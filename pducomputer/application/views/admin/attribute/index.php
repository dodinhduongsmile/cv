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
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Tiêu đề</label>
                                        <input name="title" placeholder="Tiêu đề" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>Đường dẫn</label>
                                        <input name="slugattr" placeholder="Link" class="form-control slugattr" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>kiểu thuộc tính để sau gọi ra lọc (vd:product cate)</label>
                                        <!-- <input name="type_img" placeholder="kiểu thuộc tính" class="form-control" type="text" value="attribue_laptop" readonly="readonly" /> -->
                                        <select name="type_img" id="type_img" class="form-control">
                                            <option value="">-Chọn thuộc tính-</option>
                                            <option value="attribute_laptop" selected="selected">Cho laptop,pc</option>
                                            <option value="attribute_phukien">Cho phụ kiện</option>
                                            <option value="attribute_mobile">Cho mobile</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Danh mục cha:</label>
                                        <div class="input-group">
                                            <select name="parent_id" class="form-control m-select2 category" style="width: 100%;">
                                                
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
                                        <label>giá trị thuộc tính</label>
                                        <div class="box_value_all">
                                            <div class="itemtt box_value" style="display: flex;">
                                                <input name="key[]" placeholder="Tên thuộc tính" class="form-control keyattr" type="text" value="" /><br>
                                                <input name="content[]" placeholder="giá trị thuộc tính" class="form-control valueattr" type="text" value="" />
                                                <div class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn_delete">
                                                    <span>
                                                        <i class="la la-trash-o"></i>
                                                        <span>
                                                            Delete
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="m-form__group form-group row" id="add_field">
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
    var url_ajax_load_category = '<?php echo site_admin_url('attribute/ajax_load') ?>';
</script>
<style>.box_value{padding-bottom: 10px;}</style>