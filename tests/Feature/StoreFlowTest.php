<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page renders successfully.
     */
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('QRToko');
    }

    /**
     * Test user can register an account.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post(route('register.submit'), [
            'name' => 'Budi Merchant',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
        ]);
    }

    /**
     * Test user can login and logout.
     */
    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $loginResponse = $this->post(route('login.submit'), [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->post(route('logout'));
        $logoutResponse->assertRedirect(route('home'));
        $this->assertGuest();
    }

    /**
     * Test guest is redirected to login when trying to create a store.
     */
    public function test_guest_is_redirected_to_login_on_create(): void
    {
        $response = $this->get(route('stores.create'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test authenticated merchant can create a store.
     */
    public function test_authenticated_user_can_create_store(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('stores.store'), [
            'name' => 'Warung Nasi Enak',
            'phone' => '089988776655',
            'category' => 'Makanan & Kuliner',
            'tagline' => 'Enak dan Terjangkau',
            'is_open' => true,
        ]);

        $store = Store::where('name', 'Warung Nasi Enak')->first();

        $this->assertNotNull($store);
        $this->assertEquals($user->id, $store->user_id);
        $response->assertRedirect(route('stores.edit', $store->slug));
    }

    /**
     * Test unauthorized user cannot edit another merchant's store.
     */
    public function test_unauthorized_user_cannot_edit_other_store(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();

        $store = Store::create([
            'user_id' => $owner->id,
            'name' => 'Toko Milik Owner',
            'slug' => 'toko-milik-owner',
            'phone' => '081234567890',
        ]);

        $response = $this->actingAs($stranger)->get(route('stores.edit', $store->slug));

        $response->assertStatus(403);
    }

    /**
     * Test owner can edit their store and add products.
     */
    public function test_owner_can_edit_and_add_products(): void
    {
        $owner = User::factory()->create();

        $store = Store::create([
            'user_id' => $owner->id,
            'name' => 'Kafe Pagi',
            'slug' => 'kafe-pagi',
            'phone' => '081234567890',
        ]);

        $editResponse = $this->actingAs($owner)->get(route('stores.edit', $store->slug));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('picker_open_time');
        $editResponse->assertSee('hours-live-preview');

        $productResponse = $this->actingAs($owner)->post(route('stores.products.store', $store->slug), [
            'name' => 'Kopi Tubruk',
            'category' => 'Kopi',
            'price' => 10000,
        ]);

        $productResponse->assertRedirect(route('stores.edit', $store->slug));
        $this->assertDatabaseHas('products', [
            'store_id' => $store->id,
            'name' => 'Kopi Tubruk',
        ]);
    }

    /**
     * Test owner can upload logo and product image.
     */
    public function test_owner_can_upload_logo_and_product_image(): void
    {
        Storage::fake('public');
        $owner = User::factory()->create();

        $logoFile = UploadedFile::fake()->image('store_logo.png', 200, 200);

        $storeResponse = $this->actingAs($owner)->post(route('stores.store'), [
            'name' => 'Kedai Visual',
            'phone' => '081234567890',
            'category' => 'Kafe',
            'logo' => $logoFile,
        ]);

        $store = Store::where('name', 'Kedai Visual')->first();
        $this->assertNotNull($store->logo);
        Storage::disk('public')->assertExists($store->logo);

        $productImage = UploadedFile::fake()->image('coffee_cup.jpg', 300, 300);

        $productResponse = $this->actingAs($owner)->post(route('stores.products.store', $store->slug), [
            'name' => 'Kopi Latte Foto',
            'category' => 'Coffee',
            'price' => 20000,
            'image' => $productImage,
        ]);

        $product = $store->products()->where('name', 'Kopi Latte Foto')->first();
        $this->assertNotNull($product->image_url);
        Storage::disk('public')->assertExists($product->image_url);
    }

    /**
     * Test public customer can view store and its products without logging in.
     */
    public function test_public_customer_can_view_store_without_auth(): void
    {
        $store = Store::create([
            'name' => 'Toko Terbuka',
            'slug' => 'toko-terbuka',
            'phone' => '081234567890',
        ]);

        $store->products()->create([
            'name' => 'Teh Manis',
            'category' => 'Minuman',
            'price' => 5000,
        ]);

        $response = $this->get(route('stores.show', $store->slug));

        $response->assertStatus(200);
        $response->assertSee('Toko Terbuka');
        $response->assertSee('Teh Manis');
        $response->assertSee('Rp 5.000');
    }

    /**
     * Test printable QR standee is accessible.
     */
    public function test_printable_qr_standee_is_accessible(): void
    {
        $store = Store::create([
            'name' => 'Barber Bro',
            'slug' => 'barber-bro',
            'phone' => '081234567890',
        ]);

        $response = $this->get(route('stores.qr', $store->slug));

        $response->assertStatus(200);
        $response->assertSee('Barber Bro');
    }

    /**
     * Test store announcement and facilities can be created and displayed on public page.
     */
    public function test_store_announcement_and_facilities_are_saved_and_displayed(): void
    {
        $owner = User::factory()->create();

        $response = $this->actingAs($owner)->post(route('stores.store'), [
            'name' => 'Kedai Pengumuman',
            'phone' => '081234567890',
            'category' => 'Kafe',
            'announcement' => 'Diskon 50% Grand Opening!',
            'facilities' => ['Menerima QRIS', 'Free WiFi'],
        ]);

        $store = Store::where('name', 'Kedai Pengumuman')->first();
        $this->assertEquals('Diskon 50% Grand Opening!', $store->announcement);
        $this->assertContains('Menerima QRIS', $store->facilities);

        $publicResponse = $this->get(route('stores.show', $store->slug));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Diskon 50% Grand Opening!');
        $publicResponse->assertSee('Menerima QRIS');
        $publicResponse->assertSee('Free WiFi');
    }
}
