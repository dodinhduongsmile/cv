<?php
get_header();
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Đơn hàng đã nhận tiền</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=order&controller=index&action=index">Tất cả <span class="count">(<?php echo num_rows('tbl_checkout'); ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=order&controller=index&action=status3">Đã xác nhận <span class="count">(<?php echo num_rows_by_status(3); ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=order&controller=index&action=status2">Chờ xác nhận<span class="count">(<?php echo num_rows_by_status(2); ?>)</span> |</a></li>
                            <li class="pending"><a href="?mod=order&controller=index&action=status1">Thùng rác<span class="count">(<?php echo num_rows_by_status(1); ?>)</span></a></li>
                            <li class="pending"><a href="?mod=order&controller=index&action=status4">Đã nhận tiền<span class="count">(<?php echo num_rows_by_status(4); ?>)</span></a></li>
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
                                <option value="1">Công khai</option>
                                <option value="1">Chờ duyệt</option>
                                <option value="2">Bỏ vào thủng rác</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <?php
                            if(!empty($list_order)){
                        ?>

                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Mã đơn hàng</span></td>
                                    <td><span class="thead-text">Họ và tên</span></td>
                                    <td><span class="thead-text">Số sản phẩm</span></td>
                                    <td><span class="thead-text">Tổng giá</span></td>
                                    <td><span class="thead-text">Trạng thái</span></td>
                                    <td><span class="thead-text">Thời gian</span></td>
                                    <td><span class="thead-text">Chi tiết</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $temp = 0;
                                    foreach($list_order as $item){
                                    $temp ++;
                                    $status = array(
                                            4 => "<p style='color: #f00; font-weight:bold;'>đã nhận tiền</p>",
                                            3 => "<p style='color: #03a9f4; font-weight:bold;'>đã xác nhận</p>",
                                            2 => "<p style='color: #03a9f4; font-style: italic'>Chờ xác nhận</p>",
                                            1 => "<p style='color: red;'>Thùng rác</p>"
                                        );
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                    <td><span class="tbody-text"><?php echo $temp; ?></h3></span>
                                    <td><span class="tbody-text"><?php echo "DONHANG{$item['id']}"; ?></h3></span>
                                    <td>
                                        <div class="tb-title fl-left">
                                            <a href="" title=""><?php echo $item['fullname']; ?></a>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="?mod=order&action=edit&id=<?php echo $item['id']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="?mod=order&action=delete&id=<?php echo $item['id']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td><span class="tbody-text"><?php echo $item['count_product']; ?></span></td>
                                    <td><span class="tbody-text"><?php echo currency_format($item['total_price']); ?></span></td>
                                    <td><span class="tbody-text"><?php echo $status[$item['status']]; ?></span></td>
                                    <td><span class="tbody-text"><?php echo $item['created_date']; ?></span></td>
                                    <td><a href="?mod=order&action=detail&id=<?php echo $item['id']; ?>" title="" class="tbody-text">Chi tiết</a></td>
                                </tr>
                                <?php
                                    }
                                ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="tfoot-text">STT</span></td>
                                    <td><span class="tfoot-text">Mã đơn hàng</span></td>
                                    <td><span class="tfoot-text">Họ và tên</span></td>
                                    <td><span class="tfoot-text">Số sản phẩm</span></td>
                                    <td><span class="tfoot-text">Tổng giá</span></td>
                                    <td><span class="tfoot-text">Trạng thái</span></td>
                                    <td><span class="tfoot-text">Thời gian</span></td>
                                    <td><span class="tfoot-text">Chi tiết</span></td>
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
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
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