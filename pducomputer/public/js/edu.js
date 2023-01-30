/*createConfirm*/
const createConfirm = async (message) => { //async khai báo hàm này sẽ trả về 1 lời hứa
  let noidung = '<div class="m_confim--content"><strong id="m_confim--text" class="m_confim--text"></strong><button id="m_confim--yes" class="m_confim--yes btn" >Đồng ý</button><button id="m_confim--no" class="m_confim--no btn">Hủy bỏ</button></div>';
  let model = document.getElementById('m_confim');
  model.innerHTML = noidung;
  let yes = document.getElementById('m_confim--yes');
  let no = document.getElementById('m_confim--no');
  let text = document.getElementById('m_confim--text');

  return new Promise((complete, failed)=>{ //1 lời hứa sẽ trả về kết quả
    text.innerHTML = message;
    yes.onclick = () =>{
      model.style.display = "none";
      complete(true);
    }
    no.onclick = () =>{
      model.style.display = "none";
      complete(false);
    }
    model.style.display = "block";
  });
}
/*transfer server*/
function transfer_server(thiss) {
  event.preventDefault();
  let _this = $(thiss);
  let server = _this.attr("data-server");
  let id = _this.parent(".serverpdu").attr("data-id");
  let uri = _this.attr("href");
  $.ajax({
        type: "GET",
        url: base_url+'edu/transfer_server',
        data: {id,server},
        dataType: 'html',
        beforeSend: function() {
          $("#loadingpdu").show();
        },
        success: function (response) {
            $("#loadingpdu").hide();
            _this.closest('.list_edu').html(response);
            setTimeout(function () {
                $('.serverpdu a[href="' + window.location.href + '"]').addClass('active');
            },1500);
            window.history.pushState({'pageTitle':document.title,'html':response}, document.title, uri);
        }
    });
}
/* get URL parameter using jQuery or plain JavaScript?*/
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
jQuery(document).ready(function($) {
$('.serverpdu a[href="' + window.location.href + '"]').addClass('active');

/*toggle menu*/
$("body").on('click','#come_backedu',function (event) {
  $("header#header, main.main-content,section#breadcrumb-wrapper ").css({
    display: 'block'
  });
  $(".learnpdu").remove();
});
$("body").on('click','.learnpdu_toggle',function (event) {
  event.preventDefault();
  $(this).toggleClass('closep');
  $(".learnpdu_left").toggleClass('closep');
  $(".learnpdu_right").toggleClass('w100');
});
/*học ngay*/
$("body").on('click','#btnLearn',function (event) {
    event.preventDefault();
  let _this = $(this);
  let id = _this.attr("data-id");
  let server = getUrlParameter("server");
  $.ajax({
        type: "POST",
        url: base_url+'edu/learnedu',
        data: {id,server},
        dataType: 'html',
        beforeSend: function() {
          $("#loadingpdu").show();
        },
        success: function (response) {
            $("#loadingpdu").hide();
            $("header#header, main.main-content,section#breadcrumb-wrapper ").css({
              display: 'none'
            });
            $("#mainpdu").prepend(response);
            setTimeout(function () {
               /*summernote*/
            $('.summernote').summernote({
                  height: 100,
                  // toolbar: false,
                  toolbar: [
                  ['style', ['style']],
                  ['font', ['bold', 'underline', 'clear']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'help']]//codeview
                    ],
                    callbacks: {
                      onImageUpload: function(image) {
                        uploadImage(image);
                    }
                }
            });
          },2000);
        }
    });
});                
$("body").on('click','.btnBuyEdu',async function (event) { //muốn dùng await thì hàm chứa nó phải khai báo async
    event.preventDefault();
  let _this = $(this);
  let id = _this.attr('data-id');
  let confim = await createConfirm('Bạn có chắc chắn muốn thực hiện hành động này? Nó sẽ trừ COIN của bạn');//await đợi chờ lời hứa trả về
  if(confim){ 
    $.ajax({
        type: "POST",
        url: base_url+'edu/buyedu',
        data: {id},
        dataType: 'json',
        beforeSend: function() {
          $("#loadingpdu").show();
        },
        success: function (response) {
            if (typeof response.type !== 'undefined') {
                Toastr[response.type](response.message);
                $("#loadingpdu").hide();
                if (response.type === "success") {
                  location.reload();
                }
                
            }

        }
    });
  }
  
});

  /*load video*/
$("body").on('click','.load_video_pdusoft',function (event) {
        event.preventDefault();
        $('table tr').removeClass('current');
        $(this).closest('tr').addClass('current');
        let videoId = $(this).data('video');
        let videotype = $(this).data('type');
        let title = $(this).find('a').attr("title");
        $("#tenbaihoc>h2").text(title);
        if(videotype == "yt"){
          $('.video-iframe').attr('src', 'https://www.youtube.com/embed/' + videoId);
        }else{
          $("#download_btn").children('a').attr("href","https://drive.google.com/file/d/"+videoId+"/view")
          $('.video-iframe').attr('src', 'https://drive.google.com/file/d/' + videoId + '/preview');
        }
        
        $("html, body").animate({
            scrollTop: $(".section-video").offset().top - 150
        }, 600);
        
        return false;
    });
 /*collapsible*/
 $("body").on('click','.collapsible-item--title',function (event) {
        $(this).toggleClass('active');
        $(this).parent().siblings()
        .children(".collapsible-item--title").removeClass("active")
        .end()
        .children(".collapsible-item--content").slideUp(500);
        $(this).siblings(".collapsible-item--content").slideToggle(500);
    });
 /*save note edu*/    
  $("body").on('click', 'button.btnSaveNote', function(event) {
    event.preventDefault();
    let _this = $(this);
    $.ajax({
      type: "POST",
      url: base_url + "edu/ajax_note_edu",
      data:_this.closest('form#note_edu').serialize(),
      dataType: 'JSON',
      success: function (response) {
        Toastr[response.type](response.message);  
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(thrownError);
      }
    });
  });
/*uploadImage sumernot*/
  function uploadImage(image) {
    if(image == ''){
      return false;
    }
    var formData = new FormData();
    for(var i =0; i<image.length; i++){
      formData.append('avatar'+i, image[i]);/*dữ liệu json*/
    }
    $.ajax({
      url : base_url+'ajax/ajax_upimage_user',
      type: "POST",
      data:formData,
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function(response) {

        if (typeof response.type !== 'undefined') {
          Toastr[response.type](response.message);
        }else{
          $.each(response.file,function (i, val) {
            let image1 = $('<img>').attr('src',val);
            $('.summernote').summernote("insertNode", image1[0]);
          });

        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        console.log(errorThrown);
        console.log(textStatus);
        console.log(jqXHR);
      }
    });
  }


});/*end ready*/