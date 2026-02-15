# 🛒 Produktový katalóg - PHP OOP Aplikácia

Jednoduchá PHP aplikácia na zobrazenie produktového katalógu e-shopu s použitím OOP princípov.

## 📋 Požiadavky

- PHP 7.3 alebo vyššie
- MySQL 5.7 alebo vyššie
- Web server (Apache/Nginx) alebo PHP built-in server

## 🚀 Inštalácia

### 1. Vytvorenie databázy

Cez phpMyAdmin:
1. Otvorte phpMyAdmin
2. Vytvorte novú databázu `product-catalog`
3. Importujte súbor `schema.sql`

### 2. Konfigurácia databázového pripojenia

Otvorte súbor `Database.php` a upravte prihlasovacie údaje:
```php
private $host = 'localhost';
private $dbname = 'product-catalog';
private $username = 'root';      // Vaše MySQL username
private $password = 'root';      // Vaše MySQL heslo
```

### 3. Spustenie aplikácie

#### WAMP/XAMPP:
Skopírujte všetky súbory do root priečinka vášho web servera (napr. `C:\wamp\www\product-catalog\`)

Otvorte prehliadač: `http://localhost/product-catalog/`

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
- ✅ Zobrazenie produktov s fotkami
- ✅ Vizuálne označenie produktov bez zásob
- ✅ Responzívny dizajn (vlastné CSS)
- ✅ PDO prepared statements (ochrana pred SQL injection)

### Bonus funkcie ⭐

- ⭐ Filtrovanie produktov (all / in stock)
- ⭐ Zoradenie podľa názvu, ceny, dostupnosti, dátumu
- ⭐ Detailná stránka produktu (`detail.php?id=X`)
- ⭐ Moderný gradient dizajn s hover efektami
- ⭐ Produktové fotky z Unsplash

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

## 🛠️ Technológie

- **Backend**: PHP 7.3+ (čistý PHP, bez frameworku)
- **Database**: MySQL s PDO
- **Frontend**: HTML5, CSS3 (vlastné)
- **Architecture**: OOP, Repository pattern, Singleton pattern

## 🎯 OOP Princípy

1. **Encapsulation** - private properties s public getters/setters
2. **Singleton Pattern** - jediná inštancia databázového pripojenia
3. **Repository Pattern** - oddelenie data access logiky
4. **Type Safety** - validácia vstupných dát
5. **Single Responsibility** - každá trieda má jednu zodpovednosť

## 📝 Poznámky

- Aplikácia je kompatibilná s PHP 7.3+
- Použité Unsplash API pre produktové fotky
- Kód je komentovaný v slovenčine
