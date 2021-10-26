     <!-- Navigation Bar -->
     <ul class="navigation-bar" id='id1navig' onmouseout="hide_classes()">
        <li>
          <a href="index.php">
            <i class="glyphicon glyphicon-home"></i>
            Home
          </a>
        </li>
        <li class="dropdown" onmouseover = "display_classes()" onclick="show_classes()">
          <span class = "menu_header" onmouseover = "display_classes()">
            <i class="glyphicon glyphicon-menu-hamburger" onmouseover = "display_classes()"></i>
            Classes
          </span>
          <!-- </a> -->
        </li>
                <li class="search-box">
                  <!-- <i class="glyphicon glyphicon-menu-hamburger search-box-icon1"></i> -->
                  <!-- <form method="POST" > -->
                    <div class="inner-addon left-addon">
                      <input type="text" id="search_global" name="search_query" onkeyup = "showSearch(this.value)">
                      <button onclick="showSearch(document.getElementById('search_global').value)"><i class="glyphicon glyphicon-search" onclick="$(this).closest('form').submit()"></i></button>
                    </div>
                  <!-- <input type="text" placeholder="Search.."> -->
                  <!-- <li>
                    <button type="submit" name="search_btn" style="height:50px;width:50px;border:none;background-color:black;" ><i class="glyphicon glyphicon-search"></i></button>
                  </li> -->
                <!-- </form> -->
              </li>
              
              
              <!-- Align to right -->
              <li class="navbar-right">
                <div class="user_access" id="user_access_1">
                  <a onclick="document.getElementById('user_auth').style.display='block';document.getElementById('login_signup').innerHTML='Login';document.getElementById('id_is_signup').checked=false"><i class="glyphicon glyphicon-user"></i> Login</a>
                    
                  <a href="register.php?redirect_url=index.php">
                    <i class="glyphicon glyphicon-pencil"></i>
                    Sign up
                  </a>
                </div>

                <div class="logout_nav" id="logout_nav_1" style="display:none;">
                <a onmouseover="display_user_details()" onmouseout="hide_user_details()" style="width:100px">
                <i class="glyphicon glyphicon-user"></i>
                  <?php
                  echo $_SESSION['login_user'];
                  ?>
                </a>
                </div>

                </li>

                <!-- Registered users hover button -->
                <li class="regd_users navbar-right" id="regd_users" style="background-color:black;cursor:default" onmouseover="display_regd_users()" onmouseout="hide_regd_users()">
                  <a style="background-color: rgba(17, 17, 17, 0.438);">Users</a>
                </li>

                <?php
          if(isset($_SESSION['login_user'])){
            echo("<script>document.getElementById('user_access_1').style='display:none'</script>");
            echo("<script>document.getElementById('logout_nav_1').style='display:block'</script>");
            echo("<script>document.getElementById('logout_nav_1').style='display:block'</script>");
            
          }
          ?>
                  <!-- Expand menu (For small screens) -->
                  <a href="javascript:void(0);" class="icon_hamburger" onclick="expand_navbar()">
                    <i class="glyphicon glyphicon-menu-hamburger"></i>
                  </a>
                </ul>
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
                    echo "<a href='deregister.php?confirm=false' class='deregister_link' style='color:white'>Deregister</a>";
                    echo "<a style='height:3px'></a>";
                    echo "<a href='logout.php' class='logout_link' style='color:black;height:40px'><i class='glyphicon glyphicon-log-out'></i>  Logout</a>";
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
