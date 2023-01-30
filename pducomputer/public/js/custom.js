document.addEventListener("DOMContentLoaded", function() {
    Handle.init();
    lazyLoadDom();

});
var Toastr = {
    success : function(message){
        let t='<div class="alert alert-success alert-dismissible alert-ml" role="alert"\
            style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                '+message+' !\
            </div>';
            $('#show_success_mss').html(t).show();
                setTimeout(function(){
                    jQuery('#show_success_mss').fadeOut().empty();
                }, 3000);
        },
    error : function(message){
            let  t = '<div class="alert alert-danger alert-dismissible alert-ml" role="alert"\
                style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                    '+message+' !\
                </div>';
           
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 3000);
    },
    warning : function(message){
            let  t = '<div class="alert alert-danger alert-dismissible alert-ml" role="alert"\
                style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                    '+message+' !\
                </div>';
           
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 3000);
    }
                
};
let Handle = function() {

    const custom = () => {
        $('.numberic').keydown(function(event) {
            if (!(!event.shiftKey
                && !(event.keyCode < 48 || event.keyCode > 57)
                || !(event.keyCode < 96 || event.keyCode > 105)
                || event.keyCode == 46
                || event.keyCode == 8
                || event.keyCode == 190
                || event.keyCode == 9
                || (event.keyCode >= 35 && event.keyCode <= 39)
                )) {
                event.preventDefault();
            }
        });
        $('.number').keyup(function () {
            var number = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(number); 
        });

        //dsk
        $('body').on('click', '.searchsubmit', function(event) {
            event.preventDefault();
            let keyword = $(this).closest('.searchform').find('input[name="q"]').val();
            let type = $(this).closest('.searchform').find('[name="type"]').val();
            window.location.href = 'pa_ket-qua-tim-kiem.html?type='+type+'&q='+keyword;
        });

        $('body').on('change', '#sort_category', function(event) {
            event.preventDefault();
            let href = $('#sort_category :selected').val();
            window.location.href = href;
        });
        
        $('body').on('click', '.scrl_b', function(event) {
            let ok = $('html,body').offset().top + $('html,body').scrollTop();
            let ok2 = ok-700;
            $('html,body').animate({
                scrollTop: ok2
            });  
        });

        if ($(this).width() < 500) {
            let html_store = $('.list_store').clone();
            $('.list_store').remove();
            $('.content_store').html(html_store);
        }

        
    };

    const ajaxViewCart = () =>{
        $.ajax({
                url: '/cart/ajax_viewcart',
                type: 'POST',
                dataType: 'html',
                data: {},
            })
            .done(function(response) {

                $(".cart_ajaxpdu").html(response);
            })
    }
//thêm nhieu sp vào giỏ và chuyển hướng tới cart
    const addToCart = () => {
        $('body').on('click', '.btnAddToCart', function(event) {
            event.preventDefault();
            let _this = $(this);
            let check_cart = _this.attr("data-classify");
            
            let data_sku ="";
        if(check_cart != undefined){
            if($("#list-classifypdu").length){
                
                if(check_cart == 1){
                data_sku = _this.attr("data-sku");
                
                }else{
                    $(".classifypdu").find('.text-danger').remove();
                    $(".classifypdu").css({
                        border: '1px solid red'
                    });
                    $(".classifypdu").append("<p class='text-danger' style='color:red;'>* Bạn chưa chọn phân loại sản phẩm.</p>");
                    return false;
                }
            }
        }
            
            let product_id = _this.attr('data-id');
            var num_order = $("input.js-qty__num").val();
            $.ajax({
                url: '/cart/addCart',
                type: 'POST',
                dataType: 'JSON',
                data: {product_id,num_order,data_sku},
                beforeSend: function() {
                  _this.attr("disabled",'disabled');
                  _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
              },
            })
            .done(function(response) {
               $('.hd-cart .hd-cart-count').text(response.total_item);
                $('.qv-cart-total').html('TỔNG:<span>'+formatMoney(response.total_cart,0)+ 'đ</span>');

                Toastr[response.type](response.message);
                _this.find('.fa-spin').remove();
              _this.removeAttr("disabled");
                // document.getElementById("AddToCartForm").reset();
                $(".cart_ajaxpdu").load("/cart/ajax_viewcart");
                // ajaxViewCart();

            })
        });
    };
    //thêm nhieu sp vào giỏ và chuyển hướng tới cart
    const addToCartnow = () => {
        $('body').on('click', '.btnBuyNow', function(event) {
            event.preventDefault();
            let _this = $(this);
            let check_cart = _this.attr("data-classify");
            let data_sku ="";
            
        if(check_cart != undefined){
            if($("#list-classifypdu").length){
                
                if(check_cart == 1){
                data_sku = _this.attr("data-sku");
                
                }else{
                    $(".classifypdu").find('.text-danger').remove();
                    $(".classifypdu").css({
                        border: '1px solid red'
                    });
                    $(".classifypdu").append("<p class='text-danger' style='color:red;'>* Bạn chưa chọn phân loại sản phẩm.</p>");
                    return false;
                }
            }
        }


            let product_id = _this.attr('data-id');
            var num_order = $("input.js-qty__num").val();
            $.ajax({
                url: '/cart/addCart',
                type: 'POST',
                dataType: 'JSON',
                data: {product_id,num_order,data_sku},
                beforeSend: function() {
                  _this.attr("disabled",'disabled');
                  _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
              },
            })
            .done(function(response) {
                window.location.href = base_url+'cart.html';
            })
        });
    };


    const updateQuantity = () => {

        $('body').on('change', '.quality', function(event) {
            event.preventDefault();
            let this_    = $(this).closest('.item_cart');
            let quantity = this.value;
            let product_id = this_.find('.remove_item').attr('data-id');
            let identifier = this_.find('.remove_item').attr('data-identifier');
            $.ajax({
                url: '/cart/updateQuantity',
                type: 'POST',
                dataType: 'JSON',
                data: {quantity,product_id,identifier},
            })
            .done(function(response) {
                if (quantity == 0) {
                    this_.fadeOut('slow', function () {
                        this_.remove();
                    });
                }
                if (response.total_item == 0) {
                    $('.table tbody').html('<tr><td style="color: red;" colspan="6">Không có sản phẩm nào !!!</td><tr>');
                }
                $('.hd-cart .hd-cart-count').text(response.total_item);
                // $('.qv-cart-total').html('TỔNG:<span>'+response.total_cart+ 'đ</span>');
                $('.total_cart').html(response.total_cart+'<sup>₫</sup>');
                this_.find('.subtotal').html(response.subtotal+'<sup>₫</sup>');

                Toastr[response.type](response.message);
                $(".cart_ajaxpdu").load("/cart/ajax_viewcart");
            })
        });
    };

    const removeItem = () => {
        $('body').on('click', '.remove_item', function(event) {
            event.preventDefault();
            let this_      = $(this);
            let product_id = this_.attr('data-id');
            let identifier = this_.attr('data-identifier');
            $.ajax({
                url: '/cart/removeItem',
                type: 'POST',
                dataType: 'JSON',
                data: {product_id,identifier},
            })
            .done(function(response) {
                $('.hd-cart .hd-cart-count').text(response.total_item);
                // $('.qv-cart-total').html('TỔNG:<span>'+formatMoney(response.total_cart,0)+ 'đ</span>');
                $('.total_cart').html(response.total_cart+'<sup>₫</sup>');

                Toastr[response.type](response.message);
                if (response.type == 'success') {
                    this_.closest('.item_cart').fadeOut('slow', function () {
                        this_.closest('.item_cart').remove();
                    });
                }
                if (response.total_item == 0) {
                    $('.table tbody').html('<tr><td style="color: red;" colspan="6">Không có sản phẩm nào !!!</td><tr>');
                }
                $(".cart_ajaxpdu").load("/cart/ajax_viewcart");
            })
        });
    };

    const saveOrder = () => {
        $('body').on('click', '.save_order', function(event) {
            event.preventDefault();
            sb = $(this);
            $.ajax({
                url: '/cart/saveOrder',
                type: 'POST',
                dataType: 'JSON',
                data: $("form#cart_form").serialize(),
                beforeSend: function() {
                    sb.find('.icon_load').show();
                    sb.attr('disabled', 'disabled');
                },
            })
            .done(function(response) {
                sb.find('.icon_load').hide();
                sb.attr('disabled', false);
                $('#cart_form .text-danger').empty();

                
                if (response.type != 'success') {
                    $.each(response.validation,function (i, val) {
                        $('[name="'+i+'"]').after(val);
                    });

                }else{
                    
                    setTimeout(function(){ 
                        window.location.href = base_url+'done.html';
                    }, 500);
                }

                
               Toastr[response.type](response.message);

            });
        });
    };

//click vào chọn in báo giá
    const in_bao_gia = () => {
        $('body').on('click', '.in_bao_gia', function(event) {
            event.preventDefault();
            let product_id = $(this).attr('data-id');
            $.ajax({
                url: '/page/save_in_bao_gia',
                type: 'POST',
                dataType: 'JSON',
                data: {product_id},
            })
            .done(function(response) {
                window.location.href = base_url+'am_Bao-gia-tong-hop.html';
            })
        });
    };

    const remove_item_bao_gia = () => {
        $('body').on('click', '.remove_item_bg', function(event) {
            event.preventDefault();
            let product_id = $(this).attr('data-id');
            let this_ = $(this).closest('tr');
            $.ajax({
                url: '/page/remove_item_bao_gia',
                type: 'POST',
                dataType: 'JSON',
                data: {product_id},
            })
            .done(function(response) {
                toastr[response.type](response.message);
                this_.fadeOut('slow', function () {
                    this_.remove();
                });
                $('.total_price').html(response.total+'<sup>₫</sup>');
            })
        });
    };

    const update_item_bao_gia = () => {
        $('body').on('change', '.quantity_item_bg', function(event) {
            event.preventDefault();
            let this_ = $(this).closest('tr');
            let product_id = this_.find('.remove_item_bg').attr('data-id');
            let quantity   = this.value;
            $.ajax({
                url: '/page/update_item_bao_gia',
                type: 'POST',
                dataType: 'JSON',
                data: {product_id,quantity},
            })
            .done(function(response) {
                toastr[response.type](response.message);
                $('.total_price').html(response.total+'<sup>₫</sup>');
                this_.find('.subtotal').html(response.subtotal+'<sup>₫</sup>');
            })
        });
    };

    const send_contact = () => {
        $('body').on('click', '.sendContact', function(event) {
            event.preventDefault();
            $.ajax({
                url: '/contact/send_contact',
                type: 'POST',
                dataType: 'JSON',
                data: $('#formContactUs').serialize(),
            })
            .done(function(response) {
                $('#formContactUs .text-danger').empty();
                if (response.type != 'success') {
                    $.each(response.validation,function (i, val) {
                        $('[name="'+i+'"]').after(val);
                    });
                }else{
                    $('#formContactUs')[0].reset();
                }
                Toastr[response.type](response.message);
            })
        });
    };
const send_report = () => {
        $('body').on('click', '.submitReport', function(event) {
            event.preventDefault();
            $.ajax({
                url: '/contact/send_report',
                type: 'POST',
                dataType: 'JSON',
                data: $('#formReport').serialize(),
            })
            .done(function(response) {
                $('#formReport .text-danger').empty();
                if (response.type != 'success') {
                    $.each(response.validation,function (i, val) {
                        $('[name="'+i+'"]').after(val);
                    });
                }else{
                    $('#formReport')[0].reset();
                }
                Toastr[response.type](response.message);
            })
        });
    };



    return {
        init: function() {
            custom();
            addToCart();
            addToCartnow();

            removeItem();
            updateQuantity();
            saveOrder();
            
            in_bao_gia();
            remove_item_bao_gia();
            update_item_bao_gia();
            send_contact();
            send_report();
            // filter_price();
        }
    }
}();

function copy_code(thiss) {
  let _this = $(thiss);
 var copyText = _this.children('input')[0];
  copyText.select();
  copyText.setSelectionRange(0, 999999);
  document.execCommand("copy");
  Toastr['success']('Copy: '+copyText.value + ' thành công.');
}
var lazyLoadDom = function() {
    let lazyImages = [];
    lazyImages = lazyImages.slice.call(document.querySelectorAll(".lazyloadpd"));
    let active = false;
/*
window.innerHeight = độ cao của khung hình nhìn thấy
getBoundingClientRect().top vị trí của phần tử cách vị trí top của khung hình bao nhiêu px?
-> vị trí ảnh phải nằm trong khung nhìn thì mới chạy ajax
 */
    const lazyLoad = function() {
        if (active === false) {
            active = true;

            setTimeout(function() {
                lazyImages.forEach(function(lazyImage) {
                    if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                        lazyImage.src = lazyImage.dataset.src;
                        // lazyImage.onerror = onImageError;
                        lazyImage.classList.remove("lazyloadpd");

                        lazyImages = lazyImages.filter(function(image) {
                            return image !== lazyImage;
                        });

                        if (lazyImages.length === 0) {
                            document.removeEventListener("scroll", lazyLoad);
                            window.removeEventListener("resize", lazyLoad);
                            window.removeEventListener("orientationchange", lazyLoad);
                        }
                    }
                });

                active = false;
            }, 200);
        }
    };

    document.addEventListener("scroll", lazyLoad);
    window.addEventListener("resize", lazyLoad);
    window.addEventListener("orientationchange", lazyLoad);
    lazyLoad();
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}
function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}
function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
}
}
function slugpdu (title) {
    let slug;
    slug = title.toLowerCase();
    slug = slug.replace(/\//mig, "_");
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');

    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    // slug = slug.replace(/[^a-zA-Z0-9 ]/g, "");
    slug = slug.replace(/ /gi, "_");
    slug = slug.replace(/\-\-\-\-\-/gi, '_');
    slug = slug.replace(/\-\-\-\-/gi, '_');
    slug = slug.replace(/\-\-\-/gi, '_');
    slug = slug.replace(/\-\-/gi, '_');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    slug = slug.replace(/\s/g, "_");
    return slug;
}
// ajax


$('body').on('click', '.subscribe', function(event) {
            event.preventDefault();
            let elment = $(this);
            // console.log(elment.parents("#dkynhantin").serialize());
            $.ajax({
                url: base_url +"/ajax/ajaxsend_contact",
                type: 'POST',
                dataType: 'JSON',
                data: elment.parents('.dkynhantin').serialize(),
                 beforeSend: function () {
                    elment.parents('.dkynhantin').find('.fa-spinner').show();
                },
                success: function (response) {
                   $('.dkynhantin .text-danger').empty();
                        if (response.type != 'success') {
                            $.each(response.validation,function (i, val) {
                                $('[name="'+i+'"]').after(val);
                            });
                        }else{
                            elment.parents('.dkynhantin')[0].reset();
                        }
                        Toastr[response.type](response.message);
                        
                        $("#popup-subscribe").hide();
                        elment.parents('.dkynhantin').find('.fa-spinner').hide();
                        setTimeout(function(){
                            jQuery('#show_success_mss').fadeOut().empty();
                        }, 3000);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(thrownError);
                }
            })
        });
//ajax search
$('#searchtext').bind('keyup change paste propertychange',function (event) {
        var elment = $(this);
        var q = elment.val();
        
        $.ajax({
            type: "POST",
            url: base_url + "/search/ajax_loadseach",
            data:{q},
            dataType: 'json',
            beforeSend: function () {
                $(".search-wrapper").find('.fa-spinner').show();
            },
            success: function (response) {
                var html="";
                $.each(response,function(key, value ) {
                    html+="<a class='thumbs' href='"+value.url+"'> <img src='"+media_url+value.thumbnail+"'></a>";
                    html+="<a href='"+value.url+"'>"+value.title+"<span class='price-search'>"+formatMoney(value.price,0)+"đ</span></a>";
                });
                
                $('.search-wrapper').html(html);
                $(".search-wrapper").find('.fa-spinner').hide();
                if(q == ''){
                    $(".search-wrapper").html("");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });

//Quick View
$("body").on("click",".quick-view", function(event){
   event.preventDefault();
   let product_id = $(this).attr('data-id');
$.ajax({
        url: base_url +"/ajax/ajaxview_product",
        type: 'POST',
        dataType: 'html',
        data: {product_id},
         beforeSend: function () {
          $("#loadingpdu").show();
        },
        success: function (response) {
          $("#productQuickView").html(response);
          $("#productQuickView").show();
          $('#productQuickView .modal-content').css('opacity', '1');
          
          $("#loadingpdu").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
        }
    })
});

function convert_object_params_to_strings(params) {//convert json params thành string, ngăn cách =&
    var str = [];
    for (var key in params) {
        str.push(key + '=' + params[key]);
    }
    return str.join('&');//chuyển array thành string, ngăn bởi dấu & 
}
var paramspdu = {};
paramspdu['id'] = $("input#idcate").val();
//lọc và sắp xếp cho cả category và product type
function ajax_filter(data) {
    $.ajax({
        url: url_pagition,
        type: 'get',
        dataType: 'html',
        data: data,
         beforeSend: function () {
          $("#loadingpdu").show();
        },
        success: function (response) {
          $(".bodycatepdu").html(response);
          $("#loadingpdu").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
        }
    })
}
//filter old or new
$("body").on("click",".js_filternewlike", function(event){
        paramspdu['page'] = 1;// ví dụ đang ở trang 2 mà lọc sẽ hiện kết quả trang 2, nên phải xét về page =1
        paramspdu['newlike'] = $(this).attr("data-likenew");
        $(".js_filternewlike").removeClass('active');
        $(this).addClass('active');
        return ajax_filter(paramspdu);
    });

$("body").on("click",".js_pricefilterpdux", function(event){
        paramspdu['page'] = 1;// ví dụ đang ở trang 2 mà lọc sẽ hiện kết quả trang 2, nên phải xét về page =1
        $price_from = $(this).attr("data-price-from");
        $price_to = $(this).attr('data-price-to');

        paramspdu['price_from'] = $price_from;
        paramspdu['price_to'] = $price_to;
        return ajax_filter(paramspdu);
    });
//để vừa lọc và vẫn giữ phân trang thì khai báo global price_from để dùng riêng ở view category
var datafilter = {};
$("body").on("click",".js_pricefilterpdu", function(event){
   // event.preventDefault();
   paramspdu['page'] = 1;// ví dụ đang ở trang 2 mà lọc sẽ hiện kết quả trang 2, nên phải xét về page =1
   if(this.name == "button"){
    price_from = $(this).siblings('input.filter-price-from').val();
    price_to = $(this).siblings('input.filter-price-to').val();

    paramspdu["price_from"] = price_from;
    paramspdu["price_to"] = price_to;
    
   }else{

    // $('input[name*="attribute"]:checked').each(function(index, value) {
    //     datafilter.push(value.value);
    //     // datafilter[index] = value.value;
    // });
    let type = $(this).attr("data-type");
    datafilter[type] = $(this).val();
    paramspdu["datafilter"] = datafilter;
   }
   return ajax_filter(paramspdu);
});

//reset-filter
$("body").on("click",".reset-filter", function(event){
    let value =  $(this).attr('data-reset');

    $(this).siblings('li').children('input[name*="attribute"]:checked').attr('checked', false);
    
    delete paramspdu.datafilter[value];//xóa phần tử khỏi object hoặc mảng nhưng vẫn để lại lỗ trống
    // paramspc.datafilter.splice(value, 1);// xóa phần tử khỏi mảng, xóa cả lỗ trống
    return ajax_filter(paramspdu);
});
//sắp xếp category
$("body").on("change","#sortbypdu", function(event){
   // event.preventDefault();
   paramspdu['sortpdu'] = $(this).val();
    paramspdu['sortkey'] = $(this).children(":selected").attr("data-key");

   return ajax_filter(paramspdu);
});


