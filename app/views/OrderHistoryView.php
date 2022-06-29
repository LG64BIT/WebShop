<?php
include "Header.php";
$count = 1;

if(count($vars['userOrders']) == 0){
    echo "<h1>No orders yet</h1>";
    return;
}
?>
<h1>Order history</h1>
<div style="margin: 0 10% 0 10%">
    <table class="table" style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>#</th>
            <th style="text-align: center">Products</th>
            <th style="text-align: center">Address</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Status</th>
        </tr>
        <?php foreach ($vars['userOrders'] as $order): ?>
            <tr>
                <th><?= $count++ ?></th>
                <td><?= $order->productInfo ?></td>
                <td><?= $order->address ?></td>
                <td><?= $order->date ?></td>
                <td><?= $order->status ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
include "Footer.php";
?>

