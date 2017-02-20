<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Parsing connnection string
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_") !== 0) {
        continue;
    }

    $servername = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $username = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $password = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Create query
$sql = "SELECT id, city_ascii, lat, lng FROM cities";
$result = $conn->query($sql);

$arr = "{\"cities\": [";

if ($result->num_rows > 0) {
    // output data of each row
    for ($x = 0; $x < mysqli_num_rows($result); $x++) {
        $data = mysqli_fetch_assoc($result);
        $arr .= "{\"city\":\"" . $data['city_ascii'] . "\",\"lat\": " . $data["lat"] . ",\"lng\": " . $data["lng"] . "},";
        //echo $data;
    }
    $arr = substr($arr, 0, -1);
    $arr .= "]}";
    echo $arr; 
} else {
    echo "0 results";
}
?>