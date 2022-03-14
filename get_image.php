<?php
session_start();
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 1;
}

function scale_my_image($height, $width)
{

    $con = mysqli_connect("localhost", "root", "yrk27242621", "mysql");
    $query = "SELECT * FROM showImages WHERE id='" . $_SESSION['id'] . "'";

    $res = mysqli_query($con, $query);
    $res = mysqli_fetch_assoc($res);

    if ($_SESSION['id'] < 10) {
        $_SESSION['id']++;
    } else if ($_SESSION['id'] == 10) {
        $_SESSION['id'] = 1;
    }
    $max_width = $width / 2;
    $max_height = $height /2;
    $path = $res['image_path'];

    $img = getimagesize("$path");

    $_SESSION['current_image'] = $path;

    $old_width  = $img[0];
    $old_height = $img[1];
    $scale      = min($max_width / $old_width, $max_height / $old_height);

    $new_width  = ceil($scale * $old_width);
    $new_height = ceil($scale * $old_height);
    $_SESSION['new_height'] = $new_height;
    $_SESSION['new_width'] = $new_width;
    $path = trim($path, "/srv/http");

    $value = array("path" => "/" . $path, "height" => $_SESSION['new_height'], "width" => $_SESSION['new_width']);
    return $value;
}
function return_data()
{
    $arr = array();
    $h = htmlspecialchars($_GET['height']);
    $w = htmlspecialchars($_GET['width']);
    for ($i = 0; $i < 2; $i++) {
        $data = scale_my_image($h, $w);
        $arr[$i] = array("image_path" => $data['path'], "height" => $data['height'], "width" => $data['width']);
    }
    echo json_encode($arr);
}
