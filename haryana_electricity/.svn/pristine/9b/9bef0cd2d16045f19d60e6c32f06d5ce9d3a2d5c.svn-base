<?php

session_start();
date_default_timezone_set("Asia/Kolkata");

include_once('DAO/ReportDAO.php');

//Creating users
$ReportDAO = new ReportDAO();

$disabled = "";

$last_months = date('m');
if ($_REQUEST['month'] != '') {
    $last_months = $_REQUEST['month'];
}

$year = date('Y');
if ($_REQUEST['year'] != '') {
    $year = $_REQUEST['year'];
}

if ($_SESSION['area_id'] > 0) {
    $district_id = $_SESSION['area_id'];
    $disabled = "disabled = disabled";
} else {
    $district_id = 0;
}
if (isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != '') {
    $district_id = $_REQUEST['district_id'];
}

$divisionName = $ReportDAO->getDivisionNameByID($district_id);
$monthName = date("F", mktime(0, 0, 0, $last_months, 10));

$setCounter = 0;
$setExcelName = $divisionName."_".$year."_".$monthName."_".date('d-m-Y');

function getDays() {
    $arrDaysNo = array();
    $last_months = date('m');
    if ($_REQUEST['month'] != '') {
        $last_months = $_REQUEST['month'];
    }
    $year = date('Y');
    if ($_REQUEST['year'] != '') {
        $year = $_REQUEST['year'];
    }
    $number = cal_days_in_month(CAL_GREGORIAN, $last_months, $year);
    for ($i = 1; $i <= $number; $i++) {
        $arrDaysNo[$i] = 0;
    }
    return $arrDaysNo;
}

$setMainHeader = "Summary of Monthly Complaint Report\n Division " . $divisionName . " For the Month of " . $monthName . " \n Code \t Category of Complaint\t";

$arrDaysNo = getDays();
foreach ($arrDaysNo as $key => $val) {
    $setMainHeader .= $key . "\t";
}
$setMainHeader .= "Total\t";

//For Total Complaint Register according to Day and Categorised Excel Section----------------------------
$j = 0;
$setData = '';

$setRec = $ReportDAO->getComplaintCategory();
foreach ($setRec as $key => $value) {
    $arrDaysNo = getDays();
    $complain_category_id = $value['complain_category_id'];

    $results = $ReportDAO->getComplaintNumberByDate($last_months, $year, $district_id, $complain_category_id);
    $total = 0;
    foreach ($results as $key => $result) {
        $arrDaysNo[$result['dayNo']] = $result['counted'];
        $total = $total + $result['counted'];
    }
    $setData .= $value['complain_category_id'] . "\t" . $value['Category'] . "\t";
    foreach ($arrDaysNo as $key => $val) {
        $setData .= $val . "\t";
    }
    $setData .= $total . "\n";
}

$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}


//For Total Complaint Register Excel Section----------------------------
$results = $ReportDAO->getComplaintNumberByDate($last_months, $year, $district_id, 0);
$total = 0;
foreach ($results as $key => $result) {
    $arrDaysNo[$result['dayNo']] = $result['counted'];
    $total = $total + $result['counted'];
}
$setData .= "\t Total \t";
foreach ($arrDaysNo as $key => $val) {
    $setData .= $val . "\t";
}
$setData .= $total . "\n";

//For Response Time Excel Section----------------------------
$setAttendedMainHeader = "  \t Response Time\t";

$arrDaysNo = getDays();
$setAttendedData = '';

//Get Complaint resolved within an hour
$arrDaysNo = getDays();
$total1 = 0;
$resultSql1 = $ReportDAO->getResolvedComplaintNumberByDateAndHour($last_months, $year, $district_id, 1);
foreach ($resultSql1 as $key => $result1) {
    $arrDaysNo[$result1['dayNo']] = $result1['counted'];
    $total1 = $total1 + $result1['counted'];
}
$setAttendedData .= "A \t Attended in less than 1 - hr\t";
foreach ($arrDaysNo as $key => $val) {
    $setAttendedData .= $val . "\t";
}
$setAttendedData .= $total1 . "\n";

//Get Complaint resolved within an hour
$arrDaysNo = getDays();
$total2 = 0;
$resultSql2 = $ReportDAO->getResolvedComplaintNumberByDateAndHour($last_months, $year, $district_id, 2);
foreach ($resultSql2 as $key => $result2) {
    $arrDaysNo[$result2['dayNo']] = $result2['counted'];
    $total2 = $total2 + $result2['counted'];
}
$setAttendedData .= "B \t Attended in 1 - 2 hrs\t";
foreach ($arrDaysNo as $key => $val) {
    $setAttendedData .= $val . "\t";
}
$setAttendedData .= $total2 . "\n";

//Get Complaint resolved within an hour
$arrDaysNo = getDays();
$total3 = 0;
$resultSql3 = $ReportDAO->getResolvedComplaintNumberByDateAndHour($last_months, $year, $district_id, 3);
foreach ($resultSql3 as $key => $result3) {
    $arrDaysNo[$result3['dayNo']] = $result3['counted'];
    $total3 = $total3 + $result3['counted'];
}
$setAttendedData .= "C \t Attended in 2 - 4 hrs\t";
foreach ($arrDaysNo as $key => $val) {
    $setAttendedData .= $val . "\t";
}
$setAttendedData .= $total3 . "\n";

//Get Complaint resolved within an hour
$arrDaysNo = getDays();
$total4 = 0;
$resultSql4 = $ReportDAO->getResolvedComplaintNumberByDateAndHour($last_months, $year, $district_id, 4);
foreach ($resultSql4 as $key => $result4) {
    $arrDaysNo[$result4['dayNo']] = $result4['counted'];
    $total4 = $total4 + $result4['counted'];
}
$setAttendedData .= "D \t Attended in more than 4 - hrs\t";
foreach ($arrDaysNo as $key => $val) {
    $setAttendedData .= $val . "\t";
}
$setAttendedData .= $total4 . "\n";

//Get Complaint resolved within an hour
$arrDaysNo = getDays();
$total = 0;
$resultSql = $ReportDAO->getResolvedComplaintNumberByDateAndHour($last_months, $year, $district_id, 0);
foreach ($resultSql as $key => $result) {
    $arrDaysNo[$result['dayNo']] = $result['counted'];
    $total = $total + $result['counted'];
}
$setAttendedData .= " \t Total \t";
foreach ($arrDaysNo as $key => $val) {
    $setAttendedData .= $val . "\t";
}
$setAttendedData .= $total . "\n\n\n\n";

$setAttendedData .= "\t Attended in less than 1 - hr \t" . $total1 . "\n";
$setAttendedData .= "\t Attended in 1 to 2 - hr \t" . $total2 . "\n";
$setAttendedData .= "\t Attended in 2 to 4 - hr \t" . $total3 . "\n";
$setAttendedData .= "\t Attended in more than 4 - hr \t" . $total4 . "\n";


//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader) . "\n" . $setData . "\n\n\n\n" . ucwords($setAttendedMainHeader) . "\n" . $setAttendedData . "\n";
?>