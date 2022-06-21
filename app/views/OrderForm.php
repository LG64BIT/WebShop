<?php
include "Header.php";
?>
<h2>Ordering details</h2><br>
<form method="post" action="cart/order">
    <label for="fname">First name:</label><br>
    <input required type="text" id="fname" name="fname" value="<?php echo $vars['user']->firstName ?? ''; ?>"><br><br>
    <label for="lname">Last name:</label><br>
    <input required type="text" id="lname" name="lname" value="<?php echo $vars['user']->lastName ?? ''; ?>"><br><br>
    <label for="email">Email address:</label><br>
    <input required type="email" id="email" name="email" value="<?php echo $vars['user']->email ?? ''; ?>"><br><br>
    <label for="address">Delivery address:</label><br>
    <input required type="text" id="address" name="address" value="<?php echo $vars['user']->address ?? ''; ?>"><br><br>
    <label for="phone">Phone number:</label><br>
    <input required type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo $vars['user']->phone ?? ''; ?>" id="phone" name="phone"><br>
    <small>Format: 095-523-6178</small><br><br>
    <input class="btn btn-success" type="submit" value="Order">
</form>
<p><?php echo $_SESSION['orderFormMessage'] ?? ''; ?></p>
<?php
include "Footer.php";
?>
