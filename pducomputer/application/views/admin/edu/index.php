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
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_video" role="tab" aria-selected="false">
                                        <i class="la la-info"></i>Video DRIVE
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_videoyt" role="tab" aria-selected="false">
                                        <i class="la la-info"></i>Video youtube
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
                                            <div class="input-group">
                                                <select name="category_id[]" class="form-control m-select2 category" style="width: 100%;" multiple="multiple"></select>
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
                                            <label>Video giới thiệu:</label>
                                            <input type="text" name="video" placeholder="Video giới thiệu" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>giáo viên:</label>
                                            <input type="text" name="teacher" placeholder="giáo viên" class="form-control">
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Miễn phí?</label>
                                            <div class="m-input">
                                                <select class="form-control m-input m-input--square" name="is_free">
                                                    <option value="1" selected="selected">Miễn phí</option>
                                                    <option value="0">Trả phí</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng thái:</label>
                                            <div class="m-input">
                                                <input data-switch="true" type="checkbox" name="is_status" class="switchBootstrap" checked="checked">
                                            </div>
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
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_video" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 col-12">

                                        <div class="form-group listdrive">
                                            <label>LIST DRIVE</label>
                                        <div class="box_value_alll">
                                            <!-- form-repeater -->
                                            <div class="grouppdu col-lg-12 col-12">
                                                <button type="button" class="btn btn-outline-success btn-block classify-group" id="add_group"> <i class="la la-plus"></i> Thêm nhóm phân loại</button>
                                                <div class="list_itemgroup">
                                                    <!-- list item group -->
                                                </div>
                                                
                                                <input type="hidden" name="listdrive" value="" id="listdrive">
                                            </div>
                                        <!-- form-repeater -->                                         
                                        </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- tab youtube -->
                            <div class="tab-pane" id="tab_videoyt" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group listyoutube">
                                            <label>LIST YOUTUBE</label>
                                            <div class="box_value_all">
                                                <!-- item box_value -->
                                                <div class="itemtt box_value">
                                                    <label>item</label>
                                                    <input name="listyoutube[name][]" placeholder="Tên video" class="form-control" type="text" value="" />
                                                    <input name="listyoutube[id][]" placeholder="id video" class="form-control" type="text" value="" />
                                                    <input name="listyoutube[link][]" placeholder="link video" class="form-control" type="text" value="" />
                                                    <input name="listyoutube[time][]" placeholder="time video" class="form-control" type="text" value="" />
                                                    <div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_deleteyt">
                                                        <span>
                                                            <i class="la la-trash-o"></i>
                                                            <span>
                                                                Delete
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="m-form__group form-group row add_field">
                                                <div class="col-lg-4">
                                                    <div class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                                        <span>
                                                            <i class="la la-plus"></i>
                                                            <span>
                                                                Add
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
    var url_ajax_load_category = '<?php echo site_admin_url('category/ajax_load/edu') ?>';
</script>
<style>.box_value{padding-bottom: 10px;}</style>