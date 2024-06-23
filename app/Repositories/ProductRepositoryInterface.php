<?php


namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;


/**
 * Abstraction for product repositories.
 * Allows for the desired repository implementation to be injected in the controller.
 */
interface ProductRepositoryInterface
{
    /**
     * @return: whether the product was created successfully.
     */
    public function create($attributes): bool;

    /**
     * @return: the product with the given id, or null if not found.
     */
    public function retrieveOne(int $productId): Product|null;

    /**
     * @return Product[]: an array of all the known products.
     */
    public function retrieveAll();

    /**
     * @return: whether the update was successful.
     */
    public function update($attributes): bool;

    /**
     * @return: number of products deleted. Either 0 or 1.
     */
    public function delete(int $productId): int;

    /**
     * @return: whether the update was successful.
     */
    public function multiplyAllPricesBy(float $multiplier): bool;
}
