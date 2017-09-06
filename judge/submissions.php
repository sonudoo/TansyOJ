<?php
session_start();
if(!isset($_SESSION["user"])){
    header('location:../index.php?msg=Please%20login%20first');
}
?>
<?php
    require_once("header.php");
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>
                    Submissions
                </h1>
                <hr>
                <?php
                
                    require_once("dbconfig.php");
                    $query = "select * from submissions where username='".$_SESSION['user']."' order by id desc limit 100";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result)>0) {
                        echo "<table class=\"table table-striped\">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Problem code</th>
                                <th>Verdict</th>
                                <th>Jury's comment</th>
                                <th>Language</th>
                                <th>Code</th>
                              </tr>
                            </thead>
                            <tbody>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row['id']."</td>";
                            echo "<td><a href='index.php?id=".$row['problemcode']."'>".$row['problemcode']."</a></td>";
                            $status = "";
                            switch($row['status']){
                                case 0:
                                    $status = "";
                                    break;
                                case 1:
                                    $status = "CE";
                                    break;
                                case 2:
                                    $status = "TLE";
                                    break;
                                case 3:
                                    $status = "WA";
                                    break;
                                case 4:
                                    $status = "NZEC";
                                    break;
                                case 5:
                                    $status = "AC";
                                    break;
                            }
                            echo "<td>".$status."</td>";
                            if($status=="AC"){
                                echo "<td>Jury said: OK</td>";
                            }
                            else if($status=="CE"){
                                echo "<td>Jury said: Compilation error</td>";
                            }
                            else{
                                echo "<td>Jury said: ".$row['error']."</td>";
                            }
                            if($row["lang"]==0){
                                echo "<td>C++</td>";
                            }
                            else{
                                echo "<td>Java</td>";
                            }
                            echo "<td> <a href='judge.php?id=".$row['id']."'>Code</a> </td>";
                            echo "</tr>";

                        } 
                        echo "</tbody></table>";
                    }
                    else{
                        echo "Nothing to show..";
                    }
                ?>
                </div>
        </div>
    </div>
<?php
    require_once("footer.php");
?>
