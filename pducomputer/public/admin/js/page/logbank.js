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
        field: "type",
        title: "type",
        textAlign: "center",
        width: 70,
        template: function (t) {
            var e = {
                1: {title: "rút", class: "m-badge--danger"},
                2: {title: "nạp", class: "m-badge--primary"},
            };
            return '<span class="m-badge ' + e[t.type].class + ' m-badge--wide">' + e[t.type].title + "</span>"
        }
    },{
        field: "amount",
        title: "Số lượng coin",
        width: 100,
        template: function (t) {
            return '<strong class="red">'+t.amount+'</strong>';
        }
    },{
        field: "is_status",
        title: "Status",
        textAlign: "center",
        width: 70,
        template: function (t) {
            var e = {
                0: {title: "hủy", class: "m-badge--danger"},
                1: {title: "chờ duyệt", class: "m-badge--danger"},
                2: {title: "thành công", class: "m-badge--success"},
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

            return content;
        }
    }];
    AJAX_DATATABLES.init();
    AJAX_CRUD_MODAL.init();
    SEO.init_slug();

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
                        if(key === 'created_time'){
                            modal_form.find('[id="'+key+'"]').text(value);
                        }else{
                            modal_form.find('[name="'+key+'"]').val(value);
                        }
                    });
                    if(response.data_user){
                        modal_form.find('[name="user_id"]').val(response.data_user.email);
                    }
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
