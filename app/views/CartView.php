<?php
include "Header.php";
?>
<h1>Cart</h1>
<div style="padding: 10px; max-width: 50%; margin: auto;">
<?php
    if(isset($vars['empty']))
        echo '<p>' . $vars['empty'] . '</p>';
    else
    {
        foreach ($vars['products'] as $item)
        {
            echo '<div style="background-color: burlywood; padding: 10px; margin: 10px;">Product:'
                . $item->name.' Price:' . $item->price
                . '$ Quantity:' . $_SESSION['cart'][$item->id];
            echo "<a class='btn btn-primary' href='cart/addQuantity?id=" . $item->id . "'>+</a>";
            echo "<a class='btn btn-primary' href='cart/removeQuantity?id=" . $item->id . "'>-</a></div>";
        }
        echo "<p>Total price: " . $vars['totalPrice'] . "$</p>";
        echo "<a class='btn btn-danger' href='cart/empty'>Empty cart</a>";
        if(isset($_SESSION['id']))
            echo "<a class='btn btn-success' href='orderForm'>Make order</a>";
        else
            echo "<a class='btn btn-success' href='orderForm'>Make order as guest</a>";
    }
?>
</div>
<?php
include "Footer.php";
?>
