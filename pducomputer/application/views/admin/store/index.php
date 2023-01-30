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
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Tiêu đề</label>
                                        <input name="title" placeholder="Tên" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>email</label>
                                        <input name="email" placeholder="email" class="form-control" type="email" />
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <textarea name="address" placeholder="Địa chỉ" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>kiểu store</label>
                                        <input name="type_img" placeholder="showroom" class="form-control" type="text" value="store" readonly="readonly" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <input name="phone" placeholder="Số điện thoại" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>Người phụ trách</label>
                                        <input name="curator" placeholder="Người phụ trách" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <textarea name="description" placeholder="Ghi chú" class="form-control" rows="5"></textarea>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Khu vực</label>
                                        <div class="m-input">
                                            <select class="form-control m-input m-input--square position" name="city_id">
                                                <option value="1" selected="selected">Hà nội</option>
                                                <option value="3">TP.Đà nẵng</option>
                                                <option value="2">TP.Hồ Chí Minh</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
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
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSave">Submit</button>
            </div>
        </div>
    </div>
</div>
