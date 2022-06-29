<?php
include "Header.php";
$count = 1;
?>
<h1>All orders</h1>
<h3>User orders:</h3>
<div style="margin: 0 10% 0 10%">
    <table class="table" style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>#</th>
            <th style="text-align: center">First name</th>
            <th style="text-align: center">Last name</th>
            <th style="text-align: center">email</th>
            <th style="text-align: center">Products</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Status</th>
        </tr>
        <?php foreach ($vars['orders'] as $order): ?>
        <tr>
            <th><?= $count++ ?></th>
            <td><?= $order->firstName ?? 'deleted user' ?></td>
            <td><?= $order->lastName ?? 'deleted user' ?></td>
            <td><?= $order->email ?? 'deleted user' ?></td>
            <td><?= $order->productInfo ?></td>
            <td><?= $order->date ?></td>
            <td>
                <form method="post" action="allOrders/updateUserStatus">
                    <select name="status">
                        <option <?= $order->status == "pending" ? "selected" : '' ?> value="pending">Pending</option>
                        <option <?= $order->status == "payed" ? "selected" : '' ?> value="payed">Payed</option>
                        <option <?= $order->status == "shipped" ? "selected" : '' ?> value="shipped">Shipped</option>
                        <option <?= $order->status == "completed" ? "selected" : '' ?> value="completed">Completed</option>
                        <option <?= $order->status == "canceled" ? "selected" : '' ?> value="canceled">Canceled</option>
                    </select>
                    <input type="hidden" name="user_id" value="<?= $order->user_id ?>">
                    <input type="hidden" name="date" value="<?= $order->date ?>">
                    <input type="submit" name="submit" value="Update">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php $count = 1; ?>
<h3>Guest orders:</h3>
<div style="margin: 0 10% 0 10%">
    <table class="table" style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>#</th>
            <th style="text-align: center">Guest name</th>
            <th style="text-align: center">email</th>
            <th style="text-align: center">Products</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Status</th>
        </tr>
        <?php foreach ($vars['guestOrders'] as $order): ?>
            <tr>
                <th><?= $count++ ?></th>
                <td><?= $order->firstName . ' ' . $order->lastName ?></td>
                <td><?= $order->email ?></td>
                <td><?= $order->productInfo ?></td>
                <td><?= $order->date ?></td>
                <td>
                    <form method="post" action="allOrders/updateGuestStatus">
                        <select name="status">
                            <option <?= $order->status == "pending" ? "selected" : '' ?> value="pending">Pending</option>
                            <option <?= $order->status == "payed" ? "selected" : '' ?> value="payed">Payed</option>
                            <option <?= $order->status == "shipped" ? "selected" : '' ?> value="shipped">Shipped</option>
                            <option <?= $order->status == "completed" ? "selected" : '' ?> value="completed">Completed</option>
                            <option <?= $order->status == "canceled" ? "selected" : '' ?> value="canceled">Canceled</option>
                        </select>
                        <input type="hidden" name="guest_id" value="<?= $order->guest_id ?>">
                        <input type="hidden" name="date" value="<?= $order->date ?>">
                        <input type="submit" name="submit" value="Update">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
include "Footer.php";
?>
