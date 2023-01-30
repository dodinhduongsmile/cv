<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                        <button type="submit" class="btn btn-primary m-btn m-btn--icon m-btn--air m-btn--pill btnAddForm">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Update Setting
                                </span>
                            </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>

            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-key="data_seo" data-toggle="tab" href="#tab_general" role="tab" aria-selected="true">
                                    <i class="la la-search"></i>
                                    Cấu hình SEO
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" data-key="data_social" href="#tab_social" role="tab" aria-selected="false">
                                    <i class="la la-facebook"></i>
                                    Mạng xã hội
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" data-key="data_email" href="#tab_email" role="tab" aria-selected="false">
                                    <i class="la la-cog"></i>
                                    Cấu hình email
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" data-key="data_home" href="#tab_home" role="tab" aria-selected="false">
                                    <i class="la la-cog"></i>
                                    Cấu hình trang chủ
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab_general" role="tabpanel">
                            <div class="tab-content">
                                <form action="" id="data_seo">
                                    <input type="hidden" value="data_seo" name="key_setting">
                                    <div class="form-group">
                                        <label>Tên ngắn Website</label>
                                        <input name="title_short"
                                        placeholder="Tên ngắn Website"
                                        class="form-control" type="text"
                                        value="<?php echo isset($data_seo->title_short) ? $data_seo->title_short : ''; ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Tên Website</label>
                                        <input name="title"
                                        placeholder="Tên Website"
                                        class="form-control" type="text"
                                        value="<?php echo isset($data_seo->title) ? $data_seo->title : ''; ?>"/>
                                    </div>
                                
                                    <div class="form-group">
                                        <label>Tiêu đề SEO</label>
                                        <input name="meta_title"
                                        placeholder="Tiêu đề SEO"
                                        class="form-control" type="text"
                                        value="<?php echo isset($data_seo->meta_title) ? $data_seo->meta_title : ''; ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Mô tả SEO Website</label>
                                        <textarea name="meta_desc" class="form-control"><?php echo isset($data_seo->meta_desc) ? $data_seo->meta_desc : ''; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Từ khóa SEO Website</label>
                                        <input name="meta_keyword"
                                        placeholder="Từ khóa SEO Website"
                                        class="form-control" type="text"
                                        value="<?php echo isset($data_seo->meta_keyword) ? $data_seo->meta_keyword : ''; ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ trụ sở chính</label>
                                        <input name="meta_address" class="form-control" value="<?php echo isset($data_seo->meta_address) ? $data_seo->meta_address : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Domain</label>
                                        <input name="domain" class="form-control" value="<?php echo isset($data_seo->domain) ? $data_seo->domain : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>MST</label>
                                        <input name="mst" class="form-control" value="<?php echo isset($data_seo->mst) ? $data_seo->mst : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Hotline</label>
                                        <input name="meta_hotline" class="form-control" value="<?php echo isset($data_seo->meta_hotline) ? $data_seo->meta_hotline : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Hotline Hà Nội</label>
                                        <input name="meta_hotline_hn" class="form-control" value="<?php echo isset($data_seo->meta_hotline_hn) ? $data_seo->meta_hotline_hn : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Hotline Hồ Chí Minh</label>
                                        <input name="meta_hotline_hcm" class="form-control" value="<?php echo isset($data_seo->meta_hotline_hcm) ? $data_seo->meta_hotline_hcm : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Hotline</label>
                                        <input name="meta_email" class="form-control" value="<?php echo isset($data_seo->meta_email) ? $data_seo->meta_email : ''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="thumbnail">Logo</label>
                                        <div class="input-group m-input-group m-input-group--air">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-picture-o"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="logo" value="<?php echo !empty($data_seo->logo) ? $data_seo->logo : '' ?>" onclick="FUNC.chooseImage(this)" class="form-control m-input chooseImage" placeholder="Click để chọn ảnh">
                                        </div>
                                        <div class="alert m-alert m-alert--default preview text-center mt-1" role="alert">
                                            <img height="70" src="<?php echo !empty($data_seo->logo) ? getImageThumb($data_seo->logo,100,100) : '' ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label>Hướng dẫn in báo giá</label>
                                        <textarea name="sp_in_bg" class="form-control summernote"><?php //echo !empty($data_seo->sp_in_bg) ? $data_seo->sp_in_bg : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Thông tin form báo giá</label>
                                        <textarea name="header_bao_gia" class="form-control summernote"><?php //echo !empty($data_seo->header_bao_gia) ? $data_seo->header_bao_gia : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Nội dung dưới sản phẩm</label>
                                        <textarea name="content_product" class="form-control summernote"><?php //echo !empty($data_seo->content_product) ? $data_seo->content_product : ''; ?></textarea>
                                    </div> -->
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_social" role="tabpanel">
                            <div class="tab-content">
                                <form action="" id="data_social">
                                    <input type="hidden" value="data_social" name="key_setting">
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input name="facebook" class="form-control" value="<?php echo isset($data_social->facebook) ? $data_social->facebook : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Google</label>
                                        <input name="google" class="form-control" value="<?php echo isset($data_social->google) ? $data_social->google : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <input name="twitter" class="form-control" value="<?php echo isset($data_social->twitter) ? $data_social->twitter : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Youtube</label>
                                        <input name="youtube" class="form-control" value="<?php echo isset($data_social->youtube) ? $data_social->youtube : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Instalgram</label>
                                        <input name="instalgram" class="form-control" value="<?php echo isset($data_social->instalgram) ? $data_social->instalgram : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Pinterest</label>
                                        <input name="pinterest" class="form-control" value="<?php echo isset($data_social->pinterest) ? $data_social->pinterest : ''; ?>">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_email" role="tabpanel">
                            <form action="" id="data_email">
                                <input type="hidden" value="data_email" name="key_setting">
                                <div class="form-group">
                                    <label>Email quản trị</label>
                                    <input type="text" name="email_admin" placeholder="Email quản trị" class="form-control" value="<?php echo isset($data_email->email_admin) ? $data_email->email_admin : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Name From</label>
                                    <input type="text" name="name_from" placeholder="Name Form" class="form-control" value="<?php echo isset($data_email->name_from) ? $data_email->name_from : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label>giá 1 coin/vnđ</label>
                                    <input type="number" name="coin_price" class="form-control" value="<?php echo isset($data_email->coin_price) ? $data_email->coin_price : 0; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Thưởng link ref(coin)</label>
                                    <input type="number" name="coin_ref" class="form-control" value="<?php echo isset($data_email->coin_ref) ? $data_email->coin_ref : 0; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Thưởng đơn hàng ref(%)</label>
                                    <input type="number" name="coin_order" class="form-control" value="<?php echo isset($data_email->coin_order) ? $data_email->coin_order : 0; ?>">
                                </div>
                                <div class="form-group">
                                    <label>giới hạn rút coin (min:500coin)</label>
                                    <input type="number" name="limit_withdraw" class="form-control" value="<?php echo isset($data_email->limit_withdraw) ? $data_email->limit_withdraw : 0; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Cấp độ thưởng(1 hoặc 2 or 3)</label>
                                    <div class="m-input">
                                        <select class="form-control m-input m-input--square" name="level_ref">
                                            <option value="1" <?php echo $data_email->level_ref ==1 ? "selected" : ""; ?>>ref user cha 1 cấp,order mới chính nó</option>
                                            <option value="2" <?php echo $data_email->level_ref ==2 ? "selected" : ""; ?> >ref user cha 2 cấp, order mới chính nó</option>
                                            <option value="3" <?php echo $data_email->level_ref ==3 ? "selected" : ""; ?>>ref user cha 2 cấp, order mới chính nó và cha 1 cấp</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="tab_home" role="tabpanel">
                            <div class="tab-content">
                                <form action="" id="data_home">
                                    <input type="hidden" value="data_home" name="key_setting">
                                    
                                    <div class="form-group">
                                        <h3>POPUP thông báo</h3>
                                        <label>Tiêu đề</label>
                                        <input name="intro_title" class="form-control" value="<?php echo isset($data_home->intro_title) ? $data_home->intro_title : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>POPUP nội dung</label>
                                        <textarea name="intro_content" class="form-control summernote"><?php echo !empty($data_home->intro_content) ? $data_home->intro_content : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="thumbnail">background popup 800x600</label>
                                        <div class="input-group m-input-group m-input-group--air">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-picture-o"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="popup_img" value="<?php echo !empty($data_home->popup_img) ? $data_home->popup_img : '' ?>" onclick="FUNC.chooseImage(this)" class="form-control m-input chooseImage" placeholder="Click để chọn ảnh">
                                        </div>
                                        <div class="alert m-alert m-alert--default preview text-center mt-1" role="alert">
                                            <img height="70" src="<?php echo !empty($data_home->popup_img) ? getImageThumb($data_home->popup_img,100,100) : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="thumbnail">banner trái</label>
                                        <div class="input-group m-input-group m-input-group--air">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-picture-o"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="intro_img" value="<?php echo !empty($data_home->intro_img) ? $data_home->intro_img : '' ?>" onclick="FUNC.chooseImage(this)" class="form-control m-input chooseImage" placeholder="Click để chọn ảnh">
                                        </div>
                                        <div class="alert m-alert m-alert--default preview text-center mt-1" role="alert">
                                            <img height="70" src="<?php echo !empty($data_home->intro_img) ? getImageThumb($data_home->intro_img,100,100) : '' ?>">
                                        </div>
                                        <label>link banner</label>
                                        <input name="linkintro_img" class="form-control" value="<?php echo isset($data_home->linkintro_img) ? $data_home->linkintro_img : ''; ?>" placeholder="https://www.youtube.com/embed/GlnQIgCT1e4">
                                    </div>
                                    <div class="form-group">
                                        <label for="thumbnail">banner ngang</label>
                                        <div class="input-group m-input-group m-input-group--air">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-picture-o"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="intro_img1" value="<?php echo !empty($data_home->intro_img1) ? $data_home->intro_img1 : '' ?>" onclick="FUNC.chooseImage(this)" class="form-control m-input chooseImage" placeholder="Click để chọn ảnh">
                                        </div>
                                        <div class="alert m-alert m-alert--default preview text-center mt-1" role="alert">
                                            <img height="70" src="<?php echo !empty($data_home->intro_img1) ? getImageThumb($data_home->intro_img1,100,100) : '' ?>">
                                        </div>
                                        <label>link banner</label>
                                        <input name="linkintro_img1" class="form-control" value="<?php echo isset($data_home->linkintro_img1) ? $data_home->linkintro_img1 : ''; ?>" placeholder="https://www.youtube.com/embed/GlnQIgCT1e4">
                                    </div>
                                    
                                    <div class="form-group">
                                        <h3>Về chúng tôi</h3>
                                        <label>Video youtube 1</label>
                                        <input name="videoyt1" class="form-control" value="<?php echo isset($data_home->videoyt1) ? $data_home->videoyt1 : ''; ?>" placeholder="https://www.youtube.com/embed/GlnQIgCT1e4">
                                    </div>
                                    <div class="form-group">
                                        <label>Video youtube 2</label>
                                        <input name="videoyt2" class="form-control" value="<?php echo isset($data_home->videoyt2) ? $data_home->videoyt2 : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Video youtube 3</label>
                                        <input name="videoyt3" class="form-control" value="<?php echo isset($data_home->videoyt3) ? $data_home->videoyt3 : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Video youtube 4</label>
                                        <input name="videoyt4" class="form-control" value="<?php echo isset($data_home->videoyt4) ? $data_home->videoyt4 : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Video youtube 5</label>
                                        <input name="videoyt5" class="form-control" value="<?php echo isset($data_home->videoyt5) ? $data_home->videoyt5 : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <h3>CÀI ĐẶT KHÁC</h3>
                                        <label>15 quy trình test product laptop</label>
                                        <textarea name="footer1" class="form-control summernote"><?php echo !empty($data_home->footer1) ? $data_home->footer1 : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>footer2 product laptop</label>
                                        <textarea name="footer2" class="form-control summernote"><?php echo !empty($data_home->footer2) ? $data_home->footer2 : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>footer3 (product laptop)</label>
                                        <textarea name="footer3" class="form-control summernote"><?php echo !empty($data_home->footer3) ? $data_home->footer3 : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Số tài khoản ngân hàng</label>
                                        <textarea name="banknumber" class="form-control summernote"><?php echo !empty($data_home->banknumber) ? $data_home->banknumber : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Phí ship</label>
                                        <input type="number" name="shipprice" class="form-control" value="<?php echo isset($data_home->shipprice) ? $data_home->shipprice : 0; ?>">
                                    </div>
                                    
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var url_update_setting = '<?php echo site_url('admin/setting/update_setting')?>';
</script>