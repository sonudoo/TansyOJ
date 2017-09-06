<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tansy OJ</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="css/code-styler/solarized-dark.css">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/highlight.pack.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<body>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Message from admin</h4>
            </div>
            <div class="modal-body">
                <p><?php
                    session_start();
                    require_once("dbconfig.php");
                    $sql = "select * from msg where username='".$_SESSION["user"]."'";
                    $res = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($res)>0){
                        $row = mysqli_fetch_assoc($res);
                        $msg = $row["msg"];
                        $sql1 = "delete from msg where username='".$_SESSION["user"]."'";
                        $res = mysqli_query($conn,$sql1);
                        echo $msg;
                        echo "<script type=\"text/javascript\">
                            $(document).ready(function(){
                                $(\"#myModal\").modal('show');
                            });
                        </script>";
                    }
                ?>
                    
                </p>
            </div>
        </div>
    </div>
</div>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Tansy OJ</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="submissions.php">My Submissions</a>
                    </li>
                    <li>
                        <a href="leaderboard.php">Leaderboard</a>
                    </li>
                    <li>
                        <a href="faq.php">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

