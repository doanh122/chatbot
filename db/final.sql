-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 08:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(0, 'admin1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `booking_date`, `total_price`, `status`, `adults`, `children`, `note`) VALUES
(14, 3, 1, '2025-04-22', '2025-04-24', '2025-04-19 17:50:41', 1700000.00, 'paid', 2, 2, '0'),
(15, 3, 3, '2025-04-30', '2025-05-01', '2025-04-19 18:02:37', 920000.00, 'paid', 2, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

CREATE TABLE `chat_history` (
  `id` int(11) NOT NULL,
  `user_message` text NOT NULL,
  `bot_reply` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_history`
--

INSERT INTO `chat_history` (`id`, `user_message`, `bot_reply`, `created_at`) VALUES
(1, 'hi', 'Chào bạn! Cần tôi giúp gì không?', '2025-04-19 02:40:27'),
(2, 'hi', 'Chào bạn! Có điều gì tôi có thể giúp bạn không?', '2025-04-19 02:42:37'),
(3, 'hi', 'Chào bạn! Bạn cần tôi giúp gì ạ?', '2025-04-19 02:43:57'),
(4, 'hi', 'Chào bạn! Bạn cần trợ giúp gì ạ?', '2025-04-19 02:48:34'),
(5, 'hi', 'Chào bạn! Bạn cần tôi giúp gì về việc đặt phòng khách sạn ạ?', '2025-04-19 03:00:18'),
(6, 'hi', 'Chào bạn! Bạn cần trợ giúp gì ạ?', '2025-04-19 03:06:11'),
(7, 'hi', 'Chào bạn! Có gì tôi có thể giúp bạn không?', '2025-04-19 03:07:56'),
(8, 'hi', 'Chào bạn! Bạn cần trợ giúp về điều gì ạ?', '2025-04-19 03:09:51'),
(9, 'english', 'Hello! How can I assist you today?', '2025-04-19 03:10:00'),
(10, 'i want booking a room', 'Sure, I can help you with that. How many people will be staying in the room and for how many nights?', '2025-04-19 03:10:13'),
(11, '4 people for 2 nights', 'Great! Let me check the availability for a room for 4 people for 2 nights. Please give me a moment.', '2025-04-19 03:10:27'),
(12, 'hi', 'Chào bạn! Bạn đã chọn phòng nào chưa?', '2025-04-19 03:22:19'),
(13, 'có phòng trống không', 'Dạ, chúng tôi còn phòng trống cho 4 người trong 2 đêm. Bạn muốn đặt phòng ngay không ạ?', '2025-04-19 03:25:30'),
(14, 'có', 'Để đặt phòng, bạn vui lòng cung cấp thông tin liên hệ của bạn và thời gian đến khách sạn.Bạn cũng có thể thanh toán trực tuyến hoặc khi đến nhận phòng. Có cần tôi giúp gì thêm không ạ?', '2025-04-19 03:25:41'),
(15, 'tên ni', 'Vui lòng cung cấp tên đầy đủ và thông tin liên hệ của bạn để hoàn tất quá trình đặt phòng. Cảm ơn bạn!', '2025-04-19 03:25:54'),
(16, 'e', 'Xin lỗi, có gì tôi có thể giúp bạn không?', '2025-04-19 03:33:02'),
(17, 'english', 'Hello! How can I assist you today?', '2025-04-19 03:33:18'),
(18, 'u have a room for 2', 'Yes, we have a room available for 2 people. How many nights will you be staying?', '2025-04-19 03:33:34'),
(19, 'hi', 'Chào bạn! Bạn cần tôi giúp gì ạ?', '2025-04-19 03:40:32'),
(20, 'hi', 'Chào bạn! Bạn cần trợ giúp gì về việc đặt phòng khách sạn ạ?', '2025-04-19 07:45:09'),
(21, 'đúng rồi', 'Vui lòng cho biết số người và số đêm bạn muốn đặt phòng để tôi kiểm tra sẵn có và giúp bạn đặt phòng.', '2025-04-19 07:45:17'),
(22, '2 người cho 2 đêm', 'Được rồi, để tìm phòng phù hợp cho bạn, bạn vui lòng chờ một chút nhé. Xin cám ơn!', '2025-04-19 07:45:51'),
(23, 'có phòng chưa bạn', 'Dạ, chúng tôi còn phòng trống cho 2 người trong 2 đêm. Bạn muốn đặt phòng ngay không ạ?', '2025-04-19 09:13:38'),
(24, 'có ạ', 'Để đặt phòng, bạn vui lòng cung cấp thông tin liên hệ của bạn và thời gian đến khách sạn. Bạn cũng có thể thanh toán trực tuyến hoặc khi đến nhận phòng. Có cần tôi giúp gì thêm không ạ?', '2025-04-19 09:13:44'),
(25, 'Tên Phước, số điện thoại 09098232', 'Cảm ơn bạn Phước. Tôi đã ghi nhận thông tin của bạn. Bạn sẽ nhận được xác nhận đặt phòng qua tin nhắn hoặc email trong thời gian sớm nhất. Nếu cần thêm thông tin, hãy cho tôi biết. Chúc bạn có một kì nghỉ thú vị!', '2025-04-19 09:14:14'),
(26, 'hi', 'Hello! How can I assist you today?', '2025-04-19 17:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `contact_detail`
--

CREATE TABLE `contact_detail` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `map` varchar(100) NOT NULL,
  `pn` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `ig` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_detail`
--

INSERT INTO `contact_detail` (`sr_no`, `address`, `map`, `pn`, `email`, `fb`, `tw`, `ig`, `iframe`) VALUES
(1, 'BTEC', 'https://maps.app.goo.gl/DFwGVyjGL8ye849p8', 84645654654, 'hotel@gmail.com', 'https://www.facebook.com/', 'https://x.com/', 'https://www.instagram.com/', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9751.892550642533!2d105.75805!3d9.983037!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08960c9fbe639%3A0x5bb6467de866d109!2sBTEC%20FPT!5e1!3m2!1svi!2sus!4v1742238754987!5m2!1svi!2sus\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `payment_date`, `amount`, `payment_method`, `status`) VALUES
(5, 14, '2025-04-19 18:00:27', 1700000.00, 'Online', 'completed'),
(6, 15, '2025-04-19 18:03:15', 920000.00, 'Online', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_dientich` varchar(50) NOT NULL,
  `room_songuoi` int(50) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('available','occupied','maintenance') DEFAULT 'available',
  `description` text DEFAULT NULL,
  `room_img` varchar(240) DEFAULT NULL,
  `facilities` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_dientich`, `room_songuoi`, `room_type`, `price`, `status`, `description`, `room_img`, `facilities`) VALUES
(1, '101', '50m²', 4, 'room', 850000.00, 'available', 'Cozy room with double bed and balcony.', '101.jpg', 'wifi,parking'),
(2, '102', '28m²', 2, 'room', 900000.00, 'available', 'Modern room with view.', '102.jpg', 'wifi,tv'),
(3, '103', '30m²', 2, 'room', 920000.00, 'occupied', 'Room with garden view and balcony.', '103.jpg', 'wifi,parking,tv'),
(7, '201', '35m²', 3, 'suite', 1250000.00, 'available', 'Spacious suite with living area and sofa.', '203.jpg', 'wifi,pool,parking'),
(8, '202', '38m²', 3, 'suite', 1350000.00, 'available', 'Elegant suite with large windows.', '202.jpg', 'wifi,tv,parking'),
(9, '301', '60m²', 4, 'villa', 2500000.00, 'available', 'Private villa with garden and private pool.', 'villa1.jpg', 'wifi,pool,parking'),
(10, '302', '75m²', 6, 'villa', 2850000.00, 'available', 'Spacious villa with modern kitchen and outdoor lounge.', 'villa2.jpg', 'wifi,pool,kitchen'),
(11, '303', '80m²', 5, 'villa', 2950000.00, 'occupied', 'Luxury beachfront villa with full amenities and sundeck.', 'villa3.jpg', 'wifi,pool,parking,kitchen,bathtub');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_tittle` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_tittle`, `site_about`, `shutdown`) VALUES
(1, 'HIRO', 'dfasdasdsadasdsadd asds sads dsad asdasd as', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(240) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `pass`, `role`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'Nguyễn Văn Admin', 'admin', 'admin_password_hash', 'admin', 'admin@example.com', '0123456789', 'Hà Nội', '2025-03-26 01:32:29'),
(2, 'Trần Thị A', 'trantha', 'customer_password_hash', 'customer', 'trantha@example.com', '0987654321', 'Hồ Chí Minh', '2025-03-26 01:32:29'),
(3, 'Lê Văn B', 'levanb', '123456', 'customer', 'levanb@example.com', '0912345678', 'Đà Nẵng', '2025-03-26 01:32:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `chat_history`
--
ALTER TABLE `chat_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_detail`
--
ALTER TABLE `contact_detail`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chat_history`
--
ALTER TABLE `chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
