<?php

require_once 'Database.php';
require_once 'Product.php';

/**
 * ProductRepository - Data Access Layer
 * Kompatibilné s PHP 7.3+
 */
class ProductRepository
{
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll()
    {
        $query = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $this->fetchProducts($stmt);
    }
    
    public function getById($id)
    {
        $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $products = $this->fetchProducts($stmt);
        return isset($products[0]) ? $products[0] : null;
    }
    
    public function getActive()
    {
        $query = "SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $this->fetchProducts($stmt);
    }
    
    public function getInStock()
    {
        $query = "SELECT * FROM products WHERE is_active = 1 AND stock_quantity > 0 ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $this->fetchProducts($stmt);
    }
    
    public function getAllSorted($sortBy = 'created_at', $order = 'DESC')
    {
        $allowedColumns = array('name', 'price', 'stock_quantity', 'created_at');
        $allowedOrders = array('ASC', 'DESC');
        
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }
        
        if (!in_array(strtoupper($order), $allowedOrders)) {
            $order = 'DESC';
        }
        
        $query = "SELECT * FROM products WHERE is_active = 1 ORDER BY {$sortBy} {$order}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $this->fetchProducts($stmt);
    }
    
    private function fetchProducts($stmt)
    {
        $products = array();
        
        while ($row = $stmt->fetch()) {
            $product = new Product();
            $product->setId((int)$row['id']);
            $product->setName($row['name']);
            $product->setSku($row['sku']);
            
            // Pridanie podpory pre obrázok
            if (isset($row['image_url'])) {
                $product->setImageUrl($row['image_url']);
            }
            
            $product->setPrice((float)$row['price']);
            $product->setStockQuantity((int)$row['stock_quantity']);
            $product->setIsActive((bool)$row['is_active']);
            $product->setCreatedAt($row['created_at']);
            
            $products[] = $product;
        }
        
        return $products;
    }
    
    public function getTotalCount()
    {
        $query = "SELECT COUNT(*) as count FROM products WHERE is_active = 1";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch();
        
        return (int)$result['count'];
    }
}
