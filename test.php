<?php

session_start();
include('return_data.php');
$data = return_data();
echo $data;
?>