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
    },{
        field: "email",
        title: "email User",
        width: 150,
        template: function (t) {
            return '<span><strong>'+t.email+'</strong></span>';
        }
    }, {
        field: "edu_id",
        title: "edu id",
        textAlign: "center",
        width: 70,
    },{
        field: "price",
        title: "giá mua",
        width: 100,
        template: function (t) {
            return '<strong class="red">'+t.price+'</strong>';
        }
    },{
        field: "is_status",
        title: "Status",
        textAlign: "center",
        width: 80,
        template: function (t) {
            var e = {
                0: {title: "chờ", class: "m-badge--danger"},
                1: {title: "No Drive", class: "m-badge--primary"},
                2: {title: "Yes Drive", class: "m-badge--success"},
            };
            return '<span class="m-badge ' + e[t.is_status].class + ' m-badge--wide">' + e[t.is_status].title + "</span>"
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
$('.select_searchpdu[name="is_status"]').on("change", function () {
        table.search($(this).val(), "is_status")
    }), $('.select_searchpdu[name="is_status"]').selectpicker();

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
                        if(key == 'created_time' || key == 'edu_title' || key == 'user_email'){
                            modal_form.find('[id="'+key+'"]').val(value);
                        }else{
                            modal_form.find('[name="'+key+'"]').val(value);
                        }
                    });

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
