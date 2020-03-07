<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Bước 1: Tạo thư mục lưu file
    $error = array();
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES['file']['name']);
    // Kiểm tra kiểu file hợp lệ
    $type_file = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $type_fileAllow = array('png', 'jpg', 'jpeg', 'gif');
    if (!in_array(strtolower($type_file), $type_fileAllow)) {
        $error['file'] = "File bạn vừa chọn hệ thống không hỗ trợ, bạn vui lòng chọn hình ảnh";
    }
    //Kiểm tra kích thước file
    $size_file = $_FILES['file']['size'];
    if ($size_file > 5242880) {
        $error['file'] = "File bạn chọn không được quá 5MB";
    }
// Kiểm tra file đã tồn tại trê hệ thống
    if (file_exists($target_file)) {
        $error['file'] = "File bạn chọn đã tồn tại trên hệ thống";
    }
//
    if (empty($error)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $flag = true;
            echo json_encode(array('status' => 'ok','file_path' => $target_file));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    } else {
        echo json_encode($error);
    }
}

?>