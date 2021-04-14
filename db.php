<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Model file (M of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */


class Database {
    /**
     * Database handle
     */
    private $dbh = NULL;

    /**
     * Initialize SQLite 3 Database access
     * @param database_path
     */
    public function __construct($database_path) {
        $this->dbh = new SQLite3($database_path);
    }
}

?>