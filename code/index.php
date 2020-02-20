<?php
session_start();
include ('vendor/autoload.php');

use Shopping\classes\Products;
use Shopping\classes\Cart;
use Shopping\helpers\Helpers;

$loader = new \Twig\Loader\FilesystemLoader(__dir__ . '/views');
$twig = new \Twig\Environment($loader, ['debug' => true]);

class App
{
    private $twig;
    const PRODUCTS = [
        [],
        ['name' => 'Sledgehammer', 'price' => 125.75 ],
        ['name' => 'Axe', 'price' => 190.50 ],
        ['name' => 'Bandsaw', 'price' => 562.131 ],
        ['name' => 'Chisel', 'price' => 12.9 ],
        ['name' => 'Hacksaw', 'price' => 18.45 ],
        '',
        2,
    ];


    function __construct(\Twig\Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Instance classes
     * I have created this two classes Products and Cart to maintain a clean code and separate
     * the logic from cart and products.
     *
     * This function invoke Product and Cart to get the items and list them into the templates.
     *
     * @param array $params
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function renderShopping(array $params)
    {
        // Instance classes
        $products = new Products(self::PRODUCTS);
        $items = $products->getProducts();
        $cart = new Cart();

        if (isset($params['add'])
            && Helpers::checkNumber($params['add'])
            && isset($params['quantity'])
            && Helpers::checkNumber($params['quantity'])
        ) {
            $quantity = (int) $params['quantity'];
            $add = (int) $params['add'];

            // Get the product that is going to be added or remove from the cart
            $newProduct = ($quantity <= -1) ? $_SESSION['cart'][$add] : $items[$add];
            $newProduct = $newProduct ?? [];

            // Save products in the cart
            $_SESSION['cart'] = $cart->updateCart($newProduct, $quantity);

            // Clean url and redirect to the same page
            $dis_url = $_SERVER['REQUEST_URI'];
            $uri = trim(strtok($dis_url, '?'));
            header("Refresh:0; url=$uri");
        }

        // Render view
        echo $this->twig->render('main.html.twig', [
            'products' => $products->getProducts(),
            'cart' => $_SESSION['cart'],
        ]);
    }
}

$app = new App($twig);
$app->renderShopping($_GET);
