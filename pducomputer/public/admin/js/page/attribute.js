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
        field: "order",
        title: "Thứ tự",
        width: 70,
        template: function (t) {
            return '<input type="number" name="order" class="updateSort" value="'+t.order+'" />'
        }
    }, {
        field: "title",
        title: "Tiêu đề",
        width: 100
    }, {
        field: "parent_id",
        title: "ID cha",
        width: 100,
    }, {
        field: "type_img",
        title: "kiểu",
        width: 120
    }, {
        field: "is_status",
        title: "Status",
        textAlign: "center",
        width: 70,
        template: function (t) {
            var e = {
                0: {title: "Chờ duyệt", class: "m-badge--danger"},
                1: {title: "Hiển thị", class: "m-badge--primary"},
                
            };
            var ii = {
                0: {title: "Không lọc", class: "m-badge--info"},
                1: {title: "Lọc", class: "m-badge--success"},
            };

            html = '<span data-field="is_status" data-value="'+(t.is_status == 1 ? 0 : 1)+'" class="m-badge ' + e[t.is_status].class + ' m-badge--wide btnUpdateField">' + e[t.is_status].title + "</span>";
            html += '<span data-field="is_filter" data-value="'+(t.is_filter == 1 ? 0 : 1)+'" class="m-badge pdd ' + ii[t.is_filter].class + ' m-badge--wide btnUpdateField">' + ii[t.is_filter].title + "</span>";
            return html;
        }
    },{
        field: "is_featured",
        title: "hot",
        width: 70,
        textAlign: "center",
        template: function (t) {
            return '<span data-field="is_featured" data-value="'+(t.is_featured == 1 ? 0 : 1)+'" class="btnUpdateField">' + (t.is_featured == 1 ? '<i class="la la-star"></i>' : '<i class="la la-star-o"></i>') + "</span>"
        }
    }, {
        field: "action",
        width: 250,
        title: "Actions",
        sortable: !1,
        overflow: "visible",
        template: function (t, e, a) {
            content = `<li class="m-nav__item"><span class="m-nav__link">
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
    SEO.init_slug();
    loadCategory($('select.category'));

    $('[name="is_status"]').on("change", function () {
        table.search($(this).val(), "is_status")
    }), $('[name="is_status"]').selectpicker();

    $(document).on('click','.btnEdit',function () {
        let modal_form = $('#modal_form');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();
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
                        if(element.hasClass('switchBootstrap')){
                            element.bootstrapSwitch('state',(value == 1 ? true : false));
                        }
                    });
                    // $("select#type_img option[value='"+response.data_info.type_img+"']").attr('selected','selected');
                  
                    var obj = response.data_info.content;
                    // console.log(typeof(response.data_info.content));
                    // console.log(obj);
                    var noidung = "";
                    // noidung+= "<div class='itemtt box_value' style='display: flex;'>";
                    //     noidung+= "<input name='key[]' placeholder='Tên thuộc tính' class='form-control keyattr' type='text' value='' />";
                    //     noidung+= "<input name='content[]' placeholder='giá trị thuộc tính' class='form-control valueattr' type='text' value='' />";
                    //     noidung+= "<div class='btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete'>";
                    //     noidung+= "<span><i class='la la-trash-o'></i><span>Delete</span></span></div></div>";
                    $.each(obj, function(keyx, valuex) {
                        // console.log(valuex.key);
                        noidung+= "<div class='itemtt box_value' style='display: flex;'>";
                        noidung+= "<input name='key[]' placeholder='Tên thuộc tính' class='form-control keyattr' type='text' value='"+valuex.key+"' />";
                        noidung+= "<input name='content[]' placeholder='giá trị thuộc tính' class='form-control valueattr' type='text' value='"+valuex.value+"' />";
                        noidung+= "<div class='btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete'>";
                        noidung+= "<span><i class='la la-trash-o'></i><span>Delete</span></span></div></div>";
                        
                    });
                    $(".box_value_all").html(noidung);
                    
                    if(response.data_category) loadCategory($('select.category'),response.data_category);
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
function loadCategory(selector, dataSelected) {
    selector.select2({
        placeholder: 'Chọn danh mục cha',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_category,
            dataType: 'json',
            delay: 250,
            data: function (e) {
                return {
                    q: e.term,
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

function generate_slugpdu (title) {
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
$(document).ready(function() {
    
    $('body').on('click', '#add_field', function(event) {
      // var noidung = $(".box_value").get(0); //hoặc cái dưới
      var noidung = $(".box_value").eq(0).clone();
      $(this).prev(".box_value_all").append(noidung);
    });

    $('body').on('click', '.btn_delete', function(event) {
      /* Act on the event */
      $(this).parent(".box_value").remove();
  });

    $('.box_value_all').on('keyup', '.keyattr', function(event) {
        let slugkey = generate_slug_from_title($(this).val());
        $(this).siblings('.valueattr').val(slugkey);
    });

    $('input[name="title"]').bind('keyup paste',function (event) {
        let slugkey1 = generate_slugpdu($(this).val());
        $(".slugattr").val(slugkey1);
    });
  });