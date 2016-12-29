<?php

require_once "DAO/AreaDAO.php";
require_once "DAO/ComplainDAO.php";

class CommonFunctions {

    function isLoggedIn($userIdString) {
        // return isset($_SESSION['isLogin'])?1:0;
        $status = 0;
        if ($_SESSION['isLogin'] == '1') {
            if ($userIdString == base64_encode($_SESSION['user_id'])) {
                $status = 1;
            }
        }
        return $status;
    }

    function generateComplaintNumberBydate($complaint_date) {
        $AreaDAO = new AreaDAO();
        $ComplainDAO = new ComplainDAO();

        //getting division code
        $division_code_array = $AreaDAO->getDivisionCodeByAreaId();
        $division_code = $division_code_array['division_code'];

        //getting max counter array
        $complain_counter_array = $ComplainDAO->getComplaintCounterByDate($division_code, $complaint_date);
        if (empty($complain_counter_array)) {
            $complain_counter = '0001';
        } else {
            $complain_counter = $complain_counter_array['complain_number'];
            $complain_counter = $complain_counter + 1;
        }
        // getting current date array
        $date_array = explode('/', $complaint_date);
        $day = $date_array['0'];
        $month = $date_array['1'];

        //creating complaint number
        $generated_complain_number = $division_code . '' . str_pad($day, 2, '0', STR_PAD_LEFT) . '' . str_pad($month, 2, '0', STR_PAD_LEFT) . '' . str_pad($complain_counter, 4, '0', STR_PAD_LEFT);
        return $generated_complain_number;
    }

    function generateComplaintNumber() {
        $AreaDAO = new AreaDAO();
        $ComplainDAO = new ComplainDAO();

        //getting division code
        $division_code_array = $AreaDAO->getDivisionCodeByAreaId();
        $division_code = $division_code_array['division_code'];

        //getting max counter array
        $complain_counter_array = $ComplainDAO->getComplaintCounter($division_code);
        if (empty($complain_counter_array)) {
            $complain_counter = '0001';
        } else {
            $complain_counter = $complain_counter_array['complain_number'];
            $complain_counter = $complain_counter + 1;
        }
        // getting current date array
        $date_array = getdate();
        $day = $date_array['mday'];
        $month = $date_array['mon'];

        //creating complaint number
        $generated_complain_number = $division_code . '' . str_pad($day, 2, '0', STR_PAD_LEFT) . '' . str_pad($month, 2, '0', STR_PAD_LEFT) . '' . str_pad($complain_counter, 4, '0', STR_PAD_LEFT);
        return $generated_complain_number;
    }

    function time_elapsed_string($ptime, $current_time) {

        $estimate_time = strtotime($current_time) - strtotime($ptime);

        if ($estimate_time < 1) {
            return 'Just Now';
        }

        $condition = array(
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($condition as $secs => $str) {
            $d = $estimate_time / $secs;

            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
}

//end of class
?>