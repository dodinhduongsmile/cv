<section id="breadcrumb-wrapper" class="breadcrumb-w-img">
     <div class="breadcrumb-overlay"></div>
     <div class="breadcrumb-content">
        <div class="wrapper">
           <div class="inner text-center">
              <div class="breadcrumb-big">
                 <h2>
                   <?php echo $oneItem->title; ?>
                 </h2>
              </div>
              <?php echo !empty($breadcrumb) ? $breadcrumb : ''; ?>
           </div>
        </div>
     </div>
</section> 
<div id="PageContainer" class="checkbh">
   <main class="main-content" role="main">
      <div id="page-wrapper">
         <div class="wrapper">
            <div class="content">
                <?php if(!empty($oneItem->thumbnail)): ?>
                       <div id="owl-home-main-slider" class="owl-carousel owl-theme" style="width: 100%;">
                          <div class="item"><a href="#"><img src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>" alt="<?php echo $oneItem->title; ?>"></a></div>
                          <?php if(!empty($oneItem->banner)): ?>
                          <div class="item"><a href="#"><img src="<?php echo MEDIA_URL.$oneItem->banner; ?>" alt="<?php echo $oneItem->title; ?>"></a></div>
                           <?php endif; ?>
                          
                       </div>
                   <?php endif; ?>
                   <?php echo $oneItem->content; ?>
            </div>
         	<div class="formcheck">
                
         		<form>
            <input id="titlelist" type="text" placeholder="tên list">
            <select name="" id="cate_edu">
              <option value="">- Chọn danh mục -</option>
              <?php 
                $cate_edu = getDataAll(["type"=>"edu"],'category','id,title');
                if(!empty($cate_edu)) foreach($cate_edu as $cate):
              ?>
              <option value="<?php echo $cate->id; ?>"><?php echo $cate->title; ?></option>
            <?php endforeach; ?>
            </select>
            <div class="group">
              <input id="searchbh" type="text" placeholder="link youtube">
              <button type="submit" class="btn search_yt">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </div>
         		
         		</form>
         		
         		<div id="contentvd">

         	  </div>
         </div>

       </div>

    </main>
    <?php $this->load->view($this->template_path . 'block/type_product'); ?>
 </div>
 <script>
 	$(".checkbh").on('click', 'button.search_yt', function(event) {
 		event.preventDefault();

        var q = $("#searchbh").val();
        var title = $("#titlelist").val();
        var idcate = $("#cate_edu").val();
        if(q == '' || title == '' || idcate ==''){
          Toastr["error"]("Hãy điền đủ thông tin");
          return false;
        }
        $.ajax({
            type: "GET",
            url: base_url + "/crawler/edupdu/getListYoutube",
            data:{q,title,idcate},
            dataType: 'JSON',
            beforeSend: function () {
                $("#loadingpdu").show();
            },
            success: function (response) {
                Toastr[response.type](response.message);
                $("#contentvd").html(response.html);
                $("#loadingpdu").hide();
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });
 </script>
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
    padding: 10px 32px 10px 70px;
    font-size: 18px;
    height: 70px;
    color: #fff;
    background: linear-gradient(to right, #2c6dd5 0%, #2c6dd5 28%, #ff4b5a 91%, #ff4b5a 100%);
    border-radius: 30px;
}
.formcheck button.btn.search_yt:hover {
    color: #06f5ad;
}
.formcheck button.btn.search_yt {
    background: transparent;
    color: #fff;
    margin-left: -70px;
    height: 100%;
    padding: 18px;
    font-size: 26px;
}

 </style>