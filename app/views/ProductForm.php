<?php
include "Header.php";
?>
<h2><?php echo ucfirst($vars['script']); ?> product</h2>
<form method="post" action="addProduct/submit" enctype="multipart/form-data">
    <input hidden name="id" value="<?php echo $vars['product']->id ?? 0; ?>">
    <label for="name">Product name:</label><br>
    <input required type="text" id="name" name="name" value="<?php echo $vars['product']->name ?? ''; ?>"><br>
    <label for="price">Product price:</label><br>
    <input required type="number" step="0.01" id="price" name="price" value="<?php echo $vars['product']->price ?? ''; ?>"><br><br>
    <label for="quantity">Stock quantity:</label><br>
    <input required type="number" id="quantity" name="quantity" value="<?php echo $vars['product']->quantity ?? ''; ?>"><br><br>
    <label for="categories">Select categories:</label><br>
    <select required multiple name="categories[]" id="categories">
        <?php foreach ($vars['categories'] as $category): ?>
        <option value="<?php echo $category->id ?>"
            <?php if(isset($vars['product_categories']))
                echo in_array($category, $vars['product_categories']) ? 'selected' : '';?>>
            <?php echo $category->name ?>
        </option>
        <?php endforeach; ?>
    </select><br>
    <label for="description">Description:</label><br>
    <textarea required id="description" name="description" rows="10" cols="100"><?php echo $vars['product']->description ?? ''; ?></textarea><br>
    <label for="upload">Upload image:</label>
    <center><input <?php echo isset($vars['product']->image) ? '' : 'required'; ?> type="file" name="upload" id="upload" value="img.jpg"></center><br>
    <p><?php echo $vars['product']->image ?? ''; ?></p>
    <input type="hidden" name="script" value="<?php echo $vars['script']; ?>">
    <input class="btn btn-primary" type="submit" value="Submit" name="submit">
</form><br>
<?php
if($vars['script'] == 'edit')
    echo "<a class='btn btn-danger' href='removeProduct?id=" . ($vars['product']->id ?? 0) . "'>Delete product</a>";
?>
<p><?php echo $_SESSION['productMessage'] ?? ''; ?></p>
<?php
include "Footer.php";
?>