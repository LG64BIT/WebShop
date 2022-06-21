<?php
include "Header.php";
?>
<h1>Cart</h1>
<div style="padding: 10px; max-width: 50%; margin: auto;">
<?php
    if(!isset($_SESSION['cart']) || count($_SESSION['cart']['products']) <= 0)
        echo "<p>Cart Empty!</p>";
    else
    {
        foreach ($_SESSION['cart']['products'] as $item)
        {
            echo '<div style="background-color: burlywood; padding: 10px; margin: 10px;">Product:'
                . $item[0]->name.' Price:' . $item[0]->price
                . '$ Quantity:' . $_SESSION['cart'][$item[0]->id]['quantity'];
            echo "<a class='btn btn-primary' href='cart/addQuantity?id=" . $item[0]->id . "'>+</a>";
            echo "<a class='btn btn-primary' href='cart/removeQuantity?id=" . $item[0]->id . "'>-</a></div>";
        }
        echo "<p>Total price: " . $vars['totalPrice'] . "$</p>";
        echo "<a class='btn btn-danger' href='cart/empty'>Empty cart</a>";
        if(isset($_SESSION['login']))
            echo "<a class='btn btn-success' href='orderForm'>Make order</a>";
        else
            echo "<a class='btn btn-success' href='orderForm'>Make order as guest</a>";
    }
?>
</div>
<?php
include "Footer.php";
?>
