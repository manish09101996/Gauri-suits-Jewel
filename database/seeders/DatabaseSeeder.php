<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Reel;
use App\Models\Review;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Shipment;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate existing seed tables to allow clean re-runs
        Admin::truncate();
        Role::truncate();
        DB::table('admin_roles')->truncate();
        User::truncate();
        Address::truncate();
        Category::truncate();
        Collection::truncate();
        Product::truncate();
        ProductImage::truncate();
        ProductVariant::truncate();
        DB::table('collection_product')->truncate();
        Coupon::truncate();
        Order::truncate();
        OrderItem::truncate();
        Payment::truncate();
        Shipment::truncate();
        ShippingZone::truncate();
        ShippingRate::truncate();
        Banner::truncate();
        Video::truncate();
        Reel::truncate();
        Review::truncate();
        BlogPost::truncate();
        Setting::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Roles & Admin
        $superAdminRole = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Administrator',
            'description' => 'Full access to all administrative modules, settings, and orders.'
        ]);

        $orderManagerRole = Role::create([
            'name' => 'order_manager',
            'display_name' => 'Order & Inventory Manager',
            'description' => 'Manage orders, fulfillment, shipments, and stock movements.'
        ]);

        $admin = Admin::create([
            'name' => 'Gauri Master Admin',
            'email' => 'admin@gaurisuits.com',
            'password' => Hash::make('password'),
            'phone' => '+91 98765 43210',
            'role' => 'super_admin',
            'is_active' => true,
        ]);
        $admin->roles()->attach($superAdminRole->id);

        // 2. Settings
        $settings = [
            ['key' => 'store_name', 'value' => 'Gauri Suits & Jewel', 'group' => 'general'],
            ['key' => 'store_tagline', 'value' => 'Heritage Punjabi Couture & Bespoke Fine Jewellery', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'care@gaurisuits.com', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+91 98765 43210', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '919876543210', 'group' => 'general'],
            ['key' => 'store_address', 'value' => 'Heritage Couture Arcade, Sector 17-C, Chandigarh, Punjab 160017', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => '₹', 'group' => 'general'],
            ['key' => 'currency_code', 'value' => 'INR', 'group' => 'general'],
            ['key' => 'free_shipping_threshold', 'value' => '2999', 'group' => 'shipping'],
            ['key' => 'flat_shipping_rate', 'value' => '150', 'group' => 'shipping'],
            ['key' => 'cod_enabled', 'value' => '1', 'group' => 'payment'],
            ['key' => 'cod_max_limit', 'value' => '25000', 'group' => 'payment'],
            ['key' => 'razorpay_key_id', 'value' => 'rzp_test_gauri_mock_key', 'group' => 'payment'],
            ['key' => 'razorpay_key_secret', 'value' => 'mock_secret_gauri_12345', 'group' => 'payment'],
            ['key' => 'announcement_bar', 'value' => 'Complimentary Express Shipping Across India on Orders Above ₹2,999 | Worldwide Express Delivery Available', 'group' => 'general'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/gaurisuitsjewel', 'group' => 'social'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/gaurisuitsjewel', 'group' => 'social'],
        ];
        foreach ($settings as $s) {
            Setting::create($s);
        }

        // 3. Shipping Zones & Rates
        $allIndiaZone = ShippingZone::create([
            'name' => 'Domestic India (All States & UTs)',
            'states' => json_encode(['Punjab', 'Delhi', 'Haryana', 'Chandigarh', 'Maharashtra', 'Karnataka', 'Rajasthan', 'Uttar Pradesh', 'Gujarat', 'West Bengal', 'Tamil Nadu', 'Telangana']),
            'is_active' => true,
        ]);

        ShippingRate::create([
            'zone_id' => $allIndiaZone->id,
            'name' => 'Standard Express Logistics',
            'min_order_amount' => 0,
            'max_order_amount' => 2998.99,
            'rate' => 150.00,
            'estimated_days' => '3-5 Business Days',
            'is_active' => true,
        ]);

        ShippingRate::create([
            'zone_id' => $allIndiaZone->id,
            'name' => 'Complimentary Royal Delivery',
            'min_order_amount' => 2999.00,
            'max_order_amount' => null,
            'rate' => 0.00,
            'estimated_days' => '2-4 Business Days',
            'is_active' => true,
        ]);

        // 4. Categories
        $suitsCategory = Category::create([
            'name' => 'Punjabi Suits',
            'slug' => 'punjabi-suits',
            'description' => 'Authentic handcrafted Punjabi silhouettes, bespoke salwar kameez, and heirloom party wear.',
            'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=800&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $catUnstitched = Category::create([
            'parent_id' => $suitsCategory->id,
            'name' => 'Unstitched Suits',
            'slug' => 'unstitched-suits',
            'description' => 'Pure Chanderi, Georgette, and Organza unstitched fabrics with intricate handwork.',
            'image' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=800&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2,
        ]);

        $catPatiala = Category::create([
            'parent_id' => $suitsCategory->id,
            'name' => 'Stitched Patiala Suits',
            'slug' => 'patiala-suits',
            'description' => 'Classic Punjabi Shahi Patiala suits paired with heavy phulkari and tilla borders.',
            'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=800&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 3,
        ]);

        $catAnarkali = Category::create([
            'parent_id' => $suitsCategory->id,
            'name' => 'Bridal Anarkali Ensembles',
            'slug' => 'anarkali-suits',
            'description' => 'Flared floor-length royal Kalidar Anarkalis embellished with Dabka and Zardozi.',
            'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=800&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 4,
        ]);

        $catVelvet = Category::create([
            'parent_id' => $suitsCategory->id,
            'name' => 'Velvet Festive Suits',
            'slug' => 'velvet-suits',
            'description' => 'Opulent micro-velvet suits adorned with antique Kashmiri tilla work.',
            'image' => 'https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=800&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 5,
        ]);

        $jewelleryCategory = Category::create([
            'name' => 'Fine Jewellery',
            'slug' => 'jewellery',
            'description' => 'Heirloom Kundan, uncut Polki, Jadau, and Meenakari bridal jewellery.',
            'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=800&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 6,
        ]);

        $catKundan = Category::create([
            'parent_id' => $jewelleryCategory->id,
            'name' => 'Necklaces & Chokers',
            'slug' => 'kundan-necklaces',
            'description' => '22K gold-plated Kundan chokers with emerald drops and cultured pearls.',
            'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $catNath = Category::create([
            'parent_id' => $jewelleryCategory->id,
            'name' => 'Nath & Nose Rings',
            'slug' => 'nath-nose-rings',
            'description' => 'Exquisite bridal naths with delicate pearl chains.',
            'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2,
        ]);

        $catMathaPatti = Category::create([
            'parent_id' => $jewelleryCategory->id,
            'name' => 'Maang Tikka & Passa',
            'slug' => 'matha-patti-passa',
            'description' => 'Royal bridal headpieces, side passas, and maang tikkas.',
            'image' => 'https://images.unsplash.com/photo-1602751584552-8ba73aad10e1?q=80&w=600&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 3,
        ]);

        $catJhumkas = Category::create([
            'parent_id' => $jewelleryCategory->id,
            'name' => 'Chandbalis & Jhumkas',
            'slug' => 'chandbalis-jhumkas',
            'description' => 'Opulent statement earrings and traditional Punjabi jhumkis.',
            'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=600&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 4,
        ]);

        $catHathphool = Category::create([
            'parent_id' => $jewelleryCategory->id,
            'name' => 'Hathphool & Rings',
            'slug' => 'hathphool-rings',
            'description' => 'Artisanal hand chains, finger rings, and meenakari cuffs.',
            'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=600&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 5,
        ]);

        $catPayal = Category::create([
            'parent_id' => $jewelleryCategory->id,
            'name' => 'Payal & Anklets',
            'slug' => 'payal-anklets',
            'description' => 'Bridal payals with chiming ghungroos and traditional silver accents.',
            'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 6,
        ]);

        // 5. Collections
        $collBridal = Collection::create([
            'name' => 'Virasat Bridal Edit 2026',
            'slug' => 'virasat-bridal-edit-2026',
            'description' => 'An ode to ancestral grandeur with heavy Tilla embroidery and pure silk weaves.',
            'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1200&auto=format&fit=crop',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $collRoyalPatiala = Collection::create([
            'name' => 'The Shahi Patiala Heritage',
            'slug' => 'the-shahi-patiala-heritage',
            'description' => 'Authentic pleated silhouettes crafted by third-generation Punjabi master artisans.',
            'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1200&auto=format&fit=crop',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $collJewel = Collection::create([
            'name' => 'Heirloom Kundan Treasures',
            'slug' => 'heirloom-kundan-treasures',
            'description' => 'Handcrafted uncut Polki & Kundan jewels evoking the courts of Patiala and Lahore.',
            'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1200&auto=format&fit=crop',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // 6. Products & Variants & Images
        $productsData = [
            [
                'name' => 'Gulab Noor Zardozi Patiala Suit',
                'slug' => 'gulab-noor-zardozi-patiala-suit',
                'sku' => 'GS-PS-001',
                'category_id' => $catPatiala->id,
                'price' => 8999.00,
                'sale_price' => 7499.00,
                'cost_price' => 4200.00,
                'fabric' => 'Pure Mulberry Silk',
                'colour' => 'Rani Pink',
                'pattern' => 'Hand Embroidered Floral Arabesque',
                'work' => 'Dabka, Zari & Sequins',
                'occasion' => 'Festive & Wedding',
                'care_instructions' => 'Strictly Dry Clean Only',
                'weight' => 1.20,
                'stock' => 25,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new' => true,
                'short_description' => 'Handcrafted Rani Pink mulberry silk kurta paired with an opulent shahi pleated salwar and scalloped organza dupatta.',
                'description' => '<p>Immerse yourself in royal Punjabi tradition with the Gulab Noor Zardozi Patiala Suit. Handcrafted in our Chandigarh atelier, this ensemble features a pure mulberry silk kurta adorned with painstaking Dabka, Pitta, and antique Zari embroidery along the jewel neckline, cuffs, and hem. Accompanied by a lavishly gathered pure silk Patiala salwar and a gossamer organza dupatta finished with scalloped Gota borders.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [
                    ['size' => 'S', 'colour' => 'Rani Pink', 'sku' => 'GS-PS-001-S', 'stock' => 5],
                    ['size' => 'M', 'colour' => 'Rani Pink', 'sku' => 'GS-PS-001-M', 'stock' => 8],
                    ['size' => 'L', 'colour' => 'Rani Pink', 'sku' => 'GS-PS-001-L', 'stock' => 7],
                    ['size' => 'XL', 'colour' => 'Rani Pink', 'sku' => 'GS-PS-001-XL', 'stock' => 5],
                ],
                'collections' => [$collRoyalPatiala->id, $collBridal->id]
            ],
            [
                'name' => 'Noor-e-Kashmir Velvet Tilla Suit',
                'slug' => 'noor-e-kashmir-velvet-tilla-suit',
                'sku' => 'GS-VS-002',
                'category_id' => $catVelvet->id,
                'price' => 12999.00,
                'sale_price' => 10999.00,
                'cost_price' => 6000.00,
                'fabric' => 'Micro Velvet 9000',
                'colour' => 'Royal Maroon',
                'pattern' => 'Traditional Paisleys & Cypress Motifs',
                'work' => 'Antique Kashmiri Tilla Needlework',
                'occasion' => 'Winter Weddings & Receptions',
                'care_instructions' => 'Professional Dry Clean Only. Steam Iron with Cloth Cover.',
                'weight' => 1.80,
                'stock' => 18,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new' => true,
                'short_description' => 'Regal deep maroon micro-velvet ensemble enriched with intricate antique gold Kashmiri tilla embroidery.',
                'description' => '<p>Crafted for distinguished winter nuptials, the Noor-e-Kashmir suit features luxurious micro-velvet that drapes with stately grace. Artisans have hand-guided authentic silver and gold tilla threads across the neckline, front daman, and sleeves. Paired with tailored velvet pants and a pure tissue silk dupatta carrying hand-stitched borders.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [
                    ['size' => 'S', 'colour' => 'Royal Maroon', 'sku' => 'GS-VS-002-S', 'stock' => 4],
                    ['size' => 'M', 'colour' => 'Royal Maroon', 'sku' => 'GS-VS-002-M', 'stock' => 6],
                    ['size' => 'L', 'colour' => 'Royal Maroon', 'sku' => 'GS-VS-002-L', 'stock' => 5],
                    ['size' => 'XL', 'colour' => 'Royal Maroon', 'sku' => 'GS-VS-002-XL', 'stock' => 3],
                ],
                'collections' => [$collBridal->id]
            ],
            [
                'name' => 'Sheesh Mahal Kalidar Bridal Anarkali',
                'slug' => 'sheesh-mahal-kalidar-bridal-anarkali',
                'sku' => 'GS-AK-003',
                'category_id' => $catAnarkali->id,
                'price' => 24999.00,
                'sale_price' => 21999.00,
                'cost_price' => 12500.00,
                'fabric' => 'Pure Chanderi Silk & Organza',
                'colour' => 'Ivory Gold',
                'pattern' => 'Royal Mughal Floral Jali',
                'work' => 'Mukaish, Mirrorwork & Dabka Zari',
                'occasion' => 'Bridal, Anand Karaj & Sangeet',
                'care_instructions' => 'Preserve in Cotton Muslin. Strictly Dry Clean.',
                'weight' => 2.40,
                'stock' => 12,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new' => true,
                'short_description' => 'Magnificent 28-kali flared ivory silk Anarkali woven with hand-beaten silver and gold Mukaish motifs.',
                'description' => '<p>The Sheesh Mahal Bridal Anarkali reflects timeless imperial panache. Hand-tailored in 28 dramatic Kalis (panels), it provides an ethereal swirl. Embellished with genuine silver Mukaish dots, resham highlights, and hand-cut mirrors along the hemline. Paired with a churidar and a double-shaded scalloped dupatta.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [
                    ['size' => 'S', 'colour' => 'Ivory Gold', 'sku' => 'GS-AK-003-S', 'stock' => 3],
                    ['size' => 'M', 'colour' => 'Ivory Gold', 'sku' => 'GS-AK-003-M', 'stock' => 4],
                    ['size' => 'L', 'colour' => 'Ivory Gold', 'sku' => 'GS-AK-003-L', 'stock' => 3],
                    ['size' => 'XL', 'colour' => 'Ivory Gold', 'sku' => 'GS-AK-003-XL', 'stock' => 2],
                ],
                'collections' => [$collBridal->id]
            ],
            [
                'name' => 'Virasat Emerald Kundan Choker Set',
                'slug' => 'virasat-emerald-kundan-choker-set',
                'sku' => 'GS-JW-004',
                'category_id' => $catKundan->id,
                'price' => 6499.00,
                'sale_price' => 5499.00,
                'cost_price' => 2600.00,
                'fabric' => '22K Gold Plated Brass Core',
                'colour' => 'Emerald Green & Ivory',
                'pattern' => 'Jadau Royal Setting',
                'work' => 'Uncut Glass Polki, Hydro Emeralds & Cultured Pearls',
                'occasion' => 'Bridal & Festive Celebrations',
                'care_instructions' => 'Store in airtight box. Keep away from water and perfume.',
                'weight' => 0.35,
                'stock' => 30,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new' => true,
                'short_description' => 'Heirloom 22K gold-plated Kundan choker necklace accompanied by matching chandelier earrings and a maang tikka.',
                'description' => '<p>Elegantly crafted by hereditary jewelry artisans in Punjab and Rajasthan. This opulent choker features precision-set uncut Kundan stones, emerald beads, and tiers of delicate freshwater pearls. Adjustable royal dori silk tassel fits comfortably on any neck.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [],
                'collections' => [$collJewel->id, $collBridal->id]
            ],
            [
                'name' => 'Chandrika Pearl & Polki Chandbalis',
                'slug' => 'chandrika-pearl-polki-chandbalis',
                'sku' => 'GS-JW-005',
                'category_id' => $catJhumkas->id,
                'price' => 3499.00,
                'sale_price' => 2999.00,
                'cost_price' => 1300.00,
                'fabric' => 'Gold Plated Silver Alloy',
                'colour' => 'Antique Gold & Pearl',
                'pattern' => 'Crescent Moon Chandbali',
                'work' => 'Handcrafted Kundan with Meenakari Enamelling at Back',
                'occasion' => 'Festive, Engagement, Sangeet',
                'care_instructions' => 'Wipe with soft chamois cloth. Avoid exposure to alcohol-based sprays.',
                'weight' => 0.15,
                'stock' => 45,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new' => false,
                'short_description' => 'Statement crescent moon-shaped Polki Chandbalis with fine Meenakari floral reverse artwork and pearl clusters.',
                'description' => '<p>A tribute to timeless Punjabi grandeur. These Chandbalis frame the face with gentle radiance. Finished with traditional red and green Meenakari at the reverse and micro-pearl hanging drops.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [],
                'collections' => [$collJewel->id]
            ],
            [
                'name' => 'Bagh-e-Punjab Pure Chanderi Unstitched Suit',
                'slug' => 'bagh-e-punjab-pure-chanderi-unstitched-suit',
                'sku' => 'GS-US-006',
                'category_id' => $catUnstitched->id,
                'price' => 4999.00,
                'sale_price' => 4299.00,
                'cost_price' => 2200.00,
                'fabric' => 'Pure Chanderi Silk with Santoon Bottom',
                'colour' => 'Sage Green',
                'pattern' => 'Floral Botanical Resham Weave',
                'work' => 'Hand Gota Patti & Cutdana Detailing',
                'occasion' => 'Casual Chic, Mehendi, Pooja',
                'care_instructions' => 'Gentle Dry Clean Recommended',
                'weight' => 0.85,
                'stock' => 40,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new' => true,
                'short_description' => '3-piece luxury unstitched suit fabric featuring pure Chanderi silk with hand gota embroidery and matching Banarasi dupatta.',
                'description' => '<p>Tailor your silhouette precisely to your desire. Includes 2.5m pure Chanderi silk shirt with ornate neckline embroidery, 2.5m santoon salwar/trouser fabric, and a 2.5m lightweight handwoven dupatta with zardozi accents.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [
                    ['size' => 'Unstitched (3 Pc)', 'colour' => 'Sage Green', 'sku' => 'GS-US-006-UN', 'stock' => 40],
                ],
                'collections' => [$collRoyalPatiala->id]
            ],
            [
                'name' => 'Shahi Jadau Matha Patti & Passa Duo',
                'slug' => 'shahi-jadau-matha-patti-passa-duo',
                'sku' => 'GS-JW-007',
                'category_id' => $catMathaPatti->id,
                'price' => 4499.00,
                'sale_price' => 3899.00,
                'cost_price' => 1900.00,
                'fabric' => 'Gold Plated Alloy',
                'colour' => 'Gold & Ruby Red',
                'pattern' => 'Bridal Crown Geometry',
                'work' => 'Jadau Stone Inlay with Pearl Strings',
                'occasion' => 'Bridal Anand Karaj & Nikah',
                'care_instructions' => 'Store flat in padded velvet jewellery box.',
                'weight' => 0.20,
                'stock' => 20,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new' => true,
                'short_description' => 'Traditional Punjabi bridal hair jewellery set featuring an intricately stone-encrusted Matha Patti and matching side Passa.',
                'description' => '<p>Complete your bridal crowning majesty. Features a multi-tiered Kundan matha patti that gently frames the forehead and hair parting, alongside an artisanal side passa adorned with ruby red stones and pearl droplets.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1602751584552-8ba73aad10e1?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [],
                'collections' => [$collJewel->id, $collBridal->id]
            ],
            [
                'name' => 'Nawabi Sapphire Blue Silk Gharara Set',
                'slug' => 'nawabi-sapphire-blue-silk-gharara-set',
                'sku' => 'GS-GH-008',
                'category_id' => $catPatiala->id,
                'price' => 11499.00,
                'sale_price' => 9999.00,
                'cost_price' => 5200.00,
                'fabric' => 'Raw Silk & Chinon Chiffon',
                'colour' => 'Royal Sapphire Blue',
                'pattern' => 'Gota Patti Floral Jaal',
                'work' => 'Hand Carved Gota Patti & Mukaish',
                'occasion' => 'Cocktail, Reception, Festive',
                'care_instructions' => 'Dry Clean Only',
                'weight' => 1.40,
                'stock' => 15,
                'is_featured' => true,
                'is_best_seller' => false,
                'is_new' => true,
                'short_description' => 'Exquisite raw silk short kurti paired with a voluminous double-flared gharara and hand-dyed ombre chiffon dupatta.',
                'description' => '<p>Turn every head with royal sapphire blue radiance. The short tailored kurti is framed with delicate hand gota work, while the knee-gathered flared gharara swishes with majestic fullness at every step.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [
                    ['size' => 'S', 'colour' => 'Sapphire Blue', 'sku' => 'GS-GH-008-S', 'stock' => 3],
                    ['size' => 'M', 'colour' => 'Sapphire Blue', 'sku' => 'GS-GH-008-M', 'stock' => 5],
                    ['size' => 'L', 'colour' => 'Sapphire Blue', 'sku' => 'GS-GH-008-L', 'stock' => 4],
                    ['size' => 'XL', 'colour' => 'Sapphire Blue', 'sku' => 'GS-GH-008-XL', 'stock' => 3],
                ],
                'collections' => [$collRoyalPatiala->id]
            ],
            [
                'name' => 'Noorjehan Mustard Handloom Georgette Suit',
                'slug' => 'noorjehan-mustard-handloom-georgette-suit',
                'sku' => 'GS-PS-009',
                'category_id' => $catPatiala->id,
                'price' => 6999.00,
                'sale_price' => 5999.00,
                'cost_price' => 3100.00,
                'fabric' => 'Pure Viscose Georgette',
                'colour' => 'Haldi Mustard Yellow',
                'pattern' => 'Zari Phulkari Motif',
                'work' => 'Resham Threadwork & Mirror Borders',
                'occasion' => 'Haldi, Mehendi, Baisakhi',
                'care_instructions' => 'Dry Clean Only',
                'weight' => 1.10,
                'stock' => 22,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new' => false,
                'short_description' => 'Festive yellow pure georgette Punjabi suit decorated with vibrant Phulkari inspired resham needlework and gold mirror lace.',
                'description' => '<p>Celebrate joyous auspicious occasions in this sunshine yellow georgette masterpiece. Adorned with heritage Phulkari stitch craft, paired with a matching gathered salwar and a rich Banarasi weave dupatta.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [
                    ['size' => 'S', 'colour' => 'Mustard Yellow', 'sku' => 'GS-PS-009-S', 'stock' => 5],
                    ['size' => 'M', 'colour' => 'Mustard Yellow', 'sku' => 'GS-PS-009-M', 'stock' => 7],
                    ['size' => 'L', 'colour' => 'Mustard Yellow', 'sku' => 'GS-PS-009-L', 'stock' => 6],
                    ['size' => 'XL', 'colour' => 'Mustard Yellow', 'sku' => 'GS-PS-009-XL', 'stock' => 4],
                ],
                'collections' => [$collRoyalPatiala->id]
            ],
            [
                'name' => 'Pakeezah Navratan Meenakari Choker',
                'slug' => 'pakeezah-navratan-meenakari-choker',
                'sku' => 'GS-JW-010',
                'category_id' => $catKundan->id,
                'price' => 5999.00,
                'sale_price' => 4999.00,
                'cost_price' => 2400.00,
                'fabric' => '22K Matte Gold Finish',
                'colour' => 'Multi-Colour Gemstones',
                'pattern' => 'Navratan Nine Gems Palette',
                'work' => 'Semi-Precious Gemstones & Jadau Setting',
                'occasion' => 'Weddings & Royal Trunk Shows',
                'care_instructions' => 'Wipe with cotton swab. Keep sealed.',
                'weight' => 0.28,
                'stock' => 15,
                'is_featured' => true,
                'is_best_seller' => false,
                'is_new' => true,
                'short_description' => 'Regal 9-gemstone Navratan choker necklace framed by handcrafted Kundan florals and pearl drops.',
                'description' => '<p>Echoing the royal courts of Punjab, this Navratan necklace brings together vibrant nine-colored gemstones representing harmony and prosperity. Versatile enough to pair with any shade of couture.</p>',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=900&auto=format&fit=crop', 'is_primary' => true],
                    ['url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop', 'is_primary' => false],
                ],
                'variants' => [],
                'collections' => [$collJewel->id]
            ]
        ];

        foreach ($productsData as $pData) {
            $product = Product::create([
                'name' => $pData['name'],
                'slug' => $pData['slug'],
                'sku' => $pData['sku'],
                'category_id' => $pData['category_id'],
                'price' => $pData['price'],
                'sale_price' => $pData['sale_price'],
                'cost_price' => $pData['cost_price'],
                'fabric' => $pData['fabric'],
                'colour' => $pData['colour'],
                'pattern' => $pData['pattern'],
                'work' => $pData['work'],
                'occasion' => $pData['occasion'],
                'care_instructions' => $pData['care_instructions'],
                'weight' => $pData['weight'],
                'stock' => $pData['stock'],
                'status' => 'published',
                'is_featured' => $pData['is_featured'],
                'is_best_seller' => $pData['is_best_seller'],
                'is_new' => $pData['is_new'],
                'is_sale' => !empty($pData['sale_price']),
                'short_description' => $pData['short_description'],
                'description' => $pData['description'],
                'seo_title' => $pData['name'] . ' | Gauri Suits & Jewel',
                'seo_description' => Str::limit(strip_tags($pData['short_description']), 155),
            ]);

            // Add Images
            foreach ($pData['images'] as $idx => $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $img['url'],
                    'alt_text' => $product->name,
                    'sort_order' => $idx,
                    'is_primary' => $img['is_primary'],
                ]);
            }

            // Add Variants
            foreach ($pData['variants'] as $v) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $v['sku'],
                    'size' => $v['size'],
                    'colour' => $v['colour'],
                    'price' => $pData['price'],
                    'sale_price' => $pData['sale_price'],
                    'stock' => $v['stock'],
                    'status' => true,
                ]);
            }

            // Attach collections
            if (!empty($pData['collections'])) {
                $product->collections()->attach($pData['collections']);
            }
        }

        // 7. Banners
        Banner::create([
            'title' => 'ROOTED IN TRADITION',
            'subtitle' => 'THE VIRASAT HERITAGE EDIT',
            'image_desktop' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=2000&auto=format&fit=crop',
            'image_mobile' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=800&auto=format&fit=crop',
            'link_url' => route('shop.index'),
            'button_text' => 'EXPLORE COUTURE',
            'type' => 'hero',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Banner::create([
            'title' => 'HEIRLOOM KUNDAN & POLKI',
            'subtitle' => 'TIMELESS BRIDAL JEWELS',
            'image_desktop' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2000&auto=format&fit=crop',
            'image_mobile' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=800&auto=format&fit=crop',
            'link_url' => route('shop.jewellery'),
            'button_text' => 'SHOP JEWELLERY',
            'type' => 'hero',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // 8. Videos & 6 Shoppable Reels
        Video::create([
            'title' => 'The Craft of Royal Patiala: Behind the Looms',
            'description' => 'Step inside our Chandigarh atelier where master artisans preserve centuries-old hand embroidery, dabka, and tilla weaving.',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4',
            'poster_image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1600&auto=format&fit=crop',
            'cta_text' => 'Explore The Bridal Edit',
            'cta_url' => route('shop.bridal-collection'),
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $allProds = Product::all();
        $prod1 = $allProds->get(0);
        $prod2 = $allProds->get(1);
        $prod3 = $allProds->get(2);
        $prod4 = $allProds->get(3);
        $prod5 = $allProds->get(4);
        $prod6 = $allProds->get(5);

        Reel::create([
            'title' => 'Gulab Noor Zardozi Patiala in Motion',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-woman-modeling-a-traditional-indian-dress-42415-large.mp4',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop',
            'product_id' => $prod1?->id,
            'link_url' => $prod1 ? route('product.show', $prod1->slug) : null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Reel::create([
            'title' => 'Artisanal Emerald Kundan Choker',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-golden-jewelry-necklace-and-earrings-43093-large.mp4',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop',
            'product_id' => $prod4?->id,
            'link_url' => $prod4 ? route('product.show', $prod4->slug) : null,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Reel::create([
            'title' => 'The Royal 28-Kali Bridal Flared Anarkali',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop',
            'product_id' => $prod3?->id,
            'link_url' => $prod3 ? route('product.show', $prod3->slug) : null,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Reel::create([
            'title' => 'Noor-e-Kashmir Micro-Velvet Tilla Elegance',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-woman-modeling-a-traditional-indian-dress-42415-large.mp4',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=600&auto=format&fit=crop',
            'product_id' => $prod2?->id,
            'link_url' => $prod2 ? route('product.show', $prod2->slug) : null,
            'is_active' => true,
            'sort_order' => 4,
        ]);

        Reel::create([
            'title' => 'Chandrika Meenakari Chandbalis Sway',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-golden-jewelry-necklace-and-earrings-43093-large.mp4',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=600&auto=format&fit=crop',
            'product_id' => $prod5?->id,
            'link_url' => $prod5 ? route('product.show', $prod5->slug) : null,
            'is_active' => true,
            'sort_order' => 5,
        ]);

        Reel::create([
            'title' => 'Heritage Courtyards of Patiala',
            'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',
            'product_id' => $prod6?->id,
            'link_url' => $prod6 ? route('product.show', $prod6->slug) : null,
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // 9. Coupons
        Coupon::create([
            'code' => 'GAURI10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_order_amount' => 1999.00,
            'max_discount_amount' => 1000.00,
            'usage_limit' => 500,
            'usage_count' => 18,
            'is_active' => true,
            'start_date' => Carbon::now()->subMonths(1),
            'end_date' => Carbon::now()->addMonths(6),
        ]);

        Coupon::create([
            'code' => 'ROYAL15',
            'type' => 'percentage',
            'value' => 15.00,
            'min_order_amount' => 4999.00,
            'max_discount_amount' => 2500.00,
            'usage_limit' => 200,
            'usage_count' => 12,
            'is_active' => true,
            'start_date' => Carbon::now()->subMonths(1),
            'end_date' => Carbon::now()->addMonths(6),
        ]);

        Coupon::create([
            'code' => 'WEDDING500',
            'type' => 'fixed',
            'value' => 500.00,
            'min_order_amount' => 3499.00,
            'usage_limit' => 300,
            'usage_count' => 25,
            'is_active' => true,
            'start_date' => Carbon::now()->subMonths(1),
            'end_date' => Carbon::now()->addMonths(6),
        ]);

        // 10. Sample Customer Users & Addresses
        $user1 = User::create([
            'name' => 'Simran Kaur',
            'email' => 'customer@example.com',
            'phone' => '+91 98123 45678',
            'password' => Hash::make('password'),
        ]);

        $userAddress = Address::create([
            'user_id' => $user1->id,
            'first_name' => 'Simran',
            'last_name' => 'Kaur',
            'phone' => '+91 98123 45678',
            'email' => 'customer@example.com',
            'address_line1' => 'House 412, Sector 8-B',
            'address_line2' => 'Near Gurudwara Sahib',
            'city' => 'Chandigarh',
            'state' => 'Punjab',
            'postal_code' => '160009',
            'country' => 'India',
            'type' => 'shipping',
            'is_default' => true,
        ]);

        $user2 = User::create([
            'name' => 'Harleen Dhillon',
            'email' => 'harleen.dhillon@gmail.com',
            'phone' => '+91 98765 00112',
            'password' => Hash::make('password'),
        ]);

        Address::create([
            'user_id' => $user2->id,
            'first_name' => 'Harleen',
            'last_name' => 'Dhillon',
            'phone' => '+91 98765 00112',
            'email' => 'harleen.dhillon@gmail.com',
            'address_line1' => 'B-4/12 Vasant Vihar',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'postal_code' => '110057',
            'country' => 'India',
            'type' => 'shipping',
            'is_default' => true,
        ]);

        // 11. Customer Reviews
        $products = Product::all();
        $sampleReviews = [
            [
                'product_id' => $products[0]->id,
                'user_id' => $user1->id,
                'customer_name' => 'Simran Kaur',
                'customer_email' => 'customer@example.com',
                'rating' => 5,
                'title' => 'Breathtaking embroidery and royal flare!',
                'comment' => 'The Gulab Noor suit surpassed all my expectations! The zari work on the rani pink silk is so neat, and the salwar flare is pure Punjabi grandeur. Arrived beautifully wrapped in a designer dust box within 3 days.',
                'status' => 'approved',
                'is_verified_purchase' => true,
                'approved_at' => Carbon::now()->subDays(5),
            ],
            [
                'product_id' => $products[1]->id,
                'user_id' => $user2->id,
                'customer_name' => 'Harleen Dhillon',
                'customer_email' => 'harleen.dhillon@gmail.com',
                'rating' => 5,
                'title' => 'Pure luxury velvet! Worth every rupee.',
                'comment' => 'Wore this velvet tilla suit to my brother’s winter reception in Chandigarh and received endless compliments. The weight of the fabric and the sheen of the gold tilla is unmatched.',
                'status' => 'approved',
                'is_verified_purchase' => true,
                'approved_at' => Carbon::now()->subDays(3),
            ],
            [
                'product_id' => $products[3]->id,
                'user_id' => $user1->id,
                'customer_name' => 'Simran Kaur',
                'customer_email' => 'customer@example.com',
                'rating' => 5,
                'title' => 'Heirloom finish Kundan set',
                'comment' => 'The green hydro-emeralds and pearls look just like real heirloom bridal jewellery. It felt substantial on the neck without being scratchy.',
                'status' => 'approved',
                'is_verified_purchase' => true,
                'approved_at' => Carbon::now()->subDays(8),
            ]
        ];
        foreach ($sampleReviews as $r) {
            Review::create($r);
        }

        // 12. Sample Orders across past 30 days for rich Analytics and Reports
        $orderStatuses = [
            ['status' => 'delivered', 'payment_status' => 'paid', 'days_ago' => 14, 'method' => 'razorpay'],
            ['status' => 'delivered', 'payment_status' => 'paid', 'days_ago' => 10, 'method' => 'razorpay'],
            ['status' => 'shipped', 'payment_status' => 'paid', 'days_ago' => 3, 'method' => 'razorpay'],
            ['status' => 'processing', 'payment_status' => 'pending', 'days_ago' => 1, 'method' => 'cod'],
            ['status' => 'confirmed', 'payment_status' => 'paid', 'days_ago' => 0, 'method' => 'razorpay'],
        ];

        foreach ($orderStatuses as $idx => $oInfo) {
            $prod1 = $products[$idx % count($products)];
            $prod2 = $products[($idx + 2) % count($products)];
            
            $subtotal = ($prod1->sale_price ?? $prod1->price) + ($prod2->sale_price ?? $prod2->price);
            $shipping = $subtotal >= 2999 ? 0 : 150;
            $discount = ($idx % 2 == 1) ? 500 : 0;
            $total = max(0, $subtotal + $shipping - $discount);
            $orderDate = Carbon::now()->subDays($oInfo['days_ago'])->subHours(rand(1, 10));

            $order = Order::create([
                'order_number' => 'GSJ-' . (20261000 + $idx + 1),
                'user_id' => ($idx % 2 == 0) ? $user1->id : $user2->id,
                'status' => $oInfo['status'],
                'payment_status' => $oInfo['payment_status'],
                'payment_method' => $oInfo['method'],
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'coupon_code' => ($discount > 0) ? 'WEDDING500' : null,
                'shipping_amount' => $shipping,
                'tax_amount' => 0.00,
                'total_amount' => $total,
                'shipping_name' => ($idx % 2 == 0) ? 'Simran Kaur' : 'Harleen Dhillon',
                'shipping_phone' => ($idx % 2 == 0) ? '+91 98123 45678' : '+91 98765 00112',
                'shipping_email' => ($idx % 2 == 0) ? 'customer@example.com' : 'harleen.dhillon@gmail.com',
                'shipping_address_line1' => ($idx % 2 == 0) ? 'House 412, Sector 8-B' : 'B-4/12 Vasant Vihar',
                'shipping_city' => ($idx % 2 == 0) ? 'Chandigarh' : 'New Delhi',
                'shipping_state' => ($idx % 2 == 0) ? 'Punjab' : 'Delhi',
                'shipping_postal_code' => ($idx % 2 == 0) ? '160009' : '110057',
                'shipping_country' => 'India',
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // Order Items
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $prod1->id,
                'product_name' => $prod1->name,
                'product_sku' => $prod1->sku,
                'price' => $prod1->sale_price ?? $prod1->price,
                'quantity' => 1,
                'total' => $prod1->sale_price ?? $prod1->price,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $prod2->id,
                'product_name' => $prod2->name,
                'product_sku' => $prod2->sku,
                'price' => $prod2->sale_price ?? $prod2->price,
                'quantity' => 1,
                'total' => $prod2->sale_price ?? $prod2->price,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // Payment record
            if ($oInfo['payment_status'] === 'paid') {
                Payment::create([
                    'order_id' => $order->id,
                    'transaction_id' => 'TXN_' . Str::upper(Str::random(12)),
                    'razorpay_order_id' => 'order_' . Str::random(14),
                    'razorpay_payment_id' => 'pay_' . Str::random(14),
                    'payment_method' => $oInfo['method'],
                    'amount' => $total,
                    'currency' => 'INR',
                    'status' => 'successful',
                    'paid_at' => $orderDate,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }

            // Shipment record
            if (in_array($oInfo['status'], ['shipped', 'delivered'])) {
                Shipment::create([
                    'order_id' => $order->id,
                    'carrier' => 'BlueDart Express',
                    'tracking_number' => 'BD' . (78923410 + $idx),
                    'tracking_url' => 'https://www.bluedart.com/tracking',
                    'status' => ($oInfo['status'] === 'delivered') ? 'delivered' : 'in_transit',
                    'shipped_at' => $orderDate->copy()->addDay(),
                    'delivered_at' => ($oInfo['status'] === 'delivered') ? $orderDate->copy()->addDays(3) : null,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }
        }

        // 13. Blog Posts
        BlogPost::create([
            'admin_id' => $admin->id,
            'title' => 'The Timeless Splendour of Punjabi Phulkari & Tilla Weaving',
            'slug' => 'timeless-splendour-punjabi-phulkari-tilla-weaving',
            'excerpt' => 'Exploring the rich generational heritage of Punjabi Phulkari embroidery, royal dabka needlework, and heirloom tilla threads.',
            'content' => '<p>For centuries, the culture of Punjab has celebrated textile craftsmanship that weaves poetry into every thread. Among these treasured arts, <strong>Phulkari</strong> (literally translating to "flower work") and <strong>Kashmiri Tilla</strong> embroidery hold an unshakeable place of pride in royal bridal trousseaus.</p><p>At Gauri Suits & Jewel, each ensemble honors this heritage. Third-generation karigars in our workshops spend between 40 to 120 hours meticulously guiding metallic gold and silver threads across handwoven silk and micro-velvets.</p>',
            'featured_image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1200&auto=format&fit=crop',
            'author_name' => 'Gauri Editorial Atelier',
            'status' => 'published',
            'tags' => 'Punjabi Suits, Phulkari, Heritage, Handloom',
            'published_at' => Carbon::now()->subDays(10),
        ]);

        BlogPost::create([
            'admin_id' => $admin->id,
            'title' => 'Bridal Jewellery Guide: Pairing Polki and Kundan with Royal Silhouettes',
            'slug' => 'bridal-jewellery-guide-polki-kundan-royal-silhouettes',
            'excerpt' => 'How to curate an iconic wedding day look by striking the perfect harmony between heavy zardozi embroidery and heirloom gemstones.',
            'content' => '<p>Selecting wedding jewellery is one of the most sacred and cherished rituals for any bride. Today’s modern Punjabi bride seeks an opulent balance between traditional heritage and contemporary comfort.</p><p>When styling an intricately embroidered Rani Pink or Deep Crimson velvet ensemble, opting for an uncut Kundan choker with emerald bead drops creates a striking contrast that catches every ray of camera light.</p>',
            'featured_image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1200&auto=format&fit=crop',
            'author_name' => 'Harmanpreet Kaur, Chief Stylist',
            'status' => 'published',
            'tags' => 'Jewellery, Bridal, Kundan, Styling Guide',
            'published_at' => Carbon::now()->subDays(5),
        ]);
    }
}
