<?php

namespace App\Http\Controllers;

use App\Jobs\DiscountAll;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

use App\ProductValidation\ProductAttributeValidator;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\EloquentProductRepository;
use App\Repositories\PlainSqlProductRepository;


class ProductController extends Controller
{
    use ProductAttributeValidator;

    private ProductRepositoryInterface $repository;

    /**
     * Create a new controller instance. The repository is injected by Laravel's service container.
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function showCreationPage()
    {
        return view('product-create');
    }

    /**
     * Create a new product. If successful, redirect to the products page.
     * @param Request $request: the request containing the attributes of the product to be created. Injected by Laravel's service container.
     */
    public function create(Request $request)
    {
        $attributes = $request->all();
        $this->abortIfInvalid($attributes, includeId: false);
        $success = $this->repository->create($attributes);
        if (!$success) abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        return redirect('/products')->setStatusCode(201);
    }

    /**
     * Show the main products page.
     */
    public function showProductsPage()
    {
        return view('products', [
            'products' => $this->repository->retrieveAll(),
        ]);
    }

    /**
     * Retrieve a product and return a view showing its properties.
     * @param int $productId: the id of the product to be retrieved.
     */
    public function retrieve($productId)
    {
        if ($productId != (int) $productId) {
            abort(Response::HTTP_BAD_REQUEST, 'The given product id must be an integer.');
        }
        $product = $this->repository->retrieveOne($productId);
        if ($product === null) abort(Response::HTTP_NOT_FOUND);
        return view('product', [
            'product' => $product,
        ]);
    }

    /**
     * Show the view where a product can be updated.
     * @param int $productId: the id of the product to be updated.
     */
    public function showUpdatePage($productId)
    {
        if ($productId != (int) $productId) {
            abort(Response::HTTP_BAD_REQUEST, 'The given product id must be an integer.');
        }
        $product = $this->repository->retrieveOne($productId);
        if ($product === null) abort(Response::HTTP_NOT_FOUND);
        return view('product-update', [
            'product' => $product,
        ]);
    }

    /**
     * Update a product. If successful, redirect to the updated product page.
     * @param Request $request: the request containing the attributes to be updated. Injected by Laravel's service container.
     */
    public function update(Request $request)
    {
        $attributes = $request->all();
        $this->abortIfInvalid($attributes, includeId: true);
        $success = $this->repository->update($attributes);
        // Better: actually check if it was not found or if some other error occurred
        if (!$success) abort(Response::HTTP_NOT_FOUND);
        return redirect('/products/'.$attributes['id'])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Delete a product from the db.
     * @param int $productId: the id of the product to be deleted.
     */
    public function delete($productId)
    {
        if ($productId != (int) $productId) {
            abort(Response::HTTP_BAD_REQUEST, 'The given product id must be an integer.');
        }
        $numDeleted = $this->repository->delete($productId);
        if ($numDeleted == 0) abort(Response::HTTP_NOT_FOUND, 'The product to be removed was not found.');
        return redirect('/products')->setStatusCode(200);
    }

    /**
     * Dispatch a global discount job.
     * @param $percentage: the percentage to discount by. Can be any numeric value for flexibility.
     */
    public function dispatchGlobalDiscount(Request $request)
    {
        $percentage = $request->input('percentage');
        if ($percentage === null || $percentage != (float) $percentage) {
            abort(Response::HTTP_BAD_REQUEST, 'The discount multiplier must be present and numeric.');
        }
        DiscountAll::dispatch($this->repository, $percentage);
        return redirect('/products')->setStatusCode(201);
    }

    /**
     * Abort with a bad request status if the given attributes are invalid for a product.
     * @param array<string, mixed> $attributes: the attributes to validate.
     * @param bool $includeId: whether an id should be present in the attributes. Defaults to true.
     */
    private function abortIfInvalid($attributes, bool $includeId = true)
    {
        try {
            $this->validateProductAttributes($attributes, $includeId);
        } catch (ValidationException $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
