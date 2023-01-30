    <!-- begin content -->
      <div id="page" class="section main-container">
         <div class="report">
           <div class="container">
             <div class="report-form">
               <h2>GỬI BÁO CÁO VI PHẠM</h2>
               <p>Vui lòng gửi thông tin cho chúng tôi khi bạn phát hiện các vi phạm, để đảm bảo quyền lợi của khách hàng, cũng như vì một môi trường phát triển lành mạnh.</p>
               <form action="" method="post" id="formReport">
                  <p class="info_report">thông tin người tố cáo<p>
                  <input type="text" name="full_name" placeholder="*Nhập họ tên của bạn">
                  <input type="text" name="phone" placeholder="*Nhập số điện thoại của bạn">
                  <input type="text" name="email" placeholder="*Nhập email của bạn">
                  <input type="text" name="address" placeholder="*Nhập địa chỉ theo hộ khẩu của bạn">
                  <p class="info_report">thông tin tố cáo<p>
                  <select name="type_report" id="">
                    <?php
                    $this->config->load('menus');
                     if (!empty($this->config->item('cms_report'))) foreach ($this->config->item('cms_report') as $lang => $name): ?>
                                            <option value="<?php echo $lang ?>"><?php echo $name; ?></option>
                                        <?php endforeach; ?>
                  </select>
                  <input type="text" name="facebook" placeholder="Nhập link facebook người vi phạm">
                  <input type="text" name="website" placeholder="Nhập link website shop vi phạm">
                  <textarea name="content" id="" placeholder="Nhập nội dung"></textarea>
                  <div class="rules">
                    <input type="checkbox" name="agree" value="1">
                    <span>Tôi đồng ý với điều khoản khiếu nại của công ty. (<a href="/">Xem điều khoản tại đây</a>)</span>
                  </div>
                  <div class="submit_report">
                    <input type="button" class="submitReport" value="gửi">
                    <a href="<?php echo base_url(); ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
                  </div>
               </form>
             </div>
           </div>
         </div>
          <?php $this->load->view($this->template_path . 'block/type_product'); ?>
      </div>