<div class="table-responsive">
		<table>
			<thead>
				<tr class="active">
					<th>ID</th>
					<th>Type</th>
					<th>Trạng thái</th>
					<th>Số lượng</th>
					<th>Ngày</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody class="l_database">
				<?php if(!empty($list_pending)){
					$is_status = array(
		               0 => array("hủy",'danger'),
		               1=> array("chờ duyệt",'primary'),
		               2=> array("thành công",'success'),
		            );
					foreach($list_pending as $v){?>
				<tr>
					<td><?php echo $v->id; ?></td>
					<td><?php echo $v->type == 1 ? "Rút" : "Nạp"; ?></td>
					<td><span class="label label-<?php echo $is_status[$v->is_status][1] ?>"><?php echo $is_status[$v->is_status][0]; ?></span></td>
					<td><?php echo $v->amount; ?> coin</td>
					<td><?php echo date("d/m/Y", strtotime($v->created_time)); ?></td>
					<td><?php if($v->is_status !=0 && $v->is_status !=2){ ?>
			            <button class="btn btn-danger" id="cancel_bank" data-id="<?php echo $v->id; ?>">Hủy đơn</button>
			            <?php }; ?>
			        </td>
				</tr>
				<?php }}; ?>
			</tbody>
		</table>
	</div>
	<div class="text-center urlajax" data_url="<?php echo base_url("user/pending_coin/"); ?>"><?php echo !empty($pagination) ? $pagination : ''; ?></div>