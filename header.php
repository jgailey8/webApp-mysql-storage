<?php
session_start();
//if not logged in go to login page
if (!$_SESSION["login"])
    header("Location: login_form.html");
?>
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" 
aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
            <a class="navbar-brand" href="#"></a>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="#" id='HomeBtn'><span class="glyphicon glyphicon-home"> Home</span></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!-- Show welcome message -->
                    <li><p class="navbar-text">
                <?php echo "welcome " . $_SESSION['Name'];
                    ?></p></li>
                <li><p class="navbar-btn"><a class="btn btn-default" href="logout.php">Logout</a></p></li>
            </ul>
          </div><!-- end of navbar -->
        </div><!--end of div that navbar is placed in -->
      </nav>
