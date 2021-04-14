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


// Create database object
$db = new EbooksDB(DATABASE_PATH);


// Router : choose action to do
if ($action == "welcome") {
    //
    // home/welcome action 
    //
    include("templates/home.php");

} else if ($action == "new") {
    //
    // new ebook action
    //
    include("templates/new.php");

} else if ($action == "upload") {
    //
    // upload ebook action
    //

    // Get JSON data and decode
    $jsonData = file_get_contents("php://input");
    $ebook = json_decode($jsonData);
    //var_dump($jsonData);
    //var_dump($ebook);   

    // Extract title and slugify it
    $titre = $ebook->{"title"};
    $ebookName = slugify($titre);

    // Get cover image in base64 ans save it as PNG
    $coverData = base64_decode(
    preg_replace('#^data:image/png;base64,#i', '', $ebook->{"cover"})
    );
    file_put_contents(COVERS_PATH."/{$ebookName}.png", $coverData);

    // Get ebook in base64 and save it as PDF
    $pdfData = base64_decode(
    preg_replace('#^data:application/pdf;base64,#i', '', $ebook->{"pdf"})
    );
    file_put_contents(EBOOKS_PATH."/{$ebookName}.pdf", $pdfData);

    // Add a new ebook in the database
    $ebookId = $db->addNewEbook(
        $ebook->{"title"},
        $ebook->{"author"},
        $ebook->{"description"},
        $ebook->{"year"},
        $ebook->{"pages"},    
        $ebookName
    );

    // Add tags associated to the ebook
    $db->addTagsToEbook($ebookId, $ebook->{"tags"});

    // Prepare notification message
    $_SESSION["notification"] = "Upload of <strong>{$ebookName}.pdf</strong> is done";

    // Finally send JSON answer
    header("Content-type:application/json;charset=utf-8");
    $response = [ "ebook" => $ebookName, "status" => "OK" ];
    echo json_encode($response);

} else if ($action == "list") {
    //
    // List ebooks
    //
    $ebooks = $db->getEbooks();
    foreach($ebooks as &$ebook) {
        //array_push($tags, $db->getTags($ebook["id"]));
        $ebook["tags"] = $db->getTags($ebook["id"]);
    }     
    include("templates/list.php");

} else if ($action == "tags") {
    //
    // List all tags for autocomplete
    //
    // Get the "term" parameter sent by jQuery-Tags-Inputs library
    $tags = NULL;
    if (isset($_GET["term"])) {
        $startwith = $_GET["term"];
        $tags = $db->getTagsStartingWith($startwith);
    } else {
        $startwith = NULL;
        $tags = $db->getAllTags();
    }    
    
    header("Content-type:application/json;charset=utf-8");
    echo json_encode($tags);

} else {
    //
    // default action => home/welcome page
    //
    include("templates/home.php");
}

?>