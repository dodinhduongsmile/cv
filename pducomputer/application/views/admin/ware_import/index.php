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
                        <p>tìm sp rồi edit số lượng, nếu kho khác thì mới add</p>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <?php echo button_admin(['add','delete']) ?>
                        <!-- <a href="<?php //echo site_admin_url()."Product_trash" ?>" class="btn btn-primary">thùng rác</a> -->
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
                <input type="hidden" name="edit" value="">
                <div class="m-portlet--tabs">
                    
                    <div class="m-portlet__body">
                        <div class="tab-content">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        
                                        <div class="form-group pdusoft">
                                            <label>Mã sản phẩm:</label>
                                            <input type="text" name="code" placeholder="Mã sản phẩm" class="form-control searchproductpdu">
                                            <ul class="showproduct">
                                                
                                                
                                            </ul>
                                            <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                            <div class="showform" style="display: none;">
                                                
                                                <textarea name="description"></textarea>
                                                <textarea name="content"></textarea>
                                                 <input name="meta_title" type="text" />
                                                 <input name="slug" type="text" />
                                                 <textarea name="meta_description" ></textarea>
                                                 <input value="" name="meta_keyword"/>
                                                 <input type="text" name="category_id"/>
                                                 
                                                 
                                                 <input type="text" name="quality"/>
                                                 <input type="text" name="is_status"/>
                                                 <input type="text" name="product_type_id"/>
                                                 
                                                 <input type="text" name="size"/>
                                                 <input type="text" name="mass"/>
                                                 <input type="text" name="guarantee"/>
                                                 <input type="text" name="thumbnail"/>
                                                 <input type="text" name="album"/>
                                            </div>
                                        </div>
                                        <div class="form-group viewonly">
                                            <label>tên sản phẩm:</label>
                                            <input name="title" placeholder="tên sản phẩm " class="form-control" type="text"/>
                                            <label>giá bán:</label>
                                            <input type="text" name="price" placeholder="giá bán: " class="form-control" disabled="disabled" />
                                            <label>giá nhập:</label>
                                            <input type="text" name="price_sale" placeholder="giá nhập " class="form-control" disabled="disabled"/>
                                            <label>ID nhà cung cấp:</label>
                                            <input type="text" name="warehouse" placeholder="ID nhà cung cấp " class="form-control" disabled="disabled"/>
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
                                        </div>
                                              
                                        <div class="form-group">
                                            <label>số lượng:</label>
                                            <input type="number" name="countware" placeholder="số lượng nhập" class="form-control number">
                                        </div>
                                        <div class="form-group">
                                            <label>Kho chứa:</label>
                                            <div class="input-group">
                                                <select name="khochua" class="form-control m-select2 khochua" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Ghi chú / Lí do sửa</label>
                                            <textarea name="noteware" placeholder="Ghi chú / Lí do sửa " class="form-control" rows="5"></textarea>
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
<style>
ul.showproduct {
    max-height: 300px;
    overflow-x: auto;
}
    .showproduct li.search_item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    border-bottom: 1px solid #e2dcdc;
    margin-bottom: 10px;
    transition: all ease 0.5s;
}
.showproduct li.search_item:hover {
background: #e2dcdc;
cursor: pointer;
}
.showproduct li.search_item img {
    width: 100px;
    height: 100px;
    object-fit: contain;
}

.showproduct li.search_item div {
    padding: 0 10px;
}

.showproduct li.search_item h3 {
    font-size: 17px;
    text-transform: capitalize;
}</style>
<script type="text/javascript">
    // load danh mục và type cho product
    var url_ajax_load_product = '<?php echo site_admin_url('product/ajax_load2') ?>',
    url_ajax_load_product3 = '<?php echo site_admin_url('product/ajax_load3') ?>',
    url_ajax_load_khochua = '<?php echo site_admin_url('store/ajax_load') ?>';
</script>