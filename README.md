# Gauri Suits & Jewel — Luxury Couture & Fine Jewellery E-Commerce

A bespoke, production-ready e-commerce platform built for **Gauri Suits & Jewel** — a luxury Punjabi couture and heirloom fine jewellery brand inspired by editorial high fashion and featuring a powerful administrative command center.

---

## 👑 Brand Aesthetic & Color Palette

The entire design is crafted around the finalized brand logo and a regal 3-color palette:

- **Maroon (Primary Brand Color)**: `#58111A`, `#4A0E17`, `#3B0A11` — Used for sticky navigation headers, primary CTA buttons, cart drawer header, prices, and sale badges.
- **Emerald Green (Secondary / Accent Color)**: `#083323`, `#0A3828`, `#0D4732` — Used for the announcement bar, 4-Pillar Heritage Trust Bar, Free Shipping unlocked progress bar, "NEW" badges, and WhatsApp stylist button.
- **Gold (Highlights, Buttons & Borders)**: `#D4AF37`, `#C5A869`, `#E6CA65` — Used for metallic borders, filigree ornaments (`✦`, `❦`), navigation hover underlines, star ratings, and luxury badges.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 12 (PHP 8.2+), Eloquent ORM, MySQL 8.0
- **Frontend**: Blade Templating, Tailwind CSS v4, Alpine.js 3.x, Chart.js 4.x, Vite 7
- **Payments**: Razorpay Gateway (Web checkout modal, SHA256 signature verification, webhook handler) & Cash on Delivery (COD)
- **Logistics & Shipping**: Multi-tier dynamic courier rate engine with free shipping threshold tracker (₹2,999 default)
- **Testing**: PHPUnit / Laravel Feature Tests (100% pass rate, 20 tests, 118 assertions)

---

## 🚀 Getting Started & Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL / MariaDB (e.g. XAMPP, Laragon, or standalone MySQL)
- Node.js & NPM (optional, pre-compiled production assets are included in `public/build/`)

### 1. Clone the Repository
```bash
git clone https://github.com/manish09101996/Gauri-suits-Jewel.git
cd Gauri-suits-Jewel
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Setup Environment File
Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```
Generate the application encryption key:
```bash
php artisan key:generate
```

### 4. Database Setup & SQL Import
You can either import the full database dump or run migrations and seeders:

#### Option A: Import provided SQL Dump (Recommended)
1. Create a MySQL database named `gauri_suits_jewel`:
   ```sql
   CREATE DATABASE gauri_suits_jewel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Import `gauri_suits_jewel.sql` located in the root or `database/` folder:
   ```bash
   mysql -u root -p gauri_suits_jewel < gauri_suits_jewel.sql
   ```

#### Option B: Run Laravel Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 5. Compile Assets (Optional)
Pre-built assets are included in `public/build/`. To rebuild manually:
```bash
npm install
npm run build
```

### 6. Start Development Server
```bash
php artisan serve
```
Visit: **`http://127.0.0.1:8000`**

---

## 🔐 Default Access & Credentials

### Super Admin Command Center
- **URL**: `http://127.0.0.1:8000/admin/login`
- **Email**: `admin@gaurisuits.com`
- **Password**: `password`

### Test Customer Accounts
- **Customer 1**: `customer@example.com` / `password`
- **Customer 2**: `harleen.dhillon@gmail.com` / `password`

### Active Promotional Coupons
- **`GAURI10`**: 10% discount on orders above ₹1,999 (Max ₹1,000 off)
- **`ROYAL15`**: 15% discount on orders above ₹4,999 (Max ₹2,500 off)
- **`WEDDING500`**: Flat ₹500 off on orders above ₹3,499

---

## 📦 Key Features

### Storefront
- **Editorial Homepage**: Hero carousel, "Adorn Every Part of You" collections, real-time best sellers, shoppable video reels with quick-buy drawer, customer reviews slider.
- **Faceted Product Filtering**: Live filter by Category, Price Range, Fabric (Mulberry Silk, Micro-Velvet, Chanderi, Georgette), Occasion, and Availability.
- **Dynamic Variant Matrix**: Live size, stitching option, price calculations, and low-stock indicators.
- **Pincode Delivery Estimator**: Real-time delivery time calculation.
- **Sliding Cart Drawer**: Alpine.js slide-out drawer with gamified Free Shipping threshold tracker (₹2,999).
- **Express 2-Step Checkout**: Full address capture, coupon code application, shipping tier selection, and Razorpay/COD integration.
- **Order Tracking**: Public order tracking lookup by Order ID & Email/Phone at `/track`.
- **Printable Tax Invoices**: GST-compliant invoices with watermark and detailed line items.

### Admin Command Center
- **Executive Analytics**: 4 live calculated KPI cards, 30-day sales trend charts, top performing products, and category revenue breakdown.
- **Order Management Workflow**: Status transition pipeline (`pending` &rarr; `processing` &rarr; `packed` &rarr; `shipped` &rarr; `delivered`), AWB tracking assignment, and invoice generation.
- **Manual Order Creator**: In-store / telephone concierge order booking interface.
- **Catalog Management**: Full CRUD for products, variants, collections, categories, coupons, and customer reviews moderation.
- **Live Traffic Monitor**: Active online visitor tracking table.

---

## 🧪 Running Automated Tests

Run the full PHPUnit / Pest test suite:
```bash
php artisan test
```
*All 20 tests and 118 assertions pass.*

---

## 📄 License

Proprietary — Developed for **Gauri Suits & Jewel**. All rights reserved.
