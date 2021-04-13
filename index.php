<?php
/**
 * YASLOB
 * Controller file (C of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @licence MIT
 */

// Include configuration and database
include("config.php");
include("db.php");


// Get parameters from URL
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = NULL;
}


// Router : choose action to do
if ($action == "welcome") {
    // Print the welcome page
    include("templates/welcome.php");
} else {
    // Print the welcome page by default
    include("templates/welcome.php");
}

?>