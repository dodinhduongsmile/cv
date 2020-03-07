<?php
get_header();
?>

<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url(); ?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("post"); ?>" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                        if(!empty($list_post)){
                            foreach($list_post as $item){
                        ?>
                            <li class="clearfix">
                            <a href="<?php echo base_url("post/{$item['post_slug']}-{$item['id']}"); ?>" title="" class="thumb fl-left">
                                <img src="<?php echo base_url("admin/{$item['post_thumb']}"); ?>" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="<?php echo base_url("post/{$item['post_slug']}-{$item['id']}"); ?>" title="" class="title"><?php echo $item['post_title']; ?></a>
                                <span class="create-date"><?php echo $item['created_date']; ?></span>
                                <p class="desc"><?php echo html_entity_decode($item['post_des']); ?></p>
                            </div>
                        </li>
                        <?php
                            }
                        }
                        ?>
                        
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php
                        echo $get_pagging;
                    ?>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <?php
                get_sidebar('selling');
            ?>
            
        </div>
    </div>
</div>
<?php
get_footer();
?>