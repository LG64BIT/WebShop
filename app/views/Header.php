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
        <?php if (isset($_SESSION['id'])):?>
        <ul class="nav nav-pills" style="display: inline-block; float: left">
            <li><a href='profile' data-item='Profile'><b>Profile</b></a></li>
        </ul>
        <?php endif; ?>
        <ul class="nav nav-pills" style="display: inline-block">
            <li><a href='home' data-item='Home'>Home</a></li>
            <li><a href='cart' data-item='Cart'>Cart</a></li>
            <li><a href='about' data-item='About'>About</a></li>
            <?php if (!isset($_SESSION['id'])):?>
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
            <li><a href='allOrders' data-item='AllOrders'><b>All orders</b></a></li>
        </ul>
    <?php elseif (isset($_SESSION['id'])): ?>
        <ul class="nav nav-pills" style="display: inline-block; float: right">
            <li><a href='orderHistory' data-item='OrderHistory'><b>Order history</b></a></li>
        </ul>
    <?php endif; ?>
</section>
