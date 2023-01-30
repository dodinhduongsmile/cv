<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<button id="doIt">chuyển html</button>
<button id="doIt2">chuyển html2</button>
<input type="text" id="contentx">
<script>
  $('#doIt').click(function () {
$("content").each(function(){
var encodedStr = $(this).html().replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
       return '&#'+i.charCodeAt(0)+';';
    });
    $(this).html(encodedStr.replace(/&/gim, '&amp;'));
});
});

  $("#doIt2").click(function(event) {
   console.log("msg");
   $(".itemtren").each(function(i,valx){

    let val = $(this).val();

    $(this).wrap("<div id='x"+i+"'></div>");
    $("#x"+i).text(val);

   });
   $(".itemduoi").each(function(j,valj){

    let val = $(this).val();

    $(this).wrap("<div id='y"+j+"'></div>");
    $("#y"+j).text(val);

   });


  });
</script>


  <?php if(!empty($listedu)){foreach($listedu as $key => $value){?>
<textarea name="" id="" cols="30" rows="10" class="itemtren">
<entry><id>tag:blogger.com,1999:blog-2309420333560661243.post-307164418770709500<?php echo $key; ?></id><published>2021-02-16T20:39:00.002-08:00</published><updated>2021-02-16T20:39:38.663-08:00</updated><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/blogger/2008/kind#post'></category><?php if(!empty($value->cateedu)){foreach($value->cateedu as $cate){?><category scheme='http://www.blogger.com/atom/ns#' term='<?php echo strtoupper($cate->slug); ?>'></category><?php }}; ?><title type='text'><?php echo $value->title; ?></title><content type='html'></textarea><content type='html'><div class ="pdugroup"><div class="containerpdu"><div class="list-tabd"><a class="declick active" data-tabd="gioithieu" href="https://www.pdusoft.com/">giới thiệu</a><a class="declick" data-tabd="giaotrinh" href="https://www.pdusoft.com/">giáo trình</a><a class="declick" data-tabd="giangvien" href="https://www.pdusoft.com/">download</a></div><!-- begin CODE TAB NỘI DUNG --><div class="content-tabd"><div class="danhsach active" id="gioithieu"><img src="<?php echo MEDIA_URL.$value->thumbnail; ?>" alt=""><br /><?php echo ($value->content); ?> <br />====== <br /><br /><br /></div><!--more--><br /><div class="danhsach ok" id="giaotrinh"><br /><?php echo ($this->load->view($this->template_path .'edu/viewlistvideo', ['typevd'=>'dr','linklist'=>$value->link_drive,'listvd'=>$value->listdrive],true)); ?></div><div class="danhsach" id="giangvien"><br /><div class="downloadtl"><a href="/" rel="nofollow" target="_blank">Download google driver</a><br /><a href="/" rel="nofollow" target="_blank">Dowload tại Vipshare</a><br /><a href="/" rel="nofollow" target="_blank">Dowload tại Mshare</a></div> <?php echo ($this->load->view($this->template_path .'edu/viewlistvideo', ['typevd'=>'yt','linklist'=>$value->link_youtube,'listvd'=>$value->listyoutube],true)); ?></div> </div><!--/content-tabd--></div><!--/containerpdu--><!-- /END CODE TAB NỘI DUNG --></div></content><textarea name="" id="" cols="30" rows="10" class="itemduoi"></content><link rel='replies' type='application/atom+xml' href='https://gpsgohuy.blogspot.com/feeds/3071644187707095976/comments/default' title='Đăng Nhận xét'/><link rel='replies' type='text/html' href='https://gpsgohuy.blogspot.com/2021/02/test-pdusoft_16.html#comment-form' title='0 Nhận xét'/><link rel='edit' type='application/atom+xml' href='https://draft.blogger.com/feeds/2309420333560661243/posts/default/3071644187707095976'/><link rel='self' type='application/atom+xml' href='https://draft.blogger.com/feeds/2309420333560661243/posts/default/3071644187707095976'/><link rel='alternate' type='text/html' href='https://gpsgohuy.blogspot.com/2021/02/test-pdusoft_16.html' title='test pdusoft'/><author><name>Trần Phương PD</name><uri>https://draft.blogger.com/profile/14793311231388603450</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='32' height='32' src='//2.bp.blogspot.com/-CPScmcacqGc/XX0S8Tw12iI/AAAAAAAAyKA/kX9nFe9SAXwkutQHQivzi-x7gHgdAxJyQCK4BGAYYCw/s32/logo-panel.png'/></author><thr:total>0</thr:total></entry></textarea><?php }}; ?>
