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
        return Product::All()->all();
    }

    /** @inheritDoc */
    public function update($attributes): bool
    {
        $id = $attributes['id'];
        if ($id === null) return false;
        $attributes['updated_at'] = now();
        return Product::find($id)->update($attributes);
    }

    /** @inheritDoc */
    public function delete(int $productId): int
    {
        return Product::destroy($productId);
    }
}
