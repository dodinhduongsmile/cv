
<section id="breadcrumb-wrapper" class="breadcrumb-w-img">
   <div class="breadcrumb-overlay"></div>
   <div class="breadcrumb-content">
      <div class="wrapper">
         <div class="inner text-center">
            <div class="breadcrumb-big">
               <h2>
                  giỏ hàng
               </h2>
            </div>
            <div class="breadcrumb-small">
               <a href="<?php echo base_url(); ?>" title="Quay trở về trang chủ">Trang chủ</a>
               <span aria-hidden="true">/</span>
               <span>Giỏ hàng của bạn</span>
            </div>
         </div>
      </div>
   </div>
</section>
<div id="PageContainer" class="is-moved-by-drawer checkoutpdu">
   <div class="container">
      <div class="row_pc">
         <div class="row">
            <div class="col-sm-8">
               <div class="table-responsive">
                  <h3 class="title_form">CHI TIẾT ĐƠN HÀNG</h3>
                  <table class="table">
                     <thead>
                        <tr>
                           <th class="product-thumbnail">Ảnh</th>
                           <th class="product-name">Sản phẩm</th>
                           <th class="product-quantity">Số lượng</th>
                           <th class="product-price">Giá</th>
                           
                           <th class="product-subtotal">Tổng cộng</th>
                           <th class="product-remove"><i class="fa fa-trash"></i></th>
                        </tr>
                     </thead>
                     <tbody>
            <?php if (!empty($data_cart)) : ?>
             <?php foreach ($data_cart as $key => $value): 
                 // $data_product = getByIdProduct($value['id']);
                 
                 $product_id = !empty(strstr($value['id'],"_")) ? str_replace(strstr($value['id'],"_"),"",$value['id']) : $value['id'];
                 (object)$data_product = [
                  "id" => $product_id,
                  "title" => $value['name'],
                  "price" => $value['price'],
                  "thumbnail" => $value['thumbnail'],
                  "slug" => $value['slug']
                 ];
                 $data_product = (object)$data_product;
                 
             ?>
                     <tr class="item_cart">
                        <td class="product-thumbnail">
                           <a href="<?php echo get_url_product($data_product) ?>" title="<?php echo $data_product->title ?>" class="thumbnail">
                           <img src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo getImageThumb($data_product->thumbnail,120,120); ?>" class="img-thumbnail lazyloadpd" alt="<?php echo $data_product->title ?>"/></a>
                        </td>
                        <td class="product-name">
                           <a href="<?php echo get_url_product($data_product) ?>" title="<?php echo $data_product->title ?>"><?php echo $data_product->title ?></a>
                        </td>
                        
                        <td class="product-quantity">
                              <div class="quantity">
                                 <input name="quantity" type="number" class="quality numberic" min="1" max="9999" value="<?php echo $value['qty']; ?>" pattern="[0-9]*"/>

                              </div>
                        </td>
                        <?php echo show_price_cart($data_product,$value['qty']); ?>
                        <td class="product-remove">
                           <a href="#" class="remove remove_item" title="Remove this item" data-identifier="<?php echo $key; ?>" data-id="<?php echo $value['id']; ?>">Xóa</a>
                        </td>
                     </tr>
         <?php endforeach; ?>
         <?php else: ?>
             <tr>
                 <td colspan="6" style="color: red;">Không có sản phẩm nào !!!</td>
             <tr>
         <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="cart-collaterals">
                  <div class="cart_totals">
                     <h3 class="title_form">Tổng đơn hàng</h3>
                     <table>
                        <tbody>
                           <tr class="order-total">
                              <th>Tổng cộng</th>
                              <td>
                                 <strong><span class="total_cart"> <?php echo !empty($this->cart->total()) ? number_format($this->cart->total(),0,'',',') : 0; ?><span class="currencySymbol"> vnđ</span></span></strong>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="">
                        <a href="<?php echo base_url("thanhtoan.html"); ?>" class="checkout-button button">Thanh toán</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
