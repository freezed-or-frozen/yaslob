<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Model file (M of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */


 /**
  * Database class to store data with SQLite3 API
  */
class EbooksDB {
    /**
     * Database handle
     */
    private $databasePath = NULL;

    /**
     * Initialize SQLite 3 Database access
     * @param databasePath
     */
    public function __construct($databasePath) {
        $this->databasePath = $databasePath;
    }

    /**
     * Add a new ebook
     * @param $title
     * @param $author
     * @param $description
     * @param $year 
     * @param $pages 
     * @param $ebookName
     * @param $nsfk
     */
    function addNewEbook($title, $author, $description, $year, $pages, $ebookName, $nsfk=0) {

    }


    /**
     * Add tags associated to an added ebook
     * @param ebookId 
     * @param tags string of tags like "cpp,php,rust"
     */
    function addTagsToEbook($ebookId, $tags) {

    }

    /**
     * Get the N last ebooks
     * @param ebookNumber associated with the ebook
     * @return ebooks array* 
     */
    function getLastEbooks($ebookNumber) {
        $xml = simplexml_load_file($this->databasePath);

        $ebooks = array();       
        foreach ($xml->ebook as $ebookNode) {            
            $ebook = array();
            $ebook["title"] = (string)$ebookNode->title;
            $ebook["author"] = (string)$ebookNode->author;
            $ebook["description"] = (string)$ebookNode->description;
            $ebook["year"] = (int)$ebookNode->year;
            $ebook["pages"] = (int)$ebookNode->pages;
            $ebook["date"] = (int)$ebookNode->date;
            $ebook["url"] = (string)$ebookNode->url;
            $ebook["nsfk"] = (int)$ebookNode->nsfk;
            $ebook["note"] = (int)$ebookNode->note;
            $ebook["tags"] = array();
            foreach ($ebookNode->tags->tag as $tagNode) {
                array_push($ebook["tags"], (string)$tagNode);
            }
            array_push($ebooks, $ebook);
        }
        return $ebooks;
    }

    /**
     * Get all ebooks by tag
     * @param tag associated with the ebook
     * @return ebooks array
     */
    function getEbooksByTag($tagName) {
        $xml = simplexml_load_file($this->databasePath);

        $ebooks = array();       
        foreach ($xml->ebook as $ebookNode) {
            // Check if tag is associated to this ebook
            $isTagAssociated = FALSE;
            foreach ($ebookNode->tags->tag as $tagNode) {                
                if ( (string)$tagNode == $tagName) {
                    $isTagAssociated = TRUE;
                }
            }
            
            // If true, than add ebook to the list and return
            if ($isTagAssociated == TRUE) {
                $ebook = array();
                $ebook["title"] = (string)$ebookNode->title;
                $ebook["author"] = (string)$ebookNode->author;
                $ebook["description"] = (string)$ebookNode->description;
                $ebook["year"] = (int)$ebookNode->year;
                $ebook["pages"] = (int)$ebookNode->pages;
                $ebook["date"] = (int)$ebookNode->date;
                $ebook["url"] = (string)$ebookNode->url;
                $ebook["nsfk"] = (int)$ebookNode->nsfk;
                $ebook["note"] = (int)$ebookNode->note;
                $ebook["tags"] = array();
                foreach ($ebookNode->tags->tag as $tagNode) {
                    array_push($ebook["tags"], (string)$tagNode);
                }
                array_push($ebooks, $ebook);
            }
        }
        return $ebooks;
    }


    /**
     * Get all tags associated to a specific ebook
     * @param ebookId 
     * @return tags array of tags ["cpp", "php", "rust"]
     */
    function getTags($ebookId) {        

    }


    /**
     * Get all tags (for autocomplete)
     * @return tags array of tags ["cpp", "php", "rust"]
     */
    function getAllTags() {        
   
    }


    /**
     * Get tags starting with "XXX*" string for autocomplete
     * @param startWith 
     * @return tags array of tags ["cpp", "php", "rust"]
     */
    function getTagsStartingWith($startWith) {        

    }
}


/**
 * Sulgify a string : "Hello World" --> "hello-world"
 * Thanks to : https://kodex.pierrelebedel.fr/php/url-php-slug/
 */
function slugify($string, $delimiter = '-') {
	$oldLocale = setlocale(LC_ALL, '0');
	setlocale(LC_ALL, 'en_US.UTF-8');
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower($clean);
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	$clean = trim($clean, $delimiter);
	setlocale(LC_ALL, $oldLocale);
	return $clean;
}

?>