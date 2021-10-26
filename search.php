<?php


$type = $_REQUEST['type'];
$input = $_REQUEST['q'];
$input = strtolower($input);
$input = explode(' ', $input);

error_reporting(E_ERROR | E_PARSE);

try{
    include('config.php');
    $mysqli = new mysqli($host, $username, $password, $dbname);

    //$sql = "SELECT title,`url`,course_name,course_id FROM course_video OUTER JOIN course_details ON (course_video.course_id = course_details.course_id)";
    $sql = "SELECT title,course_id FROM course_video;";
    $result = mysqli_query($db, $sql);
    
    foreach($result as $r){
        $title = strtolower($r["title"]);
        $course_id = $r["course_id"];
        $url = "http://localhost/course_enroll.php?course_id=" . $course_id;
        

        foreach($input as $word){
          if(strpos($title, $word) !== false){
            //echo "<a href=''>sucess</a>";
            if(strlen($title) > 30)
                $title = substr($title,0,30) . "...";
            echo "<a href='$url'>$title</a>";
            }  
        }
    }
    $mysqli->close();
} 
catch (PDOException $error){
//echo "<script>alert(\"Failed \")</script>";
echo 'connect failed:'.$error->getMessage();
}

?>