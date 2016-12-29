<?php

require_once "DatabaseDAO.php";

class AreaDAO {

    function getAllArea() {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_area` ORDER BY label ASC");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getDivisionCodeByAreaId() {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_area` WHERE area_id = '" . $_SESSION['area_id'] . "'");
            $result = $database->single();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllActiveArea() {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_area` WHERE status=1");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function addNewArea($area_name, $division_code, $status) {
        try {
            $database = new Database();
            $database->query("INSERT INTO `hr_area` (`label`, `division_code`, `status`, `created_at`, `updated_at`) VALUES (:area_name, :division_code, :status, now(), now())");
            $database->bind(':area_name', $area_name);
            $database->bind(':status', $status);
            $database->bind(':division_code', $division_code);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function updateArea($area_id, $area_name, $division_code, $status) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_area` SET `label` = :area_name, `division_code` = :division_code, `status` = :status, `updated_at` = now()
                            WHERE  `area_id` = :area_id");

            $database->bind(':area_id', $area_id);
            $database->bind(':area_name', $area_name);
            $database->bind(':division_code', $division_code);
            $database->bind(':status', $status);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function checkUniqueArea($area_name) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_area` WHERE label = :area_name");

            $database->bind(':area_name', $area_name);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function checkUniqueDivisionCode($division_code) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_area` WHERE division_code = :division_code");

            $database->bind(':division_code', $division_code);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

}

?>