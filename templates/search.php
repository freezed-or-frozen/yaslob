<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Search page View (V of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */
?>

<?php
// Add the header part
include("header.php");
?>


<!-- Content of the search page -->
<h1>Search</h1>
<form action="index.php" method="POST">
    <div class="form-group">
        <label>Search ebooks by <strong>word</strong> : </label><br />
        <input type="hidden" name="action" value="list" />
        <input type="text" name="word" value="" />
        <button id="search-button" class="btn btn-primary">Search</button>
    </div>    
    <div class="form-group">
        <label>Search ebooks by <strong>tags</strong> : </label><br />
        <?php
        foreach($tags as $tag) {
            echo "<form action=\"index.php\" method=\"POST\">";
            echo "<input type=\"hidden\" name=\"action\" value=\"list\" />";
            echo "<input type=\"hidden\" name=\"tag\" value=\"{$tag}\" />";
            echo "<input type=\"submit\" class=\"badge badge-info\">";
            echo "</form>";
        }
        ?>
    </div>
</form>



<?php
// Add the footer part
include("footer.php");
?>