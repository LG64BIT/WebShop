<?php
include "Header.php";
?>
<h1>Cart</h1>
<div style="padding: 10px; max-width: 50%; margin: auto;">
<?php
    if(!isset($_SESSION['cart']))
        echo "<p>Cart Empty!</p>";
    else
    {
        foreach ($_SESSION['cart']['products'] as $item)
        {
            echo '<div style="background-color: burlywood; padding: 10px; margin: 10px;">Product:'
                . $item[0]->name.' Price:' . $item[0]->price
                . '$ Quantity:' . $_SESSION['cart'][$item[0]->id]['quantity'].'</div>';
        }
        echo "<a class='btn btn-success' href='purchase'>Make purchase</a>";
    }
?>
</div>
<?php
include "Footer.php";
?>
