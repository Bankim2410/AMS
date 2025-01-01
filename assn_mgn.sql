-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 01:33 PM
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
-- Database: `assn_mgn`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`email`, `password`) VALUES
('jkcgroupa@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`) VALUES
(1, 'COSH'),
(2, 'CHEM'),
(3, 'MATH'),
(4, 'BENG'),
(5, 'HIST'),
(6, 'ENG');

-- --------------------------------------------------------

--
-- Table structure for table `papers_of_departments`
--

CREATE TABLE `papers_of_departments` (
  `paper_id` int(11) NOT NULL,
  `paper_name` varchar(100) DEFAULT NULL,
  `paper_code` varchar(10) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `papers_of_departments`
--

INSERT INTO `papers_of_departments` (`paper_id`, `paper_name`, `paper_code`, `semester`, `dept_id`) VALUES
(1, 'Introduction to Computer Science', 'CSC101', 1, 1),
(2, 'Data Structures and Algorithms', 'CSC102', 1, 1),
(3, 'Computer Networks', 'CSC103', 1, 1),
(4, 'Object-Oriented Programming', 'CSC201', 2, 1),
(5, 'Database Management Systems', 'CSC202', 2, 1),
(6, 'Web Development', 'CSC203', 2, 1),
(7, 'Operating Systems', 'CSC301', 3, 1),
(8, 'Software Engineering', 'CSC302', 3, 1),
(9, 'Algorithm Design and Analysis', 'CSC303', 3, 1),
(10, 'Computer Architecture', 'CSC401', 4, 1),
(11, 'Artificial Intelligence', 'CSC402', 4, 1),
(12, 'Cybersecurity', 'CSC403', 4, 1),
(13, 'Big Data Analytics', 'CSC501', 5, 1),
(14, 'Cloud Computing', 'CSC502', 5, 1),
(15, 'Mobile Application Development', 'CSC503', 5, 1),
(16, 'Internet Technologies', 'CSC601', 6, 1),
(17, 'Operations Research', 'CSC602', 6, 1),
(18, 'Computer Vision', 'CSC603', 6, 1),
(19, 'General Chemistry', 'CHE101', 1, 2),
(20, 'Organic Chemistry', 'CHE102', 1, 2),
(21, 'Physical Chemistry', 'CHE103', 1, 2),
(22, 'Inorganic Chemistry', 'CHE201', 2, 2),
(23, 'Analytical Chemistry', 'CHE202', 2, 2),
(24, 'Biochemistry', 'CHE203', 2, 2),
(25, 'Polymer Chemistry', 'CHE301', 3, 2),
(26, 'Environmental Chemistry', 'CHE302', 3, 2),
(27, 'Industrial Chemistry', 'CHE303', 3, 2),
(28, 'Medicinal Chemistry', 'CHE401', 4, 2),
(29, 'Nuclear Chemistry', 'CHE402', 4, 2),
(30, 'Chemical Engineering', 'CHE403', 4, 2),
(31, 'Food Chemistry', 'CHE501', 5, 2),
(32, 'Petroleum Chemistry', 'CHE502', 5, 2),
(33, 'Forensic Chemistry', 'CHE503', 5, 2),
(34, 'Astrochemistry', 'CHE601', 6, 2),
(35, 'Green Chemistry', 'CHE602', 6, 2),
(36, 'Chemical Kinetics', 'CHE603', 6, 2),
(37, 'Calculus', 'MAT101', 1, 3),
(38, 'Linear Algebra', 'MAT102', 1, 3),
(39, 'Discrete Mathematics', 'MAT103', 1, 3),
(40, 'Differential Equations', 'MAT201', 2, 3),
(41, 'Real Analysis', 'MAT202', 2, 3),
(42, 'Complex Analysis', 'MAT203', 2, 3),
(43, 'Topology', 'MAT301', 3, 3),
(44, 'Number Theory', 'MAT302', 3, 3),
(45, 'Graph Theory', 'MAT303', 3, 3),
(46, 'Abstract Algebra', 'MAT401', 4, 3),
(47, 'Mathematical Logic', 'MAT402', 4, 3),
(48, 'Numerical Analysis', 'MAT403', 4, 3),
(49, 'Probability Theory', 'MAT501', 5, 3),
(50, 'Statistics', 'MAT502', 5, 3),
(51, 'Operations Research', 'MAT503', 5, 3),
(52, 'Mathematical Physics', 'MAT601', 6, 3),
(53, 'Computational Mathematics', 'MAT602', 6, 3),
(54, 'Mathematical Modeling', 'MAT603', 6, 3),
(55, 'Bengali Literature - I', 'BENG101', 1, 4),
(56, 'Bengali Grammar and Composition', 'BENG102', 1, 4),
(57, 'History of Bengali Language', 'BENG103', 1, 4),
(58, 'Bengali Literature - II', 'BENG201', 2, 4),
(59, 'Modern Bengali Poetry', 'BENG202', 2, 4),
(60, 'Bengali Drama and Novel', 'BENG203', 2, 4),
(61, 'Bengali Literature - III', 'BENG301', 3, 4),
(62, 'Bengali Prose and Essay', 'BENG302', 3, 4),
(63, 'Bengali Folk Literature', 'BENG303', 3, 4),
(64, 'Bengali Literature - IV', 'BENG401', 4, 4),
(65, 'Bengali Literary Criticism', 'BENG402', 4, 4),
(66, 'Bengali Literature in Translation', 'BENG403', 4, 4),
(67, 'Bengali Literature - V', 'BENG501', 5, 4),
(68, 'Bengali Language and Culture', 'BENG502', 5, 4),
(69, 'Bengali Literature and Gender Studies', 'BENG503', 5, 4),
(70, 'Bengali Literature - VI', 'BENG601', 6, 4),
(71, 'Comparative Literature', 'BENG602', 6, 4),
(72, 'Modern Bengali Drama', 'BENG603', 6, 4),
(73, 'Ancient History - I', 'HIST101', 1, 5),
(74, 'Medieval History - I', 'HIST102', 1, 5),
(75, 'Modern History - I', 'HIST103', 1, 5),
(76, 'Ancient History - II', 'HIST201', 2, 5),
(77, 'Medieval History - II', 'HIST202', 2, 5),
(78, 'Modern History - II', 'HIST203', 2, 5),
(79, 'Ancient History - III', 'HIST301', 3, 5),
(80, 'Medieval History - III', 'HIST302', 3, 5),
(81, 'Modern History - III', 'HIST303', 3, 5),
(82, 'Ancient History - IV', 'HIST401', 4, 5),
(83, 'Medieval History - IV', 'HIST402', 4, 5),
(84, 'Modern History - IV', 'HIST403', 4, 5),
(85, 'Ancient History - V', 'HIST501', 5, 5),
(86, 'Medieval History - V', 'HIST502', 5, 5),
(87, 'Modern History - V', 'HIST503', 5, 5),
(88, 'Ancient History - VI', 'HIST601', 6, 5),
(89, 'Medieval History - VI', 'HIST602', 6, 5),
(90, 'Modern History - VI', 'HIST603', 6, 5),
(91, 'English Literature - I', 'ENG101', 1, 6),
(92, 'English Grammar and Composition - I', 'ENG102', 1, 6),
(93, 'Introduction to Linguistics', 'ENG103', 1, 6),
(94, 'English Literature - II', 'ENG201', 2, 6),
(95, 'English Grammar and Composition - II', 'ENG202', 2, 6),
(96, 'British History and Culture', 'ENG203', 2, 6),
(97, 'English Literature - III', 'ENG301', 3, 6),
(98, 'Introduction to American Literature', 'ENG302', 3, 6),
(99, 'Contemporary Literary Theory', 'ENG303', 3, 6),
(100, 'English Literature - IV', 'ENG401', 4, 6),
(101, 'World Literature', 'ENG402', 4, 6),
(102, 'English Language Teaching', 'ENG403', 4, 6),
(103, 'English Literature - V', 'ENG501', 5, 6),
(104, 'Postcolonial Literature', 'ENG502', 5, 6),
(105, 'Language and Gender', 'ENG503', 5, 6),
(106, 'English Literature - VI', 'ENG601', 6, 6),
(107, 'Literary Criticism', 'ENG602', 6, 6),
(108, 'Research Methodology in English Studies', 'ENG603', 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `enrollment_id` bigint(20) NOT NULL,
  `full_name` varchar(80) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `aadhar_no` bigint(20) NOT NULL,
  `s_year` int(3) NOT NULL,
  `Semester` varchar(30) NOT NULL,
  `date_admission` date NOT NULL,
  `programme` varchar(5) NOT NULL,
  `department` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`enrollment_id`, `full_name`, `date_of_birth`, `email`, `mobile_no`, `gender`, `address`, `aadhar_no`, `s_year`, `Semester`, `date_admission`, `programme`, `department`, `password`) VALUES
(1000000001, 'Arijit Das', '2003-05-15', 'iarijitdas03@gmail.com', 9064601774, 'Male', 'Cooks Compound, Purulia', 905845253766, 3, '6', '2024-06-12', 'B.Sc.', 'COSH', 'ad123'),
(1000000002, 'Rajat Sen', '2002-02-13', 'rajs@gmail.com', 9965452323, 'Male', 'Deshbandhu Road, Purulia', 905845253744, 3, '6', '2021-08-14', 'B.Sc.', 'CHEM', 'fb023'),
(1000000003, 'Bankim Ch Das', '2002-03-13', 'bcd@gmail.com', 8617516781, 'Male', 'Ketika', 905845253116, 3, '6', '2024-06-15', 'B.Sc.', 'COSH', 'CY310'),
(1000000004, 'Ajit Kumar', '2003-02-13', 'ak@gmail.com', 9966554466, 'Male', 'DB ROAD, PURULIA', 905845253100, 1, '2', '2024-06-15', 'B.A.', 'BENG', 'Bf744'),
(1000000005, 'Ramesh Dutta', '2003-05-13', 'rms@gmail.com', 9966555444, 'Male', 'Nadiha, Purulia', 905845253745, 1, '1', '2024-06-15', 'B.A.', 'BENG', 'NE778'),
(1000000006, 'Rounak Dutta', '2003-02-11', 'rd@gmail.com', 9932568455, 'Male', 'Amdiha, Purulia', 905745253215, 3, '5', '2024-06-17', 'B.Sc.', 'MATH', 'Za664'),
(1000000007, 'Sarthak Goswami', '2004-06-19', 'sg@gmail.com', 9933555486, 'Male', 'Dulmi Purulia', 905845256549, 2, '4', '2024-07-01', 'B.Sc.', 'MATH', 'Gd260'),
(1000000008, 'Sanket Dutta', '2003-02-12', 'sb@gmail.com', 8992453567, 'Male', 'Amdiha, Purulia', 903845783266, 3, '6', '2021-08-13', 'B.Sc.', 'COSH', 'TO897'),
(1000000009, 'Rajat Mukherjee', '2005-04-13', 'rm@gmail.com', 9933568458, 'Male', 'DB ROAD, PURULIA', 901278453654, 2, '4', '2022-08-13', 'B.A.', 'ENG', 'Rk687'),
(1000000010, 'Nandita Mitra', '2003-02-12', 'nm@gmail.com', 8665667844, 'Female', 'Raghunathpur', 56786548327, 1, '2', '2023-08-13', 'B.A.', 'HIST', 'xG375'),
(1000000011, 'Nayanadhir Nandi', '2003-05-19', 'nayanadhirn@gmail.com', 9609470179, 'Male', 'Purulia', 111122223333, 3, '6', '2024-07-05', 'B.Sc.', 'COSH', 'ec940');

-- --------------------------------------------------------

--
-- Table structure for table `student_marks_details`
--

CREATE TABLE `student_marks_details` (
  `enrollment_id` bigint(20) NOT NULL,
  `dept_id` int(3) DEFAULT NULL,
  `semester` int(3) DEFAULT NULL,
  `paper_id_1` int(3) DEFAULT NULL,
  `paper1_marks` int(3) DEFAULT NULL,
  `paper_id_2` int(3) DEFAULT NULL,
  `paper2_marks` int(3) DEFAULT NULL,
  `paper_id_3` int(3) DEFAULT NULL,
  `paper3_marks` int(3) DEFAULT NULL,
  `marks_total_obtained` int(11) GENERATED ALWAYS AS (`paper1_marks` + `paper2_marks` + `paper3_marks`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_marks_details`
--

INSERT INTO `student_marks_details` (`enrollment_id`, `dept_id`, `semester`, `paper_id_1`, `paper1_marks`, `paper_id_2`, `paper2_marks`, `paper_id_3`, `paper3_marks`) VALUES
(1000000001, 1, 6, 16, 100, 17, 89, 18, 89),
(1000000002, 2, 6, 34, NULL, 35, NULL, 36, NULL),
(1000000003, 1, 6, 16, 89, 17, 98, 18, 69),
(1000000004, 4, 2, 58, NULL, 59, NULL, 60, NULL),
(1000000005, 4, 1, 55, 56, 56, 89, 57, 20),
(1000000006, 3, 5, 49, 89, 50, NULL, 51, NULL),
(1000000007, 3, 4, 46, NULL, 47, NULL, 48, NULL),
(1000000008, 1, 6, 16, 78, 17, 88, 18, 95),
(1000000009, 6, 4, 100, NULL, 101, NULL, 102, NULL),
(1000000010, 5, 2, 76, NULL, 77, NULL, 78, NULL),
(1000000011, 1, 6, 16, 89, 17, 99, 18, 81);

-- --------------------------------------------------------

--
-- Table structure for table `student_submissions`
--

CREATE TABLE `student_submissions` (
  `submission_id` int(11) NOT NULL,
  `enrollment_id` bigint(20) DEFAULT NULL,
  `paper_id_1` int(11) DEFAULT NULL,
  `paper_id_2` int(11) DEFAULT NULL,
  `paper_id_3` int(11) DEFAULT NULL,
  `file_path_1` varchar(255) NOT NULL,
  `file_path_2` varchar(255) NOT NULL,
  `file_path_3` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_submitted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_submissions`
--

INSERT INTO `student_submissions` (`submission_id`, `enrollment_id`, `paper_id_1`, `paper_id_2`, `paper_id_3`, `file_path_1`, `file_path_2`, `file_path_3`, `submission_date`, `is_submitted`) VALUES
(25, 1000000001, 16, 17, 18, 'uploads/1000000001_paper_1.pdf', 'uploads/1000000001_paper_2.pdf', 'uploads/1000000001_paper_3.pdf', '2024-06-12 07:20:16', 1),
(26, 1000000003, 16, 17, 18, 'uploads/1000000003_paper_1.pdf', 'uploads/1000000003_paper_2.pdf', 'uploads/1000000003_paper_3.pdf', '2024-06-15 06:27:27', 1),
(27, 1000000002, 34, 35, 36, 'uploads/1000000002_paper_1.png', 'uploads/1000000002_paper_2.png', 'uploads/1000000002_paper_3.png', '2024-06-15 06:49:21', 1),
(28, 1000000004, 58, 59, 60, 'uploads/1000000004_paper_1.png', 'uploads/1000000004_paper_2.png', 'uploads/1000000004_paper_3.png', '2024-06-15 06:57:29', 1),
(29, 1000000005, 55, 56, 57, 'uploads/1000000005_paper_1.png', 'uploads/1000000005_paper_2.png', 'uploads/1000000005_paper_3.png', '2024-06-15 07:06:14', 1),
(30, 1000000006, 49, 50, 51, 'uploads/1000000006_paper_1.pdf', 'uploads/1000000006_paper_2.pdf', 'uploads/1000000006_paper_3.pdf', '2024-06-17 09:29:51', 1),
(31, 1000000008, 16, 17, 18, 'uploads/1000000008_paper_1.pdf', 'uploads/1000000008_paper_2.pdf', 'uploads/1000000008_paper_3.pdf', '2024-07-02 03:00:58', 1),
(32, 1000000011, 16, 17, 18, 'uploads/1000000011_paper_1.pdf', 'uploads/1000000011_paper_2.pdf', 'uploads/1000000011_paper_3.pdf', '2024-07-05 07:28:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_details`
--

CREATE TABLE `teachers_details` (
  `teacher_id` int(10) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `teacher_password` varchar(20) NOT NULL,
  `joining_date` date NOT NULL,
  `dept_id` int(11) NOT NULL,
  `paper1_code` varchar(10) DEFAULT NULL,
  `paper2_code` varchar(10) DEFAULT NULL,
  `paper3_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_details`
--

INSERT INTO `teachers_details` (`teacher_id`, `full_name`, `phone_no`, `email`, `teacher_password`, `joining_date`, `dept_id`, `paper1_code`, `paper2_code`, `paper3_code`) VALUES
(6, 'Arindam Chatterjee', '9933666481', 'ac@gmail.com', 'ac123', '2024-06-12', 1, 'CSC101', 'CSC102', 'CSC103'),
(7, 'Subhajit Mukherjee', '9933666482', 'sm@gmail.com', 'sm123', '2024-06-12', 1, 'CSC201', 'CSC202', 'CSC203'),
(8, 'Anirban Ghosh', '9933666483', 'ag@gmail.com', 'ag123', '2024-06-12', 1, 'CSC301', 'CSC302', 'CSC303'),
(9, 'Sayantan Banerjee', '9933666484', 'sb@gmail.com', 'sb123', '2024-06-12', 1, 'CSC401', 'CSC402', 'CSC403'),
(10, 'Soumya Das', '9933666485', 'sd@gmail.com', 'sd123', '2024-06-12', 1, 'CSC501', 'CSC502', 'CSC503'),
(11, 'Ritam Basu', '9933666486', 'rb@gmail.com', 'rb123', '2024-06-12', 1, 'CSC601', 'CSC602', 'CSC603'),
(18, 'Vijay Kundu', '9883224547', 'vk@gmail.com', 'vk188', '2024-06-11', 2, 'CHE101', 'CHE102', 'CHE103'),
(19, 'Madhumita Ghosh', '9933666488', 'madhumita@gmail.com', 'mg123', '2024-06-12', 2, 'CHE201', 'CHE202', 'CHE203'),
(20, 'Rajendra Mehta', '9933666489', 'rajendra@gmail.com', 'rm123', '2024-06-12', 2, 'CHE301', 'CHE302', 'CHE303'),
(21, 'Anjali Gupta', '9933666490', 'anjali@gmail.com', 'ag123', '2024-06-12', 2, 'CHE401', 'CHE402', 'CHE403'),
(22, 'Nandini Mukherjee', '9933666491', 'nandini@gmail.com', 'nm123', '2024-06-12', 2, 'CHE501', 'CHE502', 'CHE503'),
(23, 'Kailash Gupta', '9933666492', 'kailash@gmail.com', 'kg123', '2024-06-12', 2, 'CHE601', 'CHE602', 'CHE603'),
(24, 'Sunita Mehta', '9933666493', 'sunita@gmail.com', 'sm123', '2024-06-12', 3, 'MAT101', 'MAT102', 'MAT103'),
(25, 'Suresh Sharma', '9933666494', 'suresh@gmail.com', 'ss123', '2024-06-12', 3, 'MAT201', 'MAT202', 'MAT203'),
(26, 'Priyanka Banerjee', '9933666495', 'priyanka@gmail.com', 'pb123', '2024-06-12', 3, 'MAT301', 'MAT302', 'MAT303'),
(27, 'Kavita Agarwal', '9933666496', 'kavita@gmail.com', 'ka123', '2024-06-12', 3, 'MAT401', 'MAT402', 'MAT403'),
(28, 'Anupam Ghosh', '9933666497', 'anupam@gmail.com', 'ag123', '2024-06-12', 3, 'MAT501', 'MAT502', 'MAT503'),
(29, 'Ajay Kundu', '9933666497', 'ak@gmail.com', 'ak123', '2024-06-12', 3, 'MAT601', 'MAT602', 'MAT603'),
(30, 'Sharmistha Das', '9933666498', 'sharmistha@gmail.com', 'sd123', '2024-06-12', 4, 'BENG101', 'BENG102', 'BENG103'),
(31, 'Anindita Chatterjee', '9933666499', 'anindita@gmail.com', 'ac123', '2024-06-12', 4, 'BENG201', 'BENG202', 'BENG203'),
(32, 'Rajesh Sen', '9933666500', 'rajesh@gmail.com', 'rs123', '2024-06-12', 4, 'BENG301', 'BENG302', 'BENG303'),
(33, 'Arpita Saha', '9933666501', 'arpita@gmail.com', 'as123', '2024-06-12', 4, 'BENG401', 'BENG402', 'BENG403'),
(34, 'Kailash Choudhary', '9933666502', 'kailash@gmail.com', 'kc123', '2024-06-12', 4, 'BENG501', 'BENG502', 'BENG503'),
(35, 'Renuka Sharma', '9933666503', 'renuka@gmail.com', 'rs123', '2024-06-12', 4, 'BENG601', 'BENG602', 'BENG603'),
(36, 'Manoj Kumar', '9933666504', 'manoj@gmail.com', 'mjhist', '2024-06-12', 5, 'HIST101', 'HIST102', 'HIST103'),
(37, 'Geeta Sharma', '9933666505', 'geeta@gmail.com', 'ghhist', '2024-06-12', 5, 'HIST201', 'HIST202', 'HIST203'),
(38, 'Amit Singh', '9933666506', 'amit@gmail.com', 'amhist', '2024-06-12', 5, 'HIST301', 'HIST302', 'HIST303'),
(39, 'Rashmi Patel', '9933666507', 'rashmi@gmail.com', 'rlhist', '2024-06-12', 5, 'HIST401', 'HIST402', 'HIST403'),
(40, 'Prakash Verma', '9933666508', 'prakash@gmail.com', 'plhist', '2024-06-12', 5, 'HIST501', 'HIST502', 'HIST503'),
(41, 'Renuka Sharma', '9933666503', 'renuka@gmail.com', 'rhhist', '2024-06-12', 5, 'HIST601', 'HIST602', 'HIST603'),
(42, 'Samantha Jones', '9933666509', 'samantha@gmail.com', 'seseng', '2024-06-12', 6, 'ENG101', 'ENG102', 'ENG103'),
(43, 'David Smith', '9933666510', 'david@gmail.com', 'dtdeng', '2024-06-12', 6, 'ENG201', 'ENG202', 'ENG203'),
(44, 'Emily Brown', '9933666511', 'emily@gmail.com', 'eybeng', '2024-06-12', 6, 'ENG301', 'ENG302', 'ENG303'),
(45, 'Christopher Wilson', '9933666512', 'christopher@gmail.com', 'crweng', '2024-06-12', 6, 'ENG401', 'ENG402', 'ENG403'),
(46, 'Olivia Taylor', '9933666513', 'olivia@gmail.com', 'oaeeng', '2024-06-12', 6, 'ENG501', 'ENG502', 'ENG503'),
(47, 'Eliza Patel', '9933666514', 'eliza@gmail.com', 'eaeleng', '2024-06-12', 6, 'ENG601', 'ENG602', 'ENG603');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `papers_of_departments`
--
ALTER TABLE `papers_of_departments`
  ADD PRIMARY KEY (`paper_id`),
  ADD UNIQUE KEY `unique_paper_code` (`paper_code`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`enrollment_id`,`aadhar_no`);

--
-- Indexes for table `student_marks_details`
--
ALTER TABLE `student_marks_details`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `fk_dept_id` (`dept_id`);

--
-- Indexes for table `student_submissions`
--
ALTER TABLE `student_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `enrollment_id` (`enrollment_id`),
  ADD KEY `paper_id_1` (`paper_id_1`),
  ADD KEY `paper_id_2` (`paper_id_2`),
  ADD KEY `paper_id_3` (`paper_id_3`);

--
-- Indexes for table `teachers_details`
--
ALTER TABLE `teachers_details`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `teachers_details_ibfk_2` (`paper1_code`),
  ADD KEY `teachers_details_ibfk_3` (`paper2_code`),
  ADD KEY `teachers_details_ibfk_4` (`paper3_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `papers_of_departments`
--
ALTER TABLE `papers_of_departments`
  MODIFY `paper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `student_submissions`
--
ALTER TABLE `student_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `teachers_details`
--
ALTER TABLE `teachers_details`
  MODIFY `teacher_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `papers_of_departments`
--
ALTER TABLE `papers_of_departments`
  ADD CONSTRAINT `papers_of_departments_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`);

--
-- Constraints for table `student_marks_details`
--
ALTER TABLE `student_marks_details`
  ADD CONSTRAINT `fk_dept_id` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`),
  ADD CONSTRAINT `student_marks_details_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `student_details` (`enrollment_id`);

--
-- Constraints for table `student_submissions`
--
ALTER TABLE `student_submissions`
  ADD CONSTRAINT `student_submissions_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `student_details` (`enrollment_id`),
  ADD CONSTRAINT `student_submissions_ibfk_2` FOREIGN KEY (`paper_id_1`) REFERENCES `papers_of_departments` (`paper_id`),
  ADD CONSTRAINT `student_submissions_ibfk_3` FOREIGN KEY (`paper_id_2`) REFERENCES `papers_of_departments` (`paper_id`),
  ADD CONSTRAINT `student_submissions_ibfk_4` FOREIGN KEY (`paper_id_3`) REFERENCES `papers_of_departments` (`paper_id`);

--
-- Constraints for table `teachers_details`
--
ALTER TABLE `teachers_details`
  ADD CONSTRAINT `teachers_details_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`),
  ADD CONSTRAINT `teachers_details_ibfk_2` FOREIGN KEY (`paper1_code`) REFERENCES `papers_of_departments` (`paper_code`),
  ADD CONSTRAINT `teachers_details_ibfk_3` FOREIGN KEY (`paper2_code`) REFERENCES `papers_of_departments` (`paper_code`),
  ADD CONSTRAINT `teachers_details_ibfk_4` FOREIGN KEY (`paper3_code`) REFERENCES `papers_of_departments` (`paper_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
