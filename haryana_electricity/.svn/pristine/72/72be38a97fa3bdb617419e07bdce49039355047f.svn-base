<?php

require_once "DatabaseDAO.php";

class UserDAO {
    /* private $database = null;

      function __construct(){
      $database = new Database();
      } */

    function getUsersLogin($userinfo, $password) {
        try {
            $database = new Database();
            $database->query("select * from  hr_user where ( phone = :userinfo) AND password= :password AND (role_id=1 OR role_id=2)");
            $database->bind(':userinfo', $userinfo);
            $database->bind(':password', md5($password));
            $result = $database->single();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllUsers() {
        try {
            $database = new Database();

//            $qry = "SELECT user_id, role_id, user.name as user_name, user.phone, user.email_id, user.is_deactivated, area.label as area_name, subdivision.label as subdivision_name, subdivision.subdivision_id
//            FROM hr_subdivision as subdivision
//            INNER JOIN hr_user as user ON user.subdivision_id = subdivision.subdivision_id
//            INNER JOIN hr_area as area ON area.area_id = subdivision.area_id
//            WHERE role_id > '".$_SESSION['role']."'";
//            
//            if($_SESSION['area_id']!=0)
//            {
//                $qry .= " AND subdivision.area_id = '".$_SESSION['area_id']."'";
//            }

            $qry = "SELECT user_id, user.area_id, user.subdivision_id, role_id, user.name as user_name, user.phone, user.email_id, user.password, user.is_deactivated, area.label as area_name, subdivision.label as subdivision_name
            FROM hr_user as user
            LEFT JOIN hr_subdivision as subdivision ON user.subdivision_id = subdivision.subdivision_id
            LEFT JOIN hr_area as area ON area.area_id = user.area_id
            WHERE role_id > '1'";

            if ($_SESSION['area_id'] != 0) {
                $qry .= " AND subdivision.area_id = '" . $_SESSION['area_id'] . "'";
            }
            $qry.=" ORDER BY user_name ASC";

            $database->query($qry);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getUserDeactivated($user_id) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_user` SET `is_deactivated` = '1', updated_at = now(), updated_by = '" . $_SESSION['user_id'] . "' WHERE `user_id` = :user_id");
            $database->bind(':user_id', $user_id);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getUserActivated($user_id) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_user` SET `is_deactivated` = '0', updated_at = now(), updated_by = '" . $_SESSION['user_id'] . "' WHERE `user_id` = :user_id");
            $database->bind(':user_id', $user_id);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getUserDeleted($user_id) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_user` SET `is_deleted` = '1' WHERE `user_id` = :user_id");
            $database->bind(':user_id', $user_id);
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getUserById($user_id) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM hr_user WHERE `user_id` = :user_id");
            $database->bind(':user_id', $user_id);
            $result = $database->single();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function addNewUser($name, $phone, $password, $role, $area, $subdivision, $updated_by) {
        try {

            $database = new Database();
            $database->query("INSERT INTO `hr_user` (`area_id`, `subdivision_id`, `name`, `phone`, `password`, `role_id`, `created_at`, `updated_at`, `updated_by`) VALUES (:area, :subdivision, :name, :phone, :password, :role, now(), now(), :updated_by)");
            $database->bind(':name', $name);
            $database->bind(':role', $role);
            $database->bind(':phone', $phone);
            $database->bind(':password', md5($password));
            $database->bind(':area', $area);
            $database->bind(':subdivision', $subdivision);
            $database->bind(':updated_by', $updated_by);

            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function getAllLineman() {
        try {
            $database = new Database();
            $database->query("SELECT user_id, area_id, subdivision_id, name, phone FROM hr_user WHERE `role_id` = 3");
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function checkUniquePhone($phone) {
        try {
            $database = new Database();
            $database->query("SELECT phone FROM `hr_user` WHERE phone=:phone");
            $database->bind(':phone', $phone);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function checkPassword($old_password) {
        try {
            $database = new Database();
            $database->query("SELECT * FROM `hr_user` WHERE password = :old_password AND user_id = '" . $_SESSION['user_id'] . "'");
            $database->bind(':old_password', md5($old_password));
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function changePassword($new_password) {
        try {
            $database = new Database();
            $database->query("UPDATE `hr_user` SET `password` = :new_password WHERE `user_id` = '" . $_SESSION['user_id'] . "'");
            $database->bind(':new_password', md5($new_password));
            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function isAdminAreaInactive($area_id) {
        try {
            $database = new Database();
            $database->query("SELECT * from hr_area WHERE area_id = :area_id AND status = '1'");

            $database->bind(':area_id', $area_id);
            $result = $database->resultset();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function editUser($user_id, $role_id, $name, $password, $area_id, $subdivision_id) {
        try {
            $arr_user = $this->checkPasswordEditUser($user_id, $password);
            if (empty($arr_user)) {
                $isChangePass = 1;
            } else {
                $isChangePass = 0;
            }
            $qry = "UPDATE hr_user SET name = :name, area_id = :area_id, subdivision_id = :subdivision_id";
            
            if ($isChangePass == 1) {
                $qry .= " ,password = :password";
            } else {
                $qry .= " ,password = :password";
            }
            $qry .= " WHERE user_id = :user_id";
           
            $database = new Database();
            $database->query($qry);

            $database->bind(':user_id', $user_id);
            //$database->bind(':role_id', $role_id);
            $database->bind(':name', $name);
            if ($isChangePass == 1) {
                $database->bind(':password', md5($password));
            } else {
                $database->bind(':password', $password);
            }
            $database->bind(':area_id', $area_id);
            $database->bind(':subdivision_id', $subdivision_id);

            $result = $database->execute();
            $database = null;
            return $result;
        } catch (Exception $e) {
            // not a MySQL exception
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    function checkPasswordEditUser($user_id, $password) {
        try {
            $database = new Database();
            $database->query("SELECT * from hr_user WHERE user_id = :user_id AND password = :password");

            $database->bind(':user_id', $user_id);
            $database->bind(':password', $password);

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