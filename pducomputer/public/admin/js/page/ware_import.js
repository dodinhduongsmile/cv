// Dom Ready
$(function() {
    datatables_columns = [{
        field: "checkID",
        title: "#",
        width: 50,
        sortable: !1,
        textAlign: "center",
        selector: {class: "m-checkbox--solid m-checkbox--brand"}
    },{
        field: "id",
        title: "ID",
        width: 50,
        textAlign: "center",
        sortable: 'asc',
        filterable: !1,
    }, {
        field: "title",
        title: "Tiêu đề",
        width: 150
    }, {
        field: "code",
        title: "Mã",
        width: 70,
        template: function (t) {
            return '<strong>'+t.code+'</strong>'
        }
    }, {
        field: "thumbnail",
        title: "Hình ảnh",
        textAlign: "center",
        width: 100,
        template: function (t) {
            thumbnail = t.thumbnail ? FUNC.getImageThumb(t.thumbnail) : base_url+'public/default-thumbnail.png';
            return '<img class="img-thumbnail" src="'+thumbnail+'">'
        }
    }, {
        field: "price",
        title: "Giá Nhập-Xuất",
        textAlign: "center",
        width: 100,
        template: function (t) {
            return '<div class="text_price"><input type="text" class="form-control number price" value="'+t.price+'"/><input type="text" class="form-control number price_sale" value="'+t.price_sale+'"/></div>'
        }
    }, {
        field: "countware",
        title: "Số lượng nhập",
        textAlign: "center",
        width: 100
    },{
        field: "countsell",
        title: "Số lượng xuất",
        textAlign: "center",
        width: 100
    },{
        field: "actionc",
        title: "Số lượng còn",
        textAlign: "center",
        width: 100,
        template: function (t, e, a) {
            html = `<strong> ${t.countware - t.countsell}</strong>`;
            return html;
        }
    },{
        field: "khochua",
        title: "ID kho chứa",
        width: 70
    },{
        field: "is_status",
        title: "Trạng thái",
        textAlign: "center",
        width: 80,
        template: function (t) {
            var e = {
                0: {title: "Chờ duyệt", class: "m-badge--danger"},
                1: {title: "Hiển thị", class: "m-badge--primary"},
            };
            html = '<span data-field="is_status" data-value="'+(t.is_status == 1 ? 0 : 1)+'" class="m-badge ' + e[t.is_status].class + ' m-badge--wide btnUpdateField">' + e[t.is_status].title + "</span>";
            return html;
        }
    }, {
        field: "action",
        width: 250,
        title: "Thông tin",
        sortable: !1,
        overflow: "visible",
        template: function (t, e, a) {
            content = `<li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-avatar"></i><span class="m-nav__link-text"> Người tạo : <strong>${t.username}</strong></span></span></li> 
            <li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-visible"></i><span class="m-nav__link-text"> Lượt vào xem : <strong>${t.viewed}</strong></span></span></li>
            <li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-calendar"></i><span class="m-nav__link-text"> Ngày tạo : <strong>${t.created_time}</strong></span></span></li>
            <li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-calendar"></i><span class="m-nav__link-text"> Cập nhật : <strong>${t.updated_time}</strong></span></span></li>
            <li class="m-nav__item mt-2 button_event">`;

            content += `${permission_edit ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnEdit">Sửa</span>' : ''}`;
            content += `${permission_delete ? '<span class="m-badge mr-2 m-badge--danger m-badge--wide btnDelete">Xóa</span>' : ''}`;

            return content;
        }
    }];
    AJAX_DATATABLES.init();
    AJAX_CRUD_MODAL.init();
    
    AJAX_CRUD_MODAL.tinymce();
    SEO.init_slug();
    //loadCategory vào cái thẻ có class select.category
    // loadProduct($('select.product'));
     loadKhochua($('select.khochua'));

    $('[name="is_status"]').on("change", function () {
        table.search($(this).val(), "is_status")
    }), $('[name="is_status"]').selectpicker();
    
   $(document).on('click','.btnEdit',function () {
        let modal_form = $('#modal_form');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();//lấy id
        AJAX_CRUD_MODAL.edit(function () {
            $.ajax({
                url : url_ajax_edit,
                type: "POST",
                data: {id:id},
                dataType: "JSON",
                success: function(response) {
                    $.each(response.data_info, function( key, value ) {
                        let element = modal_form.find('[name="'+key+'"]');
                        element.val(value);
                        // if(element.hasClass('switchBootstrap')){
                        //     element.bootstrapSwitch('state',(value == 1 ? true : false));
                        // }
                        if(key === 'thumbnail' && value) element.closest('.form-group').find('img').attr('src',media_url + value);
                        if(key === 'album' && value) FUNC.loadMultipleMedia(value);
                    });
                    if(response.edit == "edit"){
                        modal_form.find('[name="edit"]').val("edit");
                    }

                    let element = modal_form.find('[name="content"]');
                    if(element.hasClass('tinymce') && response.data_info.content){
                        tinymce.get(element.attr('id')).setContent(response.data_info.content);
                    }
                    element.val(response.data_info.content);
                    
                   
//thêm chọn kho chứa vào product
                    if(response.data_khochua) loadKhochua($('select.khochua'),response.data_khochua);
                    modal_form.modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });return false;
        });
    });
});




// function loadProduct(selector, dataSelected) {
//     selector.select2({
//         placeholder: 'Chọn sản phẩm',
//         allowClear: !0,
//         multiple: !1,
//         data: dataSelected,
//         ajax: {
//             url: url_ajax_load_product,
//             dataType: 'json',
//             delay: 250,
//             data: function (e) {
//                 return {
//                     q: e.term,
//                     page: e.page
//                 }
//             },
//             processResults: function (e, t) {
//                 // console.log(e);
//                 // for(var i =0; i< e.length; i++){
//                 //     console.log(media_url+e[1].thumbnail);
//                 // }
//                 return t.page = t.page || 1, {
//                     results: e,
//                     pagination: {
//                         more: 30 * t.page < e.total_count
//                     }
//                 }
//             },
//             cache: !0
//         }
//     });
//     if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
// }
function loadKhochua(selector, dataSelected) {
    selector.select2({
        placeholder: 'Chọn kho chứa',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_khochua,
            dataType: 'json',
            delay: 250,
            data: function (e) {//khi search chữ sẽ chạy hàm
                return {
                    q: e.term,//từ khóa seach
                    page: e.page
                }
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {
                    results: e,
                    pagination: {
                        more: 30 * t.page < e.total_count
                    }
                }
            },
            cache: !0
        }
    });
    if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
}

$('.searchproductpdu').keyup(function (event) {
        var elment = $(this);
        var q = elment.val();
        
        $.ajax({
            type: "POST",
            url: url_ajax_load_product,
            data:{q},
            dataType: 'html',
            beforeSend: function () {
                $(".pdusoft").find('.fa-spinner').show();
            },
            success: function (response) {
                $(".showproduct").show();
                $('.showproduct').html(response);
                $(".pdusoft").find('.fa-spinner').hide();
                // $('.select2').select2({
                //     allowClear: true,
                //     placeholder: 'Select an item'
                // });
                // showmenus(locationId);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });
//lấy dữ liệu item sp khi click chọn
$('body').on('click', '.search_item', function(event) {

        var elment = $(this);
        
        var id = elment.attr('data-id');

        $.ajax({
            type: "POST",
            url: url_ajax_load_product3,
            data:{id},
            dataType: 'json',
            beforeSend: function () {
                $(".pdusoft").find('.fa-spinner').show();
            },
            success: function (response) {
                let modal_form = $('#modal_form');
                $.each(response, function( key, value ) {
                        let element = modal_form.find('[name="'+key+'"]');
                        element.val(value);
                        // if(element.hasClass('switchBootstrap')){
                        //     element.bootstrapSwitch('state',(value == 1 ? true : false));
                        // }
                    });
                modal_form.find('[name="countware"]').val(0);//đặt value = 0, để nhâp
                modal_form.find('[name="edit"]').val("");//kích chọn sp khác thì sẽ hủy trạng thái edit sang add|update
                $(".showproduct").hide();
                $(".pdusoft").find('.fa-spinner').hide();
                // $('.select2').select2({
                //     allowClear: true,
                //     placeholder: 'Select an item'
                // });
                // showmenus(locationId);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });