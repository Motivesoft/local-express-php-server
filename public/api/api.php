<?php
// api.php

require_once 'puzzle-collections.php';

// Set the content type to JSON
header('Content-Type: application/json');

// TODO Decide how and when we want to do things with authentication
session_start();
// if (!isset($_SESSION['user_id'])) {
//     http_response_code(401);
//     die(json_encode(["error" => "Unauthorized"]));
// }

// Get the request URI, query params, etc
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));
$queryParams = $_GET;

// We already know that the URI start with /api/ from the code in the router.
// Map the second part of the URI to a route in our array and call it with the
// remaining path and any query parameters
if (count($segments) > 1) {
    $response = '';
    switch ($segments[1]) {
        case 'version':
            $response = getVersion();
            break;

        case 'collections':
            $response = PuzzleCollectionsService::getCollections($queryParams);
            break;

        case 'collection-puzzle-list':
            $response = PuzzleCollectionsService::getCollectionPuzzleList($queryParams);
            break;

        default:
            // Return a 404 error for undefined routes
            http_response_code(404);
            $response = ['error' => 'Not Found'];
            // TODO Delete this: echo json_encode(['error' => 'Not Found']);
            break;
    }

    // Send the response
    echo json_encode($response);
} else {
    // Return a 404 error for undefined routes
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}

// Local API functions

// Function to return the version
function getVersion()
{
    return [
        'version' => '1.0.0',
        'lastUpdated' => '2025-03-17'
    ];
}
