<?php
include "Header.php";
?>
<h2>Login</h2>
<form method="post" action="login/submit">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
<p><?php echo $_SESSION['loginMessage'] ?? ''; ?></p>
<?php
include "Footer.php";
?>
