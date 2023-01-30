<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<button id="doIt">chuyển html</button>
<button id="doIt2">chuyển html2</button>
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

   $("#doIt,#doIt2").remove();

  });
</script>

<?php if(!empty($listedu)){foreach($listedu as $key => $value){?>
<textarea name="" id="" cols="30" rows="10" class="itemtren">
<entry><id>tag:blogger.com,1999:blog-3158206181791438447.post-5899731778817470462</id><published>2021-02-16T20:39:00.002-08:00</published><updated>2021-02-16T20:39:38.663-08:00</updated><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/blogger/2008/kind#post'></category><?php if(!empty($value->cateedu)){foreach($value->cateedu as $cate){?><category scheme='http://www.blogger.com/atom/ns#' term='<?php echo strtoupper($cate->slug); ?>'></category><?php }}; ?><title type='text'><?php echo preg_replace('/[!@#$%^&*;:\/]/','', $value->title); ?></title><content type='html'></textarea><content type='html'><div class ="pdugroup"><div class="img"><img src="<?php echo "http://pducomputer.com/public/media".$value->thumbnail; ?>" alt="<?php echo $value->title; ?>"/></div><br />[giaban]50[/giaban]<br />[tomtat]<br />Chia sẻ khóa học online edumall, unica, kyna, myclass, alada, hanhtrangsong, udemy, tiengtrung,,<br /><?php echo $value->description; ?>[/tomtat]<span><!--more--></span><br />[mota]<br /><div class="content1"><p>Xem chi tiết <a href="<?php echo $value->link_youtube; ?>" target="_blank" rel="nofollow">khóa học <?php echo $value->title; ?> trên trang chủ</a> </p><?php echo $value->content; ?></div><div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>Tên bài</th><th>Thời gian</th><th>Khóa Free</th><th>Học ngay</th></tr></thead><tbody><?php if(!empty($value->listdrive)){foreach($value->listdrive as $key =>$item){ ?><tr><td><?php echo $key; ?></td><td><h2><?php echo $item['name']; ?></h2></td><td><?php echo $item['time']; ?></td><td><a href="https://groups.google.com/forum/?hl=vi#!forum/tailieuonthipd" target="_blank" title="group khóa học miễn phí">Khóa free</a></td><td><a href="/p/dang-ky.html" target="_blank" title="xem ngay">Học ngay</a></td></tr><?php }}; ?></tbody></table></div><div style="text-align: right;"><i>Các bạn đọc hãy cho mình xin lời nhận xét để hoàn thiện hơn nhé!!!</i></div>[/mota]</div></content><textarea name="" id="" cols="30" rows="10" class="itemduoi"></content><link rel='replies' type='application/atom+xml' href='https://nhangheohocchuipdu.blogspot.com/feeds/5899731778817470460/comments/default' title='Đăng Nhận xét'/><link rel='replies' type='text/html' href='https://nhangheohocchuipdu.blogspot.com/2019/09/combo-khoa-ky-nang.html#comment-form' title='0 Nhận xét'/><link rel='edit' type='application/atom+xml' href='https://www.blogger.com/feeds/3158206181791438447/posts/default/5899731778817470460'/><link rel='self' type='application/atom+xml' href='https://www.blogger.com/feeds/3158206181791438447/posts/default/5899731778817470460'/><link rel='alternate' type='text/html' href='https://nhangheohocchuipdu.blogspot.com/2019/09/combo-khoa-ky-nang.html' title='Combo khóa kỹ năng'/><author><name>Trần Phương PD</name><uri>http://www.blogger.com/profile/14793311231388603450</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='32' height='32' src='//2.bp.blogspot.com/-CPScmcacqGc/XX0S8Tw12iI/AAAAAAAAyKA/kX9nFe9SAXwkutQHQivzi-x7gHgdAxJyQCK4BGAYYCw/s113/logo-panel.png'/></author><media:thumbnail xmlns:media="http://search.yahoo.com/mrss/" url="https://1.bp.blogspot.com/-1Ra4Z3CyYO4/XX5bv2Ub8nI/AAAAAAAAyL0/Aq_ZK5IG_5EzxDmcv3vQVf_CTB3ieSuEACNcBGAsYHQ/s72-c/dang-ky-combo-ky-nang.jpg" height="72" width="72"/><thr:total>0</thr:total></entry></textarea><?php }}; ?>
