<?php
namespace app\controllers;

use app\exceptions\FileUploadException;
use app\exceptions\NoPermissionException;
use app\exceptions\PageNotFoundException;
use app\models\Categories;
use app\models\Model;
use app\models\Product;
use PDO;

class ProductController
{
    protected PDO $db;
    protected array $supportedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    public function __construct(PDO $db)
    {
        $this->db=$db;
    }

    public function add($response)
    {
        $this->checkPermission();
        $categories = $this->db->query("SELECT * FROM categories");
        $categories = $categories->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/ProductForm.php', [
            'script' => 'add',
            'categories' => $categories
        ]);
    }

    public function edit($response)
    {
        $this->checkPermission();
        if(isset($_GET['id']))
        {
            $product = $this->db->prepare("SELECT * FROM products WHERE id=:id");
            $product->execute(['id'=>$_GET['id']]);
            $product = $product->fetchAll(PDO::FETCH_CLASS);

            $categories = $this->db->prepare("SELECT * FROM categories WHERE categories.id =
                            (SELECT category_id FROM product_category WHERE categories.id = category_id AND product_id = :id)");
            $categories->execute(['id'=>$_GET['id']]);
            $categories = $categories->fetchAll(PDO::FETCH_CLASS);

            new Model($this->db);
            return $response->setBody('app/views/ProductForm.php', [
                'product' => $product[0],
                'product_categories' => $categories,
                'categories' => Categories::GetAllCategories(),
                'script' => 'edit'
            ]);
        }
        throw new PageNotFoundException('Page you are looking for has not been found!');
    }
    public function remove()
    {
        $this->checkPermission();
        if(isset($_GET['id']))
        {
            $delete = $this->db->prepare("DELETE FROM products WHERE id=:id");
            $delete->execute(['id'=>$_GET['id']]);

            $delete = $this->db->prepare("DELETE FROM product_category WHERE product_id=:id");
            $delete->execute(['id'=>$_GET['id']]);
        }
        header("Location: home");
    }

    public function submit()
    {
        if(isset($_POST['submit']))
        {
            if(!($_FILES['upload']['name'] == ''))
            {
                $target_dir = dirname(__DIR__) . "\images\\";
                $target_file = $target_dir . basename($_FILES["upload"]["name"]);
                //check for supported extensions
                $extension = explode('.', basename($_FILES["upload"]["name"]));
                if (!in_array(end($extension), $this->supportedExtensions)) {
                    echo "Supported extensions are ";
                    foreach ($this->supportedExtensions as $supportedExtension)
                        echo strtoupper($supportedExtension) . ', ';
                    return;
                }
                if (!$this->checkFilenameLength(basename($_FILES["upload"]["name"]))) {
                    echo "Filename to long, maximum is 100 characters";
                    return;
                }
                if (!move_uploaded_file($_FILES['upload']['tmp_name'], $target_file)) {
                    throw new FileUploadException("Failed to upload file!");
                }
            }
            $product = new Product($this->db, trim($_POST['name']), $_POST['price'], trim($_POST['description']), $_POST['quantity'], $_POST['categories'], basename($_FILES["upload"]["name"]), $_POST['id']);
            if($_POST['script'] == 'add')
            {
                $product->insertIntoDataBase();
                $_POST['id'] = $this->db->lastInsertId();
                $product->setId($this->db->lastInsertId());
                foreach ($_POST['categories'] as $category)
                {
                    $product_category = $this->db->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                    $product_category->execute([
                        'product_id' => $_POST['id'],
                        'category_id' => $category
                    ]);
                }
            }
            if($_POST['script'] == 'edit')
            {
                $product->updateDatabase();
                $delete = $this->db->prepare("DELETE FROM product_category WHERE product_id=:product_id");
                $delete->execute(['product_id' => $_POST['id']]);
                foreach ($_POST['categories'] as $category)
                {
                    $product_category = $this->db->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                    $product_category->execute([
                        'product_id' => $_POST['id'],
                        'category_id' => $category
                    ]);
                }
            }
        }
        header("Location: ../home");
    }

    public function renderProduct($response)
    {
        if(isset($_GET['id']))
        {
            new Model($this->db);
            $product = $this->db->prepare("SELECT * FROM products WHERE id=:id");
            $product->execute(['id' => $_GET['id']]);
            $product = $product->fetchAll(PDO::FETCH_CLASS);
            return $response->setBody('app/views/ProductView.php', [
                'product' => $product[0],
                'categories' => Categories::GetCategoriesOfProduct($_GET['id'])
            ]);
        }
        header('Location: home');
    }

    protected function checkPermission()
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException('You do not have permission to do that!');
    }

    protected function checkFilenameLength ($filename)
    {
        return mb_strlen($filename,"UTF-8") < 100;
    }
}