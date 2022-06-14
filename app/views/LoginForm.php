<?php
include "Header.php";
?>

<form method="post" action="login/submit">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Submit">
</form>

<?php
include "Footer.php";
?>
