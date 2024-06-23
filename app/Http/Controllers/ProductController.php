<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repositories\ProductRepositoryInterface;
use App\Repositories\EloquentProductRepository;
use App\Repositories\PlainSqlProductRepository;
use App\Validation\AttributeChecker;


class ProductController extends Controller
{
    use AttributeChecker;

    private ProductRepositoryInterface $repository;

    /**
     * Create a new controller instance. The repository is injected by Laravel.
     */
    public function __construct(PlainSqlProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function showCreationPage()
    {
        return view('product-create');
    }

    /**
     * Create a new product. If successful, redirect to the products page.
     * @param Request $request: the request containing the attributes of the product to be created. Injected by Laravel.
     */
    public function create(Request $request)
    {
        $attributes = $request->all();
        try {
            $attributes = $this->withCorrectTypes($attributes, includeId: false);
        } catch (\TypeError | \InvalidArgumentException $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
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
            'user' => auth()->user(),
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
     * @param Request $request: the request containing the attributes to be updated. Injected by Laravel.
     */
    public function update(Request $request)
    {
        $attributes = $request->all();
        try {
            $attributes = $this->withCorrectTypes($attributes);
        } catch (\TypeError | \InvalidArgumentException $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
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
     * Create an attributes array out of the given one that has the correct types for a product.
     * @param array<string, mixed> $attributes: the attributes to be converted to the correct types.
     * @return array<string, mixed>: the attributes with the correct types.
     * @throws \InvalidArgumentException if any required attributes are missing.
     * @throws \TypeError if the types cannot be converted.
     */
    private function withCorrectTypes($attributes, bool $includeId=true)
    {
        // Handle potentially missing attributes.
        $requiredAttributes = ['name', 'description', 'price'];
        if ($includeId) $requiredAttributes[] = 'id';
        if (!$this->hasAttributes($attributes, $requiredAttributes)) {
            throw new \InvalidArgumentException('Missing at least one of the required attributes: '.implode(', ', $requiredAttributes).'.');
        }
        // Build $result. When PHP does not know how to cast a value, it returns a default.
        $result = [];
        $result['name'] = (string) $attributes['name'];
        $result['description'] = (string) $attributes['description'];
        $result['price'] = (float) $attributes['price'];
        if ($includeId) $result['id'] = (int) $attributes['id'];
        // Check that $result is correct using typeless equality tests.
        foreach ($requiredAttributes as $attribute) {
            if ($result[$attribute] != $attributes[$attribute]) {
                throw new \TypeError('The attribute '.$attribute.' has an unexpected type: '.gettype($attributes[$attribute]).'.');
            }
        }
        return $result;
    }
}
