<script>
$(document).ready(function(){
  $(".myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    
    $(this).siblings('select').children('option').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<div class="row">
    <div class="col-sm-6 col-xs-12">
        <h3>Có cái nào thì điền, không thì bỏ qua.</h3>
        <?php if(!empty($attribute)) foreach($attribute as $item): ?>
        <div class="form-group">
            <label><b><?php echo $item->title; ?></b></label>
            <input class="form-control myInput" type="text" placeholder="Search.."/>
            <select name="attribute[<?php echo $item->slugattr; ?>][value]" class="form-control edit">
                <option value="">-Chọn giá trị-</option>

                <?php if(!empty($item->content)):
                    $datattr = json_decode($item->content);
                    foreach($datattr as $value):
                ?>
                <option value="<?php echo $value->key; ?>"><?php echo $value->key; ?></option>
                <?php endforeach;endif; ?>
            </select>
            <!-- tên sau gọi ra -->
            <input type="text" name="attribute[<?php echo $item->slugattr; ?>][name]" value="<?php echo $item->title; ?>" class="form-control"/>
            <!-- key này để lúc chọn select thì nó slug lại tên, để sau phục vụ cho LỌC -->
            <input type="text" name="attribute[<?php echo $item->slugattr; ?>][key]" value="" class="form-control edit2"/>
        </div>
        <?php  endforeach; ?>
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="form-group">
            <label><b>Model, mã máy:</b></label>
          <input type="text" name="attribute[model][value]" placeholder="Dell inspiron 5520" class="form-control edit"/>
          <input type="text" name="attribute[model][name]" value="Model, mã máy" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Thông số chi tiết cpu:</b></label>
          <input type="text" name="attribute[chi_tiet_cpu][value]" placeholder="intel core i5-3320m" class="form-control edit"/>
          <input type="text" name="attribute[chi_tiet_cpu][name]" value="Thông số chi tiết cpu" class="form-control"/>
        </div>
        <div class="form-group">
            <label><b>Thông số chi tiết VGA, GPU:</b></label>
          <input type="text" name="attribute[chi_tiet_vga][value]" placeholder="card rời và share, quado k2000 + intel graphic 4000" class="form-control edit"/>
          <input type="text" name="attribute[chi_tiet_vga][name]" value="Thông số chi tiết VGA, GPU" class="form-control"/>
        </div>
        <div class="form-group">
            <label><b>Chipset:</b></label>
          <input type="text" name="attribute[chipset][value]" placeholder="Mobile Intel HM77 Express Chipset" class="form-control edit"/>
          <input type="text" name="attribute[chipset][name]" value="Chipset" class="form-control"/>
        </div>

        
        <div class="form-group">
            <label><b>Giao Tiếp Mạng LAN:</b></label><br/>
            <input type="text" name="attribute[lan][value]" placeholder="Chuẩn 10/100/1000 Mbps Ethernet LAN" value="Chuẩn 10/100/1000 Mbps Ethernet LAN" class="form-control edit"/>
            <input type="text" name="attribute[lan][name]" value="Giao Tiếp Mạng LAN" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>PIN/Battery:</b></label><br/>
           <input type="text" name="attribute[battery][value]" placeholder="4 Cells" class="form-control edit"/>
           <input type="text" name="attribute[battery][name]" value="PIN/Battery" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>OS - Hệ điều hành:</b></label>
          <input type="text" name="attribute[he_dieu_hanh][value]" placeholder="Windows® 7 ultimate 64 bit" class="form-control edit"/>
          <input type="text" name="attribute[he_dieu_hanh][name]" value="OS - Hệ điều hành" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Ổ đĩa quang CD/DVD:</b></label>
          <input type="text" name="attribute[o_dia_quang][value]" placeholder="Có (đọc, ghi dữ liệu)" value="Có (đọc, ghi dữ liệu)" class="form-control edit"/>
          <input type="text" name="attribute[o_dia_quang][name]" value="Ổ đĩa quang CD/DVD" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Cân nặng:</b></label>
          <input type="text" name="attribute[can_nang][value]" placeholder="2.69kg" class="form-control edit"/>
          <input type="text" name="attribute[can_nang][name]" value="Cân nặng" class="form-control"/>
        </div>
        <div class="form-group">
            <label><b>Kích thước:</b></label>
          <input type="text" name="attribute[kich_thuoc][value]" placeholder="90x120x40 cm" class="form-control edit"/>
          <input type="text" name="attribute[kich_thuoc][name]" value="ích thước" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Màu Vỏ:</b></label>
          <input type="text" name="attribute[mau_vo][value]" placeholder="Nhựa đen" class="form-control edit"/>
          <input type="text" name="attribute[mau_vo][name]" value="Màu Vỏ" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Cổng Giao Tiếp & Tính Năng Mở Rộng:</b></label>
            <textarea name="attribute[more][value]" cols="20" rows="5" class="form-control edit">4 x USB 3.0, HDMI (KẾT NỐI TIVI, MÁY CHIẾU...VV...),LAN (RJ45), VGA - KẾT NỐI MÁY CHIẾU, TÍCH HỢP MICROPHONE - HEADPHONE, Camera, Bluetooth</textarea>
            <input type="text" name="attribute[more][name]" value="Cổng Giao Tiếp & Tính Năng Mở Rộng" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Video hướng dẫn bảo dưỡng:</b></label>
          <input type="text" name="attribute[video_baotri][value]" placeholder="link" class="form-control edit"/>
          <input type="text" name="attribute[video_baotri][name]" value="Video hướng dẫn bảo dưỡng" class="form-control"/>
        </div>
    </div>
</div>
<style>
    input[name*="[name]"],input[name*="[key]"]{
        display: none !important;
    }
</style>