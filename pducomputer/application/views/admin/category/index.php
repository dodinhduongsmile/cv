<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

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
                                <div class="d-md-none m--margin-bottom-10"></div>
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
                                        <i class="la la-language"></i>
                                        Nội dung SEO
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_info" role="tab" aria-selected="false">
                                        <i class="la la-info"></i>
                                        Thông tin
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
                                            <input name="title" placeholder="Tiêu đề" class="form-control" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Tóm tắt</label>
                                            <textarea name="content" placeholder="Tóm tắt" class="form-control tinymce" rows="5"></textarea>
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
                                            <label>Danh mục cha:</label>
                                            <div class="input-group">
                                                <select name="parent_id" class="form-control m-select2 category" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>kiểu layout để hiển thị cate(product)</label>
                                            <select name="layoutview" id="type_img" class="form-control">
                                                <option value="">-Chọn layout view-</option>
                                                <option value="laptop" selected="selected">Cho laptop,pc</option>
                                                <option value="phukien">Cho phụ kiện</option>
                                                <option value="mobile">Cho mobile</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Chọn thuộc tính lọc ở buildpc,và danh mục lẻ như ram,hdd(product)vd:vào danh mục cpu chỉ load các thuộc tính của cpu</label>
                                            <select name="layout" class="form-control m-select2 layoutattr" style="width: 100%;">
                                            
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>
                                                Trạng thái:
                                            </label>
                                            <div class="m-input">
                                                <input data-switch="true" type="checkbox" name="is_status" class="switchBootstrap" checked="checked">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-12">
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
    var url_ajax_load_category = '<?php echo site_admin_url('category/ajax_load/'.$this->_method) ?>';
    var url_ajax_load_categoryAttr = '<?php echo site_admin_url('attribute/ajax_load2') ?>';
</script>