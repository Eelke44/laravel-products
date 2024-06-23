<?php


namespace App\Validation;


/**
 * Trait for checking if a given array has given attributes.
 */
trait AttributeChecker
{
    /**
     * Check if a given array has given attributes.
     * @param array<string, mixed> $array: the array to be checked.
     * @param array<string> $attributes: the attributes that $array should contain.
     * @return: whether the array has the required attributes.
     */
    private function hasAttributes($array, $attributes): bool
    {
        return count(array_intersect(array_keys($array), $attributes)) == count($attributes);
    }
}
