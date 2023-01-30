<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <div style="margin: 0;font-family: arial;background: #e7e3e3;">
        <table style="margin: auto;padding:0 15px;max-width: 90%;border-spacing: 0;font-size: 14px;background: #fff;">
            <tr>
                <td style="background-color: #dcdfe0;padding: 19px 18px 18px 18px;text-align: center;">
                    <a href="<?php echo base_url(); ?>" target="_blank">
                      <img style="width: 150px;height: auto;" src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : ''; ?>" />
                      </a>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px 15px 0px 15px;">
                    <h2 style="color: #202020;font-size: 30px;font-weight: bold;">Xin chào <span style="color: #fc621a"><?php echo $order_info['full_name']; ?></span></h2>
                    <p style="font-size: 20px;color: #202020;line-height: 1.8; border-bottom: solid 1px #6d6d70;margin-bottom: 17px;padding-bottom: 20px;">
                        Cảm ơn quý khách đã lựa chọn dịch vụ của <span style="color: #fc621a"><?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?>!</span>
                        <br>Chúng tôi xin thông báo chi tiết đơn hàng của quý khách đặt tại <?php echo $_SERVER['HTTP_HOST']; ?> như sau:</p>
                </td>
            </tr>
            <tr>
                <td style="padding: 0 15px 15px 15px;">
                    <table style="width: 100%;border-spacing: 0;border-collapse: collapse">
                        <tr>
                            <td>
                                <table style="width: 100%;border-spacing: 0;border-collapse: collapse;margin-bottom: -3px;">
                                    <tr>
                                        <td style="background: #f2f2f2;font-size: 22px;color: #202020;padding: 12px 16px;border: solid 1px #dedede;"><strong>Mã đơn hàng: </strong> <span style="color: #fc621a"><?php echo $order_info['code'] ?></span> - <a href="<?php echo base_url("cart/detail_order/").$order_info['code']; ?>" target="_blank">Xem chi tiết đơn hàng</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width: 100%;font-size: 15px;border-spacing: 0;border-collapse: collapse;">
                                    <tr style="color: #6d6d70;font-weight: bold;">
                                        <td style="border: solid 1px #dedede;padding: 10px 10px;" colspan="2">Thông tin đơn hàng</td>
                                        <td style="border: solid 1px #dedede;padding: 10px 10px;">Số lượng</td>
                                        <td style="border: solid 1px #dedede;padding: 10px 10px;">Đơn giá</td>
                                    </tr>
                                    <?php if (!empty($order_detail)) foreach ($order_detail as $key => $value) : 
                                        $data_product = getByIdProduct($value['id']);
                                    ?>
                                        <tr style="vertical-align: top">
                                            <td style="padding: 16px 10px;border: solid 1px #dedede;border-right: none;">
                                                <img style="max-width: 80px;height: auto;max-height: 80px;" src="<?php echo getImageThumb($data_product->thumbnail,80,80) ?>" alt="" title="" />
                                            </td>
                                            <td style="padding: 16px 10px;border: solid 1px #dedede;line-height: 1.5;color: #292929;border-left: none;">
                                                <h3 style="margin: 0;font-size: 15px;"><a style="color: #292929;text-decoration: none;" href="<?php echo get_url_product($data_product); ?>" title=""><?php echo $data_product->title ?></a></h3>
                                            </td>
                                            <td style="padding: 16px 10px;border: solid 1px #dedede;color: #292929"><strong><?php echo $value['qty'] ?></strong></td>
                                            <td style="padding: 16px 10px;border: solid 1px #dedede;color: #292929"><?php echo number_format($value['price'],0,'','.') ?>vnđ/1sp</td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="5" style="padding: 5px 10px 2px 10px;border: solid 1px #dedede;text-align: right;font-size: 15px;">
                                            <p style="margin-top: 0;margin-bottom: 10px; font-weight: bold;color:#292929;font-size: 18px;">Phí ship: <span style="display: inline-block;width: 150px;color: #f26522"><?php echo number_format($order_info['priceship'],0,'','.') ?>đ</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding: 5px 10px 2px 10px;border: solid 1px #dedede;text-align: right;font-size: 15px;">
                                            <p style="margin-top: 0;margin-bottom: 10px; font-weight: bold;color:#292929;font-size: 18px;">voucher giảm giá: <span style="display: inline-block;width: 150px;color: #f26522"><?php echo number_format($order_info['coupon'],0,'','.') ?>đ</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding: 5px 10px 2px 10px;border: solid 1px #dedede;text-align: right;font-size: 15px;">
                                            <p style="margin-top: 0;margin-bottom: 10px; font-weight: bold;color:#292929;font-size: 18px;">Tổng cộng: <span style="display: inline-block;width: 150px;color: #f26522"><?php echo number_format(($order_info['total_amount'] + $order_info['priceship'] - $order_info['coupon']),0,'','.') ?>đ</span></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding: 0 15px 18px 15px;width: 100%;">
                    <table style="padding:0 15px;width:100%;max-width: 100%; font-size: 15px;color: #292929;border: solid 1px #dedede;padding: 15px 18px;background: #f2f2f2;">
                        <tr>
                            <td style="border-right: solid 1px #dedede;width: 50%;">
                                <p style="margin-top: 0;margin-bottom: 12px;"><strong>Hình thức thanh toán</strong></p>
                                <p style="margin-top: 0;margin-bottom: 12px;">• <span style="color: #777777;">
                                    <?php if ($order_info['method'] == 1): ?>
                                        Thanh toán khi nhận hàng (COD)
                                    <?php elseif($order_info['method'] == 2): ?>
                                        Chuyển khoản, quý khách vui lòng chuyển khoản theo thông tin sau:
                                        <?php echo $this->_settings_home->banknumber;
                                        echo "<strong>Nội dung:</strong> Thanh toán đơn hàng {$order_info['code']}";
                                        ?>
                                    <?php else: ?>
                                        Thanh toán bằng (điểm COIN). Số COIN này tạm thời bị khóa trên tài khoản của bạn cho đến khi chúng tôi giao hàng thành công.
                                    <?php endif; ?>
                            </span></p>
                            </td>
                            <td style="width: 50%;padding-left: 25px;">
                                <p style="margin-top: 0;margin-bottom: 12px;"><strong>Đơn hàng sẽ được giao đến</strong></p>
                                <p style="margin-top: 0;margin-bottom: 0px;line-height: 1.5; "><strong style="color: #777777;text-transform: uppercase;"><?php echo $order_info['full_name']; ?></strong></p>
                                <p style="margin-top: 0;margin-bottom: 0px;line-height: 1.5; color: #777777;">Địa chỉ: <?php echo $order_info['address']; ?></p>
                                <p style="margin-top: 0;margin-bottom: 0px;line-height: 1.5; color: #777777;"><strong>Điện thoại: <?php echo $order_info['phone']; ?></strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="font-size: 15px;color: #202020;padding: 10px 15px 10px 15px;background: #8dbbde;">
                    <p style="margin-top: 0; margin-bottom: 5px;color: red;"><strong>* Lưu ý:</strong></p>
                    <p style="margin-top: 0; margin-bottom: 5px;">- Vui lòng kiểm tra sản phẩm và các giấy tờ, phụ kiện, quà tặng kèm (nếu có) trước khi ký nhận.</p>
                    <p style="margin-top: 0; margin-bottom: 5px;">- Qúy khách có thể kiểm tra thông tin đơn hàng của bạn <a href="<?php echo base_url("cart/detail_order/").$order_info['code']; ?>" target="_blank">tại đây</a></p>

                    <hr>
                    <h2 style="text-align: center;">Hãy kết nối với chúng tôi.</h2>
                    <div style="text-align: center;">
                        <a href="<?php echo $this->_settings_social->twitter; ?>" target="_blank" title="twitter" style="display: inline-block;padding: 3px 5px;margin: 0 5px;">
                            <img src="https://public.bnbstatic.com/image/social/twitter-dark.png" alt="twitter" style="width: 40px;height: auto;object-fit: contain;">
                        </a>
                        <a href="<?php echo $this->_settings_social->facebook; ?>" target="_blank" title="telegram" style="display: inline-block;padding: 3px 5px;margin: 0 5px;">
                            <img src="https://public.bnbstatic.com/image/social/telegram-dark.png" alt="telegram" style="width: 40px;height: auto;object-fit: contain;">
                        </a>
                        <a href="<?php echo $this->_settings_social->facebook; ?>" target="_blank" title="facebook" style="display: inline-block;padding: 3px 5px;margin: 0 5px;">
                            <img src="https://public.bnbstatic.com/image/social/facebook-dark.png" alt="facebook" style="width: 40px;height: auto;object-fit: contain;">
                        </a>
                        <a href="<?php echo $this->_settings_social->facebook; ?>" target="_blank" title="linkedin" style="display: inline-block;padding: 3px 5px;margin: 0 5px;">
                            <img src="https://public.bnbstatic.com/image/social/linkedin-dark.png" alt="linkedin" style="width: 40px;height: auto;object-fit: contain;">
                        </a>
                        <a href="<?php echo $this->_settings_social->youtube; ?>" target="_blank" title="youtube" style="display: inline-block;padding: 3px 5px;margin: 0 5px;">
                            <img src="https://public.bnbstatic.com/image/social/youtube-dark.png" alt="youtube" style="width: 40px;height: auto;object-fit: contain;">
                        </a>
                        <a href="<?php echo $this->_settings_social->instalgram; ?>" target="_blank" title="instagram" style="display: inline-block;padding: 3px 5px;margin: 0 5px;">
                            <img src="https://public.bnbstatic.com/image/social/instagram-dark.png" alt="instagram" style="width: 40px;height: auto;object-fit: contain;">
                        </a>
                    </div>
                    <hr>
                    <div style="text-align: center;">
                      <h3 style="font-weight: bold;font-size: 19px;">Mọi vấn đề cần liên hệ, Quý khách xin liên hệ với chúng tôi</h3>
                      <h2 style="font-weight: bold;font-size: 19px;"><?php echo !empty($this->_settings->title) ? $this->_settings->title : 'Công ty PDUCOMPUTER'; ?></h2>
                      <p style="text-align: left;color: #1077c5;"><strong>Địa chỉ:</strong> <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?></p>
                      <p style="text-align: left;color: #1077c5;"><strong>Điện thoại :</strong>  <?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : '0397.152.197'; ?>  - Hotline: <?php echo !empty($this->_settings->meta_hotline_hn) ? $this->_settings->meta_hotline_hn : '0397.152.197'; ?></p>
                      <p style="text-align: left;color: #1077c5;"><strong>Email:</strong> <?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></p>
                      <p style="text-align: left;color: #1077c5;"><strong>Website:</strong> <?php echo !empty($this->_settings->domain) ? $this->_settings->domain : $_SERVER['HTTP_HOST']; ?></p>
                      <div><strong>Xin chân thành cảm ơn!</strong></div>
                      <div>===o0o===</div>
                    </div>
                    <hr>
                
                </td>
            </tr>
            <tr>
                <td style="background-color:#9fc5e2;background-size:cover;padding:25px 0 0 0">
                    <table style="width: 100%;color: #fff; border-bottom: solid 1px rgba(255,255,255,.3);padding:0 18px 10px 18px;">
                        <tr>
                            <td>
                                <a style="color: #fff;text-decoration: none;" href="<?php echo base_url('cua-hang.html') ?>" title="hệ thống cửa hàng" target="_blank">* Hệ thống cửa hàng của <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?></a>
                                
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-block;text-align: left;">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%;color: #fff;padding: 10px 18px;">
                        <tr>
                            <td>
                                <a href="<?php echo base_url(); ?>" target="_blank">
                                  <img style="vertical-align: middle;display: inline-block; width: 100px;object-fit: contain;" src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : ''; ?>" />
                                </a>
                            </td>
                            <td style="text-align: right">© <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> 2017 - <?php echo date('Y', time()); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
        
    </body>
</html>
