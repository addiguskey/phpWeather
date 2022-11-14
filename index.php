<?php


include('./config/db_connect.php');

$sql = 'SELECT id, city_name, city_time FROM weather';

//MKAE QUERY AND GET RESULT
$result = mysqli_query($conn, $sql);

//FETCH THE RESULTRING ROW AS AN ASSOCIATIVE ARRAY
$weather = mysqli_fetch_all($result, MYSQLI_ASSOC);

//FREE RESULTS FROM MEM
mysqli_free_result($results);

//close connection
mysqli_close($conn);

//print array
print_r($weather)
?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<?php include('templates/footer.php') ?>


</html>