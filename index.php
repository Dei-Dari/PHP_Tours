<?php
session_start();
include_once("pages/functions.php");
$page = $_GET['page'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Travel Agency</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" r el="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body>
    <div class="container">
        <div class="row">
            <header class="col-sm-12 col-md-12 col-lg-12">
                <?php include_once("pages/login.php"); ?>
            </header>
        </div>

        <div class="row">
            <nav class="col-sm-12 col-md-12 col-lg-12 head">
                <?php
                include_once('pages/menu.php');
                ?>
            </nav>
        </div>

        <div class="row">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <?php
                if (isset($_GET['page'])) {
                    if ($page == 1)
                        include_once("pages/tours.php");
                    if ($page == 2)
                        include_once("pages/comments.php");
                    if ($page == 3)
                        include_once("pages/registration.php");
                    if ($page == 4)
                        include_once("pages/admin.php");
                    if ($page == 6 && isset($_SESSION['radmin']))
                        include_once("pages/private.php");
                }
                ?>
            </section>
        </div>
    </div>




    <script src="~/lib/jquery/dist/jquery.min.js"></script>
    <script src="~/lib/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
