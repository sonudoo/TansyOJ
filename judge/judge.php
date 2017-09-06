<?php
session_start();
if(!isset($_SESSION["user"])){
    header('location:../index.php?msg=Please%20login%20first');
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
    <title>Loadra OJ</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="css/code-styler/default.css">
    <script src="js/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<?php
    require_once("header.php");
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if(isset($_GET['id'])){

                        $id = htmlspecialchars(addslashes(stripslashes($_GET["id"])));

                        require_once("dbconfig.php");

                        $query = "select * from submissions where id=".$id." and username='".$_SESSION["user"]."'";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result)==1) {
                            $row = mysqli_fetch_assoc($result);
                            $status = "Unknown";
                            $code = $row["code"];
                            $code = str_replace("<", "&lt;", $code);
                            $code = str_replace(">", "&gt;", $code);
                            $lang = "Unknown";
                            if($row["lang"]==0){
                                $lang = "lang-cpp";
                            }
                            else{
                                $lang = "lang-java";
                            }
                            switch ($row["status"]) {
                                case 0: $status = "<font color='grey'>Judgement Pending..</font> <a href=''>Refresh</a>";break;
                                case 5: $status = "<font color='green'>Accepted</font>";break;
                                case 1: $status = "<font color='red'>Compilation error</font><br><p><pre style='color:black;background-color:white'>".$row['error']."</pre></p>";break;
                                case 2: $status = "<font color='blue'>".$row['error']."</font>";break;
                                case 3: $status = "<font color='red'>".$row['error']."</font>";break;
                                case 4: $status = "<font color='red'>".$row['error']."</font>";break;
                            }
                            echo "<h1 class=\"page-header\">Verdict</h1>
                                    <h4>".$status."</h4>
                                <hr>
                                <h3>
                                    Code
                                </h3><br /><pre><code class=\"html ".$lang."\">".$code."</code></pre>
                                <br />
                                <button class=\"btn btn-primary\" onclick=\"javascript:history.back();\">Go Back</button>

                                ";
                        } 
                        else{
                            
                        }
                    }
                    else{
                        
                    }
                ?>
                </div>
        </div>
    </div>
<?php
    require_once("footer.php");
?>
