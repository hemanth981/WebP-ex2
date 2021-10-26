<?php
   include("config.php");
   session_start();
   error_reporting(E_ERROR | E_PARSE);
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 

      //$hpw = 
      
      //$sql = "SELECT id FROM user_details WHERE username = '$myusername' and passcode = '$mypassword'";
      $sql = "SELECT f_name,l_name,email_id,`password` FROM user_details WHERE username = '$myusername';";
      $result = mysqli_query($db,$sql);
      
      //this loop is not a bug,don't remove it
      foreach($result as $r){  //$r used in line 28
        //echo implode(" ",$r) . "<br>";
      }
      //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      //$active = $row['active'];
      
      $count = mysqli_num_rows($result);
      $f_name = $r['f_name'];
      $_SESSION['f_name'] = $f_name;
      $_SESSION['l_name'] = $r['l_name'];
    
      $_SESSION['email_id'] = $r['email_id'];
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1 && password_verify($_POST["password"],$r["password"])) {
         // session_register("myusername");

         $_SESSION['login_user'] = $myusername;
         
        //  header("location: welcome.php");
        
      }else {
        $error = "Your Login Name or Password is invalid";
      }
    }
    ?>




<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
          Webcoursera
        </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="homepage_styles.css">
        <script src="index_js.js"></script>
        <style>
          input[type=text], input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            color: black;
}
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}
.register {
  margin-top: 60px;
  margin: 40px;
  background-color: rgba(40, 40, 100, 0.5);
  border-radius: 10px;
  margin-left:30%;
  margin-right:30%;
  color: white;
  text-align: center;
}
.register_content {
  padding-top: 20px;
  margin-left: 20px;
  margin-right: 20px;
}
.registerbtn:hover {
  opacity: 1;
}
        </style>
    </head>
    <body>
      <!-- Navigation Bar -->
      <?php
      include "navbar.php"
      ?>
      
          <!-- Dropdown menu for classes -->
          <div class="dropdown-content" onmouseover="display_classes()" onmouseout="hide_classes()">
            <a href="ajax.php">Ajax</a>
            <a href="css.php">CSS</a>
            <a href="html.php">HTML</a>
            <a href="java.php">Java</a>
            <a href="python.php">Python</a>
            <a href="javascript.php">Javascript</a>
          </div>

          <!-- Dropdown menu for user details -->
          <div class="user_details_dropdown" id="user_details_dropdown" onmouseover="display_user_details()" onmouseout="hide_user_details()" style="display:none">
                <?php
                    $f_name = $_SESSION['f_name'];
                    $l_name = $_SESSION['l_name'];
                    $email = $_SESSION['email_id'];
                    echo "<a>$f_name</a>";
                    echo "<a>$l_name</a>";
                    echo "<a>$email</a>";
                    echo "<a href='deregister.php?confirm=false' class='deregister_link'>Deregister</a>";
                    echo "<a style='height:3px'></a>";
                    echo "<a href='logout.php' class='logout_link' style='color:white;height:40px'><i class='glyphicon glyphicon-log-out'></i>  Logout</a>";
                ?>
                </div>
        <div style="background-color: rgb(180, 228, 235);padding-top:120px;padding-bottom:1px;border-bottom: solid 2px rgba(0, 0, 0, 0.247);box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
          <!-- <iframe src="python.html" frameborder="1" width="300" height="300" title="frame"></iframe> -->
          <h1 id="welcome_msg" style="font-weight: bold;color: #030e4e;">
            Register Here
        </h1>
        <i class="bi bi-caret-left-square"></i>
        </div>
        <div style="background-color: rgba(216, 220, 221, 0.3);top:0px;padding-top: 10px;padding-bottom:5px">
        
         <!-- Registration Form -->
         <div class="register">
           <div class="register_content">
        <form action="register.php" method="post" style="padding-bottom:35;">
            <h2>Registration form </h2>
            First Name: <input type="text" name="fname" required><br>
            Last Name: <input type="text" name="lname" required><br>
            Password: <input type="password" name="pw" required><br>
            Re-enter Password: <input type="password" name="pwr" required><br>
            E-mail: <input type="text" name="email" required><br>
            Mobile: <input type="text" name="mobile" required><br>
            Enter unique user name: <input type="text" name="uname" required><br>
            <input type="submit" name="Register" class="registerbtn"/>
           
        </form>
        </div>
        </div>

        </div>
        <!-- Login Form -->
        <div id="user_auth" class="login_form">
            <form class="login_form-content" action="" method="post">
              <div class="imgcontainer">
                <img src="static/img/nitc_logo.jpeg" alt="Avatar" class="avatar">
              </div>
          
              <div class="container">
                Username
                <input type="text" placeholder="Enter Username" name="username" required>
                Password
                <input type="password" placeholder="Enter Password" name="password" required>
                <input type="checkbox" name="is_signup" id="id_is_signup"  hidden>
                <button id="login_signup" type="submit" class="login_form_button">Login</button>
        
              </div>
          
              <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('user_auth').style.display='none'" class="cancelbtn login_form_button">Cancel</button>
              </div>
            </form>
          </div>

        

        </div>
        <?php
        if(isset($_SESSION['myusername'])) {
          $sql = "SELECT username FROM user_details";
          $result = mysqli_query($db,$sql);
          echo "<ul style='margin-bottom:100px'>";
          foreach ($result as $r) {
            echo "<li>" . $r['username'] . "</li>";
          }
          echo "</ul>";
        }
        ?>
        <div class="placeholder" id="placeholder">

        </div>
        <footer class="footer">
            <span class="tooltip2">
                Contact Us
              <span class="tooltiptext"  style="width:200px;position: absolute;bottom:10px;right:10px">hemanth_b180318cs@nitc.ac.in<br>isaac_b180644cs@nitc.ac.in<br>rohith_b180291cs@nitc.ac.in</span>
            </span>
            <span class="tooltip2">
                About us
              <span class="tooltiptext"  style="width:200px;position: absolute;bottom:10px;right:10px">NITC WebP Exercise 1 Group</span>
            </span>

            <a href="privacy.html" style="color:white;padding-right:10px">
                Privacy policy
            </a>
            <a href="terms_and_conditions.html" style="color:white;padding-right:10px">
                Terms and Conditions
            </a>
          </footer>
    </body>
    </html>

    <!--   Registration Logic    -->
    <?php

include "config.php";
    

    function validate_mobile($mobile) {
        return preg_match('/^[6-9]\d{9}$/', $mobile);
    }

    function unique_uname($uname){
      try{
          include "config.php";
          // $mysqli = new mysqli($host, $username, $password, $dbname);

          //$sql = "INSERT into user_details(username) values (\"usexcvragv25hfgs1\")";
          $sql = "SELECT username FROM user_details;";
          $result = mysqli_query($db,$sql);

          foreach($result as $r){
            if($r["username"] == $uname){
              return false;
            }
          }
          // $mysqli->close();

          return true;
      } 
    catch (PDOException $error){
         echo 'connect failed:'.$error->getMessage();
    }
    return false;
    }

    function insert_to_database($fname,$lname,$pw,$email,$mobile,$uname){
      try{
        include "config.php";
        // $mysqli = new mysqli($host, $username, $password, $dbname);
        $hpw = password_hash($pw, PASSWORD_DEFAULT);

        $sql = sprintf("INSERT INTO user_details(f_name,l_name,email_id,mobile_no,username,`password`) values ('%s','%s','%s','%s','%s','%s')",$fname,$lname,$email,$mobile,$uname,$hpw);
        
        $result = mysqli_query($db, $sql);

        // foreach ($result as $r){
        //   if($r["username"] == $uname){
        //     return false;
        //   }
        // }
        // $mysqli->close();
    } 
  catch (PDOException $error){
       echo 'connect failed:'.$error->getMessage();
  }
}


  $reg_finish = false;
  if(isset($_POST["fname"]) and $reg_finish == false)   {
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $pw = $_POST["pw"];
  $pwr = $_POST["pwr"];
  $email = $_POST["email"];
  $mobile = $_POST["mobile"];
  $uname = $_POST["uname"];

  $pw_check = $pw == $pwr;
  $email_check = filter_var($email, FILTER_VALIDATE_EMAIL);
  $unique_check = unique_uname($uname);

  if(!$pw_check){
      echo '<script>alert("You have re-entered wrong password")</script>';
  }

  if(!$email_check){
      echo '<script>alert("Invalid email")</script>';
  }

 
  if(!$unique_check){
    echo '<script>alert("This username has alread been taken.Try a different one.")</script>';
  }
  
  
  if ($pw_check && $email_check && $unique_check){
  insert_to_database($fname,$lname,$pw,$email,$mobile,$uname);
  
  $redirect_url = $_REQUEST['redirect_url'];
  if($redirect_url=="") {
    $redirect_url = $_SESSION['redirect_url'];
    if($redirect_url == "") {
      $redirect_url = "index.php";
    }
  }
  else {
    $_SESSION['redirect_url'] = $redirect_url;
  }
  // header("Location: http://localhost/" . $redirect_url); 
  $reg_finish = true;
  echo "<div style='height:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,0.8);width:100%;'><h1 style='color:white;text-align:center'>Registration success.</h1><h2 style='color:grey;text-align:center'>Redirecting in 3s...</h2>
  <div class='loader' style='border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  margin-left:auto;
  margin-right:auto;
  '></div>
  <style>
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  </style>
  </div>";
  echo "<script>
  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
  async function redirect() {
    await sleep(3000);
    window.location='" . $redirect_url . "';
    }
  redirect();
  </script>";}




}
$sql = "SELECT * FROM course_details";
$result = mysqli_query($db,$sql);
$courses = "";

// $courses";
foreach ($result as $r) {
  // $courses = $courses . "<div class=\"responsive\" >
  $courses_dropdown = $courses_dropdown .  "<a href=\"course_enroll.php?course_id=" . $r['course_id'] . "\">" . $r['course_formal_name'] . "</a>";
}
// $courses = str_replace("\n","\\",$courses);
echo <<<EOL
    <script>
    document.getElementById('courses_dropdown').innerHTML = `$courses_dropdown`
    </script>
    EOL;
    ?>