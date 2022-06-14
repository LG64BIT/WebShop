<?php
namespace app\views;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/views/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<section>
    <ul class="menuItems">
        <li><a href='home' data-item='Home'>Home</a></li>
        <li><a href='about' data-item='About'>About</a></li>
        <li><a href='contact' data-item='Contact'>Contact</a></li>
        <?php if (!isset($_SESSION['login'])):?>
        <li><a href='login' data-item='Login'>Login</a></li>
        <?php else: ?>
        <li><a href='logout' data-item='Logout'>Logout</a></li>
        <?php endif; ?>
        <li><a href='register' data-item='Register'>Register</a></li>
    </ul>
</section>