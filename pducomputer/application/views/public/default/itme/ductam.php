<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    $ver = 1.43;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name='robots' content='noindex,nofollow'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php if (!empty($SEO)): ?>
        <title><?php echo !empty($SEO['title']) ? $SEO['title'] : $SEO['meta_title']; ?></title>
        
    <?php else: ?>
        <title><?php echo isset($this->_settings->meta_title) ? $this->_settings->meta_title : ''; ?></title>
       
    <?php endif; ?>
    <script>
        var urlCurrentMenu = window.location.href,
            urlCurrent = window.location.href,
            segment = '<?php echo base_url($this->uri->segment(1)) ?>',
            base_url = '<?php echo base_url(); ?>',
            media_url = '<?php echo MEDIA_URL . '/'; ?>',
            csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name') ?>',
            csrf_token_name = '<?php echo $this->security->get_csrf_token_name() ?>',
            csrf_token_hash = '<?php echo $this->security->get_csrf_hash() ?>';
    </script>
	<link rel='stylesheet' href="<?php echo $this->templates_assets.'css/style.css'; ?>"  />
	<script src="<?php echo $this->templates_assets.'js/jquery.min.js'; ?>" type='text/javascript'></script>
</head>
<body>
<div class="importexcel">
	<form action="<?php echo base_url("itme/upload_excel"); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div style="display: inline-flex">
            <input type="file" name="userfile" id="userfile" class="form-control filestyle"
                   value="" data-icon="false">
            <input type="submit" name="importfile" value="Import" id="importfile-id"
                   class="btn btn-primary">
        </div>
    </form>
</div>

<div class="ductam">
	<div class="container">
		<div class="row_pc">
			<h2>Quản lý công việc đức tâm</h2>
			<div class="box1">
				<h3 class="title_formx">Thêm sản phẩm</h3>
				<form action="" class="addsp" id="addsp" enctype="multipart/form-data">
					<input type="hidden" name="id" value="0">
					<div class="row">
						<div class="col-sm-6">
							<label for="">tên máy</label>
							<input type="text" name="tenmay">
							<label for="">tag máy</label>
							<input type="text" name="servicetag">
							<label for="">ngày nhận</label>
							<input type="date" name="ngaynhan">
							<!-- <input type="date" name="created_time"> -->
							<div class="boxson">
								<label for="A">Sơn mặt A</label>
								<input type="checkbox" name="son[]" value="A" id="A">
								<label for="B">Sơn mặt B</label>
								<input type="checkbox" name="son[]" value="B" id="B">
								<label for="C">Sơn mặt C</label>
								<input type="checkbox" name="son[]" value="C" id="C">
								<label for="D">Sơn mặt D</label>
								<input type="checkbox" name="son[]" value="D" id="D">
								<label for="E">Sơn mặt E</label>
								<input type="checkbox" name="son[]" value="E" id="E">
								<label for="F">Sơn mặt F</label>
								<input type="checkbox" name="son[]" value="F" id="F">
								<label for="GAY_GONG">Sơn mặt gông, gáy</label>
								<input type="checkbox" name="son[]" value="GAY_GONG" id="GAY_GONG">
							</div>
							<label for="">Làm màn</label>
							<input type="text" name="lamman">
						</div>
						<div class="col-sm-6">
							<label for="">Ghi chú</label>
							<input type="text" name="ghichu">
							<label for="">Trạng thái</label>
					        <select name="trangthai" id="">
					        	<option value="1">1. chưa hoàn thiện</option>
					        	<option value="2">2. xử lý lại</option>
					        	<option value="3">3. hoàn thiện</option>
					        	<option value="4">4. trả lại kho</option>
					        </select>
					        <label for="">ảnh form</label>
					        <div id="uploadFile">
	                            <input type="file" name="file" id="file" data-uri="<?php echo base_url("itme/uploadimg"); ?>"><br/><br/>
	                            
	                            <input id="thumbnail_url" type ="hidden" name="image_form" value="" />
	                            <input type="submit" name="Upload" value="Upload" id="upload_single_bt">
	                            <div id="show_list_file" >
	                            	
	                            </div>

	                        </div>


					        <button type="button" class="btn submitadd">submit</button>
						</div>
					</div>
				</form>
			</div>
			<div class="box2">
				<hr><hr>
				<div class="actiondt">
                  		<button class="reload btn" onclick="reloaditme()">reload</button>
	                  	<select name="" id="sortductam">
	                  		<option value="">-chọn giá trị sắp xếp-</option>
	                  		<option data-key="ngaynhan" value="asc">ngày nhận tăng dần</option>
	                  		<option data-key="ngaynhan" value="desc">ngày nhận giảm dần</option>
	                  	</select>
	                  	<select name="" id="sortductam2">
	                  		<option value="">-chọn giá trị lọc-</option>
	                  		<option data-key="trangthai" value="4">4. trả lại kho</option>
	                  		<option data-key="trangthai" value="3">3. đã hoàn thiện</option>
	                  		<option data-key="trangthai" value="2">2. xử lý lại</option>
	                  		<option data-key="trangthai" value="1">1. chưa hoàn thiện</option>
	                  	</select>
	                  	<input id="sortductam3" class="form-control myInput" type="text" placeholder="Search.."/>
                  	</div>
				<div class="table-responsive">
                  	<h3 class="title_form">List sản phẩm</h3>
                  	
                  	<table class="table">
	                     <thead>
	                        <tr>
	                           <th>id</th>
	                           <th>số ngày</th>
	                           <th>ngaynhan</th>
	                           <th>update</th>
	                           <th>tenmay</th>
	                           <th>servicetag</th>
	                           <th>son</th>
	                           <th>lamman</th>
	                           <th>ghichu</th>
	                           <th>trangthai</th>
	                           <th>action</th>
	                        </tr>
	                     </thead>
	                     <tbody class="list_order">
	                     	<?php 
								$trangthaix = array(
									1 => "chưa hoàn thiện",
									2 => "xử lý lại",
									3 => "hoàn thiện"
								);
								$trangthaix2 = [
									0 => "black",
									1 => "red",
									2 => "green",
									3 => "blue",
									4 => "purple"
								];
							?>
	                     	<?php if(!empty($listsp)) foreach($listsp as $key=>$value): ?>
	                     	<tr data-id="<?php echo $value->id; ?>">
	                     		<td><?php echo $value->id; ?></td>
	                     		<td><?php echo date('d',time()) - date('d',strtotime($value->ngaynhan)); ?> </td>
	                     		<td><?php echo date('d-m-Y',strtotime($value->ngaynhan)) ; ?></td>
	                     		<td><?php echo date('d-m-y',strtotime($value->updated_time)) ; ?></td>
	                     		<td><?php echo $value->tenmay; ?></td>
	                     		<td><?php echo $value->servicetag; ?></td>
	                     		<td><?php echo $value->son; ?> </td>
	                     		<td><?php echo $value->lamman; ?> </td>
	                     		<td><?php echo $value->ghichu; ?> </td>
	                     		<td class="<?php echo $trangthaix2[$value->trangthai]; ?>"><?php echo $trangthaix[$value->trangthai]; ?> </td>
	                     		<td><a href="#" class="btnEdit">SỬA</a> | <a href="#" class="btnDelete">XÓA</a></td>
	                     	</tr>
	                     <?php endforeach; ?>
	                     <!-- <tr data-id="2"><td>1</td><td>11/1/2021</td><td>dell 7440</td><td>123sa43</td><td>sơn </td><td>lamman </td><td>ghichu </td><td>trangthai </td><td><a href="#">SỬA</a> | <a href="#">XÓA</a></td></tr> -->
	                     </tbody>
                 	</table>
         		</div>
			</div>
		</div>
		<div id="show_success_mss" style="position: fixed; top: 150px; right: 20px;z-index: 99999"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		var paramsdt = {};
		function ajax_ductam(data) {
		    $.ajax({
		        url: base_url +"/itme/ajax_sortFilter",
		        type: 'get',
		        dataType: 'html',
		        data: data,
		        success: function (response) {
		          $(".list_order").html(response);
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		            console.log(xhr);
		            console.log(thrownError);
		        }
		    })
		}
		$("body").on("change","#sortductam", function(event){
		   var sortval, sortkey;
		    paramsdt['sortval'] = $(this).val();
		    paramsdt['sortkey'] = $(this).children(":selected").attr("data-key");
		    
		    ajax_ductam(paramsdt);
		});
		$("body").on("change","#sortductam2", function(event){
		   /*event.preventDefault();*/ 
		   var filterkey, filterval;
		    paramsdt['filterval'] = $(this).val();
		    paramsdt['filterkey'] = $(this).children(":selected").attr("data-key");
		    
		    ajax_ductam(paramsdt);
		});
		/**/
		$(".submitadd").click(function(event) {
            event.preventDefault();
            let modal_form = $('#addsp');
            if(modal_form.find('input[name="id"]').val() == 0) {
	            url = '/itme/ajax_add';
	        } else {
	            url = '/itme/ajax_update';
	        }

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: $('#addsp').serialize(),
            })
            .done(function(response) {
            	$('#formContactUs .text-danger').empty();
                if (response.type != 'success') {
                    $.each(response.validation,function (i, val) {
                        $('[name="'+i+'"]').after(val);
                    });
                }else{
                    $('#addsp')[0].reset();
                    /*document.getElementById("addsp").reset();*/
	                $(".boxson input").attr('checked',false);
	                
	                $("input[name='id']").val(0);
	                reloaditme();
                };

                Toastr[response.type](response.message);
                
            })
        });
        /**/
         $('body').on('click','.btnEdit',function () {
	        let modal_form = $('#addsp');
	        let id = $(this).closest('tr').attr("data-id");

	            $.ajax({
	                url : '/itme/ajax_edit',
	                type: "POST",
	                data: {id:id},
	                dataType: "JSON",
	                success: function(response) {
	                	
	                    $.each(response.data_info, function( key, value ) {
	                    
	                        let element = modal_form.find('[name="'+key+'"]');
	                        element.val(value);
	                    });
	                     $.each(response.data_info.son, function( keyx, valuex ) {
	                     	/*$("#"+valuex).checked  = true;*/
	                     	$("#"+valuex).attr('checked','checked');
	                     });
	                     var image_form = '<img src="' +base_url + response.data_info.image_form + '"/>';
        				$('#show_list_file').html(image_form);

	                    $('html, body').animate({
                              scrollTop: 0
                         }, 700);
	                    $("h3.title_formx").text("sửa sản phẩm tag"+response.data_info.servicetag);
	                    $("button.submitadd").addClass('submitupdate').end().removeClass('submitadd');
	                    $("button.submitadd").removeClass('submitadd');
	                },
	                error: function (jqXHR, textStatus, errorThrown)
	                {
	                    console.log(errorThrown);
	                    console.log(textStatus);
	                    console.log(jqXHR);
	                }
	            });return false;
	    });
         $('body').on('click','.btnDelete',function () {

	        let id = $(this).closest('tr').attr("data-id");
	        if(prompt("bạn có chắc chắn muốn xóa?", "")){
	        	$.ajax({
	                url : '/itme/ajax_delete',
	                type: "POST",
	                data: {id:id},
	                dataType: "JSON",
	                success: function(response) {
	                    Toastr[response.type](response.message);
		                /*document.getElementById("addsp").reset();*/
		                reloaditme();
	                },
	                error: function (jqXHR, textStatus, errorThrown)
	                {
	                    console.log(errorThrown);
	                    console.log(textStatus);
	                    console.log(jqXHR);
	                }
	            });
	        }
	            return false;
	    });
	});

/*reloaditme*/
        function reloaditme(){
        	event.preventDefault();
            $.ajax({
                url: '/itme/ajax_reload',
                type: 'POST',
                dataType: 'html',
                data: {},
            })
            .done(function(response) {
               $(".list_order").html(response);
            });
        }
</script>
<script>
	$(document).ready(function () {
    var inputFile = $('#file');
    $('#upload_single_bt').click(function (event) {
        var URI_single = $('#uploadFile #file').attr('data-uri');
        var fileToUpload = inputFile[0].files[0];/*lấy đc cái mảng files*/
        var formData = new FormData();
        formData.append('file', fileToUpload);/*dữ liệu json*/
        $.ajax({
            url: URI_single,
            type: 'post',
            data: formData,/*data gửi lên server(phải là kiểu json)*/
            contentType: false,
            processData: false,
            dataType: 'json',/*kiểu data serrver trả về*/
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
        items = '<img src="' +data.url + data.file_path + '"/>';
        $('#show_list_file').html(items);
    };

});

</script>
<script>
$(document).ready(function(){
  $(".myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $('tbody.list_order tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
	var Toastr = {
    success : function(message){
        let t='<div class="alert alert-success alert-dismissible alert-ml" role="alert"\
            style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                '+message+' !\
            </div>';
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 2000);
        },
    error : function(message){
            let  t = '<div class="alert alert-danger alert-dismissible alert-ml" role="alert"\
                style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                    '+message+' !\
                </div>';
           
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 2000);
    },
    warning : function(message){
            let  t = '<div class="alert alert-danger alert-dismissible alert-ml" role="alert"\
                style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                    '+message+' !\
                </div>';
           
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 2000);
    }
                
};
</script>
<style>
	html,body{
		box-sizing: border-box;
		padding: 0;
		margin: 0;
	}
	.ductam {
    box-sizing: border-box;
    position:relative;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
}
.actiondt {
    padding: 10px 0;
}

button.reload.btn {
    padding: 15px 20px;
    background: #55acee;
    color: #fff;
    border: none;
    border-radius: 6px;
}
	form#addsp input,form#addsp select {
    display: block;
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    color: #333;
    border: 1px solid #000;
    font-size: 20px;
}
h3.title_formx {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 30px;
    text-align: center;
}
tbody.list_order tr:nth-child(even) {
    background: #ded0d0;
}

tbody.list_order tr:hover {
    background: #ded0d0;
}
div#show_list_file img {
    width: 200px;
    height: auto;
    object-fit: cover;
}
@media (max-width: 767px){
	.actiondt select {
    display: block;
    margin: 10px 0;
}}
.red{color: red;}
.green{color: green;}
.blue{color:blue;}
.purple{color:purple;}
</style>
</body>
</html>