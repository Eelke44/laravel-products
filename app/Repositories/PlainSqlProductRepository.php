<?php


namespace App\Repositories;

use App\Models\Product;
use App\Validation\AttributeChecker;
use Illuminate\Support\Facades\DB;


/**
 * Repository for products. Uses raw SQL queries for db interaction.
 */
class PlainSqlProductRepository implements ProductRepositoryInterface
{
    use AttributeChecker;

    /** @inheritDoc */
    public function create($attributes): bool
    {
        if (!$this->hasAttributes($attributes, ['name', 'description', 'price'])) {
            return false;
        }
        $created_at = now();
        $updated_at = $created_at;
        return DB::insert('insert into products (name, description, price, created_at, updated_at) values (?, ?, ?, ?, ?)',
            [$attributes['name'], $attributes['description'], $attributes['price'], $created_at, $updated_at]
        );
    }

    /** @inheritDoc */
    public function retrieveOne(int $productId): Product|null
    {
        $row = DB::selectOne('select * from products where id = ?', [$productId]);
        if ($row === null) return null;
        return Product::factory()->makeOne(get_object_vars($row));
    }

    /** @inheritDoc */
    public function retrieveAll()
    {
        return DB::select('select * from products');
    }

    /** @inheritDoc */
    public function update($attributes): bool
    {
        if (!$this->hasAttributes($attributes, ['name', 'description', 'price', 'id'])) {
            return false;
        }
        $updated_at = now();
        return (bool) DB::update('update products set name = ?, description = ?, price = ?, updated_at = ? where id = ?',
            [$attributes['name'], $attributes['description'], $attributes['price'], $updated_at, $attributes['id']]
        );
    }

    /** @inheritDoc */
    public function delete(int $productId): int
    {
        return DB::delete('delete from products where id = ?', [$productId]);
    }
}
