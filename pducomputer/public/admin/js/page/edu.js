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
        field: "thumbnail",
        title: "Hình ảnh",
        textAlign: "center",
        width: 100,
        template: function (t) {
            thumbnail = t.thumbnail ? FUNC.getImageThumb(t.thumbnail) : base_url+'public/default-thumbnail.png';
            return '<img class="img-thumbnail" src="'+thumbnail+'">'
        }
    }, {
        field: "is_status",
        title: "Trạng thái",
        textAlign: "center",
        width: 70,
        template: function (t) {
            var e = {
                0: {title: "Chờ duyệt", class: "m-badge--danger"},
                1: {title: "Hiển thị", class: "m-badge--primary"},
            };
            return '<span data-field="is_status" data-value="'+(t.is_status == 1 ? 0 : 1)+'" class="m-badge ' + e[t.is_status].class + ' m-badge--wide btnUpdateField">' + e[t.is_status].title + "</span>"
        }
    },{
        field: "is_featured",
        title: "HOT",
        width: 70,
        textAlign: "center",
        template: function (t) {
            return '<span data-field="is_featured" data-value="'+(t.is_featured == 1 ? 0 : 1)+'" class="btnUpdateField">' + (t.is_featured == 1 ? '<i class="la la-star"></i>' : '<i class="la la-star-o"></i>') + "</span>"
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
                        if(key === 'thumbnail' && value) element.closest('.form-group').find('img').attr('src',media_url + value);
                    });
                    let element = modal_form.find('[name="content"]');
                    if(element.hasClass('tinymce') && response.data_info.content){
                        tinymce.get(element.attr('id')).setContent(response.data_info.content);
                    }
                    // element.val(response.data_info.content);

                    //link drive
                    // let drive = response.data_info.listdrive;
                    // let myJSON = JSON.stringify(drive);
                    // $("#listdrive").val(myJSON);  
                    
            if(response.data_info.listdrive){
                let drive =  JSON.parse(response.data_info.listdrive);
                if(drive[0].child == undefined){
                        /*có 1 nhóm, hiện ra file luôn vì mảng lúc lưu vào khi có 1 nhóm là lưu mảng file luôn*/
                        var noidung1 = '<div class="item_classify"><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deletegr"><span><i class="la la-trash-o"></i><span>Delete group</span></span></div><div class="name_classify"><label>Tên nhóm phân loại</label><input name="" placeholder="Tên nhóm phân loại" class="form-control" type="text" value="NAME GROUP" /></div>  <div class="list_classify"><label>Danh sách Phân loại hàng</label><div class="box_value_all">';
                        
                    $.each(drive, function(keyx, valuex) {
                        noidung1+= '<div class="itemtt box_value" style="display: flex;">';
                        noidung1+= "<input placeholder='id video' class='form-control keyattr_id' type='text' value='"+valuex.id+"' />";
                        noidung1+= "<input placeholder='tên video' class='form-control keyattr' type='text' value='"+valuex.name+"' />";
                        
                        noidung1+= "<input placeholder='mimeType' class='form-control keyattr_type' readonly type='text' value='"+valuex.mimeType+"' />";
                        noidung1+= '<div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div>';
                    });
                    noidung1+= '</div><div class="m-form__group form-group row" id="add_fielddr"><div class="col-lg-4"><div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide"><span><i class="la la-plus"></i><span>Add </span></span></div></div></div></div></div>';

                        $(".listdrive .list_itemgroup").html(noidung1);
                }else{
                        /*có >1 nhóm, hiện ra nhóm chứa file*/
                        var noidung1 = "";
                        var noidung2= '<div class="item_classify"><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deletegr"><span><i class="la la-trash-o"></i><span>Delete group</span></span></div><div class="name_classify"><label>Nhóm Tổng hợp FILE lẻ</label><input name="" placeholder="Tên nhóm phân loại" class="form-control" type="text" value="Tổng hợp FILE" /></div>  <div class="list_classify"><label>Danh sách FILE</label><div class="box_value_all">';
                        let trangthai = 0;
                    $.each(drive, function(key, value) {
                            
                         if(value.child.length != 0){
                            
                                /*có child trong folder thì hiện*/
                            noidung1+= '<div class="item_classify"><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deletegr"><span><i class="la la-trash-o"></i><span>Delete group group</span></span></div><div class="name_classify"><label>Tên nhóm phân loại</label>';
                            noidung1+= "<input placeholder='Tên nhóm phân loại' class='form-control' type='text' value='"+value.name+"' /></div>";
                            noidung1+= '<div class="list_classify"><label>Danh sách FILE</label><div class="box_value_all">';
                            $.each(value.child, function(keyx, valuex) {
                                noidung1+= '<div class="itemtt box_value" style="display: flex;">';
                                noidung1+= "<input placeholder='id video' class='form-control keyattr_id' type='text' value='"+valuex.id+"' />";
                                noidung1+= "<input placeholder='tên video' class='form-control keyattr' type='text' value='"+valuex.name+"' />";
                                
                                noidung1+= "<input placeholder='mimeType' class='form-control keyattr_type' readonly type='text' value='"+valuex.mimeType+"' />";
                                noidung1+= '<div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div>';
                            });
                            noidung1+= ' </div><div class="m-form__group form-group row" id="add_fielddr"><div class="col-lg-4"><div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide"><span><i class="la la-plus"></i><span>Add </span></span></div></div></div></div></div>';

                            $(".listdrive .list_itemgroup").html(noidung1);
                         }else{
                            trangthai = 1;
                            /*KHÔNG có child thì nó là 1 file lẻ, gộp vào hiện 1 FOLDER riêng*/
                            noidung2+= '<div class="itemtt box_value" style="display: flex;">';
                            noidung2+= "<input placeholder='id video' class='form-control keyattr_id' type='text' value='"+value.id+"' />";
                            noidung2+= "<input placeholder='tên video' class='form-control keyattr' type='text' value='"+value.name+"' />";
                            
                            noidung2+= "<input placeholder='mimeType' class='form-control keyattr_type' readonly type='text' value='"+value.mimeType+"' />";
                            noidung2+= '<div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div>';
                        
                         }
                            
                    });
                        noidung2+= '</div><div class="m-form__group form-group row" id="add_fielddr"><div class="col-lg-4"><div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide"><span><i class="la la-plus"></i><span>Add </span></span></div></div></div></div></div>';
                        if(trangthai ==1){$(".listdrive .list_itemgroup").prepend(noidung2);}
                        
                    }//end else
            }
                    
                    
                    //link youtube
                if(response.data_info.listyoutube){
                    let youtube = JSON.parse(response.data_info.listyoutube);
                    let noidungyt = "";
                    $.each(youtube, function(key2, value2) {
                        
                        noidungyt+= "<div class='itemtt box_value'><label>item</label>";
                        noidungyt+= "<input name='listyoutube[name][]' placeholder='Tên video' class='form-control' type='text' value='"+value2.name+"' /><br>";
                        noidungyt+= "<input name='listyoutube[link][]' placeholder='link video' class='form-control' type='text' value='"+value2.link+"' />";
                        noidungyt+= "<input name='listyoutube[id][]' placeholder='id video' class='form-control' type='text' value='"+value2.id+"' />";
                        noidungyt+= "<input name='listyoutube[time][]' placeholder='số phút' class='form-control' type='text' value='"+value2.time+"' />";
                        noidungyt+= "<div class='btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deleteyt'>";
                        noidungyt+= "<span><i class='la la-trash-o'></i><span>Delete</span></span></div></div>";
                        
                    });
                   
                    $(".listyoutube .box_value_all").html(noidungyt);
                }
                    

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
        placeholder: 'Chọn danh mục',
        //allowClear: !0,
        //multiple: !1,
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

// $(document).ready(function() {
    
//     $('body').on('click', '.add_field', function(event) {
//       // var noidung = $(".box_value").get(0); //hoặc cái dưới
//       // var noidung = $(".box_value").eq(0).clone();
//       var noidung = $(this).siblings('.box_value_all').children('.box_value').eq(0).clone();

//       $(this).prev(".box_value_all").append(noidung);
//     });

//     $('body').on('click', '.btn_deleteyt', function(event) {
//       /* Act on the event */
//       $(this).parent(".box_value").remove();
//   });


//   });
//   

/*js group drive*/
$(document).ready(function() {

var contentnhom = '<div class="item_classify"><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deletegr"><span><i class="la la-trash-o"></i><span>Delete group</span></span></div><div class="name_classify"><label>Tên nhóm phân loại</label><input name="" placeholder="Tên nhóm phân loại" class="form-control" type="text" value="NAME GROUP" /></div><div class="list_classify"><label>Danh sách Phân loại hàng</label><div class="box_value_all"> <div class="itemtt box_value" style="display: flex;"><input name="" placeholder="id video" class="form-control keyattr_id" type="text" value="ID FIELD" /><input name="" placeholder="tên video" class="form-control keyattr" type="text" value="NAME FIELD" /><input placeholder="mimeType" class="form-control keyattr_type" type="text" value="" /><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div> </div><div class="m-form__group form-group row" id="add_fielddr"><div class="col-lg-4"><div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide"><span><i class="la la-plus"></i><span>Add </span></span></div></div></div></div></div>';

var contentfield = '<div class="itemtt box_value" style="display: flex;"><input name="" placeholder="id video" class="form-control keyattr_id" type="text" value="ID FIELD" /><input name="" placeholder="tên video" class="form-control keyattr" type="text" value="NAME FIELD" /><input placeholder="mimeType" class="form-control keyattr_type" type="text" value="" /><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div>';


/*thêm nhóm phân loại group classify*/
$('body').on('click', '#add_group', function(event) {
      $(this).next(".list_itemgroup").append(contentnhom);
      addtable();
});
/*xoa group*/
$('body').on('click', '.btn_deletegr', function(event) {
    $(this).parent(".item_classify").remove();

    addtable();
});
/*thêm trường drive*/
    $('body').on('click', '#add_fielddr', function(event) {
      $(this).prev(".box_value_all").append(contentfield);
      addtable();
    });
$('body').on('click', '.btn_delete', function(event) {
/* Act on the event */
    $(this).parent(".box_value").remove();
    addtable();
});
/*thêm trường youtube*/
$('body').on('click', '.add_field', function(event) {
    let noidung = $(this).siblings('.box_value_all').children('.box_value').eq(0).clone();
      $(this).prev(".box_value_all").append(noidung);
    });
$('body').on('click', '.btn_deleteyt', function(event) {
    $(this).parent(".box_value").remove();
});


var paramspro;
var addtable = () =>{

    paramspro = {};//bien global
    let paramspro1;
    let paramspro11;
    let paramspro111 = [];//mảng thì chỉ add chỉ số index, muốn khai báo key thì phải dùng object {}
    let arr_namegroup =  $(".name_classify input").toArray();//mảng name group
    
    let arr_field_namegroup = [];
    let arr_field_namegroup2 = [];
    let arr_field_namegroup3 = [];
    let k = 0;
    let lengthgr = arr_namegroup.length;
    /*data fieldgroup cách 1
    1. số group
    2. số file trong group, mỗi file có 2 trường
    $x = [
        'name_nhom_1' => [
            0 => [
                'id' => 1,
                'name' => name1
            ],
            1 => [
                'id' => 11,
                'name' => name11
            ]
        ]
    ]
    */

    if(lengthgr === 1){
        /*chỉ có 1 group, thì chỉ lưu list file*/
        let nhom;
        arr_field_namegroup =  $(".keyattr_id").toArray();//mảng field id,
        arr_field_namegroup2 =  $(".keyattr").toArray();//mảng field name
        arr_field_namegroup3 =  $(".keyattr_type").toArray();//mảng field name
        paramspro1 = [];
        $.each(arr_field_namegroup,function(index, el) {
            nhom = {'id':el.value,'name':arr_field_namegroup2[index].value,'mimeType':arr_field_namegroup3[index].value};
            paramspro1[index] = nhom;
            // paramspro1[index]['name'] = arr_field_namegroup2[k][index].value;
        });
        paramspro = paramspro1;
    }else{
        /*có nhiều hơn 1 group*/
        let nhom;
        for (k; k < lengthgr; k++){
            arr_field_namegroup[k] =  $(".item_classify:eq("+k+") .keyattr_id").toArray();//mảng field id, group thứ k
            arr_field_namegroup2[k] =  $(".item_classify:eq("+k+") .keyattr").toArray();//mảng field name
            arr_field_namegroup3[k] =  $(".item_classify:eq("+k+") .keyattr_type").toArray();//mảng field name
            paramspro1 = [];

            $.each(arr_field_namegroup[k],function(index, el) {
                nhom = {'id':el.value,'name':arr_field_namegroup2[k][index].value,'mimeType':arr_field_namegroup3[k][index].value};
                paramspro1[index] = nhom;
                // paramspro1[index]['name'] = arr_field_namegroup2[k][index].value;
            });
            paramspro11 = {};//phải reset object về trống, nếu không nó auto lấy giá trị vòng lặp cuối. Chưa hiểu lắm
            paramspro11["name"] = arr_namegroup[k].value;
            paramspro11["child"] = paramspro1;
            
            paramspro111[k] = paramspro11;
            
        }
        paramspro = paramspro111;//thêm mảng vào object
    }
    
     /*update object*/
      let myJSON = JSON.stringify(paramspro);
        $("#listdrive").val(myJSON);   
}//end addtable


$('body').on('change', '.keyattr', function(event) {
   addtable();
});

});