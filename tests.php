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

echo "<h1>getLastEbooks</h1>";
$ebooks = $db->getLastEbooks(5);
printToDebug($ebooks);

echo "<h1>getAllTags</h1>";
$tags = $db->getAllTags();
printToDebug($tags);

echo "<h1>getTagsStartingWith</h1>";
$tagsAutoComplete = $db->getTagsStartingWith("cr");
printToDebug($tagsAutoComplete);

echo "<h1>addNewEbook</h1>";
$result = $db->addNewEbook(
    "Tchoupi à la plage",
    "Thierry BIDULE",
    "Un super bouqin",
    "2000",
    11,
    "tchoupi-a-la-plage",
    0,
    0,
    "enfant,tchoupi,histoire"
);
printToDebug($result);

/*
$tags = $db->getTags(2);
printToDebug($tags);


$tagsAutoComplete = $db->getTagsStartingWith("pro");
printToDebug($tagsAutoComplete);


$ebooks = $db->getEbooksByTag("programming");
printToDebug($ebooks);
*/
?>