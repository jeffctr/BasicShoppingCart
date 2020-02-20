# Basic Shopping Cart
This is an example how to use just PHP to add, update and remove products from a shopping cart

## Prerequisites
This example requires that you have nginx or somthing similar to run it in you localhost. However, you can use this repository that already has the nginx configured [nginx-proxy](https://github.com/studionone/docker-nginx-proxy).

- nginx 
- Docker
- docker-compose

## Run
1. If you want to run it with `nginx-proxy` just download or clone the project and run the container.
    ```
        $ cd docker-nginx-proxy/
        $ docker-compose up -d
    ```
1. Clone **BasicShoppingCart docker Example** and build it with docker-compose
    ```
        $ cd BasicShoppingCart/
        $ docker-compose build && docker-compose up -d
    ```
1. Connect into the container and run `composer`, the following command will install the vendors. 
    ```$xslt
        $ docker exec -it shopping bash
        $ composer install
    ```
1. Add the virtual host into you `/etc/hosts` file `127.0.0.1  shopping.docker`
1. Now open your browser and go to [shopping.docker](http://shopping.docker/)


## Test
Now the application should be up and running. You will be able to add products to the cart and update them without duplicates.

## Code
This code is pretty simple and you can follow through. However, here I will brief you with the main files.
- `code/src/index.php` Here you can find the main `class App` that send the initial products to the `class Product`. Receives the parameters through `$_GET` and send them to `class Cart`.
- `code/src/classes/Products.php` This class has a recursion function that will clean and validate the initial data preventing duplicate products, empty arrays and non floats or integers values.  
- `code/src/classes/Cart.php` This class manage the products in the cart adding, removing and updating prices. 
- `code/src/views` Here you can find the `HMLT` files that will be render in the browser.


## Note
For more information about PHP check its official [documentation](https://www.php.net/docs.php). 
