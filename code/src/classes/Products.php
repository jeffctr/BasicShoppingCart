<?php

namespace Shopping\classes;


class Products
{
    private $products;

    function __construct(array $products)
    {
        $this->add(empty($_SESSION['products']) ? $products : $_SESSION['products']);
    }

    /**
     * This function will allow a user to insert more product in the list. However,
     * to do that is necessary enable the from template and include it in the Product list.
     * Finally, you will need to save products in session.
     *
     * @param array $products
     */
    function add(array $products)
    {
        // If the data isn't empty check that it does not exist in the products
        $products = $this->productsValidation($products);
        $this->setProducts($products);
    }

    /**
     * This recursion function that will check that there are not duplicate products or empty values,
     * it will clean the data and return an array of valid products.
     *
     * @param array $products
     * @param array $box
     * @param int $i
     * @return array
     */
    function productsValidation(array $products, array $box=[], int $i = 0): array
    {
        // End condition for the recursion
        if ($i >= count($products)) {
            return array_values($box);
        }

        // Get a single product an validate it
        $product = $products[$i];

        // Check that the item is not an empty array
        if (empty($product)){
            return $this->productsValidation($products, $box, $i+=1);
        }

        // Check that the name is a string and no empty
        if (empty($product['name']) || !is_string($product['name'])) {
            return $this->productsValidation($products, $box, $i+=1);
        }

        // Check that the price is not empty and it is a number
        if (empty($product['price'])
            || !(is_float($product['price']) || is_int($product['price']))
        ) {
            return $this->productsValidation($products, $box, $i+=1);
        }

        // Avoid to overwrite the first product with the second that has the same name
        if (isset($box[$product['name']])) {
            return $this->productsValidation($products, $box, $i+=1);
        }

        // Add product in a hash array with the name as a key
        $box[$product['name']] = $product;
        return $this->productsValidation($products, $box, $i+=1);
    }

    /**
     * @param array $products
     */
    function setProducts(array $products)
    {
        $this->products = $products;
    }

    /**
     * @return array
     */
    function getProducts(): array
    {
       return $this->products;
    }
}
