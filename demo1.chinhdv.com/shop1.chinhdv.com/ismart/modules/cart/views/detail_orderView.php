<?php get_header()?>
<div>
	<h3>Đây là chi tiết đơn hàng của bạn</h3>
	<div>
		<?php
			echo $order['product'];
		?>
		Tiến trình vận chuyển xem tại đây <a href="/">$process_ship</a>
	</div>
</div>
<?php get_footer();?>