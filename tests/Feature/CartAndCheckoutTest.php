<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ShippingZone;
use App\Models\ShippingRate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;
    protected Coupon $coupon;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::create(['key' => 'store_name', 'value' => 'Gauri Suits & Jewel', 'group' => 'general']);
        Setting::create(['key' => 'currency_symbol', 'value' => '$', 'group' => 'general']);
        Setting::create(['key' => 'currency_code', 'value' => 'AUD', 'group' => 'general']);
        Setting::create(['key' => 'free_shipping_threshold', 'value' => '299', 'group' => 'shipping']);
        Setting::create(['key' => 'flat_shipping_rate', 'value' => '15', 'group' => 'shipping']);
        Setting::create(['key' => 'cod_enabled', 'value' => '1', 'group' => 'payment']);

        $zone = ShippingZone::create([
            'name' => 'All India',
            'states' => json_encode(['Punjab', 'Delhi']),
            'is_active' => true,
        ]);

        ShippingRate::create([
            'zone_id' => $zone->id,
            'name' => 'Standard Courier',
            'min_order_amount' => 0,
            'max_order_amount' => 2998.99,
            'rate' => 150.00,
            'is_active' => true,
        ]);

        ShippingRate::create([
            'zone_id' => $zone->id,
            'name' => 'Complimentary Delivery',
            'min_order_amount' => 2999.00,
            'max_order_amount' => null,
            'rate' => 0.00,
            'is_active' => true,
        ]);

        $category = Category::create([
            'name' => 'Suits',
            'slug' => 'suits',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'name' => 'Royal Tilla Patiala Suit',
            'slug' => 'royal-tilla-patiala-suit',
            'sku' => 'RT-001',
            'price' => 3500.00,
            'sale_price' => 3200.00,
            'category_id' => $category->id,
            'stock' => 10,
            'status' => 'published',
        ]);

        $this->coupon = Coupon::create([
            'code' => 'ROYAL10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_order_amount' => 1000.00,
            'is_active' => true,
        ]);

        $this->user = User::create([
            'name' => 'Navneet Kaur',
            'email' => 'navneet@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->actingAs($this->user);
    }

    public function test_can_add_item_to_cart(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Verify summary
        $summaryRes = $this->getJson(route('cart.summary'));
        $summaryRes->assertStatus(200);
        $summaryRes->assertJsonPath('total_items', 2);
    }

    public function test_can_apply_and_remove_coupon(): void
    {
        // Add item first
        $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        // Apply valid coupon
        $res = $this->postJson(route('cart.coupon.apply'), [
            'code' => 'ROYAL10',
        ]);
        $res->assertStatus(200);
        $res->assertJson(['success' => true]);

        // Remove coupon
        $removeRes = $this->postJson(route('cart.coupon.remove'));
        $removeRes->assertStatus(200);
        $removeRes->assertJson(['success' => true]);
    }

    public function test_checkout_page_renders_with_items(): void
    {
        $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->get(route('checkout.index'));
        $response->assertStatus(200);
        $response->assertSee('Royal Tilla Patiala Suit');
    }

    public function test_customer_can_place_cod_order(): void
    {
        $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $orderData = [
            'name' => 'Navneet Kaur',
            'phone' => '9888812345',
            'email' => 'navneet@example.com',
            'address_line1' => 'Plot 88, Urban Estate Phase 2',
            'city' => 'Jalandhar',
            'state' => 'Punjab',
            'postal_code' => '144022',
            'country' => 'India',
            'payment_method' => 'cod',
        ];

        $response = $this->post(route('checkout.process'), $orderData);

        // Should redirect to order.success
        $response->assertRedirect();
        
        $order = Order::where('shipping_email', 'navneet@example.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals('cod', $order->payment_method);
        $this->assertEquals(1, $order->items()->count());

        // Order success page
        $successRes = $this->get(route('order.success', $order->order_number));
        $successRes->assertStatus(200);
        $successRes->assertSee($order->order_number);
    }

    public function test_order_tracking_portal_retrieves_order(): void
    {
        $order = Order::create([
            'order_number' => 'GSJ-99999999',
            'status' => 'shipped',
            'payment_status' => 'paid',
            'payment_method' => 'cod',
            'subtotal' => 3200.00,
            'discount_amount' => 0.00,
            'shipping_amount' => 0.00,
            'total_amount' => 3200.00,
            'shipping_name' => 'Navneet Kaur',
            'shipping_phone' => '9888812345',
            'shipping_email' => 'navneet@example.com',
            'shipping_address_line1' => 'Plot 88, Urban Estate Phase 2',
            'shipping_city' => 'Jalandhar',
            'shipping_state' => 'Punjab',
            'shipping_postal_code' => '144022',
            'shipping_country' => 'India',
        ]);

        $response = $this->get(route('order.track', [
            'order_number' => 'GSJ-99999999',
            'identifier' => 'navneet@example.com',
        ]));

        $response->assertStatus(200);
        $response->assertSee('GSJ-99999999');
        $response->assertSee('Shipped');
    }
}
