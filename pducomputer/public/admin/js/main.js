var win = $(window),
    body = $('body'),
    doc = $(document),
    meta_csrf_token = $('meta[id="csrf_token"]'),
    csrf_cookie_name = 'csrf_cookie_name',
    csrf_token_name = meta_csrf_token.attr('name'),
    csrf_token_hash = meta_csrf_token.attr('content'),
    method_modal = '',
    slug_disable = false,
    option_TinyMCE = {
        height: "500",
        selector: 'textarea.tinymce',
        setup: function (ed) {
            ed.on('DblClick', function (e) {
                if (e.target.nodeName == 'IMG') {
                    tinyMCE.activeEditor.execCommand('mceImage');
                }
            });

            ed.addButton('post_block_top', {
                type: 'button',
                text: 'Post Block Top',
                onclick: function () {
                    ed.insertContent('[postblock id="top"]');

                }
            });

            ed.addButton('post_block_bottom', {
               type: 'button',
               text: 'Post Block Bottom',
               onclick: function () {
                   ed.insertContent('[postblock id="bottom"]');
               }
            });

            ed.add

        },
        plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker template",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern moxiemanager link image",
        ],

        toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
        toolbar2: "searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink image media code | forecolor backcolor",
        toolbar3: "table | removeformat | charmap emoticons | spellchecker | template restoredraft insertfile | post_block_top post_block_bottom",
        templates: [
            {
                title: 'Textbox',
                description: 'Tạo Textbox',
                url: base_url + 'public/admin/plugins/tinymce/templates/text-box.html'
            }
        ],
        rel_list : [
            {title: 'Do Follow', value: 'dofollow'},
            {title: 'No Follow', value: 'nofollow'}
        ],
        // paste_as_text: true,
        menubar: false,
        element_format: 'html',
        extended_valid_elements: "iframe[src|width|height|name|align], embed[width|height|name|flashvars|src|bgcolor|align|play|loop|quality|allowscriptaccess|type|pluginspage]",
        toolbar_items_size: 'small',
        relative_urls: false,
        remove_script_host: true,
        convert_urls: true,
        verify_html: false,
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        external_plugins: {
            "moxiemanager": base_url + "public/admin/plugins/moxiemanager/plugin.min.js"
        }
    },
    datatables_columns = [];

var colors = ["#f44336", "#fbc02d", "#4caf50"];
var button_success = 'btn m-btn--pill m-btn--air btn-outline-success';
var button_danger = 'btn m-btn--pill m-btn--air btn-outline-danger';
var button_warning = 'btn m-btn--pill m-btn--air btn-outline-warning';
var success = 'form-group has-success';
var warning = 'form-group has-warning';
var danger = 'form-group has-danger';

var text_danger = 'form-control text-danger';
var text_success = 'form-control text-success';
var text_warning = 'form-control text-warning';
var SEO = {
    meta_title: function () {
        let _this = $('input[name="meta_title"]');
        if (_this.length > 0) {
            _this.closest('div').removeClass();
            let c_title = _this.val().length;
            let l_title = $("span.count-title");
            $(l_title).html(c_title);
            if(c_title >= 40 && c_title <= 80){
                _this.closest('div').addClass(success);
            }else if(c_title >= 25 && c_title < 40){
                _this.closest('div').addClass(warning);
            }else{
                _this.closest('div').addClass(danger);
            }
            let seo_title = _this.val();
            $(".gg-title").html(seo_title);
        }
    },
    meta_description: function() {
        let _this = $('textarea[name="meta_description"]');
        if (_this.length > 0) {
            _this.closest('div').removeClass();
            let c_desc = _this.val().length;
            let l_desc = $("span.count-desc");
            $(l_desc).html(c_desc);
            if(c_desc >= 120 && c_desc <= 150){
                _this.closest('div').addClass(success);
            }else if(c_desc >= 90 && c_desc < 120){
                _this.closest('div').addClass(warning);
            }else{
                _this.closest('div').addClass(danger);
            }
            let seo_desc = _this.val();
            $(".gg-desc").html(seo_desc);
        }

    },
    meta_keyword: function() {
        let _this = $('input[name="meta_keyword"]');
        if (_this.length > 0){
            _this.closest('div').removeClass();
            let c_key = _this.val().length;
            let l_key = $("span.count-key");
            $(l_key).html(c_key);
            if(c_key >= 10){
                _this.closest('div').addClass(success);
            }else if(c_key >= 6 && c_key < 10){
                _this.closest('div').addClass(warning);
            }else{
                _this.closest('div').addClass(danger);
            }
            let seo_key = _this.val();
            $(".gg-result").val(seo_key);
        }
    },
    generate_slug: function(title,ele){
        let slug;
        if(slug_disable){
            return;
        }
        slug = title.toLowerCase();
        slug = slug.replace(/\//mig, "-");
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');

        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        // slug = slug.replace(/[^a-zA-Z0-9 ]/g, "");
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        slug = slug.replace(/\s/g, "-");
        ele.val(slug);
    },
    init_slug: function(){
        let elementTitle = $('input[name="title"]');
        let elementSlug = $('input[name="slug"]');
        elementTitle.on('paste', function () {
            setTimeout(function () {
                SEO.generate_slug(elementTitle.val(),elementSlug);
            }, 500);
        });
        elementTitle.on('keyup', function () {
            SEO.generate_slug(elementTitle.val(),elementSlug);
        });
    },
    init: function () {
        SEO.init_slug();
        
        let cgg = $(".gg_1").text().split('').join("</span><span>");
        $(".gg_1" ).html(cgg);
        SEO.meta_title();
        SEO.meta_description();
        SEO.meta_keyword();
        $('input[name="meta_title"]').keyup( function(){
            SEO.meta_title($(this));
        });
        $('input[name="slug"]').keyup( function(){
            $(".gg-url").html(base_url+$(this).val());
        });
        $('input[name="meta_keyword"]').keyup( function(){
            SEO.meta_keyword($(this));
        });
        $('textarea[name="meta_description"]').keyup( function(){
            SEO.meta_description($(this));
        });
        $(".gg-url").html(base_url+$('input[name$="slug"]').val());
    }
};




function generate_slug_from_title (title) {
    let slug;
    slug = title.toLowerCase();
    slug = slug.replace(/\//mig, "-");
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');

    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    // slug = slug.replace(/[^a-zA-Z0-9 ]/g, "");
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    slug = slug.replace(/\s/g, "-");
    return slug;
}
/*Đây là các Function liên quan Datatables*/
var table;
var AJAX_DATATABLES = {
    init: function () {
        if (class_name == 'revision') {
            let post_id = $('[name="post_id"]').val();
            url_ajax_list = url_ajax_list + '/' + post_id;
        }
        table = $("#ajax_data").mDatatable({
            data: {
                type: "remote",
                source: {
                    read: {
                        url: url_ajax_list,
                        params: {
                            csrf_form_token: FUNC.getCookie(csrf_cookie_name)
                        },
                        map: function (t) {
                            var e = t;
                            return void 0 !== t.data && (e = t.data), e
                        }
                    }
                },
                pageSize: 10,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !1
            },
            layout: {scroll: !1, footer: !1},
            sortable: !0,
            pagination: !0,
            toolbar: {items: {pagination: {pageSizeSelect: [10, 20, 30, 50, 100]}}},
            search: {
                input: $("#generalSearch"),
            },
            columns: datatables_columns,
        });
    },
    reload: function () {
        table.load();
    }
};
/*Function CRUD Modal*/
var AJAX_CRUD_MODAL = {
    open: function(){
        let modal_form = $('#modal_form');
        modal_form.on('shown.bs.modal', function(e){
            body.addClass('fixed');
            SEO.init();
            let diaLogScroll = modal_form,
                diaLogScrollHeight = diaLogScroll.find('.modal-header').height(),
                diaLogScrollFooter = diaLogScroll.find('.modal-footer');
            diaLogScroll.find('.modal-footer').addClass('modal-footer-top-button');
            diaLogScroll.scroll(function(){
                if(diaLogScroll.scrollTop() <= diaLogScrollHeight + 35){
                    diaLogScrollFooter.addClass('modal-footer-top-button');
                }else{
                    diaLogScrollFooter.removeClass('modal-footer-top-button');
                }
            });
        });
    },
    close: function(){
        $('#modal_form').on('hidden.bs.modal', function(e){
            body.removeClass('fixed');
            window.onbeforeunload = null;
            $(this).find('form').trigger('reset');
            $(this).find('input[type=hidden]').val(0);
            $(this).find('.m-select2').empty().trigger('change');
            $(this).find('div.form-control-feedback').remove();
            $(this).find('[name="username"]').attr('disabled',false);
            $(this).find('.form-group').removeClass('has-danger');
            $(this).find('.preview img').attr('src','//via.placeholder.com/100x100');

            $(this).find('ul[role="tablist"] li a').removeClass('active show');
            $(this).find('ul[role="tablist"] li:first-child a').trigger('click').addClass('active show');
            $(this).find('#list-album').html('');
            $('#gallery').html('');
            //$("input.tagsinput").tagsinput('removeAll');
            $(this).find('input.switchBootstrap').bootstrapSwitch('state',false);
            $(this).find('input[name="is_status"]').bootstrapSwitch('state',true);
            $(this).find('input[name="is_featured"]').bootstrapSwitch('state',true);
            $(this).find('input[name="index"]').bootstrapSwitch('state',true);
            $(this).find('input[name="follow"]').bootstrapSwitch('state',true);
            $(this).find('input[name="stick_home"]').bootstrapSwitch('state', true);
            for (var j = 0; j < tinyMCE.editors.length; j++){
                tinymce.get(tinyMCE.editors[j].id).setContent('');
            }
        });
    },
    disable_close: function(){
        $('#modal_form').modal({backdrop: 'static', keyboard: false,show: false});
    },
    add: function () {
        slug_disable = false;
        if (class_name == 'post' || class_name == 'page') {
            tinymce.get('content').setContent('');
        }
        $('#modal_form').modal('show');
        if (admin_group_id == 3) {
            let option = '<option value="0" selected="selected">Chờ duyệt</option>';
            $('.post-status').html(option);
        }
        $('.post-future option').removeAttr('selected');
        $('.post-future option[value="0"]').attr('selected','selected');

        return false;
    },
    edit: function (func) {
        slug_disable = true;
        return func();
    },
    viewRevision: function (func){
        return func();
    },
    save: function () {
        let modal_form = $('#modal_form');
        let url;

        modal_form.find('.btnSave').attr('disabled',true);
        if(modal_form.find('input[name="id"]').val() == 0) {
            url = url_ajax_add;
        } else {
            url = url_ajax_update;
        }

        if(tinyMCE.editors.length > 0){
            for (let j = 0; j < tinyMCE.editors.length; j++){
                let idInput = tinyMCE.editors[j].id;
                let content = tinymce.get(idInput).getContent();
                $('[name="'+idInput+'"]').val(content);
            }

            AJAX_CRUD_MODAL.getCountWordTinymce();
        }

        $.ajax({
            url : url,
            type: "POST",
            data: modal_form.find('form').serialize(),
            dataType: "JSON",
            beforeSend: function(){
                
            },
            success: function(data){
                toastr[data.type](data.message);//thông báo trạng thái
                $('.form-control-feedback').remove();
                $('.form-group').removeClass('has-danger');
                
                if(data.type === "warning"){
                    $.each(data.validation,function (i, val) {
                        let input = $('[name="'+i+'"]');
                        if(input.parent().hasClass('input-group')){
                            input.closest('.input-group').after(val);
                        }else{
                            input.after(val);
                        }
                        input.addClass('form-control-danger');
                        input.closest('.form-group').addClass('has-danger');
                    })
                } else {
                    modal_form.modal('hide');
                    AJAX_DATATABLES.reload();
                }
                modal_form.find('.btnSave').attr('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                modal_form.find('.btnSave').attr('disabled',false);
            }
        });return false;
    },
    saveDraft: function () {
        let modal_form = $('#modal_form');
        let url;

        modal_form.find('.btnSave').attr('disabled',true);
        modal_form.find('.btnSaveDraft').attr('disabled',true);
        let id = modal_form.find('input[name="id"]').val();
        if(modal_form.find('input[name="id"]').val() == 0) {
            url = url_ajax_add_post_private;
        } else {
            url = url_ajax_add_draft;
        }

        if(tinyMCE.editors.length > 0){
            for (let j = 0; j < tinyMCE.editors.length; j++){
                let idInput = tinyMCE.editors[j].id;
                let content = tinymce.get(idInput).getContent();
                $('[name="'+idInput+'"]').val(content);
            }

            AJAX_CRUD_MODAL.getCountWordTinymce();
        }
        $.ajax({
            url : url,
            type: "POST",
            data: modal_form.find('form').serialize(),
            dataType: "JSON",
            beforeSend: function(){
                $('.form-control-feedback').remove();
                $('.form-group').removeClass('has-danger');
            },
            success: function(data){
                toastr[data.type](data.message);
                if(data.type === "warning"){
                    $.each(data.validation,function (i, val) {
                        let input = $('[name^="'+i+'"]');
                        if(input.parent().hasClass('input-group')){
                            input.closest('.input-group').after(val);
                        }else{
                            input.after(val);
                        }
                        input.addClass('form-control-danger');
                        input.closest('.form-group').addClass('has-danger');
                    })
                } else {
                    modal_form.find('input[name="id"]').val(data.post_id);
                    console.log(data.post_id);
                }
                modal_form.find('.btnSave').attr('disabled',false);
                modal_form.find('.btnSaveDraft').attr('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                modal_form.find('.btnSave').attr('disabled',false);
                modal_form.find('.btnSaveDraft').attr('disabled',false);
            }
        });return false;
    },
    delete: function () {
        return false;
    },
    tinymce: function(){
        tinymce.init(option_TinyMCE);
    },
    getCountWordTinymce: function(){
        if($('[name="total_word"]').length > 0){
            let wordcount = tinyMCE.activeEditor.plugins.wordcount;
            $('[name="total_word"]').val(wordcount.getCount());
        }
    },
    summernote: function(){
        $(".summernote").summernote({height:150});
    },
    init: function () {
        AJAX_CRUD_MODAL.disable_close();
        AJAX_CRUD_MODAL.open();
        AJAX_CRUD_MODAL.close();

        doc.on('click','.btnReload',function (e) {
            e.preventDefault();
            AJAX_DATATABLES.reload();
        });

        doc.on('click','.btnAddForm',function (e) {
            e.preventDefault();
            AJAX_CRUD_MODAL.add();
        });
        doc.on('click','.btnDeleteAll',function (ev) {
            ev.preventDefault();
            let listChecked = table.getSelectedRecords();
            if(listChecked.length == 0){
                toastr.warning('Vui lòng chọn bản ghi bạn muốn xóa !');
                return false;
            }
            swal({
                title: "Bạn có chắc chắn xóa những bản ghi này ?",
                text: "Bạn không thể khôi phục những bản ghi này sau khi xóa!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Đúng, Xóa ngay !",
                cancelButtonText: "Không, Hủy nó !",
                reverseButtons: !0
            }).then(function(e) {
                let ids = [];
                $.each(listChecked, function (i,v) {
                    ids.push($(v).find('input[type="checkbox"]').val());
                });
                if(ids){
                    if(e.value){
                        $.each(ids,function (index) {
                            $.ajax({
                                url : url_ajax_delete,
                                type: "POST",
                                data:{id:ids[index]},
                                dataType: "JSON",
                                success: function(data) {
                                    if(data.type){
                                        toastr[data.type](data.message);
                                    }
                                    if(data.type === 'success'){
                                        e.value ? swal("Xóa thành công!", "Những bản ghi bạn chọn đã được xóa.", "success") : "cancel" === e.dismiss && swal("Hủy bỏ thành công !", "Các bản ghi của bạn đã được an toàn :)", "error")
                                    }
                                    AJAX_DATATABLES.reload();
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    console.log(errorThrown);
                                    console.log(textStatus);
                                    console.log(jqXHR);
                                }
                            });
                        });

                    }else{
                        swal("Hủy bỏ thành công !", "Bản ghi của bạn đã được an toàn :)", "error")
                    }
                }
            })
        });
        doc.on('click','.btnDelete',function (ev) {
            ev.preventDefault();
            let id = $(this).closest('tr').find('input[type="checkbox"]').val();
            swal({
                title: "Bạn có chắc chắn xóa bản ghi này ?",
                text: "Bạn không thể khôi phục bản ghi này sau khi xóa!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Đúng, Xóa ngay !",
                cancelButtonText: "Không, Hủy nó !",
                reverseButtons: !0
            }).then(function(e) {
                if(e.value){
                    $.ajax({
                        url : url_ajax_delete,
                        type: "POST",
                        data:{id:id},
                        dataType: "JSON",
                        success: function(data) {
                            if(data.type){
                                toastr[data.type](data.message);
                            }
                            if(data.type === 'success'){
                                swal("Xóa thành công!", "Bản ghi đã được xóa.", "success")
                            }
                            AJAX_DATATABLES.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            console.log(errorThrown);
                            console.log(textStatus);
                            console.log(jqXHR);
                        }
                    });
                }else{
                    swal("Hủy bỏ thành công !", "Bản ghi của bạn đã được an toàn :)", "error")
                }

            })
        });

        doc.on('click','.btnUpdateField',function (ev) {
            ev.preventDefault();
            let id = $(this).closest('tr').find('input[type="checkbox"]').val();
            let field = $(this).data('field');
            let value = $(this).data('value');
            $.ajax({
                    url : url_ajax_update_field,
                    type: "POST",
                    data:{id:id,field:field,value:value},
                    dataType: "JSON",
                    success: function(data) {
                        if(data.type){
                            toastr[data.type](data.message);
                        }
                        AJAX_DATATABLES.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log(errorThrown);
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                });
        });
        doc.on('change','.updateSort',function (ev) {
            ev.preventDefault();
            let id = $(this).closest('tr').find('input[type="checkbox"]').val();
            let field = $(this).attr('name');
            let value = $(this).val();
            $.ajax({
                url : url_ajax_update_field,
                type: "POST",
                data:{id:id,field:field,value:value},
                dataType: "JSON",
                success: function(data) {
                    if(data.type){
                        toastr[data.type](data.message);
                    }
                    AJAX_DATATABLES.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
        });

        doc.on('click','.btnSave',function (e) {
            e.preventDefault();
            AJAX_CRUD_MODAL.save();
        });
        doc.on('click','.btnSaveDraft',function (e) {
            e.preventDefault();
            AJAX_CRUD_MODAL.saveDraft();
        });
        $('.number').keyup(function () {
            var number = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(number); 
        });
    }
};
/*Function CRUD Modal*/
/*Đây là các Function để dùng chung*/
var FUNC = {
    getParam: function(param){
        let url_string = window.location.href;
        let url = new URL(url_string);
        let c = url.searchParams.get(param);
        return c;
    },
    imgError : (image) => {
        image.onerror = "";
        image.src = base_url+'public/default-thumbnail.png';
        return true;
    },
    getImageThumb : (thumbnail) => {
        let src = media_url + thumbnail;
        return src;
    },
    chooseImage: function(_this){
        moxman.browse({
            view: 'thumbs',
            extensions:'jpg,jpeg,png,gif,ico',
            no_host: true,
            upload_auto_close: true,
            oninsert: function(args) {
                let element = $(_this).closest('.form-group').find('input');
                let url=args.files[0].url;
                let urlImageResponse=url.replace(media_name,'');
                let image = args.files[0].meta.thumb_url;
                element.val(urlImageResponse).closest('.form-group').find('.preview').children('img').attr('src',image);

            }
        });
        return false;
    },
    chooseMultipleMedia: function(idElement) {
        var count = parseInt($('#' + idElement).attr('data-id'));
        moxman.browse({
            view: 'thumbs',
            multiple: true,
            extensions: 'jpg,jpeg,gif,png,ico,pdf,doc,docx,xls,xlsx',
            no_host: true,
            oninsert: function (args) {
            $.each(args['files'], function (i, value) {
                count = count + 1;
                var url = value.url;
                var urlImageResponse = url.replace('/public/media','');
                var html = FUNC.itemGallery(count, urlImageResponse);
                $('#' + idElement).append(html);
            });
            $('#' + idElement).attr('data-id', $('#' + idElement + ' .item_gallery:last').data('count'));
            }
        });
    },
    loadMultipleMedia: function(data) {
        if (data !== null && (data).length > 0) {
            $.each(JSON.parse(data), function (i, v) {
                $('#gallery').append(FUNC.itemGallery(i + 1, v));
          });
        }
    },
    chooseFile: function(_this){
        moxman.browse({
            view: 'thumbs',
            extensions:'pdf,doc,docx',
            no_host: false,
            upload_auto_close: true,
            oninsert: function(args) {
                let element = $(_this).closest('.form-group').find('input');
                let url=args.focusedFile.url;
                let urlImageResponse=url.replace(media_url,'');
                element.val(urlImageResponse);
                console.log(args);
            }
        });
        return false;
    },
    showGallery: function(element,data){
        console.log(data);
        console.log(element);
        if(data !== null && (data).length > 0) {
            $.each(JSON.parse(data), function (i, v) {
                $(element).append(FUNC.itemGallery(i + 1,v));
            });
        }
    },
    itemGallery: function(count,urlImageResponse) {
        let html = "";
        html += '<li>';
        html += '<div class="imgs item_gallery item_'+ count +'" data-count="'+ count +'">';
        html += '<img src="'+media_url+ urlImageResponse + '" id="item_'+count +'" data-count="'+ count +'">';
        html += '<input type="hidden" name="album[]" value="'+ urlImageResponse +'" >';
        html += '<a href="javascript:void(0)" class="btn btn-xs red delete_image" onclick="FUNC.removeInputImageproduct(this)">Xóa ảnh này</a>';
        html += '</div>';
        html += '</li>';
        return html;
    },
    removeInputImageproduct: function(_this) {
        $(_this).closest('li').remove();
    },
    getCookie: function(name){
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    },
    getYoutubeKey: function(url){
        var rx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
        if(url) var arr = url.match(rx);
        if(arr) return arr[1];
    },
    ajaxShowRequest: function (formData, jqForm, options) {
        jqForm.find('[type="submit"]').append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
        if(tinyMCE.editors.length > 0){
            for (let j = 0; j < tinyMCE.editors.length; j++){
                let idInput = tinyMCE.editors[j].id;
                let content = tinymce.get(idInput).getContent();
                $('[name="'+idInput+'"]').val(content);
            }
        }
        //let queryString = $.param(formData);
        return true;
    },
    ajaxShowResponse: function (response, statusText, xhr, $form) {
        if(response.csrf_form){
            $form.find('input[name="' + response.csrf_form.csrf_name + '"]').val(response.csrf_form.csrf_value);
            $('meta[name="csrf_form_token"]').attr('content',response.csrf_form.csrf_value);
        }
        $form.find('.fa-spin').remove();
        if (typeof response.type !== 'undefined') {
            toastr[response.type](response.message);
            if (response.type === "warning") {
                $form.find('.form-group').removeClass('has-danger');
                $form.find('.form-control-feedback').html('');
                $.each(response.validation, function (key, val) {
                    $form.find('[name="' + key + '"]').after(val).parent().addClass('has-danger');
                });
            } else {
                $form.find('.form-group').removeClass('has-danger');
                $form.find('.form-control-feedback').html('');
                //$form.reset();
                setTimeout(function () {
                    location.reload();
                }, 1500);
                // setTimeout(function () {
                //     if(response.url_redirect) location.href = response.url_redirect;
                // },2000);
            }
        }


    },
    ajaxShowError: function () {
        toastr['error']("The action you have requested is not allowed.");
    },
    clearCacheDb: function () {
        $.ajax({
            type: 'GET',
            url: base_admin_url + 'setting/ajax_clear_cache_db',
            dataType: 'json',
            success: function (response) {
                if (typeof response.type !== 'undefined') {
                    toastr[response.type](response.message);
                }
            }
        });
        return false;
    },
    clearCacheFile: function () {
        $.ajax({
            type: 'GET',
            url: base_admin_url + 'setting/delete_cache_file',
            dataType: 'json',
            success: function (response) {
                if (typeof response.type !== 'undefined') {
                    toastr[response.type](response.message);
                }
            }
        });
        return false;
    },
    clearCacheImage: function () {
        $.ajax({
            type: 'GET',
            url: base_admin_url + 'setting/ajax_clear_cache_image',
            dataType: 'json',
            success: function (response) {
                if (typeof response.type !== 'undefined') {
                    toastr[response.type](response.message);
                }
            }
        });
        return false;
    },
    clearLogUser: function () {
        $.ajax({
            type: 'GET',
            url: base_admin_url + 'logs/ajax_delete_log_user',
            dataType: 'json',
            success: function (response) {
                if (typeof response.type !== 'undefined') {
                    toastr[response.type](response.message);
                }
            }
        });
        return false;
    }

};
/*Đây là các Event Function để dùng chung*/
var UI = {
    activeMenu: function(){
        $('ul>li a[href="' + window.location.href + '"]').parent().addClass('m-menu__item--active').closest('.m-menu__item--submenu').addClass('m-menu__item--open m-menu__item--expanded');
    },
    ajaxFormSubmit: function(){
        $('form[method="post"]').ajaxForm({
            //target:        '#output1',   // target element(s) to be updated with server response
            beforeSubmit:  FUNC.ajaxShowRequest,  // pre-submit callback
            success:       FUNC.ajaxShowResponse,  // post-submit callback
            type:      'POST',        // 'get' or 'post', override for form's 'method' attribute
            dataType:  'JSON',        // 'xml', 'script', or 'json' (expected server response type)
            clearForm: false,        // clear all form fields after successful submit
            resetForm: true,       // reset the form after successful submit
            // $.ajax options can be used here too, for example:
        });
    },

    bootstrapSwitch: function(){
        $("[data-switch=true]").bootstrapSwitch();
    },
    init: function(){
        UI.activeMenu();
        UI.bootstrapSwitch();
    }
};
jQuery(function($) {
    UI.init();
});

$(document).ready(function() {
    if (user_id != 1) {/*neu group id khong = 1 thi se check permission_all*/
        let urlCurrentMenu;
        let jsonData = JSON.parse(permission_all);
        $('.m-menu__subnav .m-menu__item .m-menu__link').addClass('d-none-menu');
        $('.m-menu__item--submenu').addClass('d-none');
        $('#m_header_menu .m-menu__item').removeClass('d-none');
        $.each(jsonData, function(key,val) {
            urlCurrentMenu = base_admin_url + key;
            let menuElementMain = $('.m-menu__subnav .m-menu__item .m-menu__link[href="' + urlCurrentMenu + '"]');
            menuElementMain.removeClass('d-none-menu');
            menuElementMain.parent().parent().parent().parent().removeClass('d-none');
        });
    }
});

////////
/*
setInterval(function(){
$(".tabpdu1").click();
},90000)
 */
$(".tabpdu1").click(function(event) {
    /* Act on the event */
        var elment = $(this);
        var url = elment.attr("data-url");
        $.ajax({
            type: "POST",
            url: url+"/ajax_load2",
            data:{},
            dataType: 'json',
            beforeSend: function () {
                $(".pduiconquay.fa-spinner").show();
            },
            success: function (response) {
// console.log(response);
var html = "";
$.each(response, function( key, value ) {
            html+= "<div class='m-list-timeline__item'>";
            html += "<span class='m-list-timeline__badge -m-list-timeline__badge--state-success'></span>";
            html += "<span class='m-list-timeline__text'>";
            html += "Đơn hàng <strong>";
            html+= "<a href='"+url+"'>" + value.code + "</a>";
            html+= "</strong> đang chờ duyệt";
            html += "</span>";
            html += "<span class='m-list-timeline__time'>";
            html += new Date(value.time).toLocaleDateString();
            html += "</span></div>";

});
              $(".showtabpdu1").html(html);  
                $(".pduiconquay.fa-spinner").hide();
 
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });