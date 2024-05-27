<?php
require '../vendor/autoload.php';
require '../src/config.php';
require '../src/Database.php';
require '../src/User.php';
require '../src/Product.php';
require '../src/StripePayment.php';

$config = require '../src/config.php';
$db = Database::getInstance($config['db']);

$userModel = new User($db);
$productModel = new Product($db);
$stripePayment = new StripePayment($config['stripe']['secret_key']);

// Example routes (simple routing for demonstration)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri == '/register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userModel->createUser($username, $email, $password);
    echo 'User registered successfully';
} elseif ($uri == '/products' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $products = $productModel->getProducts();
    echo json_encode($products);
} elseif ($uri == '/products' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $productModel->createProduct($userId, $name, $description, $price);
    echo 'Product created successfully';
} elseif ($uri == '/buy' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $userId = $_POST['user_id'];
    $token = $_POST['stripeToken'];

    $product = $productModel->getProduct($productId);
    $charge = $stripePayment->createCharge($product['price'], 'usd', $token, 'Product purchase');

    $stmt = $db->prepare("INSERT INTO transactions (product_id, user_id, stripe_charge_id, amount) VALUES (?, ?, ?, ?)");
    $stmt->execute([$productId, $userId, $charge->id, $product['price']]);

    echo 'Purchase successful';
} else {
    echo 'Welcome to the Marketplace API';
}
