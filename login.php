<?php
    $username = htmlspecialchars(addslashes($_POST['username']));
    $password = htmlspecialchars(addslashes($_POST['password']));
    
    require_once("judge/dbconfig.php");

    $query = "select * from users where username='".$username."' and password='".$password."'";
    $res = mysqli_query($conn,$query);
    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);
        session_start();
        $_SESSION["user"] = $username;
        $_SESSION["name"] = $row["name"];
        $_SESSION["rollno"] = $row["rollno"];
        header("location:judge/index.php");
    }
    else{
        header("location:index.php?msg=Authentiation%20Failed");
    }
?>
    
