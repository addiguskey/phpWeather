<?php

$conn = mysqli_connect('localhost', 'addi', 'udon', 'us_weather');
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
};
