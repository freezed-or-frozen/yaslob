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


// Unit tests
$db = new EbooksDB(DATABASE_PATH);

/*
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

$str1 = "cpp";
$str2 = "cpp,python";
var_dump(explode(",", $str1));
var_dump(explode(",", $str2));
*/

/*
$tags = $db->getTags(2);
printToDebug($tags);


$tagsAutoComplete = $db->getTagsStartingWith("pro");
printToDebug($tagsAutoComplete);


$ebooks = $db->getEbooksByTag("programming");
printToDebug($ebooks);
*/

$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);
echo "upload_max_filesize => ".$max_upload."<br />";
echo "post_max_size => ".$max_post."<br />";
echo "memory_limit => ".$memory_limit."<br />";
echo "upload_mb => ".$upload_mb."<br />";

?>