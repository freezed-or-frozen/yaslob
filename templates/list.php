<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * List ebooks page View (V of MVC)
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


<!-- Content of the welcome page -->
<h1>Ebooks</h1>
<table class="table table-striped">
    <?php
    // Transformation du tableau associatif en HTML
    foreach($ebooks as $ebook) {
        echo "<tr>";

        // Ebook cover
        echo "<td>";
        echo "<img src=\"".COVERS_PATH."/{$ebook["url"]}.png\" class=\"thumbnail rounded\"/>";
        echo "</td>";

        // Title, author, year et number of pages
        echo "<td>";
        echo "<ul class=\"list-unstyled\">";
        echo "<li>";
        echo "<a href=\"".EBOOKS_PATH."/{$ebook["url"]}.pdf\">{$ebook["title"]}</a>";
        echo "</li>";
        echo "<li>{$ebook["author"]}</li>";
        echo "<li>{$ebook["year"]} - {$ebook["pages"]}p</li>";
        echo "<li>{$ebook["date"]}</li>";
        echo "<li>";
        if ($ebook["note"] == 0) {
            echo "<i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i>";
        } else if ($ebook["note"] == 1) {
            echo "<i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i>";
        } else if ($ebook["note"] == 2) {
            echo "<i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i>";
        } else if ($ebook["note"] == 3) {
            echo "<i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i>";
        } else if ($ebook["note"] == 4) {
            echo "<i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star\"></i>";
        } else if ($ebook["note"] == 5) {
            echo "<i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i><i class=\"bi bi-star-fill\"></i>";
        } else {
            echo "<i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i><i class=\"bi bi-star\"></i>";
        }
        echo "</li>";
        echo "</ul>";
        echo "</td>";
        echo "<td>";

        // Description
        echo "<p>";
        echo "<div class=\"alert alert-dark\" role=\"alert\">{$ebook["description"]}</div>";
        echo "</p>";

        // Tags associated
        echo "<p>";    
        foreach($ebook["tags"] as $tag) {
            echo "<a href=\"index.php?action=list&tag={$tag}\" class=\"badge badge-info\">{$tag}</a>&nbsp;";
        }
        echo "</p>";
        echo "<p>";
        if ($ebook["nsfk"] == 1) {
            echo "NSFK : <i class=\"bi bi-hand-thumbs-down-fill\"></i>";
        } else {
            echo "NSFK : <i class=\"bi bi-hand-thumbs-up-fill\"></i>";
        }
        echo "</p>";

        echo "</td>";
        if ($_SESSION["authentication"] == 1) {
            echo "<td>";
            echo "<a href=\"index.php?action=delete&url={$ebook["url"]}\" class=\"btn btn-danger\">Delete</a><br/>";
            echo "<a href=\"index.php?action=edit&url={$ebook["url"]}\" class=\"btn btn-warning\">Edit</a><br/>";
            
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>


<?php
// Add the footer part
include("footer.php");
?>