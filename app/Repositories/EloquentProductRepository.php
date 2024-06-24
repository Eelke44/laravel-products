<?php


namespace App\Repositories;

use App\Models\Product;


/**
 * Repository for products. Uses Eloquent for model management and db interaction.
 */
class EloquentProductRepository implements ProductRepositoryInterface
{
    /** @inheritDoc */
    public function create($attributes): bool
    {
        return Product::create($attributes) ? true : false;
    }

    /** @inheritDoc */
    public function retrieveOne(int $productId): Product|null
    {
        return Product::find($productId);
    }

    /** @inheritDoc */
    public function retrieveAll()
    {
        return Product::all()->all();
    }

    /** @inheritDoc */
    public function update($attributes): bool
    {
        $id = $attributes['id'];
        if ($id === null) return false;
        $attributes['updated_at'] = now();
        $product = Product::find($id);
        if ($product === null) return false;
        return $product->update($attributes);
    }

    /** @inheritDoc */
    public function delete(int $productId): int
    {
        return Product::destroy($productId);
    }

    /**
     * @inheritDoc
     * Inefficient due to querying all products, then updating one by one.
     */
    public function multiplyAllPricesBy(float $multiplier): bool
    {
        $results = [];
        foreach (Product::all()->all() as $product) {
            $success = $product->update(['price' => $product->price * $multiplier]);
            $results[] = $success;
        }
        return !in_array(false, $results, true);
    }
}
