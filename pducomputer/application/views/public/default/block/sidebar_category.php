
<?php 
    $datapost = getDataAll(["is_status"=>1],'post','id,title,thumbnail,slug,description','RANDOM','',6);
    $home_left = getMenuParent(0,0);
    if($this->_method == "category" || $this->_method == "product_type"){$classsidebar = "nav-dropdown";}else{$classsidebar = "mul-dropdown";}
?>

    <div class="sidebar">
        <h2 class="title_sidebar">Tất Cả Danh mục</h2>
        <ul class="menu-aside">
        <?php if (!empty($home_left)) foreach ($home_left as $value) : 
              $child_home_left = getMenuParent($value->id,0);
        ?>
          <li class="<?php echo !empty($child_home_left)? 'has-dropdown' : ''; ?>">
            <h3><a href="<?php echo base_url($value->link); ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a></h3>

        <?php if (!empty($child_home_left)): ?>
            <ul class="<?php echo $classsidebar; ?> nav-aside">
          <?php foreach ($child_home_left as $value1): 
              $child_home_left2 = getMenuParent($value1->id,0);
          ?>     
              <li class="<?php echo !empty($child_home_left2)? 'has-dropdown' : ''; ?>">
                 <h3><a href="<?php echo base_url($value1->link); ?>" title="<?php echo $value1->title; ?>"><?php echo $value1->title; ?></a></h3>
           <?php if (!empty($child_home_left2)): ?>
                <ul class="<?php echo $classsidebar; ?> nav-aside">
                  <?php foreach ($child_home_left2 as $value2): ?>
                  <h3><a href="<?php echo base_url($value2->link); ?>" title="<?php echo $value2->title; ?>"><?php echo $value2->title; ?></a></h3>
                  <?php endforeach; ?>
                </ul>
            <?php endif; ?>
              </li>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
    </div>

<div class="new_highlight">
   <h3>Bài viết nổi bật <?php echo date('Y', time()); ?></h3>
   <ul>
    <?php if(!empty($datapost)) foreach($datapost as $item): ?>
      <li class="clearfix">
         <a href="<?php echo get_url_post($item); ?>"><?php echo getThumbnail($item,230,230); ?></a>
         <h2><a href="<?php echo get_url_post($item); ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h2>
      </li>
      
      <?php endforeach; ?>
      <div class="viewmore"><a href="<?php echo base_url('ac103_tin-tuc.html'); ?>">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>
   </ul>
</div>

<script>
  $('.has-dropdown').on('click', function() {
        var $this = $(this);
        $this.children('ul').slideToggle();
        $this.toggleClass('is-active').siblings().removeClass('is-active')
        .end() 
        .siblings().children('ul').slideUp(); 
        
    });

    $('.has-dropdown').on('click', '*', function(e) {
        e.stopPropagation();
    });
</script>
<style>
    /* =================== menu dọc *hover hay click đều như cái menu CHÍNH vì nó cùng class* ============================*/
.has-dropdown {
    position: relative;
    cursor: pointer;
}
.has-dropdown:after {
    padding-top: 0px;
    font-size: 24px;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    content: "+";
    color: #fff;
    line-height: 32px;
    width: 57px;
    height: 37px;
    text-align: center;
}
.nav-dropdown {
    display: none;
}
.nav-dropdown .nav-dropdown,.mul-dropdown .mul-dropdown {
    background-color: #e2dfdf;
    border-left: 1px solid #12d4c9;
}

.sidebar .title_sidebar {
    background: #55acee;
    color: #fff;
    font-size: 16px;
    position: relative;
    padding: 15px 14px;
    text-transform: uppercase;
    cursor: pointer;
    text-align: center;
    font-weight: 700;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
    box-shadow: 0 1px 1px 0 rgb(0 0 0 / 14%);
}

.sidebar .menu-aside {
    border: 1px solid #ccc;
    padding: 0;
    margin:0;
}

.sidebar .menu-aside li {

    font-size: 16px;
    border-bottom: 1px dashed #ccc;
    list-style:none;
}

.sidebar .menu-aside li a {
    display: inline-block;
    color: #333;
    padding: 7.5px 10px 7.5px 13px;
    margin-right: 10px;
}

.sidebar .menu-aside li:last-child {
    border-bottom: 0
}

.sidebar .menu-aside li:hover>h3 a,.sidebar .menu-aside li.is-active> h3 a {
    color: #0098da;
}
.menu-aside .has-dropdown:after{
  content: "\f105";
  font: normal normal normal 14px/1 FontAwesome;
  line-height: 40px;
  color: #000;
  font-weight: bold;
}
.menu-aside .has-dropdown.is-active:after {
    content: "\f107";
}

@media (max-width: 991px) {
  .nav-aside{
    border: 0;
    border-top: 1px solid #ccc;
  }
  .sidebar .menu-aside li.has-dropdown.is-active{
    border-bottom: 1px solid #ccc;
  }
  .sidebar .menu-aside .nav-aside li a{
    padding-left: 20px;
  }
  .sidebar .menu-aside > li.has-dropdown > a{
    display: inline-block;
  }
}
@media (min-width: 992px){
 
.nav-dropdown {
    left: 0px;
    display: block;
    opacity: 0;
    position: absolute;
    top: 100%;
    width: 215px;
    margin: 0;
    background-color: transparent;
    border-radius: 0px;
    box-shadow: 0 0 4px hsla(0, 0%, 0%, 0.15);
    visibility: hidden;
    -webkit-transition: visibility 0s linear 0.25s, opacity 0.25s linear;
    transition: visibility 0s linear 0.25s, opacity 0.25s linear;
}
 .nav-dropdown {
    -webkit-transform: scaleY(0);
    transform: scaleY(0);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
    -webkit-transition-property: transform;
    transition-property: transform;
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
  .has-dropdown:hover > .nav-dropdown {
    -webkit-transform: scaleY(1) !important;
    transform: scaleY(1) !important;
    visibility: visible;
    opacity: 1;
    -webkit-transition-delay: 0s;
    transition-delay: 0s;
}
}
.nav-aside {
    left: 100%;
    top: -1px;
    border: 1px solid #b4b3d4;
    z-index: 999;
    margin: 0;
    background: #fff;
}
.has-dropdown .mul-dropdown{
    display: none;
}
li.has-dropdown.is-active ul.mul-dropdown {
    padding-left: 10px;
}

/* ================================== end menu dọc hover và click **=================================*/

</style>