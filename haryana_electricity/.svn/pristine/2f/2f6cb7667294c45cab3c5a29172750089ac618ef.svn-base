<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require('common/ErrorManager.php');
$url = $_SERVER["SCRIPT_NAME"];
$url = explode('/', $url);
$subURL = $url[count($url) - 1];
if (empty($_SESSION['isLogin']) OR $_SESSION['isLogin'] == 0) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Haryana Admin Services</title>
        <!-- jQuery -->
        
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link media="print" href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin.css?28072016" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"> <img class="img-responsive" src="img/logo.png" /></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li>
                            <a href="index.php"> <img src="img/home.png"> Home</a>
                        </li>
                       
                        <!--<li class="<?php //if (in_array($subURL, array('pending-complain.php'))) {   ?> active <?php //}   ?>">
                            <a href="pending-complain.php"><i class="fa fa-fw fa-newspaper-o"></i> Pending Complains</a>
                        </li>
                        <li class="<?php //if (in_array($subURL, array('resolve-complain.php'))) {   ?> active <?php //}   ?>">
                            <a href="resolve-complain.php"><i class="fa fa-fw fa-newspaper-o"></i> Resolved Complains</a>
                        </li>-->
                        <li>
                            <a href="register-complain.php"><img src="img/complaint.png"> Register Complaint</a>
                        </li>
                        <li>
                             <a href="resolve-complain.php"> <img src="img/resolve-menu-icon.png"> Resolved Complaints</a>
                        </li>
                        <?php if ($_SESSION['role'] == 1) { ?>
                            <li>
                                <a href="complain-cat.php"><img src="img/category.png"> Complaint Category</a>
                            </li>
                        <?php } ?>
                             <?php if ($_SESSION['role'] == 1) { ?>
                        <li>
                            <a href="users.php"><img src="img/user.png">  Users</a>
                        </li>
                             <?php } ?>

                        <?php if ($_SESSION['role'] == 1) { ?>

                            <li>
                                <a href="area.php"><img src="img/division.png">  Manage Division</a>
                            </li>

                        <?php } ?>
                            <?php if ($_SESSION['role'] == 1) { ?>
                        <li>
                           <a href="subdivision.php"><img src="img/subdivision.png">  Manage Subdivision</a>
                        </li>
                            <?php } ?>
                        <li>
                           <a href="report.php"><img src="img/report.png">  Reports</a>
                        </li>
                        <li>
                           <a href="excel-report.php"><img src="img/report.png">  Excel Reports</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>