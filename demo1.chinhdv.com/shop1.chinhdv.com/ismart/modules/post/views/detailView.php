<?php
get_header();
echo $_GET['id'];
?>

<div id="main-content-wp" class="clearfix detail-blog-post">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url();?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("post/{$post['post_slug']}-{$post['id']}"); ?>" title=""><?php echo $post['post_title']; ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title"><?php echo $post['post_title']; ?></h3>
                </div>
                <div class="section-detail">
                    <span class="create-date"><?php echo $post['created_date']; ?></span>
                    <div class="detail">
                        <?php echo html_entity_decode($post['post_content']); ?>
                    </div>
                </div>
            </div>
            <div class="section" id="social-wp">
                <div class="section-detail">
                    <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    <div class="g-plusone-wp">
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                    <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            
            <?php
                get_sidebar("selling");
             ?>
        </div>
    </div>
</div>
<?php
get_footer();
?>