<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name='robots' content='noindex,nofollow'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php if (!empty($SEO)): ?>
        <title><?php echo !empty($SEO['title']) ? $SEO['title'] : $SEO['meta_title']; ?></title>
        
    <?php else: ?>
        <title><?php echo isset($this->_settings->meta_title) ? $this->_settings->meta_title : ''; ?></title>
       
    <?php endif; ?>
    <script>
        var urlCurrentMenu = window.location.href,
            urlCurrent = window.location.href,
            segment = '<?php echo base_url($this->uri->segment(1)) ?>',
            base_url = '<?php echo base_url(); ?>',
            media_url = '<?php echo MEDIA_URL . '/'; ?>',
            csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name') ?>',
            csrf_token_name = '<?php echo $this->security->get_csrf_token_name() ?>',
            csrf_token_hash = '<?php echo $this->security->get_csrf_hash() ?>';
    </script>
  <link rel='stylesheet' href="<?php echo base_url().'public/css/style.css'; ?>"  />
  <script src="<?php echo base_url().'public/js/jquery.min.js'; ?>" type='text/javascript'></script>
</head>
<body>
<div class="googleapp">
  <div class="container">
    <div class="formcheck">
               
      <form id="file_gg">
        <div class="searchedu">
          <label for="sub">Tìm khóa học để update, insert thì bỏ qua</label>
            <input id="title_edu" name="title_edu" type="text" placeholder="tên khóa học"/>
            <input id="id_edu" type="hidden" name="id_edu" value="">
            <i class="fa fa-spinner fa-spin" style="display: none;"></i>
            
            <ul class="showproduct"></ul>
        </div> 
        <label for="sub">Load sub folder</label>
        <input id="sub" name="sub" type="checkbox" value="1">
        <label for="searchbh">Link folder scan</label>
        <div class="group">
          <input id="searchbh" name="link" type="text" placeholder="link youtube">
          <button type="submit" class="btn search_gg">scan
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </div>
        
      </form>
        
        <div id="contentvd"></div>
     </div>
  </div>
<script>

  /*search item*/
  $('#title_edu').bind('keyup change paste propertychange',function (event) {
        var elment = $(this);
        var q = elment.val();

        $("#id_edu").val("");
        $.ajax({
            type: "POST",
            url: base_url + "edu/ajax_serachedu",
            data:{q},
            dataType: 'json',
            beforeSend: function () {
                $(".searchedu").find('.fa-spinner').show();
            },
            success: function (response) {
                var html="";
                $.each(response,function(key, value ) {
                    html+="<li class='search_item' data-id='"+value.id+"'><img src='"+media_url+value.thumbnail+"' alt='"+value.title+"'><h3>"+value.title+"</h3></li> ";
                });
                
                $('.showproduct').html(html);
                $(".searchedu").find('.fa-spinner').hide();
                if(q == ''){
                    $(".showproduct").html("");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });
/*chọn item*/
  $('body').on('click', '.search_item', function(event) {
    event.preventDefault();
      $("#id_edu").val($(this).attr("data-id"));
      $("#title_edu").val($(this).find("h3").text());
      $(".showproduct").html("");

  });
  /*scan file google*/
  $("body").on('click', 'button.search_gg', function(event) {
    event.preventDefault();
        let title_edu = $("#title_edu").val();
        let link = $("#searchbh").val();
        if(link == ''){
          Toastr["error"]("Hãy điền đủ thông tin, chọn khóa học để update, không chọn thì sẽ insert");
          return false;
        }
        $.ajax({
            type: "GET",
            url: base_url + "googleapp/ajax_file_drive",
            data:$("form#file_gg").serialize(),
            dataType: 'JSON',
            success: function (response) {
                Toastr[response.type](response.message);
                $("#contentvd").html(response.html);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });
 </script>

 <script>
  var Toastr = {
    success : function(message){
        let t='<div class="alert alert-success alert-dismissible alert-ml" role="alert"\
            style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                '+message+' !\
            </div>';
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 2000);
        },
    error : function(message){
            let  t = '<div class="alert alert-danger alert-dismissible alert-ml" role="alert"\
                style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                    '+message+' !\
                </div>';
           
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 2000);
    },
    warning : function(message){
            let  t = '<div class="alert alert-danger alert-dismissible alert-ml" role="alert"\
                style="position: absolute;right: 40px;top:0px;width:250px; padding: 15px 5px; ">\
                    '+message+' !\
                </div>';
           
            $('#show_success_mss').html(t).show();
            setTimeout(function(){
                jQuery('#show_success_mss').fadeOut().empty();
            }, 2000);
    }
                
};
</script>
</div>
<div id="show_success_mss"></div>
</body>
</html>         
          
 <style>
  .formcheck select {
    width: 100%;
    border-radius: 16px;
    margin: 15px 0;
    border: 2px solid #a45a90;
}

.formcheck select:focus {
    outline: none;
}
  .formcheck form {
    width: 70%;
    margin: 0 auto;
    text-align: center;
    padding: 30px 0;
  }
  .formcheck .group {
    display: flex;
    justify-content: center;
    align-items: center;
    
}
.formcheck input::placeholder {
    color: #fff;
    text-transform: capitalize;
}
.formcheck input {
    width: 100%;
    border: 0;
    display: block;
    width: 100%;
    padding: 10px 97px 10px 27px;
    font-size: 18px;
    height: 70px;
    color: #fff;
    background: linear-gradient(to right, #2c6dd5 0%, #2c6dd5 28%, #ff4b5a 91%, #ff4b5a 100%);
    border-radius: 30px;
}
.formcheck button.btn.search_gg:hover {
    color: #06f5ad;
}
.formcheck button.btn.search_gg {
    background: transparent;
    color: #fff;
    margin-left: -99px;
    height: 70px;
    padding: 20px 22px;
    font-size: 26px;
    border: none;
    cursor: pointer;
    background: #0da4b0;
    border-radius: 14px;
}

 </style>