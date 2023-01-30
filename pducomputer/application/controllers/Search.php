<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Public_Controller {

    protected $_product;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('search_model');
        $this->_product = new Product_model();
        $this->_search = new Search_model();
    }

    public function index($page=1){
        $data['type'] = $type = !empty($this->input->get('type')) ? $this->input->get('type') : '';
        $data['keyword'] = $keyword = $this->input->get('q');


        if(!empty($keyword)){
            $this->saveSearchKey($keyword,$type);
        }
        
        $keyword = toSlug(xss_clean($keyword));
        $limit = 20;
        
        if($type == "product" || $type = ''){
            $data['data_product'] = $this->_search->getDataSearchx($keyword,'product','id,title,slug,thumbnail,price,price_sale,code',$limit,$page);
            $total = $this->_search->getTotalDataSearch($keyword,'product');
        }elseif($type == "post"){
            $data['data_product'] = $this->_search->getDataSearchx($keyword,'post','id,title,slug,thumbnail,description,created_time,viewed',$limit,$page);
            $total = $this->_search->getTotalDataSearch($keyword,'post');
        }else{
            $data['data_product'] = $this->_search->getDataSearchx($keyword,'edu','id,title,slug,thumbnail,description,price,price_sale',$limit,$page);
            $total = $this->_search->getTotalDataSearch($keyword,'edu');
        }
        // dd($data['data_product'] );
        
        $data['url'] = $url = base_url("pa_ket-qua-tim-kiem.html?type={$type}&q=").$keyword;
        
        // phân Trang

        $this->load->library('pagination');

        $paging['base_url'] = base_url("pa_ket-qua-tim-kiem.html");
        $paging['first_url'] = base_url("pa_ket-qua-tim-kiem.html/?type={$type}&q={$keyword}");
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // $this->breadcrumbs->push("Trang chủ", base_url());
        $this->breadcrumbs->push("Bạn vừa tìm kiếm từ khóa {$keyword}", $url );
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['SEO'] = array(
            'meta_title'        => "Kết quả tìm kiếm {$data['keyword']}",
            'meta_description'  => "Kết quả tìm kiếm {$data['keyword']}, ".@$this->_settings->title,
            
            'meta_keyword'      => "Kết quả tìm kiếm {$data['keyword']}, ".@$this->_settings->title,
            'url'               => $url
        );

        if(isset($_GET['page'])){
            // $id đã định nghĩ ở link router, phân trang xử lý ở hàm khác thì phải gửi id về nữa
            $html = $this->load->view($this->template_path . 'search/ajax_product', $data, TRUE);
            echo $html;
            die();
        }else{
            //khi load lai trang
            $data['main_content'] = $this->load->view($this->template_path.'search/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
        }

        
    }
    //lưu key tìm kiếm vào database
    protected function saveSearchKey($title,$type){
        $title = trim($title);
        $slug = toSlug($title);

        $model = $this->_search->getByField('slug',$slug);

        $data = ['title'=>$title, 'slug'=>$slug, 'type'=>$type];
        $data['count'] = !empty($model->id) ? ($model->count +1) : 1;
        !empty($model->id) ? $this->_search->update(['id'=>$model->id],$data) : $this->_search->save($data);
    }

    public function ajax_loadseach(){
        $term = $this->input->post("q");
        $params = [
            'is_status'=> 1,
            'keyword' => $term,
            'limit'=> 6,
            'order' => array('id'=>'desc'),
            'selectpdu' => 'id,title,code,thumbnail,price,slug',
            
        ];
       
        $listdata = $this->_product->getData($params);

        /*cách 1: là gửi json sang rồi dùng js tạo html và append
            cách 2: gửi sang ajax 1 cái view html luôn.
         */
        
        $output = [];
        if(!empty($listdata)) foreach ($listdata as $item) {
            $output[] = ['id'=>$item->id, 'title'=>$item->title, 'thumbnail'=>$item->thumbnail, 'price'=>$item->price, 'url'=>get_url_product($item)];
        }
        $this->returnJson($output);
      /*cách 2
        $data['listdata'] = $listdata;
        $html = $this->load->view($this->template_path . 'ware_import/_ajax_load_data', $data, TRUE);
        echo $html;
        exit();
        */
    }


}
