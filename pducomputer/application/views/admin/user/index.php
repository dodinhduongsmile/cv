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
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                            Trạng thái:
                                        </label>
                                    </div>
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
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label class="m-label m-label--single">
                                            Nhóm:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <select data-placeholder="Tất cả" class="form-control m-bootstrap-select" data-multiple="false" name="filter_group_id"></select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-4">
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
                        <a href="javascript:;" class="btn btn-danger m-btn m-btn--icon m-btn--air m-btn--pill btnDeleteAll">
                            <span>
                                <i class="la la-remove"></i>
                                <span>
                                    Delete
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
                <input type="hidden" name="lever" value="1">
                <input type="hidden" name="active" value="1">
                
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>
                                Full Name:
                            </label>
                            <input type="text" name="fullname" class="form-control m-input" placeholder="Full name">
                        </div>
                        <div class="col-lg-6">
                            <label>
                                Phone:
                            </label>
                            <div class="input-group m-input-group m-input-group--square">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="la la-phone"></i>
                                    </span>
                                </div>
                                <input type="tel" name="phone" class="form-control m-input" placeholder="Phone">
                            </div>

                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>
                                Email:
                            </label>
                            <div class="input-group m-input-group m-input-group--square">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="la la-envelope"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" class="form-control m-input" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label>
                                Username:
                            </label>
                            <div class="input-group m-input-group m-input-group--square">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="la la-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="username" class="form-control m-input" placeholder="Username">
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>
                                Password:
                            </label>
                            <input type="password" name="password" class="form-control m-input">
                        </div>
                        <div class="col-lg-6">
                            <label>
                                Re-Password:
                            </label>
                            <input type="password" name="re-password" class="form-control m-input">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        
                        <div class="col-lg-6">
                            <label>Trạng thái:</label>
                            <div class="m-input">
                                <input data-switch="true" type="checkbox" name="is_status" class="switchBootstrap" checked="checked">
                            </div>
                            
                        </div>
                        <div class="col-lg-6">
                            <label>
                                Group:
                            </label>
                            <div class="input-group">
                                <select name="group_id" class="form-control m-select2" style="width: 100%;"></select>
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
    var url_ajax_load_group = '<?php echo site_admin_url('group/ajax_load') ?>';
</script>