<?php
defined('BASEPATH') or exit('No direct script access allowed');

require "public/simple_html_dom.php";

class Productpdu extends Crawler_Controller
{
    private $_category; 
    private $_product; 
    private $_product_type; 
    private $_domain; 
     
    public function __construct(){ 
        parent::__construct();
        $this->load->model(['category_model','product_model','product_type_model']);
        $this->_category     = new Category_model();
        $this->_product      = new Product_model();
        $this->_product_type = new Product_type_model();

        $this->_domain       = 'https://www.hanoicomputer.vn/';
    } 
public function updateinfo1()
{
    set_time_limit(0);
    $product = $this->_product->getDataAll('','','id,title');
    foreach($product as $item){
        $this->_product->update(['id'=>$item->id],['meta_title' => $item->title]);
    }
}
public function updateinfo()
{
    set_time_limit(0);
$product = $this->_product->getDataAll(['price <'=>0],'','id,price');
    foreach($product as $item){
        
        $this->_product->update(['id'=>$item->id],['price' => 0,'price_sale'=>0]);
                
    }

    // $product = $this->_product->getDataAll(['product_type_id'=>17],'','id,crawler_href');

    // foreach($product as $item){
    //     $crawler3 = file_get_html($item->crawler_href);
    //      $title = trim(str_replace('hanoicomputer','pdu',$crawler3->find('.product_detail-title h1')[0]->text()));
    //     $slug = $this->toSlug($title);
                    
    //      $data_album = array();//bỏ vì nếu khai báo cái này thành arr thì nó
    //      $thumb_arr = array();
    //      if(count($crawler3->find('.carousel-icon-group .img-item img'))){
    //         $oj_album = $crawler3->find('.carousel-icon-group .img-item img');
    //         foreach($oj_album as $a){
    //           $data_album[] = $a->src;
    //         }
    //      }else{
    //         $oj_album = $crawler3->find('div#tab1 img');
    //         foreach($oj_album as $a){
    //           $data_album[] = $a->src;
    //         }
    //      }
    //     if (!empty($data_album)) foreach ($data_album as $key => $value) {
            
    //             $thumb = $slug.'-pducomputer-'.$key.'.jpg';
    //             $dir  = MEDIA_PATH.'product/phukienlaptop3/'. $thumb.'';
    //             copy($value, $dir);
            
    //     }
    //     $thumb = $slug.'-pducomputer-laptoppdu.jpg';
    //     $dir2  = MEDIA_PATH.'product/phukienlaptop3/'. $thumb.'';
    //     copy($data_album[0], $dir2);

    //     $crawler3->clear();           
    // }
}
    public function deletedata()
    {
        $this->db->truncate('product');
        echo "xóa hết xong";
    }

    public function getcategory()
    {
        $crawler = file_get_html("https://www.hanoicomputer.vn/man-hinh-may-tinh");
        $ob1 = $crawler->find("ul.list-brand-check.list-unstyled",0)->find("li a.bold");
        set_time_limit(0);
        foreach($ob1 as $value){
          $data_cate = [
            "title" => $value->text(),
            "slug" => $this->toSlug($value->text()),
            "parent_id" => 116//asus =116
          ];
          dd($this->_domain.$value->href);
          // $this->_category->save($data_cate);
        }
        
        
       dd($data_cate);
    }
        
    public function indexhnc()
    {
        //Tổng quát: cạo danh mục con -> cạo list sp -> cạo sp chi tiết (3 vòng for) 
        //bước 1:cạo danh mục con
        $dem = 0;
        $page = 1;
        $crawler1 = file_get_html("https://www.hanoicomputer.vn/man-hinh-may-tinh");
        $ob1 = $crawler1->find("ul.list-brand-check.list-unstyled",0)->find("li a.bold");
        set_time_limit(0);
        if(!empty($ob1)){
            foreach($ob1 as $value){
              $titlecate = $value->text();
              
              $data_cate = [
                "title" => $titlecate,
                "slug" => $this->toSlug($titlecate),
                "type" => "product",
                "description" =>$titlecate,
                "meta_title" =>$titlecate,
                "meta_description" =>$titlecate,
                "meta_keyword" =>$titlecate,
                "content" =>$titlecate,
                "parent_id" => 142,//asus =116 REQUIRED
              ];

              $idcate = $this->_category->save($data_cate);

if($idcate){
              //bước 2: list sp ở danh mục
                $linkdanhmuc = $value->href;
                $crawler2 = file_get_html($this->_domain.$linkdanhmuc);
                $paging = count($crawler2->find('.paging')) ? count($crawler2->find('.paging',0)->find("a")) : 1;
                
            for($page =1; $page <= $paging;$page++){//số trang
                    $crawler2 = file_get_html($this->_domain.$linkdanhmuc."/{$page}/");
                    $ob2 = $crawler2->find(".cate-prod-bottom .p-component");
                
                
                foreach($ob2 as $value2){
                    $linksp = $this->_domain.$value2->find(".p-img a",0)->href;
                    $thumbnail = $value2->find(".p-img a img",0)->attr['data-src'];
                    echo $dem++;
                    //bước 3: cạo detail sp
                    $crawler3 = file_get_html($linksp);
                    
                    $title = trim(str_replace('hanoicomputer','pdu',$crawler3->find('.product_detail-title h1')[0]->text()));

                    $code =count($crawler3->find('.product_detail-sku .sku')) ? trim($crawler3->find('.product_detail-sku .sku')[0]->text()) : "PDU000";

                    // $title = preg_replace("/[!@#$%^&*;:\/]/",'', $title);
                    $text_price_sale = count($crawler3->find('#product-info-price #p-info-price')) ? $crawler3->find('#product-info-price #p-info-price')[0]->text() : 0;
                    $slug = $this->toSlug($title);

                    $price_sale = (int)preg_replace('/[^0-9]/', '', $text_price_sale)-500000;
                    $price = (int)$price_sale + 500000;
                    
                     $content = count($crawler3->find('.bang-tskt table')) ? $crawler3->find('.bang-tskt table')[0]->outertext() : '';
                     $viewd = count($crawler3->find('.counter-number')) ? $crawler3->find('.counter-number')[0]->text() : 0;
                     $data_album = array();//bỏ vì nếu khai báo cái này thành arr thì nó
                     $thumb_arr = array();
                     if(count($crawler3->find('.carousel-icon-group .img-item img'))){
                        $oj_album = $crawler3->find('.carousel-icon-group .img-item img');
                        foreach($oj_album as $a){
                          $data_album[] = $a->src;
                        }
                     }else{
                        $oj_album = $crawler3->find('div#tab1 img');
                        foreach($oj_album as $a){
                          $data_album[] = $a->src;
                        }
                     }
                    
                    if (!empty($data_album)) foreach ($data_album as $key => $value) {
                        
                            $thumb = $slug.'-pducomputer-'.$key.'.jpg';
                            $dir  = MEDIA_PATH.'product/phukienlaptop7/'. $thumb.'';
                            copy($value, $dir);
                            $thumb_arr[] = '/product/phukienlaptop7/'.$thumb;
                        
                    }
                    $album = !empty($thumb_arr) ? array_unique($thumb_arr) : '';
                    $param_store = [
                        'title' => $title,
                        'price' => $price,
                        'slug' => $slug,
                        'crawler_href' => $linksp,
                        'price_sale' => $price_sale,
                        'content' => $title."<br/>".$content,
                        'description' => $title.",".$title,
                        'album' => !empty($album) ? json_encode($album) : '',
                        'product_type_id' => 21,//required
                        'code' => 'PDU'.$code,
                        'quality' => 1,
                        'layout' => "phukien",
                        'newlike' => 1,
                        'attribute' => $this->attribute(),
                        'guarantee' => "24 tháng",
                        'meta_title' => $title.",".$title,
                        'meta_description' => $title.",".$title,
                        'meta_keyword' => $title.",".$title,
                        'viewed' => (int)$viewd,
                        'created_time' => date('Y-m-d H:i:s',strtotime("11/01/2017")),
                        'updated_time' => date('Y-m-d H:i:s',strtotime("11/01/2017"))
                    ];
                    $checkHref = $this->_product->checkHref($linksp);
                    if (empty($checkHref)) {
                        $thumb = $slug.'-pducomputer-laptoppdu.jpg';
                        $dir  = MEDIA_PATH.'product/phukienlaptop7/'. $thumb.'';
                        copy($thumbnail, $dir);
                        $param_store['thumbnail'] = '/product/phukienlaptop7/'.$thumb;

                        $id = $this->_product->save($param_store);
                        $this->save_category($id, [$idcate,142]);//017=laptopdell | hp-106 | lenlovo-115 | asus-116, acer-117 | sony-118

                        echo "Thêm $title ở trang số"."/{$page}"."<br/>";
                        // echo $linksp."/{$page}"."<br/>";

                    }else{
                        echo "Đã tồn tại $title <br/>";
                    }

                    $crawler3->clear(); 
                }//foreach ob2
                $crawler2->clear(); 
                echo "hết page số {$page}"."ở danh mục {$linkdanhmuc}";
             }//for paging
             $crawler2->clear(); 
}//if $idcate
            }//foreach $ob1
            $crawler1->clear(); 
        }//if
        
    }
     public function indexhnc1()
    {
        //Tổng quát: cạo danh mục con -> cạo list sp -> cạo sp chi tiết (3 vòng for) 
        //bước 1:cạo danh mục con
        $dem = 0;
        $page = 1;

        set_time_limit(0);
        
                $crawler2 = file_get_html("https://www.hanoicomputer.vn/nguon-may-tinh");
                $paging = count($crawler2->find('.paging')) ? count($crawler2->find('.paging',0)->find("a")) : 1;
                
            for($page =1; $page <= $paging;$page++){//số trang
                    $crawler2 = file_get_html("https://www.hanoicomputer.vn/nguon-may-tinh"."/{$page}/");
                    $ob2 = $crawler2->find(".cate-prod-bottom .p-component");
                
                
                foreach($ob2 as $value2){
                    $linksp = $this->_domain.$value2->find(".p-img a",0)->href;
                    $thumbnail = $value2->find(".p-img a img",0)->attr['data-src'];
                    echo $dem++;
                    //bước 3: cạo detail sp
                    $crawler3 = file_get_html($linksp);
                    
                    $title = trim(str_replace('hanoicomputer','pdu',$crawler3->find('.product_detail-title h1')[0]->text()));

                    $code =count($crawler3->find('.product_detail-sku .sku')) ? trim($crawler3->find('.product_detail-sku .sku')[0]->text()) : "PDU000";

                    // $title = preg_replace("/[!@#$%^&*;:\/]/",'', $title);
                    $text_price_sale = count($crawler3->find('#product-info-price #p-info-price')) ? $crawler3->find('#product-info-price #p-info-price')[0]->text() : 0;
                    $slug = $this->toSlug($title);

                    $price_sale = (int)preg_replace('/[^0-9]/', '', $text_price_sale)-500000;
                    $price = (int)$price_sale + 500000;
                    
                     $content = count($crawler3->find('.bang-tskt table')) ? $crawler3->find('.bang-tskt table')[0]->outertext() : '';
                     $viewd = count($crawler3->find('.counter-number')) ? $crawler3->find('.counter-number')[0]->text() : 0;
                     $data_album = array();//bỏ vì nếu khai báo cái này thành arr thì nó
                     $thumb_arr = array();
                     if(count($crawler3->find('.carousel-icon-group .img-item img'))){
                        $oj_album = $crawler3->find('.carousel-icon-group .img-item img');
                        foreach($oj_album as $a){
                          $data_album[] = $a->src;
                        }
                     }else{
                        $oj_album = $crawler3->find('div#tab1 img');
                        foreach($oj_album as $a){
                          $data_album[] = $a->src;
                        }
                     }
                    
                    if (!empty($data_album)) foreach ($data_album as $key => $value) {
                        
                            $thumb = $slug.'-pducomputer-'.$key.'.jpg';
                            $dir  = MEDIA_PATH.'product/phukienlaptop6/'. $thumb.'';
                            copy($value, $dir);
                            $thumb_arr[] = '/product/phukienlaptop6/'.$thumb;
                        
                    }
                    $album = !empty($thumb_arr) ? array_unique($thumb_arr) : '';
                    $param_store = [
                        'title' => $title,
                        'price' => $price,
                        'slug' => $slug,
                        'crawler_href' => $linksp,
                        'price_sale' => $price_sale,
                        'content' => $title."<br/>".$content,
                        'description' => $title.",".$title,
                        'album' => !empty($album) ? json_encode($album) : '',
                        'product_type_id' => 20,//required
                        'code' => 'PDU'.$code,
                        'quality' => 1,
                        'layout' => "phukien",
                        'newlike' => 1,
                        'attribute' => $this->attribute(),
                        'guarantee' => "24 tháng",
                        'meta_title' => $title.",".$title,
                        'meta_description' => $title.",".$title,
                        'meta_keyword' => $title.",".$title,
                        'viewed' => (int)$viewd,
                        'created_time' => date('Y-m-d H:i:s',strtotime("11/01/2017")),
                        'updated_time' => date('Y-m-d H:i:s',strtotime("11/01/2017"))
                    ];
                    $checkHref = $this->_product->checkHref($linksp);
                    if (empty($checkHref)) {
                        $thumb = $slug.'-pducomputer-laptoppdu.jpg';
                        $dir  = MEDIA_PATH.'product/phukienlaptop6/'. $thumb.'';
                        copy($thumbnail, $dir);
                        $param_store['thumbnail'] = '/product/phukienlaptop6/'.$thumb;

                        $id = $this->_product->save($param_store);
                        $this->save_category($id, [140]);//017=laptopdell | hp-106 | lenlovo-115 | asus-116, acer-117 | sony-118

                        echo "Thêm $title ở trang số"."/{$page}"."<br/>";
                        // echo $linksp."/{$page}"."<br/>";

                    }else{
                        echo "Đã tồn tại $title <br/>";
                    }

                    $crawler3->clear(); 
                }//foreach ob2
                $crawler2->clear(); 
                echo "hết page số {$page}"."ở danh mục {hdd}";
             }//for paging


        
    }
    // bước 3: sp detail
    public function detail_product()
    {
        set_time_limit(0);
        $ii=0;
        // $crawler3 = file_get_html($linksp);
        $crawler3 = file_get_html("https://www.hanoicomputer.vn/laptop-asus-vivobook-a512da-ej1448t-bac");
        $title = trim(str_replace('hanoicomputer','pdu',$crawler3->find('.product_detail-title h1')[0]->text()));
        $code = trim($crawler3->find('.product_detail-sku .sku')[0]->text());
        // $title = preg_replace("/[!@#$%^&*;:\/]/",'', $title);
        $text_price_sale = count($crawler3->find('#product-info-price #p-info-price')) ? $crawler3->find('#product-info-price #p-info-price')[0]->text() : 0;
        $slug = $this->toSlug($title);

        $price_sale = (int)preg_replace('/[^0-9]/', '', $text_price_sale)-700000;
        $price = (int)$price_sale + 700000;
        
         $content = count($crawler3->find('.bang-tskt table')) ? $crawler3->find('.bang-tskt table')[0]->outertext() : '';
         $viewd = count($crawler3->find('.counter-number')) ? $crawler3->find('.counter-number')[0]->text() : 0;
         $data_album = array();//bỏ vì nếu khai báo cái này thành arr thì nó
         $thumb_arr = array();
         if(count($crawler3->find('.carousel-icon-group .img-item img'))){
            $oj_album = $crawler3->find('.carousel-icon-group .img-item img');
            foreach($oj_album as $a){
              $data_album[] = $a->src;
            }
         }else{
            $oj_album = $crawler3->find('div#tab1 img');
            foreach($oj_album as $a){
              $data_album[] = $a->src;
            }
         }
        
        if (!empty($data_album)) foreach ($data_album as $key => $value) {
            
                $thumb = $slug.'-pducomputer-'.$key.'.jpg';
                $dir  = MEDIA_PATH.'product/laptopmoi2/'. $thumb.'';
                copy($value, $dir);
                $thumb_arr[] = '/product/laptopmoi2/'.$thumb;
            
        }
        $album = !empty($thumb_arr) ? array_unique($thumb_arr) : '';

        $param_store = [
            'album' => !empty($album) ? json_encode($album) : '',
            'content' => $content,
            'title' =>$title,
            'meta_description' => $title.",".$title,
            'meta_keyword' => $title.",".$title,
            'meta_title' => $title.",".$title,
            'code' => $code,
            'viewed' => (int)$viewd
        ];
        return $param_store;
    }

    //crawler danh mục tcc
	public function indextcc() {
        //hp,lenlovo,dell
        //https://laptoptcc.com/danh-muc/laptop-chuyen-gaming/laptop-asus-gaming/page/2
        //https://laptoptcc.com/danh-muc/laptop-chuyen-gaming/laptop-msi-gaming/
        //https://laptoptcc.com/danh-muc/laptop-dell/page/{$page}/
    $totalpage = 1;//sửa dòng 114,94 cho phù hợp
    for($page = 1; $page<= $totalpage; $page++){
        $crawler = file_get_html("https://laptoptcc.com/danh-muc/laptop-chuyen-gaming/laptop-msi-gaming/page/{$page}/");
        $count1 = count($crawler->find("ul.products.columns-4 li"));
       set_time_limit(0);

       for($j = 0; $j<$count1; $j++){
        $link_item = $crawler->find(".product-loop-header a.woocommerce-LoopProduct-link.woocommerce-loop-product__link")[$j]->href;

        $crawler2 = file_get_html($link_item);
         // echo $crawler2;
         // die();
            $thumbnail   = count($crawler2->find('a.woocommerce-main-image.zoom img')) ? $crawler2->find('a.woocommerce-main-image.zoom img')[0]->src : '';
                $href  = $link_item;
                $title = trim(str_replace('tcc','pdu',$crawler2->find('h1.product_title.entry-title')[0]->text()));
                // $title = preg_replace("/[!@#$%^&*;:\/]/",'', $title);
                $text_price_sale = count($crawler2->find('.entry-summary .woocommerce-Price-amount bdi')) ? $crawler2->find('.entry-summary .woocommerce-Price-amount bdi')[0]->text() : 0;
                $slug = $this->toSlug($title);

                $price_sale = (int)preg_replace('/[^0-9]/', '', $text_price_sale)-1500000;
                $price = (int)$price_sale + 1000000;

                 $content = count($crawler2->find('.electro-description table')) ? $crawler2->find('.electro-description table')[0]->outertext() : '';
                 
                 $data_album = array();//bỏ vì nếu khai báo cái này thành arr thì nó
                 $thumb_arr = array();
                 if(count($crawler2->find('.thumbnails .thumb[data-hq]'))){
                    $oj_album = $crawler2->find('.thumbnails .thumb[data-hq]');
                    foreach($oj_album as $a){
                      $data_album[] = $a->attr['data-hq'];
                    }
                 }else{
                    $oj_album = $crawler2->find('.electro-description img');
                    foreach($oj_album as $a){
                      $data_album[] = $a->src;
                    }
                 }
                 /* cach này count nhiều lần quá
                 $count_album = count($crawler2->find('.electro-description img')) ? count($crawler2->find('.electro-description img')) : count($crawler2->find('.thumbnails .thumb[data-hq]'));
                 $oj_album = count($crawler2->find('.electro-description img')) ? $crawler2->find('.electro-description img') : $crawler2->find('.thumbnails .thumb[data-hq]');
                 
                 for($a = 0;$a <$count_album;$a++){
                    $data_album[] = $oj_album[$a]->attr['data-hq'];
                };*/
                
                if (!empty($data_album)) foreach ($data_album as $key => $value) {
                    
                        $thumb = $slug.'-pducomputer-'.$key.'.jpg';
                        $dir  = MEDIA_PATH.'product/laptopcu3/'. $thumb.'';
                        copy($value, $dir);
                        $thumb_arr[] = '/product/laptopcu3/'.$thumb;
                    
                }
                $album = !empty($thumb_arr) ? array_unique($thumb_arr) : '';
                $param_store = [
                    'title' => $title,
                    'price' => $price,
                    'slug' => $slug,
                    'crawler_href' => $href,
                    'price_sale' => $price_sale,
                    'content' => $title."<br/>".$content,
                    'description' => $title.",".$title,
                    'album' => !empty($album) ? json_encode($album) : '',
                    'product_type_id' => 10,//dell=1
                    'code' => "tc".rand(10,1000),
                    'quality' => 1,
                    'layout' => "laptop",
                    'attribute' => $this->attribute(),
                    'guarantee' => "12 tháng",
                    'meta_title' => $title.",".$title,
                    'meta_description' => $title.",".$title,
                    'meta_keyword' => $title.",".$title,
                    'created_time' => date('Y-m-d H:i:s',strtotime("11/01/2017")),
                    'updated_time' => date('Y-m-d H:i:s',strtotime("11/01/2017"))
                ];
                $checkHref = $this->_product->checkHref($href);
                if (empty($checkHref)) {
                    $thumb = $slug.'-pducomputer-laptoppdu.jpg';
                    $dir  = MEDIA_PATH.'product/laptopcu3/'. $thumb.'';
                    copy($thumbnail, $dir);
                    $param_store['thumbnail'] = '/product/laptopcu3/'.$thumb;

                    $id = $this->_product->save($param_store);
                    $this->save_category($id, [143,131]);//017=laptopdell | hp-106 | lenlovo-115 | asus-116, acer-117 | sony-118
                    $ii++;
                    echo "Thêm $ii \n";

                }else{
                    echo "Đã tồn tại $title \n";
                }

      $crawler2->clear(); 
   }
   $crawler->clear();
}//endfor11
    }//ednindextcc 



private function save_category($id, $category_id) {
    if (!empty($category_id)) {
        $this->_product->delete(['product_id'=>$id],'product_category');
        // $data_category[] = ["product_id" => $id, 'category_id' => $category_id];
        if(!empty($category_id)) foreach ($category_id as $category_idx){
            $tmp = ["product_id" => $id, 'category_id' => $category_idx];
            $data_category[] = $tmp;
        }

        if(!$this->_product->insertMultiple($data_category, 'product_category')){
            $message['type'] = 'error';
            $message['message'] = "Thêm product_category thất bại !";
            log_message('error', $message['message'] . '=>' . json_encode($data_category));
        }
    }

}   

public function attribute()
    {
        $attr = '{"nha_san_xuat":{"value":"","name":"Nh\u00e0 s\u1ea3n xu\u1ea5t","key":""},"dung_luong_ram":{"value":"","name":"dung l\u01b0\u1ee3ng ram","key":""},"loai_ram":{"value":"","name":"Lo\u1ea1i ram","key":""},"so_khe_cam_ram":{"value":"","name":"S\u1ed1 khe c\u1eafm ram","key":""},"dung_luong_toi_da_ram":{"value":"","name":"Dung l\u01b0\u1ee3ng t\u1ed1i \u0111a Ram","key":""},"socket":{"value":"","name":"SOCKET","key":""},"loai_o_cung":{"value":"","name":"lo\u1ea1i \u1ed5 c\u1ee9ng","key":""},"dung_luong_o_cung":{"value":"","name":"Dung l\u01b0\u1ee3ng \u1ed5 c\u1ee9ng","key":""},"toc_do_o_cung":{"value":"","name":"T\u1ed1c \u0111\u1ed9 \u1ed5 c\u1ee9ng","key":""},"do_rong_man_hinh":{"value":"","name":"\u0111\u1ed9 r\u1ed9ng m\u00e0n h\u00ecnh","key":""},"do_phan_giai_man_hinh":{"value":"","name":"\u0110\u1ed9 ph\u00e2n gi\u1ea3i m\u00e0n h\u00ecnh","key":""},"vi_xu_ly_cpu":{"value":"","name":"Vi x\u1eed l\u00fd CPU","key":""},"nhu_cau_su_dung":{"value":"","name":"Nhu c\u1ea7u s\u1eed d\u1ee5ng","key":""},"ten_vga_roi":{"value":"","name":"T\u00ean VGA r\u1eddi","key":""},"bo_nho_vga":{"value":"","name":"b\u1ed9 nh\u1edb vga","key":""},"cong_xuat_nguon_pc":{"value":"","name":"C\u00f4ng xu\u1ea5t ngu\u1ed3n pc","key":""},"mau_vo_case_pc":{"value":"","name":"M\u00e0u v\u1ecf case pc","key":""},"chat_lieu_vo_case_pc":{"value":"","name":"Ch\u1ea5t li\u1ec7u v\u1ecf case pc","key":""},"model":{"value":"","name":"Model, m\u00e3 m\u00e1y"},"xuat_xu":{"value":"","name":"xu\u1ea5t x\u1ee9"},"can_nang":{"value":"","name":"C\u00e2n n\u1eb7ng"},"kich_thuoc":{"value":"","name":"k\u00edch th\u01b0\u1edbc"},"mau_vo":{"value":"","name":"M\u00e0u V\u1ecf"},"more":{"value":"4 x USB 3.0, HDMI (K\u1ebeT N\u1ed0I TIVI, M\u00c1Y CHI\u1ebeU...VV...),LAN (RJ45), VGA - K\u1ebeT N\u1ed0I M\u00c1Y CHI\u1ebeU, T\u00cdCH H\u1ee2P MICROPHONE - HEADPHONE, Camera, Bluetooth","name":"T\u00ednh N\u0103ng M\u1edf R\u1ed9ng, th\u00f4ng s\u1ed1 kh\u00e1c"},"video_baotri":{"value":"","name":"Video h\u01b0\u1edbng d\u1eabn b\u1ea3o d\u01b0\u1ee1ng"}}';
        return $attr;
    }
}//endproductpdu

