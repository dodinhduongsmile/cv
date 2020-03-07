<?php
get_header();
// show_array($list_product_cat);
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
<!-- <script src="public/js/customs.js" type="text/javascript"></script> -->
<script src="public/js/slug.js" type="text/javascript"></script>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Sửa danh mục</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php form_success('ok'); ?>
                    <form method="POST" enctype="multipart/form-data" action="">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo $product_cat_item["cat_title"]; ?>" onkeyup="ChangeToSlug();">
                        <?php form_error('title'); ?>

                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" readonly="readonly" name="slug" id="slug" value="<?php echo $product_cat_item["url"]; ?>">
                        <?php form_error('slug'); ?>
                        <label for="price">Vị trí(thứ tự)</label>
                        <input type="number" name="cat_order" id="price" value="<?php echo $product_cat_item["cat_order"]; ?>">
                        <label>Danh mục cha</label>
                        <select name="parent_Cat">
                            <option value="0">-- Chọn danh mục --</option>
                            
                            <?php
                            if(!empty($list_product_cat)){
                                foreach($list_product_cat as $item){
                            
                            ?>
                            <option value="<?php echo $item['cat_id']; ?>" <?php if($product_cat_item['cat_parent'] == $item['cat_id']){echo "selected='selected'";} ?>><?php echo str_repeat("--",$item["level"])." ".$item['cat_title']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <?php
                        if($product_cat_item['level'] == 0){
                        ?>
                            <label>ẩn/Hiện trang chủ</label>
                            <select name="showhome">
                                <option value="1" <?php if($product_cat_item['showhome'] == 1){echo "selected='selected'";} ?>>HIỆN</option>
                                <option value="0" <?php if($product_cat_item['showhome'] == 0){echo "selected='selected'";} ?>>ẨN</option>
                            </select>
                        <?php
                        } 
                         ?>
                        
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