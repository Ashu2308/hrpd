<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require('DAO/UserDAO.php');
require('DAO/customerDAO.php');
require('DAO/ComplainDAO.php');
require('DAO/AreaDAO.php');
require('DAO/SubdivisionDAO.php');
require('DAO/ReportDAO.php');
require('SMS/SMSController.php');
require('notification/NotificationController.php');
require('common/CommonFunctions.php');
require('common/ErrorManager.php');
//require('SMS/sendsms.php');
//creating objects
$UserDAO = new UserDAO();
$CustomerDAO = new CustomerDAO();
$ComplainDAO = new ComplainDAO();
$AreaDAO = new AreaDAO();
$SubdivisionDAO = new SubdivisionDAO();
$ReportDAO = new ReportDAO();
$SMSController = new SMSController();
$NotificationController = new NotificationController();
$CommonFunctions = new CommonFunctions();
$ErrorManager = new ErrorManager();


// action start
if ($_REQUEST['action'] == 'submitLoginForm') {
    $result = $UserDAO->getUsersLogin($_POST['userinfo'], $_POST['password']);
    if (empty($result)) {
        $_SESSION['isLogin'] = 0;
        echo 'false';
    } else {
        if ($result['is_deactivated'] == 1) {
            echo 'inactive';
        } else {
            if ($result['area_id'] != 0) {
                $resultArray = $UserDAO->isAdminAreaInactive($result['area_id']);
                if (empty($resultArray)) {
                    echo 'inactive';
                } else {
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['phone'] = $result['phone'];
                    $_SESSION['username'] = $result['name'];
                    $_SESSION['role'] = $result['role_id'];
                    $_SESSION['area_id'] = $result['area_id'];
		    $_SESSION['subdivision_id'] = $result['subdivision_id'];
                    $_SESSION['isLogin'] = 1;
                    echo 'true';
                }
            } else {
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['phone'] = $result['phone'];
                $_SESSION['username'] = $result['name'];
                $_SESSION['role'] = $result['role_id'];
                $_SESSION['area_id'] = $result['area_id'];
                $_SESSION['subdivision_id'] = $result['subdivision_id'];
                $_SESSION['isLogin'] = 1;
                echo 'true';
            }
        }
    }
} elseif ($_REQUEST['action'] == 'checkSession') {
    $isLoggedIn = $CommonFunctions->isLoggedIn($_REQUEST['userIdString']);
    echo $isLoggedIn;
} elseif ($_REQUEST['action'] == 'customerAutocomplete') {
    $result = $CustomerDAO->getCustomerData($_POST["keyword"]);
    ?><ul><?php
        foreach ($result as $data) {
            ?>
            <li class="move" href='#' id="<?php echo $data["customer_id"]; ?>" onClick="selectCustomer(this);"><?php echo $data["name"]; ?></li>
        <?php } ?>
    </ul>
    <?php
} elseif ($_REQUEST['action'] == 'getSubdivision') {
    $subdivisionArray = $SubdivisionDAO->getSubdivsionByDivision($_POST["division_id"]); 
	ob_start();
	?>
	 <option value="">Select</option>
	 <?php
		foreach ($subdivisionArray as $sda) { ?>
		<option value="<?php echo $sda['subdivision_id'] ?>"><?php echo $sda['label']; ?></option> 
	<?php }
	$output = ob_get_contents();
    ob_get_clean();
    echo $output;
    
} elseif ($_REQUEST['action'] == 'deactivateUser') {
    $status = $UserDAO->getUserDeactivated($_POST['user_id']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'activateUser') {
    $status = $UserDAO->getUserActivated($_POST['user_id']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'addNewUserForm') {
	if($_POST['subdivision']=='')
	{
		$subdivision = $_POST['subdivision_super'];
	}
	else
	{
		$subdivision = $_POST['subdivision'];
	}
    $status = $UserDAO->addNewUser($_POST['name'], $_POST['phone'], $_POST['password'], $_POST['role'], $_POST['area'], $subdivision, $_SESSION['user_id']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getAllUser') {
    $result = $UserDAO->getAllUsers();
    ob_start();
    $i = 1;
    foreach ($result as $res) {
        ?>
        <tr>
            <td><?php echo $res['user_name']; ?></td>
            <td><?php echo $res['phone']; ?></td>
            <?php if ($res['role_id'] == 2) { ?>
                <td>Admin</td>
                <td><?php echo $res['area_name']." / ".$res['subdivision_name']; ?></td>
            <?php } else { ?>
                <td>Complaint Center</td>
                <td><?php echo $res['subdivision_name']; ?></td>
            <?php } ?>
            <td  style="text-align: center;margin: 0 auto;">  
                <?php if ($res['is_deactivated'] == 0) { ?>
                    <button id="deactivate" value="<?php echo $res['user_id']; ?>" class="btn btn-warning" type="button">Deactivate</button>
                <?php } else { ?>
                    <button id="delete" value="<?php echo $res['user_id']; ?>" class="btn btn-success" type="button">Activate</button>         
                <?php } ?>
                <button data-div-subdiv-id="<?php
                if ($res['role_id'] == 2) {
                    echo $res['area_id'] . '" data-subdiv_id="' . $res["subdivision_id"];
                } else {
                    echo $res['subdivision_id'];
                }
                ?>" data-user-id="<?php echo $res['user_id']; ?>" data-user-role="<?php echo $res['role_id']; ?>" data-user-name="<?php echo $res['user_name']; ?>" data-user-password="<?php echo $res['password']; ?>" type="button" class="btn btn-primary edit-user"><i class="fa fa-edit"></i> Edit</button>
            </td>
        </tr>
        <?php
        $i++;
    }
    $output = ob_get_contents();
    ob_get_clean();
    echo $output;
} elseif ($_REQUEST['action'] == 'addNewComplainCategory') {
    $status = $ComplainDAO->addNewComplainCategory($_POST['name'], $_POST['status']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getAllComplainCategory') {
    $result = $ComplainDAO->getAllComplainCategory();
    $i = 1;
    ob_start();
    foreach ($result as $res) {
        ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $res['desciption']; ?></td>
            <td><?php
                if ($res['status'] == 1) {
                    echo "Active";
                } else {
                    echo "Inactive";
                }
                ?></td>
            <td style="width: 17%;">            
                <button value="<?php echo $res['complain_category_id']; ?>" data-category-id="<?php echo $res['complain_category_id']; ?>" data-category="<?php echo $res['desciption']; ?>" data-status="<?php echo $res['status']; ?>" class="btn btn-primary edit-complain center" type="button"><i class="fa fa-edit"></i> Edit</button></td>
        </tr>

        <?php
        $i++;
    }
    $output = ob_get_contents();
    ob_get_clean();
    echo $output;
} elseif ($_REQUEST['action'] == 'getCustomerDetail') {
    $result = $CustomerDAO->getCustomerById($_POST['cust_id']);
    ob_start();
    ?>
    <h3>Customer Detail</h3>
    Name :  <?php echo $result['name']; ?><br>
    Phone : <?php echo $result['phone']; ?><br>
    Email : <?php echo $result['email']; ?>
    <?php
    $output = ob_get_contents();
    ob_get_clean();
    echo $output;
} elseif ($_REQUEST['action'] == 'editComplainCategory') {
    $status = $ComplainDAO->editComplainCategory($_POST['name'], $_POST['status'], $_POST['category-id']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'registerNewComplain') {

    try {
        //compairing auto generate complain number and manual complain number
        if ($_POST['complaint_number'] != $_POST['hidden_complaint_number']) {
            $complainNumber = $_POST['hidden_complaint_number'];
            $manualComplainNumber = $_POST['complaint_number'];
        } else {
            $complainNumber = $_POST['hidden_complaint_number'];
            $manualComplainNumber = '';
        }

        $date_split_array = explode('/', $_POST['complian_date']);
        $complain_date = $date_split_array[2] . '-' . $date_split_array[1] . '-' . $date_split_array[0];
        $complain_time = date("H:i:s", strtotime($_POST['complian_time']));
		$subdivision_id = $_SESSION['subdivision_id'];
        $complain_date_time = $complain_date . ' ' . $complain_time;
        
		if ($_POST['subdivision_lineman'] != "") {
            $subdivision_lineman = explode(',', $_POST['subdivision_lineman']);
            $lineman_id = $subdivision_lineman[1];
            $lineman_phone = $subdivision_lineman[2];
        } else {
            $lineman_id = '';
            $lineman_phone = '';
        }

        $status = $ComplainDAO->registerNewComplain($complainNumber, $manualComplainNumber, $_POST['lineman_name'], $_POST['customer_id'], $_POST['name'], $_POST['phone'], $subdivision_id, $lineman_id, $_POST['address'], $_POST['comment'], $complain_date_time);

        if ($status) {
            if (SMS == '1' && CUSTOMER_SMS == '1' && $_POST['phone'] != '') {
                $SMSController->customerComplainMessage($complainNumber, $_POST['phone']);
            }
            if (SMS == '1' && COMPLAINT_CENTER_SMS == '1' && $lineman_phone != '') {
                $SMSController->linemanComplainMessage($complainNumber, $lineman_phone, $_POST['name'], $_POST['address'], $_POST['phone']);
            }
            $userArray = $UserDAO->getUserById($lineman_id);
            $NotificationController->sendNotofication($userArray['gcm_id']);

            echo 'true';
        } else {
            echo 'false';
        }
    } catch (Exception $e) {
        ErrorManager::error_log($e);
    }
} elseif ($_REQUEST['action'] == 'editComplains') {

    try {
        $date_split_array = explode('/', $_POST['complian_date']);
        $complain_date = $date_split_array[2] . '-' . $date_split_array[1] . '-' . $date_split_array[0];
        $complain_time = date("H:i:s", strtotime($_POST['complian_time']));
        $complain_date_time = $complain_date . ' ' . $complain_time;

        $date_split_array = explode('/', $_POST['complian_date1']);
        $complain_date = $date_split_array[2] . '-' . $date_split_array[1] . '-' . $date_split_array[0];
        $complain_time = date("H:i:s", strtotime($_POST['complian_time1']));
        $create_date_time = $complain_date . ' ' . $complain_time;
		$subdivision_id = $_SESSION['subdivision_id'];
        
		if ($_POST['subdivision_lineman'] != "") {
            $subdivision_lineman = explode(',', $_POST['subdivision_lineman']);    
            $lineman_id = $subdivision_lineman[1];
            $lineman_phone = $subdivision_lineman[2];
        } else {
            $lineman_id = '';
            $lineman_phone = '';
        }

        $status = $ComplainDAO->editComplain($_POST['complain_id'], $_POST['consumer_number'], $_POST['lineman_name'], $_POST['complain_category'], $_POST['resolution_comment'], $complain_date_time, $create_date_time, $subdivision_id, $lineman_id, $_POST['customer_name'], $_POST['customer_mobile'], $_POST['customer_address'], $_POST['complaint_comment']
        );
        if ($status) {
            echo 'true';
        } else {
            echo 'false';
        }
    } catch (Exception $e) {
        ErrorManager::error_log($e);
    }
} elseif ($_REQUEST['action'] == 'resolveComplains') {

    try {
        $date_split_array = explode('/', $_POST['complian_date']);
        $complain_date = $date_split_array[2] . '-' . $date_split_array[1] . '-' . $date_split_array[0];
        $complain_time = date("H:i:s", strtotime($_POST['complian_time']));
        $complain_date_time = $complain_date . ' ' . $complain_time;

        $date_split_array = explode('/', $_POST['complian_date1']);
        $complain_date = $date_split_array[2] . '-' . $date_split_array[1] . '-' . $date_split_array[0];
        $complain_time = date("H:i:s", strtotime($_POST['complian_time1']));
        $create_date_time = $complain_date . ' ' . $complain_time;
		$subdivision_id = $_SESSION['subdivision_id'];
        
		if ($_POST['subdivision_lineman'] != "") {
            $subdivision_lineman = explode(',', $_POST['subdivision_lineman']);
            $lineman_id = $subdivision_lineman[1];
            $lineman_phone = $subdivision_lineman[2];
        } else {
            $lineman_id = '';
            $lineman_phone = '';
        }

        $status = $ComplainDAO->resolveComplain($_POST['complain_id'], $_POST['consumer_number'], $_POST['lineman_name'], $_POST['complain_category'], $_POST['resolution_comment'], $complain_date_time, $create_date_time, $subdivision_id, $lineman_id, $_POST['customer_name'], $_POST['customer_mobile'], $_POST['customer_address'], $_POST['complaint_comment']
        );
        if ($status) {
            if (SMS == '1' && CUSTOMER_SMS == '1' && $_POST['customer_mobile'] != '') {
                $SMSController->customerResolveMessage($_POST['complain_number'], $_POST['customer_mobile']);
            }
            echo 'true';
        } else {
            echo 'false';
        }
    } catch (Exception $e) {
        ErrorManager::error_log($e);
    }
} elseif ($_REQUEST['action'] == 'getAllPendingComplain') {
    try {
        $result = $ComplainDAO->getAllPendingComplain();
        // $countComplaint = sizeof($result);
        //echo $current_time = date("Y-m-d H:i:s", time());
        ob_start();

        $current_time = date("Y-m-d H:i:s", time());
        foreach ($result as $res) {
            $date = $res['complain_date'];

            //finding complaint time difference
            $to_time = strtotime($res['complain_date']);
            $from_time = strtotime($current_time);
            $time_diff = round(abs($to_time - $from_time) / 60, 2);
            // echo gettype($time_diff);exit;
            $critical_time = (int) CRITICAL_COMPLAIN_TIME;
            //--------------------------------//

            $dt = new DateTime($date);
            $finalDate = $dt->format('d/m/Y');
            $finalTime = date("H:i", strtotime($date));

            //checking for showable complaint number
            if ($res['manual_complaint_number'] != '') {
                $complaint_number = $res['manual_complaint_number'];
            } else {
                $complaint_number = $res['complain_number'];
            }

            //getting complain register time
            $complain_register_time = $CommonFunctions->time_elapsed_string($res['complain_date'], $current_time);
            ?>
            <tr>
                <td style="width:14%"><?php echo $complaint_number; ?></td>                                        
                <td style="width:14%"><?php echo $res['customer_name']; ?></td>
                <td style="width:14%"><?php
                    if ($res['customer_mobile'] == '') {
                        echo 'N/A';
                    } else {
                        echo $res['customer_mobile'];
                    }
                    ?></td>
                <td style="width:14%"><?php
                    if ($res['assignee_name'] == '') {
                        echo 'N/A';
                    } else {
                        echo $res['assignee_name'];
                    }
                    ?></td>
                <td style="width:14%"><?php
                    if ($res['lineman_number'] == '') {
                        echo 'N/A';
                        if ($res['lineman_name'] == '') {
                            echo ' (N/A)';
                        } else {
                            echo ' (' . $res['lineman_name'] . ')';
                        }
                    } else {
                        echo $res['lineman_number'];
                        if ($res['lineman_name'] == '') {
                            echo ' (N/A)';
                        } else {
                            echo ' (' . $res['lineman_name'] . ')';
                        }
                    }
                    ?></td>
                <td style="width:14%"><?php
                    if ($res['subdivision_name'] == '') {
                        echo 'N/A';
                    } else {
                        echo $res['subdivision_name'];
                    }
                    ?></td>

                <td <?php if ($time_diff > $critical_time) { ?> class="urgent-comp" <?php } ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $finalDate . ', ' . $finalTime; ?>" style="width:14%;"><?php echo $complain_register_time; ?></td>
                <td style="width: 10%;">            
                    <button value="<?php echo $res['complain_id']; ?>" data-complain-category="<?php echo $res['complain_category_id']; ?>" data-lineman-name="<?php echo $res['lineman_name']; ?>" data-complaint-date="<?php echo $finalDate ?>" data-complaint-time="<?php echo $finalTime ?>" data-subdivision-id="<?php echo $res['subdivision_id']; ?>" data-assignee-id="<?php echo $res['assignee_id']; ?>" data-lineman-number="<?php echo $res['lineman_number']; ?>" data-lineman-name="<?php echo $res['assignee_name']; ?>" data-customer-address="<?php echo $res['customer_address']; ?>" data-subdivision-name="<?php echo $res['subdivision_name']; ?>" data-complain-id="<?php echo $res['complain_id']; ?>"  data-complain-number="<?php echo $complaint_number; ?>" data-customer-id="<?php echo $res['customer_id']; ?>" data-customer-name="<?php echo $res['customer_name']; ?>" data-customer-mobile="<?php echo $res['customer_mobile']; ?>" data-resolution-comment="<?php echo $res['resolution_comment']; ?>"  data-complaint-comment="<?php echo $res['complaint_comment']; ?>" class="btn btn-primary edit-complain center" type="button"><i class="fa fa-edit"></i> Edit</button>
                </td>
            </tr>
            <?php
        }

        $output = ob_get_contents();
        ob_get_clean();
        echo $output;
    } catch (Exception $e) {
        ErrorManager::error_log($e);
    }
} elseif ($_REQUEST['action'] == 'checkUniquePhone') {
    $result = $UserDAO->checkUniquePhone($_POST['phone']);
    if (empty($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'checkUniqueArea') {
    $result = $AreaDAO->checkUniqueArea($_POST['area']);
    if (empty($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'checkUniqueDivisionCode') {
    $result = $AreaDAO->checkUniqueDivisionCode($_POST['division_code']);
    if (empty($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'checkUniqueSubdivision') {
    $result = $SubdivisionDAO->checkUniqueSubdivision($_POST['subdivision']);
    if (empty($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'checkUniqueComplainCategory') {
    $result = $ComplainDAO->checkUniqueComplainCategory($_POST['complain_cat']);
    if (empty($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'addNewArea') {
    $status = $AreaDAO->addNewArea($_POST['area_name'], $_POST['division_code'], $_POST['status']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getAllArea') {
    $areaArray = $AreaDAO->getAllArea();
    ob_start();
    foreach ($areaArray as $res) {
        ?>
        <tr>
            <td><?php echo $res['label']; ?></td>
            <td><?php echo $res['division_code']; ?></td>
            <?php if ($res['status'] == 1) { ?>
                <td>Active</td>
            <?php } else { ?>
                <td>Inactive</td>
            <?php } ?>
            <td style="width: 17%;">
                <button value="<?php echo $res['area_id']; ?>"  data-division-code="<?php echo $res['division_code']; ?>" data-area-id="<?php echo $res['area_id']; ?>" data-area-name="<?php echo $res['label']; ?>" data-status="<?php echo $res['status']; ?>" class="btn btn-primary edit-area center" type="button"><i class="fa fa-edit"></i> Edit</button>
            </td>
        </tr>
        <?php
    }

    $output = ob_get_contents();
    ob_get_clean();
    echo $output;
} elseif ($_REQUEST['action'] == 'addNewSubdivision') {
    $status = $SubdivisionDAO->addNewSubdivision($_POST['subdivision_name'], $_POST['area_id'], $_POST['status']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getAllSubdivisionWithArea') {
    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionWithArea();
    ob_start();
    foreach ($subdivisionArray as $res) {
        ?>
        <tr>
            <td><?php echo $res['subdivision_name']; ?></td>
            <td><?php echo $res['area_name']; ?></td>
            <?php if ($res['status'] == 1) { ?>
                <td>Active</td>
            <?php } else { ?>
                <td>Inactive</td>
            <?php } ?>
            <td style="width: 17%;">
                <button value="<?php echo $res['subdivision_id']; ?>" data-subdivision-id="<?php echo $res['subdivision_id']; ?>" data-area-id="<?php echo $res['area_id']; ?>" data-subdivision-name="<?php echo $res['subdivision_name']; ?>" data-status="<?php echo $res['status']; ?>" class="btn btn-primary edit-subdivision center" type="button"><i class="fa fa-edit"></i> Edit</button></td>
        </td>
        </tr>
        <?php
    }
    $output = ob_get_contents();
    ob_get_clean();
    echo $output;
} elseif ($_REQUEST['action'] == 'editSubdivision') {
    $status = $SubdivisionDAO->updateSubdivision($_POST['subdivision_id'], $_POST['subdivision_name'], $_POST['area_id'], $_POST['status']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'editArea') {
    $status = $AreaDAO->updateArea($_POST['area_id'], $_POST['area_name'], $_POST['division_code'], $_POST['status']);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'changePassword') {
    $is_exit = $UserDAO->checkPassword($_POST['old_password']);
    if (empty($is_exit)) {
        echo 'notmatch';
    } else {
        $status = $UserDAO->changePassword($_POST['new_password']);
        if ($status) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
} elseif ($_REQUEST['action'] == 'checkUniqueComplaintNumber') {
    $complaint_date = $_POST['complaint_date'];
    $complaint_number = substr($_POST['complaint_number'], -4);
    $division_code = substr($_POST['complaint_number'], 0, 3);
    $data = $ComplainDAO->checkComplaintNumber($complaint_number, $division_code, $complaint_date);
    if (empty($data)) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getCurrentComplaintNumber') {
    $data = $CommonFunctions->generateComplaintNumber();
    if ($data != '') {
        echo $data;
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getComplaintNumberByDate') {
    $complaint_date = $_POST['complaint_date'];
    $data = $CommonFunctions->generateComplaintNumberBydate($complaint_date);
    if ($data != '') {
        echo $data;
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'reopenComplains') {
    $complaint_id = $_POST['complain_id'];
    $status = $ComplainDAO->reopenComplaint($complaint_id);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getAllResolveComplain') {
    try {
        $result = $ComplainDAO->getAllResolveComplain();
        ob_start();
        $i = 1;
        foreach ($result as $res) {
            //Converting complain date

            $compDate = $res['complain_date'];
            $dt = new DateTime($compDate);
            $complainDate = $dt->format('d M Y');
            $complainTime = date("H:i", strtotime($compDate));

            //converting resolve date

            $resDate = $res['resolve_date'];
            $dt1 = new DateTime($resDate);
            $resolveDate = $dt1->format('d M Y');
            $resolveTime = date("H:i", strtotime($resDate));

            if ($res['manual_complaint_number'] != '') {
                $complaint_number = $res['manual_complaint_number'];
            } else {
                $complaint_number = $res['complain_number'];
            }
            ?>
            <tr style="cursor: pointer;" class="view-resolve-detail" data-assigned-person="<?php echo $res['lineman_name']; ?>" data-consumer-number="<?php echo $res['customer_id']; ?>" data-lineman-number="<?php echo $res['lineman_number']; ?>" data-lineman-name="<?php echo $res['assignee_name']; ?>" data-customer-address="<?php echo $res['customer_address']; ?>" data-subdivision-name="<?php echo $res['subdivision_name']; ?>" data-complain-id="<?php echo $res['complain_id']; ?>"  data-complain-number="<?php echo $complaint_number; ?>" data-customer-id="<?php echo $res['customer_id']; ?>" data-customer-name="<?php echo $res['customer_name']; ?>" data-customer-mobile="<?php echo $res['customer_mobile']; ?>" data-complaint-comment="<?php echo $res['complaint_comment']; ?>" data-resolution-comment="<?php echo $res['resolution_comment']; ?>" data-complain-category="<?php echo $res['description']; ?>">
                <td style="width:14%"><?php echo $complaint_number; ?></td>
                <td style="width:14%"><?php echo $res['customer_name']; ?></td>
                <td style="width:14%"><?php
                    if ($res['customer_mobile'] == '') {
                        echo 'N/A';
                    } else {
                        echo $res['customer_mobile'];
                    }
                    ?>
                </td>
                <td style="width:14%"><?php echo $res['description']; ?></td>
                <td style="width:14%"><?php
                    if ($res['assignee_name'] == '') {
                        echo 'N/A';
                    } else {
                        echo $res['assignee_name'];
                    }
                    ?></td>
                <td style="width:14%"><?php echo $complainDate . ', ' . $complainTime; ?></td>
                <td style="width:14%"><?php echo $resolveDate . ', ' . $resolveTime; ?></td>
            </tr>
            <?php
            $i++;
        }
        $output = ob_get_contents();
        ob_get_clean();
        echo $output;
    } catch (Exception $e) {
        ErrorManager::error_log($e);
    }
} elseif ($_REQUEST['action'] == 'editUser') {
    $user_id = $_POST['user_id'];
    $role_id = $_POST['role_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    if ($role_id == '2') {
        $area_id = $_POST['division'];
        $subdivision_id = $_POST['subdivision'];
    } else {
        $subdivision_id = $_POST['subdivision'];
        $area_id = 0;
    }

    $status = $UserDAO->editUser($user_id, $role_id, $name, $password, $area_id, $subdivision_id);
    if ($status) {
        echo 'true';
    } else {
        echo 'false';
    }
} elseif ($_REQUEST['action'] == 'getCountPendingComplain') {
    $result = $ComplainDAO->getAllPendingComplain();
    $countComplaint = sizeof($result);
    echo $countComplaint;
} elseif ($_REQUEST['action'] == 'getCountResolvedComplain') {
    $result = $ComplainDAO->getAllResolveComplain();
    $countComplaint = sizeof($result);
    echo $countComplaint;
}elseif ($_REQUEST['action'] == 'refresh-graph') {
    $last_months = $_GET['months'];
    $year = $_GET['year'];
    $district = $_GET['district'];
    $data_1 = $ReportDAO->complainCloseInLessThanOneHour($last_months, $year, $district);
    $data_1_2 = $ReportDAO->complainCloseInBetweenOneAndTwoHour($last_months, $year, $district);
    $data_2_3 = $ReportDAO->complainCloseInBetweenTwoAndThreeHour($last_months, $year, $district);
    $data_3_4 = $ReportDAO->complainCloseInBetweenThreeAndFourHour($last_months, $year, $district);
    $data_4 = $ReportDAO->complainCloseInGreaterThanFourHour($last_months, $year, $district);
    $report_data = array_merge($data_1, $data_1_2, $data_2_3, $data_3_4, $data_4);
    echo json_encode($report_data);
}elseif ($_REQUEST['action'] == 'refresh-line-graph') {
    $last_months = $_GET['months'];
    $year = $_GET['year'];
    $district = $_GET['district'];
    $report_data = $ReportDAO->totalComplaintCreated($last_months, $year, $district);
    echo json_encode($report_data);
}elseif ($_REQUEST['action'] == 'refresh-bar-graph') {
    $last_months = $_GET['months'];
    $year = $_GET['year'];
    $district = $_GET['district'];
    $report_data = $ReportDAO->highestComplaintCategory($last_months, $year, $district);
    echo json_encode($report_data);
}elseif ($_REQUEST['action'] == 'refresh-excel') {
    $last_months = $_GET['months'];
    $year = $_GET['year'];
    $district = $_GET['district_id'];
    $setRec = $ReportDAO->getComplaintCategory();
    $response='';
    foreach ($setRec as $key => $val) {
        $complain_category_id = $val['complain_category_id'];
        $total = 0;

        $results = $ReportDAO->getComplaintNumberByCategory($last_months, $year, $district, $complain_category_id);
        foreach ($results as $key => $result) {
            $total = $total + $result['counted'];
        }
        $response .= '<tr><td>' . $complain_category_id . '</td><td>'. $val['Category'] . ' </td><td>' . $total . '</td></tr>';
    }
    echo $response;
}
?>
