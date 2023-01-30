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
                    <h3 id="index" class="fl-left">Chỉnh sửa sản phẩm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                   <?php form_success('ok'); ?>
                    <form method="POST" enctype="multipart/form-data" action="">
                        <label for="title">Tên sản phẩm</label>
                        <input type="text" name="title" id="title" value="<?php echo $product_item['product_title']; ?>" onkeyup="ChangeToSlug();">
                        <?php form_error('title'); ?>

                        <label for="title">URL sản phẩm ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $product_item['product_slug']; ?>">
                        <?php form_error('slug'); ?>

                        <label for="price">giá sản phẩm(đã sale)</label>
                        <input type="number" name="price" id="price" value="<?php echo $product_item['price']; ?>">
                        <?php form_error('price'); ?>
                        <label for="price">giá gốc sản phẩm</label>
                        <input type="number" name="old_price" id="price" value="<?php echo $product_item['old_price']; ?>">

                        <label for="desc">Mô tả sản phẩm</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo $product_item['product_des']; ?></textarea>
                        <label for="desc">Nội dung sản phẩm</label>
                        <textarea name="content" id="desc" class="ckeditor"><?php echo $product_item['product_content']; ?></textarea>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="file" data-uri="?mod=product&controller=index&action=upload"><br/><br/>
                            <input id="thumbnail_url" type ="hidden" name="thumbnail_url" value="<?php echo $product_item['product_thumb']; ?>" />
                            <input type="submit" name="Upload" value="Upload" id="upload_single_bt">
                            <div id="show_list_file" >
                                <img src="<?php echo $product_item['product_thumb']; ?>" alt="">
                            </div>
                        </div>
                        <label>Danh mục</label>
                        <select name="parent-Cat">
                            <option value="">-- Chọn danh mục --</option>
                            
                            <?php
                            if(!empty($list_product_cat)){
                                foreach($list_product_cat as $item){
                            
                            ?>
                            <option value="<?php echo $item['cat_id']; ?>" <?php if($product_item["cat_id"] == $item['cat_id']){echo "selected ='selected'";} ?>><?php echo str_repeat("--",$item["level"])." ".$item['cat_title']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label>Trạng thái</label>
                        <select name="product_status">
                            <option value="3" <?php if($product_item['product_status'] == 3){echo "selected = 'selected'";}  ?>>còn hàng</option>
                            <option value="2" <?php if($product_item['product_status'] == 2){echo "selected = 'selected'";}  ?>>hết hàng</option>
                        </select>
                        <button type="submit" name="btn_submit" id="btn-submit">LƯU</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>