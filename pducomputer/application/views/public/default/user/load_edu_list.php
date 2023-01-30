<?php if(!empty($list_edu)){
	$j = $stt;
 $is_status = array(
    0 => array("tạm khóa",'danger'),
    1=> array("chưa đủ",'primary'),
    2=> array("đủ",'success'),
 );
 foreach($list_edu as $k=>$v){
 	$j++;
 ?>
    <tr>
       <td><?php echo $j; ?></td>
       <td><h6><?php echo $v->title; ?></h6></td>
       <td><?php echo date("d/m/Y", strtotime($v->created_time)); ?></td>
       <td><?php echo $v->price; ?></td>
       <td><span class="label label-<?php echo $is_status[$v->is_status][1] ?>"><?php echo $is_status[$v->is_status][0]; ?></span></td>
       <td><a class="btn" href="<?php echo get_url_edu($v); ?>">Chi tiết</a></td>
    </tr>
<?php }}; ?>