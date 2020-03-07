<?php 
get_header();
?>
<div id="main-content-wp" class="add-cat-page menu-page">
    <div class="wrap clearfix">
        <div class="section" id="title-page">
            <div class="clearfix">
                <!-- <a href="?mod=block&action=addmenu" title="" id="add-new" class="fl-left">Thêm mới</a> -->
                <h3 id="index" class="fl-left">Menu</h3>
            </div>
        </div>
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section-detail clearfix">
                <div id="list-menu" class="fl-left">
                     <?php form_success('ok'); ?>
                     
                    <form  method="POST" action="">
                        <div class="form-group">
                            <label for="title">Tên menu</label>
                            <input type="text" name="title" id="title" value="<?php echo $menu_item["menu_name"]; ?>">
                        </div>
                         <?php form_error('title'); ?>
                        <div class="form-group">
                            <label for="url-static">Đường dẫn tĩnh</label>
                            <input type="text" name="url_static" id="url-static" value="<?php echo $menu_item["menu_url"]; ?>">
                            <p>Chuỗi đường dẫn tĩnh cho menu</p>
                        </div>
                         <?php form_error('url_static'); ?>

                        <div class="form-group clearfix">
                            <label>Danh mục cha</label>
                            <select name="parent_id">
                                <option value="0">-- Chọn --</option>
                                <?php
                                    
                                    foreach($list_menu as $itemm){
                                    
                                ?>
                                    <option value="<?php echo $itemm['id']; ?>" <?php if($menu_item['menu_parent'] == $itemm['id']){echo "selected='selected'";} ?>><?php echo str_repeat("--",$itemm["level"])." ". $itemm['menu_name']; ?></option>
                                <?php
                                    }
                                ?>
                                
                            </select>
                            <p>Danh mục cha của menu này(nếu không có cha thì không chọn</p>
                        </div>

                        <div class="form-group">
                            <label for="menu-order">Thứ tự</label>
                            <input type="number" name="menu_order" id="menu-order" value="<?php echo $menu_item["menu_order"]; ?>">
                            <?php form_error('menu_order'); ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="sm_add" id="btn-save-list">Lưu danh mục</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>