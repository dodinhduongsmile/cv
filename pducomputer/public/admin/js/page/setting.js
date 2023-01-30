$(function() {
    AJAX_CRUD_MODAL.tinymce();
    AJAX_CRUD_MODAL.summernote();
    $('.datetimepicker').datetimepicker({
        'format': 'yyyy/mm/dd hh:ii'
    });

    $(document).on('click','.btnAddForm',function (event) {
    	event.preventDefault();
    	let key_setting = $('.m-portlet__head-tools a.active').attr('data-key');
    	let data = $('#'+key_setting).serialize(); // serialize() lấy tất cả name và value của từng input theo dạng string
    	$.ajax({
    		url: url_update_setting,
    		type: 'POST',
    		dataType: 'JSON',
    		data: $('#'+key_setting).serialize()
    	})
    	.done(function(response) {
            toastr[response.type](response.message);
    	});
    });
});





