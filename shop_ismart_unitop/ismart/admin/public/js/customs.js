// <div id="uploadFile">
//                             <input type="file" name="file" id="file" data-uri="upload_single.php"><br/><br/>
//                             <input id="thumbnail_url" type ="hidden" name="thumbnail_url" value="" />
//                             <input type="submit" name="Upload" value="Upload" id="upload_single_bt">
//                             <div id="show_list_file" >
//                             </div>
//                         </div>
$(document).ready(function () {
    var inputFile = $('#file');
    $('#upload_single_bt').click(function (event) {
        var URI_single = $('#uploadFile #file').attr('data-uri');
        var fileToUpload = inputFile[0].files[0];//lấy đc cái mảng files
        var formData = new FormData();
        formData.append('file', fileToUpload);//dữ liệu json
        $.ajax({
            url: URI_single,
            type: 'post',
            data: formData,//data gửi lên server(phải là kiểu json)
            contentType: false,
            processData: false,
            dataType: 'json',//kiểu data serrver trả về
            success: function (data) {
                console.log(data);
                if (data.status == 'add_ok') {
                    showThumbUpload(data);
                    $('#thumbnail_url').val(data.file_path);
                }else{
                    alert(data.status);
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false;
    });

    function  showThumbUpload(data) {
        var items;
        items = '<img src="' + data.file_path + '"/>';
        $('#show_list_file').html(items);
    }

});


