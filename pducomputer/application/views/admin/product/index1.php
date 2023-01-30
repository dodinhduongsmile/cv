<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <div class="m-input">
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" name="is_status">
                                            <option value="">
                                                Tất cả
                                            </option>
                                            <option value="1">
                                                Đã xuất bản
                                            </option>
                                            <option value="0">
                                                Chưa xuất bản
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <?php echo button_admin(['add','delete']) ?>
                        <a href="<?php echo site_admin_url()."product_trash" ?>" class="btn btn-primary">thùng rác</a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="m_datatable" id="ajax_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="formModalLabel">Form</h3>
            </div>
            <div class="modal-body">
                <?php echo form_open('',['id'=>'','class'=>'m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state']) ?>
                <input type="hidden" name="id" value="0">
                <div class="m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#tab_language" role="tab" aria-selected="true">
                                        <i class="la la-language"></i>Nội dung SEO
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_info" role="tab" aria-selected="false">
                                        <i class="la la-info"></i>Thông tin
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_attr" role="tab" aria-selected="false">
                                        <i class="la la-info"></i>Thuộc tính
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab_language" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Tiêu đề</label>
                                            <input name="title" placeholder="Tiêu đề " class="form-control" type="text" />
                                            <i>tên sản phẩm, chi tiết cpu, dung lượng ram, loại ổ cứng + dung lượng ổ cứng, độ rộng màn hình, chi tiết vga</i>
                                        </div>
                                        <div class="form-group">
                                            <label>link crawler</label>
                                            <input name="crawler_href" placeholder="link crawler " class="form-control" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Tóm tắt</label>
                                            <textarea name="description" placeholder="Tóm tắt " class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Nội dung</label>
                                            <textarea name="content" class="form-control tinymce"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <?php $this->load->view($this->template_path.'_block/seo_meta') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab_info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Danh mục:</label>
                                            <!-- nếu chọn 1 danh mục thì bỏ multiple và [], chỉnh js bật allowClear và multiple -->
                                            <div class="input-group">
                                                <select name="category_id[]" class="form-control m-select2 category" style="width: 100%;" multiple="multiple"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>màu:</label>
                                            <div class="input-group">
                                                <select name="color[]" class="form-control m-select2 color" multiple="multiple" style="width: 100%;"></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Mã sản phẩm:</label>
                                            <input type="text" name="code" placeholder="Mã sản phẩm" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Giá gốc:</label>
                                            <input type="text" name="price" placeholder="Giá gốc" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Giá khuyến mại:</label>
                                            <input type="text" name="price_sale" placeholder="Giá khuyến mại" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Số lượng</label>
                                            <div class="m-input">
                                                <select class="form-control m-input m-input--square position" name="quality">
                                                    <option value="1" selected="selected">Còn hàng</option>
                                                    <option value="0">Hết hàng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tình trạng</label>
                                            <div class="m-input">
                                                <select class="form-control m-input m-input--square position" name="newlike">
                                                    <option value="0" selected="selected">đã qua sử dụng</option>
                                                    <option value="1">mới 100%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>KIỂU LAYOUT*</label>
                                            <div class="m-input">
                                                <select class="form-control m-input m-input--square position" name="layout" id="layout">
                                                    <option>-chọn layout-</option>
                                                    <option value="laptop">laptop,pc</option>
                                                    <option value="phukien">Phụ kiện</option>
                                                    <option value="mobile">mobile</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng thái:</label>
                                            <div class="m-input">
                                                <input data-switch="true" type="checkbox" name="is_status" class="switchBootstrap" checked="checked">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Hãng sản xuất:</label>
                                            <div class="input-group">
                                                <select name="product_type_id" class="form-control m-select2 product_type" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nhà cung cấp:</label>
                                            <div class="input-group">
                                                <select name="warehouse" class="form-control m-select2 warehouse1" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Kho chứa:</label>
                                            <input type="text" name="khochua" placeholder="Kho chứa" class="form-control" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label>Kích thước:</label>
                                            <input type="text" name="size" placeholder="Kích thước" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Video giới thiệu:</label>
                                            <input type="text" name="video" placeholder="Video giới thiệu" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Bảo hành:</label>
                                            <input type="text" name="guarantee" placeholder="Bảo hành" class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="thumbnail">Ảnh đại diện</label>
                                            <div class="input-group m-input-group m-input-group--air">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="input_thumbnail">
                                                        <i class="la la-picture-o"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="thumbnail" onclick="FUNC.chooseImage(this)" class="form-control m-input chooseImage" placeholder="Click để chọn ảnh" aria-describedby="input_thumbnail">
                                            </div>
                                            <div class="alert m-alert m-alert--default preview text-center mt-1" role="alert">
                                                <img width="100" height="100" src="<?php echo getImageThumb('',100,100) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <fieldset class="form-group album-contain">
                                                <legend>Album ảnh</legend>
                                                <div data-id="0" id="gallery"></div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-primary btnAddMore"
                                                    onclick="FUNC.chooseMultipleMedia('gallery')">
                                                    <i class="fa fa-plus"> Thêm</i>
                                                </button>
                                            </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_attr" role="tabpanel">
                                <!-- attribue -->
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSave">Submit</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // load danh mục và type cho product
    var url_ajax_load_category = '<?php echo site_admin_url('category/ajax_load/product') ?>',
        url_ajax_load_product_type = '<?php echo site_admin_url('product_type/ajax_load') ?>',
        url_ajax_load_warehouse1 = '<?php echo site_admin_url('Warehouse_1/ajax_load') ?>',
        url_ajax_load_color = '<?php echo site_admin_url('product/ajax_color') ?>';
</script>