<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * New ebook page View (V of MVC)
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
<h1>New ebook</h1>
<div class="row">

    <!-- Left part : form -->
    <div class="col-8">

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Ebook to upload (PDF format only and size < <?php echo $postMaxSize; ?>Mb) : </label><br />
            <input type="file" id="file-to-upload" name="file-to-upload" value="Select PDF" />
        </div>

        <div class="form-group">
            <label>Title : </label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="form-group">
            <label>Author : </label>
            <input type="text" class="form-control" name="author" id="author" required>
        </div>

        <div class="form-row">
        <div class="form-group col-md-3">
            <label>Pages : </label>
            <input type="text" class="form-control" name="pages" id="pages" required>
        </div>

        <div class="form-group col-md-3">
            <label>Year : </label>
            <input type="text" class="form-control" name="year" id="year" required>
        </div>

        <div class="form-group col-md-3">
            <label>Note : </label>
            <div class="form-control" id="note">
                <i id="star1" class="bi bi-star"></i><i id="star2" class="bi bi-star"></i><i id="star3" class="bi bi-star"></i><i id="star4" class="bi bi-star"></i><i id="star5" class="bi bi-star"></i>                
            </div>
        </div>

        <div class="form-group col-md-2">
            <label>NSFK : </label>
            <input type="checkbox" class="form-control" name="nsfk" id="nsfk">
        </div>
        </div>
        <div class="form-group">
            <label>Description : </label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>

        <div class="form-group">
            <label>Tags (comma separated) : </label>
            <input type="text" class="form-control" value="" name="tags" id="tags" data-role="tagsinput" required>
            
        </div>

        <div class="form-group">
            <!--<input type="submit" class="btn btn-primary" value="Upload ebook" name="submit" id="submit">-->
            <button type="button" id="jsonupload" class="btn btn-primary">Upload new ebook</button>
        </div>
    
    </form>
    </div><!-- col-8 -->

    <!-- Right part : cover -->
    <div class="col-4 bg-secondary" id="zonecouverture">
        <canvas id="pdf-canvas" width="100"></canvas>
    </div><!-- col-4 -->

</div><!-- row -->


<?php
// Add the footer part
include("footer.php");
?>