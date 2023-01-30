<?php
get_header();
// show_array($list_product_cat);
?>

<script src="public/js/slug.js" type="text/javascript"></script>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm danh mục mới</h3>
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
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                        <?php form_error('slug'); ?>
                        <label for="price">Vị trí(thứ tự)</label>
                        <input type="number" name="cat_order" id="price" value="<?php echo set_value('cat_order'); ?>">
                        <label>Danh mục cha</label>
                        <select name="parent_Cat">
                            <option value="0">-- Chọn danh mục --</option>
                            
                            <?php
                            if(!empty($list_product_cat)){
                                foreach($list_product_cat as $item){
                            
                            ?>
                            <option value="<?php echo $item['cat_id']; ?>"><?php echo str_repeat("--",$item["level"])." ".$item['cat_title']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
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