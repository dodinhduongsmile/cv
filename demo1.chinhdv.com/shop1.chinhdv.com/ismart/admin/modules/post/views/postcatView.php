<?php
get_header();
?>
<div id="main-content-wp" class="list-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách danh mục</h3>
                    <a href="?mod=post&action=addcat" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="table-responsive">
                        <?php
                            if(!empty($list_post_cat)){
                            $temp = 0;
                        ?>


                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">CAT_ID</span></td>
                                    <td><span class="thead-text">Tiêu đề</span></td>
                                    <td><span class="thead-text">Thứ tự</span></td>
                                    <td><span class="thead-text">Trạng thái</span></td>
                                    <!-- <td><span class="thead-text">Người tạo</span></td> -->
                                    <!-- <td><span class="thead-text">Thời gian</span></td> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($list_post_cat as $item){
                                    $temp ++;
                                     // echo str_repeat("--",$item["level"])." ".$item["title"];
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                    <td><span class="tbody-text"><?php echo $item['cat_id']; ?></h3></span>
                                    <td class="clearfix">
                                        <div class="tb-title fl-left">
                                            <a href="" title=""><?php echo str_repeat("--",$item["level"])." ".$item['cat_title']; ?></a>
                                        </div> 
                                        <ul class="list-operation fl-right">
                                            <li><a href="?mod=post&action=editcat&cat_id=<?php echo $item['cat_id']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="?mod=post&action=deletecat&cat_id=<?php echo $item['cat_id']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td><span class="tbody-text"><?php echo $temp; ?></span></td>
                                    <td><span class="tbody-text">Hoạt động</span></td>
                                    <!-- <td><span class="tbody-text">Admin</span></td> -->
                                    <!-- <td><span class="tbody-text">12-07-2016</span></td> -->
                                </tr>
                                <?php
                                    }
                                ?>
                                
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="tfoot-text">CAT_ID</span></td>
                                    <td><span class="tfoot-text-text">Tiêu đề</span></td>
                                    <td><span class="tfoot-text">Thứ tự</span></td>
                                    <td><span class="tfoot-text">Trạng thái</span></td>
                                    <!-- <td><span class="tfoot-text">Người tạo</span></td> -->
                                    <!-- <td><span class="tfoot-text">Thời gian</span></td> -->
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
                    <?php echo $get_pagging; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>