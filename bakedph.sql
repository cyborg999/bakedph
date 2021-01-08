-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2021 at 02:07 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakedph`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `productid` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `storeid` int(11) NOT NULL,
  `date_produced` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `cost`, `productid`, `date_added`, `storeid`, `date_produced`) VALUES
(9, 'ASD', '1', 11, '2020-12-08 06:49:42', 21, '0111-11-11'),
(10, 'ASD2', '1', 11, '2020-12-08 06:49:47', 21, '0234-11-11'),
(11, 'labor', '120', 16, '2021-01-08 07:18:57', 21, '2021-01-08'),
(12, 'transporation', '120', 16, '2021-01-08 07:19:05', 21, '2021-01-08'),
(13, 'desc', '345', 0, '2021-01-08 09:03:55', 21, '2021-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `materialid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `materialid`, `qty`, `productid`, `date_created`) VALUES
(67, 11, 1, 11, '2021-01-03 02:28:38'),
(68, 12, 20, 11, '2021-01-03 02:28:44'),
(70, 12, 1, 13, '2021-01-03 04:03:31'),
(71, 11, 1, 15, '2021-01-07 00:34:23'),
(72, 11, 12, 16, '2021-01-08 07:19:14'),
(74, 13, 1, 16, '2021-01-08 09:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `material_inventory`
--

CREATE TABLE `material_inventory` (
  `id` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL,
  `expiry_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `material_inventory`
--

INSERT INTO `material_inventory` (`id`, `storeid`, `name`, `qty`, `price`, `expiry_date`, `date_created`, `unit`) VALUES
(11, 21, 'Flour', 2318, 50, '1111-11-11', '2021-01-03 01:17:38', NULL),
(12, 21, 'Egg', 0, 8, '0111-11-11', '2021-01-03 02:27:33', NULL),
(13, 21, 'Sugar', 94, 40, '0000-00-00', '2021-01-03 02:27:43', NULL),
(14, 21, 'asdas', 0, 234, '2021-01-05', '2021-01-04 19:43:20', 'test'),
(15, 25, 'testMaterial', 102, 34, '2021-01-06', '2021-01-04 21:34:47', NULL),
(16, 21, 'test', 0, 0, '0000-00-00', '2021-01-07 17:29:49', '345');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `captured_at` datetime NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_id`, `amount`, `currency`, `payment_status`, `captured_at`, `userid`) VALUES
(11, 'ch_1HuBIbJmfnsrzK57UqMzcfqG', 1800.00, 'PHP', 'Captured', '2020-12-03 15:28:21', 37),
(12, 'ch_1HuBMhJmfnsrzK5769NNWqzx', 1800.00, 'PHP', 'Captured', '2020-12-03 15:32:33', 37),
(13, 'ch_1HuBTwJmfnsrzK573SpNZBoV', 3000.00, 'PHP', 'Captured', '2020-12-03 15:40:03', 37);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `srp` float NOT NULL,
  `qty` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `storeid` int(11) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `srp`, `qty`, `expiry_date`, `storeid`, `date_created`, `status`) VALUES
(16, 'Cheese Cake', 20, 99, '2021-01-07', 21, 2147483647, 1);

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `batchnumber` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_produced` date NOT NULL,
  `storeid` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` varchar(255) DEFAULT NULL,
  `date_expired` date DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`id`, `productid`, `batchnumber`, `quantity`, `date_produced`, `storeid`, `date_created`, `unit`, `date_expired`, `price`) VALUES
(48, 16, 'Batch #48', 100, '2021-01-07', 21, '2021-01-07 14:18:13', 'kg', '2021-01-07', 99),
(49, 16, 'Batch #49', 100, '2021-01-07', 21, '2021-01-07 14:19:21', 'kg', '2021-01-07', 100),
(50, 16, 'Batch #50', 34, '2021-01-08', 21, '2021-01-07 18:41:51', 'pcs', '2021-01-08', 2),
(51, 16, 'Batch #51', 319, '2021-01-08', 21, '2021-01-08 07:07:05', 'pcs', '2021-01-08', 100),
(52, 16, 'Batch #52', 100, '2021-01-08', 21, '2021-01-08 07:13:47', 'pcs', '2021-01-08', 22);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `vendorid` int(11) NOT NULL,
  `materialid` int(11) NOT NULL,
  `date_purchased` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `storeid` int(11) NOT NULL,
  `credit_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `vendorid`, `materialid`, `date_purchased`, `type`, `qty`, `date_created`, `storeid`, `credit_date`, `expiry_date`, `unit`, `price`) VALUES
(53, 1, 11, '2021-01-08', 'cash', 324, '2021-01-07 15:11:02', 21, '2021-01-08', '2021-01-08', '45', 345),
(54, 1, 11, '2021-01-08', 'cash', 324, '2021-01-07 15:11:15', 21, '2021-01-08', '2021-01-08', '45', 345),
(55, 1, 11, '2021-01-08', 'cash', 34, '2021-01-07 16:11:50', 21, '2021-01-08', '2021-01-08', 'unit', 345),
(56, 1, 11, '2021-01-08', 'cash', 34, '2021-01-07 16:11:52', 21, '2021-01-08', '2021-01-08', 'unit', 345),
(57, 1, 11, '2021-01-08', 'credit', 23, '2021-01-07 18:03:02', 21, '2021-01-09', '2021-01-08', 'test', 33);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE `purchase_return` (
  `id` int(11) NOT NULL,
  `materialid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `date_purchased` date NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_return`
--

INSERT INTO `purchase_return` (`id`, `materialid`, `amount`, `qty`, `unit`, `date_purchased`, `date_added`) VALUES
(1, 11, 234, 234, 'pcs', '2021-01-08', '2021-01-08 12:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date_purchased` date NOT NULL,
  `other_details` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` varchar(255) DEFAULT 'pcs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `storeid`, `productid`, `qty`, `date_purchased`, `other_details`, `date_created`, `unit`) VALUES
(18, 21, 16, 1, '2021-01-08', '', '2021-01-08 06:25:59', 'pcs'),
(19, 21, 16, 23, '2021-01-08', '', '2021-01-08 06:33:59', 'pcs'),
(20, 21, 16, 638, '2021-01-08', '', '2021-01-08 07:07:29', 'pcs');

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `id` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date_purchased` date NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'pcs',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_return`
--

INSERT INTO `sales_return` (`id`, `productid`, `amount`, `date_purchased`, `qty`, `unit`, `date_added`) VALUES
(1, 16, 2, '2021-01-08', 2, 'pcs', '2021-01-08 10:52:25'),
(2, 16, 2, '2021-01-08', 2, 'pcs', '2021-01-08 10:54:33'),
(3, 16, 2, '2021-01-08', 2, 'pcs', '2021-01-08 10:54:34'),
(4, 11, 234, '2021-01-08', 234, 'pcs', '2021-01-08 12:03:55'),
(5, 11, 234, '2021-01-08', 234, 'pcs', '2021-01-08 12:03:55'),
(6, 11, 234, '2021-01-08', 234, 'pcs', '2021-01-08 12:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `terms` text DEFAULT NULL,
  `privacy` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `userid`, `terms`, `privacy`) VALUES
(1, './uploads/logo/logo.png', 36, '<div class=\"EN\">\r\n                        <div>\r\n                            <h2>TERMS AND CONDITIONS</h2>\r\n                            <p><span>This site is owned and operated by BakedPH.</span></p>\r\n                            <h3>AGREEMENT</h3>\r\n                            <p><span>BakedPH contains multiple Web pages operated by BakedPH. This offer is available for you and is subject to the acceptance of the following terms and conditions. Your use of the BakedPH site and related offers represents your consent to all such terms contained herein. BakedPH reserves the right to change the terms in which this offer is being offered. Please check this page for any changes. BakedPH seeks to ensure that all available information on the website is accurate and true, however there is no guarantee. These terms and conditions apply exclusively, although in contrast to the general or specific conditions or stipulations of the buyer. These conditions will remain in force during the sale and during the relevant activities relating to such sale.</span></p>\r\n                            <h3>BASIC TERMS OF THE AGREEMENT</h3>\r\n                            <p><span>The price of this product is the price set at the time of purchase and may change from time to time if it is used to complete a new purchase. In no event shall the purchase price of today guarantee a price for future purchases not related. The price does not include shipping and applicable operating costs that may be evaluated based on the amount of purchase.</span></p>\r\n                            <p><span>Live email support is available:</span><span> </span><a href=\"mailto:support@bakedph.com\"><span> </span><span>support@bakedph.com</span></a></p>\r\n                            <p>Or you may call us toll-free:</p>\r\n                            <div class=\"billing_support\">\r\n                                <div>\r\n                                    <p><strong>CA : </strong><span>1 (888) 254-5183</span></p>\r\n                                    <p><strong>IE : </strong><span>1800 903 218</span></p>\r\n                                    <p><strong>NZ : </strong><span>0800 359 816</span></p>\r\n                                    <p><strong>US : </strong><span>1 (877) 359-4160</span></p>\r\n                                    <p><strong>ZA : </strong><span>080 099 5067</span></p>\r\n                                </div>\r\n                            </div>\r\n                            <h3>CANCELLATIONS / REFUNDS</h3>\r\n                            <p>To cancel your order at any time, please contact our Customer Service Department.</p>\r\n                            <p><span>Live Email Support</span><span>:&nbsp;&nbsp;</span><a class=\"supp\" href=\"mailto:support@bakedph.com\">support@bakedph.com</a></p>\r\n                            <div class=\"billing_support\">\r\n                                <div>\r\n                                    <p><strong>CA : </strong><span>1 (888) 254-5183</span></p>\r\n                                    <p><strong>IE : </strong><span>1800 903 218</span></p>\r\n                                    <p><strong>NZ : </strong><span>0800 359 816</span></p>\r\n                                    <p><strong>US : </strong><span>1 (877) 359-4160</span></p>\r\n                                    <p><strong>ZA : </strong><span>080 099 5067</span></p>\r\n                                </div>\r\n                            </div>\r\n                            <p><span>If the cancellation is made after the order has been shipped, you will be responsible for the payment of the product that has been (1) already been shipped or (2) has already been given to you when you call.</span></p>\r\n                            <p><span>You can receive a refund of any Product that you ordered up to thirty (30) days after the completion of your order. Customers will receive a refund for the product ordered, and repetitive refunds are not allowed, unless at the time of delivery the product is defective. BakedPH reserves the right to refuse to refund all customers who make repeated requests for refunds or who, in the opinion of BakedPH, require refunds in bad faith.</span></p>\r\n                            <p><span>In order to process the refund, you must contact our customer service and provide your name and account information. If you provide incorrect information, we will not be able to access your account and we will not complete the return. Refunds can take up to two weeks to appear on your credit card according to the bank that issued the credit card.</span></p>\r\n                            <h3>SHIPPING / RETURNS</h3>\r\n                            <p><span>Standard shipping usually takes 14-21 working days. If you want to return the unused product please do so by sending the address indicated below.</span></p>\r\n                            <p>Please send all returns to:</p>\r\n                            <p><span><strong>BakedPH</strong>: <br>6525 Gunpark Dr, Ste 370-346<br> Boulder, CO 80301 USA</span></p>\r\n                            <p><span>Customers are responsible for any shipping fees associated with their return, and may be subject to a restocking fee.</span></p>\r\n                            <h3>RELATIONS WITH THIRD PARTIES</h3>\r\n                            <p><span>BakedPH is not responsible for web-casting or any other form of transmission received from any Linked Site. BakedPH is providing these links to you only as a convenience, and the inclusion of any link does not imply endorsement by BakedPH the site or any association with its officers or directors.</span></p>\r\n                            <h3>NO UNLAWFUL OR PROHIBITED USE</h3>\r\n                            <p><span>As a condition of your use of BakedPH, you agree not to use the Site for any purpose that is unlawful or prohibited by these terms and conditions. You may not use BakedPH to damage, disable or impair the website BakedPH. You may not obtain or seek to obtain any materials or information through any means not intentionally made available or provided for through our website.</span></p>\r\n                            <h3>USER REGISTRATION AND ELECTRONIC SIGNATURE</h3>\r\n                            <p><span>You must register as a \"member\" of the BakedPH in order to access certain functions of the site. You must provide current, complete and accurate information about you when you register as a member. You agree that such information is true and complete. You agree to maintain and keep your personal information current and update the information as needed. Without your true information, BakedPH can not be held responsible for any access or access problem.</span></p>\r\n                            <p><span>Once the registration is completed you consent to these Terms and Conditions, you gave us your approval and electronic signature for this offer, and, therefore, the authorization. Only in this way the charge and the acceptance can be confirmed.</span></p>\r\n                            <h3>DISCLAIMER</h3>\r\n                            <p><span>THE INFORMATION, SOFTWARE, PRODUCTS, AND SERVICES INCLUDED IN OR AVAILABLE THROUGH THE WEB SITE BakedPH MAY INCLUDE INACCURACIES OR TYPOGRAPHICAL ERRORS. CHANGES ARE PERIODICALLY ADDED TO THE INFORMATION.</span></p>\r\n                            <p><span>BakedPH MAKES NO REPRESENTATIONS OR WARRANTIES AS TO THE RELIABILITY, FITNESS, TIMELINESS, AND ACCURACY OF THE INFORMATION, SOFTWARE, PRODUCTS, SERVICES AND RELATED GRAPHICS CONTAINED ON THE SITE. TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL BakedPH AND / OR ITS SUPPLIERS BE LIABLE FOR ANY DIRECT, INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL, CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS OF USE, DATA OR PROFITS, ARISING OUT OF OR IN ANY WAY CONNECTED WITH THE USE OR PERFORMANCE OF THE PRODUCTS OR SERVICES.</span></p>\r\n                            <h3>TERMINATION / ACCESS RESTRICTION</h3>\r\n                            <div>\r\n                                <p><span>BakedPH reserves the right, in its sole discretion, to terminate your access to the website and the related services or any portion thereof at any time, without notice. You agree that no joint venture, partnership, employment, or agency relationship exists between you and BakedPH as a result of this agreement or use of the services. This agreement is written in English, which must be considered the official language of the text of this contract, regardless of the language in which these terms may have been translated. If you wish to receive a copy of these terms, please send a request to:</span><span> </span><a href=\"mailto:support@bakedph.com\"><span> </span><span>support@bakedph.com</span></a></p>\r\n                            </div>\r\n                            <h3>NOTICES OF INTELLECTUAL PROPERTY, COPYRIGHT AND TRADEMARKS:</h3>\r\n                            <p><span>BakedPH and all its related logos are trademarks or trade names. You may not copy, imitate or use the above without the prior written consent of BakedPH. You may not alter, modify or in any way change these HTML logos, or use them in a manner deemed offensive according BakedPH or use them in any way that implies sponsorship or endorsement of BakedPH.</span></p>\r\n                            <h3>TRADEMARKS</h3>\r\n                            <p><span>The names of actual companies and products mentioned herein may be the trademarks of their respective owners. The example companies, organizations, products, people and events depicted herein are fictitious. No association with any real company, organization, product, person, or event is intended or should be inferred. All rights not expressly granted herein are reserved.</span></p>\r\n                            <h3>PRIVACY POLICY</h3>\r\n                            <p><span>Please consult the privacy policy of BakedPH. By accepting these Terms and Conditions, and each time you use the service, you consent to the collection, use and disclosure of information or data recording by BakedPH, in accordance with the privacy policy without notice or liability to you or any other person.</span></p>\r\n                            <p><span>Customer Service is available 24 hours a day at:</span><span> </span><a href=\"mailto:support@bakedph.com\"><span> </span><span>support@bakedph.com</span></a></p>\r\n                            <p class=\"termscopy\"><span>Copyright</span><span> © </span><span>2021</span><span> </span><span>BakedPH</span><span> </span><span class=\"mobilef\">All Rights Reserved</span><span> </span></p>\r\n                        </div>\r\n                    </div>', '<div data-reactid=\".2.1.0.0.$=11:0.0.0\">\r\n                <figure class=\"logo\"></figure>\r\n                <h2 data-reactid=\".2.1.0.0.$=11:0.0.0.0\">PRIVACY POLICY</h2><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.1\">THE INFORMATION WE COLLECT</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.2\">We use the information we collect on our websites to provide a superior shopping experience and to communicate with you about products, services and promotions. We collect information about you when you register on our site, place an order, subscribe to our newsletter, respond to a survey, or fill out a form.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.3\">The following types of information about a user are among those that may be collected by us in relation to the site: name, postal address, e-mail address, telephone number, mobile phone number, payment information (such as card numbers credit and billing address if purchases or payments are made), date of birth, age, sex, other demographic information (such as occupation, income bracket), IP address, referring site, and other technical information collected by the site server.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.4\">INFORMATION</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.5\">In connection with the web site, we may collect information in the following ways:</p><ul data-reactid=\".2.1.0.0.$=11:0.0.0.6\"><li data-reactid=\".2.1.0.0.$=11:0.0.0.6.0\">Through registration forms filled out by a user on the Site</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.6.1\">Through the information provided by a user in connection with the purchase of products or services on the Site</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.6.2\">Through the maintenance and analysis of Web server logs</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.6.3\">Through calls and e-mail users</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.6.4\">Through Internet chat sessions between a user and this site</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.6.5\">Through the use of this site to third-party databases from which user information is extracted and combined with information obtained from this site by other means</li></ul><p data-reactid=\".2.1.0.0.$=11:0.0.0.7\">We can also connect to personally and non-personally identifiable information from users via \"cookies\" (small text files placed by this site on users\' computers), GIF image files to single-pixel (also called \"Web beacons\"), the Web server log analysis and other similar technological means. This information can be used to track the trends of the site and improve the user experience, and may be shared with third parties.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.8\">To the extent that third parties may place advertisements on the Site, such third parties may use cookies or other technological means within the advertising to collect and use non-personally identifiable information. We are not responsible for information collected by third parties in this manner, nor for the collection or use of information from other sites which are connected to the site.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.9\">USE OF INFORMATION</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.a\">We may use information collected in connection with the Site in the following ways:</p><ul data-reactid=\".2.1.0.0.$=11:0.0.0.b\"><li data-reactid=\".2.1.0.0.$=11:0.0.0.b.0\">Provide the requested information, products, and services to users via the Site or through other online or offline channels</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.b.1\">To enable users to enter prize promotions and receive prizes from us and / or third parties</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.b.2\">To improve the user experience with the site</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.b.3\">In relation to the operation of the Site and for our internal business</li><li data-reactid=\".2.1.0.0.$=11:0.0.0.b.4\">In order for users to obtain information and offers for products and services offered by us and selected third parties</li></ul><p data-reactid=\".2.1.0.0.$=11:0.0.0.c\">To do the above, we can provide the information to trusted third parties, including but not limited to third-party contractors that provide us with services, such as the operation of the Site, communication services and the creation of test orders, credit cards and payment services, and other online and offline marketing in connection with the offerings provided to users by us and / or such other sellers. We will use commercially reasonable efforts to limit the use of information by such third parties for the specific uses mentioned above. We also use electronic and physical security to reduce the risk of improper access or manipulation of information during transmission and storage, but can not guarantee the security and integrity of the information and shall have no liability for breaches of security or integrity or third-party interception in transit.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.d\">We may also disclose information when it determines that it is necessary to comply with applicable laws and regulations and protect the interests or safety of our business, its customers, or other visitors to the site.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.e\">Note: If at any time you would like to unsubscribe from receiving e-mail in the future, there are detailed instructions for cancellation of registration at the bottom of each email.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.f\">HOW DO WE PROTECT YOUR INFORMATION?</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.g\">We implement a variety of security measures to ensure the safety of your personal information when you place an order or access your personal information.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.h\">We offer the use of a secure server. All information supplied sensitive / credit supply is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our Payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to maintain the confidentiality of information.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.i\">COOKIES</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.j\">From time to time, we may send a \"cookie\" to your computer. A cookie is a small piece of data that is sent to your browser from a web server and stored on your computer\'s hard drive. A cookie can not read data on your hard disk or read cookie files created by other sites. Cookies do not damage your system. We use cookies to recognize you when you return to our sites, or to identify which areas of our network of web sites you have visited (i.e. e-commerce sites, etc.) We can use this information to better personalize the content you see on our sites.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.k\">Many web sites place cookies on your hard drive. You can choose whether to accept cookies by changing the settings of your browser. Your browser can refuse all cookies, or show you when a cookie is being sent. If you choose not to accept cookies, your experience at our site and other websites may be diminished and some features may not work as expected.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.l\">DISCLOSE ANY INFORMATION TO OUTSIDE PARTIES?</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.m\">We do not sell, trade, or otherwise transfer your personal information to third parties. This does not include trusted third parties who assist us in operating our website, conducting our business, or offer services, provided that such parties undertake to keep such information confidential. We may also release your information when we believe release is appropriate to comply with the law and, by enforcing our site policies, or protect ours or others rights, property, or safety. However, if the information is not personally identifiable it may be provided to other parties for marketing, advertising, or other uses.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.n\">PURCHASES FROM MINORS</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.o\">We do not knowingly collect any information from children under 18 years of age. Our website, products and services are all directed to people who are at least 18 years or more.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.p\">YOUR CONSENT</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.q\">By using our site, you consent to our privacy policy.</p><p data-reactid=\".2.1.0.0.$=11:0.0.0.r\">We reserve the right to revise and update this Privacy Policy at any time. Any such revisions will be effective from the date of publication on the Site, and applies to all information collected by us both before and after the effective date. Your use of the Site after any such changes will be deemed acceptance of those revisions. Users should periodically visit this page to review the current policies with respect to information.</p><h3 data-reactid=\".2.1.0.0.$=11:0.0.0.s\">GDPR</h3><p data-reactid=\".2.1.0.0.$=11:0.0.0.t\"><span data-reactid=\".2.1.0.0.$=11:0.0.0.t.0\">In accordance with GDPR, BakedPH will honor requests for personal data. This may include the transfer or deletion of personal data from BakedPH servers and database. Requests may be sent to <a href=\"mailto:support@bakedph.com\">support@bakedph.com</a>. Requests will be answered in the order they are received (always within 30 days).</span></p></div>');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `photo` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) NOT NULL DEFAULT 'slide'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `content`, `status`, `photo`, `date_created`, `type`) VALUES
(15, 'slide1', 'asd', 1, 'uploads/admin/banner3.jpg', '2021-01-02 11:14:45', 'slider');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `date_creaed` timestamp NULL DEFAULT current_timestamp(),
  `userid` int(11) NOT NULL,
  `subscriptionid` int(255) DEFAULT NULL,
  `last_payment_id` varchar(255) DEFAULT NULL,
  `material_low` int(11) DEFAULT 20,
  `product_low` int(11) DEFAULT 20,
  `b_address` varchar(255) DEFAULT NULL,
  `dti` varchar(255) DEFAULT NULL,
  `b_email` varchar(255) DEFAULT NULL,
  `b_contact` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `description`, `logo`, `date_creaed`, `userid`, `subscriptionid`, `last_payment_id`, `material_low`, `product_low`, `b_address`, `dti`, `b_email`, `b_contact`) VALUES
(20, 'jorjor', NULL, NULL, '2020-10-12 15:57:01', 36, 30, NULL, 20, 20, NULL, NULL, NULL, NULL),
(21, 'cyborg999', NULL, NULL, '2020-10-17 04:48:07', 37, 32, 'ch_1HuBTwJmfnsrzK573SpNZBoV', 985, 350, NULL, NULL, NULL, NULL),
(22, 'User2 Store', NULL, NULL, '2020-11-29 14:50:17', 38, 32, NULL, 20, 20, NULL, NULL, NULL, NULL),
(23, 'merchanrt5', NULL, NULL, '2021-01-03 12:49:16', 39, 31, NULL, 20, 20, NULL, NULL, NULL, NULL),
(24, 'test store', NULL, NULL, '2021-01-04 20:28:33', 40, 31, NULL, 20, 20, '234 asdsad', '34435', '3445@mail.com', '34534534'),
(25, 'Trial Store', NULL, NULL, '2021-01-04 20:46:44', 41, 42, NULL, 20, 20, '234 asdas', '345435', 'sad@nauk.com', '3454353'),
(26, 'Jordan Sadiwa', NULL, NULL, '2021-01-06 02:42:36', 42, 42, NULL, 20, 20, '1852 Sandejas Pasay City', '234', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '234'),
(27, 'Jordan Sadiwa345', NULL, NULL, '2021-01-06 14:32:00', 45, 42, NULL, 20, 20, '1852 Sandejas Pasay City', '234', 'sad@mail.com', '234'),
(28, 'Jordan Sadiwa345', NULL, NULL, '2021-01-06 14:32:14', 46, 42, NULL, 20, 20, '1852 Sandejas Pasay City', '234', 'sad@mail.com', '234'),
(29, 'Jordan Sadiwa345', NULL, NULL, '2021-01-06 14:32:34', 47, 42, NULL, 20, 20, '1852 Sandejas Pasay City', '234', 'sad@mail.com', '234');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `cost` float NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `is_trial` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `duration`, `cost`, `active`, `title`, `caption`, `deleted`, `is_trial`) VALUES
(24, 23, 2, 1, '1', '2', 1, 0),
(25, 1, 1, 1, '1', '1', 1, 0),
(26, 1, 1, 1, '1', '1', 1, 0),
(27, 23, 23, 1, 'q', '3', 1, 0),
(28, 234, 242, 1, '4', '2344', 1, 0),
(29, 234, 324, 1, '34', '42', 1, 0),
(30, 3, 600, 1, 'Plan #1', '3 Months', 0, 0),
(31, 1, 800, 1, 'Plan #2', '1 Month', 1, 0),
(32, 6, 500, 1, 'Plan #3', '6 Months', 1, 0),
(33, 12, 450, 0, 'Plan #4', '1 Year', 1, 0),
(34, 7, 550, 0, 'Plan #5', '7 Months', 1, 0),
(35, 345345, 0, 1, 'asdas', '345345', 1, 0),
(36, 3453, 0, 1, 'asdsa', '345345', 1, 0),
(37, 234, 0, 1, 'asdasd', '34', 1, 0),
(38, 34543, 0, 1, 'test', '45', 1, 1),
(39, 345, 0, 1, 'test', '345345', 1, 1),
(40, 43, 46, 1, 'sdfsd', '345', 1, 0),
(41, 345, 4, 1, 'test product', '43', 1, 0),
(42, 1, 0, 1, 'Free Plan', '1 Month Free Trial', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL DEFAULT 'basic',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `usertype`, `verified`, `date_created`) VALUES
(36, 'admin', 'eed57216df3731106517ccaf5da2122d', 'admin', 0, '2020-10-12 15:56:55'),
(37, 'cyborg999', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 1, '2020-10-17 04:48:06'),
(38, 'user2', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2020-11-29 14:50:17'),
(39, 'merchant5', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2021-01-03 12:49:16'),
(40, 'test', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2021-01-04 20:28:33'),
(41, 'trialUser', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2021-01-04 20:46:44'),
(42, 'test9', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2021-01-06 02:42:35'),
(47, 'cyborg999asd', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2021-01-06 14:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `fullname`, `address`, `contact`, `email`, `bday`, `date_created`, `userid`) VALUES
(2, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '09287655606', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '2021-01-05', '2020-10-12 15:56:56', 36),
(3, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '09287655606', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '2021-01-05', '2020-10-17 04:48:06', 37),
(15, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '09287655606', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '2021-01-05', '2020-11-29 14:50:17', 38),
(16, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '09287655606', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '2021-01-05', '2021-01-03 12:49:16', 39),
(17, NULL, NULL, NULL, NULL, NULL, '2021-01-04 20:28:33', 40),
(20, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '234', 'sad@mail.com', NULL, '2021-01-06 14:32:34', 47);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `storeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `address`, `contact`, `date_created`, `storeid`) VALUES
(1, 'Jordan Sadiwa', '1852 Sandejas Pasay City', 2342342, '2020-10-17 11:17:37', 21),
(3, 'test345', '345', 234, '2020-10-17 11:20:20', 21),
(4, 'testSupplier', '344353', 23432, '2021-01-04 21:34:58', 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_inventory`
--
ALTER TABLE `material_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return`
--
ALTER TABLE `sales_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `material_inventory`
--
ALTER TABLE `material_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `purchase_return`
--
ALTER TABLE `purchase_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales_return`
--
ALTER TABLE `sales_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
