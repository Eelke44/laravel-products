<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use App\Models\Product;
use App\Models\User;

class CrudTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private array $productAttributes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->productAttributes = [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
        ];
    }

    /**
     * Return an object that can make authenticated http requests.
     * E.g., $this->authenticated()->get('/products');
     */
    private function authenticated()
    {
        return $this->actingAs($this->user);
    }

    /**
     * Test that unauthenticated users are redirected to the login page when trying to access products.
     */
    public function testProductsAuthNecessary(): void
    {
        $allRoutes = Route::getRoutes();
        foreach ($allRoutes as $route) {
            $path = $route->uri();
            if (str_starts_with($path, 'products')) {
                $verbs = $route->methods();
                foreach ($verbs as $verb) {
                    $response = $this->call($verb, $path);
                    $response->assertRedirect('/login');
                }
            }
        }
    }

    public function testCreateProductPage(): void
    {
        $response = $this->authenticated()->get('/products/create');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCreateProduct(): void
    {
        // Success
        $attributes = $this->productAttributes;
        $response = $this->authenticated()->post('/products', $attributes);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('products', $attributes);
        $this->assertDatabaseCount('products', 1);

        // Fail
        $attributeMissing = ['name' => 'test', 'description' => 'test'];
        $response = $this->authenticated()->post('/products', $attributeMissing);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testRetrieveProducts(): void
    {
        $response = $this->authenticated()->get('/products');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testRetrieveProduct(): void
    {
        $product = Product::factory()->createOne($this->productAttributes);

        // Success
        $response = $this->authenticated()->get('/products/'.$product->id);
        $response->assertStatus(Response::HTTP_OK);

        // Fails
        $response = $this->authenticated()->get('/products/-1');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response = $this->authenticated()->get('/products/invalid');
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testUpdateProductPage(): void
    {
        $product = Product::factory()->createOne($this->productAttributes);

        // Success
        $response = $this->authenticated()->get('/products/'.$product->id.'/update');
        $response->assertStatus(Response::HTTP_OK);

        // Fails
        $response = $this->authenticated()->get('/products/-1/update');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response = $this->authenticated()->get('/products/invalid/update');
        error_log($response->getStatusCode());
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testUpdateProduct(): void
    {
        $product = Product::factory()->createOne($this->productAttributes);
        $attributes = $product->getAttributes();
        $created_at = $attributes['created_at'];
        $attributes['description'] = 'updated';

        // Success
        $response = $this->authenticated()->put('/products/'.$product->id.'/update', $attributes);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('products', $attributes);
        $this->assertDatabaseCount('products', 1);
        $updatedProduct = Product::find($product->id);
        $this->assertLessThanOrEqual($created_at, $updatedProduct->updated_at);

        // Fails
        $attributes['id'] = -1;
        $response = $this->authenticated()->put('/products/'.$product->id.'/update', $attributes);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $attributes['id'] = "invalid";
        $response = $this->authenticated()->put('/products/'.$product->id.'/update', $attributes);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testDeleteProduct(): void
    {
        $product = Product::factory()->createOne($this->productAttributes);
        
        // Success
        $response = $this->authenticated()->delete('/products/'.$product->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseCount('products', 0);
        
        // Fail
        $response = $this->authenticated()->delete('/products/'.$product->id);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
