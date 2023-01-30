<div class="dasboard">
	<div class="dasboard_head">
		<div class="dasboard_head_action">
			<div class="box_action">
				<button class="show_child">Hành động</button>
				<ul class="show_content clearfix boxmenu_item">
					<li><a href="<?php echo base_url('user/withdraw_coin'); ?>">rút tiền</a></li>
					<li><a href="<?php echo base_url('user/deposit_coin'); ?>">nạp tiền</a></li>
					<li><a href="<?php echo base_url('user/pending_coin'); ?>">Lịch sử Nạp/Rút</a></li>
                    
				</ul>
			</div>
		</div>
		
		<div class="price_total">Tổng tài khoản: <strong><?php echo $user->coin_total; ?> COIN</strong></div>

        <div class="price_lock">Coin đang khóa: <strong><?php echo $user->coin_lock; ?> COIN</strong></div>
        <p></p>
		<p class="des">1 COIN <=> <?php echo number_format($this->_settings_email->coin_price,0,'','.'); ?> vnđ</p>
	</div>
	<div class="dasboard_body">
		<div class="pdutab_btn">
			<button class="pdutab_link active pdubtn" data-href="#tab1"><span>Thu nhập từ ref</span></button>
			<button class="pdutab_link pdubtn" data-href="#tab2"><span>updateting..</span></button>
		</div>
		<div class="pdutab_content">
			<div id="tab1" class="pdutab_item active">
				<div class="row clearfix">
					<div class="col-md-4 col-sm-6">
						<div class="dasboard_content bg_bit">
							<div class="dasboard_content_t">
								<p>Thu nhập từ người đăng ký mới</p>
								<p><b>1ref = <?php echo $this->_settings_email->coin_ref; ?> COIN</b></p>
							</div>
							
							<img src="<?php echo $this->templates_assets.'images/bitcoin.svg'; ?>" alt="">
							<div class="das_content_price bold">
								<p>Tổng thu: <?php echo $user->coin_ref; ?> <strong>COIN</strong></p>
								<div class="progress">
								    <div class="progress-bar label-success" style="width:<?php echo ( (int)$user->coin_ref / $percent)*100; ?>%"><?php echo ( (int)$user->coin_ref / $percent)*100; ?>%</div>
								 </div>
								 <div class="star" title="Đạt 5* sẽ x2 phần thưởng">
								 	<i class="pdu-star"></i>
								 	<i class="pdu-star-o"></i>
								 	<i class="pdu-star-o"></i>
								 	<i class="pdu-star-o"></i>
								 	<i class="pdu-star-o"></i>
								 </div>
								<p class="boxmenu_item">
									<button class="btn withdraw_total" data-type="coin_ref">Rút về ví</button>
									<a href="<?php echo base_url('user/history?type=transfer'); ?>" class="btn history" title="quản lý lịch sử">quản lý</a>
                                </p>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="dasboard_content bg_eth">
							<div class="dasboard_content_t">
								<p>Thu nhập từ đơn hàng thành công</p>
								<p><b>Thưởng <?php echo $this->_settings_email->coin_order; ?>% giá trị đơn hàng</b></p>
							</div>
							
							<img src="<?php echo $this->templates_assets.'images/ethereum.svg'; ?>" alt="">
							<div class="das_content_price bold">
								<p>Tổng thu: <?php echo $user->coin_order; ?> <strong>COIN</strong></p>
								<div class="progress">
                                    <div class="progress-bar label-primary" style="width:<?php $x=((int)$user->coin_order / $percent); if($x > 1){echo 100;}else{echo $x*100;} ?>%"><?php echo $x*100; ?>%</div>
								 </div>
								 <div class="star" title="Đạt 5* sẽ x2 phần thưởng">
                                <?php if($x > 1){ ?>
								 	<i class="pdu-star"></i>
                                    <i class="pdu-star"></i>
                                    <i class="pdu-star"></i>
                                    <i class="pdu-star"></i>
                                    <i class="pdu-star"></i>
                                <?php }else{ $x2 = ceil($x*5);
                                    for ($i=0; $i < 5; $i++) { 
                                        echo "<i class='pdu-star'></i>";
                                        if($i == $x2){
                                            for ($j=$x2+1; $j < 5; $j++) {
                                                echo "<i class='pdu-star-o'></i>";
                                            }
                                            break;
                                        }
                                    }
                                ?>
                                <?php }; ?>
								 </div>
								<p class="boxmenu_item">
                                    <button class="btn withdraw_total" data-type="coin_order">Rút về ví</button>
                                    <a href="<?php echo base_url('user/history?type=transfer'); ?>" class="btn history" title="quản lý lịch sử">quản lý</a>
                                </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="tab2" class="pdutab_item">updateing...</div>
		</div>
	</div>

</div>
<style>
	.star {
    margin: 10px auto;
}
	.star i{
    display: inline-block;
    font-family: FontAwesome;
    font-size: 16px;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	}
	i.pdu-star:before {
    content: "\f005";
}
	i.pdu-star-o:before {
    content: "\f006";
}
.star .pdu-star {
    color: #51f380;
}
.star i:hover {
    scale: 1.3;
    color:#51f380;;
}
	.progress {
    height: 10px;
    margin: 10px auto;
    overflow: hidden;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgb(0 0 0 / 10%);
    box-shadow: inset 0 1px 2px rgb(0 0 0 / 10%);
}
.progress-bar {
    float: left;
    width: 0%;
    height: 100%;
    font-size: 10px;
    line-height: 11px;
    color: #fff;
    text-align: center;
    background-color: #337ab7;
    -webkit-box-shadow: inset 0 -1px 0 rgb(0 0 0 / 15%);
    box-shadow: inset 0 -1px 0 rgb(0 0 0 / 15%);
    -webkit-transition: width .6s ease;
    -o-transition: width .6s ease;
    transition: width .6s ease;
}

	.dasboard_content {
    border-radius: 6px;
    text-align: center;
    padding: 15px 10px;
    font-size: 16px;
    transition: all ease 0.6s;
}
.dasboard_content:hover {
    box-shadow: 0 10px 20px rgb(0 0 0 / 19%), 0 6px 6px rgb(0 0 0 / 22%);
}
.dasboard_content_t {
    min-height: 100px;
}
.dasboard_content img {
    width: 120px;
    height: 120px;
    object-fit: contain;
}
	.bg_bit{
background-color: #F6E5CA;
	}
	.bg_eth{
background-color: #F3D6EF;
	}
	.bold{font-weight: bold;}
	.pdutab_content .pdutab_item{
		display: none;
		opacity: 0;
		transition: all ease 0.6s;
	}
	.pdutab_content .pdutab_item.active {
    opacity: 1;
    display: block;
}
.pdutab_content {
    padding: 20px 0;
}
.pdutab_btn button{
    margin-right: 10px;
}
.pdutab_btn button:last-child {
    margin-right: 0;
}
.pdutab_btn {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}
.pdutab_btn button.active span {
    background: #20689e;
}

.pdutab_btn button:hover span {
    background: #20689e;
}
.pdubtn span {
    display: inline-block;
    border-radius: 6px;
    background: #55acee;
    color: #fff;
    transition: all ease 0.3s;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
    padding: 10px 20px;
    position: relative;
    z-index: 2;
}

@keyframes SidebarCreate{to{transform:translateX(-50%)}}
.pdubtn:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 200%;
    height: 100%;
    background: linear-gradient(115deg,#4fcf70,#fad648,#a767e5,#12bcfe,#44ce7b);
    background-size: 50% 100%;
    
}
.pdubtn:hover:before{animation:SidebarCreate .75s linear infinite;}
.pdubtn {
    overflow: hidden;
    position: relative;
    z-index: 2;
    padding: 3px;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    display: inline-block;
}

.dasboard_body {
    padding: 10px 15px;
    text-align: left;
}
.dasboard {
    text-align: center;
    color: #333;
    -webkit-box-shadow: 0 1px 15px 1px rgb(12 4 30 / 87%);
    -moz-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);
    box-shadow: 0 1px 15px 1px rgb(18 5 48 / 28%);
    background-color: #fff;
}

.dasboard_head {
    padding: 100px 30px;
    background: #7dbef0;
    background-image: linear-gradient(#fff, #7dbef0);
    position: relative;
}
.dasboard_head .price_total {
    font-size: 2em;
    background: linear-gradient(to right, #131414 0%, #d82762 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    padding: 10px 0;
    font-weight: bold;
}
.dasboard_head .price_lock {
    font-size: 18px;
    background: linear-gradient(to right, #1dd2d2 0%, #d88127 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    padding: 10px 0;
    font-weight: bold;
}
.dasboard_head_action {
    display: inline-block;
    font-size: 16px;
    position: absolute;
    top: 0;
    right: 7%;
    padding: 10px 15px;
}
.box_action {
    position: relative;
}
ul.show_content {
    opacity: 0;
    visibility: hidden;
    transition: all ease 0.5s;
    text-align: left;
    min-width: 200px;
    background: #fff;
    border-radius: 6px;
    position: absolute;
    top: 30px;
    right: 0;
}
ul.show_content li {
    border-bottom: 1px solid #e2dede;
}
.dasboard_head_action:hover ul.show_content {
    opacity: 1;
    visibility:visible;
    padding: 15px;
    margin-top: 10px;
}

.dasboard_head_action button.show_child {
    border: 1px solid #fff;
    padding: 5px 15px;
    border-radius: 5px;
    transition: all ease 0.5s;
    font-weight: bold;
}

ul.show_content:before {
	border: 12px solid transparent;
    border-bottom-color: #fff;
    position: absolute;
    top: -21px;
    right: 20px;
    content: "";
    border-radius: 5px;
}

ul.show_content a {
    display: inline-block;
    padding: 5px;
    font-size: 16px;
    text-transform: capitalize;
    color: #55acee;
}

ul.show_content a:hover {
    color: #1068ab;
}

</style>
