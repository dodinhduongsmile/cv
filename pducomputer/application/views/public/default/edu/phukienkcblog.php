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

<?php if(!empty($listpro)){foreach($listpro as $key => $value){?>
<textarea name="" id="" cols="30" rows="10" class="itemtren">
<entry><id>tag:blogger.com,1999:blog-3158206181791438447.post-5899731778817470462</id><published>2021-02-16T20:39:00.002-08:00</published><updated>2021-02-16T20:39:38.663-08:00</updated><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/blogger/2008/kind#post'></category>
  <?php if(!empty($value->cateedu)){foreach($value->cateedu as $cate){?><category scheme='http://www.blogger.com/atom/ns#' term='<?php echo strtoupper($cate->slug); ?>'></category><?php }}; ?>
  <title type='text'><?php echo preg_replace('/[!@#$%^&*;:\/]/','', $value->title); ?></title>
  <content type='html'></textarea><content type='html'>
[masp]<?php echo $value->code; ?>[/masp]<br />
[giaban] <?php echo number_format($value->price, 0, '', '.');?> vnđ[/giaban]<br />
[giacu]<?php echo number_format($value->price+20000, 0, '', ',');?> vnđ[/giacu]<br />
[tinhtrang]Còn hàng[/tinhtrang]<br />
[mota]
<?php echo $value->title; ?>
[/mota]<br />
<!--more-->
<?php if(!empty($value->attribute)): ?>
[phanloai]
<select class="single-option-selector item_size">
  <?php foreach($value->attribute as $attr){ ?>
    <option value="<?php echo $attr; ?>"><?php echo $attr; ?></option>
  <?php }; ?>
</select>
[/phanloai]
<?php endif; ?>
<br />
[chitiet]<?php echo $value->content; ?>[/chitiet]<br />

<div class="albumpdu">
<?php //if(!empty($value->album)) foreach($value->album as $image): ?>
<img src="https://pducomputer.com/public/media//hethong/pducomputer.jpg" alt="<?php echo $value->title; ?>"/>
<?php //endforeach; ?>
</div>

    </content><textarea name="" id="" cols="30" rows="10" class="itemduoi"></content><link rel='replies' type='application/atom+xml' href='https://nhangheohocchuipdu.blogspot.com/feeds/5899731778817470460/comments/default' title='Đăng Nhận xét'/><link rel='replies' type='text/html' href='https://nhangheohocchuipdu.blogspot.com/2019/09/combo-khoa-ky-nang.html#comment-form' title='0 Nhận xét'/><link rel='edit' type='application/atom+xml' href='https://www.blogger.com/feeds/3158206181791438447/posts/default/5899731778817470460'/><link rel='self' type='application/atom+xml' href='https://www.blogger.com/feeds/3158206181791438447/posts/default/5899731778817470460'/><link rel='alternate' type='text/html' href='https://nhangheohocchuipdu.blogspot.com/2019/09/combo-khoa-ky-nang.html' title='Combo khóa kỹ năng'/><author><name>Trần Phương PD</name><uri>http://www.blogger.com/profile/14793311231388603450</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='32' height='32' src='//2.bp.blogspot.com/-CPScmcacqGc/XX0S8Tw12iI/AAAAAAAAyKA/kX9nFe9SAXwkutQHQivzi-x7gHgdAxJyQCK4BGAYYCw/s113/logo-panel.png'/></author><media:thumbnail xmlns:media="http://search.yahoo.com/mrss/" url="https://1.bp.blogspot.com/-1Ra4Z3CyYO4/XX5bv2Ub8nI/AAAAAAAAyL0/Aq_ZK5IG_5EzxDmcv3vQVf_CTB3ieSuEACNcBGAsYHQ/s72-c/dang-ky-combo-ky-nang.jpg" height="72" width="72"/><thr:total>0</thr:total></entry></textarea><?php }}; ?>


