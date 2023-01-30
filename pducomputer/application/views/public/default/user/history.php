
<div class="history">
	<div class="table-responsive">
		<table>
			<thead>
				<tr class="active">
					<th>ID</th>
					<th>Type</th>
					<th>từ ai</th>
					<th>Cộng/Trừ(coin)</th>
					<th>Ngày</th>
					<th>Nội dung</th>
				</tr>
			</thead>
			<tbody class="l_database">
				<?php if(!empty($list_log)){
					foreach($list_log as $v){

					?>
				<tr>
					<td><?php echo $v->id; ?></td>
					<td><?php echo $v->type; ?></td>
					<td>taikhoan_<?php echo $v->child_id; ?></td>
					<td><?php echo $v->type == "delete_coin" ? "-" : "+";  ?><?php echo $v->reward; ?> coin</td>
					<td><?php echo date("d/m/Y", strtotime($v->created_time)); ?></td>
					<td><?php echo $v->note; ?></td>
				</tr>
				<?php }}; ?>
			</tbody>
		</table>
	</div>
	<div class="text-center urlajax" data_url="<?php echo base_url("user/history/"); ?>"><?php echo !empty($pagination) ? $pagination : ''; ?></div>
</div>