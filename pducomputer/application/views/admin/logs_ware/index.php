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
            <div class="m_datatable" id="ajax_data"></div>
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
                <input type="hidden" name="idcu" value="0">
                <div class="m-portlet--tabs">
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    DATA MỚI
                                    <div class="form-group viewonly">
                                            <label>tên sản phẩm:</label>
                                            <input name="title" placeholder="tên sản phẩm " class="form-control" type="text"/>
                                            <label>giá bán:</label>
                                            <input type="text" name="price" placeholder="giá bán: " class="form-control" disabled="disabled" />
                                            <label>giá nhập:</label>
                                            <input type="text" name="price_sale" placeholder="giá nhập " class="form-control" disabled="disabled"/>
                                            <label>ID nhà cung cấp:</label>
                                            <input type="text" name="warehouse" placeholder="ID nhà cung cấp " class="form-control" disabled="disabled"/>
                                            
                                        
                                              
                                        <div class="form-group">
                                            <label>số lượng:</label>
                                            <input type="number" name="countware" placeholder="số lượng nhập" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Kho chứa:</label>
                                            <input type="number" name="khochua" placeholder="số lượng nhập" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Ghi chú / Lí do sửa</label>
                                            <textarea name="noteware" placeholder="Ghi chú / Lí do sửa " class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    </div>
                                <div class="col-sm-6 col-xs-12">
                                    DATA CŨ
                                    <div class="form-group viewonly">
                                            <label>tên sản phẩm:</label>
                                            <input name="titlecu" placeholder="tên sản phẩm " class="form-control" type="text"/>
                                            <label>giá bán:</label>
                                            <input type="text" name="pricecu" placeholder="giá bán: " class="form-control" disabled="disabled" />
                                            <label>giá nhập:</label>
                                            <input type="text" name="price_salecu" placeholder="giá nhập " class="form-control" disabled="disabled"/>
                                            <label>ID nhà cung cấp:</label>
                                            <input type="text" name="warehousecu" placeholder="ID nhà cung cấp " class="form-control" disabled="disabled"/>
                                            
                                        
                                              
                                        <div class="form-group">
                                            <label>số lượng:</label>
                                            <input type="number" name="countwarecu" placeholder="số lượng nhập" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Kho chứa:</label>
                                            <input type="number" name="khochuacu" placeholder="số lượng nhập" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Ghi chú / Lí do sửa</label>
                                            <textarea name="notewarecu" placeholder="Ghi chú / Lí do sửa " class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                                                .tab-content label {
                                                    color: #000;
                                                    font-weight: bold;
                                                }
                                                .form-group.viewonly input {
                                                    background: #aba3a3;
                                                    }.form-group.viewonly {
                                                        border: 3px double #dc0303;
                                                    }
                                                    .form-group.viewonly:hover{
                                                        cursor: no-drop;
                                                    }
                                                    .form-group.viewonly input::placeholder{
                                                        color:#fff;
                                                    }
                                                    .form-group.viewonly input {
                                                        cursor: no-drop;
                                                        pointer-events: none;
                                                    }</style> 
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn btn-primary btnSave">Submit</button> -->
            </div>
        </div>
    </div>
</div>