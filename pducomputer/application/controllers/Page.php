<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Public_Controller
{
    protected $_page;
    protected $_product;
    protected $_key_bao_gia;


    public function __construct() {
        parent::__construct();
        
        $this->load->model(['page_model','product_model']);
        
        $this->_page         = new Page_model();
        $this->_product      = new Product_model();

    }

    public function index($slug)
    {
        
        $data['oneItem'] = $oneItem = $this->_page->getByField('slug',$slug);
        if (empty($oneItem)) show_404();
        if(!empty($oneItem->slug_redirect)){
            //slug_redirect cài ở router
            header('Location: '.base_url().$oneItem->slug_redirect.$oneItem->slug.".html");
            exit;
        }
        // $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($oneItem->title, base_url().$oneItem->slug.".html");
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['data'] = [];
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_page($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $layoutView = '';
        if (!empty($oneItem->layout)) $layoutView = '-' . $oneItem->layout;
        $data['main_content'] = $this->load->view($this->template_path . 'page/index' . $layoutView, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    //khuyen-mai.html
    public function sale_voucher($slug=""){
        $this->load->model('Codesale_model');
        $this->_codesale = new Codesale_model();
        $data['limit'] = $limit = 10;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;

        if(isset($_POST['offset'])){
            //ajax
            $data['list_codesale'] = $this->_codesale->get_datapdu('',["is_status"=>1],$limit,$offset,'');

            $html  = $this->load->view($this->template_path . 'user/load_voucher', $data, TRUE);
            
            $data_mess = [
                'html' => $html,
                'limit' => $limit
            ];
            die(json_encode($data_mess));
        }else{
            //load trang
            $data['oneItem'] = $oneItem = $this->_page->getByField('slug',$slug);

            if (empty($oneItem)) show_404();
            $this->breadcrumbs->push($oneItem->title, get_url_category_codesale($oneItem));
            $data['breadcrumb'] = $this->breadcrumbs->show();
            
            $data['list_codesale'] = $this->_codesale->get_datapdu('',["is_status"=>1],$limit,$offset,'');

            $data['SEO'] = [
                'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
                'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
                'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
                'url' => base_url($oneItem->slug.".html"),
                'is_robot' => 1,
                'image' => getImageThumb($oneItem->thumbnail, 600, 314),
            ];
            $data['main_content'] = $this->load->view($this->template_path . 'page/index-khuyenmai', $data, TRUE);
            $this->load->view($this->template_main, $data);
        }
        
    }
    public function print_bao_gia()
    {
        $data['vat'] = !empty($this->input->get('vat')) ? $this->input->get('vat') : '';
        if (!empty($this->session->userdata['pdu_buildpc'])) {
            $id_bao_gia  = $this->session->userdata['pdu_buildpc'];
            $data['data_arr_bg'] = json_decode($id_bao_gia);
        }
        echo $this->load->view($this->template_path . 'page/print_bao_gia' , $data, TRUE);
    }
    
/*chọn cấu hình*/
    public function changeCH()
    {
        $this->load->model('category_model');
        $this->_category     = new Category_model();

        $cauhinhpc   = $this->input->post('cauhinhpc');
        $catecomputer = $this->_category->getByField('slug',"linh-kien-computer");
        $data['category_child'] = $category_child = $this->_category->getCategoryChild($catecomputer->id);
        $total = 0;
        if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {
             
            $data_pro_pc = $this->session->userdata['pdu_buildpc'][$cauhinhpc];

            if(!empty($data_pro_pc)){
                $data['data_pro_pc'] = $data_pro_pc;

                foreach ($data['data_pro_pc'] as $key => $value) {
                    $price        = $value['price'];
                    $total+=$price*$value['quantity'];
                }

                $data['totalprice'] = $total;
            }else{
                 $data['data_pro_pc'] = [];
            }

        }

        $html = $this->load->view($this->template_path . 'page/ajax_buildpc3', $data, TRUE);
        $data_mess = [
            'html' => $html,
            'total' => number_format($total,0,'','.')
        ];
        die(json_encode($data_mess));

    }
/*xu ly trang build pc*/
    public function build_pc($slug,$page = 1)
    {
        $this->load->model('category_model');
        $this->_category     = new Category_model();
        /*
        b1:lấy all danh mục con của computer
         */
        $cauhinhpc   = $this->input->post('cauhinhpc') ? $this->input->post('cauhinhpc') : 'ch1';

        $data['oneItem'] = $oneItem = $this->_page->getByField('slug',$slug);
        if (empty($oneItem)) show_404();

        $catecomputer = $this->_category->getByField('slug',"linh-kien-computer");
        $data['category_child'] = $category_child = $this->_category->getCategoryChild($catecomputer->id);

       

        if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {
            $pdu_buildpc  = $this->session->userdata['pdu_buildpc'];
            
            $data['data_pro_pc'] = $pdu_buildpc[$cauhinhpc];

            $total = 0;
            foreach ($data['data_pro_pc'] as $key => $value) {
               $data_product = $this->_product->getById($value['id'],'id,price,price_sale');
                $price        = $this->price_product($data_product);
                $total+=$price*$value['quantity'];
            }
            $data['totalprice'] = $total;
        }


        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => base_url("am_$slug.html"),
            'is_robot' => 1,
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $data['main_content'] = $this->load->view($this->template_path . 'page/index-buildpc', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function save_item_pc()
    {
        
        $this->checkRequestPostAjax();
        $product_id   = $this->input->post('product_id');
        $cate_id   = $this->input->post('cate_id');
        $cauhinhpc   = $this->input->post('cauhinhpc');

        $data_product = $this->_product->getById($product_id,'id,title,price,price_sale,thumbnail,slug,guarantee,quality,code');
        $price     = $this->price_product($data_product);
        $total  = 0;

        if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {
            $datass = $this->session->userdata['pdu_buildpc'];
            /*
            1.check xem đang có session cauhinhpc nào
            2. check $this->session->userdata['pdu_buildpc'] không trống thì check tiếp $this->session->userdata['pdu_buildpc'][$cauhinhpc] (a1), nếu (a1) không trống thì thêm ptu vào mảng, nếu (a1) trống thì khởi tạo mảng mới
             */
            $datax = $datass[$cauhinhpc];
            $check = false;
            if (!empty($datax)) foreach ($datax as $key => $value) {
                if ($value['id'] != $product_id) {
                    $check = true;
                }
                if($key != $cate_id){
                    $total+=$value['price']*$value['quantity'];
                }
                
            }
            if ($check == true) {
                $datass[$cauhinhpc][$cate_id] = [
                    'id' => $product_id,
                    'quantity' => 1,
                    'price' => $price
                ];
            }
            
            // $this->session->set_userdata('pdu_buildpc', $data);
        }else {
            /*ch1 đã có sp, chuyển sang ch2, mà ch2 đang trống -> tạo phần tử ch2 rồi set_session thì nó sẽ mất ch1
            -> nếu ch1 có, ch2 trống. thì tiến hành add ch2 vào mảng.
            */
            if(@$this->session->userdata['pdu_buildpc']){
                $datass = $this->session->userdata['pdu_buildpc'];

                $datass[$cauhinhpc][$cate_id] = [
                    'id' => $product_id,
                    'quantity' => 1,
                    'price' => $price
                ];
            }else{
                $datass[$cauhinhpc][$cate_id] = [
                    'id' => $product_id,
                    'quantity' => 1,
                    'price' => $price
                ];
            }

        }
        $this->session->set_userdata("pdu_buildpc", $datass);
        // dd($this->session->userdata['pdu_buildpc']);

        $total += $price;
        $html = $this->load->view($this->template_path . 'page/ajax_buildpc2', ['data_product' =>$data_product], TRUE);
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success',
            'html' => $html,
            'total' => number_format($total,0,'','.')
        ];
        die(json_encode($data_mess));
    }
    public function delete_buildpc(){
        $this->session->unset_userdata('pdu_buildpc');
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success'
        ];
        die(json_encode($data_mess));
    }

    public function remove_item_pc()
    {
        $this->checkRequestPostAjax();
        $product_id = $this->input->post('product_id');
        $cauhinhpc   = $this->input->post('cauhinhpc');

        $total  = 0;
        if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {
            $data = $this->session->userdata['pdu_buildpc'];
            
            $datax = $data[$cauhinhpc];
            if (!empty($datax)) foreach ($datax as $key => $value) {
                if ($value['id'] == $product_id) {
                    unset($datax[$key]);
                }else{
                    
                    $total+=$value['price']*$value['quantity'];
                }
            }
            $data[$cauhinhpc] = $datax;
            // dd($data);
            if (!empty($data)) {
                $this->session->set_userdata('pdu_buildpc', $data);
            }else{
                $this->session->unset_userdata('pdu_buildpc');
            }
        }
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success',
            'total' => number_format($total,0,'','.')
        ];
        die(json_encode($data_mess));
    }

    public function update_item_pc()
    {
        $this->checkRequestPostAjax();
        $product_id   = $this->input->post('product_id');
        $quantity     = $this->input->post('quantity');
        $cauhinhpc   = $this->input->post('cauhinhpc');
        $total        = 0;
        $subtotal     = 0;
        if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {
            $data = $this->session->userdata['pdu_buildpc'];
            //$data = json_decode($data,true);
            $datax = $data[$cauhinhpc];
            if (!empty($datax)) foreach ($datax as $key => $value) {
                $data_product = getByIdProduct($value['id']);
                $price        = $this->price_product($data_product);
                if ($value['id'] == $product_id) {
                    $datax[$key]['quantity'] = $quantity;
                    $subtotal = $price * $quantity;
                }
                $total += $price * $datax[$key]['quantity'];
            }
            $data[$cauhinhpc] = $datax;
            $this->session->set_userdata('pdu_buildpc', $data);
        }
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success',
            'total' => number_format($total,0,'','.'),
            'subtotal' => number_format($subtotal,0,'','.')
        ];
        die(json_encode($data_mess));
    }

    public function price_product($data_product)
    {
        if (!empty($data_product->price) && !empty($data_product->price_sale)) {
            $price = $data_product->price_sale;
        }elseif(!empty($data_product->price) && empty($data_product->price_sale)){
            $price = $data_product->price;
        }else{
            $price = 0;
        }
        return $price;
    }

    public function _queue_select($categories, $parent_id = 0, $char = ''){
        if(!empty($categories)) foreach ($categories as $key => $item){
            if ($item->parent_id == $parent_id){
                $title = $item->title == 'Sản phẩm' ? 'Tất cả sản phẩm' : $item->title;
                $tmp['title'] = $parent_id ? '  |--'.$char.$title : $char.$title;
                $tmp['id'] = $item->id;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue_select($categories,$item->id,$char.'--');
            }
        }
    }

    public function _404(){
        redirect('/','','301');
    }
    
    public function notfound(){
        $data['main_content'] = $this->load->view($this->template_path . 'page/_404', NULL, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function download_excel_listpc()
    {

         $cauhinhpc   = $this->input->post('cauhinhpc');
         if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {

            $data_pro_pc = $this->session->userdata['pdu_buildpc'][$cauhinhpc];

            $table_column = array('mã sản phẩm','tên sản phẩm','bảo hành', 'số lượng', 'đơn giá', 'thành tiền');

            cms_delete_public_file_by_extend('xlsx');
            // create file name
            $fileName = 'Builpc-pducomputer' . time() . '.xlsx';

            // load excel library
            $this->load->library('PHPExcel');
            $objPHPExcel = new PHPExcel();

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle("Builpc-pducomputer");
            //cột
            $column = 0;
            foreach($table_column as $item){
                $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($column, 1, $item);
                $column++;
            }
            //hàng
            $excel_row = 2;
            $total = 0;
            foreach($data_pro_pc as $row){
                $data_product = getByIdProduct($row['id']);
                $total += $row['price'] *$row['quantity'];
                $subtotal = $row['price'] *$row['quantity'];

                    $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(0, $excel_row, $data_product->code);
                    $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(1, $excel_row, $data_product->title);
                    $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(2, $excel_row, $data_product->guarantee);
                    $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(3, $excel_row, $row['quantity']);
                    $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(4, $excel_row, $row['price']);
                    $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(5, $excel_row, $subtotal);
                    
                $excel_row++;
            }
            $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(0, $excel_row, "tổng giá");
            $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(5, $excel_row, $total);

            foreach (range('A', 'H') as $columnId) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
            }
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
            //download file
            header("Content-Type: application/vnd.ms-excel");
            $linkdownload = (HTTP_UPLOAD_IMPORT_PATH . $fileName);
            $data_mess = [
                'linkdownload' => $linkdownload,
                'type' => 'success',
                'message' => 'thành công',
            ];

        }else{
            $data_mess = [
                'linkdownload' => "",
                'message' => 'Chưa có sản phẩm nào được chọn!',
                'type' => 'error',
            ];
           
        }
         die(json_encode($data_mess));
    }

    public function create_image_listpc()
    {//xuất file ảnh hoặc pdf,chưa biết làm
        // $cauhinhpc   = $this->input->post('cauhinhpc');
        //  if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {

        //     $data_pro_pc = $this->session->userdata['pdu_buildpc'][$cauhinhpc];

        // }
        
    }

    public function add_cart_listpc()
    {
       $cauhinhpc   = $this->input->post('cauhinhpc') ? $this->input->post('cauhinhpc') : 'ch1';
        if (!empty($this->session->userdata['pdu_buildpc'][$cauhinhpc])) {
            $data_pro_pc = $this->session->userdata['pdu_buildpc'][$cauhinhpc];
            
            foreach($data_pro_pc as $item){
                $data_product = $this->_product->getById($item['id'],'id,price,price_sale,slug,thumbnail,title');
                $price        = $this->price_product($data_product);

                $item = array(
                    'id' => $data_product->id,
                    'qty' => $item['quantity'],
                    'price' => $price,
                    'name' => $data_product->title,//có dấu / ở tên là méo thêm đc
                    'slug' => $data_product->slug,
                    'thumbnail' => $data_product->thumbnail,
                );
                
                $this->cart->insert($item);

            }
            $total_cart = $this->cart->total();
            $total_item = $this->cart->total_items();
            $data_mess = array(
                'message' => 'Thêm sản phẩm thành công',
                'type' => 'success',
                'total_cart' => $total_cart,
                'total_item' => $total_item
            );
            
            unset($this->session->userdata['pdu_buildpc'][$cauhinhpc]);
        }else{
            $data_mess = array(
                'message' => 'Bạn chưa chọn sản phẩm nào!',
                'type' => 'error',
            );
        }
        die(json_encode($data_mess));
    }
    public function view_print()
    {
        
       $cauhinhpc  = $this->input->get('cauhinh');
       // $type = $this->input->get('type');
        $data['data_pro_pc'] = $this->session->userdata['pdu_buildpc'][$cauhinhpc];


        $data['SEO'] = [
            'meta_title' => 'In báo giá sản phẩm '.(!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'),
            'meta_description' => 'In báo giá sản phẩm, '.(!empty($this->_settings->meta_desc) ? $this->_settings->meta_desc : 'PDUCOMPUTER'),
            'url' => base_url("am_buildpc.html"),
            'is_robot' =>  '1'
        ];

        $this->load->view($this->template_path . 'page/baogia_buildpc', $data);

    }


}
