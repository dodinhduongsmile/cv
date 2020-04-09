<?php
get_header();
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thùng rác</h3>
                    <a href="?mod=post&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=post&controller=index&action=main">Tất cả <span class="count">(<?php echo num_rows('tbl_post'); ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=post&controller=index&action=status3">Đã đăng <span class="count">(<?php echo num_rows_by_status('3'); ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=post&controller=index&action=status2">Chờ xét duyệt <span class="count">(<?php echo num_rows_by_status('2'); ?>)</span></a></li>
                            <li class="trash"><a href="?mod=post&controller=index&action=status1">Thùng rác <span class="count">(<?php echo num_rows_by_status('1'); ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right">
                            <input type="text" name="s" id="s">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form>
                    </div>
                    <div class="actions">
                        <form method="GET" action="" class="form-actions">
                            <select name="actions">
                                <option value="0">Tác vụ</option>
                                <option value="1">Chỉnh sửa</option>
                                <option value="2">Bỏ vào thủng rác</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <?php
                            if(!empty($list_post)){
                        ?>

                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">ID</span></td>
                                    <td><span class="thead-text">Tiêu đề</span></td>
                                    <td><span class="thead-text">Danh mục</span></td>
                                    <td><span class="thead-text">Trạng thái</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                    <td><span class="thead-text">Thời gian</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($list_post as $item){
                                        $status = array(
                                            3 => "<p style='color: #03a9f4; font-weight:bold;'>đã đăng</p>",
                                            2 => "<p style='color: #03a9f4; font-style: italic'>Chờ duyệt</p>",
                                            1 => "<p style='color: red;'>Thùng rác</p>"
                                        );
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                    <td><span class="tbody-text"><?php echo $item['id']; ?></h3></span>
                                    <td class="clearfix">
                                        <div class="tb-title fl-left">
                                            <a href="" title=""><?php echo $item['post_title']; ?></a>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="<?php echo base_url("?mod=post&action=edit&id={$item['id']}"); ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="<?php echo base_url("?mod=post&action=delete&id={$item['id']}"); ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td><span class="tbody-text"><?php echo $item['cat_id']; ?></span></td>
                                    <td><span class="tbody-text"><?php echo $status[$item['status']]; ?></span></td>
                                    <td><span class="tbody-text"><?php echo $item['author']; ?></span></td>
                                    <td><span class="tbody-text"><?php echo $item['created_date']; ?></span></td>
                                </tr>
                                <?php
                                    }
                                ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="tfoot-text">STT</span></td>
                                    <td><span class="tfoot-text">Tiêu đề</span></td>
                                    <td><span class="tfoot-text">Danh mục</span></td>
                                    <td><span class="tfoot-text">Trạng thái</span></td>
                                    <td><span class="tfoot-text">Người tạo</span></td>
                                    <td><span class="tfoot-text">Thời gian</span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php
                            }
                        ?>
                    </div>

                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <?php echo $get_pagging; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>