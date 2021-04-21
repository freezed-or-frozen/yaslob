<?php
/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Header part of the View (V of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Yet Another Simple Library Of eBooks">
    <title>Ebooks</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/custom.css" rel="stylesheet">  

    <!-- Pass PHP paramters to Javascript -->
    <script>
        var baseUrl = "<?php echo BASE_URL; ?>";
    </script>

    <!-- Precise where to find favicon --> 
    <link rel="shortcut icon" href="<?php echo BASE_URL ?>/assets/img/favicon.ico" />
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            :: YASLOB ::            
        </a>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="welcome" />
                    <button type="submit" class="btn btn-primary"><i class="bi bi-house-door-fill"></i> Home</button>
                </form>
                <!--<a class="nav-link" href="index.php?action=welcome"><i class="bi bi-house-door-fill"></i> Home</a>-->
            </li>
            <li class="nav-item">
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="list" />
                    <button type="submit" class="btn btn-primary"><i class="bi bi-book-fill"></i> Ebooks</button>                
                </form>
                <!--<a class="nav-link" href="index.php?action=list"><i class="bi bi-book-fill"></i> Ebooks</a>-->
            </li>
            <li class="nav-item">
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="search" />
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                </form>
                <!--<a class="nav-link" href="index.php?action=search"><i class="bi bi-search"></i> Search</a>-->
            </li>
            
            <!-- If admin is authenticated... -->
            <?php if ( (isset($_SESSION["authentication"])) && ($_SESSION["authentication"] == 1) ) : ?>
                <li class="nav-item">
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="new" />
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> New</button>
                    </form>
                    <!--<a class="nav-link" href="index.php?action=new"><i class="bi bi-plus-circle-fill"></i> New</a>-->
                </li>

                <!-- Disconnect button -->
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="signout" />
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Disconnect</button>
                </form>
            <?php else: ?>
                <li class="nav-item">
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="adminform" />
                        <!--<a class="btn btn-outline-info my-2 my-sm-0" href="index.php?action=adminform">Sign in</a>-->
                        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Sign in</button>
                    </form>
                </li>
            <?php endif; ?>
            
        </ul>
        
    </nav>

    <!-- main bootstrap container -->
    <main role="main" class="container starter-template">

    <!-- Notification messages --> 
    <?php
    if (isset($_SESSION["notification"]) && (strlen($_SESSION["notification"])>0)) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">";
        echo $_SESSION["notification"];
        echo "</div>";
        $_SESSION["notification"] = "";
    }
    ?>