<?php
include "Header.php";
?>
<form method="post" action="register/submit">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <label for="repeat">Repeat password:</label><br>
    <input type="password" id="repeat" name="repeat"><br><br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
<p><?php echo $_SESSION['registerMessage'] ?? ''; ?></p>
<?php
include "Footer.php";
?>