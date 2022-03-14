<?php 
session_start();
$_SESSION['height'] = htmlspecialchars($_GET['height']);
$_SESSION['width'] = htmlspecialchars($_GET['width']);


$image = "/Tinder like clone/saturn_high.png";
$max_width = $_SESSION['height'] / 2;
$max_height = $_SESSION['height'];

$img = getimagesize("/saturn_high.png");
var_dump($img);
// Get current dimensions
$old_width  = $img[0];
$old_height = $img[1];

// Calculate the scaling we need to do to fit the image inside our frame
$scale      = min($max_width/$old_width, $max_height/$old_height);

// Get the new dimensions
$new_width  = ceil($scale*$old_width);
$new_height = ceil($scale*$old_height);
$_SESSION['new_height'] = $new_height;
$_SESSION['new_width'] = $new_width;
//echo "<img src='$image' height='" . $new_height . "' width='" .$new_width . "'";
