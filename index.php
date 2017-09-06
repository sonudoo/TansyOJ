<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("location:judge/index.php");
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="judge/css/bootstrap.min.css" rel="stylesheet">
<link href="judge/css/portfolio-item.css" rel="stylesheet">
<style>
.register{ height:<?php if($error!="")   echo "340"; else echo "320"; ?>px;width:220px;margin:auto;border:1px #CCC solid;padding:10px;}
.register input { padding:5px;margin:5px}
</style>
<title>Tansy OJ</title>
</head>
<body>
        <div class="container">

                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                          <div class="panel-heading">User login</div>
                          <div class="panel-body">
                          <div  style="text-align:center">
                            <img src="tansy.png" height="25%" width="25%">
                            <img src="tansy-text.png">
                            </div>
                            <?php if(isset($_GET['msg']))   echo "<div style=\"color:red;width:98%;height:auto;border-radius:10px;border-style:solid;border-color:red;border-width:2px;background-color:#EEAFB0;padding:10px;margin-left:1%;margin-right:1%;margin-top:2%;margin-bottom:2%;text-align:center;vertical-align:middle;font-weight:normal\">".htmlspecialchars($_GET['msg'])."</div>";  ?>
                            <form method="post" action="login.php">
                              <div class="form-group">
                                  <label for="username">Username:</label>
                                  <input type="text" placeholder="Username" id="username" name="username" value="" class="form-control" required>
                                </div>
                                <div class="form-group">
                                  <label for="password">Password:</label>
                                  <input type="password" placeholder="Password" id="password" name="password" value="" class="form-control" required>
                                </div>
                                <input type="submit" value="Login" class="btn btn-primary"><br /><br />
                                <a href="register.php">Register here </a>
                          </div>
                        </form>
                    </div>
                </div>

            </div>
    <script src="judge/js/jquery.js"></script>
    <script src="judeg/js/bootstrap.min.js"></script>
</body>
</html>
