<?php


namespace App\ProductValidation;

use Illuminate\Validation\ValidationException;


/**
 * Trait for validating product attributes.
 */
trait ProductAttributeValidator
{
    /**
     * Validate that the given attributes are correct for a product.
     * @param array<string, mixed> $attributes: the attributes to be checked.
     * @throws ValidationException if any required attributes are missing or otherwise invalid.
     */
    private function validateProductAttributes($attributes, bool $includeId = true): void
    {
        $rules = [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
        if ($includeId) {
            $rules['id'] = ['required', 'numeric', 'min:0'];
        }
        validator($attributes, $rules)->validate();
    }
}
