<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::create(['key' => 'store_name', 'value' => 'Gauri Suits & Jewel', 'group' => 'general']);
        Setting::create(['key' => 'currency_symbol', 'value' => '$', 'group' => 'general']);
        Setting::create(['key' => 'currency_code', 'value' => 'AUD', 'group' => 'general']);
        Setting::create(['key' => 'free_shipping_threshold', 'value' => '299', 'group' => 'shipping']);
    }

    public function test_homepage_loads_successfully(): void
    {
        $category = Category::create([
            'name' => 'Punjabi Suits',
            'slug' => 'punjabi-suits',
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Phulkari Georgette Suit',
            'slug' => 'phulkari-georgette-suit',
            'sku' => 'TEST-001',
            'price' => 4999.00,
            'category_id' => $category->id,
            'status' => 'published',
            'is_featured' => true,
        ]);

        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Gauri Suits & Jewel');
        $response->assertSee('Phulkari Georgette Suit');
        // Redesigned visual hierarchy verification (matching editorial blueprint)
        $response->assertSee('TIMELESS TRADITIONS');
        $response->assertSee('HANDCRAFTED');
        $response->assertSee('PUNJABI SUITS');
        $response->assertSee('PATIALA SALWARS');
        $response->assertSee('OUR COLLECTION');
        $response->assertSee('Featured Products');
        $response->assertSee('The Atelier');
        $response->assertSee('Authentic Craftsmanship');
        $response->assertSee('Festive Edit');
        $response->assertSee('Heirloom Jewellery');
        $response->assertSee('Free Shipping');
        $response->assertSee('Easy Returns');
    }

    public function test_catalog_and_category_pages_render(): void
    {
        $category = Category::create([
            'name' => 'Fine Jewellery',
            'slug' => 'fine-jewellery',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Kundan Royal Choker',
            'slug' => 'kundan-royal-choker',
            'sku' => 'JW-001',
            'price' => 3999.00,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        // Shop index
        $response = $this->get(route('shop.index'));
        $response->assertStatus(200);
        $response->assertSee('Kundan Royal Choker');

        // Category filter
        $catResponse = $this->get(route('shop.category', 'fine-jewellery'));
        $catResponse->assertStatus(200);
        $catResponse->assertSee('Kundan Royal Choker');
    }

    public function test_product_detail_page_loads_with_details(): void
    {
        $category = Category::create([
            'name' => 'Patiala Suits',
            'slug' => 'patiala-suits',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Shahi Zardozi Suit',
            'slug' => 'shahi-zardozi-suit',
            'sku' => 'SZ-001',
            'price' => 7999.00,
            'category_id' => $category->id,
            'status' => 'published',
            'fabric' => 'Pure Silk',
            'short_description' => 'A royal masterpiece.',
            'description' => 'Detailed handcrafted description.',
        ]);

        $response = $this->get(route('product.show', $product->slug));
        $response->assertStatus(200);
        $response->assertSee('Shahi Zardozi Suit');
        $response->assertSee('Pure Silk');
    }

    public function test_informational_and_policy_pages_render(): void
    {
        $pages = [
            route('pages.about'),
            route('pages.contact'),
            route('pages.faq'),
            route('pages.shipping-policy'),
            route('pages.return-policy'),
            route('pages.refund-policy'),
            route('pages.privacy-policy'),
            route('pages.terms'),
        ];

        foreach ($pages as $url) {
            $res = $this->get($url);
            $res->assertStatus(200);
        }
    }

    public function test_blog_pages_render(): void
    {
        $post = BlogPost::create([
            'title' => 'The Grandeur of Phulkari Weaves',
            'slug' => 'grandeur-of-phulkari-weaves',
            'content' => '<p>Historic tale of Punjabi craftsmanship.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $indexRes = $this->get(route('blog.index'));
        $indexRes->assertStatus(200);
        $indexRes->assertSee('The Grandeur of Phulkari Weaves');

        $showRes = $this->get(route('blog.show', $post->slug));
        $showRes->assertStatus(200);
        $showRes->assertSee('Historic tale of Punjabi craftsmanship');
    }

    public function test_customer_can_register_and_login(): void
    {
        $registerRes = $this->post(route('customer.register'), [
            'name' => 'Kirandeep Kaur',
            'email' => 'kirandeep@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'phone' => '+91 99887 76655',
        ]);

        $registerRes->assertRedirect(route('account.dashboard'));
        $this->assertDatabaseHas('users', ['email' => 'kirandeep@example.com']);

        // Logout
        $this->post(route('customer.logout'));

        // Login
        $loginRes = $this->post(route('customer.login'), [
            'email' => 'kirandeep@example.com',
            'password' => 'secret123',
        ]);
        $loginRes->assertRedirect(route('account.dashboard'));
        $this->assertAuthenticated();
    }
}
