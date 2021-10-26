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
        echo "<script>alert('Your Login Name or Password is invalid')</script>";

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
    </head>
    <body>
    <?php
    include "navbar.php";
    ?>
                <div style="background-color: rgb(180, 228, 235);padding-top:120px;padding-bottom:1px;border-bottom: solid 2px rgba(0, 0, 0, 0.247);box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                  <!-- <iframe src="python.html" frameborder="1" width="300" height="300" title="frame"></iframe> -->
                  <h1 id="welcome_msg" style="font-weight: bold;color: #030e4e;">
                    <?php
            if($_SESSION['login_user'] == null ) {
              echo "Welcome to Webcoursera";
            }
            else {
              echo "Welcome " . $_SESSION['f_name'] . ", Let's start learning.";
            }
            ?>
        </h1>
        <i class="bi bi-caret-left-square"></i>
        </div>
        <div style="background-color: rgba(216, 220, 221, 0.3);top:0px;padding-top: 10px;padding-bottom:5px">
        <p style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
        Your one stop destination for web development lessons ranging from HTML to Python.<br>
        Select any subject from the dropdown menu above and begin expanding your knowledge right away!<br>
        </p>
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

          <br>
          <h2 style="color:rgb(77, 141, 160);font-weight: bold;">Courses Offered</h2>
        <!-- Courses offered -->
        <div id="courses" class="course_class">

        </div>

        <?php
          $sql = "SELECT * FROM course_details";
          $result = mysqli_query($db,$sql);
          $courses = "";
          
          // $courses";
          foreach ($result as $r) {
            // $courses = $courses . "<div class=\"responsive\" >
            $courses = $courses . "<div class=\"responsive\" >
            <div class=\"gallery\">
            <a target=\"_blank\" href=\"course_enroll.php?course_id=" . $r['course_id'] . "\">
            <img src=\"" . $r['course_img_url'] . "\" alt=\"" . $r['course_formal_name'] . "\">
            <div class=\"desc\">" . $r['course_name'] . "</div>
            </a>
            </div>
            </div>";
            $courses_dropdown = $courses_dropdown .  "<a href=\"course_enroll.php?course_id=" . $r['course_id'] . "\">" . $r['course_formal_name'] . "</a>";
          }
          // $courses = str_replace("\n","\\",$courses);
          echo <<<EOL
              <script>
              document.getElementById('courses').innerHTML = `$courses`
              document.getElementById('courses_dropdown').innerHTML = `$courses_dropdown`
              </script>
              EOL;
          ?>

<div id="reg_users" class="reg_users" style="bottom:100px">

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
        <footer class="footer">
            <span class="tooltip2">
                Contact Us
              <span class="tooltiptext"  style="width:200px;position: absolute;bottom:10px;right:10px">hemanth_b180318cs@nitc.ac.in<br>isaac_b180644cs@nitc.ac.in<br>rohith_b180291cs@nitc.ac.in</span>
            </span>
            <span class="tooltip2">
                About us
              <span class="tooltiptext"  style="width:200px;position: absolute;bottom:10px;right:10px">NITC WebP Exercise 2 Group</span>
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