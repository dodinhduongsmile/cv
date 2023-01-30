document.addEventListener("DOMContentLoaded", function() {
    loadPostDrag($("#selectDrag"),{q:''});

    $('#nestableDrag').nestable({
        maxDepth: 1
    });

    $(document).on('click','.addtonavmenu',function () {
        let select = $('#selectDrag option:selected');
        let id = select.val();
        let title = select.html();
        if (!id || id == 'undefined') {
            toastr['error']("Vui lòng chọn bài viết");
            return;
        };
        $('#nestableDrag > ol.dd-list').append('<li class="dd-item dd3-item" data-id="'+id+'" data-type="home_featured"><div class="dd-handle dd3-handle"></div><div class="dd3-content">' + title + '</div><div class="action-item"><span class="nestledeletedd fa fa-trash"></span></div></li>');
        $('#nestableDrag').nestable({
            maxDepth: 1
        });
    });
    $(document).on('click','.nestledeletedd',function () {
        let element = $(this).parent().parent();
        element.remove();
        element.find('ol.dd-list').remove();
    });
    $(document).on('click', '.btnSaveMenu', function () {
        let select = $('#nestableDrag');
        if (select.find('.dd-list > *').length == 0){
            toastr['error']("Bạn chưa chọn Menu !");
        } else {
            let structure = select.nestable('serialize');
            let check = [];
            let save = 1;
            structure.forEach(function (item,key) {
                if (check.includes(item.id)) {
                    toastr['error']("Không thể trùng lặp bài viết!");
                    save = 0;
                    return false;
                } else{
                    check.push(item.id);
                }
            });
            if (save == 1) {
                saveData(structure);
            }
        }
    });
});
function loadPostDrag(selector,dataSelected) {
    if (selector.length > 0){
        selector.select2({
            placeholder: 'Chọn phim',
            data: dataSelected,
            ajax: {
                url: url_ajax_load_phim,
                dataType: 'json',
                delay: 250,
                data: function(e) {

                    return {
                        q: e.term,
                        page: e.page
                    }
                },
                processResults: function(e, t) {
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
}
function saveData(structure){
    $.ajax({
        type: "POST",
        url: base_admin_url + 'drag/save_drag',
        data: {
            s:structure,
            type
        },
        dataType: "json",
        cache: "false",
        success: function (result) {
            if (result == 1) {
                toastr['success']("Lưu thành công !");
            }
            else {
                toastr['error']("Lưu không thành công !");
            }
        }
    });
}