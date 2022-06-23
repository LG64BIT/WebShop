<?php
namespace app\views;

use app\models\Categories;
use app\models\Model;
use app\Utils;

new Model(Utils::getDb());
$allCategories = Categories::GetAllCategories();
$mainCategories = [];
foreach ($allCategories as $category)
    if($category->parent_id == 0)
        $mainCategories[] = $category;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Inchoo praksa/WebShop/app/views/css/style.css"><!--linux->/app/views/css/style.css; windows->/Inchoo praksa/WebShop/app/views/css/style.css-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<section style="background-color: #e1b96a">
        <?php if (isset($_SESSION['login'])):?>
        <ul class="nav nav-pills" style="display: inline-block; float: left">
            <li><a href='profile' data-item='Profile'><b>Profile</b></a></li>
        </ul>
        <?php endif; ?>
        <ul class="nav nav-pills" style="display: inline-block">
            <li><a href='home' data-item='Home'>Home</a></li>
            <li><a href='cart' data-item='Cart'>Cart</a></li>
            <li><a href='about' data-item='About'>About</a></li>
            <?php if (!isset($_SESSION['login'])):?>
            <li><a href='login' data-item='Login'>Login</a></li>
            <li><a href='register' data-item='Register'>Register</a></li>
            <?php else: ?>
            <li><a href='logout' data-item='Logout'>Logout</a></li>
            <?php endif; ?>
        </ul>
    <?php if(isset($_SESSION['isAdmin'])): ?>
        <ul class="nav nav-pills" style="display: inline-block; float: right">
            <li><a href='addProduct' data-item='AddProduct'><b>Add product</b></a></li>
            <li><a href='allUsers' data-item='AllUsers'><b>All users</b></a></li>
            <li><a href='allOrders' data-item='allOrders'><b>All orders</b></a></li>
        </ul>
    <?php endif; ?>
</section>
<section>
        <ul>
            <?php foreach ($mainCategories as $mainCategory): ?>
            <div class="subnav" style="display: inline-block;">
                <li><a class="btn" href='home?category=<?php echo $mainCategory->id ?>'><b><?php echo $mainCategory->name ?></b></a></li>
                <div class="subnav-content">
                    <?php foreach ($allCategories as $category)
                        if($category->parent_id == $mainCategory->id): ?>
                    <a class="btn" href='home?category=<?php echo $category->id ?>'><?php echo $category->name ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </ul>
</section>