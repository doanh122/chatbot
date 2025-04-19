USE hotel;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 27, 2025 lúc 06:38 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hotel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(0, 'admin1', '123');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `booking_date`, `total_price`, `status`) VALUES
(1, 2, 1, '2025-04-01', '2025-04-05', '2025-03-26 01:32:30', 2000000.00, 'unpaid'),
(2, 3, 2, '2025-04-10', '2025-04-12', '2025-03-26 01:32:30', 1500000.00, 'paid'),
(3, 2, 1, '2025-03-26', '2025-03-27', '2025-03-26 04:12:26', 500000.00, 'unpaid'),
(4, 2, 3, '2025-03-26', '2025-03-27', '2025-03-26 16:04:26', 1200000.00, 'unpaid'),
(5, 3, 1, '2025-03-26', '2025-03-27', '2025-03-26 16:12:33', 500000.00, 'paid'),
(6, 3, 3, '2025-03-26', '2025-03-28', '2025-03-26 16:15:30', 2400000.00, 'paid');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_detail`
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
-- Đang đổ dữ liệu cho bảng `contact_detail`
--

INSERT INTO `contact_detail` (`sr_no`, `address`, `map`, `pn`, `email`, `fb`, `tw`, `ig`, `iframe`) VALUES
(1, 'BTEC', 'https://maps.app.goo.gl/DFwGVyjGL8ye849p8', 84645654654, 'hotel@gmail.com', 'https://www.facebook.com/', 'https://x.com/', 'https://www.instagram.com/', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9751.892550642533!2d105.75805!3d9.983037!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08960c9fbe639%3A0x5bb6467de866d109!2sBTEC%20FPT!5e1!3m2!1svi!2sus!4v1742238754987!5m2!1svi!2sus\r\n');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
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
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `payment_date`, `amount`, `payment_method`, `status`) VALUES
(2, 2, '2025-03-26 01:32:30', 1500000.00, 'Online', 'completed'),
(3, 5, '2025-03-26 16:13:55', 500000.00, 'Online', 'completed'),
(4, 6, '2025-03-26 16:17:10', 2400000.00, 'Online', 'completed');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_dientich` varchar(50) NOT NULL,
  `room_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_dientich`, `room_type`) VALUES
(1, '101', '20m²', 'Single'),
(2, '102', '25m²', 'Double'),
(3, '103', '30m²', 'Suite');
