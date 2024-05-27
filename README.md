# Online Marketplace Backend

Welcome to the Online Marketplace backend! This project is a simple yet powerful backend system for an online marketplace where users can buy and sell products. It features user registration, product management, and integrated Stripe payment processing.

## Features

- User registration and authentication
- Product listing and management
- Stripe payment integration for secure transactions
- Basic routing and request handling

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP installed on your server (>= 7.2)
- MySQL database
- Composer for dependency management
- A Stripe account for payment processing

## Installation

Follow these steps to set up the project locally:

1. Clone the repository:

   ```sh
   git clone https://github.com/bartzalewski/marketplace.git
   ```

2. Navigate to the project directory:

   ```sh
   cd marketplace
   ```

3. Install dependencies using Composer:

   ```sh
   composer install
   ```

4. Create a MySQL database and import the provided SQL file:

   ```sql
   CREATE DATABASE marketplace;
   USE marketplace;

   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL,
       email VARCHAR(100) NOT NULL,
       password VARCHAR(255) NOT NULL
   );

   CREATE TABLE products (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT,
       name VARCHAR(100) NOT NULL,
       description TEXT,
       price DECIMAL(10, 2) NOT NULL,
       FOREIGN KEY (user_id) REFERENCES users(id)
   );

   CREATE TABLE transactions (
       id INT AUTO_INCREMENT PRIMARY KEY,
       product_id INT,
       user_id INT,
       stripe_charge_id VARCHAR(100),
       amount DECIMAL(10, 2),
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (product_id) REFERENCES products(id),
       FOREIGN KEY (user_id) REFERENCES users(id)
   );
   ```

5. Configure the project by editing the `src/config.php` file with your database and Stripe credentials:

   ```php
   <?php
   // src/config.php
   return [
       'db' => [
           'host' => '127.0.0.1',
           'dbname' => 'marketplace',
           'user' => 'your_db_user',
           'password' => 'your_db_password',
       ],
       'stripe' => [
           'secret_key' => 'your_stripe_secret_key',
           'publishable_key' => 'your_stripe_publishable_key',
       ]
   ];
   ```

6. Start the PHP built-in server:

   ```sh
   php -S localhost:8000 -t public
   ```

7. Open your browser and navigate to `http://localhost:8000`.

## Usage

### User Registration

To register a new user, send a POST request to `/register` with the following parameters:

- `username`: The username of the new user.
- `email`: The email address of the new user.
- `password`: The password for the new user.

### Product Management

To create a new product, send a POST request to `/products` with the following parameters:

- `user_id`: The ID of the user creating the product.
- `name`: The name of the product.
- `description`: A description of the product.
- `price`: The price of the product.

To list all products, send a GET request to `/products`.

### Purchase Product

To purchase a product, send a POST request to `/buy` with the following parameters:

- `product_id`: The ID of the product to be purchased.
- `user_id`: The ID of the user making the purchase.
- `stripeToken`: The Stripe token for payment.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

If you have any questions or suggestions, feel free to reach out:

- Email: your.email@example.com
- GitHub: [yourusername](https://github.com/yourusername)

Thank you for checking out the Online Marketplace backend!
