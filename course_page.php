<?php

include("config.php");
session_start();
// echo "<script>alert('Unauth.');</script>";
$auth_id = $_SESSION['auth_course_id'];
$course_id = $_REQUEST['course_id'];
   if($auth_id != $course_id) {
     header('Location: course_enroll.php?course_id=' . $course_id);
    }
    $sql = 'SELECT * FROM course_details WHERE course_id = ' . $course_id;
    $result = mysqli_query($db, $sql);
    foreach($result as $r)
    {

    }
    $course_name = $r['course_name'];
    $course_description = $r['course_description'];
    $course_sub = $r['course_subtitle'];
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 

      //$hpw = 
      
      //$sql = "SELECT id FROM user_details WHERE username = '$myusername' and passcode = '$mypassword'";
      $sql = "SELECT `password` FROM user_details WHERE username = '$myusername';";
      $result = mysqli_query($db,$sql);
      
      //this loop is not a bug,don't remove it
      foreach($result as $r){  //$r used in line 28
        //echo implode(" ",$r) . "<br>";
      }
      //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      //$active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
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
    </head>
    <body>
      <!-- Navigation Bar -->
      <?php
    include "navbar.php";
    ?>
                <!-- Dropdown menu for classes -->
                <div class="dropdown-content" id="courses_dropdown" onmouseover="display_classes()" onmouseout="hide_classes()">
                </div>
                <div class="search_dropdown" id="search_dropdown">

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

                <!-- DISPLAY REGD USERS -->
                <ul class="regd_users_dropdown" id="regd_users_dropdown" onmouseover="display_regd_users()" onmouseout="hide_regd_users()" style="display:none">
                  <!-- Display all registered users in the website -->
                   <?php
                   if(isset($_SESSION['login_user'])) {
                     $sql = "SELECT username FROM user_details";
                     $result = mysqli_query($db,$sql);
                     foreach ($result as $r) {
                       echo "<li>" . $r['username'] . "</li>";
                      }}
                      else {
                      echo "<li>Please login to view</li>";
                    }
                    ?>
                </ul>

                <div style="background-color: rgb(180, 228, 235);padding-top:120px;padding-bottom:1px;border-bottom: solid 2px rgba(0, 0, 0, 0.247);box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                  <!-- <iframe src="python.html" frameborder="1" width="300" height="300" title="frame"></iframe> -->
                  <h1 id="course_title" style="font-weight: bold;color: #030e4e;">
                    <?php
                  echo $course_name;
                  echo <<<EOF
                  <button class="unenroll_btn"style="float:right;font-size:15px;padding-bottom:10px;" onclick="window.location='course_enroll.php?unenroll=true&course_id=$course_id'">Unenroll</button>
                  EOF
                  ?>
                </h1>
                <!-- <i class="bi bi-caret-left-square"></i> -->
              </div>
              <div style="background-color: rgba(216, 220, 221, 0.3);top:0px;padding-top: 10px;padding-bottom:5px">
                <p style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                  <?php

try{
  echo $course_description;
                    // include('config.php');
                    
                    $sql = "SELECT user_id FROM registrations WHERE course_id=$course_id";
                    $result = mysqli_query($db, $sql);
                    $c = mysqli_num_rows($result);
                    
                    
                    echo "<h4 style=\"font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;\"> " . $c . " users currently enrolled.<br></h4>";
                    
                  } 
                  catch (PDOException $error){
                    echo "<script>alert(\"Hello Failure\")</script>";
                    echo 'connect failed:'.$error->getMessage();
                  };
                  ?>
        </p>
        </div>
        <h2 style="color:rgb(77, 141, 160);font-weight: bold;">Video Lectures</h2>
        <div class="video_length_filter">
        <!-- <a class="active" href="#home">Home</a> -->
        
        <label class="container_checkbox" >Small
          <input type="checkbox" checked onchange="length_filter(this, 1)" id="video_filter_s">
          <span class="checkmark"></span>
        </label>
        <label class="container_checkbox" >Medium
          <input type="checkbox" checked onchange="length_filter(this, 1)" id="video_filter_m">
          <span class="checkmark"></span>
        </label>
        <label class="container_checkbox" >Large
          <input type="checkbox" checked onchange="length_filter(this, 1)" id="video_filter_l">
          <span class="checkmark"></span>
        </label>
        <!-- <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a> -->
        </div>
        <div id="videos" style="margin-top:30px">
          <?php
          $sql = 'SELECT `url`,thumbnail,title,video_length from course_video WHERE course_id=' . $course_id;
          $result = mysqli_query($db, $sql);
          foreach($result as $r) {
            $url = $r['url'];
            $title = $r['title'];
            $thumbnail = $r['thumbnail'];
            $vid_length = $r['video_length'];
            echo <<<EOL
            <div class="responsive">
            <div class="gallery">
            <a class="course_video_item" onclick="play_video(this, '$url')" vid_length=$vid_length>
            <img src="$thumbnail" alt="$course_name" style="width:100%">
            <div class="desc">$title</div>
            </a>
              </div>
          </div>
          EOL;
          }

          ?>
    </div>
        <div style="margin-bottom:100px">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h4 style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;color:#030e4e;">Reference<h4>
              <?php 
                $sql = 'SELECT course_references FROM course_details where course_id=' . $course_id;
                $result = mysqli_query($db, $sql);
                foreach ($result as $r) {
                  echo $r['course_references'];
                  // <a href="https://devdocs.io/css/">CSS Reference Material</a>
                }
              ?>
            </div>
    <br>
    
    
    <!-- Courses offered -->
    
    <!-- </div> -->
    <div id="player_complete" class="player_background" onclick="document.getElementById('player_complete').style.display='none';document.getElementById('course_video').src = '';">
      
              <div class="video_player">
                <button type="button" onclick="document.getElementById('player_complete').style.display='none';document.getElementById('course_video').src = '';" class="player_close_button">X</button>
                <iframe id="course_video" width=100% height=100% src="https://www.youtube.com/embed/zPHerhks2Vg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
    </div>
                
        <?php
          $sql = "SELECT * FROM course_details";
          $result = mysqli_query($db,$sql);
          $courses_dropdown = "";
          
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