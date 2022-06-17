<?php
namespace app\controllers;

use app\exceptions\FileUploadException;
use app\exceptions\NoPermissionException;
use app\exceptions\PageNotFoundException;
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
        return $response->setBody('app/views/ProductForm.php', [
            'script' => 'add'
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
            return $response->setBody('app/views/ProductForm.php', [
                'product' => $product[0],
                'script' => 'edit'
            ]);
        }
        throw new PageNotFoundException('Page you are looking for has not been found!');
    }

    public function submit()
    {
        if(isset($_POST['submit']))
        {
            $target_dir = dirname(__DIR__) . "\images\\";
            $target_file = $target_dir . basename($_FILES["upload"]["name"]);

            //check for supported extensions
            $extension = explode('.', basename($_FILES["upload"]["name"]));
            if(!in_array(end($extension), $this->supportedExtensions))
            {
                echo "Supported extensions are ";
                foreach ($this->supportedExtensions as $supportedExtension)
                    echo strtoupper($supportedExtension) . ', ';
                return;
            }

            if(!$this->checkFilenameLength(basename($_FILES["upload"]["name"])))
            {
                echo "Filename to long, maximum is 100 characters";
                return;
            }

            if (!move_uploaded_file($_FILES['upload']['tmp_name'], $target_file)) {
                throw new FileUploadException("Failed to upload file!");
            }
            $product = new Product($this->db, trim($_POST['name']), $_POST['price'], trim($_POST['description']), basename($_FILES["upload"]["name"]), $_POST['id']);
            if($_POST['script'] == 'add')
                $product->insertIntoDataBase();
            if($_POST['script'] == 'edit')
                $product->updateDatabase();
        }
        header("Location: ../home");
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