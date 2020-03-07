<?php
//(cách 2)
//     $item0 = db_fetch_array("SELECT * FROM `tbl_product_cat` WHERE `level` = 0 ORDER BY `cat_order`");
//     // show_array($item0);
// //LẤY DANH MỤC CON
//     $item1 = db_fetch_array("SELECT * FROM `tbl_product_cat` WHERE `level` = 1 ORDER BY `cat_order`");
//     $item2 = db_fetch_array("SELECT * FROM `tbl_product_cat` WHERE `level` = 2 ORDER BY `cat_order`");
/*
lấy cat_parent ở con item1, so sánh xem bằng cái cat_id nào ở item0. Nếu bằng thì mới cho hiện con item1
 */
//CÁCH 1
$list_cat = db_fetch_array("SELECT * FROM `tbl_product_cat`");

//kiểm tra xem tồn tại menu con (cat_parent = cat_id của thằng cha nó)
function check_exists_child($cat_id) {
    $check = db_num_rows("SELECT * FROM `tbl_product_cat` WHERE `cat_parent` = {$cat_id}");
    if ($check > 0)
        return true;
}
//lấy menu con
function get_child($cat_id) {
    return db_fetch_array("SELECT * FROM `tbl_product_cat` WHERE `cat_parent` = {$cat_id}");
}

?>

    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            <ul class="list-item">
                <?php
                if (!empty($list_cat)) {
                    foreach ($list_cat as $item) {
                        ?>
                        <?php
                        if ($item['cat_parent'] == 0) {
                            $cat_id = $item['cat_id'];
                            ?>
                            <li>
                                <a href="<?php echo base_url("product/{$item['url']}-{$item['cat_id']}"); ?>" title=""><?php echo $item['cat_title']; ?></a>
                                <!--Nếu có menu con-->
                                <?php
                                if (check_exists_child($cat_id)) {
                                    ?>
                                    <ul class="sub-menu">
                                        <?php
                                        $list_child = get_child($cat_id);
                                        foreach ($list_child as $child) {
                                            $cat_id_child = $child['cat_id'];
                                            ?>
                                            <li>
                                                <a href="<?php echo base_url("product/{$child['url']}-{$child['cat_id']}"); ?>" title=""><?php echo $child['cat_title']; ?></a>
                                                <?php
                                                if (check_exists_child($cat_id_child)) {
                                                    ?>
                                                    <ul class="sub-menu">
                                                        <?php
                                                        $list_child_1 = get_child($cat_id_child);
                                                        foreach ($list_child_1 as $child_1) {
                                                            //$cat_id = $child['parent_id'];
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo base_url("product/{$child_1['url']}-{$child_1['cat_id']}"); ?>" title=""><?php echo $child_1['cat_title']; ?></a>
                                                            </li>

                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                <?php }
                                                ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                <?php }
                                ?>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>






<!-- <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                        <?php
                            if(!empty($item0)){
                                foreach($item0 as $item){
                        ?>
                        <li>
                            <a href="<?php echo base_url("product/{$item['url']}-{$item['cat_id']}"); ?>" title=""><?php echo $item['cat_title']; ?></a>
                            <?php
                                if(!empty($item1)){
                            ?>
                                <ul class="sub-menu">
                                    <?php
                                        foreach($item1 as $itemm){
                                            if($itemm['cat_parent'] == $item['cat_id']){


                                    ?>
                                        <li>
                                            <a href="<?php echo base_url("product/{$itemm['url']}-{$itemm['cat_id']}"); ?>" title=""><?php echo $itemm['cat_title']; ?></a>
                                                <?php
                                                        if(!empty($item2)){
                                                    ?>
                                                        <ul class="sub-menu">
                                                            <?php
                                                                foreach($item2 as $itemmm){
                                                                    if($itemmm['cat_parent'] == $itemm['cat_id']){


                                                            ?>
                                                                <li>
                                                                    <a href="<?php echo base_url("product/{$itemmm['url']}-{$itemmm['cat_id']}"); ?>" title=""><?php echo $itemmm['cat_title']; ?></a>
                                                                    
                                                                </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                    </ul>
                                                    <?php
                                                        }
                                                    ?>
                                        </li>
                                    <?php
                                        }
                                    }
                                    ?>
                            </ul>
                            <?php
                                }
                            ?>
                            
                        </li>
                        <?php
                            }
                        }
                        ?>
                        
                        
                    </ul>
                </div>
            </div>
 -->