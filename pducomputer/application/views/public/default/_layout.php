<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    $ver = 1.43;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name='robots' content='index,follow'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta property="fb:app_id" content="279219862659309" />
    <meta property="fb:admins" content="100020293903965"/>
    <meta name="author" content="pducomputer.com"/>
    <meta name="theme-color" content="#081A48"/>
    <?php
    $title_short = !empty($this->_settings->title_short) ? $this->_settings->title_short : "PDU";
    if (!empty($SEO)): ?>
        <title><?php echo !empty($SEO['title']) ? $SEO['title'] : $SEO['meta_title']; echo " - ".$title_short; ?></title>
        <meta name="description" content="<?php echo !empty($SEO['meta_description']) ? $SEO['meta_description'] : '';echo " - ".$title_short; ?>"/>
        <meta name="keywords" content="<?php echo !empty($SEO['meta_keyword']) ? $SEO['meta_keyword'] : '';echo " - ".$title_short; ?>"/>
        <!--Meta Facebook Page Other-->
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="<?php echo !empty($SEO['meta_title']) ? $SEO['meta_title'] : '';echo " - ".$title_short; ?>"/>
        <meta property="og:description" content="<?php echo !empty($SEO['meta_description']) ? $SEO['meta_description'] : ''; echo " - ".$title_short; ?>"/>
        <meta property="og:image" content="<?php echo !empty($SEO['image']) ? $SEO['image'] : ''; ?>"/>
        <meta property="og:url" content="<?php echo !empty($SEO['url']) ? $SEO['url'] : base_url(); ?>"/>
        <!--Meta Facebook Page Other-->
        <link rel="canonical" href="<?php echo !empty($SEO['url']) ? $SEO['url'] : base_url(); ?>"/>
        <meta name="robots" content="<?php echo !empty($SEO['is_robot']) ? 'index, follow' : 'noindex,nofollow' ?>" />
        <meta name="Googlebot-News" content="<?php echo !empty($SEO['is_robot']) ? 'index, follow' : 'noindex,nofollow' ?>" />
    <?php else: ?>
        <title><?php echo isset($this->_settings->meta_title) ? $this->_settings->meta_title : ''; ?></title>
        <meta name="description" content="<?php echo !empty($this->_settings->meta_desc) ? $this->_settings->meta_desc : ''; echo " - ".$title_short;?>"/>
        <meta name="keywords" content="<?php echo !empty($this->_settings->meta_keyword) ? $this->_settings->meta_keyword : ''; echo " - ".$title_short;?>"/>
        <!--Meta Facebook Homepage-->
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="<?php echo isset($this->_settings->meta_title) ? $this->_settings->meta_title : ''; echo " - ".$title_short;?>"/>
        <meta property="og:description" content="<?php echo isset($this->_settings->meta_desc) ? $this->_settings->meta_desc : ''; echo " - ".$title_short;?>"/>
        <meta property="og:image" content="<?php echo $this->templates_assets.'images/logo.png'; ?>"/>
        <meta property="og:url" content="<?php echo base_url(); ?>"/>
        <!--Meta Facebook Homepage-->
        <link rel="canonical" href="<?php echo base_url(); ?>"/>
        <!-- <meta name="robots" content="index, follow"> -->
        <!-- <meta name="Googlebot-News" content="index, follow"> -->
    <?php endif; ?>

    <link rel="shortcut icon" href="<?php echo site_url('public/favicon.ico') ?>" />
    
    <!-- CSS ================================================== -->
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/font-awesome.css?v='.$ver; ?>"  />
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/timber.scss9d71.css?v='.$ver; ?>"  />
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/suplo-style.scss9d71.css?v='.$ver; ?>"  />
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/owl.carousel2.css?v='.$ver; ?>"  />
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/owl.theme2.css?v='.$ver; ?>"  />
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/animate9d71.css?v='.$ver; ?>"  />
        <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/style.css?v='.$ver; ?>"  />

        <!-- Header hook for plugins ================================================== -->
        <script src="<?php echo $this->templates_assets.'js/jquery.min.js?v='.$ver; ?>" type='text/javascript'></script>
        

    <script>
        var urlCurrentMenu = window.location.href,
            urlCurrent = window.location.href,
            segment = '<?php echo base_url($this->uri->segment(1)) ?>',
            base_url = '<?php echo base_url(); ?>',
            media_url = '<?php echo MEDIA_URL; ?>',
            csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name') ?>',
            csrf_token_name = '<?php echo $this->security->get_csrf_token_name() ?>',
            csrf_token_hash = '<?php echo $this->security->get_csrf_hash() ?>';
    </script>

</head>
<?php 
    if ($this->_controller == 'product' && $this->_method == 'detail') {
        $class = 'single-product';
    }elseif($this->_controller == 'home' && $this->_method == 'index'){
        $class = 'home';
    }elseif($this->_controller == 'cart' && $this->_method == 'index'){
        $class = 'cart';
    }elseif($this->_controller == 'cart' && $this->_method == 'done'){
        $class = 'done';
    }else{
        $class = '';
    }
?>
<body class="full template-index <?php echo $class; ?> ">
    <div class="preloader" style="/* display: none; */">
      <div class="wrapLoading">
        <div class="cssload-loader">
          <div class="cssload-inner cssload-one"></div>
          <div class="cssload-inner cssload-two"></div>
          <div class="cssload-inner cssload-three"></div>
        </div>
      </div>
    </div>
  <!-- Load Facebook SDK for JavaScript -->
 <!-- Load Facebook SDK for JavaScript -->
<div id='fb-root'></div>
<script>
    setTimeout(function() {
         window.fbAsyncInit = function() {
            FB.init({
              xfbml            : true,
              version          : "v8.0"
            });
          };

          (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));
    },1000);
  </script>
<!-- Your customer chat code -->
<div attribution='setup_tool' class='fb-customerchat' logged_in_greeting='Xin chào, Bạn muốn hỗ trợ gì?' logged_out_greeting='Xin chào, Bạn muốn hỗ trợ gì?' page_id='107352608058443' theme_color='#67b868'>
</div>



    <?php $this->load->view($this->template_path . '_header') ?>
    <main id="mainpdu">
        <?php echo !empty($main_content) ? $main_content : '' ?>
    </main>
    <?php $this->load->view($this->template_path . '_footer') ?>



<div id="show_success_mss" style="position: fixed; top: 150px; right: 20px;z-index: 99999"></div>
<input type="hidden" id="idcate" value="<?php echo @$oneItem->id; ?>" data-controler="<?php echo $this->_controller; ?>">

<!-- js -->
<script src="<?php echo $this->templates_assets.'js/modernizr.min9d71.js?v='.$ver; ?>" type='text/javascript'></script>
<script src="<?php echo $this->templates_assets.'js/owl.carousel2.min.js?v='.$ver; ?>" type='text/javascript'></script>
<script src="<?php echo $this->templates_assets.'js/wow.min.js?v='.$ver; ?>" type='text/javascript'></script>
<script src="<?php echo $this->templates_assets.'js/fastclick.min9d71.js';?>" type='text/javascript'></script>

<script src="<?php echo $this->templates_assets.'js/timber9d71.js?v='.$ver; ?>" type='text/javascript'></script>
<script src="<?php echo $this->templates_assets.'js/maind.js?v='.$ver; ?>" type='text/javascript'></script>
<script src="<?php echo $this->templates_assets.'js/custom.js?v='.$ver; ?>" type='text/javascript'></script>

<?php 
if ($this->_controller == 'user') {?>
<link rel='stylesheet' href="<?php echo $this->templates_assets.'css/memberpdu.css?v='.$ver; ?>"  />
<script src="<?php echo $this->templates_assets.'js/accountfe.js'; ?>" type='text/javascript'></script>
<?php
};?>
<?php 
if ($this->_controller == 'edu') {?>
<script src="<?php echo $this->templates_assets.'js/edu.js'; ?>" type='text/javascript'></script>
<?php
};?>
        <script>
        $("html, body").scrollTop(0);
        new WOW().init();
        jQuery(document).ready(function($) {
          $('.preloader').delay(500).fadeOut(500);
        })

//anti hacked
console.log("%cCảnh Báo! %cBẠN ĐANG CỐ GẮNG XÂM NHẬP HỆ THỐNG. PDU SẼ VÔ HIỆU HÓA MÁY TÍNH CỦA BẠN NẾU KHÔNG DỪNG NGAY HÀNH ĐỘNG DƠ BẨN NÀY LẠI! CẢM ƠN!","color:red;font-family:system-ui;font-size:4rem;-webkit-text-stroke: 1px black;font-weight:bold", "font-size:16px;color:black;font-weight:bold;display:block");
/*
    checkCtrl=false;//85=u,123=f12
    window.onkeydown = function(e){
        if(e.keyCode=="17"){checkCtrl=true;}
        if(e.keyCode=="123"){location.assign(location.href); return false;}
        if(checkCtrl){if(e.keyCode == "85"){location.assign(location.href);return false;} }};
    // mouse right
    window.oncontextmenu = function (){return false;}
*/
        </script>
</body>

</html>