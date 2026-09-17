<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Setting;
use App\Models\ShippingZone;
use App\Models\ShippingRate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::create(['key' => 'store_name', 'value' => 'Gauri Suits & Jewel', 'group' => 'general']);
        Setting::create(['key' => 'currency_symbol', 'value' => '₹', 'group' => 'general']);
        Setting::create(['key' => 'free_shipping_threshold', 'value' => '2999', 'group' => 'shipping']);
        Setting::create(['key' => 'flat_shipping_rate', 'value' => '150', 'group' => 'shipping']);
        Setting::create(['key' => 'cod_enabled', 'value' => '1', 'group' => 'payment']);

        $zone = ShippingZone::create([
            'name' => 'All India',
            'states' => json_encode(['Punjab', 'Delhi', 'Chandigarh']),
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
    }

    public function test_complete_user_flow_from_browsing_to_order_confirmation(): void
    {
        $user = User::create([
            'name' => 'Harleen Kaur',
            'email' => 'harleen@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->actingAs($user);

        // 1. Setup category, product and coupon
        $category = Category::create([
            'name' => 'Royal Punjabi Suits',
            'slug' => 'royal-punjabi-suits',
            'is_active' => true,
            'is_featured' => true,
        ]);

        $product = Product::create([
            'name' => 'Kashmiri Tilla Velvet Anarkali',
            'slug' => 'kashmiri-tilla-velvet-anarkali',
            'sku' => 'FLOW-001',
            'price' => 5499.00,
            'category_id' => $category->id,
            'status' => 'published',
            'is_featured' => true,
            'stock' => 10,
        ]);

        $coupon = Coupon::create([
            'code' => 'ROYAL10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_order_amount' => 1000.00,
            'is_active' => true,
        ]);

        // Step 1: Browse Homepage
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('GAURI');
        $homeResponse->assertSee('SUITS &amp; JEWEL', false);
        $homeResponse->assertSee('TIMELESS TRADITIONS');

        // Step 2: Browse Category / Shop
        $shopResponse = $this->get(route('shop.index', ['category' => $category->slug]));
        $shopResponse->assertStatus(200);
        $shopResponse->assertSee('Kashmiri Tilla Velvet Anarkali');

        // Step 3: View Product Details
        $productResponse = $this->get(route('product.show', $product->slug));
        $productResponse->assertStatus(200);
        $productResponse->assertSee('Kashmiri Tilla Velvet Anarkali');
        $productResponse->assertSee('₹5,499');

        // Step 4: Add Product to Cart
        $cartAddResponse = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $cartAddResponse->assertStatus(200);
        $cartAddResponse->assertJson(['success' => true]);

        // Step 5: View Cart Page
        $cartPageResponse = $this->get(route('cart.index'));
        $cartPageResponse->assertStatus(200);
        $cartPageResponse->assertSee('Kashmiri Tilla Velvet Anarkali');

        // Step 6: Apply Coupon
        $couponResponse = $this->postJson(route('cart.coupon.apply'), [
            'code' => 'ROYAL10',
        ]);
        $couponResponse->assertStatus(200);
        $couponResponse->assertJson(['success' => true]);

        // Step 7: View Checkout Page
        $checkoutPageResponse = $this->get(route('checkout.index'));
        $checkoutPageResponse->assertStatus(200);
        $checkoutPageResponse->assertSee('Secure Checkout');

        // Step 8: Place Order via Cash on Delivery
        $checkoutProcessResponse = $this->post(route('checkout.process'), [
            'name' => 'Harleen Kaur',
            'email' => 'harleen@example.com',
            'phone' => '9876543210',
            'address_line1' => 'House 42, Sector 8-C',
            'city' => 'Chandigarh',
            'state' => 'Punjab',
            'postal_code' => '160018',
            'country' => 'India',
            'payment_method' => 'cod',
            'notes' => 'Please gift wrap in royal maroon velvet box.',
        ]);

        $checkoutProcessResponse->assertRedirect();
        $targetUrl = $checkoutProcessResponse->headers->get('Location');
        $this->assertStringContainsString('/order/success/', $targetUrl);

        // Extract order number from redirect URL
        preg_match('/\/order\/success\/(.+)$/', $targetUrl, $matches);
        $orderNumber = $matches[1];

        // Step 9: Verify Order Success Page
        $successResponse = $this->get(route('order.success', $orderNumber));
        $successResponse->assertStatus(200);
        $successResponse->assertSee($orderNumber);
        $successResponse->assertSee('Harleen Kaur');

        // Step 10: Verify Order Tracking Portal
        $trackResponse = $this->get(route('order.track', [
            'order_number' => $orderNumber,
            'contact' => 'harleen@example.com',
        ]));
        $trackResponse->assertStatus(200);
        $trackResponse->assertSee($orderNumber);
    }
}
