<?php
//error_reporting(0);
include_once('DAO/ReportDAO.php');
include_once('DAO/AreaDAO.php');
include_once('DAO/SubdivisionDAO.php');

//Creating objects
$ReportDAO = new ReportDAO();
$AreaDAO = new AreaDAO();
$SubdivisionDAO = new SubdivisionDAO();

$district_ids = $AreaDAO->getAllArea();

foreach ($district_ids as $key => $district_id) {
    //$message = '';
    $subdivisions = $SubdivisionDAO->getSubdivsionByDivision($district_id['area_id']);
    
    $to = $district_id['manager_email'];
    $subject = 'Daily Complaint Report for '.$district_id['label'] .", ". date('d.m.Y',strtotime("-1 days")); ;

    $headers = "From: rohit.gupta@advaitsolutions.in\r\n";
    $headers .= "Reply-To: rohit.gupta@advaitsolutions.in\r\n";
    $headers .= "CC: rohit.gupta@advaitsolutions.in\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $message = '<html><body>';
    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    foreach ($subdivisions as $key => $subdivision) {
        $report_data = $ReportDAO->totalComplaintCreatedLastDay($subdivision['subdivision_id']);

        $complaintCount = $report_data[0]['value'];
        if ($report_data[0]['value'] == '') {
            $complaintCount = 0;
        }
        $subdivisionName = $subdivision['label'];

        $message .= "<tr style='background: #eee;'><td><strong>Sub Division Name:</strong> </td><td>" . $subdivisionName . "</td></tr>";
        $message .= "<tr><td><strong>Total Complaints:</strong> </td><td>" . $complaintCount . "</td></tr>";

    }
    $message .= "</table>";
    $message .= "</body></html>";
    mail($to, $subject, $message, $headers);
    
}
?>