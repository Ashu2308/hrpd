<?php

require_once "DatabaseDAO.php";

class SubdivisionDAO {

    function getAllSubdivisionByArea() {
        try {
            $database = new Database();
            $database->query("SELECT sd.*, area.area_id FROM `hr_subdivision` as sd INNER JOIN hr_area as area ON area.area_id = sd.area_id WHERE sd.area_id='" . $_SESSION['area_id'] . "' AND sd.status=1 AND area.status=1 ORDER BY sd.label ASC");
            //$database->bind(':area_id', $area_id);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
	
	function getSubdivsionByDivision($division_id) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_subdivision` WHERE area_id = :division_id AND status = '1'");
            $database->bind(':division_id', $division_id);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function checkUniqueSubdivision($subdivision_name) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_subdivision` WHERE label = :subdivision_name");
            $database->bind(':subdivision_name', $subdivision_name);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllActiveSubdivision() {
        try {
            $database = new Database();
            $database->query("SELECT sd.*, area.area_id FROM `hr_subdivision` as sd 
                            INNER JOIN hr_area as area ON area.area_id = sd.area_id
                            WHERE area.status=1 AND sd.status=1 ORDER BY sd.label ASC");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllSubdivision() {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_subdivision`");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllSubdivisionWithArea() {
        try {
            $database = new Database();

            $qry = "SELECT sd.area_id, sd.subdivision_id, sd.label as subdivision_name, area.label as area_name, sd.status FROM `hr_subdivision` as sd 
                    INNER JOIN hr_area as area ON area.area_id = sd.area_id";

            if ($_SESSION['area_id'] != 0) {
                $qry .= " AND sd.area_id = '" . $_SESSION['area_id'] . "'";
            }
            
            $qry.=" ORDER BY area_name ASC";

            $database->query($qry);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllSubdivisionAndLinemanByArea($area_id) {
        try {
            $database = new Database();
            $database->query("SELECT sd.subdivision_id, sd.label as subdivision_name, user.user_id, user.name as lineman_name, user.phone
                            FROM hr_user  as user 
                            INNER JOIN hr_subdivision as sd ON user.subdivision_id = sd.subdivision_id
                            WHERE sd.subdivision_id IN (SELECT subdivision_id from hr_subdivision WHERE area_id = :area_id) 
                            AND user.is_deactivated = 0
                            AND user.is_deleted = 0
                            AND user.role_id = 3
                            AND sd.status = 1
                            ORDER BY sd.label ASC");
            $database->bind(':area_id', $area_id);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllSubdivisionAndLineman() {
        try {
            $database = new Database();
            $database->query("SELECT sd.subdivision_id, sd.label as subdivision_name, user.user_id, user.name as lineman_name, user.phone 
                            FROM hr_user  as user 
                            INNER JOIN hr_subdivision as sd ON user.subdivision_id = sd.subdivision_id
                            WHERE user.is_deactivated = 0
                            AND user.is_deleted = 0
                            AND user.role_id = 3
                            AND sd.status = 1
                            ORDER BY sd.label ASC");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function addNewSubdivision($subdivision_name, $area_id, $status) {
        try {
            $database = new Database();
            $database->query("INSERT INTO `hr_subdivision` (`area_id`, `label`, `status`, `created_at`, `updated_at`, `updated_by`) 
                            VALUES (:area_id, :subdivision_name, :status, now(), now(), '" . $_SESSION['user_id'] . "')");

            $database->bind(':subdivision_name', $subdivision_name);
            $database->bind(':area_id', $area_id);
            $database->bind(':status', $status);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function updateSubdivision($subdivision_id, $subdivision_name, $area_id, $status) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_subdivision` SET `area_id` = :area_id, `label` = :subdivision_name, `status` = :status, `updated_at` = now(), `updated_by` = '" . $_SESSION['user_id'] . "' 
                            WHERE `subdivision_id` = :subdivision_id");

            $database->bind(':subdivision_id', $subdivision_id);
            $database->bind(':subdivision_name', $subdivision_name);
            $database->bind(':area_id', $area_id);
            $database->bind(':status', $status);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

}

?>