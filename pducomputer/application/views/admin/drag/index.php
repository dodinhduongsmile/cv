<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<style>
    @media only screen and (max-width: 600px) {
        .action-item{
            right: 4px;
        }
        .dd3-content{
            height: 70px;
        }
        .dd-list{
            margin-top: 50px;
        }
        .content_menu{
            height: 1000px;
        }
    }
    .input_post,textarea{
        width: 100%;
    }
    .content_top{
        height: 150px;
    }
    .dd3-handle{
        height: 100%;
    }
</style>
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <select name="" id="selectDrag" class="col-12"></select>
                    <button class="addtonavmenu btn btn-primary" style="margin-top: 20px">Thêm</button>
                </div>
                <div class="col-sm-8 col-xs-12 content_menu">
                    <button class="btn btn-primary float-right btnSaveMenu" type="button">Save</button>
                    <div class="dd col-12" id="nestableDrag">
                        <ol class="dd-list">
                            <?php if (!empty($dragInfo)) foreach ($dragInfo as $k => $value) : 
                                $dataPost = getByIdPhim($value->phim_id);
                            ?>
                                <?php if (!empty($dataPost)): ?>
                                    <li class="dd-item dd3-item" data-id="<?php echo $value->phim_id; ?>" data-type="<?php echo $value->type; ?>" >
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content <?php echo $value->type; ?>">
                                            <?php echo $dataPost->title; ?>
                                        </div>
                                        <div class="action-item"><span class="nestledeletedd fa fa-trash"></span></div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var  url_ajax_load_post = '<?php
        switch ($heading_type) {
            case "data_bet_featured":
                echo site_admin_url("drag/ajax_load");
                break;
            default: echo site_admin_url("drag/ajax_load");
        }?>',
    type = '<?php echo $heading_type ?>',
    url_ajax_load_phim = '<?php echo site_admin_url("phims/ajax_load"); ?>';
</script>
