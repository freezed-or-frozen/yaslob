<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Configuration file
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */

 
// Base URL
define("BASE_URL", "http://127.0.0.1/yaslob");

// Path to XML database
define("DATABASE_PATH", "../yaslob_data/db/ebooks.xml");

// Path to ebook cover images
define("COVERS_PATH", "../yaslob_data/covers");

// Path to ebook pdf
define("EBOOKS_PATH", "../yaslob_data/ebooks");

// Maximum number of ebooks in the front page
define("MAX_EBOOKS_NUMBER", 5);

// File size limit (in bytes)
define("FILE_SIZE_LIMIT", 100000000);

// Admin credentials
define("ADMIN_LOGIN", "admin");
define("ADMIN_PASSWORD", "p4ssw0rd");
?>