<?php
 // This file is a common footer to all pages after user logs in
?>

<hr>
        <footer>
            <div class="container">

                <div class="col-md-12">
                    <div class="panel panel-default">
                          <div class="panel-heading">User Information</div>
                          <div class="panel-body">
                              <p>
                                  <b>Username: </b> <?php echo $_SESSION["user"]; ?>
                              </p>
                              <p>
                                  <b>Name:</b> <?php echo $_SESSION["name"]; ?>
                              </p>
                              <p>
                                  <b>IP address:</b> <?php echo $_SERVER["REMOTE_ADDR"]; ?>
                              </p>
                              <p>
                                  <button class="btn btn-primary" onclick="window.location.href='logout.php';">Logout</button>
                              </p>
                          </div>
                    </div>
                </div>

            </div>
            <div class="container">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <p style="color:gray">&copy; Tansy OJ. Created by, Sushant Kumar Gupta, Birla Institute of Technology, Ranchi</p>
                </div>
                <div class="col-lg-3">
                </div>
            </div>
        </footer>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
