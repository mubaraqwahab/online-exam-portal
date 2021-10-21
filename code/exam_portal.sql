-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2020 at 05:22 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment_status`
--

CREATE TABLE `assignment_status` (
  `status_id` int(11) NOT NULL,
  `value` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assignment_status`
--

INSERT INTO `assignment_status` (`status_id`, `value`) VALUES
(1, 'Awaiting approval'),
(2, 'Declined'),
(6, 'Graded'),
(4, 'In progress'),
(3, 'Ready'),
(5, 'Turned in');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(8) NOT NULL,
  `course_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_name`) VALUES
('CSC307', 'Computer Architecture and Organization'),
('GST301', 'Entrepreneurial Studies II'),
('CSC334', 'Numerical Analysis'),
('CSC303', 'Object Oriented Programming'),
('CSC305', 'Operating Systems II'),
('CSC309', 'Sytem Analysis and Design'),
('CSC313', 'Web Programming');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `instructor_id` varchar(16) NOT NULL,
  `course_code` varchar(8) NOT NULL,
  `title` varchar(45) NOT NULL,
  `type_id` int(11) NOT NULL,
  `no_of_questions` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `invite_prefix` varchar(5) NOT NULL,
  `total_mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exam_id`, `instructor_id`, `course_code`, `title`, `type_id`, `no_of_questions`, `status_id`, `invite_prefix`, `total_mark`) VALUES
(32, '171103026', 'CSC313', 'Quiz', 2, 1, 2, 'zmB1s', 150),
(34, '171103018', 'CSC313', 'Quiz II', 1, 1, 1, 'EnXAS', 0),
(36, '171103018', 'CSC305', 'Quiz IV', 2, 1, 1, 'JRvsa', 0),
(37, '171103026', 'GST301', 'Final Exam', 2, 3, 1, 'WmYyO', 0),
(38, '171103026', 'CSC307', 'Final', 1, 3, 1, '86xjM', 0),
(39, '171103018', 'CSC309', 'Finals', 1, 2, 1, 'TTetm', 70),
(40, '171103026', 'CSC307', 'Finals', 3, 2, 2, 'qecrv', 0),
(41, '171103026', 'CSC303', 'Finger Exercise', 2, 2, 1, '6bWkp', 30),
(42, '171103018', 'GST301', 'Finals', 1, 2, 1, 'JQxa4', 0),
(43, 'mubaraqwahab', 'CSC307', 'Midterm', 1, 2, 1, 've3MG', 0),
(44, '171103026', 'CSC307', 'Finals', 2, 1, 1, 'KznOI', 10),
(45, '171103026', 'CSC307', 'Midterm', 2, 1, 2, 'zXSue', 100),
(46, '171103026', 'CSC307', '', 2, 1, 1, 'caT11', 0),
(47, '171103026', 'CSC334', 'Quiz', 3, 1, 1, 'ZxURZ', 50),
(48, '171103018', 'CSC334', 'Quiz', 1, 2, 1, 'qT2f9', 50),
(49, '171103018', 'GST301', 'Quiz', 2, 1, 1, 'QnwCM', 30),
(50, '171103026', 'CSC303', 'Quiz', 2, 1, 1, '4aJhz', 10),
(51, '171103026', 'CSC307', 'Mid', 1, 1, 2, '5p8Ob', 10),
(52, '171103026', 'CSC313', 'Finale', 1, 1, 2, 'UxPPh', 25),
(53, '171103026', 'CSC305', 'Quiz', 1, 1, 2, 'CRYjp', 30),
(54, '171103018', 'CSC309', 'Quiz 2', 2, 1, 1, '3zVbj', 12),
(55, '171103026', 'CSC307', 'Theory', 3, 2, 2, 'mssZb', 30);

-- --------------------------------------------------------

--
-- Table structure for table `exam_assignment`
--

CREATE TABLE `exam_assignment` (
  `exam_id` int(11) NOT NULL,
  `assignee_id` varchar(16) NOT NULL,
  `total_score` float DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam_assignment`
--

INSERT INTO `exam_assignment` (`exam_id`, `assignee_id`, `total_score`, `status_id`) VALUES
(32, '171103007', NULL, 5),
(32, '171103010', 100, 6),
(32, '171103018', 98, 2),
(37, '171103007', NULL, 1),
(37, '171103018', NULL, 3),
(38, '171103007', NULL, 1),
(38, '171103010', NULL, 1),
(38, '171103018', NULL, 1),
(39, '171103010', NULL, 1),
(39, '171103026', 20, 6),
(40, '171103010', NULL, 1),
(40, '171103018', NULL, 1),
(41, '171103010', NULL, 1),
(41, '171103018', NULL, 3),
(42, '171103018', NULL, 6),
(42, '171103026', NULL, 6),
(43, 'mubaraqwahab', NULL, 4),
(44, '171103026', 10, 6),
(45, '171103018', NULL, 2),
(45, '171103023', NULL, 1),
(47, '171103026', 7, 6),
(48, '171103026', 30, 6),
(49, '171103026', NULL, 5),
(50, '171103018', NULL, 5),
(50, 'mubaraqwahab', NULL, 5),
(51, '171103018', NULL, 5),
(51, 'mubaraqwahab', NULL, 5),
(52, '171103018', NULL, 5),
(53, '171103018', 30, 6),
(53, '171103026', NULL, 2),
(53, 'mubaraqwahab', 0, 6),
(54, '171103026', 0, 6),
(55, '171103018', 22, 6),
(55, 'mubaraqwahab', 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `exam_status`
--

CREATE TABLE `exam_status` (
  `status_id` int(11) NOT NULL,
  `value` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam_status`
--

INSERT INTO `exam_status` (`status_id`, `value`) VALUES
(2, 'Closed'),
(1, 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `type_id` int(11) NOT NULL,
  `value` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam_type`
--

INSERT INTO `exam_type` (`type_id`, `value`) VALUES
(2, 'Fill in the blank'),
(1, 'Multi-choice'),
(3, 'Theory');

-- --------------------------------------------------------

--
-- Table structure for table `fill_in_question`
--

CREATE TABLE `fill_in_question` (
  `exam_id` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `question` varchar(256) NOT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fill_in_question`
--

INSERT INTO `fill_in_question` (`exam_id`, `question_no`, `question`, `mark`) VALUES
(32, 1, 'PHP stands for ___', 15),
(36, 1, 'What\'s SSTF? ___', 100),
(37, 1, 'What lies at the nexus of talent, passion, need and conscience is ___?', 20),
(37, 2, '___ is value creation', 30),
(37, 3, 'BryCoal is an enterprise created by ___ (number) students', 50),
(41, 1, 'Java uses pointers, true or false? ___', 10),
(41, 2, 'JVM stands for ___', 20),
(44, 1, 'PCIe stands for ___', 10),
(45, 1, 'What\'s Architecture?', 100),
(49, 1, 'What lies at the nexus of TAPANECO is ___', 30),
(50, 1, 'Do you like Java? Yes/No? ___', 10),
(54, 1, 'What?___', 12);

-- --------------------------------------------------------

--
-- Table structure for table `fill_in_response`
--

CREATE TABLE `fill_in_response` (
  `exam_id` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `assignee_id` varchar(16) NOT NULL,
  `response` varchar(45) DEFAULT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fill_in_response`
--

INSERT INTO `fill_in_response` (`exam_id`, `question_no`, `assignee_id`, `response`, `score`) VALUES
(32, 1, '171103018', 'Personal Home Page', 7.5),
(41, 1, '171103018', 'false', NULL),
(41, 2, '171103018', 'Java Virtual Machine', NULL),
(44, 1, '171103026', 'Peripheral Component Interconnect Express', 10),
(49, 1, '171103026', 'entrepreneurial voice', NULL),
(54, 1, '171103026', 'efsdsds', 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `value` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `value`) VALUES
(1, '100'),
(2, '200'),
(3, '300'),
(4, '400'),
(5, '500');

-- --------------------------------------------------------

--
-- Table structure for table `multi_choice_question`
--

CREATE TABLE `multi_choice_question` (
  `exam_id` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `question` varchar(256) NOT NULL,
  `correct_answer` varchar(1) NOT NULL,
  `a` varchar(256) NOT NULL,
  `b` varchar(256) NOT NULL,
  `c` varchar(256) NOT NULL,
  `d` varchar(256) NOT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `multi_choice_question`
--

INSERT INTO `multi_choice_question` (`exam_id`, `question_no`, `question`, `correct_answer`, `a`, `b`, `c`, `d`, `mark`) VALUES
(34, 1, 'What\'s HTML?', 'B', 'Hypertext\'s markdown language', 'Hypertext markup language', 'Hyperthreaded machine link', 'Hyperthreaded motor link', 10),
(38, 3, 'What was the last thing we did in class?', 'A', 'Presentation', 'Revision', 'Normal class', 'Lab class', 35),
(39, 1, 'abcdefghiljkad sdjasj asd', 'A', 'assdjsk', 'fdkjfdf', 'Cascading Style Sheets', 'ajkd', 20),
(39, 2, 'fdfh sjdk rekj aslkjf dnxv', 'D', 'qwere', 'dfvcx', 'asdfd', 'ythgb', 50),
(42, 1, 'What lies at the nexus of TAPANECO?', 'C', 'Talent', 'Passion', 'Voice', 'Conscience', 2),
(42, 2, 'Why did you choose what you chose above?', 'A', 'I felt like', 'I felt it is the correct answer', 'None of the above', 'All of the above', 1),
(43, 1, 'abc def', 'C', 'abc', 'cef', 'ghi', 'ajkd', 4),
(43, 2, 'adfghjy yutfd', 'A', 'hgf', 'dfgh', 'uyg', 'cvb', 6),
(48, 1, 'Which of these did\'nt we do in class?', 'C', 'Simpson\'s Rule', 'Newton-Raphson', 'Taylor expansion', 'Bisection method', 20),
(48, 2, 'What\'s the name of your lecturer?', 'B', 'Prof. Agwu', 'Dr. Mary', 'Prof. Moussa', 'Mr. Salisu', 30),
(51, 1, 'Who\'s the lecturer', 'A', 'Mr Salisu', 'Mr Saka', 'Mr Dalhatu', 'Mr Abass', 10),
(52, 1, 'Which isn\'t related to Web?', 'D', 'PHP', 'HTML', 'jQuery', 'OralB', 25),
(53, 1, 'Paging and not what?', 'C', 'Virtual memory', 'Segmentation', 'Bootstrap', 'Memory allocation', 30);

-- --------------------------------------------------------

--
-- Table structure for table `multi_choice_response`
--

CREATE TABLE `multi_choice_response` (
  `exam_id` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `assignee_id` varchar(16) NOT NULL,
  `response` varchar(1) DEFAULT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `multi_choice_response`
--

INSERT INTO `multi_choice_response` (`exam_id`, `question_no`, `assignee_id`, `response`, `score`) VALUES
(39, 1, '171103026', 'a', 20),
(39, 2, '171103026', 'c', 0),
(42, 1, '171103018', 'C', 2),
(42, 1, '171103026', 'D', 0),
(42, 2, '171103018', 'A', 1),
(42, 2, '171103026', 'A', 1),
(43, 1, 'mubaraqwahab', 'A', 0),
(43, 2, 'mubaraqwahab', 'A', 6),
(48, 1, '171103026', 'D', 0),
(48, 2, '171103026', 'B', 30),
(53, 1, '171103018', 'C', 30),
(53, 1, 'mubaraqwahab', 'D', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(10) UNSIGNED NOT NULL,
  `recipient_id` varchar(16) NOT NULL,
  `status_id` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `type_id` int(11) UNSIGNED NOT NULL,
  `sender_id` varchar(16) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `recipient_id`, `status_id`, `type_id`, `sender_id`, `exam_id`, `time_stamp`) VALUES
(19, '171103018', 2, 2, '171103026', 47, '2020-01-05 00:39:59'),
(20, '171103018', 2, 3, '171103026', 41, '2020-01-05 00:48:14'),
(21, '171103018', 2, 4, '171103026', 46, '2020-01-05 00:48:14'),
(22, '171103018', 2, 5, '171103026', 45, '2020-01-05 00:49:57'),
(23, '171103018', 2, 6, '171103026', 40, '2020-01-05 00:49:57'),
(24, '171103018', 2, 7, '171103026', 44, '2020-01-05 00:51:23'),
(25, '171103018', 2, 8, '171103026', 47, '2020-01-05 00:51:23'),
(26, '171103010', 1, 8, '171103026', 46, '2020-01-05 02:24:55'),
(31, '171103026', 2, 2, '171103018', 45, '2020-01-05 10:33:33'),
(36, '171103026', 2, 3, '171103018', 45, '2020-01-05 11:03:49'),
(38, '171103026', 2, 3, '171103018', 45, '2020-01-05 11:10:00'),
(40, '171103026', 2, 2, '171103018', 45, '2020-01-05 11:12:59'),
(42, '171103026', 2, 2, '171103018', 45, '2020-01-05 11:16:57'),
(44, '171103026', 2, 3, '171103018', 45, '2020-01-05 11:20:18'),
(46, '171103026', 2, 3, '171103018', 45, '2020-01-05 11:23:33'),
(48, '171103018', 2, 2, '171103026', 48, '2020-01-05 11:31:28'),
(49, '171103018', 2, 6, '171103026', 48, '2020-01-05 11:55:38'),
(50, '171103026', 2, 7, '171103018', 48, '2020-01-05 11:55:38'),
(51, '171103018', 2, 4, '171103026', 49, '2020-01-05 12:35:29'),
(52, '171103018', 2, 2, '171103026', 49, '2020-01-05 12:43:24'),
(53, '171103018', 2, 6, '171103026', 49, '2020-01-05 12:43:40'),
(55, '171103026', 2, 2, '171103018', 50, '2020-01-05 13:15:33'),
(56, '171103026', 2, 4, 'mubaraqwahab', 50, '2020-01-05 13:16:38'),
(57, '171103026', 2, 5, '171103018', 50, '2020-01-05 13:17:04'),
(58, '171103026', 2, 5, 'mubaraqwahab', 50, '2020-01-05 13:20:26'),
(60, '171103026', 2, 4, 'mubaraqwahab', 51, '2020-01-05 13:30:27'),
(61, '171103026', 2, 2, '171103018', 51, '2020-01-05 13:31:21'),
(62, '171103026', 2, 5, '171103018', 51, '2020-01-05 13:31:27'),
(63, '171103026', 2, 5, 'mubaraqwahab', 51, '2020-01-05 13:33:01'),
(65, '171103026', 2, 2, '171103018', 52, '2020-01-05 13:43:20'),
(66, '171103026', 2, 5, '171103018', 52, '2020-01-05 13:47:31'),
(69, '171103026', 2, 3, '171103026', 53, '2020-01-05 13:56:06'),
(70, '171103026', 2, 2, '171103018', 53, '2020-01-05 13:56:25'),
(71, '171103026', 2, 5, '171103018', 53, '2020-01-05 13:56:36'),
(72, '171103026', 2, 6, '171103018', 53, '2020-01-05 13:56:40'),
(73, '171103018', 2, 7, '171103026', 53, '2020-01-05 13:56:40'),
(74, '171103026', 2, 4, 'mubaraqwahab', 53, '2020-01-05 13:57:16'),
(75, '171103026', 2, 5, 'mubaraqwahab', 53, '2020-01-05 13:58:04'),
(76, '171103026', 2, 6, 'mubaraqwahab', 53, '2020-01-05 13:58:35'),
(77, 'mubaraqwahab', 2, 7, '171103026', 53, '2020-01-05 13:58:35'),
(78, '171103018', 2, 4, '171103026', 54, '2020-01-05 15:18:39'),
(79, '171103018', 2, 5, '171103026', 54, '2020-01-05 15:18:47'),
(80, '171103018', 2, 6, '171103026', 54, '2020-01-05 15:19:06'),
(81, '171103026', 2, 5, '171103026', 44, '2020-01-05 15:24:00'),
(82, '171103026', 2, 6, '171103026', 44, '2020-01-05 15:24:05'),
(84, '171103026', 2, 2, '171103018', 55, '2020-01-05 15:56:53'),
(85, '171103026', 2, 4, 'mubaraqwahab', 55, '2020-01-05 15:57:08'),
(86, '171103026', 2, 5, '171103018', 55, '2020-01-05 15:57:31'),
(87, '171103026', 2, 6, '171103018', 55, '2020-01-05 15:57:58'),
(88, '171103026', 2, 5, 'mubaraqwahab', 55, '2020-01-05 15:58:04'),
(89, '171103026', 2, 6, 'mubaraqwahab', 55, '2020-01-05 15:58:24'),
(90, 'mubaraqwahab', 2, 7, '171103026', 55, '2020-01-05 16:14:16'),
(91, '171103018', 2, 8, '171103026', 55, '2020-01-05 16:36:05'),
(92, 'mubaraqwahab', 2, 8, '171103026', 55, '2020-01-05 16:36:05'),
(93, '171103018', 2, 8, '171103026', 55, '2020-01-05 16:36:25'),
(94, 'mubaraqwahab', 2, 8, '171103026', 55, '2020-01-05 16:36:25'),
(95, '171103018', 2, 8, '171103026', 55, '2020-01-05 16:41:54'),
(96, 'mubaraqwahab', 1, 8, '171103026', 55, '2020-01-05 16:41:54'),
(97, '171103018', 2, 8, '171103026', 55, '2020-01-05 16:42:06'),
(98, 'mubaraqwahab', 1, 8, '171103026', 55, '2020-01-05 16:42:07'),
(99, '171103018', 2, 8, '171103026', 55, '2020-01-05 16:42:08'),
(100, 'mubaraqwahab', 1, 8, '171103026', 55, '2020-01-05 16:42:08'),
(101, '171103018', 2, 8, '171103026', 55, '2020-01-05 16:43:09'),
(102, 'mubaraqwahab', 1, 8, '171103026', 55, '2020-01-05 16:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `notification_status`
--

CREATE TABLE `notification_status` (
  `status_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification_status`
--

INSERT INTO `notification_status` (`status_id`, `value`) VALUES
(1, 'Unviewed'),
(2, 'Viewed');

-- --------------------------------------------------------

--
-- Table structure for table `notification_type`
--

CREATE TABLE `notification_type` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(45) NOT NULL,
  `msg_template` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification_type`
--

INSERT INTO `notification_type` (`type_id`, `value`, `msg_template`) VALUES
(1, 'Invite', '[User] has invited you to take [Exam]'),
(2, 'Accepted invite', '[User] has accepted your invite to take [Exam]'),
(3, 'Declined invite', '[User] has declined your invite to take [Exam]'),
(4, 'Joined by code', '[User] has joined [Exam] by invite code'),
(5, 'Started exam', '[User] has started [Exam]'),
(6, 'Completed exam', '[User] has completed [Exam]'),
(7, 'Graded exam', '[User] has graded [Exam]'),
(8, 'Closed exam', '[User] has closed [Exam]');

-- --------------------------------------------------------

--
-- Table structure for table `theory_question`
--

CREATE TABLE `theory_question` (
  `exam_id` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `question` varchar(256) NOT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theory_question`
--

INSERT INTO `theory_question` (`exam_id`, `question_no`, `question`, `mark`) VALUES
(40, 1, 'What is your name?', 20),
(40, 2, 'What is my surname?', 30),
(47, 1, 'What is numerical analysis?', 50),
(55, 1, 'What is structure?', 15),
(55, 2, 'What is function?', 15);

-- --------------------------------------------------------

--
-- Table structure for table `theory_response`
--

CREATE TABLE `theory_response` (
  `exam_id` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `assignee_id` varchar(16) NOT NULL,
  `response` varchar(256) DEFAULT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theory_response`
--

INSERT INTO `theory_response` (`exam_id`, `question_no`, `assignee_id`, `response`, `score`) VALUES
(47, 1, '171103026', 'A mathematical course', 7),
(55, 1, '171103018', 'organization and interconnection of pc components', 10),
(55, 1, 'mubaraqwahab', 'Struct', 0),
(55, 2, '171103018', 'what the components do as part of structure', 12),
(55, 2, 'mubaraqwahab', 'A user defined function', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(16) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `profile_picture` varchar(45) DEFAULT NULL,
  `recovery_key` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `password`, `level_id`, `profile_picture`, `recovery_key`) VALUES
('171103007', 'Isa', 'Elleman', 'isaelleman@gmail.com', 'IsahE123', 3, NULL, NULL),
('171103010', 'Isiaq', 'Ibrahim', 'isiaq@yahoo.com', 'qwerty123', 3, NULL, NULL),
('171103018', 'Mustapha', 'Ibrahim', 'mikabu38@gmail.com', 'f4b37afc59e0792a3ea73192c96eb554', 3, '6bb000002217edf20324947d1d8eb5b1.jpg', NULL),
('171103023', 'Ibrahim', 'Subair', 'isubair538@gmail.com', '7d15f9c41f7a78cca8c3e177a1fd8157', 3, '7f34abc2948b89c689b335391a17d20e.jpg', NULL),
('171103026', 'Mubaraq', 'Wahab', 'mub.wahab26@gmail.com', '433484b5317340f5c28e085bfffc78be', 3, 'dcba3346dff99f519e98f886b5f0b95c.jpg', NULL),
('muazumd', 'Muazu', 'Abubakar', 'muazumd@gmail.com', '9614fe5793fddfe3217c3501fefeb3ba', NULL, 'c8e8851d0bd8e4f4097bd26f0005379a.jpg', NULL),
('mubaraqwahab', 'Mubaraq', 'Wahab', 'mub.wahab26@yahoo.com', '1234567890', 3, 'df3ebd0416d9ca00d1497f1a86344729.jpg', '770864');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment_status`
--
ALTER TABLE `assignment_status`
  ADD PRIMARY KEY (`status_id`),
  ADD UNIQUE KEY `assignment_status_value_UNIQUE` (`value`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`),
  ADD UNIQUE KEY `course_name_UNIQUE` (`course_name`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `exam_course_code_idx` (`course_code`),
  ADD KEY `exam_type_id_idx` (`type_id`),
  ADD KEY `exam_instructor_id_idx` (`instructor_id`),
  ADD KEY `exam_status_id` (`status_id`);

--
-- Indexes for table `exam_assignment`
--
ALTER TABLE `exam_assignment`
  ADD PRIMARY KEY (`exam_id`,`assignee_id`),
  ADD KEY `assignment_assignee_id_idx` (`assignee_id`),
  ADD KEY `assignment_status_id_idx` (`status_id`);

--
-- Indexes for table `exam_status`
--
ALTER TABLE `exam_status`
  ADD PRIMARY KEY (`status_id`),
  ADD UNIQUE KEY `exam_status_value_UNIQUE` (`value`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `exam_type_value_UNIQUE` (`value`);

--
-- Indexes for table `fill_in_question`
--
ALTER TABLE `fill_in_question`
  ADD PRIMARY KEY (`exam_id`,`question_no`);

--
-- Indexes for table `fill_in_response`
--
ALTER TABLE `fill_in_response`
  ADD PRIMARY KEY (`exam_id`,`question_no`,`assignee_id`),
  ADD KEY `fill_in_response_assignee_id_idx` (`assignee_id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`),
  ADD UNIQUE KEY `level_value_UNIQUE` (`value`);

--
-- Indexes for table `multi_choice_question`
--
ALTER TABLE `multi_choice_question`
  ADD PRIMARY KEY (`exam_id`,`question_no`);

--
-- Indexes for table `multi_choice_response`
--
ALTER TABLE `multi_choice_response`
  ADD PRIMARY KEY (`exam_id`,`question_no`,`assignee_id`),
  ADD KEY `multi_choice_response_assignee_id_idx` (`assignee_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notification_status_id` (`status_id`),
  ADD KEY `notification_sender_id` (`sender_id`),
  ADD KEY `notification_type_id` (`type_id`),
  ADD KEY `notification_recipient_id` (`recipient_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `notification_status`
--
ALTER TABLE `notification_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `msg_template_UNIQUE` (`msg_template`);

--
-- Indexes for table `theory_question`
--
ALTER TABLE `theory_question`
  ADD PRIMARY KEY (`exam_id`,`question_no`);

--
-- Indexes for table `theory_response`
--
ALTER TABLE `theory_response`
  ADD PRIMARY KEY (`exam_id`,`question_no`,`assignee_id`),
  ADD KEY `theory_response_assignee_id_idx` (`assignee_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`) USING BTREE,
  ADD KEY `user_level_id_idx` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment_status`
--
ALTER TABLE `assignment_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `exam_status`
--
ALTER TABLE `exam_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `notification_status`
--
ALTER TABLE `notification_status`
  MODIFY `status_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification_type`
--
ALTER TABLE `notification_type`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_course_code` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_instructor_id` FOREIGN KEY (`instructor_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_status_id` FOREIGN KEY (`status_id`) REFERENCES `exam_status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_type_id` FOREIGN KEY (`type_id`) REFERENCES `exam_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_assignment`
--
ALTER TABLE `exam_assignment`
  ADD CONSTRAINT `assignment_assignee_id` FOREIGN KEY (`assignee_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignment_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignment_status_id` FOREIGN KEY (`status_id`) REFERENCES `assignment_status` (`status_id`) ON UPDATE CASCADE;

--
-- Constraints for table `fill_in_question`
--
ALTER TABLE `fill_in_question`
  ADD CONSTRAINT `fill_in_question_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fill_in_response`
--
ALTER TABLE `fill_in_response`
  ADD CONSTRAINT `fill_in_response_assignee_id` FOREIGN KEY (`assignee_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fill_in_response_id` FOREIGN KEY (`exam_id`,`question_no`) REFERENCES `fill_in_question` (`exam_id`, `question_no`) ON DELETE CASCADE;

--
-- Constraints for table `multi_choice_question`
--
ALTER TABLE `multi_choice_question`
  ADD CONSTRAINT `multi_choice_question_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `multi_choice_response`
--
ALTER TABLE `multi_choice_response`
  ADD CONSTRAINT `multi_choice_response_assignee_id` FOREIGN KEY (`assignee_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `multi_choice_response_id` FOREIGN KEY (`exam_id`,`question_no`) REFERENCES `multi_choice_question` (`exam_id`, `question_no`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_recipient_id` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_status_id` FOREIGN KEY (`status_id`) REFERENCES `notification_status` (`status_id`),
  ADD CONSTRAINT `notification_type_id` FOREIGN KEY (`type_id`) REFERENCES `notification_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `theory_question`
--
ALTER TABLE `theory_question`
  ADD CONSTRAINT `theory_question_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `theory_response`
--
ALTER TABLE `theory_response`
  ADD CONSTRAINT `theory_response_assignee_id` FOREIGN KEY (`assignee_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `theory_response_id` FOREIGN KEY (`exam_id`,`question_no`) REFERENCES `theory_question` (`exam_id`, `question_no`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_level_id` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`) ON DELETE CASCADE ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
