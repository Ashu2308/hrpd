<?php

require_once "DatabaseDAO.php";

class ReportDAO {

    function complainCloseInLessThanOneHour($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            
            $sql = "SELECT 'Complaints closed in < 1 hrs' as label, count( * ) AS value
                            FROM `hr_complain` 
                            WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)<3600 
                            AND resolve_status = '1' $condition ";
                            
            $database->query($sql);
            //echo $sql;
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
	
	function complainCloseInBetweenOneAndTwoHour($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            
            $database->query("SELECT 'Complaints closed between 1-2 hrs' as label, count( * ) AS value
							FROM `hr_complain` 
							WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=3600  
							AND  TIMESTAMPDIFF(SECOND, created_at, resolved_at)<7200 
							AND resolve_status = '1' $condition ");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
	
	function complainCloseInBetweenTwoAndThreeHour($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            
            $database->query("SELECT 'Complaints closed between 2-3 hrs' as label, count( * ) AS value
							FROM `hr_complain` 
							WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=7200  
							AND  TIMESTAMPDIFF(SECOND, created_at, resolved_at)<10800
                                                        AND YEAR(created_at) = YEAR(NOW())
							AND resolve_status = '1' $condition ");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
	
	function complainCloseInBetweenThreeAndFourHour($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            
            $database->query("SELECT 'Complaints closed between 3-4 hrs' as label, count( * ) AS value
						FROM `hr_complain` 
						WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=10800  
						AND  TIMESTAMPDIFF(SECOND, created_at, resolved_at)<14400 
						AND resolve_status = '1' $condition ");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
	
	function complainCloseInGreaterThanFourHour($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            
            $database->query("SELECT 'Complaints closed in >4 hrs' as label, count( * ) AS value
							FROM `hr_complain` 
							WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=14400 
							AND resolve_status = '1' $condition ");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    //Function for getting data for the line graph
    function totalComplaintCreated($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }

            $sql = "SELECT DATE(created_at) AS date, count(*) as value FROM hr_complain WHERE complain_id > 0 $condition GROUP BY date";
            //echo $sql;
            $database->query($sql);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    //Function for getting data for the line graph
    function highestComplaintCategory($last_months, $year, $district) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(hc.created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(hc.created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(hc.created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND hc.division_id = ".$district;
            }else{
                $condition .= "";
            }
            
            $database->query("SELECT hcc.desciption as complaint_category, count(*) as total_complaint from hr_complain as hc INNER JOIN hr_complain_category as hcc ON hc.complain_category_id = hcc.complain_category_id WHERE complain_id > 0 $condition GROUP BY hcc.complain_category_id ORDER BY total_complaint DESC LIMIT 0,5");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    //Function for getting data for the line graph
    function getComplaintCategory() {
        try {
            $database = new Database();
            $sql = "SELECT complain_category_id, desciption As Category from hr_complain_category";
            //echo $sql;
            $database->query($sql);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    //Function for getting data for the line graph
    function getComplaintNumberByCategory($last_months, $year, $district, $complain_category_id) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE complain_id > 0 $condition AND complain_category_id = ".$complain_category_id." GROUP BY complain_category_id";
            //echo $sql;
            $database->query($sql);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    //Function for getting data for the excel graph
    function getComplaintNumberByDate($last_months, $year, $district, $complain_category_id) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            if($complain_category_id>0){
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE complain_id > 0 ".$condition." AND complain_category_id = ".$complain_category_id." GROUP BY DATE(created_at)";
            }else{
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE complain_id > 0 ".$condition." GROUP BY DATE(created_at)";
            }
            //echo $sql."<br>";
            $database->query($sql);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    //Function for getting data
    function getResolvedComplaintNumberByDateAndHour($last_months, $year, $district, $time) {
        try {
            $database = new Database();
            $condition = '';
            if($last_months != ''){
                $condition .= " AND MONTH(created_at) = ".$last_months;
            }else{
                $condition .= " AND MONTH(created_at) = MONTH(NOW())";
            }
            if($year != ''){
                $condition .= " AND YEAR(created_at) = ".$year;
            }
            if($district>0){
                $condition .= " AND division_id = ".$district;
            }else{
                $condition .= "";
            }
            if($time == 1){
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)<3600 AND resolve_status = '1' AND complain_id > 0 ".$condition." GROUP BY DATE(created_at)";
            }else if($time == 2){
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=3600 AND TIMESTAMPDIFF(SECOND, created_at, resolved_at)<7200 AND resolve_status = '1' AND complain_id > 0 ".$condition." GROUP BY DATE(created_at)";
            }else if($time == 3){
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=7200 AND TIMESTAMPDIFF(SECOND, created_at, resolved_at)<14400 AND resolve_status = '1' AND complain_id > 0 ".$condition." GROUP BY DATE(created_at)";
            }else if($time == 4){
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE TIMESTAMPDIFF(SECOND, created_at, resolved_at)>=14400 AND resolve_status = '1' AND complain_id > 0 ".$condition." GROUP BY DATE(created_at)";
            }else if($time == 0){
                $sql = "SELECT DATE(created_at) AS date, DAY(created_at) AS dayNo, complain_category_id, count(*) as counted FROM hr_complain WHERE resolve_status = '1' AND complain_id > 0 " .$condition. " GROUP BY DATE(created_at)";
            }
            //echo $sql;
            $database->query($sql);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    function getDivisionNameByID($district_id) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_area` WHERE area_id = ".$district_id);
            $result = $database->single();
            $database = null;
            return $result['label'];
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    //Function for getting data for the line graph
    function totalComplaintCreatedLastDay($subdivision_id) {
        try {
            $database = new Database();

            $sql = "SELECT DATE(created_at) AS date, count(*) as value FROM hr_complain WHERE date(created_at) = date(NOW()-INTERVAL 1 DAY) AND subdivision_id=" . $subdivision_id . " GROUP BY date";
            //echo $sql;
            $database->query($sql);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    
    
    
}//end of class

?>