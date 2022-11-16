<?php

if (array_key_exists('save', $_POST)) {

    if (isset($_POST['city_name'], $_POST['temperature'], $_POST['overview'])) {
        $city_name  = $_POST['city_name'];
        $temperature = $_POST['temperature'];
        $overview = $_POST['overview'];
        //create sql query
        $sql = "INSERT INTO city_weather (city_name, temperature, overview) VALUES('$city_name', '$teperature', '$overview')";
        //save the db 
        if (mysqli_query($conn, $sql)) {
            echo 'sucess !';
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}


/////////////////////////////////////
//////////////RECOMMENT//////////////
/////////////////////////////////////
//THIS WAS NESTED ALL WITHIN THE SUBMIT BUTTON

$city_name  = $_POST['city_name'];
if (isset($_POST['temperature'])) {
    echo 'hello i am temp';
};
$temperature = $_POST['temperature'];
$overview = $_POST['overview'];
//create sql query
$sql = "INSERT INTO city_weather (city_name, temperature, overview) VALUES('$city_name', '$teperature', '$overview')";
//save the db 

if (mysqli_query($conn, $sql)) {
    echo 'sql connection sucess !';
} else {
    echo 'query error: ' . mysqli_error($conn);
}
