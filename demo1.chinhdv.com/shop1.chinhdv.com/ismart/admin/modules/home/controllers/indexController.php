<?php
// http://localhost/unitop/backend/lession/section26/projectmvc.vn/?mod=user&controller=index&action=addd

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');

}

function indexAction() {
    //Sau này có thể viết chức năng thống kê doanh số ở đây. giờ tạm chuyển hướng sang danh sách bài viết
redirect("?mod=post&action=main");
// load_view('index');
}
