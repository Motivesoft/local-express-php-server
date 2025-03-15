const express = require("express");
const path = require("path");
const phpExpress = require("php-express")({
  binPath: "php", // Path to the PHP executable
});

const app = express();
const port = 3000;

// Set the view engine to php-express
app.engine("php", phpExpress.engine);
app.set("views", path.join(__dirname, "public")); // Set the views directory
app.set("view engine", "php"); // Set the default view engine

// Serve static files from the "public" directory
app.use(express.static(path.join(__dirname, "public")));

// Set up PHP-Express middleware
app.use("/", phpExpress.router);

// Default to index.php instead of index.html
app.use((req, res, next) => {
  const requestedPath = path.join(__dirname, "public", req.path);

  // Check if the requested path is a directory
  if (req.path.endsWith("/")) {
    const indexPhpPath = path.join(requestedPath, "index.php");
    const indexHtmlPath = path.join(requestedPath, "index.html");

    // Check if index.php exists
    if (phpExpress.fileExists(indexPhpPath)) {
        return res.render(indexPhpPath); // Render the PHP file
    }
    
    // Fallback to index.html if index.php doesn't exist
    if (phpExpress.fileExists(indexHtmlPath)) {
      return res.sendFile(indexHtmlPath);
    }
  }

  // Continue to the next middleware if no index file is found
  next();
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});