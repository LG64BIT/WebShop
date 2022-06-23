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
            <th style="text-align: center">Username</th>
            <th style="text-align: center">Products</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Status</th>
        </tr>
        <?php foreach ($vars['userOrders'] as $order): ?>
        <tr>
            <th><?php echo $count++; ?></th>
            <td>
                <?php echo $order->username ?? 'deleted user'; ?>
            </td>
            <td>
                <?php echo $order->productInfo; ?>
            </td>
            <td>
                <?php echo $order->date; ?>
            </td>
            <td>
                <form method="post" action="allOrders/updateUserStatus">
                    <select name="status">
                        <option <?php echo $order->status == "pending" ? "selected" : ''; ?> value="pending">Pending</option>
                        <option <?php echo $order->status == "payed" ? "selected" : ''; ?> value="payed">Payed</option>
                        <option <?php echo $order->status == "shipped" ? "selected" : ''; ?> value="shipped">Shipped</option>
                        <option <?php echo $order->status == "completed" ? "selected" : ''; ?> value="completed">Completed</option>
                        <option <?php echo $order->status == "canceled" ? "selected" : ''; ?> value="canceled">Canceled</option>
                    </select>
                    <input type="hidden" name="user_id" value="<?php echo $order->user_id; ?>">
                    <input type="hidden" name="date" value="<?php echo $order->date; ?>">
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
            <th style="text-align: center">Products</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Status</th>
        </tr>
        <?php foreach ($vars['guestOrders'] as $order): ?>
            <tr>
                <th><?php echo $count++; ?></th>
                <td>
                    <?php echo $order->firstName . ' ' . $order->lastName; ?>
                </td>
                <td>
                    <?php echo $order->productInfo; ?>
                </td>
                <td>
                    <?php echo $order->date; ?>
                </td>
                <td>
                    <form method="post" action="allOrders/updateGuestStatus">
                        <select name="status">
                            <option <?php echo $order->status == "pending" ? "selected" : ''; ?> value="pending">Pending</option>
                            <option <?php echo $order->status == "payed" ? "selected" : ''; ?> value="payed">Payed</option>
                            <option <?php echo $order->status == "shipped" ? "selected" : ''; ?> value="shipped">Shipped</option>
                            <option <?php echo $order->status == "completed" ? "selected" : ''; ?> value="completed">Completed</option>
                            <option <?php echo $order->status == "canceled" ? "selected" : ''; ?> value="canceled">Canceled</option>
                        </select>
                        <input type="hidden" name="guest_id" value="<?php echo $order->guest_id; ?>">
                        <input type="hidden" name="date" value="<?php echo $order->date; ?>">
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