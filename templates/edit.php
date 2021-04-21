<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Edit ebook page View (V of MVC)
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


<!-- Content of the new ebook page -->
<h1>Edit ebook</h1>
<div class="row">

    <!-- Left part : form -->
    <div class="col-8">

    <form action="index.php" method="POST">

        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="url" value="<?php echo $ebook["url"]; ?>" />

        <div class="form-group">
            <label>Title : </label>
            <input type="text" class="form-control" name="title" id="title" value="<?php echo $ebook["title"]; ?>" required>
        </div>

        <div class="form-group">
            <label>Author : </label>
            <input type="text" class="form-control" name="author" id="author" value="<?php echo $ebook["author"]; ?>"required>
        </div>

        <div class="form-row">
        <div class="form-group col-md-3">
            <label>Pages : </label>
            <input type="text" class="form-control" name="pages" id="pages" value="<?php echo $ebook["pages"]; ?>" required>
        </div>

        <div class="form-group col-md-3">
            <label>Year : </label>
            <input type="text" class="form-control" name="year" id="year" value="<?php echo $ebook["year"]; ?>" required>
        </div>

        <div class="form-group col-md-3">
            <label>Note : </label>
            <div class="form-control">
                <i id="star1" class="bi bi-star"></i><i id="star2" class="bi bi-star"></i><i id="star3" class="bi bi-star"></i><i id="star4" class="bi bi-star"></i><i id="star5" class="bi bi-star"></i>                
                <input type="hidden" name="notevalue" id="notevalue" value="<?php echo $ebook["note"]; ?>"/>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label>NSFK : </label>
            <input type="checkbox" class="form-control" name="nsfk" id="nsfk" value="<?php echo $ebook["nsfk"]; ?>" />
        </div>
        </div>
        <div class="form-group">
            <label>Description : </label>
            <input type="text" class="form-control" name="description" id="description" value="<?php echo $ebook["description"]; ?>" required>
        </div>

        <div class="form-group">
            <label>Tags (comma separated) : </label>
            <input type="text" class="form-control" name="tags" id="tags" data-role="tagsinput" value="<?php echo $ebook["tagsline"]; ?>" required>
        </div>

        <div class="form-group">
            <!--<input type="submit" class="btn btn-primary" value="Upload ebook" name="submit" id="submit">-->
            <input type="submit" value="Edit ebook" id="editbutton" class="btn btn-primary">
        </div>
    
    </form>
    </div><!-- col-8 -->

    <!-- Right part : cover -->
    <div class="col-4 bg-secondary" id="zonecouverture">
        <img src="<?php echo COVERS_PATH."/".$ebook["url"].".png" ?>" />
    </div><!-- col-4 -->

</div><!-- row -->


<?php
// Add the footer part
include("footer.php");
?>