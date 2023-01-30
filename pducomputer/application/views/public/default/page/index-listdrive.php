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
         	<div class="formdrive">
              <div class="searchedu">
                  <input id="searchvd" type="text" placeholder="tên khóa học"/>
                  <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                  
                  <ul class="showproduct"></ul>
              </div>
                
                <div class="setdata">
                  <div class="col-sm-6">
                    <label for="">dán name bài vào đây</label>
                    <textarea name="dataname" id="dataname"></textarea>
                  </div>
                  <div class="col-sm-6">
                    <label for="">dán link bài vào đây</label>
                    <textarea name="datalink" id="datalink"></textarea>
                  </div>
                  
                  <button type="button" class="btn" id="submit">chuyển đổi data blogspot</button>
                </div>
         		   <div id="inra" style="display: none;"></div>
         		
         		<div id="contentvd"></div>
         </div>

       </div>

    </main>
    <?php $this->load->view($this->template_path . 'block/type_product'); ?>
 </div>

<script>
  var id_itemedu = "";
  var title_itemedu = "";
  /*search item*/
  $('#searchvd').bind('keyup change paste propertychange',function (event) {
        var elment = $(this);
        var q = elment.val();

        id_itemedu = "";
        $.ajax({
            type: "POST",
            url: base_url + "/edu/ajax_serachedu",
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
      id_itemedu = $(this).attr("data-id");
      $("#searchvd").val($(this).find("h3").text());
      $(this).hide();

  });
/*submit*/
 	$(".checkbh").on('click', 'button#submit', function(event) {
 		event.preventDefault();
    title_itemedu = $("#searchvd").val();
    var dataname,the,datalink,data;
    dataname = $("#dataname").val();

      $("#inra").html(dataname);
      the = $("#inra option");
      
      datalink = document.getElementById("datalink").value; 
        datalink = datalink.replace(/(?:\r\n|\r|\n|\n\n)/g, ',');
        datalink = datalink.split(",");//arr2
        if(the.length == datalink.length){
  
          var customSort = function (a, b) {
            return (Number(a[0].match(/(\d+)/g)[0]) - Number((b[0].match(/(\d+)/g)[0])));
          }
          var obj2 = [];
            for(var i = 0; i<the.length; i++){
            obj2.push([the[i].innerHTML,datalink[i]]);
          };
          obj2.sort(customSort);
          /*
          //dùng object thì sau sang backend lại phải for rồi lồng dữ liệu cho nhau
            // obj['name'][] = the[i].innerHTML;
            // obj['link'][] = datalink[i];
           obj.sort(customSort);//méo sort đc object*/
          
        }else{
          alert("ten bai va so link khong bang nhau");
        }
        //validate
        if(title_itemedu == '' || dataname == '' || datalink ==''){
          Toastr["error"]("Hãy điền đủ thông tin");
          return false;
        }
        data = {obj2,id_itemedu,title_itemedu}
        /*update dữ liệu vào khóa học*/
        $.ajax({
            type: "POST",
            url: base_url + "/crawler/edupdu/getListDrive",
            data:data,
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
  .formdrive {
    padding-bottom: 100px;
}
ul.showproduct {
    max-height: 300px;
    overflow-x: auto;
    margin: 0;
    padding: 0 15px;
}
  .showproduct li.search_item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    border-bottom: 1px solid #e2dcdc;
    margin-bottom: 10px;
    transition: all ease 0.5s;
}
.showproduct li.search_item:hover {
background: #e2dcdc;
cursor: pointer;
}
.showproduct li.search_item img {
    width: 100px;
    height: 85px;
    object-fit: contain;
}

.showproduct li.search_item {
    padding: 0 10px;
}

.showproduct li.search_item h3 {
    font-size: 17px;
    text-transform: capitalize;
}
.searchedu {
    width: 70%;
    margin: 0 auto 15px;
}

input#searchvd {
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
input#searchvd::placeholder {
    color: #fff;
    text-transform: capitalize;
}
.setdata label {
    display: block;
    text-transform: capitalize;
    padding: 10px 0;
}

.setdata textarea {
    width: 100%;
    height: auto;
    border: 2px solid #e64f68;
}

.setdata button {
    margin-top: 20px;
}

.setdata {
    text-align: center;
}
</style>