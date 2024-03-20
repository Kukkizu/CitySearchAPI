<?php

    /*if (isset($_SERVER['HTTP_ORIGIN'])) {
        // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a whitelist of safe origins
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    }*/

    header("Access-Control-Allow-Origin: *");

    if (!isset($_GET['key'])) {
        http_response_code(401); // Bad Request
        die('Key required');
    }

    $apiKey = "";

    if ($_GET['key'] != $apiKey) {
        http_response_code(403); // Bad Request
        die('Key invalid');
    }

    if (!isset($_GET['q'])) {
        http_response_code(400); // Bad Request
        die('Query not entered.');
    }

    // Load the JSON data into a PHP array
    $americanCities = json_decode(file_get_contents('uscities.json'), true);

    // Get the search query parameter from the URL
    $searchQuery = $_GET['q'];

    // Initialize an array to store matched cities
    $matchedCities = [];

    // Perform case-insensitive search for matching cities
    $limit = 15;

    $count = 0;
    foreach ($americanCities as $city) {
        if (strtolower($searchQuery) === strtolower(substr($city, 0, strlen($searchQuery)))) {
            $matchedCities[] = $city;
            $count++;
        }
        if ($count == $limit) {
            break;
        }
    }


    // Return the matched cities as JSON
    header('Content-Type: application/json');
    echo json_encode($matchedCities, JSON_UNESCAPED_UNICODE);


?>
