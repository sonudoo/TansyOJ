<?php
    session_start();
    if(isset($_SESSION["user"])){
        header('location:judge/index.php');
    }
?>
<?php
	if(isset($_POST["username"])){
		$username = htmlspecialchars(addslashes($_POST['username']));
		$password = htmlspecialchars(addslashes($_POST['password']));
		$cpassword = htmlspecialchars(addslashes($_POST['cpassword']));
		$name = htmlspecialchars(addslashes($_POST['name']));
		$rollno = htmlspecialchars(addslashes($_POST['rollno']));
		$email = htmlspecialchars(addslashes($_POST['email']));
		$phno = htmlspecialchars(addslashes($_POST['phno']));
		$error = "";
		if(strlen($username)<4){
			$error = "Username too short. Minimum 1 characters";
		}
		else if(strlen($username)>20){
			$error = "Username too long. Maximum 20 characters";
		}
		else if (!preg_match("/^[a-zA-Z0-9_]*$/",$username)) {
	      	$error = "Only alphanumeric characters and underscores allowed in username"; 
	    }
	    else if(strlen($password)<6){
	    	$error = "Password too short. Minimum 6 characters";
	    }
	    else if(strlen($password)>20){
			$error = "Password too long. Maximum 20 characters";
		}
	    else if($password!==$cpassword){
	    	$error = "Passwords do not match";
	    }
	    else if($name==""){
	    	$error = "Please fill out your name";
	    }
	    else if(strlen($name)>30){
			$error = "Name too long. Maximum 30 characters";
		}
	    else if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
	      	$error = "Only letters and spaces allowed in Name"; 
	    }
	    else if($rollno==""){
	    	$error = "Please enter your roll no";
	    }
	    else{
	    	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			  $error = "Invalid Email!";
		}
	    	else if(!preg_match('/^[0-9]{10}$/',$phno)){
		     $error = "Invalid Phone number! Don't mention +91 at the beginning.";
		}
		else{
			//Validation was fine..
	    	}
	    }
		require_once("judge/dbconfig.php");

		$sql = "select * from users where username='".$username."'";
		$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res)>0){
			$error = "Username already exists";
		}
		$ip = $_SERVER["REMOTE_ADDR"];
		if($error==""){
			$sql = "insert into users(username,password,name,rollno,email,phno,ip) values ('$username','$password','$name','$rollno','$email','$phno','$ip')";
			mysqli_query($conn,$sql);
			session_start();
			$_SESSION["user"] = $username;
			$_SESSION["name"] = $name;
			$_SESSION["rollno"] = $rollno;
			header('location:judge/index.php');
		}
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
<title>Loadra OJ</title>
</head>
<body>
        <div class="container">

                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                          <div class="panel-heading">User registration</div>
                          <div class="panel-body">
                          	<img src="loadra.png">
                          	
				                <?php if($error!="")   echo "<div style=\"color:red;width:98%;height:auto;border-radius:10px;border-style:solid;border-color:red;border-width:2px;background-color:#EEAFB0;padding:10px;margin-left:1%;margin-right:1%;margin-top:2%;margin-bottom:2%;text-align:center;vertical-align:middle;font-weight:normal\">".$error."</div>";  ?>
				            <form method="post" action="">
                              <div class="form-group">
								  <label for="username">Username:</label>
								  <input type="text" placeholder="Username" id="username" name="username" value="<?php echo htmlspecialchars($_POST["username"]); ?>" class="form-control" required>
								</div>
								<div class="form-group">
								  <label for="password">Password:</label>
								  <input type="password" placeholder="Password" id="password" name="password" value="<?php echo htmlspecialchars($_POST["password"]); ?>" class="form-control" required>
								</div>
								<div class="form-group">
								  <label for="cpassword">Confirm Password:</label>
								  <input type="password" placeholder="Confirm Password" id="cpassword" value="<?php echo htmlspecialchars($_POST["cpassword"]); ?>" name="cpassword"  class="form-control" required>
								</div>
								<div class="form-group">
								  <label for="name">Name:</label>
								  <input type="text" placeholder="Name" id="name" name="name" value="<?php echo htmlspecialchars($_POST["name"]); ?>" class="form-control" required>
								</div>
								<div class="form-group">
								  <label for="rollno">Roll number (Ex: BE/10010/12):</label>
								  <input type="text" placeholder="Roll number" id="rollno" name="rollno" value="<?php echo htmlspecialchars($_POST["rollno"]); ?>" class="form-control" required>
								</div>
								<div class="form-group">
								  <label for="email">Email ID (Ex: you@somedomain.com):</label>
								  <input type="text" placeholder="Email ID" id="email" name="email" value="<?php echo htmlspecialchars($_POST["email"]); ?>" class="form-control" required>
								</div>
								<div class="form-group">
								  <label for="phno">Phone no: (Ex: 9898989898):</label>
								  <input type="number" placeholder="Phone number" id="phno" name="phno" value="<?php echo $_POST["phno"]; ?>" class="form-control" required>
								</div>
								<input type="submit" value="Sign up" class="btn btn-primary"><br /><br />
          						<a href="index.php">Login here </a>
                          </div>
                        </form>
                    </div>
                </div>

            </div>
    <script src="judge/js/jquery.js"></script>
    <script src="judeg/js/bootstrap.min.js"></script>
</body>
</html>
