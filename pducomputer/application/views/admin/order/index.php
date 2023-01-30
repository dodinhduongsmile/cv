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
                                            <option value="1">
                                                chờ xác nhận
                                            </option>
                                            <option value="2">
                                                đã xác nhận
                                            </option>
                                            <option value="3">
                                                đã giao
                                            </option>
                                            <option value="4">
                                                hoàn trả
                                            </option>
                                            <option value="0">
                                                hủy đơn
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
                        <?php echo button_admin(['delete']) ?>
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
                            <!-- thong tin don hang -->
                            <div class="row">
                                <div class="col-xl-5">
                                    <div class="m-portlet div_order_content m-portlet--bordered-semi m-portlet--full-height ">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                        Thông tin khách hàng
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="m-portlet__body">
                                            <div class="m-widget4">
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Họ Và Tên :
                                                        </span>
                                                        <span class="m-widget4__title" id="full_name"></span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Email :
                                                        </span>
                                                        <span class="m-widget4__title" id="email"></span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Số điện thoại :
                                                        </span>
                                                        <span class="m-widget4__title" id="phone"></span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Số điện thoại khác :
                                                        </span>
                                                        <span class="m-widget4__title" id="another_phone"></span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Địa chỉ :
                                                        </span>
                                                        <span class="m-widget4__title" id="address"></span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Trạng thái đơn hàng :
                                                        </span>
                                                        <span class="m-widget4__title">
                                                            <span class="m-badge m-badge--is_status">
                                                                <select class="form-control m-input m-input--square position" name="is_status">
                                                                    <option value="0">Huỷ đơn</option>
                                                                    <option value="1">Chờ xác nhận</option>
                                                                    <option value="2">Đã xác nhận (đang vận chuyển)</option>
                                                                    <option value="3">Đã giao</option>
                                                                    <option value="4">Hoàn trả</option>
                                                                </select>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Trạng thái thanh toán :
                                                        </span>
                                                        <span class="m-widget4__title">
                                                            <span class="m-badge m-badge--is_status">
                                                                <select class="form-control m-input m-input--square position" name="pay_status">
                                                                    <option value="0">Huỷ đơn</option>
                                                                    <option value="1">Chưa thanh toán</option>
                                                                    <option value="2">Đã thanh toán</option>
                                                                    <option value="3">Hoàn trả</option>
                                                                </select>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Hình thức thanh toán :
                                                        </span>
                                                        <span class="m-widget4__title">
                                                            <span class="m-badge m-badge--is_status">
                                                            <select class="form-control m-input m-input--square" name="method">
                                                                    <option value="1">COD</option>
                                                                    <option value="2">Banking</option>
                                                                    <option value="3">COIN</option>
                                                            </select>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Ghi chú của khách</label>
                                                    <textarea name="content" placeholder="Ghi chú của khách" class="form-control noteorder" type="text"></textarea>
                                                </div>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__sub">
                                                            Ngày mua hàng :
                                                        </span>
                                                        <span class="m-widget4__title" id="created_time"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-7">
                                    <div class="m-portlet div_order_content m-portlet--full-height ">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                        Thông tin đơn hàng
                                                    </h3>
                                                </div>
                                            </div>
                                            
                                            <div class="m-portlet__head-tools">
                                                <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget5_tab1_content" role="tab">
                                                            Tổng tiền đơn hàng : <span id="total_amount"></span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_info" role="tab" aria-selected="false">
                                                             Lịch sử đơn hàng.
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_print" role="tab" aria-selected="false">
                                                             In đơn hàng.
                                                        </a>
                                                    </li>
                                                     
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
                                                    <div class="m-widget5" id="order_detail">
                                                        
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_info" role="tabpanel">
                                                    <div class="form-group">
                                                        <label>Lịch trình đơn hàng</label>
                                                        <div class="box_value_all">
                                                            <div class="itemtt box_value" style="display: flex;">
                                                                
                                                                <input name="note[]" placeholder="lịch trình" class="form-control" type="text" value="" />
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
                                                    <div class="form-group">
                                                        <label>Đơn vị vận chuyển:</label>
                                                        <select class="form-control m-input m-input--square position" name="shipping">
                                                    <?php $this->config->load('menus');
                                                     if (!empty($this->config->item('shipping'))) foreach ($this->config->item('shipping') as $key => $value): ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                    <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="tab_print" role="tabpanel">
                                                    <div id="order_print">
                                                        
                                                    </div>
                                                    <button type="button" onclick="In_Content('printable')" class="btn btn-primary btn-print">print(in)</button>
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- thong tin don hang -->
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
    
</script>