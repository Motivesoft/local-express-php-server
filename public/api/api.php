<?php
// api.php

// Set the content type to JSON
header('Content-Type: application/json');

// Define the API routes
$routes = [
    '/api/version' => 'getVersion'
];

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];

// Check if the route exists
if (array_key_exists($requestUri, $routes)) {
    $functionName = $routes[$requestUri];
    $response = $functionName();
    echo json_encode($response);
} else {
    // Return a 404 error for undefined routes
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}

// Function to return the version
function getVersion() {
    return [
        'version' => '1.0.0',
        'lastUpdated' => '2025-03-17'
    ];
}
