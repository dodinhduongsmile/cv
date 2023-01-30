	
function cms_user_ajax($param) {
    $.ajax({
        url: $param.url,
        type: $param.type,
        data: $param.data,
        async : true,//default true,có xử lý bất động bộ, khi nhận dữ liệu trả về nó mới chạy success (beforeSend ->success) , false thì không xử lý bất động bộ, cái nào ít thời gian xử lý hơn thì chạy trước.
        dataType: $param.dataType,
        beforeSend: function() {
        	$param._this.attr("disabled",'disabled');
	        $param._this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
	    },
        success: function (response) {
            $('.text-danger').remove();
            if (typeof response.type !== 'undefined') {
            	$('.noficationajax').remove();
            	$param._form.find('.fa-spin').remove();
            	$param._this.removeAttr("disabled");
                Toastr[response.type](response.message);
                if (response.type === "warning") {
                    $.each(response.validation,function (i, val) {
                        $('[name="'+i+'"]').after(val);
                    });
                } else {
                	$param.callbackss(response);
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
            console.log(ajaxOptions);
            Toastr['error']("The action you have requested is not allowed.");
        }
    });
};
/*rút coin withdraw*/

/*rút coin withdraw*/
function pd_deposit(thiss) {
	let _this = $(thiss);
	let _form = $('.forminfo');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/deposit_coin/',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function (response) {
        	$("input[name='password']").val('');
        	_form.append('<p class="noficationajax">'+response.message+'</p>');
        }
    };
    return cms_user_ajax($param);
};
/*rút coin withdraw*/
function pd_withdraw(thiss) {
	let _this = $(thiss);
	let _form = $('.forminfo');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/withdraw_coin/',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function (response) {
        	$("input[name='password']").val('');
        	_form.append('<p class="noficationajax">'+response.message+'</p>');
        }
    };
    return cms_user_ajax($param);
};
/*saveinfo*/
function pd_updateinfo(thiss) {
	let _this = $(thiss);
	let _form = $('.forminfo');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/ajax_saveinfo/',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function () {
        	
        }
    };
    return cms_user_ajax($param);
};
/*btn_updatepass*/
function pd_updatepass(thiss) {
	let _this = $(thiss);
	let _form = $('.forminfo');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/update_password/',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function () {
        	_form[0].reset();
        }
    };
    return cms_user_ajax($param);
};
function pd_updatebank(thiss) {
	let _this = $(thiss);
	let _form = $('.forminfo');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/update_banking/',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function () {
        	$("input[name='password']").val('');
        }
    };
    return cms_user_ajax($param);
};
function pd_forgotpass(thiss) {
	let _this = $(thiss);
	let _form = $('.register_form');
	let uri = $("#forgotten_password_code").val();
	if(uri == undefined){uri = ''};
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/forgotpass/'+uri,
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function (response) {
        	_form[0].reset();
        	_form.append('<p class="noficationajax">'+response.message+'</p>');
            if(response.redirect){
            	setTimeout(function () {
                	location.href = response.redirect;
            	},1500);
            }
        }
    };
    return cms_user_ajax($param);
};
function pd_login(thiss) {
	let _this = $(thiss);
	let _form = $('.login_form');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/ajax_login/',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function (response) {
        	_form[0].reset();
        	_form.append('<p class="noficationajax">'+response.message+'</p>');
            if(response.redirect){
            	setTimeout(function () {
                	location.href = response.redirect;
            	},1500);
            }
        }
    };
    return cms_user_ajax($param);
};
function pd_register(thiss) {
	let _this = $(thiss);
	let _form = $('.register_form');
	let $param = {
		'_this' : _this,
		'_form' : _form,
        'type': 'POST',
        'url': base_url+'user/ajax_register',
        'data': _form.serialize(),
        'dataType': 'json',
        'callbackss': function (response) {
        	_form[0].reset();
        	_form.append('<p class="noficationajax">'+response.message+'</p>');
            if(response.redirect){
            	setTimeout(function () {
                	location.href = response.redirect;
            	},1500);
            }
        }
    };
   return cms_user_ajax($param);
};


jQuery(document).ready(function($) {
$('.boxmenu_item a[href="' + window.location.href + '"]').addClass('active_info');

$("body").on('click','.boxmenu_item a',function (ev) {
    ev.preventDefault();
    let _this = $(this);
    let url = _this.attr('href').replace(base_url+'user/','');

    $.ajax({
        type: "POST",
        url: base_url+'user/'+url,
        data: {url},
        dataType: 'json',
        beforeSend: function() {
          $(".preloader").show();
        },
        success: function (response) {
        	
        	$(".boxmenu_list a").removeClass('active_info');
        	_this.addClass('active_info');
        	$(".account_title").text(response.title);
        	$(".boxuser_content").html(response.html);
        	
        	window.history.pushState({'pageTitle':response.title,'html':response.html}, response.title, url);
        	document.title = response.title;
        	window.onpopstate = (event) => {
        		if(event.state){
			        document.title = event.state.pageTitle;
			        document.getElementsByClassName("boxuser_content")[0].innerHTML = event.state.html;
			        //alert(`location: ${document.location}, state: ${JSON.stringify(event.state)}`);
			    }
			}
        	// history.replaceState(stateObj, '', 'bar2.html');
        	$(".preloader").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
            console.log(ajaxOptions);
            Toastr['error']("The action you have requested is not allowed.");
        }
    });
    
});
/*refect load lại content*/
function ajax_load(ev) {
    let url = window.location.href;
    $.ajax({
        type: "POST",
        url: url,
        data: {url},
        dataType: 'json',
        beforeSend: function() {
          $(".loaderpdu").show();
        },
        success: function (response) {
        	
        	$(".account_title").text(response.title);
        	$(".boxuser_content").html(response.html);
        	$(".loaderpdu").hide();
        }
    });
};
/*load address*/
$('body').on('change','#city',function () {
    let code = $(this).children(":selected").val();
    $.getJSON(base_url+'public/json/quan-huyen/'+code+'.json', function(result){
    	let html="";
    	$.each(result,function(index, value) {
	        html+= "<option value='"+value.code+"'>"+value.name_with_type+"</option>";
	    });
	   $("#district").html(html);
    });
});
$('body').on('change','#district',function () {
    let code = $(this).children(":selected").val();
    $.getJSON(base_url+'public/json/xa-phuong/'+code+'.json', function(result){
    	let html="";
    	$.each(result,function(index, value) {
	        html+= "<option value='"+value.code+"'>"+value.name_with_type+"</option>";
	    });
	   $("#commune").html(html);
    });
});
/*Load more*/
$("body").on('click','#btn_loadmore',function (event) {
    event.preventDefault();
	let _this = $(this);
	let offset = _this.attr('data-offset');
	let url = window.location.href.replace(base_url+'user/','');
	$.ajax({
        type: "POST",
        url: base_url+'user/'+url,
        data: {url,offset},
        dataType: 'json',
        beforeSend: function() {
          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
        },
        success: function (response) {
            _this.find('.fa-spin').remove();
            $(".list_order").append(response.html);
            if(response.html != ""){
            	_this.attr('data-offset',Number(response.limit) + Number(offset));
            }else{
            	_this.hide();
            }

        }
    });
});
/*pagination phân trang*/
$("body").on("click",".ajaxpagination", function(event){
   event.preventDefault();
   let page = $(this).children("a").attr("data-ci-pagination-page");
   let url = $(this).parents(".urlajax").attr("data_url");
	$.ajax({
        url: url+page,
        type: 'get',
        dataType: 'json',
        data: {page},
         beforeSend: function () {
          $(".loaderpdu").show();
        },
        success: function (response) {
        	$(".history").html(response.html);
          $(".loaderpdu").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
        }
    })
});

$("body").on("click","#cancel_bank", function(event){
    let id = $(this).data('id');
    let  note = prompt("Lí do hủy đơn của bạn?");
    if(note){
            $.ajax({
                type: "POST",
                url: base_url + "user/ajax_cancel_bank",
                data:{id,note},
                dataType: 'json',
                success: function (response) {
                if (typeof response.type !== 'undefined') {
	                Toastr[response.type](response.message);
	                ajax_load();
	            }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(thrownError);
                }
            });
        }else{
            confirm("Bạn cần phải ghi lí do hủy đơn, mới hủy được ạ.");
            return false;
        }
    });
/*update field,content*/
$("body").on("click",".withdraw_total", function(event){
    let type = $(this).data('type');
    if(confirm("Bạn muốn rút hết coin về ví tổng?")){
        $.ajax({
            type: "POST",
            url: base_url + "user/withdraw_total",
            data:{type},
            dataType: 'json',
            success: function (response) {
            if (typeof response.type !== 'undefined') {
                Toastr[response.type](response.message);
                //ajax_load();
            }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    }else{
        return false;
    }
});
/*sidebar*/
$(".show_sidebar").click(function(event) {
	$(".boxmenu").slideToggle();
});
/*change avatar*/
$("body").on('click','.changelogo',function (ev) {
    let _this = $(this);
	/* Act on the event */
	$("#userlogo").click();
	$("#userlogo").change(function(e){
        // console.log(e.target.value);
        // this là #userlogo
        _this.text("Change: "+this.files[0].name);
		$('.updatelogo').show();

	});
});

$("body").on('click','.updatelogo',function (ev) {
    ev.preventDefault();
    let _this = $(this);
    let fileToUpload = _this.siblings('#userlogo')[0].files[0];
    if(fileToUpload == undefined){
    	return false;
    }
    
    var formData = new FormData();
     	formData.append('avatar', fileToUpload);/*dữ liệu json*/
        // console.log(formData);
    $.ajax({
        url : base_url+'user/ajax_update_logo',
        type: "POST",
        data:formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(response) {
            if (typeof response.type !== 'undefined') {
                Toastr[response.type](response.message);
                _this.siblings('img').attr("src",base_url+"public/"+response.file);
                _this.hide();
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


/*view pass*/
$("body").on('click','.boxpass i',function (event) {
	let input = $(this).siblings('input');
	if (input[0].type === "password") {
    	input[0].type = "text";
  	} else {
    	input[0].type = "password";
  	}
});






});/*end*/

document.addEventListener("DOMContentLoaded", function() {
    Acountfe.init();
    
});
var Acountfe = {
    init : function(){
       //this.user(); 
       //this.login(); 
       //this.forgotpass(); 
    },
    user : function(){
    	$("body").on('click', '#pduregister', function(event) {
    		event.preventDefault();
    		let _this = $(this);
    		let $form = $('.register_form');
    		
    		$.ajax({
		        type: "POST",
		        url: base_url+'user/ajax_register',
		        data: $form.serialize(),
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		            $form.find('.fa-spin').remove();
		            $('.text-danger').remove();
		                if (typeof response.type !== 'undefined') {
		                    Toastr[response.type](response.message);
		                    if (response.type === "warning") {
		                        $.each(response.validation,function (i, val) {
	                                $('[name="'+i+'"]').after(val);
	                            });
		                    } else {
		                        // $form.reset();
		                        _this.attr("disabled",'disabled');
		                        setTimeout(function () {
		                            location.href = base_url+'user/login';
		                        },2000);
		                    }
		                }
		          
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		            console.log(xhr);
		            console.log(thrownError);
		            console.log(ajaxOptions);
		            Toastr['error']("The action you have requested is not allowed.");
		        }
		    });
    	});
    },
    login : function(){
    	$("body").on('click', '#btn_loginpdu', function(event) {
    		event.preventDefault();
    		let _this = $(this);
    		let $form = $('.login_form');
    		
    		$.ajax({
		        type: "POST",
		        url: base_url+'user/ajax_login',
		        data: $form.serialize(),
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		            $form.find('.fa-spin').remove();
		            $('.text-danger').remove();
		                if (typeof response.type !== 'undefined') {
		                    Toastr[response.type](response.message);
		                    if (response.type === "warning") {
		                        $.each(response.validation,function (i, val) {
	                                $('[name="'+i+'"]').after(val);
	                            });
		                    } else {
		                        //$form.reset();
		                        _this.attr("disabled",'disabled');
		                        setTimeout(function () {
		                            location.href = base_url+'user/info';
		                        },2000);
		                    }
		                }
		          
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		            console.log(xhr);
		            console.log(thrownError);
		            console.log(ajaxOptions);
		            Toastr['error']("The action you have requested is not allowed.");
		        }
		    });
    	});
    },
    forgotpass : function(){
    	$("body").on('click', '#btn_forgotpass', function(event) {
    		event.preventDefault();
    		let _this = $(this);

    		let $form = $('.register_form');
    		let uri = $("#forgotten_password_code").val();
    		if(uri == undefined){uri = ''};
    		$.ajax({
		        type: "POST",
		        url: base_url+'user/forgotpass/'+uri,
		        data: $form.serialize(),
		        dataType: 'json',
		        beforeSend: function() {
		          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
		        },
		        success: function (response) {
		            $form.find('.fa-spin').remove();
		            $('.text-danger').remove();
		                if (typeof response.type !== 'undefined') {
		                    Toastr[response.type](response.message);
		                    if (response.type === "warning") {
		                        $.each(response.validation,function (i, val) {
	                                $('[name="'+i+'"]').after(val);
	                            });
		                    } else {
		                        //$form.reset();
		                        _this.attr("disabled",'disabled');
		                        $form.append('<p class="nofication">'+response.message+'</p>');
		                        if(response.redirect){
		                        	setTimeout(function () {
		                            	location.href = response.redirect;
		                        	},3000);
		                        }
		                        
		                    }
		                }
		          
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		            console.log(xhr);
		            console.log(thrownError);
		            console.log(ajaxOptions);
		            Toastr['error']("The action you have requested is not allowed.");
		        }
		    });
    	});
    	
    }

};/*end Acountfe*/