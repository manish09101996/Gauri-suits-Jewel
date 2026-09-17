<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::create(['key' => 'store_name', 'value' => 'Gauri Suits & Jewel', 'group' => 'general']);
        Setting::create(['key' => 'currency_symbol', 'value' => '₹', 'group' => 'general']);

        $role = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Administrator',
        ]);

        $this->admin = Admin::create([
            'name' => 'Gauri Admin',
            'email' => 'admin@gaurisuits.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);
        $this->admin->roles()->attach($role->id);
    }

    public function test_admin_login_page_renders(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('Admin Command Center');
    }

    public function test_admin_can_authenticate_and_reach_dashboard(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@gaurisuits.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin, 'admin');

        $dashboardResponse = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Admin Dashboard');
    }

    public function test_admin_dashboard_computes_kpis_and_orders(): void
    {
        // Seed an order
        $order = Order::create([
            'order_number' => 'GSJ-TEST-100',
            'status' => 'delivered',
            'payment_status' => 'paid',
            'payment_method' => 'cod',
            'subtotal' => 5000.00,
            'discount_amount' => 0.00,
            'shipping_amount' => 0.00,
            'total_amount' => 5000.00,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '9988776655',
            'shipping_email' => 'test@customer.com',
            'shipping_address_line1' => 'Street 10',
            'shipping_city' => 'Ludhiana',
            'shipping_state' => 'Punjab',
            'shipping_postal_code' => '141001',
            'shipping_country' => 'India',
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('GSJ-TEST-100');
    }

    public function test_admin_product_management_routes(): void
    {
        $category = Category::create([
            'name' => 'Bridal Suits',
            'slug' => 'bridal-suits',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Royal Velvet Kalidar',
            'slug' => 'royal-velvet-kalidar',
            'sku' => 'VK-01',
            'price' => 14000.00,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        $actingAdmin = $this->actingAs($this->admin, 'admin');

        // Products List
        $listRes = $actingAdmin->get(route('admin.products.index'));
        $listRes->assertStatus(200);
        $listRes->assertSee('Royal Velvet Kalidar');

        // Create Page
        $createRes = $actingAdmin->get(route('admin.products.create'));
        $createRes->assertStatus(200);

        // Edit Page
        $editRes = $actingAdmin->get(route('admin.products.edit', $product->id));
        $editRes->assertStatus(200);
        $editRes->assertSee('Royal Velvet Kalidar');
    }

    public function test_admin_order_management_and_invoice(): void
    {
        $order = Order::create([
            'order_number' => 'GSJ-INV-001',
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',
            'subtotal' => 6000.00,
            'discount_amount' => 0.00,
            'shipping_amount' => 0.00,
            'total_amount' => 6000.00,
            'shipping_name' => 'Pooja Sharma',
            'shipping_phone' => '9876543210',
            'shipping_email' => 'pooja@example.com',
            'shipping_address_line1' => 'Civil Lines',
            'shipping_city' => 'Amritsar',
            'shipping_state' => 'Punjab',
            'shipping_postal_code' => '143001',
            'shipping_country' => 'India',
        ]);

        $actingAdmin = $this->actingAs($this->admin, 'admin');

        // Orders List
        $actingAdmin->get(route('admin.orders.index'))->assertStatus(200)->assertSee('GSJ-INV-001');

        // Order Detail
        $actingAdmin->get(route('admin.orders.show', $order->id))->assertStatus(200)->assertSee('Pooja Sharma');

        // Order Invoice
        $actingAdmin->get(route('admin.orders.invoice', $order->id))->assertStatus(200)->assertSee('TAX INVOICE');
    }

    public function test_admin_settings_and_cms_modules(): void
    {
        $actingAdmin = $this->actingAs($this->admin, 'admin');

        $routes = [
            route('admin.categories.index'),
            route('admin.customers.index'),
            route('admin.coupons.index'),
            route('admin.reviews.index'),
            route('admin.reports.index'),
            route('admin.settings.index'),
            route('admin.shipping.index'),
            route('admin.blog.index'),
            route('admin.banners.index'),
            route('admin.banners.create'),
            route('admin.videos.index'),
            route('admin.reels.index'),
            route('admin.live-visitors.index'),
            route('admin.admins.index'),
        ];

        foreach ($routes as $url) {
            $res = $actingAdmin->get($url);
            $res->assertStatus(200);
        }
    }
}
