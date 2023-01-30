<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm khối</h3>
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
                        <label for="title">Tên khối</label>
                        <input type="text" name="title" id="title" value="<?php echo $block_item['name_block']; ?>">
                        <?php form_error('title'); ?>
                        <label for="title">Mã khối</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $block_item['code_block']; ?>">
                        <?php form_error('slug'); ?>
                        <label for="desc">Nội dung khối</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo $block_item['content_block']; ?></textarea>
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