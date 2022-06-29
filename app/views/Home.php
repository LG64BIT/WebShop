<?php
include "Header.php";

$allCategories = $vars['categories'];
$mainCategories = [];
foreach ($allCategories as $category)
    if($category->parent_id == 0)
        $mainCategories[] = $category;
?>
<section>
    <ul>
    <?php foreach ($mainCategories as $mainCategory): ?>
        <div class="subnav" style="display: inline-block;">
            <li><a class="btn" href='home?category=<?php echo $mainCategory->id ?>'><b><?= $mainCategory->name ?></b></a></li>
            <div class="subnav-content">
            <?php foreach ($allCategories as $category)
                if($category->parent_id == $mainCategory->id): ?>
                    <a class="btn" href='home?category=<?php echo $category->id ?>'><?= $category->name ?></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    </ul>
</section>
<h1>Hardware Shop</h1>
<h2><?= isset($vars['currentCategoryName']) ? "Category: " . $vars['currentCategoryName'] : '' ?></h2>
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
    echo '<h3 class="text-danger">' . ($product->quantity <= 3 && $product->quantity > 0 ? 'Only ' : '');
    echo $product->quantity . ' left</h3>';
    if(isset($_SESSION['isAdmin']))
        echo "<a class='btn btn-success' href='editProduct?id=". $product->id . "'>Edit</a>";
    if($product->quantity <= 0)
        echo "<a disabled title='Product not in stock!' class='btn btn-primary'>Add to cart</a></div>";
    else
    {
        echo '<form style="display: inline" method="get" action="cart/add">';
        //echo "<a class='btn btn-primary' href='cart/add?id=". $product->id . "'>Add to cart</a></div>";
        echo '<input hidden name="id" value="' . $product->id . '">';
        echo '<input class="btn btn-primary" type="submit" value="Add to cart">';
        echo '<input type="number" name="qty" style="width: 40px;">';
        echo '</form></div>';
    }
    if($counter%2==1)
        echo "</div>";
    $counter++;
}
?>
</div>
<?php
include "Footer.php";
?>

