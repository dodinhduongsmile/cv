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
	$("body").on('click','.custom-file-upload',function (event) {
		var inputs = document.querySelectorAll( '#pducmt_wr--file' );
		console.log(inputs);
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

jQuery(document).ready(function($) {

	/*show fbpdu_more*/
	$("body").on('click', '.fbpdu_more2', function(event) {
		event.preventDefault();
		let _this = $(this);
		_this.closest('.pducmt_item').find('.feedback_rep').slideToggle('slow');
		/*callback ajax load sub comment*/
	});
	/*rantings*/
	$("body").on('click', '#pducmt_vote .ratings li', function(event) {
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