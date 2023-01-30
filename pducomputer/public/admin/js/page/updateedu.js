jQuery(document).ready(function($) {


 var id_itemedu = "";

  var type_itemedu = "";
  /*search item*/
  $('.searchvd').bind('keyup change paste propertychange',function (event) {
        var elment = $(this);
        var q = elment.val();

        id_itemedu = "";
        $.ajax({
            type: "POST",
            url: base_url + "/admin/updateedu/ajax_serachedu",
            data:{q},
            dataType: 'json',
            beforeSend: function () {
                $(".searchedu").find('.fa-spinner').show();
            },
            success: function (response) {
                var html="";
                $.each(response,function(key, value ) {
                    html+="<li class='search_item search_item1' data-id='"+value.id+"' data-craw='"+value.crawlerhref+"' data-craw2='"+value.crawlerhref2+"'><img src='"+media_url+value.thumbnail+"' alt='"+value.title+"'><h3>"+value.title+"</h3></li> ";
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
  $('body').on('click', '.search_item1', function(event) {
    event.preventDefault();
      id_itemedu = $(this).attr("data-id");
        $(this).closest('.searchedu').find('.searchvd').val($(this).find("h3").text());

      $(".showproduct").html("");
  });
/*submit drive*/
$(".checkbh").on('click', 'button#submit1', function(event) {
        event.preventDefault();
        let _this = $(this);
        let link = _this.siblings("#searchbh").val();
        if(link == ''){
          toastr["error"]("Hãy điền đủ thông tin, chọn khóa học để update, không chọn thì sẽ insert");
          return false;
        }
        let title_itemedu = $(".formdrive .searchvd").val();
        let sub = $("input#sub:checked").val();
        data = {id_itemedu,title_itemedu,sub,link}
        $.ajax({
            type: "POST",
            url: base_url + "/admin/updateedu/getListDrive",
            data:data,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loadingpdu").show();
            },
            success: function (response) {
                toastr[response.type](response.message);
                $("#contentvd").html(response.html);
                $("#loadingpdu").hide();
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });

//submit youtube
$(".checkyt").on('click', 'button#submit2', function(event) {
 		event.preventDefault();
        let _this = $(this);
        var q = _this.siblings("#searchbh").val();
        let title_itemedu = $(".formcheck .searchvd").val();
        
        if(q == '' || title_itemedu == ''){
         toastr["error"]("Hãy điền đủ thông tin");
          return false;
        }
        data = {q,id_itemedu,title_itemedu,type_itemedu}
        $.ajax({
            type: "POST",
            url: base_url + "/admin/updateedu/getListYoutube",
            data:data,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loadingpdu").show();
            },
            success: function (response) {
                toastr[response.type](response.message);
                $("#contentvd2").html(response.html);
                $("#loadingpdu").hide();
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });

// update type
$("body").on('click', '.updateTypeedu', function(event) {
	event.preventDefault();
	$.ajax({
            type: "POST",
            url: base_url + "/admin/updateedu/updateType",
            data:{},
            dataType: 'JSON',
            success: function (response) {
                toastr[response.type](response.message);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
});


//loadvideo
 $('.loadvideo1').bind('keyup change paste propertychange',function (event) {
        var elment = $(this);
        var q = elment.val();
        $.ajax({
            type: "POST",
            url: base_url + "/admin/updateedu/ajax_serachedu1",
            data:{q},
            dataType: 'json',

            success: function (response) {
                var html="";
                $.each(response,function(key, value ) {
                    html+="<li class='search_item search_item2' data-id='"+value.id+"' data-craw='"+value.crawlerhref+"' data-craw2='"+value.crawlerhref2+"'><img src='"+media_url+value.thumbnail+"' alt='"+value.title+"'><h3>"+value.title+"</h3></li> ";
                });
                
                $('.showproduct2').html(html);
                if(q == ''){
                    $(".showproduct2").html("");
                }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });
$('body').on('click', '.search_item2', function(event) {
        let elment = $(this);
        let id = elment.attr('data-id');
        $.ajax({
            type: "POST",
            url: base_url + "/admin/updateedu/ajax_load1",
            data:{id},
            dataType: 'json',

            success: function (response) {
            	toastr[response.type](response.message);
                $('.html_dr').html(response.htmldr);
                $('.html_yt').html(response.htmlyt);
                $(".search_item2").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });
    });

});