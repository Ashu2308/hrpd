<?php

require_once "DatabaseDAO.php";

class ComplainDAO {

    function getAllComplainCategory() {
        try {
            $database = new Database();
            $database->query("SELECT * FROM hr_complain_category");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function checkUniqueComplainCategory($complain_cat) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM hr_complain_category WHERE desciption = :complain_cat");

            $database->bind(':complain_cat', $complain_cat);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function getAllActiveComplainCategory() {
        try {
            $database = new Database();
            $database->query("SELECT * FROM hr_complain_category WHERE status = 1");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
             ErrorManager::error_log($e);
        }
    }

    function getAllPendingComplain() {
        try {
            $database = new Database();
            $qry = "SELECT comp.lineman_name, comp.complain_id, comp.complain_category_id, comp.manual_complaint_number, comp.assignee_id, comp.subdivision_id, comp.complain_number, comp.complaint_comment, comp.resolution_comment, comp.customer_id,  comp.customer_name, comp.customer_mobile as customer_mobile, comp.customer_address, comp.created_at as complain_date, user.name as assignee_name, user.phone as lineman_number, sd.label as subdivision_name
                            FROM hr_complain as comp 
                            LEFT JOIN hr_user as user ON user.user_id=comp.assignee_id 
                            LEFT JOIN hr_subdivision as sd ON sd.subdivision_id = comp.subdivision_id 
                            WHERE (resolve_status='0' OR resolve_status='2')";
            if ($_SESSION['area_id'] != 0) {
                $qry .= " AND comp.division_id = '" . $_SESSION['area_id'] . "'";
            }
            
            if ($_SESSION['subdivision_id'] != 0) {
                $qry .= " AND comp.subdivision_id = '" . $_SESSION['subdivision_id'] . "'";
            }

            $qry .= " ORDER BY comp.created_at ASC";

            $database->query($qry);
            //$database->bind(':area_id', $area_id);

            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
             ErrorManager::error_log($e);
        }
    }

    function getAllResolveComplain() {

        try {
            $database = new Database();

            $qry = "SELECT comp.customer_id, comp.lineman_name, comp.complain_id, comp.manual_complaint_number, comp.complain_number, comp.complaint_comment, comp.resolution_comment, comp.customer_name, comp.customer_mobile as customer_mobile, comp.customer_address, comp.created_at as complain_date, comp.resolved_at as resolve_date, user.name as assignee_name, user.phone as lineman_number, cc.desciption as description, sd.label as subdivision_name
                    FROM hr_complain as comp 
                    LEFT JOIN hr_user as user ON user.user_id=comp.assignee_id 
                    INNER JOIN hr_complain_category as cc ON cc.complain_category_id=comp.complain_category_id 
                    LEFT JOIN hr_subdivision as sd ON sd.subdivision_id = comp.subdivision_id 
                    WHERE resolve_status='1'";

            if ($_SESSION['area_id'] != 0) {
                $qry .= " AND comp.division_id = '" . $_SESSION['area_id'] . "'";
            }
	    if ($_SESSION['subdivision_id'] != 0) {
                $qry .= " AND comp.subdivision_id = '" . $_SESSION['subdivision_id'] . "'";
            }
            if ($_SESSION['filter_value'] == 'today') {
           // $qry .= " AND resolved_at >= NOW() - INTERVAL 1 DAY ORDER BY resolved_at DESC";
                $qry .= " AND date(resolved_at) = date(NOW()) ORDER BY resolved_at DESC";
            }
            elseif ($_SESSION['filter_value'] == 'yesterday') {
            //$qry .= " AND resolved_at >= NOW() - 1 ORDER BY resolved_at DESC";
                $qry .= " AND date(resolved_at) = date(NOW()-INTERVAL 1 DAY) ORDER BY resolved_at DESC";
            }
            elseif ($_SESSION['filter_value'] == 'week') {
           //$qry .= " AND resolved_at >= NOW() - INTERVAL 1 WEEK ORDER BY resolved_at DESC";
                $qry .= " AND resolved_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY resolved_at DESC";
            }
            elseif ($_SESSION['filter_value'] == 'month') {
           // $qry .= " AND resolved_at >= NOW() - INTERVAL 1 MONTH ORDER BY resolved_at DESC";
                $qry .= " AND resolved_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY resolved_at DESC";
            }
            
            $database->query($qry);
            // $database->bind(':area_id', $area_id);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function addNewComplainCategory($name, $status) {
        try {
            $database = new Database();
            $database->query("INSERT INTO `hr_complain_category` (`desciption`, `status`, `created_at`, `updated_at`, `updated_by`) VALUES (:name, :status, now(), now(), '" . $_SESSION['user_id'] . "')");

            $database->bind(':status', $status);
            $database->bind(':name', $name);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function editComplainCategory($name, $status, $category_id) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_complain_category` SET `desciption` = :name, `status` = :status, `desciption` = :name, `updated_at` = now(), updated_by = '" . $_SESSION['user_id'] . "'  WHERE `complain_category_id` = :category_id");
            $database->bind(':name', $name);
            $database->bind(':status', $status);
            $database->bind(':category_id', $category_id);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function registerNewComplain($complainNumber, $manualComplainNumber, $lineman_name, $customer_id, $customer_name, $customer_mobile, $subdivision_id, $assignee_id, $customer_address, $complaint_comment, $complain_date_time) {
        try {
            $database = new Database();
            $date = date('Y-m-d h:i:s');
            $database->query("INSERT INTO `hr_complain` (`complain_number`, `manual_complaint_number`, `lineman_name`, `division_id`, `subdivision_id`, `assignee_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `customer_id`, `customer_name`, `customer_mobile`, `customer_address`, `complaint_comment`) 
                            VALUES (:complainNumber, :manualComplainNumber, :lineman_name, '" . $_SESSION['area_id'] . "', :subdivision_id, :assignee_id, '" . $_SESSION['user_id'] . "', '" . $_SESSION['user_id'] . "', '" . $complain_date_time . "', now(), :customer_id, :customer_name, :customer_mobile, :customer_address, :complaint_comment)");

            $database->bind(':complainNumber', $complainNumber);
            $database->bind(':manualComplainNumber', $manualComplainNumber);
            $database->bind(':lineman_name', $lineman_name);
            $database->bind(':customer_id', $customer_id);
            $database->bind(':customer_name', $customer_name);
            $database->bind(':customer_mobile', $customer_mobile);
            $database->bind(':customer_address', $customer_address);
            $database->bind(':complaint_comment', $complaint_comment);
            $database->bind(':subdivision_id', $subdivision_id);
            $database->bind(':assignee_id', $assignee_id);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function editComplain($complain_id, $consumer_number, $lineman_name, $complain_category, $resolution_comment, $complain_date_time, $create_date_time, $subdivision_id, $lineman_id, $customer_name, $customer_mobile, $customer_address, $complaint_comment) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_complain` 
                            SET `lineman_name` = :lineman_name, customer_id = :consumer_number, `complain_category_id` = :complain_category, resolution_comment = :resolution_comment, resolved_by = '" . $_SESSION['user_id'] . "', updated_by = '" . $_SESSION['user_id'] . "', updated_at= now(), resolved_at='" . $complain_date_time . "', created_at = '" . $create_date_time . "',  subdivision_id = :subdivision_id,
                            assignee_id = :lineman_id, customer_name = :customer_name, customer_mobile = :customer_mobile, customer_address = :customer_address,  complaint_comment = :complaint_comment
                            WHERE `complain_id` = :complain_id");
            $database->bind(':complain_id', $complain_id);
            $database->bind(':lineman_name', $lineman_name);
            $database->bind(':consumer_number', $consumer_number);
            $database->bind(':complain_category', $complain_category);
            $database->bind(':resolution_comment', $resolution_comment);
            $database->bind(':subdivision_id', $subdivision_id);
            $database->bind(':lineman_id', $lineman_id);
            $database->bind(':customer_name', $customer_name);
            $database->bind(':customer_mobile', $customer_mobile);
            $database->bind(':customer_address', $customer_address);
            $database->bind(':complaint_comment', $complaint_comment);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
             ErrorManager::error_log($e);
        }
    }

    function resolveComplain($complain_id, $consumer_number, $lineman_name, $complain_category, $resolution_comment, $complain_date_time, $create_date_time, $subdivision_id, $lineman_id, $customer_name, $customer_mobile, $customer_address, $complaint_comment) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_complain` 
                            SET `lineman_name` = :lineman_name, customer_id = :consumer_number, `complain_category_id` = :complain_category, resolve_status = '1', resolution_comment = :resolution_comment, resolved_by = '" . $_SESSION['user_id'] . "', updated_by = '" . $_SESSION['user_id'] . "', updated_at= now(), resolved_at='" . $complain_date_time . "', created_at = '" . $create_date_time . "',  subdivision_id = :subdivision_id,
                            assignee_id = :lineman_id, customer_name = :customer_name, customer_mobile = :customer_mobile, customer_address = :customer_address,  complaint_comment = :complaint_comment
                            WHERE `complain_id` = :complain_id");
            $database->bind(':complain_id', $complain_id);
            $database->bind(':consumer_number', $consumer_number);
            $database->bind(':lineman_name', $lineman_name);
            $database->bind(':complain_category', $complain_category);
            $database->bind(':resolution_comment', $resolution_comment);
            $database->bind(':subdivision_id', $subdivision_id);
            $database->bind(':lineman_id', $lineman_id);
            $database->bind(':customer_name', $customer_name);
            $database->bind(':customer_mobile', $customer_mobile);
            $database->bind(':customer_address', $customer_address);
            $database->bind(':complaint_comment', $complaint_comment);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
           ErrorManager::error_log($e);
        }
    }

    function generateComplainNumber() {
        $time = time();
        $generatedNumber = 'CMP' . $time;
        $result = $this->checkComplainNumber($generatedNumber);
        if (empty($result)) {
            return $generatedNumber;
        } else {
            $this->generateComplainNumber();
        }
    }

    function checkComplainNumber($generatedNumber) {
        try {
            $database = new Database();
            $database->query("SELECT complain_number FROM `hr_complain` WHERE complain_number=:generatedNumber");
            $database->bind(':generatedNumber', $generatedNumber);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
           ErrorManager::error_log($e);
        }
    }

    function getComplaintCounter($division_code) {
        $today_date = date("Y-m-d");
        try {
            $database = new Database();
            $database->query("SELECT max(substring(complain_number,-4)) as complain_number FROM hr_complain WHERE substring(complain_number, 1, 3) = :division_code AND date(created_at)='" . $today_date . "'");
            $database->bind(':division_code', $division_code);
            $result = $database->single();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function getComplaintCounterByDate($division_code, $complaint_date) {
        $dateArray = explode('/', $complaint_date);
        $complaint_date = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        $cdate = strtotime($complaint_date);
        $newformat_comp_date = date('Y-m-d', $cdate);
        try {
            $database = new Database();
            $database->query("SELECT max(substring(complain_number,-4)) as complain_number FROM hr_complain WHERE substring(complain_number, 1, 3) = :division_code AND date(created_at)='" . $newformat_comp_date . "'");
            $database->bind(':division_code', $division_code);
            $result = $database->single();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function checkComplaintNumber($complain_number, $division_code, $complaint_date) {
        //$today_date = date("Y-m-d");
        $dateArray = explode('/', $complaint_date);
        $complaint_date = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        $cdate = strtotime($complaint_date);
        $newformat_comp_date = date('Y-m-d', $cdate);
        try {
            $database = new Database();
            $database->query("SELECT complain_number FROM hr_complain WHERE substring(complain_number, 1, 3) = :division_code AND substring(complain_number,-4) = :complain_number AND date(created_at)='" . $newformat_comp_date . "'");
            $database->bind(':complain_number', $complain_number);
            $database->bind(':division_code', $division_code);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            ErrorManager::error_log($e);
        }
    }

    function reopenComplaint($complaint_id) {
        try {
            $database = new Database();
            $database->query("UPDATE hr_complain SET resolve_status = '2', reopen_counter = (reopen_counter+1) WHERE complain_id = :complaint_id");
            $database->bind(':complaint_id', $complaint_id);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
             ErrorManager::error_log($e);
        }
    }

}

?>
