<?php
get_header();
?>

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách sản phẩm</h3>
                    <a href="?mod=product&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=product&action=main">Tất cả <span class="count"><?php echo count($list_product); ?></span></a> |</li>
                            <li class="publish"><a href="?mod=product&action=status3">Còn hàng <span class="count">(<?php echo num_rows_by_status('3'); ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=product&action=status2">Hết hàng<span class="count">(<?php echo num_rows_by_status('2'); ?>)</span> |</a></li>
                            <li class="pending"><a href="?mod=product&action=status1">Thùng rác<span class="count">(<?php echo num_rows_by_status('1'); ?>)</span></a></li>
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
                            if(!empty($list_product)){
                                $temp = 0;
                        ?>

                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">ID</span></td>
                                    <td><span class="thead-text">Hình ảnh</span></td>
                                    <td><span class="thead-text">Tên sản phẩm</span></td>
                                    <td><span class="thead-text">Giá</span></td>
                                    <!-- <td><span class="thead-text">Danh mục</span></td> -->
                                    <td><span class="thead-text">Trạng thái</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                    <td><span class="thead-text">Thời gian</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($list_product as $item){
                                        $temp ++;
                                        $status = array(
                                            3 => "<p style='color: #03a9f4; font-weight:bold;'>còn hàng</p>",
                                            2 => "<p style='color: #03a9f4; font-style: italic'>Hết hàng</p>",
                                            1 => "<p style='color: red;'>Thùng rác</p>"
                                        );
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                    <td><span class="tbody-text"><?php echo $temp; ?></h3></span>
                                    <td><span class="tbody-text"><?php echo $item['id']; ?></h3></span>
                                    <td>
                                        <div class="tbody-thumb">
                                            <img src="<?php echo $item['product_thumb']; ?>" alt="">
                                        </div>
                                    </td>
                                    <td class="clearfix">
                                        <div class="tb-title fl-left">
                                            <a href="" title=""><?php echo $item['product_title']; ?></a>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="<?php echo base_url("?mod=product&action=edit&id={$item['id']}"); ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="<?php echo base_url("?mod=product&action=delete&id={$item['id']}"); ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td><span class="tbody-text"><?php echo currency_format($item['price']); ?></span></td>
                                    <!-- <td><span class="tbody-text"><?php //echo $item['cat_title']; ?></span></td> -->
                                    <td><span class="tbody-text"><?php echo $status[$item['product_status']]; ?></span></td>
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
                                    <td><span class="tfoot-text">ID</span></td>
                                    <td><span class="tfoot-text">Hình ảnh</span></td>
                                    <td><span class="tfoot-text">Tên sản phẩm</span></td>
                                    <td><span class="tfoot-text">Giá</span></td>
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