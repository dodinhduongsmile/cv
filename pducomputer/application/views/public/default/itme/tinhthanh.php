<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    $ver = 1.43;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>API TỈNH THÀNH VIỆT NAM</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name='robots' content='index,dofollow'/>
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
	<link rel='stylesheet' href="<?php echo $this->templates_assets.'css/style.css'; ?>"  />
	<script src="<?php echo $this->templates_assets.'js/jquery.min.js'; ?>" type='text/javascript'></script>
</head>
<body>
    <div class="tinhthanh">
        <div class="container">
            <div class="boxone">
                <select id="city">
                    <option value="">--chọn tỉnh--</option>
                    <?php if(!empty($listCity)): foreach($listCity as $item): ?>
                    <option value="<?php echo $item->codename; ?>" data-code="<?php echo $item->code; ?>"><?php echo $item->name; ?></option>

                <?php endforeach;endif; ?>
                </select>

                <select id="district">
                    <option value="codename" data-code="code" data-province="province_code">huyện</option>
                </select>
                <select id="ward">
                    <option value="codename" data-code="code" data-district="district_code">xã</option>
                </select>
            </div><!-- end boxone -->
            <div class="boxtrue">
                <textarea name="" id="show_distric" placeholder="show_distric"></textarea>
                <textarea name="" id="show_ward" placeholder="show_ward"></textarea>
            </div><!-- end boxtrue -->
            <div class="boxthree">
                <input type="text" class="addfirst" placeholder="add text first">
                <input type="text" class="addlast" placeholder="add text last">
                <button class="addtext">add text</button>
            </div> <!-- end boxthree -->
            <hr><hr>
            <div class="boxfour">
                <h3>find and replace text in show_ward</h3>
                <input type="text" class="findtext" placeholder="tìm từ cần thay">
                <input type="text" class="replacetext" placeholder="từ thay thế">
                <input type="text" class="replacetext1" placeholder="mảng từ vd: laptop/pc/surface">
                <button class="btn_replacetext">replace text</button>
            </div>
        </div>
    </div>


<script>
    $('body').on('change','#city',function () {

            let code = $(this).children(":selected").attr("data-code");
            // let code = $(this).siblings('#city').children(":selected").attr("data-code");
            
                $.ajax({
                    url : base_url + "/crawler/seopdu/getDistric",
                    type: "get",
                    data: {code:code},
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response.districts);
                        var html="";
                        var html2 = "";
                        $.each(response.districts,function(index, value) {

                            html+= "<option value='"+value.codename+"' data-code='"+value.code+"' data-province='"+value.province_code+"'>"+value.name+"</option>";

                            html2+= value.name + "\n";
                            // console.log(value.name);
                        });
                        $("#district").html(html);
                        $("#show_distric").html(html2);

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log(errorThrown);
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                });

        });

    $('body').on('change','#district',function () {

            let code = $(this).children(":selected").attr("data-code");
            // let code = $(this).siblings('#city').children(":selected").attr("data-code");
            
                $.ajax({
                    url : base_url + "/crawler/seopdu/getWard",
                    type: "get",
                    data: {code:code},
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response.wards);
                        let html="";
                        let html2 = "";
                        $.each(response.wards,function(index, value) {

                            html+= "<option value='"+value.codename+"' data-code='"+value.code+"' data-district='"+value.district_code+"'>"+value.name+"</option>";

                            html2+= value.name + "\n";
                            // console.log(value.name);
                        });
                        
                        $("#ward").html(html);
                        $("#show_ward").val(html2);
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log(errorThrown);
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                });

        });

    /*click add text để add vào đầu và cuối của huyện và xã
        c1: Lưu biến mảng global district và ward -> click add text sẽ duyệt mảng và thêm text vào đầu và cuối

        c2: lấy list distric và ward -> convert sang mảng -> click add text sẽ duyệt mảng và thêm text vào đầu và cuối
    */
    
jQuery(document).ready(function() {
    $(".addtext").click(function(event) {
        /* Act on the event */
        var listDistrict , listWard, textFirst, textLast;
        var str = $("#show_distric").val(); 
        var str2 = $("#show_ward").val(); 

        str = str.replace(/(?:\r\n|\r|\n|\n\n)/g, ',');//thay thế xuống dòng,khoảng trắng thành dấu ,
        str2 = str2.replace(/(?:\r\n|\r|\n|\n\n)/g, ',');//thay thế xuống dòng,khoảng trắng thành dấu ,
        listDistrict = str.split(",");//chuyển string->array ngăn bởi dấu ,để for đc
        listWard = str2.split(",");
        // console.log(memberpdusoft);
        // document.write(memberpdusoft);
        var count = listDistrict.length, i = 0;
        var count2 = listWard.length, j = 0;

        textFirst = $(".addfirst").val();
        textLast = $(".addlast").val();
        let html = "";
        for(i;i<count;i++){
            html += textFirst + " "+ listDistrict[i]+ " " + textLast + "\n";
        }
        $("#show_distric").val(html);

        let html2 = "";
        for(j;j<count2;j++){
            html2 += textFirst + " "+ listWard[j]+ " " + textLast + "\n";
        }
        console.log(html2);
        $("#show_ward").val(html2);
    });
  });
</script>
<script>
    /*find and replace text in show_ward*/
    jQuery(document).ready(function($) {
        $(".btn_replacetext").click(function(event) {
            /* Act on the event */
            var findtext,replacetext,string,replacetext1;
            findtext = $(".findtext").val();
            replacetext = $(".replacetext").val();
            replacetext1 = $(".replacetext1").val();
            string = $("#show_ward").val();
            var reg = new RegExp(findtext, "gi");
            

            if(replacetext1 == "" && replacetext != ""){
                let string2= string.replace(reg, replacetext);
                console.log(string2);
                $("#show_ward").val(string2);
            }else if(replacetext == "" && replacetext1 != ""){
                list_replace = replacetext1.split("/");

                var count3 = list_replace.length, k = 0;
                let string2 = "";
                for(k; k<count3; k++){
                    string2+= string.replace(reg, list_replace[k]);
                    string2+= "\n";
                }
                $("#show_ward").val(string2);
            }else{
                console.log("Bạn chỉ có thể điền 1 trường replace");
            }

        });
    });
</script>
<style>
    textarea{
        width: 300px;
        height: 400px;
        overflow:auto;
    }
</style>
</body>
</html>