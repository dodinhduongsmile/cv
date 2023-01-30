// Dom Ready
$(function () {
    datatables_columns = [{
        field: "checkID",
        title: "#",
        width: 50,
        sortable: !1,
        textAlign: "center",
        selector: {class: "m-checkbox--solid m-checkbox--brand"}
    }, {
        field: "id",
        title: "ID",
        width: 50,
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
        width: 350
    }, {
        field: "is_featured",
        title: "Nổi bật",
        width: 70,
        textAlign: "center",
        template: function (t) {
            return '<span data-field="is_featured" data-value="' + (t.is_featured == 1 ? 0 : 1) + '" class="btnUpdateField">' + (t.is_featured == 1 ? '<i class="la la-star"></i>' : '<i class="la la-star-o"></i>') + "</span>"
        }
    }, {
        field: "is_status",
        title: "Status",
        width: 70,
        template: function (t) {
            var e = {
                0: {title: "Disable", class: "m-badge--danger"},
                1: {title: "Active", class: "m-badge--primary"},
            };
            return '<span data-field="is_status" data-value="' + (t.is_status == 1 ? 0 : 1) + '" class="m-badge ' + e[t.is_status].class + ' m-badge--wide btnUpdateField">' + e[t.is_status].title + "</span>"
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
    loadCategory();
    loadLayoutAttr();
    AJAX_CRUD_MODAL.init();
    AJAX_CRUD_MODAL.tinymce();
    SEO.init_slug();

    $('[name="is_status"]').on("change", function () {
        table.search($(this).val(), "is_status")
    }), $('[name="is_status"]').selectpicker();


    $(document).on('click', '.btnEdit', function () {
        let modal_form = $('#modal_form');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();
        AJAX_CRUD_MODAL.edit(function () {
            $.ajax({
                url: url_ajax_edit,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (response) {
                    $.each(response.data_info, function (key, value) {
                        let element = modal_form.find('[name="' + key + '"]');
                        element.val(value);
                        if (element.hasClass('switchBootstrap')) {
                            element.bootstrapSwitch('state', (value == 1 ? true : false));
                        }
                        if (key === 'content' && value) tinymce.get(element.attr('id')).setContent(response.data_info.content);
                        if (key === 'thumbnail' && value) element.closest('.form-group').find('img').attr('src', media_url + value);
                    });

                    loadCategory(response.data_category);
                    
                    //không gọi id mà gọi slugattr nên lúc sửa hơi lag, xóa bỏ mới load đc
                    loadLayoutAttr(response.data_categoryAttr);

                    modal_form.modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
            return false;
        });
    });
});

function loadCategory(dataSelected) {
    let selector = $('select.category');
    selector.select2({
        placeholder: 'Chọn danh mục',
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
function loadLayoutAttr(dataSelected) {
    let selector = $('select.layoutattr');
    selector.select2({
        placeholder: 'Chọn danh mục thuộc tính',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_categoryAttr,
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
