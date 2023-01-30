<?php 
header('Content-Type: text/html; charset=utf-8');

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Báo giá sản phẩm ketsatgiadinh.vn</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<META NAME="description" CONTENT="Báo giá sản phẩm ketsatgiadinh.vn">
	<META NAME="keywords" CONTENT= "Báo giá sản phẩm ketsatgiadinh.vn">
	<META NAME="PAGE-TOPIC" content="Báo giá sản phẩm ketsatgiadinh.vn">
	<META name="revisit-after" content="2 days">
	<META NAME="ROBOTS" CONTENT= "INDEX, FOLLOW">
	<META NAME="distribution" content= "global">
	<META NAME="Copyright" content="ketsatgiadinh.vn">
	<link rel="shortcut icon" href="<?php echo site_url('public/favicon.ico') ?>">
<style>
	.list_table{
		border-collapse:collapse;
		border-style:solid;
		border-color:#999999;
	}
	.cart_first_tr{
		background-color:#cccccc;

	}
	body,form,table,td,span,div{
		font-family: "Times New Roman", Times, serif;
		font-size:14px;
		line-height:16px;
	}
	p{
		font-family: "Times New Roman", Times, serif;
		font-size:14px;
		line-height:15px;
	}
	.title{color:#000000; font-family: "Times New Roman", Times, serif; font-size:15px; text-decoration:none;}
	.content{color:#000000; font-family: "Times New Roman", Times, serif; font-size:14px; text-decoration:none;}
</style>

</head>
<body style="background:#FFFFFF">
	<center>
		<div style="width:900px; font-size:14px; position:relative; text-align:left; padding-right:1px; padding-top:15px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" align="center">
					<?php echo !empty($this->_settings->header_bao_gia) ? $this->_settings->header_bao_gia : ''; ?>
				<div style="padding-top:5px; text-align:center">--------o0o---------</div>
					</td>
					<td width="50%" align="center">
						<div style="padding:0px; margin:0px; font-weight:bold; text-align:center; font-size:25px;">BÁO GIÁ SẢN PHẨM</div>
					</td>
				</tr>
			</table>
			<div style="clear:both; height:25px;">&nbsp;</div>
			<div style="font-weight:bold; padding-left:150px;"><u>Kính gửi:</u> <i>Quý khách hàng!</i></div>
			<div style="clear:both; height:15px;">&nbsp;</div>
			<div style="font-weight:bold; font-style:italic;">Công ty Phú Gia An xin gửi tới Quý khách hàng bảng báo giá các sản phẩm sau:</div>
			<div style="clear:both; height:10px;">&nbsp;</div>

			<table class="list_table" cellspacing="0" cellpadding="5" rules="all" border="1" id="dgOrder" style="background-color:White;border-color:#C4C4CF;border-width:1px;border-style:Solid;font-family: 'Times New Roman', Times, serif;width:100%;border-collapse:collapse;">
				<tr class="tx_tit2" align="center" valign="middle" style="background-color:#CCFFCC;">
					<td width="5%"><strong>STT</strong></td>
					<td width="35%"><strong>Tên sản phẩm</strong></td>
					<td width="15%"><strong>Hình ảnh</strong></td>
					<td width="15%" align="center"><strong>Kích thước</strong></td>
					<td width="15%" align="center"><strong>Trọng lượng</strong></td>
					<td width="15%" align="right"><strong>Giá bán</strong></td>
				</tr>
				<?php $total_price = 0; if (!empty($data_arr_bg)) foreach ($data_arr_bg as $key => $value) : 
                    $data_product = getByIdProduct($value->id);
                    $total_price += $value->price*$value->quantity;
				?>
					<tr style="background-color:#FFFFFF;">
						<td align="center">
							<strong>1</strong>
						</td>
						<td align="left">
							<strong>
								<div class="title"><?php echo $data_product->title ?></div>
							</strong>
							<div class="content" style="padding-top:6px;">
								<strong>Bảo hành:</strong> 
								<span style="text-transform:lowercase"><?php echo $data_product->guarantee; ?></span>
							</div>
						</td>
						<td align="center" valign="middle">
							<img alt="<?php echo $data_product->title ?>" src="<?php echo getImageThumb($data_product->thumbnail,80,80); ?>" width="80px" />
						</td>
						<td align="left" valign="middle">
							<div class="content">
								<strong><?php echo $data_product->size; ?></strong>
							</div>
						</td>
						<td align="center" valign="middle">
							<div class="content">
								<strong><?php echo $data_product->mass; ?></strong>
							</div>
						</td>
						<td align="right" valign="middle">
							<div style="font-weight:bold"><?php echo number_format($value->price*$value->quantity,0,'','.'); ?></div>
						</td>
					</tr>
				<?php endforeach; ?>

				<tr class="tx_tit2" align="center" valign="middle" style="background-color:#CCFFCC;">
					<td colspan="4" align="right">
						<strong>Tổng tiền</strong>
					</td>
					<td align="right" colspan="2">
						<strong>
							<?php echo number_format($total_price,0,'','.') ?>
							<?php if (!empty($vat)):
								$total = $total_price + $total_price*10/100;
							?>
								x 10% = <?php echo number_format($total,0,'','.'); ?>
							<?php endif; ?>
						</strong>
					</td>
				</tr>
			</table>

			<div style="clear:both; height:10px;">&nbsp;</div>
			<div style="color:#000000; font-family:'Times New Roman', Times, serif; font-size:18px; text-decoration:underline;">
				<strong>Ghi chú:</strong>
			</div>
			<div style="clear:both; padding-left:20px; line-height:16px; text-align:justify;">
				<p>* Báo giá trên chưa bao gồm 10% thuế GTGT; có giá trị cho đến khi có báo giá mới thay thế.</p>
				<p>* Miễn phí giao hàng nội thành Hà Nội và TP.HCM bán kính 10km từ showroom.</p>
			</div>
			<div style="clear:both; height:5px;">&nbsp;</div>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="70%">&nbsp;</td>
					<td width="30%" align="center">TP. HCM, <?php echo 'ngày '.date('d').' tháng '.date('m').' năm '.date('Y') ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="center">
						<div style="clear:both; text-align:center; font-weight:bold; font-size:16px;">
							<p>Trân Trọng!</p>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</center>
</body>
</html>