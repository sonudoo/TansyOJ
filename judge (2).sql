-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2017 at 01:18 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `judge`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `username` varchar(20) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `username` varchar(20) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `statement` varchar(10000) DEFAULT NULL,
  `sampleinput` varchar(10000) DEFAULT NULL,
  `sampleoutput` varchar(10000) DEFAULT NULL,
  `users_solved` int(11) NOT NULL,
  `time` double NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `code`, `description`, `statement`, `sampleinput`, `sampleoutput`, `users_solved`, `time`, `level`) VALUES
(1, 'BSEARCH', '[Query processing]. Search if a number exists in the array.', 'You are given an array of \'N\' numbers and \'Q\' queries. Each queries contains a single number which you need to tell whether it exists in the given array or not. Print "yes" (without quotes) if the number exists in the array and "no" (without quotes) otherwise.<br><br>\nThe first line of input contains \'N\'.<br>\nThe second line contains N space-separated integers which are the elements of the array. <br>\nThe third line contains \'Q\', i.e the number of queries you need to answer.<br>\nThen comes Q lines each containing a single integer that needs to be searched.<br><br>\nAll the numbers will fit in 32-bit integers. Don\'t forget to print a newline (\'\\n\') character after each input.\n<br><br>\n<b>Hint:</b> A normal solution would be to scan the entire array for each query. However such solution is slow and would easily timeout. Can you find a faster technique to answer the queries using fewer number of iterations? Think about sorting the array. Use sort() library function.', '5<br>\r\n1 2 3 4 5<br>\r\n5<br>\r\n1<br>\r\n4<br>\r\n7<br>\r\n8<br>\r\n1<br>', 'yes<br>\r\nyes<br>\r\nno<br>\r\nno<br>\r\nyes<br><br>', 3, 0.07, 3),
(2, 'CHARPAT1', 'Print the character pattern 1.', 'You are given a single integer in the input which represents the height of the pattern. Print a pattern as shown in the sample I/O.<br><br>', '5', '<pre>\nX....\nXX...\nXXX..\nXXXX.\nXXXXX\n</pre>', 7, 0.5, 1),
(3, 'COUNTONE', 'Count the number of ones in the binary representation of the input number.', 'Count the number of ones in the binary representation of the input number. The input number will fit in 64-bit integer.', '3', '2', 3, 0.5, 2),
(4, 'FIBONACCI', 'Calculate the Nth Fibonacci number.', 'Given a single integer \'N\' in the input, Calculate and print the Nth Fibonacci number to the output. The value of N is such that the result will fit in 32-bit integers. Don\'t print any other character except for the resultant number.<br><br>\r\n<b>Fibonacci number:</b> The first Fibonacci number is 1. The second Fibonacci number is also 1. The recurrence relation is given as:<br><br>\r\n<center><b>Fib(n) = Fib(n-1) + Fib(n-2)</b></center> ', '5', '5', 4, 1, 2),
(5, 'GCD', 'Calculate the GCD of two numbers.', 'You are given two numbers which fit in 32-bit signed integer. Output a single number which is the greatest common divisor (GCD) of the number.\r\n<br />\r\n<br />\r\n<b>GCD:</b> It is the largest positive number which divides both the given numbers.', '10 16', '2', 9, 0.1, 2),
(6, 'LUE1', 'Life, Universe and Everything 1', 'Read a single number from input and print it to the output. Check the sample I/O for clarity. The number will fit in 32-bit integer data type. Don\'t print any other character except for the number.', '89', '89', 84, 0.1, 0),
(7, 'MUL2', 'Calculate the product of two numbers.', 'Given two numbers on two lines, calculate their product and print it to output.<br><br> The first number doesn\'t fit even in 64-bit integer. However the second number does fit in 32-bit integers. <br><br>Don\'t print any character other than the product.<br><br>\r\n<b>Hint:</b> Take the first number as character array and perform manual multiplication.', '10000000000000000000000000<br>\r\n100000', '1000000000000000000000000000000', 0, 1, 3),
(8, 'NCR', 'Calculate the value of combination.', 'You are given two numbers N and R. You have to calculate the value of <b><sup>n</sup>C<sub>r</sub></b>. The result will for in 64-bit integer. Don\'t print any other character except for the result. <br><br>\r\n<b>Hint</b>: Why don\'t you try the high school recursive formula?<br><br>\r\n<center><b><sup>n</sup>C<sub>r</sub> = <sup>n-1</sup>C<sub>r-1</sub> + <sup>n</sup>C<sub>r-1</sub></b></center>', '16 20', '0', 4, 1, 2),
(9, 'PRIME1', 'Process T test cases and check if a number is prime.', 'Process \'T\' test cases. Each test case will contain a single integer on a separate line. Check if the number is prime or not. Output "yes" (without quotes) if it is a prime and "no" (without quotes) otherwise. <br><br>\r\nThe output of each test case must be on a separate line. All input numbers are less than 1000 and are positive. <br><br>\r\n<b>Prime:</b> A number X is said to be prime if it only has 1 and X as its factors.', '5<br>\r\n1<br>\r\n2<br>\r\n3<br>\r\n4<br>\r\n5<br>', 'no<br>\r\nyes<br>\r\nyes<br>\r\nno<br>\r\nyes<br><br>', 2, 1, 1),
(10, 'PRIME2', 'Process T test cases and check if a number is prime.', 'Process \'T\' test cases. Each test case will contain a single integer on a separate line. Check if the number is prime or not. Output "yes" (without quotes) if it is a prime and "no" (without quotes) otherwise. <br><br>\r\nThe output of each test case must be on a separate line. All input numbers are less than 1000000 and are positive. <br><br>\r\n<b>Prime:</b> A number X is said to be prime if it only has 1 and X as its factors.\r\n<br><br>\r\n<b>Hint:</b> A naive solution is to iterate through the square root of the element to check if it is prime. However it is slow. Have you heard of something called <i>Sieve of Eratosthenes</i>?', '5<br>\r\n1<br>\r\n2<br>\r\n3<br>\r\n4<br>\r\n5<br>', 'no<br>\r\nyes<br>\r\nyes<br>\r\nno<br>\r\nyes<br><br>', 1, 0.008, 3),
(11, 'QPROCESS', '[Important] Introduction to test case processing.', 'It is now a good time to introduce you all to queries and test case processing. Often it is required that you need to run the program not for single but for multiple test cases. One way of doing this is to run the program again and again and get the output for each case. However this can be, at times, tedious! So Online Juries (like LOADRA,AURORA,SPOJ etc.) often process multiple test cases in a single input.<br><br>\r\nIn this question, the first integer is \'T\' which represents the number of test cases your program needs to process. Each test case contains two space separated integers. Your task is to print \'T\' lines each containing a integer which represents the sum of the two numbers in the input cases. Check the sample I/O for clarity.<br><br>\r\nAll the numbers will fit in 64-bit integers. Don\'t forget to print the newline (\'\\n\') character after each integer output.', '3<br>\r\n1 2<br>\r\n3 4<br>\r\n5 6<br>', '3<br>\r\n7<br>\r\n11<br><br>', 0, 0.5, 1),
(12, 'SORT1', 'Sort the given numbers in increasing order.', 'You are given an array of \'N\' numbers. Sort and print it in increasing order.\r\n<br><br>\r\nThe first line contains a single integer \'N\' which represents the number of elements in the array. There will be no more than 100 elements.<br>The second line contains \'N\' space separated integers which needs to be sorted in increasing order. <br><br>\r\nAll numbers will fit in 32-bit integers. Don\'t print \'\\n\' after the result.<br><br>\r\n<b>Hint:</b> Find the minimum element. This element will be the first element of the result array. Remove this element. Again find the minimum element. This element will be the second element in the result array. Keep repeating unless all numbers are removed. This technique is also known as <i>Selection sort</i>.', '5<br>\r\n1 4 2 3 5', '1 2 3 4 5 ', 2, 0.5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `problemcode` varchar(10) DEFAULT NULL,
  `lang` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `error` varchar(10000) DEFAULT NULL,
  `code` varchar(50000) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `rollno` varchar(20) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `phno` varchar(10) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
