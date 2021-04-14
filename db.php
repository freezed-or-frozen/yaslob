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
    private $dbh = NULL;

    /**
     * Initialize SQLite 3 Database access
     * @param databasePath
     */
    public function __construct($databasePath) {
        $this->dbh = new SQLite3($databasePath);
    }

    /**
     * Add a new ebook
     * @param $title
     * @param $author
     * @param $description
     * @param $year 
     * @param $pages 
     * @param $ebookName
     */
    function addNewEbook($title, $author, $description, $year, $pages, $ebookName) {
        // Prepare SQL request with parameters
        $sql = "
            INSERT INTO documents (title, author, description, year, pages, date, url)
            VALUES (:title, :author, :description, :year, :pages, :date, :url);";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":title", $title, SQLITE3_TEXT);
        $stmt->bindValue(":author", $author, SQLITE3_TEXT);
        $stmt->bindValue(":description", $description, SQLITE3_TEXT);
        $stmt->bindValue(":year", $year, SQLITE3_INTEGER);
        $stmt->bindValue(":pages", $pages, SQLITE3_INTEGER);    
        $stmt->bindValue(":date", date("Y-m-d H:i:s"), SQLITE3_TEXT);
        $stmt->bindValue(":url", $ebookName, SQLITE3_TEXT);

        // Execute it and return the new ebook id
        $result = $stmt->execute();
        $ebookId = $this->dbh->lastInsertRowID();
        return $ebookId;
    }


    /**
     * Add tags associated to an added ebook
     * @param ebookId 
     * @param tags string of tags like "cpp,php,rust"
     */
    function addTagsToEbook($ebookId, $tags) {
        // Transform tags string list in an array
        $ebookTags = explode(",", $tags);
        //var_dump($ebookTags);
        //echo "<br />";

        // For each tag in the array...
        foreach($ebookTags as $key => $value) {
            // Check if tag already exist in database            
            $sql = "
                SELECT *
                FROM tags
                WhERE name LIKE :nom;";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":nom", $value, SQLITE3_TEXT);
            $result = $stmt->execute();
            $res = $result->fetchArray(SQLITE3_ASSOC);
            //echo "{$value} => ";
            //var_dump($res);
            //echo "<br />";

            // If not, add it
            $tagId = 0;
            if ($res == false) {
                $sql = "
                    INSERT INTO tags (name)                
                    VALUES (:nom);";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindValue(":nom", $value, SQLITE3_TEXT);
                $result = $stmt->execute();
                $tagId = $this->dbh->lastInsertRowID();
            } else {
                $tagId = $res["id"];
            }
            //echo "tag_id => {$tagId}<br >";

            // Check if this tag is already associated to ebook
            $sql = "
                SELECT *
                FROM associations
                WhERE id_document = :ebookId
                AND id_tag = :tag_id;";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":ebookId", $ebookId, SQLITE3_INTEGER);
            $stmt->bindValue(":tag_id", $tagId, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $res = $result->fetchArray(SQLITE3_ASSOC);

            // If not add an association between tag and ebook
            if ($res == false) {
                $sql = "
                    INSERT INTO associations (id_document, id_tag)                
                    VALUES (:ebookId, :tag_id);";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindValue(":ebookId", $ebookId, SQLITE3_INTEGER);
                $stmt->bindValue(":tag_id", $tagId, SQLITE3_INTEGER);
                $result = $stmt->execute();
            }
        }
    }

    /**
     * Get all ebooks
     */
    function getEbooks() {
        $sql = "
            SELECT *
            FROM documents
            ORDER BY date DESC;";
        $result = $this->dbh->query($sql);
        $ebooks = array();
        while($res = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push($ebooks, $res);
        }
        return $ebooks;
    }


    /**
     * Get all tags associated to a specific ebook
     * @param ebookId 
     * @return tags array of tags ["cpp", "php", "rust"]
     */
    function getTags($ebookId) {        
        // Prepare SQL request with parameters and execute it
        $sql = "
            SELECT tags.id, tags.name
            FROM tags
            INNER JOIN associations
            ON tags.id = associations.id_tag
            INNER JOIN documents
            ON associations.id_document = documents.id
            WhERE id_document = :ebookId;";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":ebookId", $ebookId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        $tags = array();
        while($res = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push($tags, $res["name"]);
        }
        return $tags;
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