 <div class="product-list row clearfix">

  <?php if(!empty($list_product)) foreach($list_product as $item): ?>
       <div class="col-md-3 col-sm-4 col-xs-6 col-480-12">
            <div class="product-item edu_item">
              <div class="product-img">
                <a href="<?php echo get_url_edu($item); ?>">
                <img src="<?php echo getThumbnailnoajax($item->thumbnail,230,240); ?>" alt="<?php echo $item->title; ?>">
                </a>
                <?php if($item->price_sale != 0): 
                  // dd($item->price_sale);
                ?>
                <div class="tag-saleoff text-center">
                  <?php echo "-".(100-(($item->price_sale/$item->price)*100)) ."%"; ?>
                </div>
              <?php endif; ?>

              </div>
              <div class="product-item-info text-center">
                <div class="product-title">
                  
                  <h2><a href="<?php echo get_url_edu($item); ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h2>
                </div>
                <div class="product-price clearfix">
                  <?php echo show_price_coin($item); ?>
                </div>
              </div>
            </div>
          </div>
  <?php endforeach; ?>
              </div>
             <div class="pagination not-filter">
                <div id="pagination-" class="text-center clear-left">
                   <?php echo !empty($pagination) ? $pagination : ''; ?>
                </div>
             </div>