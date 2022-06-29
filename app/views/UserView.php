<?php
include "Header.php";
?>
<h1>User: <?= $vars['user']->email ?></h1>
<div>
    <div style="display: inline-block; vertical-align: middle; padding-right: 20px;">
        <?php if($vars['isAdmin']): ?>
        <h3>Change privileges:</h3><br>
        <form method="post" action="editUser/submit">
            <label for="isAdmin">Edit privileges</label><br>
            <select id="isAdmin" name="isAdmin">
                <option value="1" <?= $vars['user']->isAdmin == 1 ? 'selected' : '' ?>>Admin</option>
                <option value="0" <?= $vars['user']->isAdmin == 0 ? 'selected' : '' ?>>Customer</option>
            </select><br><br>
            <input class="btn btn-primary" type="submit" value="Submit">
        <?php else: ?>
        <h3>Change password:</h3><br>
        <form method="post" action="editUser/updatePassword">
            <label for="oldPassword">Enter old password:</label><br>
            <input required type="password" id="oldPassword" name="oldPassword"><br><br>
            <label for="newPassword">Enter new password:</label><br>
            <input required type="password" id="newPassword" name="newPassword"><br><br>
            <label for="repeat">Repeat new password:</label><br>
            <input required type="password" id="repeat" name="repeat"><br><br>
            <input class="btn btn-primary" type="submit" value="Change password">
        <?php endif; ?>
            <input hidden name="id" value="<?= $vars['user']->id ?>">
        </form>
    </div>
    <div style="display: inline-block; vertical-align: middle; padding-left: 20px;">
        <h3>Change shipping info:</h3><br>
        <form method="post" action="editUser/updateInfo">
            <label for="fname">First name:</label><br>
            <input required type="text" id="fname" name="fname" value="<?= $vars['user']->firstName ?? '' ?>"><br><br>
            <label for="lname">Last name:</label><br>
            <input required type="text" id="lname" name="lname" value="<?= $vars['user']->lastName ?? '' ?>"><br><br>
            <label for="address">Delivery address:</label><br>
            <input required type="text" id="address" name="address" value="<?= $vars['user']->address ?? '' ?>"><br><br>
            <label for="phone">Phone number:</label><br>
            <input required type="tel" pattern="[0-9]{3}/[0-9]{3}-[0-9]{4}" value="<?= $vars['user']->phone ?? '' ?>" id="phone" name="phone"><br>
            <small>Format: 095/523-6178</small><br><br>
            <input hidden name="id" value="<?= $vars['user']->id ?>">
            <input class="btn btn-success" type="submit" value="Update info">
        </form>
    </div>
</div>
<p><?= $_SESSION['userViewMessage'] ?? '' ?></p>
<?php
include "Footer.php";
?>
