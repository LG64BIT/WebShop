<?php
include "Header.php";
?>
<h1><?php echo $vars['product']->name; ?></h1>
<div style="padding: 10px; max-width: 80%; margin: auto;">
<?php
echo "<p>";
foreach ($vars['categories'] as $category)
    echo "<a href='home?category=" . $category->id . "'>#" . $category->name . " </a>";
echo "</p>";
echo "<img style='max-width: 50%' src= 'app/images/" . $vars['product']->image . "'alt='" . $vars['product']->image . "'><br>";
echo '<h3 class="text-danger">' . ($vars['product']->quantity <= 3 && $vars['product']->quantity > 0 ? 'Only ' : '');
echo $vars['product']->quantity . ' left</h3><br>';
echo '<h4 style="white-space: pre-line">' . $vars['product']->description . '</h4>';
echo '<h3>Price: ' . $vars['product']->price . '$</h3><br>';
if(isset($_SESSION['isAdmin']))
    echo "<a class='btn btn-success' href='editProduct?id=". $vars['product']->id . "'>Edit</a>";
if($vars['product']->quantity <= 0)
    echo "<a disabled title='Product not in stock!' class='btn btn-primary'>Add to cart</a>";
else
    echo "<a class='btn btn-primary' href='cart/add?id=". $vars['product']->id . "'>Add to cart</a>";
?>
</div>
<?php
include "Footer.php";
?>