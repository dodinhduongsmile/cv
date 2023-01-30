var paramspc = {};
paramspc['cauhinh'] = 'ch1';
document.addEventListener("DOMContentLoaded", function() {
    Buildpc.init();
    // Buildpc.Test.test1();
    
});

var Buildpc = {
    init : function(){
       this.showpopup(); 
       this.ajax_filter(); 
       this.Cartbuilpc(); 
    },
    Test : {
        test1 : function(){
            console.log("test1");
        }
    },
    showpopup : function(){
        $("body").on('click', '.open-selection', function(event) {
            event.preventDefault();
            let datainfo = $(this).data("info");
            paramspc['id'] = datainfo.id;
            paramspc['layout'] = datainfo.layout;
            // console.log(paramspc);
            $.ajax({
                url: base_url +"/product/ajax_buildpc",
                type: 'get',
                dataType: 'html',
                data: paramspc,
                 beforeSend: function () {
                  $("#loadingpdu").show();
                },
                success: function (response) {
                    // console.log(response);
                  $("#js-modal-popup").html(response);

                  $(".mask-popup").addClass('active');
                  $("#loadingpdu").hide();
                  checked_filter_search();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(thrownError);
                }
            })
        });
        
    },
    ajax_filter: function(){
            const runfilterajax = (data) => {
                    $.ajax({
                    url: base_url +"/product/ajax_buildpc",
                    type: 'get',
                    dataType: 'html',
                    data: paramspc,
                     beforeSend: function () {
                      $("#loadingpdu").show();
                    },
                    success: function (response) {
                        // console.log(response);
                      $("#js-modal-popup").html(response);

                      $(".mask-popup").addClass('active');
                      $("#loadingpdu").hide();

                      setTimeout(function() {
                         checked_filter_search();
                    },500);
                      
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr);
                        console.log(thrownError);
                    }
                });
            };
            
        //sort
        $("body").on("change","#sortbybuilpc", function(event){
           // event.preventDefault();
           paramspc['sortpdu'] = $(this).val();
            paramspc['sortkey'] = $(this).children(":selected").attr("data-key");
           return runfilterajax(paramspc);
        });
        //filter
        $("body").on("click",".js_pricefilterpcx", function(event){
            paramspc['page'] = 1;// ví dụ đang ở trang 2 mà lọc sẽ hiện kết quả trang 2, nên phải xét về page =1
            $price_from = $(this).attr("data-price-from");
            $price_to = $(this).attr('data-price-to');

            paramspc['price_from'] = $price_from;
            paramspc['price_to'] = $price_to;
            return runfilterajax(paramspc);
        });

        var datafilter = {};
        //filter2
        $("body").on("click",".js_pricefilterpc", function(event){
           // event.preventDefault();
           paramspc['page'] = 1;// ví dụ đang ở trang 2 mà lọc sẽ hiện kết quả trang 2, nên phải xét về page =1
           if(this.name == "button"){
            price_from = $(this).siblings('input.filter-price-from').val();
            price_to = $(this).siblings('input.filter-price-to').val();

            paramspc["price_from"] = price_from;
            paramspc["price_to"] = price_to;
            
           }else{
            // $('input[name*="attribute"]:checked').each(function(index, value) {
            //     datafilter.push(value.value);
            // });
            let type = $(this).attr("data-type");
            datafilter[type] = $(this).val();
            paramspc["datafilter"] = datafilter;//add element to object paramspc
           }
           
           return runfilterajax(paramspc);
        });
        //reset-filter
        $("body").on("click",".reset-filter", function(event){
            let value =  $(this).attr('data-reset');

            $(this).siblings('li').children('input[name*="attribute"]:checked').attr('checked', false);
            
            delete paramspc.datafilter[value];//xóa phần tử khỏi object hoặc mảng nhưng vẫn để lại lỗ trống
            // paramspc.datafilter.splice(value, 1);// xóa phần tử khỏi mảng, xóa cả lỗ trống
            return runfilterajax(paramspc);
        });
        //search pc

        $("body").on("click","#js-buildpc-search-btn", function(event){
             event.preventDefault();
             let datafilter = [];
             datafilter.push($(this).siblings("#buildpc-search-keyword").val());
            paramspc['datafilter'] = datafilter;
            
            return runfilterajax(paramspc);
           
        });

    },
    Cartbuilpc : function(){
        const save_item_pc = () => {
            $('body').on('click', '.save_item_pc', function(event) {
                event.preventDefault();
                let product_id = $(this).attr('data-id');
                let cate_id = paramspc['id'];
                let cauhinhpc = paramspc['cauhinh'];
                $.ajax({
                    url: '/page/save_item_pc',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {product_id,cate_id,cauhinhpc},
                })
                .done(function(response) {
                    Toastr[response.type](response.message);
                    $(".mask-popup").removeClass('active');
                    
                    $("#js-selected-item-"+cate_id).html(response.html);
                    $('.total-price-config').html(response.total+'<sup>₫</sup>');
                    
                })
            });
        };

        const remove_item_pc = () => {
            $('body').on('click', '.remove_item_pc', function(event) {
                event.preventDefault();
                let cauhinhpc = paramspc['cauhinh'];
                let product_id = $(this).attr('data-id');
                let this_ = $(this).closest('.contain-item-drive');

                $.ajax({
                    url: '/page/remove_item_pc',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {product_id,cauhinhpc},
                })
                .done(function(response) {
                    Toastr[response.type](response.message);
                    this_.fadeOut('slow', function () {
                        this_.remove();
                    });
                    $('.total-price-config').html(response.total+'<sup>₫</sup>');

                 });
            });
        };

        const update_item_pc = () => {
            $('body').on('change', '.quantity_item_pc', function(event) {
                event.preventDefault();
                let this_ = $(this).closest('.item-drive');
                let product_id = this_.find('.remove_item_pc').attr('data-id');
                let quantity   = this.value;
                let cauhinhpc = paramspc['cauhinh'];
                $.ajax({
                    url: '/page/update_item_pc',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {product_id,quantity,cauhinhpc},
                })
                .done(function(response) {
                    Toastr[response.type](response.message);
                    $('.total-price-config').html(response.total+'<sup>₫</sup>');
                    this_.find('.sum_price').html(response.subtotal+'<sup>₫</sup>');
                })
            });
        };

        const edit_item_pc = () => {
            $("body").on('click', '.edit_item_pc', function(event) {
                // event.preventDefault();
                console.log("msg");
                $(this).closest('.drive-checked').children('.open-selection').trigger('click');
                
            });
        };

        //
        const showBuildId = () => {
            $("body").on('click', '.showBuildId', function(event) {
                $_this = $(this);
                paramspc['cauhinh'] = $(this).attr("data-ch");
                let cauhinhpc = paramspc['cauhinh'];
                $.ajax({
                    url: '/page/changeCH',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {cauhinhpc},
                })
                .done(function(response) {
                    $_this.closest('ul').children('li').removeClass('active');
                    $_this.parent("li").addClass('active');
                    $(".list-drive").html(response.html);
                    // Toastr[response.type](response.message);
                    $('.total-price-config').html(response.total+'<sup>₫</sup>');
                    // $('.contain-item-drive').remove();
                })
            }); 
            
        };
        
        save_item_pc();remove_item_pc();update_item_pc();edit_item_pc();showBuildId();
            
        
        
    },
    Buildpc2 : {
        openPopupRebuild : function(){
            
            if(confirm("Làm mới sẽ xóa tất cả cấu hình. Bạn vẫn muốn thực hiện chứ?")){
                $.ajax({
                    url: '/page/delete_buildpc',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {},
                })
                .done(function(response) {
                    Toastr[response.type](response.message);
                    $('.total-price-config').html('0 <sup>₫</sup>');
                    $('.contain-item-drive').remove();
                })
            }
        }
    }

};//end Buildpc

/*checked vào ô đang search*/
const checked_filter_search = () =>{
    $(`.js_pricefilterpcx[data-price-to="${paramspc['price_to']}"]`).attr('checked', true);//prop đặt thuộc tính cho ptu
    
    // console.log(paramspc);
    for (var key in paramspc.datafilter) {//loop object
        // console.log(`.js_pricefilterpc[name*="attribute"][value="${paramspc.datafilter[key]}"]`);
        $(`.js_pricefilterpc[name*="attribute"][value="${paramspc.datafilter[key]}"]`).attr('checked', true);
    }
};
/*xóa bỏ checked khi đóng popup*/
const reset_filter_search = () =>{
    paramspc.datafilter = [];
};
jQuery(document).ready(function($) {
    $(".download_excel_listpc").click(function(event) {
    let cauhinhpc = paramspc['cauhinh'];

        $.ajax({
            url: '/page/download_excel_listpc',
            type: 'POST',
            dataType: 'json',
            data: {cauhinhpc},
        })
        .done(function(response) {
            Toastr[response.type](response.message);
            window.location = response.linkdownload;
         });
    });

    $(".add_cart_listpc").click(function(event) {
    let cauhinhpc = paramspc['cauhinh'];

        $.ajax({
            url: '/page/add_cart_listpc',
            type: 'POST',
            dataType: 'json',
            data: {cauhinhpc},
        })
        .done(function(response) {
            Toastr[response.type](response.message);
            $('.hd-cart .hd-cart-count').text(response.total_item);
            // $('.contain-item-drive').remove();
            // $(".cart_ajaxpdu").load("/cart/ajax_viewcart");
            window.location.href = base_url+'cart.html';
         });
    });
    $(".print_view").click(function(event) {
        let cauhinhpc = paramspc['cauhinh'];
        let type = "buildpc";
        window.location = base_url+'/page/view_print/?type='+type+'&cauhinh='+cauhinhpc;
    });

});
function get_date() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = dd + '/' + mm + '/' + yyyy;
    return today;
}