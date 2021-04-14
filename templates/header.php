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

    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/custom.css" rel="stylesheet">  
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            :: YASLOB ::
            <img src="assets/img/ebooks_logo.jpg" height="35px" />
        </a>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=welcome">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=list">Ebooks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=new">New</a>
            </li>
        </ul>
        
    </nav>

    <!-- main bootstrap container -->
    <main role="main" class="container starter-template">