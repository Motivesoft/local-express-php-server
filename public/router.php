<?php
// Get the requested URI and test whether it is valid and to continue routing
//   - Route API stuff to its own handler
//   - Turn a directory request into a index file request
//   - Test file existence by stripping any query params from the end and serving the page
//   - Otherwise, show a 404
$requestUri = $_SERVER['REQUEST_URI'];
$documentRoot = __DIR__;
$filePath = $documentRoot . parse_url($requestUri, PHP_URL_PATH);

// Check if it's an API request
if (strpos($requestUri, '/api/') === 0) {
    include 'api/api.php';
    return true;
}

// Serve an index file if the navigation path is to a directory
if (is_dir($filePath)) {
    if (file_exists($filePath . '/index.php')) {
        include $filePath . '/index.php';
        return;
    } elseif (file_exists($filePath . '/index.html')) {
        return false; // Let the built-in server serve the static HTML file
    }
}

// Check if the requested file exists
if (file_exists($filePath) && !is_dir($filePath)) {
    // Serve the requested file
    return false;
} else {
    // Serve a custom 404 page for missing files
    http_response_code(404);
    include '404.php'; // Ensure you have a 404.php file in the same directory
}
