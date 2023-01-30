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
        field: "code",
        title: "Mã đơn hàng",
        width: 100
    }, {
        field: "full_name",
        title: "Khách hàng",
        width: 240,
        template: function (t) {
            return '<span><strong>'+t.full_name+'</strong></span></br><span>'+t.email+'</span>';
        }
    }, {
        field: "phone",
        title: "Số điện thoại",
        width: 100
    }, {
        field: "total_amount",
        title: "Tiền đơn",
        width: 100,
        template: function (t) {
            return '<strong class="red">'+t.total_amount+'</strong>';
        }
    }, {
        field: "is_status",
        title: "Trạng thái đơn",
        textAlign: "center",
        width: 100,
        template: function (t) {
            var e = {
                0: {title: "Huỷ đơn", class: "m-badge--danger"},
                1: {title: "Chờ xác nhận", class: "m-badge--primary"},
                2: {title: "Đã xác nhận", class: "m-badge--primary"},
                3: {title: "Đã giao", class: "m-badge--success"},
                4: {title: "Hoàn trả", class: "m-badge--danger"},
            };
            return '<span class="m-badge ' + e[t.is_status].class + ' m-badge--wide">' + e[t.is_status].title + "</span>"
        }
    }, {
        field: "pay_status",
        title: "Trạng thái Pay",
        textAlign: "center",
        width: 100,
        template: function (t) {
            var e = {
                0: {title: "Huỷ đơn", class: "m-badge--danger"},
                1: {title: "Chưa thanh toán", class: "m-badge--primary"},
                2: {title: "Đã thanh toán", class: "m-badge--success"},
                3: {title: "Hoàn trả", class: "m-badge--danger"},
            };
            return '<span class="m-badge ' + e[t.pay_status].class + ' m-badge--wide">' + e[t.pay_status].title + "</span>"
        }
    }, {
        field: "action",
        width: 250,
        title: "Thông tin",
        sortable: !1,
        overflow: "visible",
        template: function (t, e, a) {
            content = `<li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-calendar"></i><span class="m-nav__link-text"> Ngày mua : <strong>${t.created_time}</strong></span></span></li>
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
                    $('#order_detail').empty();
                    $.each(response.data_info, function( key, value ) {
                        if(key === 'is_status' || key ==='pay_status' || key === 'id' || key === 'content' || key === 'shipping' || key === 'method'){
                            modal_form.find('[name="'+key+'"]').val(value);
                        }else{
                            modal_form.find('[id="'+key+'"]').text(value);
                        }
                    });
                    $('#order_detail').html(response.order_detail);
                    $('#order_print').html(response.order_print);

                    //lich trinh
                    var noidung = "";
                    noidung+= "<div class='itemtt box_value' style='display: flex;'>";
                    noidung+= "<input name='note[]' placeholder='giá trị thuộc tính' class='form-control' type='text' value='' />";
                    noidung+= "<div class='btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete'>";
                    noidung+= "<span><i class='la la-trash-o'></i><span>Delete</span></span></div></div>";
                    $.each(response.data_info.note, function(keyx, valuex) {
                        // console.log(valuex.key);
                        noidung+= "<div class='itemtt box_value' style='display: flex;'>";
                        noidung+= "<input name='note[]' placeholder='giá trị thuộc tính' class='form-control' type='text' value='"+valuex+"' />";
                        noidung+= "<div class='btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete'>";
                        noidung+= "<span><i class='la la-trash-o'></i><span>Delete</span></span></div></div>";
                        
                    });
                    $(".box_value_all").html(noidung);
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


$(document).ready(function() {
    $('body').on('click', '#add_field', function(event) {
      /*var noidung = $(".box_value").get(0); //hoặc cái dưới*/
      var noidung = $(".box_value").eq(0).clone();
      $(this).prev(".box_value_all").append(noidung);
    });

    $('body').on('click', '.btn_delete', function(event) {
      /* Act on the event */
      $(this).parent(".box_value").remove();
  });
  });