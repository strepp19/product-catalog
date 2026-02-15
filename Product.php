<?php

/**
 * Product class - reprezentuje jeden produkt
 * Kompatibilné s PHP 7.3+
 */
class Product
{
    private $id = null;
    private $name;
    private $sku;
    private $imageUrl = null;
    private $price;
    private $stockQuantity;
    private $isActive;
    private $createdAt = null;
    
    public function __construct($name = '', $sku = '', $price = 0.0, $stockQuantity = 0, $isActive = true)
    {
        $this->name = $name;
        $this->sku = $sku;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->isActive = $isActive;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getSku()
    {
        return $this->sku;
    }
    
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }
    
    public function isActive()
    {
        return $this->isActive;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
    
    public function setPrice($price)
    {
        if ($price < 0) {
            throw new InvalidArgumentException("Price cannot be negative");
        }
        $this->price = $price;
    }
    
    public function setStockQuantity($stockQuantity)
    {
        if ($stockQuantity < 0) {
            throw new InvalidArgumentException("Stock quantity cannot be negative");
        }
        $this->stockQuantity = $stockQuantity;
    }
    
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    public function isInStock()
    {
        return $this->stockQuantity > 0;
    }
    
    public function getFormattedPrice()
    {
        return number_format($this->price, 2, ',', ' ') . ' €';
    }
    
    public function hasImage()
    {
        return !empty($this->imageUrl);
    }
}
