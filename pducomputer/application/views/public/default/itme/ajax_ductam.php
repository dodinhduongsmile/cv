<?php 
$trangthaix = array(
	1 => "chưa hoàn thiện",
	2 => "xử lý lại",
	3 => "hoàn thiện"
);
$trangthaix2 = [
	1 => "red",
	2 => "green",
	3 => "blue"
];
?>
<?php if(!empty($listsp)) foreach($listsp as $key=>$value): ?>
	<tr data-id="<?php echo $value->id; ?>">
		<td><?php echo $value->id; ?></td>
		<td><?php echo date('d',time()) - date('d',strtotime($value->ngaynhan)); ?> </td>
 		<td><?php echo date('d-m-Y',strtotime($value->ngaynhan)) ; ?></td>
 		<td><?php echo date('d-m-y',strtotime($value->updated_time)) ; ?></td>
		<td><?php echo $value->tenmay; ?></td>
		<td><?php echo $value->servicetag; ?></td>
		<td><?php echo $value->son; ?> </td>
		<td><?php echo $value->lamman; ?> </td>
		<td><?php echo $value->ghichu; ?> </td>
		<td class="<?php echo $trangthaix2[$value->trangthai]; ?>"><?php echo $trangthaix[$value->trangthai]; ?> </td>
		<td><a href="#" class="btnEdit">SỬA</a> | <a href="#" class="btnDelete">XÓA</a></td>
	</tr>
<?php endforeach; ?>