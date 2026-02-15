<?php
require_once 'ProductRepository.php';

// Spracovanie filtrov a zoradenia
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$repository = new ProductRepository();

// Získanie produktov podľa filtra
if ($filter === 'in_stock') {
    $products = $repository->getInStock();
} else {
    $products = $repository->getAllSorted($sortBy, $order);
}

$totalProducts = $repository->getTotalCount();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktový katalóg</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            font-size: 1.1em;
        }
        
        .filters {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .filters label {
            font-weight: 600;
            color: #555;
        }
        
        .filters select {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filters select:hover {
            border-color: #667eea;
        }
        
        .filters button {
            padding: 10px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filters button:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        
        .product-card.out-of-stock {
            opacity: 0.7;
        }
        
        .product-card.out-of-stock::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: #e74c3c;
            z-index: 10;
        }
        
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #f5f5f5;
        }
        
        .product-image.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: #ccc;
        }
        
        .product-content {
            padding: 25px;
        }
        
        .product-sku {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            margin-bottom: 15px;
        }
        
        .product-name {
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            min-height: 60px;
        }
        
        .product-card.out-of-stock .product-name {
            text-decoration: line-through;
            color: #999;
        }
        
        .product-price {
            font-size: 1.8em;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .product-card.out-of-stock .product-price {
            color: #999;
        }
        
        .stock-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .stock-status.in-stock {
            background: #d4edda;
            color: #155724;
        }
        
        .stock-status.out-of-stock {
            background: #f8d7da;
            color: #721c24;
        }
        
        .stock-quantity {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        
        .view-details {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .view-details:hover {
            background: #5568d3;
        }
        
        .product-card.out-of-stock .view-details {
            background: #ccc;
            pointer-events: none;
        }
        
        .empty-state {
            background: white;
            padding: 60px;
            border-radius: 12px;
            text-align: center;
            color: #666;
        }
        
        .empty-state h2 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #999;
        }
        
        footer {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            color: #666;
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            .filters {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filters select,
            .filters button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🛒 Produktový katalóg</h1>
            <p class="subtitle">Celkom <?php echo $totalProducts; ?> produktov v ponuke</p>
        </header>
        
        <div class="filters">
            <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; width: 100%;">
                <div>
                    <label for="filter">Filter:</label>
                    <select name="filter" id="filter">
                        <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>Všetky produkty</option>
                        <option value="in_stock" <?php echo $filter === 'in_stock' ? 'selected' : ''; ?>>Len skladom</option>
                    </select>
                </div>
                
                <div>
                    <label for="sort">Zoradiť podľa:</label>
                    <select name="sort" id="sort">
                        <option value="created_at" <?php echo $sortBy === 'created_at' ? 'selected' : ''; ?>>Dátum pridania</option>
                        <option value="name" <?php echo $sortBy === 'name' ? 'selected' : ''; ?>>Názov</option>
                        <option value="price" <?php echo $sortBy === 'price' ? 'selected' : ''; ?>>Cena</option>
                        <option value="stock_quantity" <?php echo $sortBy === 'stock_quantity' ? 'selected' : ''; ?>>Dostupnosť</option>
                    </select>
                </div>
                
                <div>
                    <label for="order">Poradie:</label>
                    <select name="order" id="order">
                        <option value="ASC" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>Vzostupne</option>
                        <option value="DESC" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Zostupne</option>
                    </select>
                </div>
                
                <button type="submit">Použiť</button>
            </form>
        </div>
        
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <h2>😔 Žiadne produkty</h2>
                <p>Momentálne sa nenašli žiadne produkty podľa vašich kritérií.</p>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card <?php echo !$product->isInStock() ? 'out-of-stock' : ''; ?>">
                        <?php if ($product->hasImage()): ?>
                            <img src="<?php echo htmlspecialchars($product->getImageUrl()); ?>" 
                                 alt="<?php echo htmlspecialchars($product->getName()); ?>" 
                                 class="product-image">
                        <?php else: ?>
                            <div class="product-image placeholder">📦</div>
                        <?php endif; ?>
                        
                        <div class="product-content">
                            <span class="product-sku"><?php echo htmlspecialchars($product->getSku()); ?></span>
                            <h2 class="product-name"><?php echo htmlspecialchars($product->getName()); ?></h2>
                            <div class="product-price"><?php echo $product->getFormattedPrice(); ?></div>
                            
                            <?php if ($product->isInStock()): ?>
                                <span class="stock-status in-stock">✓ Skladom</span>
                                <div class="stock-quantity">Dostupných kusov: <?php echo $product->getStockQuantity(); ?></div>
                            <?php else: ?>
                                <span class="stock-status out-of-stock">✗ Nie je skladom</span>
                            <?php endif; ?>
                            
                            <a href="detail.php?id=<?php echo $product->getId(); ?>" class="view-details">Zobraziť detail</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Produktový katalóg | Vytvorené s PHP & OOP</p>
        </footer>
    </div>
</body>
</html>
