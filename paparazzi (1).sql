-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 06:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--+
-- Database: `paparazzi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `dip_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `additional_price` decimal(10,2) DEFAULT 0.00,
  `total_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_toppings`
--

CREATE TABLE `cart_toppings` (
  `cart_topping_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `topping_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(3, 'Floats'),
(2, 'Ice Cream'),
(4, 'Sugar Bowl');

-- --------------------------------------------------------

--
-- Table structure for table `dips`
--

CREATE TABLE `dips` (
  `dip_id` int(11) NOT NULL,
  `dip_type` varchar(255) NOT NULL,
  `additional_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dips`
--

INSERT INTO `dips` (`dip_id`, `dip_type`, `additional_price`) VALUES
(1, 'No Dip', 0.00),
(5, 'Strawberry Dip', 12.00),
(6, 'Chocolate Dip', 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_types`
--

CREATE TABLE `order_types` (
  `order_id` int(11) NOT NULL,
  `order_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_types`
--

INSERT INTO `order_types` (`order_id`, `order_type`) VALUES
(1, 'For Delivery'),
(2, 'For Pickup'),
(3, 'For Delivery and Pickup');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_method`) VALUES
(1, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `best_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image_url`, `order_id`, `category_id`, `best_seller`, `created_at`, `updated_at`) VALUES
(1, 'Ten Yen Ice Cream', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?', 65.00, '../assets/img/ten-yen.png', 3, 2, 1, '2024-11-30 13:39:02', '2024-12-02 17:14:11'),
(2, 'Ice Cream Cone\r\n(Flavors of the Month)', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?', 45.99, '../assets/img/ice-cream-cone.png', 2, 3, 1, '2024-11-30 13:51:19', '2024-12-02 11:01:28'),
(3, 'Taiyaki Fish', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?', 60.99, '../assets/img/taiyaki.png', 3, 4, 1, '2024-11-30 13:51:19', '2024-12-02 11:01:28'),
(5, 'Meow Meow Ice Cream', 'Ice Cream Yummy! Ice Cream Good!', 85.00, '../assets/img/674c94d1b9905.jpg', 2, 2, 0, '2024-12-01 16:54:41', '2024-12-02 11:01:28'),
(6, 'Meow Meow Ice Cream', 'ice cream yummy ice cream good', 77.77, '../assets/img/674c968d718c1.jpg', 2, 2, 0, '2024-12-01 17:02:05', '2024-12-02 11:01:28'),
(7, 'Meow Meow Ice Cream', 'ice cream yummy ice cream good', 77.77, '../assets/img/674c976a76bf1.jpg', 2, 2, 0, '2024-12-01 17:05:46', '2024-12-02 11:01:28'),
(8, 'Meow Meow Ice Cream', 'ice cream yummy ice cream good', 77.77, '../assets/img/674c976c4cc26.jpg', 2, 2, 0, '2024-12-01 17:05:48', '2024-12-02 11:01:28'),
(9, 'hehe', 'asdasdasda', 57.98, '../assets/img/674c9781c0d83.jpg', 1, 3, 0, '2024-12-01 17:06:09', '2024-12-02 11:01:28'),
(10, 'asd', 'sdasda', 55.55, '../assets/img/674c9af506559.jpg', 2, 3, 0, '2024-12-01 17:20:53', '2024-12-02 11:01:28'),
(11, 'asd', 'sdasda', 55.55, '../assets/img/674d6df8384e7.jpg', 2, 3, 0, '2024-12-02 08:21:12', '2024-12-02 11:01:28'),
(12, 'Meow Meow Ice Cream', 'sdasda', 65.00, '../assets/img/674d7277d8d61.png', 1, 3, 0, '2024-12-02 08:40:23', '2024-12-02 11:01:28'),
(13, 'asd', 'hrhghfghf', 55.55, '../assets/img/674d7be8e542d.png', 3, 2, 0, '2024-12-02 09:20:40', '2024-12-02 09:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(255) NOT NULL,
  `additional_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`, `additional_price`) VALUES
(1, 'Small', 0.00),
(2, 'Medium', 15.00),
(3, 'Large', 25.00),
(4, '250ml', 18.00);

-- --------------------------------------------------------

--
-- Table structure for table `toppings`
--

CREATE TABLE `toppings` (
  `topping_id` int(11) NOT NULL,
  `topping_name` varchar(255) NOT NULL,
  `additional_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toppings`
--

INSERT INTO `toppings` (`topping_id`, `topping_name`, `additional_price`) VALUES
(6, 'Sprinkles', 10.00),
(7, 'Marshmallow', 10.00),
(9, 'Oreo', 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `pickup_time` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `total_amount`, `payment_id`, `order_id`, `pickup_time`, `status`, `transaction_date`) VALUES
(60, 5, 660.00, 1, 2, '10:30', 'Pending', '2024-12-04 05:16:35'),
(61, 6, 336.00, 1, 2, '10:30', 'Pending', '2024-12-04 10:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `transaction_item_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `additional_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`transaction_item_id`, `transaction_id`, `product_id`, `additional_price`) VALUES
(5, 60, 1, 47.00),
(6, 61, 2, 33.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `account_type` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `contact`, `address`, `email`, `password`, `img`, `account_type`) VALUES
(1, 'Andrei', 'Tallado', '9951912107', 'Banay-banay', 'atalladotes@gmail.com', '$2y$10$C5drBDkWQktHDVLa01JPTuPfbIu4nwF9eLgp7jRkp.1vS9GsZjJle', NULL, '3'),
(5, 'Blakie', 'Bun', '09123456789', '', 'blakiebun11@gmail.com', '$2y$10$csuqlr8157dDymHFoXqw3uTTgNcFBsl9EOp3pqb8iqk5GFjTatQha', '', '2'),
(6, 'Kenneth', 'Lorenzo', '0912345678', 'Balintawak, Lipa City', 'kennetics1@gmail.com', '$2y$10$hGIuGaNngzBkZQQUVg0wfuw6hAe2iaJHyEc65jU1fJ.eBk0PJ9wRa', '../assets/profile/kenneth.jpg', '3'),
(7, 'shopi', 'me', '09123456789', 'Sabang, Lipa City', 'shopime4@gmail.com', '$2y$10$dGGSAVYrHyLx4qnwa3lfNe9NE7CeOkBW5ktCiKID9y55R9Kqbyja2', NULL, '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_dip_id` (`dip_id`),
  ADD KEY `fk_size_id` (`size_id`);

--
-- Indexes for table `cart_toppings`
--
ALTER TABLE `cart_toppings`
  ADD PRIMARY KEY (`cart_topping_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `topping_id` (`topping_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `dips`
--
ALTER TABLE `dips`
  ADD PRIMARY KEY (`dip_id`),
  ADD KEY `idx_dip_id` (`dip_id`);

--
-- Indexes for table `order_types`
--
ALTER TABLE `order_types`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_order_type` (`order_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `idx_size_id` (`size_id`);

--
-- Indexes for table `toppings`
--
ALTER TABLE `toppings`
  ADD PRIMARY KEY (`topping_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_transactions_order_id` (`order_id`),
  ADD KEY `fk_payment` (`payment_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`transaction_item_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `cart_toppings`
--
ALTER TABLE `cart_toppings`
  MODIFY `cart_topping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dips`
--
ALTER TABLE `dips`
  MODIFY `dip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_types`
--
ALTER TABLE `order_types`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `toppings`
--
ALTER TABLE `toppings`
  MODIFY `topping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `transaction_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_dip_id` FOREIGN KEY (`dip_id`) REFERENCES `dips` (`dip_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_size_id` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `cart_toppings`
--
ALTER TABLE `cart_toppings`
  ADD CONSTRAINT `cart_toppings_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_toppings_ibfk_2` FOREIGN KEY (`topping_id`) REFERENCES `toppings` (`topping_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_order_type` FOREIGN KEY (`order_id`) REFERENCES `order_types` (`order_id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_payment` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transactions_order_id` FOREIGN KEY (`order_id`) REFERENCES `order_types` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
