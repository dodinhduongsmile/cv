<?php
get_header();
?>
<script src="public/js/customs.js" type="text/javascript"></script>
<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">SỬA Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                	<?php
                            if(!empty($success["ok"])){
                                echo "<p class='alert'>".$success['ok']."</p>";
                            }
                        ?>
                    <form method="POST">
                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo $slide_item['slide_title'];  ?>">
<?php form_error('title'); ?>
                        <label for="title">Link</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $slide_item['slide_url'];  ?>">

                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo $slide_item['slide_des'];  ?></textarea>

                        <label for="title">Thứ tự</label>
                        <input type="text" name="num_order" id="num-order" value="<?php echo $slide_item['slide_order'];  ?>">
<?php form_error('num_order'); ?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="file" data-uri="upload_single.php"><br/><br/>
                            <input id="thumbnail_url" type ="hidden" name="thumbnail_url" value="<?php echo $slide_item['slide_img'];  ?>" />
                            <?php form_error('thumbnail_url'); ?>
                            <input type="submit" name="Upload" value="Upload" id="upload_single_bt">
                            <div id="show_list_file" >
                                <img src="<?php echo $slide_item['slide_img'];  ?>" alt="">
                            </div>

                        </div>
                        <label>Trạng thái</label>
                        <select name="status">
                            <option value=""><?php echo $slide_item['slide_status'];  ?></option>
                            <option value="0">Chờ duyệt</option>
                            <option value="1">Công khai</option>
                        </select>
                        <button type="submit" name="btn_submit" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>