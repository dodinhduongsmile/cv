<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-sm-7 col-xs-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="form-group">
                                <select id="menu_locations" class="form-control">
                                    <!-- load menu từ config -->
                                    <?php if (!empty($this->config->item('cms_menu'))) foreach ($this->config->item('cms_menu') as $lang => $name): ?>
                                        <option value="<?php echo $lang ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button class="btn btn-primary btnShowMenu">Show Menu <i class="fa fa-spinner fa-spin" style="display: none"></i> </button>
                        </div>
                    </div>

                    <div id="listContent" class="mt-3"></div>
                </div>
                <div class="col-sm-5 col-xs-12">
                    <menu id="nestable-menu" class="text-center">
                        <button class="btn btn-primary btnSaveMenu" type="button">Save Menu</button>
                        <button class="btn btn-info" type="button" data-action="expand-all">Expand All</button>
                        <button class="btn btn-danger" type="button" data-action="collapse-all">Collapse All</button>
                    </menu>
                    <label id="output-menu" class="label label-info"></label>
                    <div class="dd col-12" id="nestable">
                        <ol class="dd-list"></ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var url_ajax_load = '<?php echo site_admin_url('menus/ajax_load') ?>';
    var url_ajax_load_menu = '<?php echo site_admin_url('menus/ajax_load_menu') ?>';
    var url_ajax_save_menu = '<?php echo site_admin_url('menus/ajax_save_menu') ?>';
</script>
