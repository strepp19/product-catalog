<?php
require_once 'ProductRepository.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId <= 0) {
    header('Location: index.php');
    exit;
}

$repository = new ProductRepository();
$product = $repository->getById($productId);

if (!$product) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product->getName()); ?> - Detail produktu</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .back-button {
            display: inline-block;
            padding: 12px 24px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        .product-detail {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .product-detail.out-of-stock {
            border-top: 5px solid #e74c3c;
        }
        
        .product-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
        }
        
        .product-image-container {
            position: relative;
        }
        
        .product-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 12px;
            background: #f5f5f5;
        }
        
        .product-image.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 120px;
            color: #ccc;
        }
        
        .product-info-main {
            display: flex;
            flex-direction: column;
        }
        
        .product-sku {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
            align-self: flex-start;
        }
        
        h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
        }
        
        .out-of-stock h1 {
            text-decoration: line-through;
            color: #999;
        }
        
        .product-price {
            font-size: 3em;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .out-of-stock .product-price {
            color: #999;
        }
        
        .stock-status {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            align-self: flex-start;
        }
        
        .stock-status.in-stock {
            background: #d4edda;
            color: #155724;
        }
        
        .stock-status.out-of-stock {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .status-badge.active {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .product-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 40px;
            background: #f8f9fa;
        }
        
        .info-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        
        .info-value {
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
        }
        
        .product-description {
            background: #f8f9fa;
            padding: 25px 40px 40px 40px;
            line-height: 1.8;
        }
        
        .product-description h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .product-main {
                grid-template-columns: 1fr;
                padding: 25px;
            }
            
            .product-info {
                grid-template-columns: 1fr;
                padding: 25px;
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            .product-price {
                font-size: 2.2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-button">← Späť na katalóg</a>
        
        <div class="product-detail <?php echo !$product->isInStock() ? 'out-of-stock' : ''; ?>">
            <div class="product-main">
                <div class="product-image-container">
                    <?php if ($product->hasImage()): ?>
                        <img src="<?php echo htmlspecialchars($product->getImageUrl()); ?>" 
                             alt="<?php echo htmlspecialchars($product->getName()); ?>" 
                             class="product-image">
                    <?php else: ?>
                        <div class="product-image placeholder">📦</div>
                    <?php endif; ?>
                </div>
                
                <div class="product-info-main">
                    <span class="product-sku">SKU: <?php echo htmlspecialchars($product->getSku()); ?></span>
                    <h1><?php echo htmlspecialchars($product->getName()); ?></h1>
                    <div class="product-price"><?php echo $product->getFormattedPrice(); ?></div>
                    
                    <?php if ($product->isInStock()): ?>
                        <span class="stock-status in-stock">✓ Produkt je skladom</span>
                    <?php else: ?>
                        <span class="stock-status out-of-stock">✗ Produkt nie je skladom</span>
                    <?php endif; ?>
                    
                    <?php if ($product->isActive()): ?>
                        <span class="status-badge active">Aktívny produkt</span>
                    <?php else: ?>
                        <span class="status-badge inactive">Neaktívny produkt</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="product-info">
                <div class="info-box">
                    <div class="info-label">📦 Dostupnosť</div>
                    <div class="info-value"><?php echo $product->getStockQuantity(); ?> ks</div>
                </div>
                
                <div class="info-box">
                    <div class="info-label">💰 Cena za kus</div>
                    <div class="info-value"><?php echo $product->getFormattedPrice(); ?></div>
                </div>
                
                <div class="info-box">
                    <div class="info-label">📅 Pridané</div>
                    <div class="info-value">
                        <?php 
                        $date = new DateTime($product->getCreatedAt());
                        echo $date->format('d.m.Y');
                        ?>
                    </div>
                </div>
                
                <div class="info-box">
                    <div class="info-label">🔖 Kód produktu</div>
                    <div class="info-value"><?php echo htmlspecialchars($product->getSku()); ?></div>
                </div>
            </div>
            
            <div class="product-description">
                <h3>📋 Informácie o produkte</h3>
                <p>
                    <strong><?php echo htmlspecialchars($product->getName()); ?></strong> je <?php echo $product->isInStock() ? 'momentálne dostupný' : 'aktuálne nedostupný'; ?> 
                    v našom sklade. 
                    <?php if ($product->isInStock()): ?>
                        Máme na sklade <?php echo $product->getStockQuantity(); ?> <?php echo $product->getStockQuantity() === 1 ? 'kus' : 'kusov'; ?>.
                    <?php else: ?>
                        Produkt momentálne nie je skladom, ale môžete ho sledovať pre notifikáciu o dostupnosti.
                    <?php endif; ?>
                </p>
                <p style="margin-top: 15px;">
                    Cena produktu je <strong><?php echo $product->getFormattedPrice(); ?></strong>. 
                    Produkt bol pridaný do katalógu 
                    <?php 
                    $date = new DateTime($product->getCreatedAt());
                    echo $date->format('d.m.Y');
                    ?>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
