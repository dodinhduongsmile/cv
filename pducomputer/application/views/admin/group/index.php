<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
$user_id = $this->session->userdata['user_id'];

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
                                                    All
                                                </option>
                                                <option value="1">
                                                    Kích hoạt
                                                </option>
                                                <option value="0">
                                                    Khóa
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

                    <?php echo form_open('', ['id' => '', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state']) ?>
                        <input type="hidden" name="id" value="0">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#tab_info" role="tab" aria-selected="true">
                                            <i class="la la-language"></i>Thông tin
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item tab_admin">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#tbl_per" role="tab" aria-selected="false">
                                            <i class="la la-info"></i>Nhóm quyền
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="m-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab_info" role="tabpanel">

                                    <div class="form-group ">
                                        <label>
                                            Tên nhóm:
                                        </label>
                                        <input type="text" name="title" class="form-control m-input" placeholder="Tên nhóm">
                                    </div>
                                    <div class="form-group ">
                                        <label>
                                            Mô tả nhóm
                                        </label>
                                        <textarea name="description" class="form-control m-input" rows="3"></textarea>
                                    </div>
                                    <div class="form-group ">
                                        <label>
                                            Active:
                                        </label>
                                        <div class="m-input">
                                            <input data-switch="true" type="checkbox" name="is_status" checked="checked">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane  " id="tbl_per" role="tabpanel">
                                    <div class="form-group">
                                        <table class="table table-hover" id="tbl_per">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center">Xem</th>
                                                    <th class="text-center">Thêm</th>
                                                    <th class="text-center">Sửa</th>
                                                    <th class="text-center">Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                    $arr_not = array('log','menus','setting');
                                                    if (!empty($controllers)):
                                                        foreach ($controllers as $controller):
                                                            $tmpName = pathinfo($controller);
                                                            $name = strtolower($tmpName['filename']);

                                                            if (in_array($name, array('dashboard', 'auth'))) {
                                                                continue;
                                                        }
                                                    ?>
                                                    <tr id="per_<?php echo $name; ?>">
                                                        <td>
                                                            <?php echo !empty($this->config->item('cms_language_role')[$name]) ? $this->config->item('cms_language_role')[$name] : ucfirst($name); ?>
                                                        </td>

                                                        <td class="text-center">
                                                            <label class="m-checkbox">
                                                                <input type="checkbox" id="per_<?php echo $name; ?>_view" name="permission[<?php echo $name; ?>][view]" value="1" />
                                                                <span></span>
                                                            </label>
                                                        </td>
                                                        <?php if (!in_array($name, $arr_not)) : ?>
                                                            <td class="text-center">
                                                                <label class="m-checkbox">
                                                                    <input type="checkbox" id="per_<?php echo $name; ?>_add" name="permission[<?php echo $name; ?>][add]" value="1" />
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <td class="text-center">
                                                                <label class="m-checkbox">
                                                                    <input type="checkbox" id="per_<?php echo $name; ?>_edit" name="permission[<?php echo $name; ?>][edit]" value="1" />
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <td class="text-center">
                                                                <label class="m-checkbox">
                                                                    <input type="checkbox" id="per_<?php echo $name; ?>_delete" name="permission[<?php echo $name; ?>][delete]" value="1" />
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <?php endif ?>
                                                    </tr>
                                                    <?php
                                                        endforeach;
                                                        endif;
                                                    ?>
                                            </tbody>
                                        </table>
                                        <a href="javascript:;" onclick="check_all_per();">Chọn tất cả</a> /
                                        <a href="javascript:;" onclick="uncheck_all_per();">Bỏ chọn</a>
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