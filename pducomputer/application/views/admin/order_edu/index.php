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
                                        <select class="form-control m-bootstrap-select select_searchpdu" name="is_status">
                                            <option value="">
                                                Tất cả
                                            </option>
                                            <option value="0">
                                                tạm khóa
                                            </option>
                                            <option value="1">
                                                chưa share drive
                                            </option>
                                            <option value="2">
                                                đã share drive
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
                        <a href="javascript:;" class="btn btn-primary m-btn m-btn--icon m-btn--air m-btn--pill btnAddForm">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Add
                                </span>
                            </span>
                        </a>
                        <a href="javascript:;" class="btn btn-info m-btn m-btn--icon m-btn--air m-btn--pill btnReload">
                            <span>
                                <i class="la la-refresh"></i>
                                <span>Refresh</span>
                            </span>
                        </a>
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
                                        <label>Email người mua :</label>
                                        <input placeholder="giá" class="form-control" id="user_email" type="text" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Tên khóa học :</label>
                                        <input placeholder="giá" class="form-control" id="edu_title" type="text" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Tổng COIN thanh toán</label>
                                        <input name="price" placeholder="giá" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>trạng thái</label>
                                        <div class="m-input">
                                            <select class="form-control m-input m-input--square" name="is_status">
                                                <option value="0">Tạm khóa</option>
                                                <option value="1" selected="selected">No Drive</option>
                                                <option value="2">Yes Drive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <textarea name="note" placeholder="Xóa sẽ trả lại COIN cho khách, nếu xóa mà không muốn trả lại COIN thì cập nhật price = 0, rồi xóa" class="form-control" rows="5"></textarea>
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