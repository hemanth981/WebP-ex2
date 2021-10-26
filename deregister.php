


<?php
    session_start();
    if(!isset($_SESSION['login_user'])) {
        header("Location: index.php");
    }
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST["dereg"]) && $_POST["dereg"]){
        $user_name = $_SESSION['login_user'];
        
    
        try{
            include('config.php');
            
        
            $sql1 = "DELETE FROM registrations WHERE user_id = (SELECT user_id FROM user_details WHERE username = '$user_name')";
            $result = mysqli_query($db, $sql1);
            
            $sql2 = "DELETE FROM user_details WHERE username = '$user_name'";
            $result = mysqli_query($db, $sql2);
            
            session_unset();
            header("Location: index.php");
        } catch (PDOException $error){
            //echo "<script>alert(\"Hello Failure\")</script>";
            echo 'connect failed:'.$error->getMessage();
            }
    }
    else {
            echo "<script>
            alert('Cancelled.')
            window.location.href='index.php'
            </script>";

    }
}
?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Deregister
        </title>
        <link rel="stylesheet" href="homepage_styles.css">
        <script src="index_js.js"></script>
        <style>
            body {
                background-image: url('static/img/1.png');
                /* min-width: fit-content; */
                margin:0;
                padding:0;
            }
            .bg_blur {
                background-color: rgba(31, 31, 31, 0.603);
                /* background-color: red; */
                backdrop-filter: blur(6px);
                /* padding:-8px; */
                left: 0;
                right:0;
                top:0;
                bottom:0;
                padding-top:150px;
                /* margin:-8px; */
                width: 100%;
                height: calc(100% - 150px);;
                margin-top: -35px;
            }
            .navigation-bar {
                position: absolute;
            }
            .confirm_dialog {
                width:400px;
                height:200px;
                margin-top: 700px;
                left:auto;
                right: auto;
                top:100p;
                bottom:auto;
                margin: auto;
                background-color: rgba(40, 192, 210, 0.39);
                /* backdrop-filter: blur(6px); */
                border-radius: 20px;

            }
            .dialog_content {
                color: white;
                /* padding-top: 20px; */
                padding: 20px;
            }
            
            .dialog_content p {
                color: white;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 20px;
            }
            .dialog_actions {
                margin-top: 10px;
                padding-left: 20px;
            }
            .dialog_actions button {
                /* padding-top: 40px; */
                width: 80px;
                border-radius: 10px;
                border: none;
                padding: 10px;
            }

        </style>
    </head>
    <body>
        <?php
            include "navbar.php";
        ?>
        <div class="bg_blur">
            <div class='confirm_dialog'>
                <div class='dialog_content'>
                    <p>Confirm deregister?</p>
                    <form method="POST" action="deregister.php">
                        <label class="container_checkbox" >I accept to deregister myself, and <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I know that this action is irreversible.
                          <input type="checkbox" name="dereg" id="dereg">
                          <span class="checkmark"></span>
                        </label>
                        <div class="dialog_actions">
                            <button type="Submit">Proceed</button>
                            <button onclick="document.getElementById('dereg').checked=false" name='cancel'>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>

 
