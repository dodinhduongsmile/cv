 
<div id="pducmt_vote" class="my_evaluate">
	<p>Đánh giá của bạn. 
	    <span>Hãy cho chúng tôi biết chất lượng về sản phẩm bằng cách đánh giá dưới đây!</span>
	</p>
	<ul class="ratings">
	    <li class="star selected" data-val="5"></li>
	    <li class="star" data-val="4"></li>
	    <li class="star" data-val="3"></li>
	    <li class="star" data-val="2"></li>
	    <li class="star" data-val="1"></li>
	</ul>
	<div class="pducmt_wr">
		<div class="pducmt_wr--user">
			<img src="<?php echo !empty($this->session->userdata('avatar')) ? TEMPLATES_ASSETS.$this->session->userdata('avatar') :base_url("public/images/user.png") ?>" alt="">
		</div>
		<div class="pducmt_wr--ct">
			<textarea name="" id="" placeholder="Viết nội dung đánh giá"></textarea>
			<input type="file" id="pducmt_wr--file" data-multiple-caption="{count}files selected" hidden>
			<label for="pducmt_wr--file" class="custom-file-upload">
			    <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Choose file</span>
			</label>
			

			<button class="btn btn_sendvote hide_" data-star="5">gửi</button>
		</div>

	</div>
</div>

<ul class="pducmt_list">
	<?php if(!empty($list_comment)){ foreach($list_comment as $v){ 
	?>
	<!-- pducmt_item -->
	<li class="pducmt_item" data-idcmt="<?php echo $v->id; ?>">
		<div class="feedback_" data-idcmt="<?php echo $v->id; ?>">
			<div class="feedbacker">
				<img src="<?php echo !empty($v->avatar) ? TEMPLATES_ASSETS.$v->avatar :base_url("public/images/user.png"); ?>" alt="">
				
			</div>
			<div class="fbContent">
				<span><a href="#profile"><?php echo !empty($v->fullname)?$v->fullname:"No Name"; symUserpdu($v->lever);?></a></span>
				<time><?php echo date("d/m/Y - H:i", strtotime($v->updated_time)); ?> </time>
				<ul class="fbpdu_star">
					<?php
					for ($i=1; $i <= 5; $i++) {
						if($i <= $v->count_star){
							echo '<li><span class="fa fa-star"></span></li>';
						}else{
							echo '<li><span class="fa fa-star-o"></span></li>';
						}
					}
					?>
				</ul>
				<p class="fbpdu_content"><?php echo $v->content; ?></p>
				<?php if(isset($v->file_attach)){
				?>
				<div class="attach_file">
					<a href="<?php echo TEMPLATES_ASSETS.$v->file_attach; ?>" target="_blank"><img src="<?php echo TEMPLATES_ASSETS.getPathThumb($v->file_attach); ?>" alt="<?php echo $v->content; ?>"></a>
				</div>
				<?php }; ?>
				<ul class="fbpdu_action">
					<li class="fb_action_reply"><a href="" data-user="<?php echo !empty($v->fullname)?$v->fullname:"No Name" ; ?>" data-userid="<?php echo $v->user_id; ?>"><i class="fa fa-reply" aria-hidden="true"></i> trả lời</a></li>
					<li class="fb_action_like"><a href=""><span><?php echo $v->count_like; ?></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> like</a></li>
					<li class="fb_action_repot"><a href=""><span><?php echo $v->report; ?></span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Báo cáo vi phạm</a></li>

				<?php if($v->user_id == @$_SESSION['user_id']){ ?>
					<li class="fb_action_edit"><a href=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa</a></li>
					<li class="fb_action_delete"><a href=""><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a></li>
				<?php }; ?>
				</ul>
				<!-- check xem thằng $v->id này có con hay không, load sub comment -->
				<?php if($v->total_child > 0){ ?>
				<div class="fbpdu_more2">
					<a href="#"><i class="fa fa-share"></i> <?php echo $v->total_child; ?> phản hồi</a>
				</div>
				<?php }; ?>
			</div>
		</div>
		
		<div class="feedback_rep <?php if($v->total_child == 0){echo 'hide_';} ?>">
			<!-- có sub comment thì load vào đây -->

			<div class="fbpdu_more"><a href="#" id="fbpdu_more" data-parent="<?php echo $v->id; ?>" data-offset="0">Xem thêm phản hồi <i class="fa fa-caret-down"></i></a></div>
		</div>
		
		<!-- comment -->
		<div class="pducmt_addcmt hide_">
			<div class="pducmt_wr--ct">
				<textarea name=""></textarea>
				<button class="btn submit_cmt hide_" data-idcmt="0" data-idedit="0">gửi</button>
			</div>
		</div>
	</li>
	<div class="fbpdu_mores <?php if(count($list_comment) < $limit){echo 'hide';} ?>"><a href="#" id="fbpdu_mores" data-parent="0" data-offset="<?php echo $limit; ?>">Xem thêm <?php echo $limit; ?> phản hồi <i class="fa fa-caret-down"></i></a></div>
<?php }}; ?>


</ul>

<script>
var url_like_comment = base_url + "ajax/like_cmt";
var url_report_comment =base_url + "ajax/report_cmt"; 
var url_load_comment =base_url + "ajax/comment";
var url_load_sub_comment =base_url + "ajax/comment_sub";
var url_delete_comment =base_url + "ajax/delete_comment";

var filed_comment1 = '<div class="feedback_ feedback_sub" data-idcmt="{id_comment}"><div class="feedbacker"><img src="{avatar}" alt=""></div><div class="fbContent">';
	filed_comment1+='<span>{fullname}</span>';
	filed_comment1+='<p class="fbpdu_content">{content}</p>';
	filed_comment1+='<ul class="fbpdu_action"><li class="fb_action_reply"><a href="" data-user="{fullname}" data-userid="{user_id}"><i class="fa fa-reply" aria-hidden="true"></i> trả lời</a></li><li class="fb_action_like"><a href=""><span></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> like</a></li><li class="fb_action_repot"><a href=""><span></span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Báo cáo vi phạm</a></li></ul></div></div>';

var filed_comment = '<li class="pducmt_item" data-idcmt="{id_comment}"><div class="feedback_" data-idcmt="{id_comment}"><div class="feedbacker"><img src="{avatar}" alt=""></div><div class="fbContent">';
	filed_comment+='<span>{fullname}</span><time>';
	filed_comment+='<p class="fbpdu_content">{content}</p>';
	filed_comment+='<ul class="fbpdu_action"><li class="fb_action_reply"><a href="" data-user="{fullname}" data-userid="{user_id}"><i class="fa fa-reply" aria-hidden="true"></i> trả lời</a></li><li class="fb_action_like"><a href=""><span></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> like</a></li><li class="fb_action_repot"><a href=""><span></span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Báo cáo vi phạm</a></li></ul></div></div><div class="pducmt_addcmt hide_"><div class="pducmt_wr--ct"><textarea name=""></textarea><button class="btn submit_cmt hide_" data-idcmt="0" data-idedit="0">gửi</button></div></div></li>';
document.addEventListener("DOMContentLoaded", function() {
    feedback.init();
});
var feedback = {
	init : function(){
		this.makeinputfile();
		this.uploadfile();
		this.submit_cmt();
		this.loadmore();
		this.loadmore_sub();
		this.like_comment();
		this.report_comment();
		this.delete_comment();
	},
	delete_comment: function(){
		$("body").on('click', '.fb_action_delete a', function(event) {
			event.preventDefault();
			let _this = $(this);
			let id = _this.closest('.feedback_').attr("data-idcmt");
			$.ajax({
		        type: "GET",
		        url: url_delete_comment,
		        data: {id},
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		            _this.find('.fa-spin').remove();
		            if (response.type === "success") {
		            	Toastr[response.type](response.message);
		            	let sub = _this.closest('.feedback_sub');
		            	if(sub.length){
		            		sub.remove();
		            	}else{
		            		_this.closest('.pducmt_item').remove();
		            	}
		            }else{
		            	Toastr[response.type](response.message);
		            }

		        }
		    });
		});
	},
	like_comment: function(){
		$("body").on('click', '.fb_action_like a', function(event) {
			event.preventDefault();
			let _this = $(this);
			let id = _this.closest('.feedback_').attr("data-idcmt");
			$.ajax({
		        type: "GET",
		        url: url_like_comment,
		        data: {id},
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		            _this.find('.fa-spin').remove();
		            if (response.type === "success") {
		            	_this.find("span").text(response.message);
		            }else{
		            	Toastr[response.type](response.message);
		            }

		        }
		    });
		});
	},
	report_comment: function(){
		$("body").on('click', '.fb_action_repot a', function(event) {
			event.preventDefault();
			let _this = $(this);
			let id = _this.closest('.feedback_').attr("data-idcmt");
			$.ajax({
		        type: "GET",
		        url: url_report_comment,
		        data: {id},
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		            _this.find('.fa-spin').remove();
		            if (response.type === "success") {
		            	_this.find("span").text(response.message);
		            }else{
		            	Toastr[response.type](response.message);
		            }

		        }
		    });
		});
	},
	loadmore_sub: function(){
		$("body").on('click','#fbpdu_more',function (event) {
		    event.preventDefault();
			let _this = $(this);
			let offset = _this.attr('data-offset');

			let parent_id = _this.attr('data-parent');
			let target_id = $("#idcate").val();
		    let type = $("#idcate").attr("data-controler");

			$.ajax({
		        type: "POST",
		        url: url_load_sub_comment,
		        data: {offset,type,target_id,parent_id},
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		        	if (response.type == "error") {
		            	Toastr[response.type](response.message);
		            	return false;
		            }
		            _this.find('.fa-spin').remove();
		            _this.parent(".fbpdu_more").before(response.html);
		            if(response.html != ""){
		            	_this.attr('data-offset',Number(response.limit) + Number(offset));
		            }else{
		            	_this.hide();
		            }

		        }
		    });
		});
	},
	loadmore: function(){
		$("body").on('click','#fbpdu_mores',function (event) {
		    event.preventDefault();
			let _this = $(this);
			let offset = _this.attr('data-offset');

			let parent_id = _this.attr('data-parent');
			let target_id = $("#idcate").val();
		    let type = $("#idcate").attr("data-controler");

			$.ajax({
		        type: "POST",
		        url: url_load_comment,
		        data: {offset,type,target_id},
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		        	if (response.type == "error") {
		            	Toastr[response.type](response.message);
		            	return false;
		            }
		            _this.find('.fa-spin').remove();
		            _this.parent(".fbpdu_mores").before(response.html);
		            if(response.html != ""){
		            	_this.attr('data-offset',Number(response.limit) + Number(offset));
		            }else{
		            	_this.hide();
		            }

		        }
		    });
		});
	},
	makeinputfile : function(){
		/*css input file*/
		var inputs = document.querySelectorAll( '#pducmt_wr--file' );
		Array.prototype.forEach.call( inputs, function( input )
		{
			var label	 = input.nextElementSibling,
				labelVal = label.innerHTML;

			input.addEventListener( 'change', function( e )
			{
				var fileName = '';
				if( this.files && this.files.length > 1 ){
					fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
				}else{
					fileName = e.target.value.split( '\\' ).pop();
					
				}
				
				if( fileName ){
					label.querySelector('span').innerHTML = fileName;
				}else{
					label.innerHTML = labelVal;
				}
	
			});
		});
	},
	submit_cmt: function(){/*edit,comment,rep comment*/
		$("body").on('click', '.submit_cmt', function(event) {
			event.preventDefault();
			let _this = $(this);
			let parent_id = _this.attr("data-idcmt");
			let content = _this.siblings('textarea').val();
			let id_edit = _this.attr("data-idedit");

			let target_id = $("#idcate").val();
		    let type = $("#idcate").attr("data-controler");
			let data_callback = {parent_id,content,target_id,type,id_edit};
			$.ajax({
		        url : base_url+'ajax/ajax_comment',
		        type: "POST",
		        data:data_callback,
		        dataType: "JSON",
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function(response) {
		        	_this.find('.fa-spin').remove();
		            if (response.type == "success") {
		            	if(response.action == "edit"){
		            		/*xu ly edit*/
		            		Toastr[response.type](response.message);
		            		
		            		_this.attr("data-idedit",0);
		            		_this.closest('.pducmt_item').find(".feedback_[data-idcmt ='"+id_edit+"']").find(".fbpdu_content").text(response.content);
		            		_this.closest('.pducmt_addcmt').hide();
		            		_this.text("Đăng");
		            	}else{
		            		/*xu ly add*/
		            		let result = filed_comment1.replace('{user_id}',response.info.user_id)
			            	.replace(/{fullname}/g,response.info.fullname)
			            	.replace('{avatar}',base_url+"public/"+response.info.avatar)
			            	.replace('{content}',response.info.content)
			            	.replace(/{id_comment}/g,response.info.id_comment);
			            	_this.closest('.pducmt_item').find(".feedback_rep").prepend(result);
			            	_this.closest('.pducmt_item').find(".feedback_rep").slideDown();
			            	_this.closest('.pducmt_addcmt').hide();
			            	
		            	}
		            
		            }else{
		            	Toastr[response.type](response.message);
		            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
		        }
		    });
		});
	},
	send_infovote: function(data_callback){

		$.ajax({
	        url : base_url+'ajax/ajax_comment',
	        type: "POST",
	        data:data_callback,
	        dataType: "JSON",
	        success: function(response) {
	            if (response.type == "success") {
	            let result = filed_comment.replace('{user_id}',response.info.user_id)
	            	.replace(/{fullname}/g,response.info.fullname)
	            	.replace('{avatar}',base_url+"public/"+response.info.avatar)
	            	.replace(/{id_comment}/g,response.info.id_comment)
	            	.replace('{content}',response.info.content);
	            	$(".pducmt_list").prepend(result);
	            	$('#pducmt_vote textarea').val("");
	            	$('#pducmt_vote label span').text("Choose image");
	            }else{
	            	Toastr[response.type](response.message);
	            }
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            console.log(errorThrown);
	            console.log(textStatus);
	            console.log(jqXHR);
	        }
	    });

	},
	uploadfile: function(oject=this){
		$("body").on('click','.btn_sendvote',function (ev) {
		    ev.preventDefault();
		    let _this = $(this);
		    let fileToUpload = $(this).siblings('input#pducmt_wr--file')[0].files[0];
		    
		    /*get data*/
		    let count_star = _this.attr("data-star");
		    let content = _this.siblings('textarea').val();
		    if(content == ""){
		    	Toastr["error"]("Bạn chưa viết nội dung đánh giá");
		    	return false;
		    }
		    let target_id = $("#idcate").val();
		    let type = $("#idcate").attr("data-controler");
		    var data_callback = {count_star,content,target_id,type};
		    /*get file*/
		    var formData = new FormData();
		    if(fileToUpload == undefined){
		    	return oject.send_infovote(data_callback);
		    }else{
		    	formData.append('imagevote', fileToUpload);/*dữ liệu json*/
		    }

		    $.ajax({
		        url : base_url+'ajax/ajax_vote',
		        type: "POST",
		        data:formData,
		        contentType: false,
		        processData: false,
		        dataType: "JSON",
		        success: function(response) {
		            if (typeof response.type == 'error') {
		                Toastr[response.type](response.message);
		    			return false;
		            }else{
		            	let files = response.file;
		            	data_callback.file = files;
		            	return oject.send_infovote(data_callback);
		            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
		        }
		    });
		});
	}

};
</script>
<script>
jQuery(document).ready(function($) {

	/*show fbpdu_more*/
	$("body").on('click', '.fbpdu_more2', function(event) {
		event.preventDefault();
		let _this = $(this);
		_this.closest('.pducmt_item').find('.feedback_rep').slideToggle('slow');
		/*callback ajax load sub comment*/
	});
	/*rantings*/
	$("#pducmt_vote .ratings li").click(function(event) {
		let _this = $(this);
		$("#pducmt_vote .ratings li").removeClass('selected');
		_this.addClass('selected');
		let value = _this.attr("data-val");
		_this.closest('#pducmt_vote').find(".btn_sendvote").attr("data-star",value);

	});
	/*show button comment*/
	$("body").on('keyup', '.pducmt_wr--ct textarea', function(event) {
		$(this).siblings('button').show();
		$(this).off('keyup');
	});
	$("body").on('click', '.fb_action_reply a', function(event) {
		event.preventDefault();
		let _this = $(this);
		let box_area = _this.closest('.pducmt_item').find(".pducmt_addcmt");
		let idcmt = _this.closest('.pducmt_item').attr("data-idcmt");/*lấy id thằng cha chính là pducmt_item thôi, cho đỡ for nhiều cấp để lấy sub comment*/
		box_area.toggle();

		box_area.find("textarea").val("@"+_this.attr("data-user")+": ");

		box_area.find("button.submit_cmt").attr("data-idcmt",idcmt);
		box_area.find("textarea").focus();
	});

	$("body").on('click', '.fb_action_edit a', function(event) {
		event.preventDefault();
		let _this = $(this);
		let idcmt = _this.closest('.feedback_').attr("data-idcmt");
		let content = _this.closest('.fbContent').find(".fbpdu_content").text();
		let box_area = _this.closest('.pducmt_item').find(".pducmt_addcmt");
		box_area.toggle();
		box_area.find("textarea")
		.val(content)
		.focus();
		box_area.find("button.submit_cmt")
		.attr("data-idedit",idcmt)
		.text("Cập nhật");
	});
});
</script>
















<style>
.feedback_ ul{
	margin:0;
}
.feedback_ {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  padding-bottom: 15px;
  margin-bottom: 15px;
}
.pducmt_item,.feedback_sub{
  border-bottom: 1px solid #eee;
  margin-bottom: 15px;
}
.feedbacker {
  -webkit-box-flex: 0;
      -ms-flex: 0 0 50px;
          flex: 0 0 50px;
  margin-right: 10px;
}
.feedbacker img {
  width: 50px;
  height: 50px;
  -o-object-fit: cover;
     object-fit: cover;
  border-radius: 50%;
}
.feedback_ .fbContent span {
  font-weight: bold;
  font-size: 16px;
}
.fbContent ul.fbpdu_star {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}
.fbContent ul.fbpdu_star span {
  font-size: 12px;
}
.fbContent ul.fbpdu_star span.fa-star{
	color: #ffba07;
}
 .fbContent p.fbpdu_content {
  margin: 5px 0;
  font-size: 15px;
}
.feedback_ .fbContent time {
  font-size: 13px;
  color: #999;
}
.feedback_ .fbContent time span {
  margin-right: 5px;
  font-weight: 100;
  font-size: 13px;
}

ul.fbpdu_action {
    display: flex;
    justify-content: flex-start;
    align-items: center;
}

ul.fbpdu_action li {
    padding: 5px 7px;
    margin: 0 5px;
}

ul.fbpdu_action li a {
    font-size: 15px;
    display: inline-block;
}
ul.fbpdu_action li span {
    font-size: 17px !important;
    display: inline-block;
    margin-right: 5px;
}

li.fb_action_like span {
    color: #41cc0d;
}

li.fb_action_repot span {
    color: #f40101;
}
.pducmt_wr {
    display: flex;
    justify-content: flex-start;
    
    margin-bottom: 15px;
    padding: 10px 0;
}


.pducmt_wr--user {
    flex-basis: 70px;
    margin-right: 15px;
}

.pducmt_wr--user img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.pducmt_wr--ct textarea {
    width: 100%;
    height: 70px;
    min-height: 60px;
    border: 2px solid #28a745;
}
.pducmt_wr--ct textarea:focus {
    border: 2px dashed #28a745;
}
.pducmt_wr .pducmt_wr--ct {
    flex-basis: 100%;
    display: block;
}

.feedback_rep .feedback_ {
    padding-bottom: 15px;
    border-bottom: 1px solid #d8d3d3;
    margin-left: 30px;
}
.feedback_rep {
    background: #dddbdb;
    margin-left: 20px;
    border-radius: 6px;
    padding: 10px 0;
    margin-bottom: 15px;
}
li.pducmt_item .pducmt_addcmt {
    margin-left: 30px;
}
.pducmt_wr--ct button {
    padding: 10px 30px;
    font-size: 16px;
    text-transform: capitalize;
    border-radius: 7px;
    float: right;
    margin-right: 30px;
}


.my_evaluate p {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  font-size: 18px;
}
.my_evaluate p span {
  color: #999;
  text-align: center;
  font-size: 14px;
}
.my_evaluate .ratings {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 100%;
  direction: rtl;
  text-align: center;
}
.my_evaluate .ratings .star {
  position: relative;
  line-height: 60px;
  display: inline-block;
  -webkit-transition: color 0.2s ease;
  -o-transition: color 0.2s ease;
  transition: color 0.2s ease;
  color: #ebebeb;
  cursor: pointer;
  -webkit-transition: all 0.5s;
  -o-transition: all 0.5s;
  transition: all 0.5s;
}
.my_evaluate .ratings .star:before {
  content: "★";
  font-size: 60px;
}
@media (max-width: 480px) {
  .my_evaluate .ratings .star:before {
    font-size: 40px;
  }
}
.my_evaluate .ratings .star:hover {
  -webkit-transform: scale(1.5);
      -ms-transform: scale(1.5);
          transform: scale(1.5);
  -webkit-transition: all 0.5s;
  -o-transition: all 0.5s;
  transition: all 0.5s;
}
.my_evaluate .star:hover,
.my_evaluate .star.selected,
.my_evaluate .star:hover ~ .star,
.my_evaluate .star.selected ~ .star {
  -webkit-transition: color 0.8s ease;
  -o-transition: color 0.8s ease;
  transition: color 0.8s ease;
  color: #ffba07;
}

.fbpdu_more a,.fbpdu_more2 a {
    display: block;
    font-size: 17px;
    font-weight: 700;
    padding: 3px 15px;
    margin-left: 30px;
    color: #666363;
}

.fbpdu_more a:hover {
    text-decoration: underline;
    color: #55acee;
}

.fbpdu_mores a {
    display: inline-block;
    padding: 5px 15px;
    font-size: 16px;
}

.fbpdu_mores {
    text-align: center;
}

.fbpdu_mores a:hover {
    text-decoration: underline;
}
/*css input file*/
label.custom-file-upload {
    font-size: 18px;
    color: #55acee;
}

label.custom-file-upload:hover {
    cursor: pointer;
    color: #205f8e;
}
ul.pducmt_list {
    padding-bottom: 50px;
}
.attach_file a {
    display: inline-block;
}

.attach_file a img {
    width: 85px;
    height: 85px;
    object-fit: contain;
    border-radius: 5px;
}

.user{
  width: 20px;
    height: 20px;
    display: inline-flex;
    font-family: FontAwesome;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    position: relative;
    border-radius: 50%;
    justify-content: center;
    align-items: center;
    margin: 0 3px;
}
.admincap2,.admincap3,.admincap1 {
    background: repeating-linear-gradient(to right,#317eb9 0,#64a8dc 50%,#7669de 100%);
}
.admincap2:before,.admincap3:before,.admincap1:before,.usercap0:before {
    content: "\f00c";
    color: #fff;
    font-size: 16px;
}

</style>