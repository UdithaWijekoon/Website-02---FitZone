-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 09:49 AM
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
-- Database: `fitzone_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration_accounts`
--

CREATE TABLE `administration_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administration_accounts`
--

INSERT INTO `administration_accounts` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(4, 'admin_1', 'admin_1@gmail.com', '$2y$10$4HnqyKvyvDMCsO3MMub8Qu2Mo5Wrg3HA5rkZRdEdhkw72d5/PAbya', 'admin', '2024-11-04 04:29:28'),
(6, 'staff_1', 'staff_1@gmail.com', '$2y$10$1LxfgWNVKRjg2YajK6JAjO1DniJFLfZ8PkX5OXq.63J0pRP7AT9k.', 'staff', '2024-11-04 04:42:45'),
(8, 'admin_2', 'admin_2@gmail.com', '$2y$10$H1TfJQUJ5WUfDJASgvDoGuFJmgSmixn/Soeq6nRmxz2T0kYm37zK2', 'admin', '2024-11-04 09:17:09'),
(10, 'staff_2', 'staff_2@gmail.com', '$2y$10$GI3VSKreHGsrTo.DDISEu.b5ccqUcJAiThvtfYHsHDuoxWXyOnLTq', 'staff', '2024-11-05 03:25:18'),
(11, 'staff_3', 'staff_3@gmail.com', '$2y$10$uzwEZoP6Xssft4xATiB2EeNegIrV11wBNNVMyaKY8ywfFPgggRyje', 'staff', '2024-11-05 03:25:40'),
(12, 'staff_4', 'staff_4@gmail.com', '$2y$10$EHoG79GBQYSpJ0Z1ZF6JpulJGn8XEEA35VFRTCFZHEnXVsoTy271q', 'staff', '2024-11-05 03:25:51'),
(13, 'staff_5', 'staff_5@gmail.com', '$2y$10$lgECNqMXyKaI5XoRCJwrg.F3RE.tQpO5E6zwz/NZUKnhE43RlXFLG', 'staff', '2024-11-06 07:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `customer_id`, `trainer_id`, `appointment_date`, `appointment_time`, `status`, `created_at`) VALUES
(1, 1, 1, '2024-12-11', '11:00:00', 'Confirmed', '2024-11-04 03:19:20'),
(2, 1, 10, '2024-12-11', '08:00:00', 'Pending', '2024-11-04 03:20:11'),
(9, 1, 2, '2024-12-24', '09:00:00', 'Cancelled', '2024-11-05 05:16:43'),
(10, 2, 6, '2024-12-24', '10:00:00', 'Pending', '2024-11-05 05:17:16'),
(11, 2, 9, '2024-12-22', '14:00:00', 'Confirmed', '2024-11-05 05:17:36'),
(12, 1, 1, '2025-02-24', '08:00:00', 'Pending', '2024-11-06 06:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `image_url`, `description`, `content`, `is_featured`, `created_at`) VALUES
(13, '5 Best Exercises for Cardio Health', '../images/blog_1.jpg', 'Discover top exercises to improve your cardiovascular health.', 'When it comes to maintaining a healthy heart and improving cardiovascular health, cardio exercises are essential. Here are five of the best exercises that can get your heart pumping and help you build endurance:\r\n\r\n1. **Running or Jogging**: Running is one of the most effective ways to improve cardiovascular fitness. It strengthens the heart, boosts metabolism, and burns calories. Even jogging at a moderate pace for 20-30 minutes can have long-lasting heart health benefits.\r\n\r\n2. **Cycling**: Whether you cycle outdoors or on a stationary bike, cycling is a low-impact exercise that promotes heart health. It’s also easy on the joints, making it ideal for people of all fitness levels. Try cycling for at least 30 minutes three times a week for optimal results.\r\n\r\n3. **Swimming**: Swimming is a full-body workout that increases heart rate while putting minimal stress on the body. It’s an ideal workout for individuals with joint pain or arthritis and can be as intense or as relaxing as you want it to be.\r\n\r\n4. **Rowing**: Rowing engages both the upper and lower body, providing an intense workout that enhances cardiovascular health. It’s a great choice for building endurance and muscle strength simultaneously.\r\n\r\n5. **Jump Rope**: Don’t underestimate the power of jump rope! It’s a quick way to raise your heart rate, improve coordination, and burn calories. Just 10 minutes of jump rope can provide a high-intensity cardio workout that boosts your heart health.\r\n\r\nIncorporating these exercises into your weekly routine can help improve cardiovascular health, increase stamina, and support a healthier heart.\r\n', 1, '2024-11-05 05:54:47'),
(14, 'Healthy Recipes for Busy People', '../images/blog_2.jpg', 'Easy and quick recipes to maintain a healthy diet.', 'Eating healthy can be a challenge, especially when you’re busy. Here are three quick, nutritious recipes to keep you on track even on your busiest days:\r\n\r\n1. **Overnight Oats**: Start your day with a nutritious breakfast that requires minimal prep time.\r\n   - **Ingredients**: 1/2 cup rolled oats, 1/2 cup almond milk, 1 tbsp chia seeds, 1/2 banana (sliced), and a handful of berries.\r\n   - **Instructions**: Combine oats, milk, and chia seeds in a jar, stir well, and refrigerate overnight. In the morning, top with banana slices and berries for a delicious, energy-boosting meal.\r\n\r\n2. **Avocado and Chickpea Salad Wrap**: This lunch option is packed with protein and healthy fats.\r\n   - **Ingredients**: 1 ripe avocado, 1/2 cup canned chickpeas, 1 tbsp lemon juice, a pinch of salt and pepper, and whole-wheat wraps.\r\n   - **Instructions**: Mash the avocado and mix with chickpeas, lemon juice, salt, and pepper. Spread on a whole-wheat wrap, add your favorite veggies, and roll up for a tasty, filling lunch.\r\n\r\n3. **One-Pan Baked Salmon with Vegetables**: This dinner is easy to make and requires little clean-up.\r\n   - **Ingredients**: 1 salmon fillet, 1 cup broccoli florets, 1/2 cup cherry tomatoes, 1 tbsp olive oil, salt, pepper, and lemon wedges.\r\n   - **Instructions**: Place salmon and vegetables on a baking sheet, drizzle with olive oil, and season with salt and pepper. Bake at 400°F (200°C) for 15-20 minutes, or until the salmon is cooked through. Serve with lemon wedges.\r\n\r\nThese recipes provide quick, nutritious options for every meal and are perfect for anyone with a packed schedule.\r\n', 0, '2024-11-05 05:56:02'),
(15, 'Top Benefits of Strength Training', '../images/blog_3.jpg', 'Learn the amazing benefits of incorporating strength training into your routine.', 'Strength training isn’t just for bodybuilders. It has numerous health benefits for everyone, regardless of age or fitness level. Here are some top benefits of strength training:\r\n\r\n1. **Improved Muscle Mass**: Regular strength training helps build and maintain muscle mass, which is essential as we age. It can prevent muscle loss and keep you strong, active, and independent.\r\n\r\n2. **Enhanced Metabolism**: Building muscle also boosts your metabolism, as muscles burn more calories than fat even at rest. This makes strength training an effective component of weight management.\r\n\r\n3. **Stronger Bones**: Weight-bearing exercises like lifting weights increase bone density, reducing the risk of osteoporosis and fractures, especially in older adults.\r\n\r\n4. **Better Joint Flexibility and Balance**: Strength training strengthens muscles around your joints, which can enhance flexibility and stability, preventing injuries and improving overall balance.\r\n\r\n5. **Mental Health Benefits**: Exercise releases endorphins, which help improve mood and reduce anxiety. Strength training, in particular, has been shown to reduce symptoms of depression and increase self-confidence.\r\n\r\nWhether it’s lifting weights, using resistance bands, or doing body weight exercises, incorporating strength training into your weekly routine can lead to a healthier, stronger, and more confident you.\r\n', 1, '2024-11-05 05:56:30'),
(16, 'Yoga for Mind and Body', '../images/blog_4.jpg', 'Explore the physical and mental benefits of yoga practice.', 'Yoga is an ancient practice that benefits both the body and the mind. Here’s a closer look at why yoga should be part of your wellness routine:\r\n\r\n1. **Improves Flexibility and Strength**: Yoga involves a range of postures that increase flexibility and strength over time. Whether you’re new to exercise or an athlete, yoga can help improve your range of motion and muscle tone.\r\n\r\n2. **Reduces Stress and Anxiety**: Yoga emphasizes mindful breathing and meditation, which can help calm the nervous system. Studies show that practicing yoga regularly reduces cortisol levels, the body’s primary stress hormone.\r\n\r\n3. **Boosts Mental Clarity and Focus**: The meditative aspect of yoga enhances mental focus and clarity. Regular practice has been shown to improve cognitive function, memory, and concentration.\r\n\r\n4. **Enhances Balance and Coordination**: Yoga postures require stability and focus, which help improve balance and body coordination, reducing the risk of falls and injuries.\r\n\r\n5. **Promotes Better Sleep**: Yoga helps relax the body and mind, leading to improved sleep quality. Many people find that gentle evening yoga helps them unwind and sleep better.\r\n\r\nYoga is a holistic approach to physical and mental well-being. From gentle restorative yoga to vigorous vinyasa flows, there’s a style that suits everyone, and the benefits are transformative.\r\n', 0, '2024-11-05 05:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('confirmed','pending','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `class_id`, `schedule_id`, `booking_date`, `status`) VALUES
(10, 1, 7, 7, '2024-11-05 03:57:18', 'confirmed'),
(11, 1, 8, 11, '2024-11-05 04:15:31', 'confirmed'),
(12, 1, 9, 13, '2024-11-05 04:17:25', 'canceled'),
(13, 2, 9, 14, '2024-11-05 04:23:22', 'pending'),
(15, 1, 7, 9, '2024-11-06 06:30:32', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `trainer` varchar(100) DEFAULT NULL,
  `schedule` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `description`, `trainer`, `schedule`, `image_path`) VALUES
(7, 'Cardio Blast', 'A high-energy class focused on improving cardiovascular fitness and burning calories.', 'Emma Johnson, James Wilson, Ava Hernandez', 'Mon, Wed, Fri - 6:00 AM to 7:00 AM', '../images/672993bc250e3_cardio_blast.jpg'),
(8, 'Strength Training', 'Build muscle and increase strength with a focus on resistance training and form.', 'John Smith, Sophia Davis, James Wilson, Ava Hernandez', 'Tue, Thu - 5:30 PM to 6:30 PM', '../images/672994cdeaba4_strength_training.jpg'),
(9, 'Yoga Flow', 'A calming class to improve flexibility, balance, and mental relaxation.', 'Michael Brown, Olivia Garcia, Mia Robinson', 'Sat, Sun - 7:30 PM to 8:30 PM', '../images/67299535e6928_yoga_flow.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `trainer` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `seats_available` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `class_id`, `trainer`, `date`, `time`, `duration`, `location`, `seats_available`, `description`, `created_at`) VALUES
(1, 1, 'John Doe', '2024-11-05', '09:00:00', 60, 'Studio A', 20, 'Cardio Blast session led by John', '2024-11-03 15:40:13'),
(2, 2, 'Jane Smith', '2024-11-06', '11:00:00', 45, 'Studio B', 15, 'Strength training focused on core strength', '2024-11-03 15:40:13'),
(3, 3, 'Emily Brown', '2024-11-07', '08:00:00', 90, 'Yoga Room', 10, 'Relaxing yoga session to start your day', '2024-11-03 15:40:13'),
(7, 7, 'Emma Johnson', '2024-02-11', '08:00:00', 90, 'Room A', 20, 'High-energy cardio workout to boost endurance, burn calories, and improve heart health. Suitable for all fitness levels.', '2024-11-05 03:57:06'),
(8, 7, 'James Wilson', '2024-12-20', '09:00:00', 60, 'Room B', 15, 'High-energy cardio workout to boost endurance, burn calories, and improve heart health. Suitable for all fitness levels.', '2024-11-05 03:59:00'),
(9, 7, 'Ava Hernandez', '2024-12-21', '10:00:00', 45, 'Room C', 25, 'High-energy cardio workout to boost endurance, burn calories, and improve heart health. Suitable for all fitness levels.', '2024-11-05 04:00:08'),
(10, 8, 'John Smith', '2024-12-24', '09:00:00', 60, 'Studio 1', 15, 'Strength training session focusing on core stability, muscle endurance, and strength building. Ideal for anyone looking to tone and build muscle.', '2024-11-05 04:01:19'),
(11, 8, 'Sophia Davis', '2024-12-25', '10:00:00', 75, 'Studio 2', 20, 'Strength training session focusing on core stability, muscle endurance, and strength building. Ideal for anyone looking to tone and build muscle.', '2024-11-05 04:02:06'),
(12, 8, 'Ava Hernandez', '2024-12-28', '08:00:00', 60, 'Studio 3', 15, 'Strength training session focusing on core stability, muscle endurance, and strength building. Ideal for anyone looking to tone and build muscle.', '2024-11-05 04:02:55'),
(13, 9, 'Michael Brown', '2024-12-27', '09:00:00', 60, 'Main Hall', 50, 'Invigorating yoga practice focused on flexibility, strength, and balance. Emphasis on mindful breathing and relaxation techniques. Suitable for all.', '2024-11-05 04:08:50'),
(14, 9, 'Mia Robinson', '2024-12-29', '10:00:00', 120, 'Main Hall', 50, 'Invigorating yoga practice focused on flexibility, strength, and balance. Emphasis on mindful breathing and relaxation techniques. Suitable for all.', '2024-11-05 04:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Test 1', 'testing@gmail.com', 'test_1', 'testing', '2024-11-03 13:21:04'),
(6, 'Customer_1', 'customer_1@gmail.com', 'Inquiry About Membership Plans', 'Hello, I would like more details on the different membership plans you offer, including the benefits and pricing. Could you please provide information on any discounts for long-term memberships?', '2024-11-05 05:19:40'),
(7, 'Customer_1', 'customer_1@gmail.com', 'Personal Training Availability', 'Hi, I’m interested in starting personal training sessions. Could you let me know about the availability of trainers and the costs associated with one-on-one sessions?', '2024-11-05 05:19:58'),
(8, 'Customer_2', 'customer_2@gmail.com', 'Feedback on Class Schedule', 'Hello, I’d like to share some feedback about the current class schedule. It would be great if there were more evening slots for yoga and cardio sessions. This would make it easier for working members to attend.', '2024-11-05 05:20:27'),
(9, 'Guest', 'guest@gmail.com', 'Questions About Group Classes', 'Hi, I’m interested in joining group classes but am unsure about how they work. Could you provide more information on what’s included, the duration of each class, and how to sign up?', '2024-11-05 05:20:52'),
(10, 'Customer_1', 'customer_1@gmail.com', 'Gym Equipment Inquiry', 'Hello, I’ve noticed some new equipment in the gym. Could you provide instructions or demonstrations on how to use the latest machines effectively and safely?', '2024-11-05 05:21:13'),
(11, 'Customer_3', 'customer_3@gmail.com', 'Test', 'testing', '2024-11-06 06:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'customer_1', 'customer_1@gmail.com', '$2y$10$bngNSZTEUngrIqnN1GzLb.jY71q2XfoOqr7Z7seyOsokCUBsO2FeG', '2024-11-03 14:42:37'),
(2, 'customer_2', 'customer_2@gmail.com', '$2y$10$h5W4tOFVuVz5Yi4O82wQ9.JTog.YiQ3BF4yMggQp6foSfHVQWB3ae', '2024-11-03 18:05:13'),
(9, 'customer_3', 'customer_3@gmail.com', '$2y$10$lWLCLQz1mS8RAXMVuIzspO92a92d7P4O7v.EDWEkP/hVIHr.hlXPq', '2024-11-05 03:27:05'),
(10, 'customer_4', 'customer_4@gmail.com', '$2y$10$Z1lARz1fk.Ms7N4kOcN11uhRZ//vSlgmf7ZJkT/3QJe6JDIvDhUBu', '2024-11-05 03:27:21'),
(11, 'customer_5', 'customer_5@gmail.com', '$2y$10$NbuSd96VjkGZO5XDVbFD2u5jzkktsG9UQDOS7DpgRVICBXYRoJVHO', '2024-11-05 03:27:36'),
(12, 'customer_6', 'customer_6@gmail.com', '$2y$10$XGolvSYSXKW581Y4bLTHMukaH6vtsTg4IIuvd7WDoK/WU7Lxn9KYG', '2024-11-05 03:27:49'),
(13, 'customer_7', 'customer_7@gmail.com', '$2y$10$SRW/GG9.UgYrV2c8EE79b.i31Kg6vjkVmNVQ1lPHcpGO2XfFdzyG6', '2024-11-06 06:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `guest_passes` int(11) DEFAULT 0,
  `class_access` varchar(100) DEFAULT NULL,
  `health_assessment` tinyint(1) DEFAULT 0,
  `personal_training_sessions` int(11) DEFAULT 0,
  `nutrition_counseling` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `plan_name`, `description`, `price`, `guest_passes`, `class_access`, `health_assessment`, `personal_training_sessions`, `nutrition_counseling`, `is_active`, `created_at`) VALUES
(1, 'Basic', 'Access to gym equipment and cardio classes', 29.00, 1, 'Cardio Only', 0, 0, 0, 1, '2024-11-03 12:13:27'),
(2, 'Premium', 'All Basic benefits plus strength training classes', 49.00, 2, 'All Classes', 1, 0, 0, 1, '2024-11-03 12:13:27'),
(3, 'VIP', 'All Premium benefits plus personal training sessions', 79.00, 5, 'All Classes', 1, 1, 1, 1, '2024-11-03 12:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `expertise` text NOT NULL,
  `bio` text DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `session_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `expertise`, `bio`, `availability`, `photo_path`, `session_price`) VALUES
(1, 'Nuwan Perera', 'Strength Training', '', 'Mon, Wed, Fri: 9 AM - 5 PM', '../images/trainers/john_smith.jpg', 50.00),
(2, 'Shamila Liyanarachchi', 'Cardio', '', 'Tue, Thu: 10 AM - 4 PM', '../images/trainers/emma_johnson.jpg', 45.00),
(3, 'Dinesh Bandara', 'Flexibility', '', 'Mon - Fri: 11 AM - 7 PM', '../images/trainers/michael_brown.jpg', 60.00),
(4, 'Anushka Ratnayake', 'Strength Training', '', 'Sat, Sun: 8 AM - 2 PM', '../images/trainers/sophia_davis.jpg', 55.00),
(5, 'Asela Fernando', 'Cardio & Strength Training', '', 'Mon - Fri: 9 AM - 6 PM', '../images/trainers/james_wilson.jpg', 70.00),
(6, 'Manori De Silva', 'Yoga & Flexibility', '', 'Wed, Fri: 10 AM - 5 PM', '../images/trainers/olivia_garcia.jpg', 65.00),
(7, 'Ruwan Silva', 'High-Intensity Interval Training', '', 'Tue, Thu: 7 AM - 3 PM', '../images/trainers/liam_martinez.jpg', 55.00),
(8, 'Shanika Gunasekara', 'Strength Training & Cardio', '', 'Mon, Wed, Fri: 12 PM - 8 PM', '../images/trainers/ava_hernandez.jpg', 60.00),
(9, 'Lakshan Jayasuriya', 'Weight Loss & Nutrition', '', 'Mon - Thu: 8 AM - 4 PM', '../images/trainers/ethan_miller.jpg', 75.00),
(10, 'Tharushi Wijesinghe', 'Pilates & Flexibility', '', 'Mon - Fri: 10 AM - 6 PM', '../images/trainers/mia_robinson.jpg', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE `user_memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_memberships`
--

INSERT INTO `user_memberships` (`id`, `user_id`, `plan_id`, `start_date`, `status`) VALUES
(1, 1, 3, '2024-11-03 15:03:05', 'pending'),
(2, 1, 3, '2024-11-03 15:05:48', 'inactive'),
(3, 1, 2, '2024-11-03 16:45:36', 'active'),
(4, 1, 3, '2024-11-03 17:31:21', 'inactive'),
(5, 2, 2, '2024-11-03 18:05:30', 'active'),
(10, 2, 1, '2024-11-05 05:22:29', 'pending'),
(11, 1, 2, '2024-11-06 06:32:44', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration_accounts`
--
ALTER TABLE `administration_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administration_accounts`
--
ALTER TABLE `administration_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_memberships`
--
ALTER TABLE `user_memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `class_schedule` (`id`);

--
-- Constraints for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD CONSTRAINT `user_memberships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `user_memberships_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_plans` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
