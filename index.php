<?php
include('templates/header.php');
error_reporting(0);
error_reporting(E_ALL);

include('./config/db_connection.php');

date_default_timezone_set('MST');
$today = date("F j, Y, g:i a");

$city_name = $temperature = $overview = '';
$weathers = array('city_name' => '', 'temperature' => '', 'overview' => '');
// print_r($weathers);
$sql = 'SELECT city_name, temperature, overview FROM city_weather ORDER BY saved_time';

$weatherArray = $tempF = $name = $weather = $humidity = $feels_like = $wind_speed = $save  = '';

if (array_key_exists('submit', $_POST)) {

    // checking if input is empty
    if (!$_POST['city_name']) {
        $error = "Please enter a valid city";
    }

    if ($_POST['city_name']) {
        $apiCall = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . $_POST['city_name'] . "&appid=d61e6c3f32b672ef640a1eeab500b0dc");
        $weatherArray = json_decode($apiCall, true);
        //F = (K − 273.15) × 1.8 + 32
        $tempF = floor(($weatherArray['main']['temp'] - 273.15) * 1.8 + 32);
        $name = $weatherArray['name'] . ", " . $weatherArray['sys']['country'];
        $weather = $weatherArray['weather']['0']['description'];
        $humidity = $weatherArray['main']['humidity'];
        $feels_like = floor(($weatherArray['main']['feels_like'] - 273.15) * 1.8 + 32);
        $wind_speed = floor($weatherArray['wind']['speed']);

        /////////////////////////////////////////
        //////////HOURLY API CALL !!/////////////
        /////////////////////////////////////////

        //     extracting lat/lon to find the hourly forecast
        //     $lat = $weatherArray['coord']['lat'];
        //     $l//on = $weatherArray['coord']['lon'];
        //     // print($lat);
        //     // print($lon);

        //     $hourlyApiCall = file_get_contents("https://pro.openweathermap.org/data/2.5/forecast/hourly?lat=" . $lat . "&lon=" . $lon . "&appid=d61e6c3f32b672ef640a1eeab500b0dc");
        //     $hourlyArray = json_decode($hourlyApiCall, true);
        //     print_r($hourlyArray);

        $_POST['temperature'] = $tempF;
        $_POST['overview'] = $weather;

        $sql = "INSERT INTO city_weather (city_name, temperature, overview) VALUES('$_POST[city_name]', '$tempF', '$weather')";

        if (mysqli_query($conn, $sql)) {
            echo 'sucess !';
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<body>
    <!-- SEARCH/Clear History SECTION -->
    <div>
        <div class="d-flex flex-column align-items-center text-center mt-3">
            <div class="d-flex row align-items-center justify-content-center ">
                <div class="col-12"></div>
                <h2 class="search-header my-1 text-white" id="date"><b><?php echo $today ?></b> </h2>

                <div class="row align-items-center">
                    <form id="city-name" method="POST">
                        <input name="city_name" type="text" class="form-control form-block order-dark rounded-3" placeholder="Where are you?">
                        <input type="submit" name="submit" value="Submit" class="btn btn-dark mt-2">
                    </form>

                </div>


                <div>
                    <?php if ($weather) { ?>
                        <div class="alert alert-dark" role="alert">
                            <h5> <b><?php echo $name  ?></b> </h5>
                            <ul id="weather-list">
                                <li><?php echo $tempF ?>°F</li>
                                <li><b><?php echo ucwords($weather) ?></b>
                                </li>
                                <li><b>Humidity: </b><?php echo $humidity ?>%</li>
                                <li><b>Feels like: </b><?php echo $feels_like ?>°F</li>
                                <li><b>Wind Speed: </b><?php echo $wind_speed ?>m/s</li>
                            </ul>

                            <form method=" POST">
                                <input name="city_name" type="hidden"></input>
                                <input name="temperature" type="hidden"></input>
                                <input name="overveiw" type="hidden"></input>
                                <input type="submit" name="save" value="Save" class="btn btn-light"></input>
                            </form>
                        </div>
                        <!-- MAKE FORM TAGS FOR  -->
                        <!-- <form id="temperature" method="POST"> -->


                    <?php } ?>

                </div>

            </div>
            <!-- INSERT HOURLY DATA HERE  -->
            <?php include('./hourly.php') ?>
        </div>
    </div>

</body>

</html>