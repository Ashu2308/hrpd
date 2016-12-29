<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Login</title>

        <!-- Jquery -->

        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    </head>

    <body style="background-color: #f8f8f8;">

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel-heading">
						<a class="navbar-brand img-responsive" href="index.php" style="margin-bottom:20px;margin-left:40px;"> <img class="img-responsive" src="img/logo.png" /></a>
                        <h2  style="color:#4cae4c; font-weight:700; text-align:center; letter-spacing:1px"> Haryana </h2>
                        <h2 class="panel-title" style="color:#4cae4c; font-weight:700; margin-top:10px; text-align:center"> Power Distribution Support Services </h2>
                    </div>
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form name="loginForm" id="loginForm" method="post" action="ajax-process.php?action=submitLoginForm">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" id="userinfo" placeholder="Mobile Number" name="userinfo" type="text" autofocus>
                                    </div>
                                    <div id="unique_info" class="formErrorSelf"></div>
                                    <div class="form-group">
                                        <input class="form-control" id="password" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div id="unique_pass" class="formErrorSelf"></div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" name="submitLogin" id="submitLogin" onclick="return submitLoginForm(event);" />
                                    <div id="invalid-detail" class="formErrorSelf"></div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php //include_once('footer.php'); ?>

        <script type="text/javascript">

            function submitLoginForm(e)
            {
                if ($('#userinfo').val() == '')
                {
                    $('#unique_info').html("You can't leave this empty");
                    if ($('#password').val() == '')
                    {
                        $('#unique_pass').html("You can't leave this empty");
                    }
                    e.preventDefault();
                } else
                {
                    //callback handler for form submit
                    $("#loginForm").submit(function (e)
                    {
                        var postData = $(this).serializeArray();
                        var formURL = $(this).attr("action");
                        $.ajax(
                                {
                                    url: formURL,
                                    type: "POST",
                                    async: false,
                                    cache: false,
                                    data: postData,
                                    error: function () {
                                        //return true;
                                    },
                                    success: function (result)
                                    {
                                        if (result == 'true')
                                        {
                                            //$.removeCookie("loggedout");
                                            location.href = "index.php";
                                            
                                        } else if (result == 'inactive') {
                                            $('#invalid-detail').html("You are not authorised to login.");
                                        } else
                                        {
                                            $('#invalid-detail').html("The login credentials you entered is incorrect.");
                                        }
                                    }
                                });
                        e.preventDefault(); //STOP default action
                    });
                }
            }

        </script>
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-80379765-1', 'auto');
  ga('send', 'pageview');

</script>
