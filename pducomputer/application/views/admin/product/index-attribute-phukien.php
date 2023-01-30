
<div class="row">
    <div class="col-sm-6 col-xs-12">
        <h3>Có cái nào thì điền, không thì bỏ qua.</h3>
        <?php if(!empty($attribute)) foreach($attribute as $item): ?>
        <div class="form-group">
            <label><b><?php echo $item->title; ?></b></label>
            <select name="attribute[<?php echo $item->slugattr; ?>][value]" class="form-control edit">
                <option value="">-Chọn giá trị-</option>
                <?php if(!empty($item->content)):
                    $datattr = json_decode($item->content);
                    foreach($datattr as $value):
                ?>
                <option value="<?php echo $value->key; ?>"><?php echo $value->key; ?></option>
                <?php  endforeach;endif; ?>
            </select>
            <input type="text" name="attribute[<?php echo $item->slugattr; ?>][name]" value="<?php echo $item->title; ?>" class="form-control"/>
             <input type="text" name="attribute[<?php echo $item->slugattr; ?>][key]" value="" class="form-control edit2"/>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-6 col-xs-12">
        
        <div class="form-group">
            <label><b>Model, mã máy:</b></label>
          <input type="text" name="attribute[model][value]" placeholder="blutooth 111" class="form-control edit"/>
          <input type="text" name="attribute[model][name]" value="Model, mã máy" class="form-control"/>
        </div>

        <div class="form-group">
            <label>xuất xứ:</label><br/>
            <input type="text" name="attribute[xuat_xu][value]" placeholder="trung quốc" class="form-control edit"/>
            <input type="text" name="attribute[xuat_xu][name]" value="xuất xứ" class="form-control"/>
        </div>
        <div class="form-group">
            <label><b>Cân nặng:</b></label>
          <input type="text" name="attribute[can_nang][value]" placeholder="2.69kg" class="form-control edit"/>
          <input type="text" name="attribute[can_nang][name]" value="Cân nặng" class="form-control"/>
        </div>
        <div class="form-group">
            <label><b>Kích thước:</b></label>
          <input type="text" name="attribute[kich_thuoc][value]" placeholder="90x120x40 cm" class="form-control edit"/>
          <input type="text" name="attribute[kich_thuoc][name]" value="kích thước" class="form-control"/>
        </div>
        
       <div class="form-group">
            <label><b>Màu Vỏ:</b></label>
          <input type="text" name="attribute[mau_vo][value]" placeholder="Nhựa đen" class="form-control edit"/>
          <input type="text" name="attribute[mau_vo][name]" value="Màu Vỏ" class="form-control"/>
        </div>

        <div class="form-group">
            <label><b>Tính Năng Mở Rộng, thông số khác mà trên không có:</b></label>
            <textarea name="attribute[more][value]" cols="20" rows="5" class="form-control edit"></textarea>
            <input type="text" name="attribute[more][name]" value="Tính Năng Mở Rộng, thông số khác" class="form-control"/>
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