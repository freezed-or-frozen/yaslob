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
    //$jsonData = file_get_contents("php://input");
    //$ebook = json_decode($jsonData);
    //var_dump($jsonData);
    //var_dump($ebook);   

    // Get POST data
    $title = $_POST["title"];
    $author = $_POST["author"];
    $description = $_POST["description"];
    $year = $_POST["year"];
    $pages = $_POST["pages"];
    $nsfk = $_POST["nsfk"];
    $note = $_POST["note"];
    $tags = $_POST["tags"];
    $cover = $_POST["cover"];
    $pdf = $_POST["data"];

    // Slugify title to use in URL after
    $ebookName = slugify($titre);

    // Get cover image in base64 ans save it as PNG
    $coverData = base64_decode(
    preg_replace('#^data:image/png;base64,#i', '', $cover)
    );
    file_put_contents(COVERS_PATH."/{$ebookName}.png", $coverData);

    // Get ebook in base64 and save it as PDF
    $pdfData = base64_decode(
    preg_replace('#^data:application/pdf;base64,#i', '', $pdf)
    );
    file_put_contents(EBOOKS_PATH."/{$ebookName}.pdf", $pdfData);

    // Add a new ebook in the database
    $ebookId = $db->addNewEbook(
        $title,
        $author,
        $description,
        $year,
        $pages,    
        $ebookName,         // url in database
        $nsfk,
        $note,
        $tags
    );

    // Add tags associated to the ebook
    //$db->addTagsToEbook($ebookId, $ebook->{"tags"});

    // Prepare notification message
    $_SESSION["notification"] = "Upload of <strong>{$ebookName}.pdf</strong> is done";

    // Finally send answer    
    echo "OK";

} else if ($action == "list") {
    //
    // List ebooks
    //

    // Get ebooks list depending on the way it is asked
    $ebooks = NULL;
    if (isset($_GET["tag"])) {
        $tagName = $_GET["tag"];
        $ebooks = $db->getEbooksByTag($tagName);
    } else {        
        $ebooks = $db->getLastEbooks(MAX_EBOOKS_NUMBER);
    }  
/*    
    // Get associated tags for each ebooks
    foreach($ebooks as &$ebook) {
        //array_push($tags, $db->getTags($ebook["id"]));
        $ebook["tags"] = $db->getTags($ebook["id"]);
    }     
*/
    // Render template view
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