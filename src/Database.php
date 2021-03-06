<?php

require_once __DIR__ . '/../src/Product.php';
class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('sqlite:' . __DIR__ .
            '\..\data\products.sqlite3');
    }

    public function createTableProducts()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS products (
					id INTEGER PRIMARY KEY, 
					description TEXT, 
					quantity INTEGER)';
        $this->pdo->exec($sql);
    }

    public function insertProduct($description, $quantity)
    {
        // Prepare INSERT statement to SQLite3 file db
        $sql = 'INSERT INTO products (description, quantity) 
			VALUES (:description, :quantity)';
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quantity', $quantity);

        // Execute statement
        $stmt->execute();

    }

    public function getAllProducts()
    {
        $sql = 'SELECT * FROM products';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_CLASS, 'Product');
        return $products;
    }

    public function dropTableProducts()
    {
        // Drop table messages from file db
        $this->pdo->exec('DROP TABLE products');
    }

    public function printProduct($product)
    {
        print '<hr>';
        print "<br>Id: " . $product->getId();
        print "<br>Product: " . $product->getDescription();
        print "<br>Quantity: " . $product->getQuantity();
    }






}
