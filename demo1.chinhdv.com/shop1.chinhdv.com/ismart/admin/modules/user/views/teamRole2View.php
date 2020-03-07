<?php
get_header();
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <div class="section" id="title-page">
                <div class="clearfix">
                    <a href="?mod=user&controller=team&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                    <h3 id="index" class="fl-left">Nhóm người kiểm duyệt</h3>
                </div>
            </div>
        <?php get_sidebar('user'); ?>
        <div id="content" class="fl-right">
            
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=user&controller=team&action=index">Tất cả <span class="count">(<?php echo num_rows('tbl_user'); ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=user&controller=team&action=role1">Quản trị <span class="count">(<?php echo num_rows_by_role(1); ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=user&controller=team&action=role2">Kiểm duyệt <span class="count">(<?php echo num_rows_by_role(2); ?>)</span></a></li>
                            <li class="trash"><a href="?mod=user&controller=team&action=role3">Người dưng <span class="count">(<?php echo num_rows_by_role(3); ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="?mod=user&controller=team&action=search">
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
                                    if(!empty($list_user_role)){
                        ?>


                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">ID</span></td>
                                    <td><span class="thead-text">Tên tài khoản</span></td>
                                    <!-- <td><span class="thead-text">Danh mục</span></td> -->
                                    <td><span class="thead-text">Cấp bậc</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                    <td><span class="thead-text">Thời gian</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                        foreach($list_user_role as $item){
                                        $info_role = array(
                                            1 => "<p style='color: #03a9f4; font-weight:bold;'>Người quản trị</p>",
                                            2 => "<p style='color: #03a9f4; font-style: italic'>Cộng tác viên</p>",
                                            3 => "<p style='color: red;'>Không có quyền</p>"
                                        );

                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                    <td><span class="tbody-text"><?php echo $item['user_id']; ?></h3></span>
                                    <td class="clearfix">
                                        <div class="tb-title fl-left">
                                           <a href="?mod=user&action=edit&id=<?php echo $item['user_id']; ?>" title="chi tiết"><?php echo $item['username']; ?>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="?mod=user&action=edit&id=<?php echo $item['user_id']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="?mod=user&action=delete&id=<?php echo $item['user_id']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <!-- <td><span class="tbody-text">Danh mục 1</span></td> -->
                                    <td><span class="tbody-text"><?php echo $info_role[$item['role']]; ?></span></td>
                                    <td><span class="tbody-text"><?php echo $item['who_create']; ?></span></td>
                                    <td><span class="tbody-text"><?php echo $item['created_date']; ?></span></td>
                                </tr>        
                                
                                <?php
                                        }
                                
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="tfoot-text">ID</span></td>
                                    <td><span class="tfoot-text">Tên tài khoản</span></td>
                                    <!-- <td><span class="tfoot-text">Danh mục</span></td> -->
                                    <td><span class="tfoot-text">Cấp bậc</span></td>
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
                    <?php
                    echo $get_pagging;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>