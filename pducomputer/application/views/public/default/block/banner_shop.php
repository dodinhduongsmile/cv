<?php $list_img = getDataBanner("shop"); ?>
<section id="home-brands">
  <div class="wrapper">
    <div class="inner">
      <div class="grid">
        <?php if(!empty($list_img)): ?>
        <div id="owl-blog-single-slider" class="owl-carousel owl-theme">
          <?php foreach($list_img as $item): ?>
          <div class="item itempdu wow zoomIn" data-wow-delay="0.2s" data-wow-duration="0.75s">
            <a href="<?php echo $item->link_url; ?>" class="text-center"><img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo MEDIA_URL. $item->thumbnail; ?>" alt="<?php echo $item->title; ?>" /></a>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      </div>
    </div>
  </div>
</section>