<?php
include "Header.php";
?>
<h2>Register</h2>
<form method="post" action="register/submit">
    <label for="email">Email:</label><br>
    <input required type="email" id="email" name="email"><br>
    <label for="password">Password:</label><br>
    <input required type="password" id="password" name="password"><br><br>
    <label for="repeat">Repeat password:</label><br>
    <input required type="password" id="repeat" name="repeat"><br><br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
<p><?= $_SESSION['registerMessage'] ?? '' ?></p>
<?php
include "Footer.php";
?>
