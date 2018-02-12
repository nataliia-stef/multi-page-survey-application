<?php
/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code:  final page that will be displayed to the user after saving the form */

//start session
session_start();

//include html header
include 'includes/header.php' ?>

<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="intro-text text-center">
                <h1>Your data has been saved to the database!</h1>
                
        </div>
    </div>
</div><!-- container -->

<?php
//include html footer
include 'includes/footer.php' ?>

<?php

//control the page number
if(!isset($_SESSION['page'])){
    header('Location:index.php');
} else if ($_SESSION['page'] !='save' ){
    header('Location:page_'.$_SESSION['page'].'.php');
}



//FOR TESTING PURPOSE
//print_r($_SESSION['product_satisfaction']) ;
//print_r ($_SESSION['product_recommendation']);

?>
