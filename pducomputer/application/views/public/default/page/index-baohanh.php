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
         		<input id="searchbh" type="text" placeholder="Mã đơn hàng | phone | full name">

            	<button type="submit" class="btn searchbh">
                	<i class="fa fa-search" aria-hidden="true"></i>
                </button>
         		</form>
         		
         		<div class="table-responsive">
                  <h3 class="title_form">CHI TIẾT ĐƠN HÀNG</h3>
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Mã ĐH</th>
                           <th>Tên</th>
                           <th>Phone</th>
                           <th>Địa chỉ</th>
                           <th>Tổng tiền</th>
                           <th>Trạng thái</th>
                           <th>Chi tiết</th>
                        </tr>
                     </thead>
                     <tbody class="list_order">
                     	
                     </tbody>
                 </table>
         	
         	</div>
         </div>

       </div>

    </main>
    <?php $this->load->view($this->template_path . 'block/type_product'); ?>
 </div>
 <script>
 	$(".checkbh").on('click', 'button.searchbh', function(event) {
 		event.preventDefault();

        var elment = $(this).siblings("#searchbh");
        var q = elment.val();
        
        $.ajax({
            type: "POST",
            url: base_url + "/ajax/Search_bh",
            data:{q},
            dataType: 'json',
            beforeSend: function () {
                $("#loadingpdu").show();
            },
            success: function (response) {
                var html="";
                $.each(response,function(key, value ) {
                    html+="<tr><td>"+value.code+" </td><td>"+value.full_name+" </td><td>"+value.phone+" </td><td>address: "+value.address+"</td><td>"+formatMoney(value.total_amount,0)+"đ</td><td>"+value.is_status+"</td><td><a href='"+value.url_detail+"' target='_blank'>Xem Chi tiết</a> </td><tr>";
                });
                $(".list_order").html(html);
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
 	.formcheck form {
    width: 70%;
    margin: 0 auto;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 0;
}
.formcheck input::placeholder {
    color: #fff;
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

.formcheck button.btn.searchbh {
    background: transparent;
    color: #fff;
    margin-left: -70px;
    height: 100%;
    padding: 18px;
    font-size: 26px;
}

 </style>