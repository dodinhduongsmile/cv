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
        title: "Giá",
        textAlign: "center",
        width: 120,
        template: function (t) {
            return '<div class="text_price"><input type="text" class="form-control number price" value="'+t.price+'"/><input type="text" class="form-control number price_sale" value="'+t.price_sale+'"/></div>'
        }
    }, {
        field: "quality",
        title: "Tình trạng",
        textAlign: "center",
        width: 80,
        template: function (t) {
            var e = {
                0: {title: "Hết hàng", class: "m-badge--danger"},
                1: {title: "Còn hàng", class: "m-badge--primary"},
            };
            return '<span data-field="quality" data-value="'+(t.quality == 1 ? 0 : 1)+'" class="m-badge ' + e[t.quality].class + ' m-badge--wide btnUpdateField">' + e[t.quality].title + "</span>"
        }
    }, {
        field: "is_featured",
        title: "HOT",
        width: 70,
        textAlign: "center",
        template: function (t) {
            return '<span data-field="is_featured" data-value="'+(t.is_featured == 1 ? 0 : 1)+'" class="btnUpdateField">' + (t.is_featured == 1 ? '<i class="la la-star"></i>' : '<i class="la la-star-o"></i>') + "</span>"
        }
    }, {
        field: "is_status",
        title: "Trạng thái",
        textAlign: "center",
        width: 80,
        template: function (t) {
            var e = {
                0: {title: "Chờ duyệt", class: "m-badge--danger"},
                1: {title: "Hiển thị", class: "m-badge--primary"},
                
            };
            var ii = {
                0: {title: "Không lọc", class: "m-badge--info"},
                1: {title: "Lọc giá", class: "m-badge--success"},
            };
            html = '<span data-field="is_status" data-value="'+(t.is_status == 1 ? 0 : 1)+'" class="m-badge ' + e[t.is_status].class + ' m-badge--wide btnUpdateField">' + e[t.is_status].title + "</span>";
            html += '<span data-field="is_filter" data-value="'+(t.is_filter == 1 ? 0 : 1)+'" class="m-badge pdd ' + ii[t.is_filter].class + ' m-badge--wide btnUpdateField">' + ii[t.is_filter].title + "</span>";
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
    loadCategory($('select.category'));
    // loadCategory2($('select.category2'));
    loadProductType($('select.product_type'));
    loadWareHouse1($('select.warehouse1'));
//search khi chọn cái name = "is_status"
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
                    /*load view phần group classify*/
                    if(response.data_info.classify){
                        let classify =  JSON.parse(response.data_info.classify);
                    let content_classify1 ="";
                    $.each(classify.fulldgroup,function(key1, value1) {
                        content_classify1 += '<div class="item_classify"><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deletegr"><span><i class="la la-trash-o"></i><span>Delete group</span></span></div><div class="name_classify"><label>Tên nhóm phân loại</label><input placeholder="Tên nhóm phân loại" class="form-control" type="text" value="'+value1.name+'" /></div><div class="list_classify"><label>Danh sách Phân loại hàng</label><div class="box_value_all">';
                        $.each(classify.fulldgroup[key1].value,function(key2, value2) {
                            
                             content_classify1 += '<div class="itemtt box_value" style="display: flex;"><input  placeholder="Nhập phân loại hàng (vd: đỏ, đen)" class="form-control keyattr" type="text" value="'+value2+'" /><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div>' ;
                         });
                         content_classify1 += '</div><div class="m-form__group form-group row" id="add_field"><div class="col-lg-4"><div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide"><span><i class="la la-plus"></i><span>Add </span></span></div></div></div></div></div>';
                    });
                    $(".list_itemgroup").html(content_classify1);

                    let content_classify2 ="";
                     $.each(classify.fulldata,function(key1, value1) {
                        content_classify2 += '<tr>';
                        $.each(classify.fulldata[key1],function(key2, value2) {
                            content_classify2+= '<td><input class="dienvao" type="text" dataname="'+key2+'" value="'+value2+'"></td>';
                        });
                        content_classify2 += '</tr>';
                     });
                     $("table.groupprice tbody").html(content_classify2);
                    }
                    
                     
                    //load view attribute
                   let layout = response.data_info.layout;
                    // $.ajax({
                    //     url: base_admin_url  +"/product/loadAttribute/",
                    //     type: 'get',
                    //     dataType: 'html',
                    //     data: {layout},
                    // })
                    // .done(function(responsex) {
                    //     $("#tab_attr").html(responsex); 
                    //     $.each(response.data_info.attribute, function( keyx, valuex ) {
                    //         let elementx = modal_form.find('[name*="'+keyx+'"]');

                    //          elementx.val(valuex);
                    //     });
                    // })

                    $.get(base_admin_url  +"/product/loadAttribute/", {layout}, function(responsex){
                        $("#tab_attr").html(responsex); 
                        
                        $.each(response.data_info.attribute, function( keyx, valuex ) {
                            let elementx = modal_form.find('.edit[name*="'+keyx+'"]');
                             elementx.val(valuex.value);
                             modal_form.find('.edit2[name*="'+keyx+'"]').val(valuex.key);
                        });

                    },'html');

                    $.each(response.data_info, function( key, value ) {
                        let element = modal_form.find('[name="'+key+'"]');
                        element.val(value);
                        if(element.hasClass('switchBootstrap')){
                            element.bootstrapSwitch('state',(value == 1 ? true : false));
                        }
                        if(key === 'thumbnail' && value) element.closest('.form-group').find('img').attr('src',media_url + value);
                        if(key === 'album' && value) FUNC.loadMultipleMedia(value);

                    });
                    
                    


                    // $("input[name*='ram'][value='"+response.data_info.attribute.ram+"']").attr('checked','checked');
                    // $("select#machine option[value='"+response.data_info.attribute.machine+"']").attr('selected','selected');

                    let element = modal_form.find('[name="content"]');
                    if(element.hasClass('tinymce') && response.data_info.content){
                        tinymce.get(element.attr('id')).setContent(response.data_info.content);
                    }
                    element.val(response.data_info.content);

                    if(response.data_category) loadCategory($('select.category'),response.data_category);
                    
                    if(response.data_khochua){
                        modal_form.find('[name="khochua"]').val(response.data_khochua.title);
                    }
                    

                    if(response.data_product_type) loadProductType($('select.product_type'),response.data_product_type);
                    //nhà cung cấp 
                    if(response.data_warehouse) loadWareHouse1($('select.warehouse1'),response.data_warehouse);
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
        // multiple: !1,
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

function loadProductType(selector, dataSelected) {
    selector.select2({
        placeholder: 'Chọn thương hiệu',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_product_type,
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
function loadWareHouse1(selector, dataSelected) {
    selector.select2({
        placeholder: 'Chọn nhà cung cấp',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_warehouse1,
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
//chọn layout attribute
$("body").on("change","#layout", function(event){
   // event.preventDefault();
let layout = $(this).val();
$.ajax({
        url: base_admin_url  +"/product/loadAttribute/",
        type: 'get',
        dataType: 'html',
        data: {layout},
        success: function (response) {

          $("#tab_attr").html(response); 
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
        }
    })
});

$(document).ready(function() {
    $('body').on('change', 'select.edit', function(event) {
        let slugkey = generate_slug_from_title($(this).val());
        $(this).siblings('.edit2').val(slugkey);
    });

  });
/*js group classify*/
$(document).ready(function() {

var contentnhom = '<div class="item_classify"><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deletegr"><span><i class="la la-trash-o"></i><span>Delete group</span></span></div><div class="name_classify"><label>Tên nhóm phân loại</label><input  placeholder="Tên nhóm phân loại" class="form-control" type="text" value="NAME GROUP" /></div><div class="list_classify"><label>Danh sách Phân loại hàng</label><div class="box_value_all"> <div class="itemtt box_value" style="display: flex;"><input  placeholder="Nhập phân loại hàng (vd: đỏ, đen)" class="form-control keyattr" type="text" value="NAME FIELD" /><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div> </div><div class="m-form__group form-group row" id="add_field"><div class="col-lg-4"><div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide"><span><i class="la la-plus"></i><span>Add </span></span></div></div></div></div></div>';

var contentfield = '<div class="itemtt box_value" style="display: flex;"><input placeholder="Nhập phân loại hàng (vd: đỏ, đen)" class="form-control keyattr" type="text" value="NAME FIELD" /><div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete"><span><i class="la la-trash-o"></i><span>Delete </span></span></div></div>';


/*thêm nhóm phân loại group classify*/
$('body').on('click', '#add_group', function(event) {
      $(this).next(".list_itemgroup").append(contentnhom);
      let count = $(this).siblings(".list_itemgroup").children('.item_classify').length;
    if(count === 2){
        $(this).hide();
    }else{
        $(this).show();
    }
});

$('body').on('keyup', '.keyattr', function(event) {
            addtable();
        });
/*thêm phân loại hàng #1*/
    $('body').on('click', '#add_field', function(event) {
      $(this).prev(".box_value_all").append(contentfield);

      addtable();

    });

    $('body').on('click', '.btn_deletegr', function(event) {
        $(this).parent(".item_classify").remove();
        $("#add_group").show();
        
        addtable();
    });
        $('body').on('click', '.btn_delete', function(event) {
        /* Act on the event */
        let index1 = $(this).parent(".box_value").index();
        $("tr:eq("+(index1+1)+")").remove();
        $(this).parent(".box_value").remove();

        addtable();
        
        
    });

/*gõ vào input ở phân loại hàng #1 sẽ hiện vào bảng danh sách*/

$('body').on('keyup', '.name_classify input', function(event) {
    addtable();
});

var paramspro;
var addtable = () =>{
    let codepro = $('input[name="code"]').val();
    paramspro = {};//bien global
    let paramspro1;
    let paramspro11;
    let paramspro111 = {};
    let arr_namegroup =  $(".name_classify input").toArray();//mảng name group
    
    let arr_field_namegroup = [];
    let k = 0;
    let lengthgr = arr_namegroup.length;
    /*data fieldgroup cách 1*/
    for (k; k < lengthgr; k++){
        arr_field_namegroup[k] =  $(".item_classify:eq("+k+") .keyattr").toArray();//mảng field
        paramspro1 = {};
        $.each(arr_field_namegroup[k],function(index, el) {
            paramspro1[index] = el.value;
        });
        paramspro11 = {};//phải reset object về trống, nếu không nó auto lấy giá trị vòng lặp cuối. Chưa hiểu lắm
        paramspro11["value"] = paramspro1;
        paramspro11["name"] = arr_namegroup[k].value;
        paramspro111[k] = paramspro11;
        
    }
    // console.log(paramspro111);
    paramspro['fulldgroup'] = paramspro111;//thêm mảng vào object
    
    let noidungth = "<tr>";
     $.each(arr_namegroup, function(key, value) {
        noidungth += "<th>"+value.value+"</th>";
    });
        noidungth += "<th>giá </th><th>kho hàng </th><th>SKU </th></tr>";
    $("table.groupprice thead").html(noidungth);


    let noidungtbody = "";


    if(lengthgr === 1){

        $.each(arr_field_namegroup[0], function(key1, value1) {
            noidungtbody += "<tr>";
            noidungtbody += '<td><input class="dienvao" type="text" readonly="readonly" dataname="namegroup0" value="'+value1.value+'"></td>';
            noidungtbody += '<td><input  class="dienvao" type="number" dataname="price" value="" required="required"></td><td><input  class="dienvao" type="number" dataname="countware" value="" required="required"></td><td><input  class="dienvao" type="text" dataname="sku" value="'+codepro+'-'+key1+'"></td></tr>';
        });
    }else{
        var sttcode = 0;
        $.each(arr_field_namegroup[0], function(key1, value1) {
            $.each(arr_field_namegroup[1], function(key2, value2) {
                sttcode++;
                noidungtbody += "<tr>";
                noidungtbody += '<td><input class="dienvao" type="text" readonly="readonly" dataname="namegroup0" value="'+value1.value+'"></td>';
                noidungtbody += '<td><input class="dienvao" type="text" readonly="readonly" dataname="namegroup1" value="'+value2.value+'"></td>';
                noidungtbody += '<td><input  class="dienvao" type="number" dataname="price" value="" required="required"></td><td><input  class="dienvao" type="number" dataname="countware" value="" required="required"></td><td><input  class="dienvao" type="text" dataname="sku" value="'+codepro+'-'+sttcode+'"></td></tr>';

            });
        });
    }
        
    $("table.groupprice tbody").html(noidungtbody);
        
}//end addtable

$(".btnSave").click(function(event) {
    let lengthgr = $(".item_classify").length;
    if(lengthgr >=1){
        if($(".dienvao[required]").val() == ""){
            $(".dienvao[required]").after('<div class="pdu-feedback"> *Trường bắt buộc.</div>');
            return false;
        }
    }
});

/*data fulldata*/
$('body').on('keyup', '.dienvao', function(event) {
    let fulldata;
    let fulldata1 = {};
    let arr = $("table.groupprice tbody tr").toArray();
    let k = 0;
    let lengthgr1 = arr.length;
    for (k; k < lengthgr1; k++){
        fulldata = {};
        let num1 = arr[k].childElementCount;
        let l = 0;
        let name, value;
        for (l; l < num1; l++){
            value = arr[k].children[l].children[0].value;
            name = arr[k].children[l].children[0].getAttribute("dataname");
            fulldata[name] = value;
        }
        fulldata1[k] =fulldata;
    }
    paramspro['fulldata'] = fulldata1;
    let myJSON = JSON.stringify(paramspro);
    $("#groupclassify").val(myJSON);
    

});
    

  });