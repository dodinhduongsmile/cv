<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
        body {
            font-family: Arial, Verdana, Helvetica, sans-serif;
            font-size: 16px;
        }
        hr{background: #55acee;}
    </style>
</head>
<body>
    <div style="box-sizing: border-box;font-family: arial;background: #e3e0e0;font-size: 16px;">
        <table style="box-sizing: border-box;width: 75%;margin: 0 auto;padding: 20px 30px;background: #fff;font-size: 16px;">
            <tr style="text-align: center;">
                <td>
                    <a href="<?php echo base_url(); ?>" target="_blank" style="display: block;border-bottom: 1px solid #55acee;">
                      <img style="width: 150px;height: auto;margin: 10px 0;" src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : ''; ?>" />
                      </a>
                </td>
            </tr>
            <tr>
                <td>
                    <h2 style="text-align: center;"><?php echo $title . @$this->_settings->title_short; ?></h2>
                    <p>Xin chào <strong style="color: #55acee;font-style: italic;"><?php echo $email; ?></strong></p>
                    <p><?php echo $content; ?> </p>
                    <p style="color: #55acee;font-style: italic;">Team support <?php echo @$this->_settings->title_short; ?> </p>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>
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
                <td>
                    <div style="text-align: center;">
                    <a href="<?php echo base_url(); ?>">
                      <img style="vertical-align: middle;display: inline-block; width: 100px;object-fit: contain;" src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : ''; ?>" />
                    </a>
                    <p>© <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> 2017 - <?php echo date('Y', time()); ?></p>
                    </div>
                </td>
                
            </tr>
        </table>
    </div>
</body>
</html>
