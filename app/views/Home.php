<?php
include "Header.php";
?>
<h1>Web Shop</h1>
<h2><?php echo isset($vars['currentCategoryName']) ? "Category: " . $vars['currentCategoryName'] : ''; ?></h2>
<div style="padding: 10px; max-width: 80%; margin: auto;">
<?php
$counter = 0;
foreach ($vars['products'] as $product) {
    if($counter%2==0)
        echo "<div>";
    echo "<div style='max-width: 40%; width:500px; padding: 5px; background-color: #e1b96a; margin: 10px 10px 10px 10px; display: inline-block; vertical-align: middle;'>";
    echo "<a href='product?id=" . $product->id . "'><img style='max-width: 100%; width:500px; height:300px;' src= 'app/images/" . $product->image . "'alt='" . $product->image . "'><br></a>";
    echo '<h4>' . $product->name . '<br><br>';
    echo 'Price: ' . $product->price . '$<br>';
    //echo $product->description . '</h4>';
    echo '<h3 class="text-danger">' . ($product->quantity <= 3 && $product->quantity > 0 ? 'Only ' : '');
    echo $product->quantity . ' left</h3>';
    if(isset($_SESSION['isAdmin']))
        echo "<a class='btn btn-success' href='editProduct?id=". $product->id . "'>Edit</a>";
    if($product->quantity <= 0)
        echo "<a disabled title='Product not in stock!' class='btn btn-primary'>Add to cart</a></div>";
    else
        echo "<a class='btn btn-primary' href='cart/add?id=". $product->id . "'>Add to cart</a></div>";
    if($counter%2==1)
        echo "</div>";
    $counter++;
}
?>
</div>
<?php
include "Footer.php";
?>