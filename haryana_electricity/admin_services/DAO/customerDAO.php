<?php

require_once "DatabaseDAO.php";

class CustomerDAO {

    function getCustomerData($info) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM hr_customer WHERE customer_id like '" . $info . "%' OR phone like '" . $info . "%'
							ORDER BY name LIMIT 0,6");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getCustomerById($cust_id) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_customer` WHERE customer_id = :cust_id");
            $database->bind(':cust_id', $cust_id);
            $result = $database->single();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

}

?>