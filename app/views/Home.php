<?php
include "Header.php";
?>
<h1>Web Shop</h1>
<div style="padding: 10px; max-width: 50%; margin: auto;">
<form method="get" action="home">
    <label for="category">Category:</label>
    <select id="category" name="category">
        <?php foreach ($vars['categories'] as $category): ?>
        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
        <?php endforeach; ?>
    </select>
    <input class="btn btn-primary" type="submit" value="Filter">
</form>
    <?php
    foreach ($vars['products'] as $product) {
        echo "<div style='padding: 10px; background-color: #e1b96a; margin: 10px 10px 10px 10px;'>
        <img style='max-width: 100%;' src= 'app/images/" . $product->image . "'alt='" . $product->image . "'><br>";
        echo '<h4>' . $product->name . '<br>';
        echo $product->price . '$<br>';
        echo $product->description . '</h4>';
        echo '<h3 class="text-danger">' . ($product->quantity <= 3 && $product->quantity > 0 ? 'Only ' : '');
        echo $product->quantity . ' left</h3>';
        if(isset($_SESSION['isAdmin']))
            echo "<a class='btn btn-success' href='editProduct?id=". $product->id . "'>Edit</a>";
        if($product->quantity <= 0)
            echo "<a disabled title='Product not in stock!' class='btn btn-primary'>Add to cart</a>" . '</div>';
        else
            echo "<a class='btn btn-primary' href='cart/add?id=". $product->id . "'>Add to cart</a>" . '</div>';
    }
    ?>
</div>

<?php
include "Footer.php";
?>