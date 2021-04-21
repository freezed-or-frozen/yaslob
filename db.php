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
     * @param $url
     * @param $nsfk
     * @param $note
     * @param $tagsList
     */
    function addNewEbook($title, $author, $description, $year, $pages, $url, $nsfk, $note, $tagsList) {
        // Load XML database file
        $xml = simplexml_load_file($this->databasePath);

        // New ebook child node
        $ebookNode = $xml->addChild("ebook");
        $ebookNode->addChild("title", $title);
        $ebookNode->addChild("author", $author);
        $ebookNode->addChild("description", $description);
        $ebookNode->addChild("year", $year);
        $ebookNode->addChild("pages", $pages);
        $ebookNode->addChild("date", date("Y-m-d H:i:s"));
        $ebookNode->addChild("url", $url);
        $ebookNode->addChild("nsfk", $nsfk);
        $ebookNode->addChild("note", $note);

        // New tags node with tag children nodes
        $tags = explode(',', $tagsList);
        $tagsNode = $ebookNode->addChild("tags");
        foreach ($tags as $tag) {
            $tagsNode->addChild("tag", $tag);
        }

        // Save XML database file
        $xml->asXML($this->databasePath);
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
     * Get all ebooks by tag
     * @param word searched in title, author and description
     * @return ebooks array
     */
    function getEbooksByWord($word) {
        $xml = simplexml_load_file($this->databasePath);

        $ebooks = array();       
        foreach ($xml->ebook as $ebookNode) {
            // Init
            $wordFound = FALSE;
            $title = strtolower((string)$ebookNode->title);
            $author = strtolower((string)$ebookNode->author);
            $description = strtolower((string)$ebookNode->description);

            // Check if word is found in the title
            if (strpos($title, $word) !== false) {
                $wordFound = TRUE;
            }
            if (strpos($author, $word) !== false) {
                $wordFound = TRUE;
            }
            if (strpos($description, $word) !== false) {
                $wordFound = TRUE;
            }
            
            // If true, than add ebook to the list and return
            if ($wordFound == TRUE) {
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
     * Get all tags (for autocomplete)
     * @return tags array of tags ["cpp", "php", "rust"]
     */
    function getAllTags() {        
        $xml = simplexml_load_file($this->databasePath);

        $tags = array();       
        foreach ($xml->ebook as $ebookNode) {
            // Check if tag is associated to this ebook            
            foreach ($ebookNode->tags->tag as $tagNode) {
                $isTagAlreadyAdded = FALSE;
                foreach ($tags as $tag) {
                    if ( (string)$tagNode == $tag) {
                        $isTagAlreadyAdded = TRUE;
                    }
                }                
                if ($isTagAlreadyAdded == FALSE) {
                    array_push($tags, (string)$tagNode);
                }
            }           
        }
        return $tags;
    }


    /**
     * Get tags starting with "XXX*" string for autocomplete
     * @param startWith 
     * @return tags array of tags ["cpp", "php", "rust"]
     */
    function getTagsStartingWith($startWith) {
        $xml = simplexml_load_file($this->databasePath);

        $tags = array();       
        foreach ($xml->ebook as $ebookNode) {
            // Check if tag is associated to this ebook            
            foreach ($ebookNode->tags->tag as $tagNode) {
                $isTagAlreadyAdded = FALSE;
                foreach ($tags as $tag) {
                    if ( (string)$tagNode == $tag) {
                        $isTagAlreadyAdded = TRUE;
                    }
                }                
                if ($isTagAlreadyAdded == FALSE) {
                    if (substr((string)$tagNode, 0, strlen($startWith)) === $startWith) { 
                        array_push($tags, (string)$tagNode);
                    }
                }
            }           
        }
        return $tags;
    }


    /**
     * Get one ebook by url
     * @param url the slugified title of the ebook
     * @return ebook associative array
     */
    function getEbookByUrl($url) {
        $xml = simplexml_load_file($this->databasePath);

        $ebooks = array();       
        foreach ($xml->ebook as $ebookNode) {
            
            // If true, than add ebook to the list and return
            if (strpos($url, (string)$ebookNode->url) !== false) {
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
        return $ebooks[0];
    }


    /**
     * Delete an ebook with its url (slugify title)
     * @param url the slugified title
     */
    function deleteEbook($url) { 
        // Search ebook node corresponding tu $url parameter 
        $xml = simplexml_load_file($this->databasePath);
        $ebookNode = $xml->xpath("/ebooks/ebook[url='{$url}']");

        // Delete ebook from XML database
        $dom = dom_import_simplexml($ebookNode[0]);
        $dom->parentNode->removeChild($dom);

        // Save XML database file
        $xml->asXML($this->databasePath);

        // Delete cover and PDF files
        unlink(COVERS_PATH."/".$url.".png");
        unlink(EBOOKS_PATH."/".$url.".pdf");       
    }


    /**
     * Update an ebook with its url (slugify title)
     * @param url the slugified title
     */
    function updateEbook($url, $title, $author, $description, $year, $pages, $nsfk, $note, $tagsList) { 
        // Search ebook node corresponding tu $url parameter 
        $xml = simplexml_load_file($this->databasePath);
        $ebookNode = $xml->xpath("/ebooks/ebook[url='{$url}']")[0];

        if ($title != (string)$ebookNode->title) {
            $ebookNode->title = $title;
        }
        if ($author != (string)$ebookNode->author) {
            $ebookNode->author = $author;
        }
        if ($description != (string)$ebookNode->description) {
            $ebookNode->description = $description;
        }
        if ($year != (string)$ebookNode->year) {
            $ebookNode->year = $year;
        }
        if ($pages != (string)$ebookNode->pages) {
            $ebookNode->pages = $pages;
        }
        if ($nsfk != (string)$ebookNode->nsfk) {
            $ebookNode->nsfk = $nsfk;
        }
        if ($note != (string)$ebookNode->note) {
            $ebookNode->note = $note;
        }

        // Delete tags node from XML database
        $dom = dom_import_simplexml($ebookNode->tags);
        $dom->parentNode->removeChild($dom);

        // New tags node with tag children nodes
        $tags = explode(',', $tagsList);
        $tagsNode = $ebookNode->addChild("tags");
        foreach ($tags as $tag) {
            $tagsNode->addChild("tag", $tag);
        }

        // Save XML database file
        $xml->asXML($this->databasePath);    
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