<?php
   include("config.php");
   session_start();
   error_reporting(E_ERROR | E_PARSE);
   if(!isset($_SESSION['login_user']))
   {
      echo "<script>alert('Please log in first!');
                window.location.href='index.php'</script>";
    }
    // Check if user is already enrolled in course
    // If enrolled, take to course page
    // Else show option to enroll
    include("config.php");
    $username = $_SESSION['login_user'];
    $course_id = $_REQUEST['course_id'];
    $sql = "SELECT `user_id` FROM user_details WHERE username = '$username';";
    $result = mysqli_query($db,$sql);
    foreach ($result as $r) {
        # Do NOT remove this!!!
    }

    $user_id = $r['user_id'];

    $sql = "SELECT `user_id` FROM registrations WHERE `user_id` = '$user_id' and course_id = '$course_id';";
    $result = mysqli_query($db,$sql);
    $count = mysqli_num_rows($result);
    $sql = "SELECT * FROM course_details where course_id = '$course_id'";
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) == 0) {
      echo "<div id='load_bg' style='backdrop-filter: blur(6px);height:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,0.7);width:100%;'><h1 style='color:white;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Invalid course!</h1><h2 style='color:grey;text-align:center'>Taking you to index in 3s...</h2>
      <div class='loader' style='border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #df2b2b;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
      margin-left:auto;
      margin-right:auto;
      '></div>
      <style>
      
      .navigation-bar {display:none;}
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
      .sub_header {
        background-color: rgba(180, 228, 235,0.2);
      </style>
      </div>";
      echo "<script>
      function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      }
      async function redirect() {
        await sleep(3000);
        window.location = 'index.php';
        }
      redirect();
      </script>";
    }
    foreach ($result as $r) {
        # code... 
    }
    $course = $r;
    $course_img = $r['course_img_url'];
    if($count != 0 && isset($_REQUEST['unenroll']) && $_REQUEST['unenroll'] ==true) {
        $_SESSION['auth_course_id'] = $course_id;
        // echo "<script>alert('WELCOME TO COURSE');</script>";
        $sql = 'DELETE FROM registrations WHERE `user_id`=' . $user_id . ' and course_id=' . $course_id;
        $result = mysqli_query($db, $sql);
        if(!$result)
        {
            echo mysqli_error($db);
            echo "<div id='load_bg' style='backdrop-filter: blur(6px);height:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,0.7);width:100%;'><h1 style='color:white;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Unenroll failed! Please try again. $user_id , $course_id</h1><h2 style='color:grey;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Redirecting in 3s...</h2>
            <div class='loader' style='border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #df2b2b;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin-left:auto;
            margin-right:auto;
            '></div>
            <style>
            
            .navigation-bar {display:none;}
            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
            .sub_header {
              background-color: rgba(180, 228, 235,0.2);
            </style>
            </div>";
            echo "<script>
            function sleep(ms) {
              return new Promise(resolve => setTimeout(resolve, ms));
            }
            async function redirect() {
              await sleep(3000);
              window.location = 'course_page.php?course_id=$course_id';
              }
            redirect();
            </script>";
            die();
        }
        else
        {
            echo "<div id='load_bg' style='backdrop-filter: blur(6px);height:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,0.7);width:100%;'><h1 style='color:white;text-align:center'>Unenroll success.</h1><h2 style='color:grey;text-align:center'>Taking you to homepage in 3s...</h2>
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
            
            .navigation-bar {display:none;}
            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
            .sub_header {
              background-color: rgba(180, 228, 235,0.2);
            </style>
            </div>";
            echo "<script>
            function sleep(ms) {
              return new Promise(resolve => setTimeout(resolve, ms));
            }
            async function redirect() {
              await sleep(3000);
              window.location='index.php';
              }
            redirect();
            </script>";
        } 

    }
    elseif($count != 0) {
        $_SESSION['auth_course_id'] = $course_id;
        // echo "<script>alert('WELCOME TO COURSE');</script>";
        header('Location: course_page.php?course_id=' . $course_id);
    }
    else {
        if(isset($_REQUEST['enroll']) && $_REQUEST['enroll'] ==true) {
            
            $sql = 'INSERT INTO registrations(`user_id`,course_id) values (\'' . $user_id . '\',\'' . $course_id . '\')';
            $result = mysqli_query($db, $sql);
            
            if(!$result)
            {
                echo mysqli_error($db);
                echo "<div id='load_bg' style='backdrop-filter: blur(6px);height:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,0.7);width:100%;'><h1 style='color:white;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Enroll failed! Please try again.</h1><h2 style='color:grey;text-align:center'>Redirecting in 3s...</h2>
                <div class='loader' style='border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #df2b2b;
                width: 120px;
                height: 120px;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
                margin-left:auto;
                margin-right:auto;
                '></div>
                <style>
                
                .navigation-bar {display:none;}
                @keyframes spin {
                  0% { transform: rotate(0deg); }
                  100% { transform: rotate(360deg); }
                }
                .sub_header {
                  background-color: rgba(180, 228, 235,0.2);
                </style>
                </div>";
                echo "<script>
                function sleep(ms) {
                  return new Promise(resolve => setTimeout(resolve, ms));
                }
                async function redirect() {
                  await sleep(3000);
                  window.location = 'index.php';
                  }
                redirect();
                </script>";
                die();
            }
            else
            {
                echo "<div id='load_bg' style='backdrop-filter: blur(6px);height:100%;position:fixed;top:0;left:0;background-color:rgba(0,0,0,0.7);width:100%;'><h1 style='color:white;text-align:center'>Enroll success.</h1><h2 style='color:grey;text-align:center'>Taking you to course page in 3s...</h2>
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
                
                .navigation-bar {display:none;}
                @keyframes spin {
                  0% { transform: rotate(0deg); }
                  100% { transform: rotate(360deg); }
                }
                .sub_header {
                  background-color: rgba(180, 228, 235,0.2);
                </style>
                </div>";
                echo "<script>
                function sleep(ms) {
                  return new Promise(resolve => setTimeout(resolve, ms));
                }
                async function redirect() {
                  await sleep(3000);
                  window.location='course_page.php?course_id=" . $course_id . "';
                  }
                redirect();
                </script>";
            } 


        }
        else
        {
        // echo "<script>alert('Please enroll first!');</script>";
        // echo "You are not enrolled!";
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


                <div class="sub_header" style="background-color: rgba(180, 228, 235, 0.2);padding-top:120px;padding-bottom:1px;border-bottom: solid 2px rgba(0, 0, 0, 0.247);box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                  <!-- <iframe src="python.html" frameborder="1" width="300" height="300" title="frame"></iframe> -->
                  <h1 id="welcome_msg" style="font-weight: bold;color: #030e4e;">
                    <?php
            if(!isset($_SESSION['login_user'])) {
              echo "Welcome to Webcoursera";
            }
            else {
              echo "Welcome, " . $_SESSION['login_user'] . ", Let's start learning.";
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
          <?php
            $course_name = $course['course_name'];
            $course_sub = $course['course_subtitle'];
            $course_description = $course['course_description'];
            echo <<<EOL
            <img src='$course_img' style='height:100px;width:auto;float:left;margin-right:20px;'>
            <h2 style="color:rgb(0, 73, 95);font-weight: bold;">
            $course_name
            </h2>
            <div>
            <button id='enroll_btn' style='float:left' onclick="window.location.href='course_enroll.php?course_id=$course_id&enroll=true'">Enroll</button>
            EOL;
            try{
              include('config.php');
              $mysqli = new mysqli($host, $username, $password, $dbname);
          
              $sql = "SELECT user_id FROM registrations WHERE course_id=$course_id";
              $result = mysqli_query($db, $sql);
              $c = mysqli_num_rows($result);
              
              
              echo "<h4 style='color:rgb(73, 73, 95);font-weight: bold;padding-top:25px'>" . $c . " users currently enrolled.<br></h4></div>";

              $mysqli->close();
            } 
            catch (PDOException $error){
              echo "<script>alert(\"Hello Failure\")</script>";
              echo 'connect failed:'.$error->getMessage();
            };
            echo <<<EOL
            <br>
            <br>
            <div class='subtitles' style='padding-left:20px'>
            <h3 style="color:rgb(0, 73, 95);font-weight: bold;">
            $course_sub
            </h3>
            <h4 style="color:rgb(0, 73, 95);font-size:15px">
            $course_description
            </h4>
            </div>

            EOL
            ?>
            <!--  Course enrolled number printed -->
            <?php 
            
            
            ?>

        <!-- Fill course details -->
        <?php
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

        <!-- Footer -->
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