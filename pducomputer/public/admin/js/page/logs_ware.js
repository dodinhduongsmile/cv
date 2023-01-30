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
        field: "user",
        title: "Author",
        type: "date",
        textAlign: "center"
    }, {
        field: "action",
        title: "Thao tác",
        width: 300
    }, {
        field: "note",
        title: "Note",
        textAlign: "center",
        width: 300
    }, {
        field: "created_time",
        title: "Created Time",
        type: "date",
        textAlign: "center",
        format: "MM/DD/YYYY"
    }, {
        field: "actionc",
        width: 250,
        title: "Thông tin",
        sortable: !1,
        overflow: "visible",
        template: function (t, e, a) {
            content = `<li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-avatar"></i><span class="m-nav__link-text"> Người tạo : <strong>${t.user}</strong></span></span></li> 
            
            <li class="m-nav__item"><span class="m-nav__link">
            <i class="m-nav__link-icon flaticon-calendar"></i><span class="m-nav__link-text"> Ngày tạo : <strong>${t.created_time}</strong></span></span></li>`;

            content += `${permission_edit ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnEdit">Sửa</span>' : ''}`;

            return content;
        }
    }];
   AJAX_DATATABLES.init();
    AJAX_CRUD_MODAL.init();
    
    AJAX_CRUD_MODAL.tinymce();
    SEO.init_slug();

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
                        
                    });
                     $.each(response.data_cu, function( key, value ) {
                        let element1 = modal_form.find("[name='"+key+"cu']");
                        element1.val(value);
                        
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

setInterval(function(){
$(".btnReload").click();
},900000)
