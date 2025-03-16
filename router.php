<?php
// router.php - Main routing file
chdir(__DIR__);
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseDir = realpath(__DIR__ . '/public');
$allowedExtensions = ['php', 'html', 'css', 'js', 'png', 'jpg'];

// Define primary routes
$routes = [
    '/auth' => __DIR__ . '/public/auth-system',
    '/api' => __DIR__ . '/api',
];

// Try primary routes first
foreach ($routes as $route => $dir) {
    if (strpos($requestUri, $route) === 0) {
        $filePath = realpath($dir . substr($requestUri, strlen($route)));
        
        // Security check
        if ($filePath && strpos($filePath, realpath($dir)) === 0) {
            if (is_file($filePath)) {
                // Serve existing files directly
                if (in_array(pathinfo($filePath, PATHINFO_EXTENSION), $allowedExtensions)) {
                    return false; // Let PHP server handle
                }
                readfile($filePath);
                exit;
            }
            
            // Try index.php in directory
            $indexFile = realpath($dir . '/index.php');
            if ($indexFile) {
                include $indexFile;
                exit;
            }
        }
    }
}

// Fallback to main-content directory
$fallbackPath = realpath($baseDir . $requestUri);

// Security checks
if ($fallbackPath && 
    strpos($fallbackPath, $baseDir) === 0 &&
    is_file($fallbackPath) &&
    in_array(pathinfo($fallbackPath, PATHINFO_EXTENSION), $allowedExtensions)) {
    
    // Serve allowed file types
    if (pathinfo($fallbackPath, PATHINFO_EXTENSION) === 'php') {
        include $fallbackPath;
    } else {
        readfile($fallbackPath);
    }
    exit;
}

// Final fallback: 404 handling
http_response_code(404);
include realpath($baseDir . '/404.php') ?: __DIR__ . '/404.php';
exit;

// To start server: php -S localhost:8000 router.php
