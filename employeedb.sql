-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 24, 2025 lúc 01:16 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `employeedb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`id`, `name`, `location`) VALUES
(1, 'HR', 'Hà Nội'),
(2, 'IT', 'TP. Hồ Chí Minh'),
(3, 'Finance', 'Đà Nẵng'),
(4, 'Marketing', 'Hải Phòng'),
(5, 'Sales', 'Cần Thơ'),
(6, 'Support', 'Huế'),
(7, 'R&D', 'Nha Trang'),
(8, 'Operations', 'Vũng Tàu'),
(9, 'Legal', 'Bắc Ninh'),
(10, 'Admin', 'Quảng Ninh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `hire_date`, `department_id`, `position`) VALUES
(1, 'Nguyễn Thế Kỷ', 'ntk@example.com', '0987654321', '2022-05-10', 1, 'Nhân sự'),
(2, 'Đặng Minh Phương', 'dmp@example.com', '0976543210', '2023-06-15', 2, 'Lập trình viên'),
(3, 'Nguyễn Công Danh', 'ncd@example.com', '0912345678', '2021-09-20', 3, 'Kế toán'),
(4, 'Nguyễn Như Quỳnh', 'nnq@example.com', '0934567890', '2020-12-01', 4, 'Marketing Manager'),
(5, 'Hoàng Văn Đức', 'hve@example.com', '0978456123', '2019-03-25', 5, 'Nhân viên bán hàng'),
(6, 'Đặng Thị Hương', 'dtf@example.com', '0923456789', '2022-07-15', 6, 'Hỗ trợ khách hàng'),
(7, 'Võ Văn Kiệt', 'vvg@example.com', '0956789123', '2023-01-10', 7, 'Nghiên cứu viên'),
(8, 'Bùi Thị Mai', 'bth@example.com', '0965432178', '2018-05-05', 8, 'Quản lý vận hành'),
(9, 'Ngô Văn Quang', 'nvi@example.com', '0987654322', '2024-02-18', 9, 'Luật sư'),
(10, 'Dương Thị Trang', 'dtj@example.com', '0912123456', '2023-08-22', 10, 'Quản trị viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','manager','employee') DEFAULT 'employee',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `employee_id`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 1, 'nguyentheky', '123456', 'manager', 'active', '2025-03-24 09:05:16'),
(2, 2, 'dangminhphuong', 'abc123', 'employee', 'active', '2025-03-24 09:05:16'),
(3, 3, 'trancongdanh', 'password1', 'manager', 'active', '2025-03-24 09:05:16'),
(4, 4, 'nguyennhuquynh', 'password2', 'employee', 'active', '2025-03-24 09:05:16'),
(5, 5, 'hoangvanduc', 'password3', 'employee', 'active', '2025-03-24 09:05:16'),
(6, 6, 'dangthihuong', 'password4', 'employee', 'active', '2025-03-24 09:05:16'),
(7, 7, 'vovankiet', 'password5', 'manager', 'active', '2025-03-24 09:05:16'),
(8, 8, 'buithimai', 'password6', 'employee', 'active', '2025-03-24 09:05:16'),
(9, 9, 'ngovanquang', 'password7', 'employee', 'active', '2025-03-24 09:05:16'),
(10, 10, 'admin', 'admin', 'admin', 'active', '2025-03-24 09:05:16');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `department_id` (`department_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
