<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Database class tests
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */

// Include configuration and database
include("config.php");
include("db.php");


/**
 * Print something for debug purpose
 */
function printToDebug($something) {
    echo "<pre>";
    var_dump($something);
    echo "</pre>";
}


// Unit test
$db = new EbooksDB(DATABASE_PATH);

$ebooks = $db->getEbooks();
printToDebug($ebooks);

$tags = $db->getTags(2);
printToDebug($tags);

?>