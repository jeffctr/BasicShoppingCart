<?php

namespace Shopping\classes;

class Cart
{
    private $cart;

    function __construct()
    {
        // Instance the cart session
        $this->cart = !empty($_SESSION['cart']) ? $_SESSION['cart'] : [] ;
    }

    /**
     * Add, Update and Remove items from the products cart
     *
     * @param array $newProduct
     * @param int $quantity
     * @return array
     */
    function updateCart(array $newProduct, int $quantity): array
    {
        $isNew = true;
        $products = $this->cart;

        if (empty($newProduct)) {
            return $products;
        }

        foreach ($products as $index => $product) {
            if ($product['name'] != $newProduct['name']) {
                continue;
            }

            $product['quantity'] +=  $quantity;
            if ($product['quantity'] <= 0) {
               unset($products[$index]);
               return $products;
            }

            // Update product total and quantity
            $products[$index] = $this->updatePrice($product, $product['quantity']);
            $isNew = false;
        }

        if ($isNew) {
            $newProduct['quantity'] = $quantity;
            $newProduct = $this->updatePrice($newProduct, $newProduct['quantity']);
            $products[] = $newProduct;
        }

        return $products;
    }

    /**
     * @param array $product
     * @return array
     */
    function updatePrice(array $product, $quantity): array
    {
        $product['total'] = $product['price'] * $quantity;
        return $product;
    }
}