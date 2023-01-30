
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="<?php echo site_admin_url() ?>" class="m-brand__logo-wrapper">
                            <img alt=""
                                 src="<?php echo $this->templates_assets ?>images/logo.png" width="100">
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block
					 ">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
                        id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>
                <!-- END: Horizontal Menu -->
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        <li class="m-menu__item">
                            <a href="<?php echo site_admin_url('menus') ?>" class="m-menu__link">
                                <i class="m-menu__link-icon flaticon-menu-1"></i>
                                <span class="m-menu__link-text">
                                    Cấu hình menu
                                </span>
                            </a>
                        </li>

                        <li class="m-menu__item m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon la la-eraser"></i>
                                <span class="m-menu__link-text">
                                    Cache Manager
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust" style="left: 73px;"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" onclick="FUNC.clearCacheDb()" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-database"></i>
                                            <span class="m-menu__link-text">
                                                Clear cache database
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" onclick="FUNC.clearCacheFile()" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-database"></i>
                                            <span class="m-menu__link-text">
                                                Clear cache file
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" onclick="FUNC.clearCacheImage()" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-image"></i>
                                            <span class="m-menu__link-text">
                                                Clear cache image
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" onclick="FUNC.clearLogUser()" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-image"></i>
                                            <span class="m-menu__link-text">
                                                Clear Log user
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width tabpdu1" m-dropdown-toggle="click" m-dropdown-persistent="1" aria-expanded="true" data-url="<?php echo site_url("admin/Order/")?>">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                    <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger m-animate-blink"></span>
                                    <span class="m-nav__link-icon m-animate-shake">
													<i class="flaticon-music-2"></i>
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url(); ?>public/admin/assets/app/media/img/misc/notification_bg.jpg); background-size: cover;">
														<span class="m-dropdown__header-title">
															9 New
														</span>
                                            <span class="m-dropdown__header-subtitle">
															User Notifications
														</span>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                                    <li class="nav-item m-tabs__item tabpdu1" data-url="<?php echo site_url("admin/Order/")?>">
                                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                                            Cart<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item tabpdu2">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">
                                                            Events
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item tabpdu3">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
                                                            Logs
                                                        </a>
                                                    </li>
                                                </ul>
                                                
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                                        <div class="m-scrollable mCustomScrollbar _mCS_2 mCS-autoHide mCS_no_scrollbar" data-scrollable="true" data-max-height="250" data-mobile-max-height="200" style="max-height: 250px; height: 250px; position: relative; overflow: visible;"><div id="mCSB_2" class="mCustomScrollBox mCS-minimal-dark mCSB_vertical mCSB_outside" tabindex="0" style="max-height: 250px;"><div id="mCSB_2_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">

                                                                <div class="m-list-timeline m-list-timeline--skin-light">
                                                                    <i class="pduiconquay fa fa-spinner fa-spin" style="display: none;"></i>
                                                                        <div class="m-list-timeline__items showtabpdu1">

                                                                            <!-- <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                                                <span class="m-list-timeline__text">
																						12 new users registered
																					</span>
                                                                                <span class="m-list-timeline__time">
																						Just now
																					</span>
                                                                            </div>
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge"></span>
                                                                                <span class="m-list-timeline__text">
																						System shutdown
																						<span class="m-badge m-badge--success m-badge--wide">
																							pending
																						</span>
																					</span>
                                                                                <span class="m-list-timeline__time">
																						14 mins
																					</span>
                                                                            </div> -->

                                                                        </div>
                                                                    </div>
                                                                </div></div><div id="mCSB_2_scrollbar_vertical" class="mCSB_scrollTools mCSB_2_scrollbar mCS-minimal-dark mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_2_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 50px; top: 0px; display: block; height: 207px; max-height: 230px;"><div class="mCSB_dragger_bar" style="line-height: 50px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div>
                                                    </div>
                                                    <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                                                        <div class="m-scrollable mCustomScrollbar _mCS_3 mCS-autoHide mCS_no_scrollbar" data-scrollable="true" data-max-height="250" data-mobile-max-height="200" style="max-height: 250px; height: 250px; position: relative; overflow: visible;"><div id="mCSB_3" class="mCustomScrollBox mCS-minimal-dark mCSB_vertical mCSB_outside" tabindex="0" style="max-height: 250px;"><div id="mCSB_3_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                                                                    <div class="m-list-timeline m-list-timeline--skin-light">
                                                                        <div class="m-list-timeline__items">
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                                                <a href="" class="m-list-timeline__text">
                                                                                    New order received
                                                                                </a>
                                                                                <span class="m-list-timeline__time">
																						Just now
																					</span>
                                                                            </div>
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
                                                                                <a href="" class="m-list-timeline__text">
                                                                                    New invoice received
                                                                                </a>
                                                                                <span class="m-list-timeline__time">
																						20 mins
																					</span>
                                                                            </div>
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                                                <a href="" class="m-list-timeline__text">
                                                                                    Production server up
                                                                                </a>
                                                                                <span class="m-list-timeline__time">
																						5 hrs
																					</span>
                                                                            </div>
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                                                <a href="" class="m-list-timeline__text">
                                                                                    New order received
                                                                                </a>
                                                                                <span class="m-list-timeline__time">
																						7 hrs
																					</span>
                                                                            </div>
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                                                <a href="" class="m-list-timeline__text">
                                                                                    System shutdown
                                                                                </a>
                                                                                <span class="m-list-timeline__time">
																						11 mins
																					</span>
                                                                            </div>
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                                                <a href="" class="m-list-timeline__text">
                                                                                    Production server down
                                                                                </a>
                                                                                <span class="m-list-timeline__time">
																						3 hrs
																					</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div></div><div id="mCSB_3_scrollbar_vertical" class="mCSB_scrollTools mCSB_3_scrollbar mCS-minimal-dark mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_3_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 50px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 50px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div>
                                                    </div>
                                                    <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                                        <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
																			<span class="">
																				All caught up!
																				<br>
																				No new logs.
																			</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click">
                                <a href="<?php echo base_url() ?>" target="_blank"
                                   class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
                                    <span class="m-nav__link-icon">
                                        <i class="la la-home"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="<?php echo $this->templates_assets ?>assets/app/media/img/users/user4.jpg"
                                                         class="m--img-rounded m--marginless m--img-centered" alt=""/>
												</span>
                                    <span class="m-topbar__username m--hide">
													Nick
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url(<?php echo $this->templates_assets ?>assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="<?php echo $this->templates_assets ?>assets/app/media/img/users/user4.jpg"
                                                         class="m--img-rounded m--marginless" alt=""/>
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">
                                                        <?php echo $this->session->userdata('user_name') ?>
                                                    </span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                        <?php echo $this->session->userdata('email') ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
																	<span class="m-nav__section-text">
																		Section
																	</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="<?php echo site_admin_url('user/profile') ?>"
                                                           class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">
																					My Profile
																				</span>
																			</span>
																		</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="<?php echo site_admin_url('user/activity') ?>"
                                                           title="Activity" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">
																			Activity
																		</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <a href="<?php echo site_admin_url('user/logout') ?>"
                                                           title="Logout"
                                                           class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                            Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>