<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

   	<title><?php echo !empty($SEO['meta_title']) ? $SEO['meta_title'] : (!empty($this->_settings->title) ? $this->_settings->title : $this->_settings->title_short) ; ?></title>
   	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="description" content="<?php echo !empty($SEO['meta_description']) ? $SEO['meta_description'] : (!empty($this->_settings->meta_desc) ? $this->_settings->meta_desc : 'PDU Group'); ?>"/>

    <meta name="keywords" content="<?php echo !empty($SEO['meta_keyword']) ? $SEO['meta_keyword'] : (!empty($this->_settings->meta_keyword) ? $this->_settings->meta_keyword : 'PDU Group'); ?>"/>
    <meta name="Copyright" content="<?php echo !empty($SEO['url']) ? $SEO['url'] : base_url(); ?>"/>
    <meta name="robots" content="index, follow" />

      <meta name="revisit-after" content="2 days"/>
      <meta name="author" CONTENT= "<?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?>"/>
      <meta name="distribution" content= "global"/>
      
      <link rel='stylesheet' href="<?php echo $this->templates_assets.'css/style.css'; ?>"  />
      <link rel="shortcut icon" href="<?php echo site_url('public/favicon.ico') ?>" />

   </head>
   <body>
   	<div id="printable">
      <div style="width: 700px;margin: 0 auto;">
         <table >
            <tr>
               <td colspan="3" valign="top">
                  <img src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="" width:150px;/>
               </td>
               <td colspan="5" align="right" style="line-height: 19px;">
                  <b style="color: #e51f28;font-size: 20px;"><?php echo !empty($this->_settings->title) ? $this->_settings->title : 'PDUCOMPUTER'; ?></b><br />
                  Trụ sở chính: <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?> <br />
                  Hotline: <?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?> * Website: <?php echo !empty($this->_settings->domain) ? $this->_settings->domain : $_SERVER['HTTP_HOST']; ?>
               </td>
            </tr>
            <tr>
               <td colspan="9"></td>
            </tr>
            <tr>
               <td colspan="9" style="border-top: 4px double #ccc;;font-size:21px; font-weight:bold; text-align:center; padding:15px 0;">BẢNG BÁO GIÁ THIẾT BỊ</td>
            </tr>
         </table>
         <table>
            <tr>
               <td colspan="9">&nbsp;</td>
            </tr>
         </table>
         <table>
            <tr>
               <td colspan="6" align="left"></td>
               <td colspan="3" align="right">
                  Ngày báo giá: <span id="price_time"><?php echo date("d/m/Y - H:i",time()); ?></span>
               </td>
            </tr>
            <tr>
               <td colspan="6" align="left"></td>
               <td colspan="3" align="right">
                  <i>Đơn vị tính: VNĐ</i>
               </td>
            </tr>
         </table>
         <div style="padding: 10px;"></div>
         <table class="list_table" border="1">
            <tr style="color: #ffffff; background-color:#e00;">
               <td>STT</td>
               <td>Mã sản phẩm</td>
               <td>Ảnh</td>
               <td colspan="2">Tên sản phẩm</td>
               <td>Bảo hành</td>
               <td>Số lượng</td>
               <td>Đơn giá</td>
               <td>Thành tiền</td>
            </tr>
            <?php $i=0; $total = 0;
            if(!empty($data_pro_pc)) foreach($data_pro_pc as $item):
            	$data_product = getByIdProduct($item['id']);
            	$i++; 
            	$total += $item['price'] *$item['quantity'];
            ?>
            <tr>
               <td><?php echo $i; ?></td>
               <td><?php echo $data_product->code; ?></td>
               <td><a target="_blank" href="<?php echo get_url_product($data_product); ?>"><img src="<?php echo getThumbnailnoajax($data_product->thumbnail,230,240); ?>"></a></td>
               <td colspan="2"><a href="<?php echo get_url_product($data_product); ?>"><?php echo $data_product->title; ?></a></td>
               <td><?php echo $data_product->guarantee; ?></td>
               <td><?php echo $item['quantity'] ?></td>
               <td>
               	<?php echo number_format($item['price'],0,'','.')."<sup>đ </sup>";?>            	
               </td>
               <td>
                  <?php echo number_format($item['price'] *$item['quantity'],0,'','.')."<sup>đ </sup>"; ?>
               </td>
            </tr>
        <?php endforeach; ?>
            <tr>
               <td colspan="5"></td>
               <td colspan="2" style="background:#b8cce4;">Phí vận chuyển</td>
               <td colspan="2" style="background:#b8cce4;">0</td>
            </tr>
            <tr>
               <td colspan="5"></td>
               <td colspan="2" style="background:#b8cce4;">Chi phí khác</td>
               <td colspan="2" style="background:#b8cce4;">0</td>
            </tr>
            <tr>
               <td colspan="5"></td>
               <td colspan="2" style="background:#b8cce4;">Tổng tiền đơn hàng</td>
               <td colspan="2" style="background:#b8cce4;"><?php echo number_format($total,0,'','.')."<sup>đ </sup>"; ?></td>
            </tr>
            <tr>
               <td colspan="5"></td>
               <td colspan="2" style="background:#b8cce4;">Tổng tiền thanh toán sau KM tiền mặt</td>
               <td colspan="2" style="background:#b8cce4;"><?php echo number_format($total,0,'','.')."<sup>đ </sup>"; ?></td>
            </tr>
         </table>
         <table>
            <tr>
               <td colspan="9">&nbsp;</td>
            </tr>
         </table>
         <table >
            <tr>
               <td colspan="9"><b>Quý khách lưu ý:</b> Giá bán, khuyến mại của sản phẩm và tình trạng còn hàng có thể bị thay đổi bất cứ lúc nào mà không kịp báo trước</td>
            </tr>
            <tr>
               <td colspan="9">
                  Để biết thêm chi tiết, Quý khách vui lòng liên hệ <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'; ?> qua tổng đài <?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?> (8h00-21h30 tất cả các ngày trong tuần) hoặc email: <a href="mailto:<?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?>"><?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></a>
               </td>
            </tr>
            <tr>
               <td colspan="9">Một lần nữa <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'; ?> cảm ơn quý khách!</td>
            </tr>
         </table>
      </div>
      <style>
         .list_table {
         border-collapse:collapse;
         }
         .list_table td{border:solid 1px #aaa; padding:5px; text-algin:center; vertical-align:middle;}
         .cart_first_tr {
         background-color:#cccccc;
         }
         body, form, table, td, span, div {
         font-family: Arial, Helvetica, sans-serif;
         font-size:12px;
         }
         .title a {
         color:#0000FF;
         font-family:Arial, Helvetica, sans-serif;
         font-size:12px;
         text-decoration:none;
         }
         .title a:hover {
         color:#0000FF;
         text-decoration:underline;
         }
         a{text-decoration: none;}
         td a img{
         	width: 60px;
		    height: 55px;
		    object-fit: contain;

		}
    table {
    width: 100%;
}

      </style>
    </div>
      <div style="text-align: center;padding: 20px 0;">
        <a class="viewmore" href="javascript:window.history.go(-1)" class="btn_cyan" style="width:150px;display:inline-block;"><- Xây lại cấu hình</a>
        <a class="viewmore" href="#" onclick="In_Content('printable')" style="width:100px;display:inline-block;" class="btn_orange">In đơn hàng -></a>
     </div>
      
      <script>
  /*in don hang*/ 
    function In_Content(strid) {
      	let data = document.getElementById(strid).innerHTML;
      	var mywindow = window.open('', 'In hóa đơn', 'height=800,width=1200,toolbar=0,scrollbars=1,status=0');
            if (mywindow == null) {
                alert('Trình duyệt đã ngăn không cho phần mềm In. Vui lòng mở khóa hiển thị In ở góc phải phía trên của trình duyệt');
            } else {
                if (mywindow.document.URL == 'about:blank')
                    mywindow.document.writeln(data);

                setTimeout(function () {
                    mywindow.document.close();
                    mywindow.focus();
                    mywindow.print();
                    mywindow.close();
                    return true;
                }, 1000);
            }

    }
</script>
   </body>
</html>