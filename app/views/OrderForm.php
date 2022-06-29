<?php
include "Header.php";
?>
<h2>Ordering details</h2><br>
<form method="post" action="cart/order">
    <label for="fname">First name:</label><br>
    <input required type="text" id="fname" name="fname" value="<?= $vars['user']->firstName ?? '' ?>"><br><br>
    <label for="lname">Last name:</label><br>
    <input required type="text" id="lname" name="lname" value="<?= $vars['user']->lastName ?? '' ?>"><br><br>
    <?php if(!isset($_SESSION['id'])): ?>
    <label for="email">Email address:</label><br>
    <input required type="email" id="email" name="email" value="<?= $vars['user']->email ?? '' ?>"><br><br>
    <?php endif; ?>
    <label for="address">Delivery address:</label><br>
    <input required type="text" id="address" name="address" value="<?= $vars['user']->address ?? '' ?>"><br><br>
    <label for="phone">Phone number:</label><br>
    <input required type="tel" pattern="[0-9]{3}/[0-9]{3}-[0-9]{4}" value="<?= $vars['user']->phone ?? '' ?>" id="phone" name="phone"><br>
    <small>Format: 095/523-6178</small><br><br>
    <input class="btn btn-success" type="submit" value="Order">
</form>
<p><?= $_SESSION['orderFormMessage'] ?? '' ?></p>
<?php
include "Footer.php";
?>
