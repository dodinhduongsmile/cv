<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-8">
                                <button  class="btn btn-primary updateTypeedu">updateTypeedu</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!--end: Search Form -->
            <div class="m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#tab_drive" role="tab" aria-selected="true">
                        <i class="la la-language"></i>update drive
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_youtube" role="tab" aria-selected="false">
                        <i class="la la-info"></i>update youtube
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_video" role="tab" aria-selected="false">
                        <i class="la la-info"></i>load html
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active show" id="tab_drive" role="tabpanel">
                <!-- update drive -->
<div id="PageContainer" class="checkbh">
   <main class="main-content" role="main">
      <div id="page-wrapper">
         <div class="wrapper">
          <div class="formdrive">
            <p>Vào link <?php echo base_url("googleapp/file_drive"); ?> để login google đã, rồi mới update đc</p>
              <div class="searchedu">
                  <input class="searchvd" type="text" placeholder="tên khóa học"/>
                  <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                  
                  <ul class="showproduct"></ul>
              </div>
                
              <input id="searchbh" type="text" placeholder="link drive"/>
              <div class="form-group">
                <label for="sub">Load sub folder</label>
                <input id="sub" name="sub" type="checkbox" checked="checked" value="1">
              </div>
              <button type="button" class="btn" id="submit1">Lấy data drive</button>

                <div id="contentvd"></div>

         </div>

       </div>

    </main>
 </div>

                <!-- update drive -->
            </div>
            <div class="tab-pane" id="tab_youtube" role="tabpanel">
                <!-- update youtube -->
<div id="PageContainer" class="checkyt">
   <main class="main-content" role="main">
      <div id="page-wrapper">
         <div class="wrapper">
          <div class="formcheck">

             <div class="searchedu">
                  <input class="searchvd" type="text" placeholder="tên khóa học"/>
                  <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                  <ul class="showproduct"></ul>
              </div>

              <input id="searchbh" type="text" placeholder="link youtube">
              <button type="button" class="btn" id="submit2">update youtube</button>
                
                <div id="contentvd2"></div>
         </div>

       </div>

    </main>
 </div>
                <!-- update youtube -->
            </div>
            <div class="tab-pane" id="tab_video" role="tabpanel">
<div id="PageContainer" class="loadvideo">
   <main class="main-content" role="main">
      <div id="page-wrapper">
         <div class="wrapper">
             <div class="searchedu">
                  <input class="loadvideo1" type="text" placeholder="tên khóa học"/>
                  <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                  <ul class="showproduct showproduct2"></ul>
              </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="html_dr"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="html_yt"></div>
                    </div>
                </div>
         </div>

       </div>

    </main>
</div>
            </div>
        </div>
    </div>
</div>
            <!--end: Datatable -->
        </div>
    </div>
</div>


<script type="text/javascript">
    var url_ajax_load_category = '<?php echo site_admin_url('category/ajax_load/edu') ?>';
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

input.searchvd,#searchbh,.loadvideo1,.bg_gra {
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
input.bg_gra:focus {
    color: #fff;
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

button#submit1,button#submit2 {
    margin-top: 20px;
}
button#submit1:hover, button#submit2:hover {
    background: #ad8181;
}

input:focus {
    outline: none;
}

input::placeholder {
    color: #fff;
    text-transform: capitalize;
}
.formcheck,.formdrive {
    text-align: center;
}

</style>