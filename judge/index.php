<?php
// This is the first page that the user sees after logging in. This page lists the problems as well as display them depending on whether the id is set in the query or not. This page also processes submissions.

// Check if the user is logged in
session_start();
if(!isset($_SESSION["user"])){
    header('location:../index.php?msg=Please%20login%20first');
}

// Check if a submission was made.
if(isset($_POST["problemcode"])){
    $problemcode = htmlspecialchars(stripslashes(trim(str_replace(" ","",$_POST["problemcode"]))));
    $code = addslashes($_POST["code"]);
    $ip = $_SERVER["REMOTE_ADDR"];
    
    // Validate the submission
    if(strlen($code) > 50000){
        header("location:index.php?id=".$problemcode."&msg=Code%20too%20large.");
    }
    if(strlen($code)<=1){
        header("location:index.php?id=".$problemcode."&msg=Please%20enter%20some%20code.");
    }
    if($_POST["lang"]!="0" && $_POST["lang"]!="1"){
        
        // 0 for C++ and 1 for Java. Add language code accordingly.
        header("location:index.php?id=".$problemcode."&msg=Incorrect%20language%20selected.");
    }
    
    require_once("dbconfig.php");
    
    // Check the validity of the problem code. 
    $query = "select * from problems where code='".$problemcode."'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result)!=1){
        die("<center>Incorrect problem code. Are you trying to crack into the system?</center>");
    }

    // Insert the submission to the database.
    
    $query = "insert into submissions(username,problemcode,lang,status,code,ip) values ('".$_SESSION["user"]."','".$problemcode."',".$_POST["lang"].",0,'".$code."','".$ip."')";
    
    // The judge (judge.py) is waiting for the submission. The below code is used to inform the judge that a submission has been made. If the judge.py script is not running, the submission will be stored and judged next time when the script runs again.
    
    if(mysqli_query($conn,$query)){
        if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))){
            die("<center>Sorry, the judge is offline at this time. Your code has been received. <br />It will be judged as soon as the judge is online</center>");
        }
        if(!socket_connect($sock , '127.0.0.1' , 8080)){
            die("<center>Sorry, the judge is offline at this time. Your code has been received. <br />It will be judged as soon as the judge is online</center>");
        }
        socket_close($sock);
        header('location:judge.php?id='.mysqli_insert_id($conn));
    }
    else{
        die("<center>There was a problem connecting to database..</center>");
    }
}
?>
<?php
    require_once("header.php");
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if(isset($_GET["id"])){
                        
                        // If the id is set then display the corresponding question.
                        $id = htmlspecialchars(addslashes(stripslashes($_GET["id"])));

                        require_once("dbconfig.php");

                        $query = "select * from problems where code='".$id."'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result)==1) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<h2 class=\"page-header\">".$id."</h1>".$row["statement"]."<hr>
                                <div class=\"panel panel-default\">
                                      <div class=\"panel-heading\">Sample Input</div>
                                      <div class=\"panel-body\">
                                          ".$row["sampleinput"]."
                                      </div>
                                </div>
                                <div class=\"panel panel-default\">
                                      <div class=\"panel-heading\">Sample Output</div>
                                      <div class=\"panel-body\">
                                          ".$row["sampleoutput"]."
                                      </div>
                                </div>
                                <div class=\"panel panel-default\">
                                      <div class=\"panel-heading\">Constraints</div>
                                      <div class=\"panel-body\">
                                          <p>
                                            <b>Time Limit:</b> ".$row["time"]." sec
                                          </p>
                                          <p>
                                            <b>Allowed languages:</b> C++, Java 
                                          </p>
                                          <p>
                                            <b>Source limit:</b> 50000 B
                                          </p>
                                          <p>
                                            <b>Memory limit:</b> 2096 MB
                                          </p>
                                      </div>
                                </div>
                                <hr>
                                <h3>
                                    Submit Solution
                                </h3>
                                ";
                            if(isset($_GET["msg"])){
                                echo "<font color='red'>".htmlspecialchars(addslashes(stripslashes($_GET["msg"])))."</font><br /><br />";
                            }

                            echo "<form name=\"form\" method=\"post\" action=\"\">
                                    <p>Language: </p><select name=\"lang\" class=\"form-control\" style=\"width:30%\">
                                        <option value=\"0\">C or C++ 14 (g++ 6.3)</option>
                                        <option value=\"1\">Java 8 (java8)</option>
                                    </select>
                                    <br />
                                    <p>
                                        Code:
                                    </p>
                                    <input type=\"hidden\" name=\"problemcode\" value=\"".$id."\" />
                                    <textarea name=\"code\" onkeydown=\"if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}\" rows=15 class=\"form-control\" style=\"resize:none;font-family:courier new;font-size:17px;color:black;\" spellcheck=false>";
                            $query = "select id,code from submissions where username='".$_SESSION["user"]."' and problemcode='".$id."' order by id desc limit 1";
                            $result = mysqli_query($conn,$query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row["code"];
                            echo "</textarea>
                                    <br />
                                    <input type=\"submit\" name=\"Submit\" value=\"Submit Solution\" class=\"btn btn-primary\" />
                                </form>";
                        } 
                        else{
                            
                            // Oops. That's a 404 error. No problem corresponding to provided id was found in the database.
                            
                        }
                    }
                    else{
                        
                        
                        // No id set. Show the list of all the problems.
                        
                        require_once("dbconfig.php");
                        $query = "select problemcode,status from submissions where username='".$_SESSION["user"]."'";
                        $result = mysqli_query($conn,$query);
                        $solved = array();
                        while($row=mysqli_fetch_assoc($result)){
                            if($row["status"]==5){
                                $solved[$row["problemcode"]] = 1;
                            }
                            else{
                                if(!isset($solved[$row["problemcode"]]))
                                    $solved[$row["problemcode"]] = 0;
                            }
                        }
                        echo "<h1 class=\"page-header\">List of Problems</h1>";
                        echo "<ul class=\"nav nav-tabs\">
                                  <li class=\"active\"><a data-toggle=\"tab\" href=\"#easy\">Easy</a></li>
                                  <li><a data-toggle=\"tab\" href=\"#medium\">Medium</a></li>
                                  <li><a data-toggle=\"tab\" href=\"#hard\">Hard</a></li>
                                  <li><a data-toggle=\"tab\" href=\"#extreme\">Extreme</a></li>
                                </ul>";
                        echo "<div class=\"tab-content\">";

                        echo "<div id=\"easy\" class=\"tab-pane fade in active\">";
                        echo "<table class=\"table table-hover\">
                            <thead>
                              <tr>
                                <th>Sl. no.</th>
                                <th>Problem Code</th>
                                <th>Short Description</th>
                                <th>Users</th>
                                <th>Link</th>
                              </tr>
                            </thead>
                            <tbody>";

                        $query = "select * from problems where level=0 order by id";
                        $result = mysqli_query($conn, $query);
                        $sl = 1;
                        while($row=mysqli_fetch_assoc($result)) {
                            if(isset($solved[$row["code"]]) && $solved[$row["code"]]==1){
                                echo "<tr class=\"success\">";
                            }
                            else if(isset($solved[$row["code"]]) && $solved[$row["code"]]==0){
                                echo "<tr class=\"danger\">";
                            }
                            else{
                                echo "<tr>";
                            }
                            echo "<td>".$sl++."</td><td><a href='index.php?id=".$row["code"]."'>".$row["code"]."</a></td>
                                    <td>".$row["description"]."</td>
                                    <td>".$row["users_solved"]."</td>
                                    <td><a href='index.php?id=".$row["code"]."'>View/Submit</a></td>
                                  </tr>";
                        }
                        echo "</tbody></table></div>";
                        echo "<div id=\"medium\" class=\"tab-pane fade\">";
                        echo "<table class=\"table table-hover\">
                            <thead>
                              <tr>
                                <th>Sl. no.</th>
                                <th>Problem Code</th>
                                <th>Short Description</th>
                                <th>Users</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>";

                        $query = "select * from problems where level=1 order by id";
                        $result = mysqli_query($conn, $query);
                        $sl = 1;
                        while($row=mysqli_fetch_assoc($result)) {
                            if(isset($solved[$row["code"]]) && $solved[$row["code"]]==1){
                                echo "<tr class=\"success\">";
                            }
                            else if(isset($solved[$row["code"]]) && $solved[$row["code"]]==0){
                                echo "<tr class=\"danger\">";
                            }
                            else{
                                echo "<tr>";
                            }
                            echo "<td>".$sl++."</td><td><a href='index.php?id=".$row["code"]."'>".$row["code"]."</a></td>
                                    <td>".$row["description"]."</td>
                                    <td>".$row["users_solved"]."</td>
                                    <td><a href='index.php?id=".$row["code"]."'>View/Submit</a></td>
                                  </tr>";
                        }
                        echo "</tbody></table></div>";
                        echo "<div id=\"hard\" class=\"tab-pane fade\">";
                        echo "<table class=\"table table-hover\">
                            <thead>
                              <tr>
                                <th>Sl. no.</th>
                                <th>Problem Code</th>
                                <th>Short Description</th>
                                <th>Users</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>";

                        $query = "select * from problems where level=2 order by id";
                        $result = mysqli_query($conn, $query);
                        $sl = 1;
                        while($row=mysqli_fetch_assoc($result)) {
                            if(isset($solved[$row["code"]]) && $solved[$row["code"]]==1){
                                echo "<tr class=\"success\">";
                            }
                            else if(isset($solved[$row["code"]]) && $solved[$row["code"]]==0){
                                echo "<tr class=\"danger\">";
                            }
                            else{
                                echo "<tr>";
                            }
                            echo "<td>".$sl++."</td><td><a href='index.php?id=".$row["code"]."'>".$row["code"]."</a></td>
                                    <td>".$row["description"]."</td>
                                    <td>".$row["users_solved"]."</td>
                                    <td><a href='index.php?id=".$row["code"]."'>View/Submit</a></td>
                                  </tr>";
                        }
                        echo "</tbody></table></div>";
                        echo "<div id=\"extreme\" class=\"tab-pane fade\">";
                        echo "<table class=\"table table-hover\">
                            <thead>
                              <tr>
                                <th>Sl. no.</th>
                                <th>Problem Code</th>
                                <th>Short Description</th>
                                <th>Users</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>";

                        $query = "select * from problems where level=3 order by id";
                        $result = mysqli_query($conn, $query);
                        $sl = 1;
                        while($row=mysqli_fetch_assoc($result)) {
                            if(isset($solved[$row["code"]]) && $solved[$row["code"]]==1){
                                echo "<tr class=\"success\">";
                            }
                            else if(isset($solved[$row["code"]]) && $solved[$row["code"]]==0){
                                echo "<tr class=\"danger\">";
                            }
                            else{
                                echo "<tr>";
                            }
                            echo "<td>".$sl++."</td><td><a href='index.php?id=".$row["code"]."'>".$row["code"]."</a></td>
                                    <td>".$row["description"]."</td>
                                    <td>".$row["users_solved"]."</td>
                                    <td><a href='index.php?id=".$row["code"]."'>View/Submit</a></td>
                                  </tr>";
                        }
                        echo "</tbody></table></div>";
                        echo "</div>";
                    }
                ?>
                </div>
        </div>
    </div>
<?php
    require_once("footer.php");
?>
