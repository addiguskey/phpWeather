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
        // print_r($weatherArray);
        //F = (K − 273.15) × 1.8 + 32
        $tempF = floor(($weatherArray['main']['temp'] - 273.15) * 1.8 + 32);
        $name = $weatherArray['name'] . ", " . $weatherArray['sys']['country'];
        $weather = $weatherArray['weather']['0']['description'];
        $humidity = $weatherArray['main']['humidity'];
        $feels_like = floor(($weatherArray['main']['feels_like'] - 273.15) * 1.8 + 32);
        $wind_speed = floor($weatherArray['wind']['speed']);

        $_POST['temperature'] = $tempF;
        $_POST['overview'] = $weather;

        $sql = "INSERT INTO city_weather (city_name, temperature, overview) VALUES('$_POST[city_name]', '$tempF', '$weather')";

        if (mysqli_query($conn, $sql)) {
            // echo 'sucess !';
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
    ///////////////////////////////////////
    ////////HOURLY API CALL !!/////////////
    ///////////////////////////////////////

    // extracting lat/lon to find the hourly forecast
    $lat = $weatherArray['coord']['lat'];
    $lon = $weatherArray['coord']['lon'];
    // print($lat);
    // print($lon);

    $hourlyApiCall = file_get_contents("https://api.openweathermap.org/data/2.5/forecast?lat=" . $lat . "&lon=" . $lon . "&appid=464770d8a5748695dded85cb88f43e87");
    // print_r($hourlyApiCall);
    $hourlyArray = json_decode($hourlyApiCall, true);
    // echo json_encode($hourlyArray);

    ////////HOUR 3////////
    $hour3temp = floor((($hourlyArray['list']['1']['main']['temp'] - 273.15) * 1.8 + 32));
    $hour3desc = ucwords($hourlyArray['list']['1']['weather']['0']['description']);
    $hour3icon = " http://openweathermap.org/img/wn/" . $hourlyArray['list']['1']['weather']['0']['icon'] . "@2x.png";

    ////////HOUR 6////////
    $hour6temp = floor((($hourlyArray['list']['2']['main']['temp'] - 273.15) * 1.8 + 32));
    $hour6desc = ucwords($hourlyArray['list']['2']['weather']['0']['description']);
    $hour6icon = " http://openweathermap.org/img/wn/" . $hourlyArray['list']['2']['weather']['0']['icon'] . "@2x.png";

    ////////HOUR 9////////
    $hour9temp = floor((($hourlyArray['list']['3']['main']['temp'] - 273.15) * 1.8 + 32));
    $hour9desc = ucwords($hourlyArray['list']['3']['weather']['0']['description']);
    $hour9icon = " http://openweathermap.org/img/wn/" . $hourlyArray['list']['3']['weather']['0']['icon'] . "@2x.png";

    ////////HOUR 12////////
    $hour12temp = floor((($hourlyArray['list']['4']['main']['temp'] - 273.15) * 1.8 + 32));
    $hour12desc = ucwords($hourlyArray['list']['4']['weather']['0']['description']);
    $hour12icon = " http://openweathermap.org/img/wn/" . $hourlyArray['list']['4']['weather']['0']['icon'] . "@2x.png";

    ////////HOUR 15////////
    $hour15temp = floor((($hourlyArray['list']['5']['main']['temp'] - 273.15) * 1.8 + 32));
    $hour15desc = ucwords($hourlyArray['list']['5']['weather']['0']['description']);
    $hour15icon = " http://openweathermap.org/img/wn/" . $hourlyArray['list']['5']['weather']['0']['icon'] . "@2x.png";
}


?>

<!DOCTYPE html>
<html lang="en">

<body>
    <!-- SEARCH/Clear History SECTION -->
    <div>
        <div class="d-flex flex-column align-items-center text-center ">
            <div class="d-flex row align-items-center justify-content-center ">
                <div class="col-12"></div>
                <h2 class="search-header text-white" id="date"><b><?php echo $today ?> (MST)</b> </h2>

                <div class="row align-items-center">
                    <form id="city-name" method="POST">
                        <input name="city_name" type="text" class="form-control form-block order-dark rounded-3" placeholder="Where are you?">
                        <input type="submit" name="submit" value="Submit" class="btn btn-dark mt-2">
                    </form>

                </div>


                <div>
                    <?php if ($weather) { ?>
                        <div class="alert alert-dark border-0" role="alert">
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
            <!-- THREE HOURLY FORECAST -->
            <?php if ($weather) { ?>
                <div>

                    <h3 class="text-center text-white mt-3 p-2"><b> 3 Hour Forecast</b></h3>
                    <div class="card-group border-0 p-2">
                        <!-- CARD 1 -->
                        <div class="card bg-light " id="card1">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $hour3temp ?>°F</h5>
                                <img src="<?php echo $hour3icon ?>" class="card-img-top" alt="hour3">
                                <p class="card-text align-items-center"><?php echo $hour3desc ?></p>
                            </div>
                        </div>
                        <!-- CARD 2 -->
                        <div class="card bg-light" id="card2">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $hour6temp ?>°F</h5>
                                <img src="<?php echo $hour6icon ?>" class="card-img-top" alt="hour3">
                                <p class="card-text align-middle"><?php echo $hour6desc ?></p>
                            </div>
                        </div>
                        <!-- CARD 3 -->
                        <div class="card bg-light" id="card3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $hour9temp ?>°F</h5>
                                <img src="<?php echo $hour9icon ?>" class="card-img-top" alt="hour3">
                                <p class="card-text"><?php echo $hour9desc ?></p>
                            </div>
                        </div>
                        <!-- CARD 4 -->
                        <div class="card bg-light" id="card4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $hour12temp ?>°F</h5>
                                <img src="<?php echo $hour12icon ?>" class="card-img-top" alt="hour3">
                                <p class="card-text"><?php echo $hour12desc ?></p>
                            </div>
                        </div>
                        <!-- CARD 5 -->
                        <div class="card bg-light" id="card5">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $hour15temp ?>°F</h5>
                                <img src="<?php echo $hour15icon ?>" class="card-img-top" alt="hour3">
                                <p class="card-text"><?php echo $hour15desc ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include("./templates/footer.php") ?>