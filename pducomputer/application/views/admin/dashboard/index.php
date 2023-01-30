<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#tabpdu1" role="tab" aria-selected="true">
                                    <i class="la la-bell"></i>
                                    Thông Báo
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#tabpdu2" role="tab" aria-selected="false">
                                    <i class="la la-money"></i>
                                    Doanh Số
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                    	<!-- tabpdu1 -->
                        <div class="tab-pane active show" id="tabpdu1" role="tabpanel">
                            <div class="tabpdu">
                            	<div class="col-md-12 m--align-right">
					                <a href="javascript:;" class="btn btn-info m-btn m-btn--icon m-btn--air m-btn--pill reload_tabpdu1">
					                    <span>
					                        <i class="la la-refresh"></i>
					                        <span>Refresh</span>
					                    </span>
					                </a>
					            </div>
                                <!--Begin::Timeline 3 -->
								<div class="m-timeline-3">
									<div class="m-timeline-3__items">
										<div id="count_order" class="m-timeline-3__item m-timeline-3__item--info">
											<span class="m-timeline-3__item-time">
												1
											</span>
											<div class="m-timeline-3__item-desc">
												<a href="<?php echo site_admin_url('order'); ?>" class="m-link m--font-info">
												<i class="la la-cart-plus"></i>Bạn có <strong class="m--font-danger">5</strong> đơn hàng mới, chờ duyệt
												</a>
												
											</div>
										</div>
										
										<div id="count_nap" class="m-timeline-3__item m-timeline-3__item--brand">
											<span class="m-timeline-3__item-time">
												2
											</span>
											<div class="m-timeline-3__item-desc">
												<a href="<?php echo site_admin_url('logbank'); ?>" class="m-link m--font-brand">
												<i class="la la-bullhorn"></i>Bạn có <strong class="m--font-danger">5</strong> lệnh nạp tiền mới
												</a>
												
											</div>
										</div>
										
										<div id="count_rut" class="m-timeline-3__item m-timeline-3__item--danger">
											<span class="m-timeline-3__item-time">
												3
											</span>
											<div class="m-timeline-3__item-desc">
												<a href="<?php echo site_admin_url('logbank'); ?>" class="m-link m--font-danger">
												<i class="la la-exclamation-triangle"></i>Bạn có <strong class="m--font-danger">5</strong> lệnh rút tiền mới
												</a>
												
											</div>
										</div>
										<div id="count_edu_user" class="m-timeline-3__item m-timeline-3__item--success">
											<span class="m-timeline-3__item-time">
												4
											</span>
											<div class="m-timeline-3__item-desc">
												<a href="<?php echo site_admin_url('order_edu'); ?>" class="m-link m--font-success">
												<i class="la la-phone"></i>Bạn có <strong class="m--font-danger">5</strong> Khóa học khách đăng ký, chưa có drive
												</a>
												
											</div>
										</div>

										<div id="comment_bad" class="m-timeline-3__item m-timeline-3__item--success">
											<span class="m-timeline-3__item-time">
												5
											</span>
											<div class="m-timeline-3__item-desc">
												<a href="<?php echo site_admin_url('comment'); ?>" class="m-link m--font-success">
												<i class="la la-phone"></i>Bạn có <strong class="m--font-danger">5</strong> comment dưới 4*
												</a>
												
											</div>
										</div>
									</div>
								</div>
								<!--End::Timeline 3 -->
                            </div>
                        </div>
                        <!-- tabpdu2 -->
                        <div class="tab-pane" id="tabpdu2" role="tabpanel">
                            <div class="tabpdu">
                            	
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-loader m-loader--brand loaderpdu"></div>
<style>
.tabpdu a {
    font-size: 17px;
    
}
.m-timeline-3__item-desc a{
	padding: 10px 0;
	font-weight: 700;
}
.m-timeline-3__items .m-timeline-3__item:hover {
    background: #e5e2e2;
}
strong.m--font-danger {
    font-size: 22px;
    padding: 0 7px;
}
.m-loader.loaderpdu {
    display: none;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    transition: all ease 0.7s;
    text-align: center;
    vertical-align: middle;
}

.m-loader.loaderpdu:before {
    width: 30px;
    height: 30px;
}
</style>
<script>
    var url_ajax_load1 = '<?php echo site_url('admin/dashboard/ajax_load1')?>';
</script>