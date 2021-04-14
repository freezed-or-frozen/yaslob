<?php
/**
 * YASLOB
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

    <!-- Custom styles for this template -->
    <link href="assets/css/custom.css" rel="stylesheet">  
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            :: EBOOKS ::
            <img src="assets/img/ebooks_logo.jpg" height="35px" />
        </a>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?by=name">By name</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?by=date">By date</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?by=tags">By tags</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?by=new">New</a>
            </li>
        </ul>
        
    </nav>

    <!-- main bootstrap container -->
    <main role="main" class="container starter-template">