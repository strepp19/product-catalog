# 🛒 Produktový katalóg - PHP OOP Aplikácia

Jednoduchá PHP aplikácia na zobrazenie produktového katalógu e-shopu s použitím OOP princípov.

## 📋 Požiadavky

- PHP 7.4 alebo vyššie
- MySQL 5.7 alebo vyššie
- Web server (Apache/Nginx) alebo PHP built-in server

## 🚀 Inštalácia

### 1. Vytvorenie databázy

```bash
# Prihláste sa do MySQL
mysql -u root -p

# Vytvorte databázu a naimportujte schému
mysql -u root -p < schema.sql
```

Alebo cez phpMyAdmin:
1. Otvorte phpMyAdmin
2. Vytvorte novú databázu `product_catalog`
3. Importujte súbor `schema.sql`

### 2. Konfigurácia databázového pripojenia

Otvorte súbor `Database.php` a upravte prihlasovacie údaje:

```php
private string $host = 'localhost';
private string $dbname = 'product_catalog';
private string $username = 'root';      // Vaše MySQL username
private string $password = '';          // Vaše MySQL heslo
```

### 3. Spustenie aplikácie

#### Možnosť A: PHP Built-in Server (najjednoduchšie)

```bash
php -S localhost:8000
```

Potom otvorte prehliadač na `http://localhost:8000`

#### Možnosť B: Apache/Nginx

Skopírujte všetky súbory do root priečinka vášho web servera (napr. `htdocs`, `www`, `public_html`)

## 📁 Štruktúra projektu

```
├── schema.sql              # Databázová schéma s ukážkovými dátami
├── Database.php            # Singleton trieda pre databázové pripojenie
├── Product.php             # Model produktu s getters/setters
├── ProductRepository.php   # Data Access Layer pre produkty
├── index.php              # Hlavná stránka s katalógom
├── detail.php             # Detailná stránka produktu (bonus)
└── README.md              # Dokumentácia
```

## ✨ Funkcie

### Základné požiadavky ✅

- ✅ Databáza s tabuľkou `products`
- ✅ 5 ukážkových produktov
- ✅ OOP triedy: `Product`, `Database`, `ProductRepository`
- ✅ Zobrazenie produktov v prehľadnej forme
- ✅ Vizuálne označenie produktov bez zásob
- ✅ Responzívny dizajn (vlastné CSS)
- ✅ PDO prepared statements (ochrana pred SQL injection)

### Bonus funkcie ⭐

- ⭐ Filtrovanie produktov (all / in stock)
- ⭐ Zoradenie podľa názvu, ceny, dostupnosti, dátumu
- ⭐ Detailná stránka produktu (`detail.php?id=X`)
- ⭐ Moderný gradient dizajn s hover efektami
- ⭐ Počítadlo celkového počtu produktov

## 🔒 Bezpečnosť

- **PDO prepared statements** - ochrana pred SQL injection
- **Input validácia** - kontrola GET parametrov
- **Whitelist stĺpcov** - pri zoraďovaní len povolené stĺpce
- **HTML escaping** - `htmlspecialchars()` na všetkých výstupoch

## 🎨 Dizajn

- Moderný gradient pozadie (fialová → ružová)
- Responzívny grid layout (3 stĺpce → 1 stĺpec na mobile)
- Karty s hover efektami a tieňmi
- Vizuálne odlíšenie produktov bez zásob (červená čiara, prečiarknutie)
- Badge pre dostupnosť (zelený/červený)

## 🧪 Testovanie

1. Otvorte `index.php` - mali by ste vidieť 4 aktívne produkty
2. Vyskúšajte filter "Len skladom" - zobrazí sa 3 produkty
3. Zmeňte zoradenie na "Cena" - produkty sa preusporiadajú
4. Kliknite na "Zobraziť detail" - otvorí sa detailná stránka
5. Produkty bez zásob majú prečiarknutý názov a červenú farbu

## 🛠️ Technológie

- **Backend**: PHP 7.4+ (čistý PHP, bez frameworku)
- **Database**: MySQL s PDO
- **Frontend**: HTML5, CSS3 (vlastné, bez Bootstrapu)
- **Architecture**: OOP, Repository pattern, Singleton pattern

## 📊 Databázová schéma

```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## 🎯 OOP Princípy použité v projekte

1. **Encapsulation** - private properties s public getters/setters v `Product.php`
2. **Singleton Pattern** - jediná inštancia databázového pripojenia v `Database.php`
3. **Repository Pattern** - oddelenie data access logiky v `ProductRepository.php`
4. **Type Hinting** - striktné typy parametrov a návratových hodnôt
5. **Single Responsibility** - každá trieda má jednu zodpovednosť

## 📝 Poznámky

- Aplikácia je pripravená na ďalšie rozšírenie (admin rozhranie, košík, objednávky)
- Kód je komentovaný v slovenčine pre lepšiu čitateľnosť
- Dizajn je moderný a používateľsky prívetivý
- Všetky vstupné dáta sú validované a escapované

## 👨‍💻 Autor

Vytvorené ako test zadanie pre pozíciu PHP Developer

## 📄 Licencia

Voľne použiteľné pre študijné a testovacie účely
