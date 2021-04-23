<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Controller file (C of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */

// If session not active...
if (version_compare(phpversion(), "5.4.0", "<")) {
    if (session_id() == "") {                           // PHP < 5.4.0
        // ...then we start one
        session_start();
    }
} else {
    if (session_status() !== PHP_SESSION_ACTIVE) {    // PHP >= 5.4.0
        // ...then we start one
        session_start();
    } 
}


// Include configuration and database
include("config.php");
include("db.php");


// Get parameters from URL
if (isset($_POST["action"])) {
    $action = $_POST["action"];
} else {
    $action = NULL;
}


// Create database object
$db = new EbooksDB(DATABASE_PATH);

/*
// Check if user is authenticated
if ( (isset($_SESSION["authentication"]) == FALSE) || ($_SESSION["authentication"] == 0) ) {

    // Does he want to anthenticate ?
    if ($_POST["action"] == "authentication") {

        // If so, check login/password
        if (    ($_POST["login"] == ADMIN_LOGIN) &&
                ($_POST["password"] == ADMIN_PASSWORD) ) {

            // Memorize that he is authenticated
            $_SESSION["authentication"] = 1;

            // Redirection thru the home page            
            include("templates/home.php");
        }
        else {
            // Redirection thru login form
            include("templates/authentication.php");
        }
    } else {
        // Redirection thru login form
        include("templates/authentication.php");
    }
} else {
*/


// Router : choose action to do
if ($action == "welcome") {
    //
    // home/welcome action 
    //

    // Render template view
    include("templates/home.php");

} else if ($action == "new") {
    //
    // new ebook action
    //

    // Get the maximum size one can upload with POST method
    $postMaxSize = (int)(ini_get('post_max_size'));

    // Render template view
    include("templates/new.php");

} else if ($action == "upload") {
    //
    // upload ebook action
    //

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
    $pdf = $_POST["pdf"];

    // Slugify title to use in URL after
    $ebookName = slugify($title);

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
    if (isset($_POST["tag"])) {
        $tagName = $_POST["tag"];
        $ebooks = $db->getEbooksByTag($tagName);
    } else if (isset($_POST["word"])) {
        $word = $_POST["word"];
        $ebooks = $db->getEbooksByWord($word);
    } else {        
        $ebooks = $db->getLastEbooks(MAX_EBOOKS_NUMBER);
    }  

    // Render template view
    include("templates/list.php");

} else if ($action == "tags") {
    //
    // List all tags for autocomplete
    //
    // Get the "term" parameter sent by jQuery-Tags-Inputs library
    $tags = NULL;
    if (isset($_POST["term"])) {
        $startwith = $_POST["term"];
        $tags = $db->getTagsStartingWith($startwith);
    } else {
        $startwith = NULL;
        $tags = $db->getAllTags();
    }    
    
    // Response should be in JSON
    header("Content-type:application/json;charset=utf-8");
    
    // Build the JSON array manually because json_encode() is unknown in PHP 5.1.3
    $tagsJson = "[";
    $counter = 0;
    foreach ($tags as $tag) {
        $tagsJson .= "\"".$tag."\",";
    }
    $tagsJson = substr($tagsJson, 0, -1);
    $tagsJson .= "]";
    echo $tagsJson;

} else if ($action == "search") {
    //
    // List all tags for 
    //

    // Search all tags in database
    $tags = $db->getAllTags();
    sort($tags);

    // Render template view
    include("templates/search.php");

} else if ($action == "adminform") {
    //
    // Authentication form
    // 

    // Render template view
    include("templates/authentication.php");
} else if ($action == "signin") {
    //
    // Sign in
    //

    if (($_POST["login"] == ADMIN_LOGIN) && ($_POST["password"] == ADMIN_PASSWORD)) {
        // Mémorisation de l'authentification pour la suite
        $_SESSION["authentication"] = 1;        

        // Render template view
        $_SESSION["notification"] = "Welcome <strong>".ADMIN_LOGIN."</strong> !";
        include("templates/home.php");
    } else {
        // Render template view
        $_SESSION["notification"] = "Sorry, login and/or password are wrong";
        include("templates/home.php");
    }

} else if ($action == "signout") {
    //
    // Sign out
    //

    // Empty $_SESSION variable
    unset($_SESSION);

    // Destroy session variable
    session_destroy();

    // Render template view
    include("templates/home.php");
} else if ($action == "delete") {    
    //
    // Delete an ebook
    //

    // Get url parameters from URL
    if (isset($_POST["url"])) {
        $url = $_POST["url"];
        $db->deleteEbook($url);
        $_SESSION["notification"] = "Ebook <strong>{$url}</strong> was deleted !";        
    } else {
        $_SESSION["notification"] = "Sorry, cannot handle URL";
    }

    // Render template view
    $ebooks = $db->getLastEbooks(MAX_EBOOKS_NUMBER);
    include("templates/list.php");

} else if ($action == "editform") {   
    //
    // Edit an ebook (prepare form)
    //

    // Get url parameters from URL
    if (isset($_POST["url"])) {
        $url = $_POST["url"];
        $ebook = $db->getEbookByUrl($url);        
        $ebook["tagsline"] = "";
        foreach ($ebook["tags"] as $tags) {
            $ebook["tagsline"] .= $tags.",";
        }
        //var_dump($ebook);

        // Render template view
        include("templates/edit.php");
        
    } else {
        $_SESSION["notification"] = "Sorry, cannot handle URL";
        // Render template view
        $ebooks = $db->getLastEbooks(MAX_EBOOKS_NUMBER);
        include("templates/list.php");
    }

} else if ($action == "edit") {   
    //
    // Edit an ebook (apply modification)
    //

    // Retrieve all parameters
    if (    (isset($_POST["url"])) &&
            (isset($_POST["title"])) &&
            (isset($_POST["author"])) &&
            (isset($_POST["description"])) && 
            (isset($_POST["year"])) && 
            (isset($_POST["pages"])) &&             
            (isset($_POST["notevalue"])) && 
            (isset($_POST["tags"])) ) {
        
        $nsfk = 0;
        if (!isset($_POST["nsfk"])) {
            $nsfk = 0;
        } else {
            $nsfw = 1;
        }
        
        // Update XML database
        $db->updateEbook(
            $_POST["url"],
            $_POST["title"],
            $_POST["author"],
            $_POST["description"],
            $_POST["year"],
            $_POST["pages"],
            $nsfk,
            $_POST["notevalue"],
            $_POST["tags"]
        );

        $_SESSION["notification"] = "<strong>{$_POST["url"]}</strong> was updated";
    } else {

        $_SESSION["notification"] = "Sorry, one parameter is missing";        
    }

    // Render template view
    $ebooks = $db->getLastEbooks(MAX_EBOOKS_NUMBER);
    include("templates/list.php");
    

} else {
    //
    // default action => home/welcome page
    //

    // Render template view
    include("templates/home.php");
}

?>