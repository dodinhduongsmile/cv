<div class="table-responsive">
   <table class="table table-bordered table-hover">
      <thead>
         <tr class="active">
            <th>STT</th>
            <th>Tên Khóa Học</th>
            <th>Ngày đăng ký</th>
            <th>Phí(coin)</th>
            <th>Trạng thái</th>
            <th>Chi tiết</th>
         </tr>
      </thead>
   <tbody class="list_order">
      <?php if(!empty($list_edu)){
          $is_status = array(
             0 => array("tạm khóa",'danger'),
             1=> array("chưa đủ",'primary'),
             2=> array("đủ",'success'),
          );
         foreach($list_edu as $k=>$v){?>
            <tr>
               <td><?php echo $k; ?></td>
               <td><h6><?php echo $v->title; ?></h6></td>
               <td><?php echo date("d/m/Y", strtotime($v->created_time)); ?></td>
               <td><?php echo $v->price; ?></td>
               <td><span class="label label-<?php echo $is_status[$v->is_status][1] ?>"><?php echo $is_status[$v->is_status][0]; ?></span></td>
               <td><a class="btn" href="<?php echo get_url_edu($v); ?>">Chi tiết</a></td>
            </tr>
         <?php }}; ?>
      </tbody>
   </table>
   <div class="text-center" style="padding: 0px 15px">
      <button class="btn <?php if(count($list_edu) < @$limit){echo 'hide';} ?>" id="btn_loadmore" data-offset="1" data-url="">Load More</button>
   </div>
</div>
