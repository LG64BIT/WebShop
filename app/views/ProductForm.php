<?php
include "Header.php";
?>
    <h2>Add product</h2>
    <form method="post" action="addProduct/submit" enctype="multipart/form-data">
        <input hidden name="id" value="<?php echo $vars['product']->id ?? 0; ?>">
        <label for="name">Product name:</label><br>
        <input required type="text" id="name" name="name" value="<?php echo $vars['product']->name ?? ''; ?>"><br>
        <label for="price">Product price:</label><br>
        <input required type="number" step="0.01" id="price" name="price" value="<?php echo $vars['product']->price ?? ''; ?>"><br><br>
        <label for="description">Description</label><br>
        <textarea required id="description" name="description" rows="10" cols="100">
            <?php echo $vars['product']->description ?? ''; ?>
        </textarea><br>
        <label for="upload">Upload image:</label>
        <center><input required type="file" name="upload" id="upload"></center><br>
        <input type="hidden" name="script" value="<?php echo $vars['script']; ?>">
        <input class="btn btn-primary" type="submit" value="Submit" name="submit">
    </form>
    <p><?php echo $_SESSION['productMessage'] ?? ''; ?></p>
<?php
include "Footer.php";
?>