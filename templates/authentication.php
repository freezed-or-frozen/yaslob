<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Welcome page View (V of MVC)
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


<!-- Content of the login page -->
<h1>Sign in</h1>

<form action="index.php" method="GET">

    <!-- Hidden input to precize action in the controller -->
    <input type="hidden" name="action" value="signin" />

    <!-- Input to get login and password -->
    <div class="form-group">
        <label>Login</label>
        <input type="text" name="login" class="form-control">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>   

    <!-- Button to send the form-->
    <button type="submit" class="btn btn-primary">Sign in</button>
</form>


<?php
// Add the footer part
include("footer.php");
?>