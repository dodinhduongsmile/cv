<?php
//kiểm tra xem tồn tại menu con
function check_exists_child($cat_id) {
    $check = db_num_rows("SELECT * FROM `tbl_product_cat` WHERE `cat_parent` = {$cat_id}");
    if ($check > 0)
        return true;
}
//lấy menu con
function get_child($cat_id) {
    return db_fetch_array("SELECT * FROM `tbl_product_cat` WHERE `cat_parent` = {$cat_id}");
}
