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
                                        <label>User:</label>
                                        <input name="user_id" placeholder="user" class="form-control user_id" type="text" readonly="readonly" />
                                    </div>
                                    <div class="form-group">
                                        <label>Số lượng coin</label>
                                        <input name="amount" placeholder="Số coin rút" class="form-control" type="text" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Kiểu giao dịch</label>
                                        <div class="m-input">
                                            <select class="form-control m-input m-input--square" name="type">
                                                <option value="1" selected="selected">rút coin</option>
                                                <option value="2">nạp coin</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>trạng thái</label>
                                        <div class="m-input">
                                            <select class="form-control m-input m-input--square" name="is_status">
                                                <option value="1" selected="selected">chờ duyệt</option>
                                                <option value="2">thành công</option>
                                                <option value="0">Hủy</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <textarea name="note" placeholder="Nội dung" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__sub">
                                                Ngày yêu cầu :
                                            </span>
                                            <span class="m-widget4__title" id="created_time"></span>
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
    var url_ajax_load_user = '<?php echo site_admin_url('user/ajax_load') ?>';
</script>