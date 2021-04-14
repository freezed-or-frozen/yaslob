<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Controller file (C of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
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
    // Print the home/welcome page
    include("templates/home.php");
} else if ($action == "new") {
    // Print the new ebook page
    include("templates/new.php");
} else {
    // Print the home/welcome page by default
    include("templates/home.php");
}

?>