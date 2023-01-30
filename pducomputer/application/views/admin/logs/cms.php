<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    
                </div>
            </div>
            <style>
                .w70{
                    width: 70px;
                }
                .le{
                    background: #f4f4f4;
                }
            </style>
            <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded" id="ajax_data" style="">
                <table class="m-datatable__table" style="display: block; min-height: 300px; overflow-x: auto;">
                    <thead class="m-datatable__head">
                        <tr class="m-datatable__row" style="left: 0px;">
                            <td class="w70 m-datatable__cell--center m-datatable__cell m-datatable__cell--sort" data-sort="asc">
                                Stt
                            </td>
                            <td data-field="title" class="m-datatable__cell m-datatable__cell--sort">Lỗi</td>
                        </tr>
                    </thead>
                    <tbody class="m-datatable__body" style="">
                        <?php 
                        $i=0;
                        if (!empty($logs)) foreach ($logs as $key => $value) : ?>
                            <?php if (!empty($value)): $i++;?>
                                <tr class="m-datatable__row <?php echo $i%2 ? 'chan' : 'le' ?>">
                                    <td class="w70 m-datatable__cell--sorted m-datatable__cell--center m-datatable__cell">
                                        <span><?php echo $i; ?></span>
                                    </td>
                                    <td data-field="title" class="m-datatable__cell">
                                        <span><?php echo $value; ?></span>
                                    </td>
                                </tr>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

