<?php
include "Header.php";
?>
<h1>Web Shop</h1>
<div style="padding: 10px; max-width: 50%; margin: auto;">
    <?php
    foreach ($vars['products'] as $product) {
        echo "<div style='padding: 10px; background-color: #e1b96a; margin: 10px 10px 10px 10px;'>
        <img style='max-width: 100%;' src= 'app/images/" . $product->image . "'alt='" . $product->image . "'><br>";
        echo $product->name . '<br>';
        echo $product->price . '$<br>';
        echo $product->description . '<br>';
        if(isset($_SESSION['isAdmin']))
            echo "<a class='btn btn-success' href='editProduct?id=". $product->id . "'>Edit</a>";
        if(!isset($_SESSION['login']))
            echo "<a disabled title='Login for shopping!' class='btn btn-primary'>Add to cart</a>" . '</div>';
        else
            echo "<a class='btn btn-primary' href='cart/add?id=". $product->id . "'>Add to cart</a>" . '</div>';

    }
    ?>
</div>

<?php
include "Footer.php";
?>