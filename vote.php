<?php 
/*
0 is downvote
1 is upvote
*/
session_start();
include('get_image.php');
$con = mysqli_connect("localhost","root","","mysql");

$action = mysqli_real_escape_string($con, htmlspecialchars($_GET['vote']));
$height = htmlspecialchars($_GET['height']);
$width = htmlspecialchars($_GET['width']);
if($action == 1 || $action == 0)
{
    $query = "";
    if($action == 1)
    {
        $query = "update showImages set upvote = upvote + 1 where image_path='" . $_SESSION['current_image'] . "'";        
    }
    if($action == 0)
    {    
        $query = "update showImages set downvote = downvote + 1 where image_path='" . $_SESSION['current_image'] . "'";
    }
    $res = mysqli_query($con,$query);
    $data = scale_my_image($height,$width);
    echo json_encode($data);
    
}
else{
    die();
}
