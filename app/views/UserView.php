<?php
include "Header.php";
$count=1;
?>
<h1>User</h1>
<form method="post" action="editUser/submit">
    <label for="username">Edit username:</label>
    <input type="text" id="username" name="username" value="<?php echo $vars['user'][0]->username; ?>"><br><br>
    <label for="isAdmin">Edit privileges</label>
    <select id="isAdmin" name="isAdmin">
        <option value="1" <?php echo $vars['user'][0]->isAdmin == 1 ? 'selected' : ''; ?>>Admin</option>
        <option value="0" <?php echo $vars['user'][0]->isAdmin == 0 ? 'selected' : ''; ?>>Customer</option>
    </select><br>
    <input class="btn btn-primary" type="submit" value="Submit">
    <input hidden name="id" value="<?php echo $vars['user'][0]->id; ?>">
</form>
<p><?php echo $_SESSION['loginMessage'] ?? ''; ?></p>
<?php
include "Footer.php";
?>