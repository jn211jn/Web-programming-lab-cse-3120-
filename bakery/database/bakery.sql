-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 09:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `service_id` varchar(20) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `price` int(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'in process',
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `name`, `number`, `email`, `service_id`, `employee_id`, `date`, `time`, `price`, `status`, `payment_status`) VALUES
(2, '14', 'sooya shimi', 123456789, 'sooya@gmail.com', '13', '1', '2025-04-24', '3:00 PM - 4:00 PM', 1000, 'in process', 'pending'),
(7, '10', 'jannat shimi', 123456789, 'jannat@gmail.com', '13', '1', '2025-04-24', '3:30 PM - 4:30 PM', 1000, 'in process', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` int(10) NOT NULL,
  `profile_desc` text NOT NULL,
  `profile` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `profession`, `email`, `number`, `profile_desc`, `profile`, `status`) VALUES
(1, 'Jannatul Shimi', 'pastry chef', 'jannatul@gmail.com', 2147483647, 'She is a talented pastry chef with a flair for turning every dessert into a delightful work of art. Her passion, creativity, and attention to detail make every bite an unforgettable experience.', 'U49yrByNpGgTEWK7N0ZX.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('IxSjlAYzWCdGFVuAKzsz', '2mQsO873m6KYTKNCXupd', 'jannatul', 'jannatul@gmail.com', 'how book an appointment', 'how book an appointment');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `placed_on` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'in process'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `product_id`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `status`) VALUES
(28, 14, 'strawberry cake', '123456789', 'sooya@gmail.com', 4, 'mohammadpur', '1', '250', '2025-04-15', 'Bkash', 'in process');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `products_detail` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `products_detail`, `category`, `status`) VALUES
(4, 'strawberry cake', '250', 'strawberry cake.jpg', 'This Strawberry cake is a light and fruity treat, bursting with the sweet, tangy flavor of fresh strawberries. The cake itself is soft and airy, often paired with a creamy frosting that enhances the natural sweetness of the fruit. It’s a refreshing and delicious dessert that offers a perfect balance of fruity freshness and sweetness in every bite.', 'dessert', 'active'),
(8, 'mocha cake', '100', 'mocha cake.jpg', 'This Mocha cake is a decadent blend of rich coffee and smooth chocolate flavors. The cake is moist and velvety, with a subtle coffee kick that perfectly complements the deep, indulgent chocolate taste. Often topped with a creamy mocha frosting, it offers a delightful balance of sweetness and a slight bitterness from the coffee, making it a perfect treat for coffee and chocolate lovers alike.', 'dessert', 'active'),
(9, 'Raspberry cheesecake', '400', 'Raspberry.jpg', 'This Raspberry cheesecake is a deliciously creamy dessert with a smooth, tangy filling made from rich cream cheese. The sweetness of the cheesecake is perfectly balanced by the tart, vibrant flavor of fresh raspberries. A buttery, crumbly crust provides the ideal base, and a swirl of raspberry sauce or whole berries on top adds a refreshing burst of flavor, making every bite a perfect combination of sweet and tangy.', 'Dessert', 'active'),
(11, 'chocolate cake', '150', 'cake.jpg', 'This Chocolate cake is a rich, moist dessert with a deep, indulgent chocolate flavor. The texture is soft and velvety, often complemented by a smooth, creamy frosting. Each bite is a perfect balance of sweetness and cocoa, offering a comforting, melt-in-your-mouth experience.', 'beauty products', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `service_detail` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `image`, `service_detail`, `category`, `status`) VALUES
(1, 'Basic Baking', '1000', 'bas1.png', 'In this basic baking class, you will learn how to measure ingredients accurately and follow simple recipes. We will cover how to bake cookies, cupcakes, and basic breads from scratch. You will get hands-on experience mixing, kneading, and decorating. We will also explore oven safety and proper kitchen hygiene. By the end, you will have the confidence to bake tasty treats at home!', 'basic', 'active'),
(10, 'Special Class', '1500', 'special.png', 'In this Specialty Baking Class, you will explore advanced techniques to elevate your baking skills. Learn the delicate art of making perfect macarons with vibrant colors and flavors. Master cake decorating with piping, fondant, and creative designs. Discover the secrets of artisan bread, from kneading to scoring. This class is perfect for passionate bakers ready to level up!', 'special class', 'active'),
(11, 'Advanced Workshop', '3000', 'baker2.png', 'In this Advanced Workshop, you will dive deep into professional baking techniques and precision. Learn how to create artisan pastries, complex bread recipes, and layered cakes with expert-level decoration. Develop skills in dough fermentation, flavor balancing, and bakery production planning. The course includes hands-on training guided by experienced chefs. Perfect for serious bakers or those aiming for a bakery career path!', 'advance', 'active'),
(12, 'online baking workshop', '1500', 'online bake1.png', 'In this Online Baking Workshop, you can join live, interactive sessions from the comfort of your home. Learn to bake delicious treats step-by-step with real-time guidance from expert instructors. Follow along with clear recipe instructions and ask questions as you go. All you need is your kitchen and internet access to get started. Perfect for beginners or busy bakers looking to level up their skills remotely!', 'online', 'active'),
(13, 'Childrens Baking Workshop', '1000', 'baker3.3.jpg', 'In this childrens baking workshop, kids will explore the joy of baking through fun and creative activities. They will learn to mix, shape, and decorate treats like cookies and cupcakes. Each session is hands-on and designed for little learners. Our instructors guide them step-by-step in a safe, friendly environment. Perfect for sparking a lifelong love of baking!', 'junior', 'active'),
(14, 'healthy sweets baking workshop', '2000', 'baker4.png', 'In this workshop, participants will learn how to bake healthier versions of traditional sweets and desserts. Adorable chibi characters in the poster add a fun, welcoming touch to the event. Using wholesome ingredients, the workshop focuses on guilt-free indulgence without compromising taste. The colorful, cheerful design reflects the joy of healthy baking. It’s perfect for families, foodies, and anyone interested in sweet, nutritious creations.', 'healthy baking', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(200) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
(6, 'shimi', 'shimi@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'iHwDqdnv7pbEeZUfd2Av.jpg'),
(10, 'jannat', 'jannat@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'tAxzDBQAo0T6Lz0JDaw1.webp'),
(11, 'ahashan', 'habib@gmail.com', '81fe8bfe87576c3ecb22426f8e57847382917acf', 'MQSiIetTbG6cTjRqNojh.png'),
(12, 'inaya', 'inaya@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'hN9TbpybDj69np1RnGcg.jpg'),
(13, 'sara', 'sara@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'mkYcBQEMuqjy5giGFW7s.jpg'),
(14, 'sooya', 'sooya@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '6TTAyoE0AAMCLCB1KE7s.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
