<?php
session_start();
if(!isset($_SESSION['user'])){
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
                    Leaderboard
                </h1>
                <hr>
                <?php

                    require_once("dbconfig.php");
                    $query = "select * from leaderboard order by score desc,username asc";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result)>0) {
                        echo "<table class=\"table table-striped\">
                            <thead>
                              <tr>
                                <th>Rank</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Score</th>
                              </tr>
                            </thead>
                            <tbody>";
                        $rank = 1;
                        while($row = mysqli_fetch_assoc($result)) {
                            $query1 = "select * from users where username='".$row["username"]."'";
                            $result1 = mysqli_query($conn, $query1);
                            $row1 = mysqli_fetch_assoc($result1);
                            $name = $row1['name'];
                            echo "<tr>";
                            echo "<td>".$rank."</td>";
                            echo "<td>".$row['username']."</td>";
                            echo "<td>".$name."</td>";
                            echo "<td>".$row['score']."</td>";
                            echo "</tr>";
                            $rank++;

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
