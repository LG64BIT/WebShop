<?php
include "Header.php";
?>
<h2>Login</h2>
<form method="post" action="login/submit">
    <label for="email">Email:</label><br>
    <input required type="email" id="email" name="email"><br>
    <label for="password">Password:</label><br>
    <input required type="password" id="password" name="password"><br><br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
<p><?= $_SESSION['loginMessage'] ?? '' ?></p>
<?php
include "Footer.php";
?>
