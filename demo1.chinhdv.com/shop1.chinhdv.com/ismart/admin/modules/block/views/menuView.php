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
                            <input type="text" name="title" id="title">
                        </div>
                         <?php form_error('title'); ?>
                        <div class="form-group">
                            <label for="url-static">Đường dẫn tĩnh</label>
                            <input type="text" name="url_static" id="url-static" value="#">
                            <p>Chuỗi đường dẫn tĩnh cho menu</p>
                        </div>
                         <?php form_error('url_static'); ?>

                        <div class="form-group clearfix">
                            <label>Danh mục cha</label>
                            <select name="parent_id">
                                <option value="">-- Chọn --</option>
                                <?php
                                	
                                	foreach($list_menu as $itemm){
                                	
                                ?>
									<option value="<?php echo $itemm['id']; ?>"><?php echo str_repeat("--",$itemm["level"])." ".$itemm['menu_name']; ?></option>
                                <?php
                                	}
                                ?>
                                
                            </select>
                            <p>Danh mục cha của menu này(nếu không có cha thì không chọn</p>
                        </div>

                        <div class="form-group">
                            <label for="menu-order">Thứ tự</label>
                            <input type="number" name="menu_order" id="menu-order">
                            <?php form_error('menu_order'); ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="sm_add" id="btn-save-list">Lưu danh mục</button>
                        </div>
                    </form>
                </div>

                <div id="category-menu" class="fl-right">
                    <div class="actions">
                        <select name="post_status">
                            <option value="-1">Tác vụ</option>
                            <option value="delete">Xóa vĩnh viễn</option>
                        </select>
                        <button type="submit" name="sm_block_status" id="sm-block-status">Áp dụng</button>
                    </div>
                    <div class="table-responsive">
                    	<?php
                    		if(!empty($list_menu)){
                    	?>


                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">ID</span></td>
                                    <td><span class="thead-text">Tên menu</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Slug</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Thứ tự</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Cha nó(ID)</span></td>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            		foreach($list_menu as $item){
                            	?>
								<tr>
                                    <td><input type="checkbox" name="checkItem[]" class="checkItem" value="1"></td>
                                    <td><span class="tbody-text"><?php echo $item['id']; ?></span>
                                    <td>
                                        <div class="tb-title fl-left">
                                            <a href="" title=""><?php echo str_repeat("--",$item["level"])." ".$item['menu_name']; ?></a>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="<?php echo base_url("?mod=block&action=editmenu&id={$item['id']}");?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="<?php echo base_url("?mod=block&action=deletemenu&id={$item['id']}");?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td style="text-align: center;"><span class="tbody-text"><?php echo $item['menu_url']; ?></span></td>
                                    <td style="text-align: center;"><span class="tbody-text"><?php echo $item['menu_order']; ?></span></td>
                                    <td style="text-align: center;"><span class="tbody-text"><?php echo $item['menu_parent']; ?></span></td>
                                </tr>
                            	<?php
                            		}
                            	?>  

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Tên menu</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Slug</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Thứ tự</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Cha nó(ID)</span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php
                    		}
                    	?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>