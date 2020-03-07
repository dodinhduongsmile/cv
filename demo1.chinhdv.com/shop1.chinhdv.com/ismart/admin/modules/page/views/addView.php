<?php
get_header();
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
<script src="public/js/customs.js" type="text/javascript"></script>
<script src="public/js/slug.js" type="text/javascript"></script>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm mới trang</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php form_success('ok'); ?>
                    <form method="POST" enctype="multipart/form-data" action="">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title'); ?>" onkeyup="ChangeToSlug();">
                        <?php form_error('title'); ?>

                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" <?php echo set_value('slug'); ?>>
                        <?php form_error('slug'); ?>

                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo set_value('desc'); ?></textarea>
                        <label for="desc">Nội dung bài đăng</label>
                        <textarea name="content" id="desc" class="ckeditor"><?php echo set_value('content'); ?></textarea>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="file" data-uri="?mod=post&controller=index&action=upload"><br/><br/>
                            <input id="thumbnail_url" type ="hidden" name="thumbnail_url" value="<?php echo set_value('thumb'); ?>" />
                            <input type="submit" name="Upload" value="Upload" id="upload_single_bt">
                            <div id="show_list_file" >
                                <img src="<?php echo set_value('thumb'); ?>" alt="">
                            </div>
                        </div>

                        <button type="submit" name="btn_submit" id="btn-submit">Thêm mới</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>