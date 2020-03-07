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
                    <h3 id="index" class="fl-left">Chỉnh sửa danh mục</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                     <?php form_success('ok'); ?>
                    <form method="POST" enctype="multipart/form-data" action="">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo $post_cat['cat_title']; ?>" onkeyup="ChangeToSlug();">
                        <?php form_error('title'); ?>

                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $post_cat['url']; ?>">
                        <?php form_error('slug'); ?>

                        <label>Danh mục id cha</label>
                        <select name="parent_Cat">
                            <option value="">-- Chọn danh mục cha --</option>
                            
                            <?php
                            if(!empty($list_post_cat)){
                                foreach($list_post_cat as $item){
                            
                            ?>
                            <option value="<?php echo $item['cat_id']; ?>" <?php if($item['cat_id'] == $post_cat['parent_id']){echo "selected = 'selected'";} ?>><?php echo str_repeat("--",$item["level"])." ".$item['cat_title']; ?></option>
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