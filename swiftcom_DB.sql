-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2022 at 09:54 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swiftcom`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `timed` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender_username` varchar(255) NOT NULL,
  `receiver_username` varchar(255) NOT NULL,
  `textmsg` text NOT NULL,
  `read_status` int(11) NOT NULL,
  `is_img` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `timed`, `sender_username`, `receiver_username`, `textmsg`, `read_status`, `is_img`) VALUES
(0, '2022-06-29 18:05:13', 'shaheer', 'sam', 'Heyyy', 1, 0),
(1, '2022-06-29 18:05:13', 'sam', 'shaheer', 'yooo man what\'s up?', 1, 0),
(2, '2022-06-29 18:05:13', 'sam', 'shaheer', 'what\'s going on?', 1, 0),
(3, '2022-06-29 18:05:13', 'shaheer', 'sam', 'nothing much', 1, 0),
(4, '2022-06-29 18:05:13', 'shaheer', 'sam', '24/7 at the work 😩', 1, 0),
(5, '2022-06-29 18:05:13', 'sam', 'shaheer', 'seriously?!!', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` text NOT NULL,
  `user_contacts` text NOT NULL,
  `user_status` varchar(255) NOT NULL,
  `profile_pic` text NOT NULL,
  `user_password` text NOT NULL,
  `password_reset` text NOT NULL,
  `blocked_contacts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_fullname`, `user_email`, `user_contacts`, `user_status`, `profile_pic`, `user_password`, `password_reset`, `blocked_contacts`) VALUES
(1, 'shaheer', 'Shaheer Ahmed', 'shaheerahmed576@gmail.com', '2 [] 3 4 5 6', 'online', '1.jpg', '$2y$10$KIjZpYrJIKbML5dX1qEQH.Jba1l6V/14d6uNlwawzD39fVoQxQ9fe', '', ''),
(2, 'sam', 'Sam Smith', 'shaheerahmed576@gmail.com', '1 []', 'online', '1.jpg', '$2y$10$KIjZpYrJIKbML5dX1qEQH.Jba1l6V/14d6uNlwawzD39fVoQxQ9fe', '', ''),
(3, 'keith', 'Keith Sally', 'shaheerahmed576@gmail.com', '[]', 'online', '2.jpg', '$2y$10$KIjZpYrJIKbML5dX1qEQH.Jba1l6V/14d6uNlwawzD39fVoQxQ9fe', '', ''),
(4, 'James', 'James Robert', 'shaheerahmed576@gmail.com', '[]', 'online', '3.jpg', '$2y$10$KIjZpYrJIKbML5dX1qEQH.Jba1l6V/14d6uNlwawzD39fVoQxQ9fe', '', ''),
(5, 'michael', 'Michael David', 'shaheerahmed576@gmail.com', '[]', 'online', '4.jpg', '$2y$10$KIjZpYrJIKbML5dX1qEQH.Jba1l6V/14d6uNlwawzD39fVoQxQ9fe', '', ''),
(6, 'richard', 'Richard William', 'shaheerahmed576@gmail.com', '[]', 'online', '5.jpg', '$2y$10$KIjZpYrJIKbML5dX1qEQH.Jba1l6V/14d6uNlwawzD39fVoQxQ9fe', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
