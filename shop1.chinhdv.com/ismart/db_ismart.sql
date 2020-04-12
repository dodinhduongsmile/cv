-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 30, 2020 lúc 05:31 PM
-- Phiên bản máy phục vụ: 10.1.36-MariaDB
-- Phiên bản PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_ismart`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_block`
--

CREATE TABLE `tbl_block` (
  `id` int(11) NOT NULL,
  `name_block` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `code_block` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `content_block` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `author` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `created_date` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_block`
--

INSERT INTO `tbl_block` (`id`, `name_block`, `code_block`, `content_block`, `author`, `created_date`) VALUES
(1, 'LI&Ecirc;N HỆ', 'footer1', '&lt;ul&gt;\r\n	&lt;li&gt;\r\n	&lt;p&gt;106 - Trần B&amp;igrave;nh - Cầu Giấy - H&amp;agrave; Nội&lt;/p&gt;\r\n	&lt;/li&gt;\r\n	&lt;li&gt;\r\n	&lt;p&gt;0987.654.321 - 0989.989.989&lt;/p&gt;\r\n	&lt;/li&gt;\r\n	&lt;li&gt;\r\n	&lt;p&gt;vshop@gmail.com&lt;/p&gt;\r\n	&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 'dothiquynh', '07-12-2019'),
(2, 'Ch&iacute;nh s&aacute;ch mua h&agrave;ng', 'footer3', '&lt;ul&gt;\r\n	&lt;li&gt;&lt;a href=&quot;http://localhost/unitop/backend/lession/section29/theme.ismart.com/&quot; title=&quot;&quot;&gt;Quy định - ch&amp;iacute;nh s&amp;aacute;ch&lt;/a&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;a href=&quot;http://localhost/unitop/backend/lession/section29/theme.ismart.com/&quot; title=&quot;&quot;&gt;Ch&amp;iacute;nh s&amp;aacute;ch bảo h&amp;agrave;nh - đổi trả&lt;/a&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;a href=&quot;http://localhost/unitop/backend/lession/section29/theme.ismart.com/&quot; title=&quot;&quot;&gt;Ch&amp;iacute;nh s&amp;aacute;ch hội viện&lt;/a&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;a href=&quot;http://localhost/unitop/backend/lession/section29/theme.ismart.com/&quot; title=&quot;&quot;&gt;Giao h&amp;agrave;ng - lắp đặt&lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 'dothiquynh', '07-12-2019'),
(3, 'Bảng tin', 'footer4', '&lt;p&gt;Đăng k&amp;yacute; với chung t&amp;ocirc;i để nhận được th&amp;ocirc;ng tin ưu đ&amp;atilde;i sớm nhất&lt;/p&gt;\r\n\r\n&lt;div id=&quot;form-reg&quot;&gt;\r\n&lt;form action=&quot;&quot; method=&quot;POST&quot;&gt;&lt;input id=&quot;email&quot; name=&quot;email&quot; placeholder=&quot;Nhập email tại đ&acirc;y&quot; type=&quot;email&quot; /&gt;&lt;button id=&quot;sm-reg&quot; type=&quot;submit&quot;&gt;Đăng k&amp;yacute;&lt;/button&gt;&lt;/form&gt;\r\n&lt;/div&gt;\r\n', 'dothiquynh', '10-12-2019'),
(4, 'phone', 'phone', '&lt;p&gt;0986.490.199&lt;/p&gt;\r\n', 'dothiquynh', '10-12-2019'),
(5, 'logo', 'logo', '&lt;img alt=&quot;&quot; src=&quot;http://localhost/unitop/backend/lession/section29/ismart.com/admin/upload/files/logo.png&quot; style=&quot;width: 152px; height: 51px;&quot; /&gt;\r\n', 'dothiquynh', '15-12-2019'),
(6, 'ISMART', 'footer2', '&lt;h3&gt;&lt;strong&gt;&lt;span style=&quot;color:#ff0000;&quot;&gt;ISMART&lt;/span&gt;&lt;/strong&gt;&lt;/h3&gt;\r\n\r\n&lt;p&gt;ISMART lu&amp;ocirc;n cung cấp lu&amp;ocirc;n l&amp;agrave; sản phẩm ch&amp;iacute;nh h&amp;atilde;ng c&amp;oacute; th&amp;ocirc;ng tin r&amp;otilde; r&amp;agrave;ng, ch&amp;iacute;nh s&amp;aacute;ch ưu đ&amp;atilde;i cực lớn cho kh&amp;aacute;ch h&amp;agrave;ng c&amp;oacute; thẻ th&amp;agrave;nh vi&amp;ecirc;n.&lt;/p&gt;\r\n', 'dothiquynh', '10-12-2019');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_checkout`
--

CREATE TABLE `tbl_checkout` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `address` varchar(400) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `phone` int(30) NOT NULL,
  `note` text COLLATE utf8mb4_vietnamese_ci,
  `product` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `count_product` int(20) NOT NULL,
  `total_price` varchar(30) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `payment` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT '2',
  `code` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `created_date` varchar(30) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_checkout`
--

INSERT INTO `tbl_checkout` (`id`, `fullname`, `email`, `address`, `phone`, `note`, `product`, `count_product`, `total_price`, `payment`, `status`, `code`, `created_date`) VALUES
(12, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'xxxxx', '<table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n    		<tr style=\'border: 1px solid black !important;\'>\r\n	    		<td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n	    		<td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n    		</tr>\r\n    	</thead><tbody><tr>\r\n	                    <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>Điện thoại iPhone Xs Max 256GB</td>\r\n                        <td style=\'border: 1px solid black;\'></td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n	                    <td style=\'border: 1px solid black;\'>750,000đ</td>\r\n	                </tr><tr>\r\n	                    <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>Laptop Acer Aspire A715 72G</td>\r\n                        <td style=\'border: 1px solid black;\'></td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n	                    <td style=\'border: 1px solid black;\'>610,000đ</td>\r\n	                </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' rowspan=\'2\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng:2 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' rowspan=\'2\'>Thanh toán:<strong >1,360,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table>', 2, '1360000', 'ship', '2', 'DH1576338181', '14-12-2019'),
(13, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'ccccc', '<table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n    		<tr style=\'border: 1px solid black !important;\'>\r\n	    		<td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n	    		<td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n    		</tr>\r\n    	</thead><tbody><tr>\r\n	                    <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>điện thoại iphone 8 plus</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n	                    <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n	                </tr><tr>\r\n	                    <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>laptop dell latitude d630</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n	                    <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n	                </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'2\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng:2 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'2\'>Thanh toán:<strong >4,000,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table>', 2, '4000000', 'ship', '2', 'DH1576338456', '14-12-2019'),
(14, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'cccccc', '<div>\r\n        <p>Chào bạn:đỗ đình dương . Cảm ơn bạn đã đặt hàng tại shop <strong>Ismart</strong></p>\r\n        <h3>Đây là thông tin đơn hàng của bạn</h3>\r\n        <p>1. Mã đơn hàng: DH1576340189</p>\r\n        <p>2. Thời gian đặt hàng: 14-12-2019</p>\r\n        <h3>Đây là thông tin giao hàng của bạn:</h3>\r\n        <ul>\r\n            <li>1. Người nhận: đỗ đình dương</li>\r\n            <li>2. Địa chỉ nhận hàng: xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội </li>\r\n            <li>3. Số điện thoại: 0986490196</li>\r\n            <li>4. Ghi chú: cccccc</li>\r\n            <li>5. Hình thức thanh toán: ship </li>\r\n            <li>6. Chi phí vận chuyển: <b>Miễn phí</b> </li>\r\n        </ul>\r\n        <h3>Đây là chi tiết đơn hàng của bạn:</h3>\r\n    </div><table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n            <tr style=\'border: 1px solid black !important;\'>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n            </tr>\r\n        </thead><tbody><tr>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>điện thoại iphone 8 plus</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr><tr>\r\n                        <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>laptop dell latitude d630</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'3\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>2 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'><strong >4,000,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table><p>Chúng tôi sẽ gọi để xác nhận đơn hàng trong vòng 24h. Bạn nhớ để ý điện thoại nhé</p>\r\n    <strong>Trân trọng cảm ơn!</strong>', 2, '4000000', 'ship', '2', 'DH1576340189', '14-12-2019'),
(15, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'nhanh lên', '<div>\r\n        <p>Chào bạn:đỗ đình dương . Cảm ơn bạn đã đặt hàng tại shop <strong>Ismart</strong></p>\r\n        <h3>Đây là thông tin đơn hàng của bạn</h3>\r\n        <p>1. Mã đơn hàng: DH1576341200</p>\r\n        <p>2. Thời gian đặt hàng: 14-12-2019</p>\r\n        <h3>Đây là thông tin giao hàng của bạn:</h3>\r\n        <ul>\r\n            <li>1. Người nhận: đỗ đình dương</li>\r\n            <li>2. Địa chỉ nhận hàng: xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội </li>\r\n            <li>3. Số điện thoại: 0986490196</li>\r\n            <li>4. Ghi chú: nhanh lên</li>\r\n            <li>5. Hình thức thanh toán: ship </li>\r\n            <li>6. Chi phí vận chuyển: <b>Miễn phí</b> </li>\r\n        </ul>\r\n        <h3>Đây là chi tiết đơn hàng của bạn:</h3>\r\n    </div><table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n            <tr style=\'border: 1px solid black !important;\'>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n            </tr>\r\n        </thead><tbody><tr>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>điện thoại iphone 8 plus</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr><tr>\r\n                        <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>laptop dell latitude d630</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'3\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>2 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'><strong >4,000,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table><p>Chúng tôi sẽ gọi để xác nhận đơn hàng trong vòng 24h. Bạn nhớ để ý điện thoại nhé</p>\r\n    <strong>Trân trọng cảm ơn!</strong>', 2, '4000000', 'ship', '2', 'DH1576341200', '14-12-2019'),
(16, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'nhanh lên', '<div>\r\n        <p>Chào bạn:đỗ đình dương . Cảm ơn bạn đã đặt hàng tại shop <strong>Ismart</strong></p>\r\n        <h3>Đây là thông tin đơn hàng của bạn</h3>\r\n        <p>1. Mã đơn hàng: DH1576341271</p>\r\n        <p>2. Thời gian đặt hàng: 14-12-2019</p>\r\n        <h3>Đây là thông tin giao hàng của bạn:</h3>\r\n        <ul>\r\n            <li>1. Người nhận: đỗ đình dương</li>\r\n            <li>2. Địa chỉ nhận hàng: xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội </li>\r\n            <li>3. Số điện thoại: 0986490196</li>\r\n            <li>4. Ghi chú: nhanh lên</li>\r\n            <li>5. Hình thức thanh toán: ship </li>\r\n            <li>6. Chi phí vận chuyển: <b>Miễn phí</b> </li>\r\n        </ul>\r\n        <h3>Đây là chi tiết đơn hàng của bạn:</h3>\r\n    </div><table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n            <tr style=\'border: 1px solid black !important;\'>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n            </tr>\r\n        </thead><tbody><tr>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>điện thoại iphone 8 plus</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr><tr>\r\n                        <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>laptop dell latitude d630</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'3\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>2 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'><strong >4,000,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table><p>Chúng tôi sẽ gọi để xác nhận đơn hàng trong vòng 24h. Bạn nhớ để ý điện thoại nhé</p>\r\n    <strong>Trân trọng cảm ơn!</strong>', 2, '4000000', 'ship', '2', 'DH1576341271', '14-12-2019'),
(17, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'nhanh.......', '<div>\r\n        <p>Chào bạn:đỗ đình dương . Cảm ơn bạn đã đặt hàng tại shop <strong>Ismart</strong></p>\r\n        <h3>Đây là thông tin đơn hàng của bạn</h3>\r\n        <p>1. Mã đơn hàng: DH1576341585</p>\r\n        <p>2. Thời gian đặt hàng: 14-12-2019</p>\r\n        <h3>Đây là thông tin giao hàng của bạn:</h3>\r\n        <ul>\r\n            <li>1. Người nhận: đỗ đình dương</li>\r\n            <li>2. Địa chỉ nhận hàng: xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội </li>\r\n            <li>3. Số điện thoại: 0986490196</li>\r\n            <li>4. Ghi chú: nhanh.......</li>\r\n            <li>5. Hình thức thanh toán: ship </li>\r\n            <li>6. Chi phí vận chuyển: <b>Miễn phí</b> </li>\r\n        </ul>\r\n        <h3>Đây là chi tiết đơn hàng của bạn:</h3>\r\n    </div><table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n            <tr style=\'border: 1px solid black !important;\'>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n            </tr>\r\n        </thead><tbody><tr>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>điện thoại iphone 9 plus</td>\r\n                        <td style=\'border: 1px solid black;\'>6000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>6,000,000đ</td>\r\n                    </tr><tr>\r\n                        <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>laptop dell latitude d630</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr><tr>\r\n                        <td style=\'border: 1px solid black;\'>3</td>\r\n                        <td style=\'border: 1px solid black;\'>laptop dell latitude d730</td>\r\n                        <td style=\'border: 1px solid black;\'>4000000</td>\r\n                        <td style=\'border: 1px solid black;\'>2</td>\r\n                        <td style=\'border: 1px solid black;\'>8,000,000đ</td>\r\n                    </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'3\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>4 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'><strong >16,000,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table><p>Chúng tôi sẽ gọi để xác nhận đơn hàng trong vòng 24h. Bạn nhớ để ý điện thoại nhé</p>\r\n    <strong>Trân trọng cảm ơn!</strong>', 4, '16000000', 'ship', '2', 'DH1576341585', '14-12-2019'),
(18, 'đỗ đình dương', 'dodinhduongsmilepd@gmail.com', 'xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội', 986490196, 'xxxxxxx', '<div>\r\n        <p>Chào bạn:đỗ đình dương . Cảm ơn bạn đã đặt hàng tại shop <strong>Ismart</strong></p>\r\n        <h3>Đây là thông tin đơn hàng của bạn</h3>\r\n        <p>1. Mã đơn hàng:<a href=\'http://localhost/unitop/backend/lession/section29/ismart.com/?mod=cart&action=detail_order&order_code=DH1576342185\'> DH1576342185</a></p>\r\n        <p>2. Thời gian đặt hàng: 14-12-2019</p>\r\n        <h3>Đây là thông tin giao hàng của bạn:</h3>\r\n        <ul>\r\n            <li>1. Người nhận: đỗ đình dương</li>\r\n            <li>2. Địa chỉ nhận hàng: xã hiệp thuận, huyện phúc thọ, tỉnh hà nội, xã hiệp thuận, huyện phúc thọ, tỉnh hà nội </li>\r\n            <li>3. Số điện thoại: 0986490196</li>\r\n            <li>4. Ghi chú: xxxxxxx</li>\r\n            <li>5. Hình thức thanh toán: ship </li>\r\n            <li>6. Chi phí vận chuyển: <b>Miễn phí</b> </li>\r\n        </ul>\r\n        <h3>Đây là chi tiết đơn hàng của bạn:</h3>\r\n    </div><table style=\'width:100%;border:1px solid #333;border-collapse: collapse;\'><thead>\r\n            <tr style=\'border: 1px solid black !important;\'>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>STT</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Sản phẩm</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Đơn giá</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Số lượng</td>\r\n                <td style=\'border: 1px solid black;font-weight:bold;\'>Thành tiền</td>\r\n            </tr>\r\n        </thead><tbody><tr>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>điện thoại iphone 8 plus</td>\r\n                        <td style=\'border: 1px solid black;\'>2000000</td>\r\n                        <td style=\'border: 1px solid black;\'>1</td>\r\n                        <td style=\'border: 1px solid black;\'>2,000,000đ</td>\r\n                    </tr></tbody><tfoot style=\'background: red; color: #fff; font-weight: bold;\'>\r\n                        <tr>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\' colspan=\'3\' >Tổng đơn hàng:</td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'>1 </td>\r\n                            <td style=\'border: 1px solid black;font-weight:bold;\'><strong >2,000,000đ</strong></td>\r\n                        </tr>\r\n                    </tfoot></table><p>Chúng tôi sẽ gọi để xác nhận đơn hàng trong vòng 24h. Bạn nhớ để ý điện thoại nhé</p>\r\n    <strong>Trân trọng cảm ơn!</strong>', 1, '2000000', 'ship', '2', 'DH1576342185', '14-12-2019');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `menu_url` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT '#',
  `level` int(50) NOT NULL,
  `menu_order` int(50) NOT NULL,
  `menu_parent` varchar(100) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `menu_name`, `menu_url`, `level`, `menu_order`, `menu_parent`) VALUES
(1, 'tin tức', '#', 0, 1, '0'),
(5, 'sức khỏe', '#', 0, 5, '0'),
(6, 'y dược', '#', 1, 6, '5'),
(7, 'kotex', '#', 1, 2, '1'),
(9, 'thể thao', '#', 1, 2, '1'),
(10, 'đ&aacute; b&oacute;ng', '#', 2, 3, '9');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_page`
--

CREATE TABLE `tbl_page` (
  `id` int(11) NOT NULL,
  `page_title` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `page_slug` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `page_thumb` varchar(400) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `page_des` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `page_content` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `created_date` varchar(60) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `author` varchar(60) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `page_title`, `page_slug`, `page_thumb`, `page_des`, `page_content`, `created_date`, `author`) VALUES
(2, 'giới thiệu', 'gioi-thieu', 'upload/thumb/si-quan-1.jpg', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '06-12-2019', 'dothiquynh'),
(3, 'li&ecirc;n hệ', 'lien-he', 'upload/thumb/62025572_405299050069683_6704962493342547968_n.jpg', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '&lt;p&gt;trang thứ 3&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '13-12-2019', 'dothiquynh'),
(5, 'trang thứ 34', 'trang-thu-34', 'upload/thumb/31673628_117513959113818_6943404028051062784_n.jpg', '&lt;p&gt;trang thứ 3&lt;/p&gt;\r\n', '&lt;p&gt;trang thứ 3 4&lt;/p&gt;\r\n', '13-12-2019', 'dothiquynh'),
(6, 'trang thứ 3', 'trang-thu-3', '', '&lt;p&gt;trang thứ 3trang thứ 3&lt;/p&gt;\r\n', '&lt;p&gt;trang thứ 3trang thứ 3&lt;/p&gt;\r\n', '13-12-2019', 'dothiquynh'),
(7, 'trang thứ 3c', 'trang-thu-3c', 'upload/thumb/31673628_117513959113818_6943404028051062784_n.jpg', '&lt;p&gt;trang thứ 3&lt;/p&gt;\r\n', '&lt;p&gt;trang thứ 3&lt;/p&gt;\r\n', '13-12-2019', 'dothiquynh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_post`
--

CREATE TABLE `tbl_post` (
  `id` int(11) NOT NULL,
  `post_title` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `post_slug` varchar(400) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `post_thumb` varchar(200) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `post_des` text COLLATE utf8mb4_vietnamese_ci,
  `post_content` text COLLATE utf8mb4_vietnamese_ci,
  `created_date` varchar(30) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `cat_id` int(20) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `post_title`, `post_slug`, `post_thumb`, `post_des`, `post_content`, `created_date`, `author`, `cat_id`, `status`) VALUES
(2, 'h&ocirc;m nay l&agrave; thứ 5', 'hom-nay-la-thu-5', 'upload/thumb/61589510_405299003403021_7983866272188203008_n.jpg', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '05-12-2019', 'dothiquynh', 0, '3'),
(3, 'h&ocirc;m nay l&agrave; thứ 6', 'hom-nay-la-thu-6', 'upload/thumb/61709918_405298986736356_753907618195439616_n.jpg', '&lt;p&gt;Doanh nghiệp EU t&amp;igrave;m kiếm cơ hội hợp t&amp;aacute;c đầu tư c&amp;ocirc;ng nghệ xanh tại Việt Nam&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '05-12-2019', 'dothiquynh', 0, '3'),
(5, 'h&ocirc;m nay l&agrave; thứ 7', 'hom-nay-la-thu-7', 'upload/thumb/62025572_405299050069683_6704962493342547968_n.jpg', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '05-12-2019', 'dothiquynh', 0, '3'),
(6, 'h&ocirc;m nay l&agrave; chủ nhật', 'hom-nay-la-chu-nhat', 'upload/thumb/61589510_405299003403021_7983866272188203008_n.jpg', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '&lt;p&gt;&lt;strong&gt;Elon Musk nghĩ rằng c&amp;aacute;c c&amp;ocirc;ng ty lưới điện kh&amp;ocirc;ng c&amp;oacute; g&amp;igrave; phải lo sợ c&amp;aacute;c hệ thống m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời. Nhiều b&amp;aacute;o c&amp;aacute;o cho rằng đang c&amp;oacute; một &amp;ldquo;cuộc chiến&amp;rdquo; giữa c&amp;aacute;c c&amp;ocirc;ng ty năng lượng mặt trời v&amp;agrave; c&amp;aacute;c c&amp;ocirc;ng ty lưới điện tại Hoa Kỳ, xoay quanh một số vấn đề quan trọng.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Một trong số đ&amp;oacute; l&amp;agrave; nhiều tiểu bang c&amp;oacute; luật &amp;ldquo;mua lại điện&amp;rdquo; đỏi hỏi c&amp;aacute;c c&amp;ocirc;ng ty lưới điện phải mua lại lượng điện dư thừa m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng tạo ra bởi năng lượng mặt trời. Cũng c&amp;oacute; những lo ngại rằng người ta c&amp;oacute; thể d&amp;ugrave;ng ng&amp;oacute;i năng lượng mặt trời tự sản xuất điện năng lượng mặt trời độc lập với lưới &amp;ndash; v&amp;agrave; như vậy sẽ giảm số người phụ thuộc v&amp;agrave;o lưới điện v&amp;agrave; chuyển c&amp;aacute;c chi ph&amp;iacute; điện lưới đ&amp;oacute; cho những người kh&amp;ocirc;ng d&amp;ugrave;ng điện năng lượng mặt trời.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ph&amp;aacute;t biểu tại buổi ra mắt sản phẩm m&amp;aacute;i ng&amp;oacute;i năng lượng mặt trời v&amp;agrave; hệ thống pin dự trữ mới của Tesla v&amp;agrave; SolarCity v&amp;agrave;o thứ S&amp;aacute;u vừa rồi, Musk, người vừa l&amp;agrave; chủ tịch của cả hai c&amp;ocirc;ng ty vừa l&amp;agrave; CEO của Tesla, n&amp;oacute;i về l&amp;yacute; do tại sao tầm nh&amp;igrave;n của &amp;ocirc;ng ấy về điện năng lượng mặt trời tại Mỹ s&amp;acirc;u xa hơn sẽ c&amp;oacute; nhiều việc cho c&amp;aacute;c c&amp;ocirc;ng lưới điện chứ kh&amp;ocirc;ng phải &amp;iacute;t hơn&lt;/p&gt;\r\n', '15-12-2019', 'dothiquynh', 14, '3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_post_cat`
--

CREATE TABLE `tbl_post_cat` (
  `cat_id` int(20) NOT NULL,
  `cat_title` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `level` int(20) NOT NULL,
  `parent_id` int(20) NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_post_cat`
--

INSERT INTO `tbl_post_cat` (`cat_id`, `cat_title`, `level`, `parent_id`, `url`) VALUES
(13, 'tin tức', 0, 0, 'tin-tuc'),
(14, 'thể thao', 1, 13, 'the-thao'),
(15, 'b&oacute;ng đ&aacute;', 1, 14, 'bong-da'),
(16, 'sức khỏe', 0, 0, 'suc-khoe'),
(17, 'y học', 1, 16, 'y-hoc'),
(18, 'thế giới', 0, 0, 'the-gioi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `product_title` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `product_slug` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `product_thumb` varchar(300) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `product_des` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `product_content` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `product_status` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `price` int(100) NOT NULL,
  `old_price` int(100) DEFAULT NULL,
  `cat_id` int(60) NOT NULL,
  `author` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `created_date` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `product_title`, `product_slug`, `product_thumb`, `product_des`, `product_content`, `product_status`, `price`, `old_price`, `cat_id`, `author`, `created_date`) VALUES
(2, 'điện thoại iphone 8 plus', 'dien-thoai-iphone-8-plus', 'upload/thumb/dien-thoai.jpg', '&lt;p&gt;M&amp;ocirc; tả ngắn điện thoại iphone 8 plus&lt;/p&gt;\r\n', '&lt;p&gt;Nội dung&amp;nbsp;điện thoại iphone 8 plus&lt;/p&gt;\r\n', '3', 2000000, 3000000, 20, 'dothiquynh', '06-12-2019'),
(3, 'điện thoại iphone 9 plus', 'dien-thoai-iphone-9-plus', 'upload/thumb/dien-thoai.jpg', '&lt;p&gt;M&amp;ocirc; tả ngắn điện thoại iphone 8 plus&lt;/p&gt;\r\n', '&lt;p&gt;Nội dung&amp;nbsp;điện thoại iphone 8 plus&lt;/p&gt;\r\n', '3', 6000000, 7000000, 20, 'dothiquynh', '06-12-2019'),
(5, 'laptop dell latitude d630', 'laptop-dell-latitude-d630', 'upload/thumb/gm-v2.png', '&lt;p&gt;laptop dell latitude d630&lt;/p&gt;\r\n', '&lt;p&gt;laptop dell latitude d630&lt;/p&gt;\r\n\r\n&lt;p&gt;laptop dell latitude d630&lt;/p&gt;\r\n', '3', 2000000, 3000000, 22, 'dothiquynh', '08-12-2019'),
(6, 'laptop dell latitude d730', 'laptop-dell-latitude-d730', 'upload/thumb/gm-v2.png', '&lt;p&gt;laptop dell latitude d730&lt;/p&gt;\r\n', '&lt;p&gt;laptop dell latitude d730&lt;/p&gt;\r\n\r\n&lt;p&gt;laptop dell latitude d730&lt;/p&gt;\r\n', '3', 4000000, 5000000, 22, 'dothiquynh', '08-12-2019'),
(7, 'laptop dell m4800', 'laptop-dell-m4800', 'upload/thumb/gm-v2.png', '&lt;p&gt;laptop dell m4800&lt;/p&gt;\r\n', '&lt;p&gt;laptop dell m4800&lt;/p&gt;\r\n\r\n&lt;p&gt;laptop dell m4800&lt;/p&gt;\r\n', '2', 8000000, 9000000, 22, 'dothiquynh', '09-12-2019'),
(12, 'Samsung galaxy s7', 'samsung-galaxy-s7', 'upload/thumb_product/dien-thoai (1).jpg', '&lt;p&gt;Samsung galaxy s7&lt;/p&gt;\r\n', '&lt;p&gt;Samsung galaxy s7&lt;/p&gt;\r\n', '3', 100000000, 5220000, 21, 'dothiquynh', '14-12-2019'),
(13, 'Samsung galaxy s8', 'samsung-galaxy-s8', 'upload/thumb_product/dien-thoai (1).jpg', '&lt;p&gt;Samsung galaxy s7Samsung galaxy s8&lt;/p&gt;\r\n', '&lt;p&gt;Samsung galaxy s7Samsung galaxy s8&lt;/p&gt;\r\n', '3', 100000, 5220000, 21, 'dothiquynh', '14-12-2019');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product_cat`
--

CREATE TABLE `tbl_product_cat` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `level` int(100) NOT NULL,
  `cat_order` int(50) DEFAULT NULL,
  `cat_parent` varchar(100) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `url` varchar(300) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `showhome` enum('1','0') COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product_cat`
--

INSERT INTO `tbl_product_cat` (`cat_id`, `cat_title`, `level`, `cat_order`, `cat_parent`, `url`, `showhome`) VALUES
(1, 'điện thoại', 0, 1, '0', 'dien-thoai', '1'),
(2, 'laptop', 0, 3, '0', 'laptop', '1'),
(5, 'm&aacute;y t&iacute;nh bảng', 1, 2, '1', 'may-tinh-bang', '1'),
(20, 'apple', 1, 2, '1', 'apple', '1'),
(21, 'samsung', 1, 2, '1', 'samsung', '1'),
(22, 'laptop dell', 1, 3, '2', 'laptop-dell', '1'),
(23, 'laptop hp', 1, 3, '2', 'laptop-hp', '1'),
(24, 'Phụ kiện điện thoại', 0, 4, '0', 'phu-kien-dien-thoai', '0'),
(25, 'dell latitude', 2, 0, '22', 'dell-latitude', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_slide`
--

CREATE TABLE `tbl_slide` (
  `id` int(11) NOT NULL,
  `slide_title` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `slide_img` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `slide_des` text COLLATE utf8mb4_vietnamese_ci,
  `slide_url` varchar(200) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `slide_order` int(50) NOT NULL,
  `slide_status` int(30) NOT NULL,
  `created_date` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_slide`
--

INSERT INTO `tbl_slide` (`id`, `slide_title`, `slide_img`, `slide_des`, `slide_url`, `slide_order`, `slide_status`, `created_date`, `author`) VALUES
(3, 'slide1', 'upload/thumb/anh-bia-tai-lieu-on-thi-pd1.jpg', '&lt;p&gt;slide1&lt;/p&gt;\r\n', 'https://www.facebook.com/', 1, 0, '15-12-2019', 'dothiquynh'),
(4, 'slide2', 'upload/thumb/slider-02.png', '&lt;p&gt;slide2&lt;/p&gt;\r\n', '#', 2, 1, '08-12-2019', 'dothiquynh'),
(5, 'slide3', 'upload/thumb/slider-03.png', '&lt;p&gt;slide3&lt;/p&gt;\r\n', '#', 3, 1, '08-12-2019', 'dothiquynh'),
(6, 'slide4', 'upload/thumb/slider-01.png', '&lt;p&gt;slide4&lt;/p&gt;\r\n', '#', 4, 1, '08-12-2019', 'dothiquynh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `phone_number` varchar(13) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `created_date` varchar(20) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `who_create` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `address` text COLLATE utf8mb4_vietnamese_ci,
  `password` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `role` enum('1','2','3') COLLATE utf8mb4_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `fullname`, `username`, `email`, `phone_number`, `created_date`, `who_create`, `address`, `password`, `role`) VALUES
(2, 'đỗ quỳnh', 'admin', 'dodinhduongsmilepd@gmail.com', '0986490195', '22/10/2019', 'dodinhduong', 'x&atilde; hiệp thuận, huyện ph&uacute;c thọ, tỉnh h&agrave; nội\r\nx&atilde; hiệp thuận, huyện ph&uacute;c thọ, tỉnh h&agrave; nội', 'e10adc3949ba59abbe56e057f20f883e', '1'),
(6, '', 'dodinhduong', 'dodinhduongsmilepdq@gmail.com', '', '12-12-2019', 'dothiquynh', '', 'e10adc3949ba59abbe56e057f20f883e', '1'),
(8, '', 'quaphuong', 'quaphuong@gmail.com', '', '12-12-2019', 'dothiquynh', '', '7eac8e782473ac6d3423ce41ff0c46bd', '2');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_block`
--
ALTER TABLE `tbl_block`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_checkout`
--
ALTER TABLE `tbl_checkout`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_page`
--
ALTER TABLE `tbl_page`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_post_cat`
--
ALTER TABLE `tbl_post_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_product_cat`
--
ALTER TABLE `tbl_product_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `tbl_slide`
--
ALTER TABLE `tbl_slide`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_block`
--
ALTER TABLE `tbl_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_checkout`
--
ALTER TABLE `tbl_checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `tbl_page`
--
ALTER TABLE `tbl_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_post_cat`
--
ALTER TABLE `tbl_post_cat`
  MODIFY `cat_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbl_product_cat`
--
ALTER TABLE `tbl_product_cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `tbl_slide`
--
ALTER TABLE `tbl_slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
