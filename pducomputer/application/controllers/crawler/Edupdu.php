<?php
defined('BASEPATH') or exit('No direct script access allowed');

require "public/simple_html_dom.php";

class Edupdu extends Crawler_Controller
{
    private $_category; 
    private $_product; 
    private $_domain; 
     
    public function __construct(){ 
        parent::__construct();
        $this->load->model(['category_model','edu_model']);
        $this->_category     = new Category_model();
        $this->_edu      = new Edu_model();

        $this->_domain       = 'https://unica.vn';
    } 
public function deletedata()
    {
        $this->db->truncate('edu_category');
        echo "xóa hết xong x";
    }

public function updateinfo()
{
    set_time_limit(0);
$product = $this->_edu->getDataAll('','','id,crawler_href');

    foreach($product as $item){
        $crawler1 = file_get_html($item->crawler_href);
        $description = trim($crawler1->find(".block-ulti ul",0)->outertext());
        $this->_edu->update(['id'=>$item->id],['description' =>$description]);
        $crawler1->clear();         
    }
}
public function edumall()
{
    /*
    danh mục full khóa học https://edumall.vn/courses/
    dùng ajax load nên tải toàn bộ -> copy full html -> bỏ vào textarea -> click button thì inner nó ra màn hình rồi dom lấy thông tin, -> gửi ajax về server.giống kiểu get video drive
    Edumall ajax cả trang chi tiết nên không làm được theo cách trên.
     */
    $crawler1 = file_get_html("https://edumall.vn/courses/hoc-jquery-co-ban-den-nang-cao-qua-20-bai-tap");
    echo $crawler1;die();
        $ob1 = $crawler1->find(".u-cate-list-seo",0)->find("li a.btn");
        set_time_limit(0);
}


public function unica()
{
    $crawler1 = file_get_html("https://unica.vn/course/marketing");
    $ob1 = $crawler1->find(".u-cate-list-seo",0)->find("li a.btn");
    $dem = 0;
    set_time_limit(0);
    if(!empty($ob1)){
// bước 1: cạo danh mục con

        foreach($ob1 as $value){
            $titlecate = $value->text();
            
            $data_cate = [
                "title" => $titlecate,
                "slug" => $this->toSlug($titlecate),
                "type" => "edu",
                "description" =>$titlecate,
                "meta_title" =>$titlecate,
                "meta_description" =>$titlecate,
                "meta_keyword" =>$titlecate,
                "content" =>$titlecate,
                "parent_id" => 1//asus =116 REQUIRED
              ];
echo "danh mục:".$titlecate ;
            // $idcate = 1;

            if($idcate = $this->_category->save($data_cate)){
                $linkdanhmuc = $value->href;
                $crawler2 = file_get_html($linkdanhmuc);
                $numberItem = count($crawler2->find("span#total-course"))? $crawler2->find("span#total-course",0)->text() :'';
                if(!empty($numberItem)){
                    $page = ceil((int)$numberItem / 20);
                }else{
                    $page = 1;
                }
                
                for($i =1; $i <= $page;$i++){//số trang
                    $crawler2 = file_get_html($linkdanhmuc."?page={$i}");
                    
                    $ob2 = $crawler2->find(".list-course .form-group");
                    foreach($ob2 as $value2){
                        $linksp = $this->_domain.$value2->find("a.course-box-slider",0)->href;
                        $thumbnail = $value2->find(".img-course img",0)->src;
                        echo $dem++;
                        //lấy chi tiết bài viết
                        
                        $crawler3 = file_get_html($linksp);
                        
                        $title = count($crawler3->find('.u-detail-block-title h1 span')) ? $crawler3->find('.u-detail-block-title h1 span',0)->text() : '';
                        $slug = $this->toSlug($title);
                        $description = $crawler3->find(".u-detail-desc",0)->text();
                        $content1 = count($crawler3->find(".u-learn-what")) ? preg_replace('/unica/i','pd',$crawler3->find(".u-learn-what",0)->outertext()) : '';
                        $content2 = count($crawler3->find("div#u-des-course")) ? preg_replace('/unica/i','pd',$crawler3->find("div#u-des-course",0)->text()) : '';
                        $teacher = count($crawler3->find(".uct-right")) ? preg_replace('/unica/i','pd',$crawler3->find(".uct-right",0)->text()) : '';
                        $content3 = count($crawler3->find("div.panel-collapse .col")) ? $crawler3->find("div.panel-collapse .col") : '';
                        $listbaihoc = [];
                        if(!empty($content3)){
                            foreach($content3 as $value3){
                                $listbaihoc[] = ['name'=>trim($value3->find(".title a",0)->text()),'time'=>trim($value3->find(".time",0)->text())];
                            }
                        }
                        
                        if(!empty($listbaihoc)){
                            $listbaihoc = json_encode($listbaihoc);
                        }
                        $text_price_sale = count($crawler3->find('.big-price')) ? $crawler3->find('.big-price')[0]->text() : 0;
                        $price = (int)preg_replace('/[^0-9]/', '', $text_price_sale);
                        $price_sale = 50000;
                        $param_store = [
                            'title' => $title,
                            'price' => $price,
                            'slug' => $slug,
                            'crawler_href' => $linksp,
                            'price_sale' => $price_sale,
                            'content' => $content1."<br/>".$content2,
                            'teacher' =>$teacher,
                            'listdrive' => $listbaihoc,
                            'description' => $title.",".$title,
                            'code' => 'edu'.rand(1,1000),
                            'meta_title' => $title.",".$title,
                            'meta_description' => $title.",".$title,
                            'meta_keyword' => $title.",".$title,
                            'created_time' => date('Y-m-d H:i:s',strtotime("11/01/2017")),
                            'updated_time' => date('Y-m-d H:i:s',strtotime("11/01/2017"))
                        ];
                        $checkHref = $this->_edu->checkHref($linksp);
                        if (empty($checkHref)) {
                            $thumb = $slug.'-pd.jpg';
                            $dir  = MEDIA_PATH.'edu/'. $thumb.'';
                            //copy($thumbnail, $dir);
                            $param_store['thumbnail'] = '/edu/'.$thumb;

                            $id = $this->_edu->save($param_store);
                            $this->save_category($id, [$idcate,1]);

                            echo "Thêm $title ở trang số"."/{$i}"."<br/>";
                            // echo $linksp."/{$page}"."<br/>";

                        }else{
                            echo "Đã tồn tại $title <br/>";
                        }

                        $crawler3->clear();

                    }//foreach($ob2

                    $crawler2->clear(); 
                    //echo "hết page số {$i}"."ở danh mục {$linkdanhmuc}"."<br/>";
                }//for $page
                $crawler2->clear(); 
            }//if($idcate)

        }//foreach($ob1 as $value){
            $crawler1->clear(); 
    }//if(!empty($ob1)){
}

public function unica2()
{
    $crawler2 = file_get_html("https://unica.vn/course/nhiep-anh-dung-phim");
   $linkdanhmuc = "https://unica.vn/course/nhiep-anh-dung-phim";
    $dem = 0;
    set_time_limit(0);

                $numberItem = count($crawler2->find("span#total-course"))? $crawler2->find("span#total-course",0)->text() :'';
                if(!empty($numberItem)){
                    $page = ceil((int)$numberItem / 20);
                }else{
                    $page = 1;
                }
                
                for($i =1; $i <= $page;$i++){//số trang
                    $crawler2 = file_get_html($linkdanhmuc."?page={$i}");
                    
                    $ob2 = $crawler2->find(".list-course .form-group");
                    foreach($ob2 as $value2){
                        $linksp = $this->_domain.$value2->find("a.course-box-slider",0)->href;
                        $thumbnail = $value2->find(".img-course img",0)->src;
                        echo $dem++;
                        //lấy chi tiết bài viết
                        
                        $crawler3 = file_get_html($linksp);
                        
                        $title = count($crawler3->find('.u-detail-block-title h1 span')) ? $crawler3->find('.u-detail-block-title h1 span',0)->text() : '';
                        $slug = $this->toSlug($title);
                        $description = $crawler3->find(".u-detail-desc",0)->text();
                        $content1 = count($crawler3->find(".u-learn-what")) ? preg_replace('/unica/i','pd',$crawler3->find(".u-learn-what",0)->outertext()) : '';
                        $content2 = count($crawler3->find("div#u-des-course")) ? preg_replace('/unica/i','pd',$crawler3->find("div#u-des-course",0)->text()) : '';
                        $teacher = count($crawler3->find(".uct-right")) ? preg_replace('/unica/i','pd',$crawler3->find(".uct-right",0)->text()) : '';
                        $content3 = count($crawler3->find("div.panel-collapse .col")) ? $crawler3->find("div.panel-collapse .col") : '';
                        $listbaihoc = [];
                        if(!empty($content3)){
                            foreach($content3 as $value3){
                                $listbaihoc[] = ['name'=>trim($value3->find(".title a",0)->text()),'time'=>trim($value3->find(".time",0)->text())];
                            }
                        }
                        
                        if(!empty($listbaihoc)){
                            $listbaihoc = json_encode($listbaihoc);
                        }
                        $text_price_sale = count($crawler3->find('.big-price')) ? $crawler3->find('.big-price')[0]->text() : 0;
                        $price = (int)preg_replace('/[^0-9]/', '', $text_price_sale);
                        $price_sale = 50000;
                        $param_store = [
                            'title' => $title,
                            'price' => $price,
                            'slug' => $slug,
                            'crawler_href' => $linksp,
                            'price_sale' => $price_sale,
                            'content' => $content1."<br/>".$content2,
                            'teacher' =>$teacher,
                            'listdrive' => $listbaihoc,
                            'description' => $title.",".$title,
                            'code' => 'edu'.rand(1,1000),
                            'meta_title' => $title.",".$title,
                            'meta_description' => $title.",".$title,
                            'meta_keyword' => $title.",".$title,
                            'created_time' => date('Y-m-d H:i:s',strtotime("11/01/2017")),
                            'updated_time' => date('Y-m-d H:i:s',strtotime("11/01/2017"))
                        ];
                        $checkHref = $this->_edu->checkHref($linksp);
                        if (empty($checkHref)) {
                            $thumb = $slug.'-pd.jpg';
                            $dir  = MEDIA_PATH.'edu/edu2/'. $thumb.'';
                            copy($thumbnail, $dir);
                            $param_store['thumbnail'] = '/edu/edu2/'.$thumb;

                            $id = $this->_edu->save($param_store);
                            $this->save_category($id, [13,1]);

                            echo "Thêm $title ở trang số"."/{$i}"."<br/>";
                            // echo $linksp."/{$page}"."<br/>";

                        }else{
                            echo "Đã tồn tại $title <br/>";
                        }

                        $crawler3->clear();

                    }//foreach($ob2

                    $crawler2->clear(); 
                    //echo "hết page số {$i}"."ở danh mục {$linkdanhmuc}"."<br/>";
                }//for $page
}

/*
chuyển đổi link với name của khóa học drive rồi update. giờ dùng ở admin rồi nên bỏ
 */
public function getListDrive()
{
    $this->checkRequestPostAjax();
    $id_itemedu = $this->input->post('id_itemedu') ? $this->input->post('id_itemedu') : "";
    $obj2 = $this->input->post('obj2');
    $title_itemedu = $this->input->post('title_itemedu');
    if(!empty($obj2)){
        foreach($obj2 as $item){

            $idvideo = str_replace("https://drive.google.com/file/d/","",$item[1]);
            $idvideo = explode("/",$idvideo);
            $namevideo = $item[0];
            $pos = strpos($namevideo,"(");
            if($pos){
                $namevideo = substr_replace($namevideo,"",$pos);
            }
            $linkvideo = str_replace("usp=drivesdk", "usp=pdusoft", $item[1]);
            $data[] = [
                "name" => str_replace("Bản sao của","",$namevideo),
                "link" => $linkvideo,
                "id" => $idvideo[0]
            ];
        }//foreach
       
        if($id_itemedu){
            //update
            $dataupdate = [
                "listdrive" => json_encode($data),
                "type" => 1,
                "crawler_href2" =>$data[0]['link']
            ];
           //$this->_edu->update(['id'=>(int)$id_itemedu],$dataupdate);  
            $_message = "update thành công"; 
        }else{
            //insert
            $datainsert = [
                "title" => $title_itemedu,
                "slug" => $this->toSlug($title_itemedu),
                'description' => $title_itemedu.",".$title_itemedu,
                'meta_title' => $title_itemedu.",".$title_itemedu,
                'meta_description' => $title_itemedu.",".$title_itemedu,
                'meta_keyword' => $title_itemedu.",".$title_itemedu,
                "content" =>$title_itemedu.",".$title_itemedu,
                "listdrive" => json_encode($data),
                "type" => 1,//đủ cả youtube và drive là 2, thiếu là 1
                "crawler_href2" =>$data[0]['link'],
                "price" => 50000,
                "price_sale" => 50000
            ];
            //$id = $this->_edu->save($datainsert); 
            $_message = "thành công"; 
        }

        $data['listvd'] = $data;
            $html = $this->load->view('public/default/crawler/ajax_listyoutube', $data, TRUE);
            $data_mess = [
                'message' => $_message,
                'type' => 'success',
                'html' => $html
            ];
            die(json_encode($data_mess));
    }

    
}
public function getListYoutube()
{
    $this->checkRequestGetAjax();
    $titlelist = $this->input->get("title");
    $idcate = $this->input->get("idcate");
    $search = $this->input->get("q") ?  trim($this->input->get("q")) : "";
    
    if(!empty($search)){
        if(strpos($search, "youtube.com") == false){
            $data_mess = [
                'message' => 'url của bạn không phải của youtube',
                'type' => 'error'
            ];
            die(json_encode($data_mess));
        }else{
            //
            $checkHref = $this->_edu->checkHref($search);
            if (empty($checkHref)) {
                $dataAPI = $this->callCURL("https://api.youtubemultidownloader.com/playlist?url={$search}&nextPageToken=",'','get');
                
                $datayt = json_decode($dataAPI);
                
                if($datayt->status){//có tồn tại link
                    $data = [];
                    foreach($datayt->items as $item){
                        $data[] = [
                            "name" => $item->title,
                            "link" => $item->url,
                            "id" => $item->id,
                            "time" => round($item->duration / 60,1),
                            "thumbnail" => $item->thumbnails,
                        ];
                    }
                    if(!empty($data)){
                        //sort
                        usort($data, function($a,$b){
                           preg_match_all('!\d+!', $a['name'], $matches);
                           preg_match_all('!\d+!', $b['name'], $matches2);
                           if(!empty($matches[0]) && !empty($matches2[0])){
                            $a = (int)$matches[0][0];
                            $b = (int)$matches2[0][0];
                               return ($a<$b)?-1:1;//nếu $a < $b thì không cần sort, và ngược lại
                           }else{
                             return 1;//nên có nút bật tắt sort, cái nào không có số thì tắt bỏ sort
                           }
                            
                        });
                        
                        $datainsert = [
                            "title" => $titlelist,
                            "thumbnail" => $data[0]['thumbnail'],
                            "slug" => $this->toSlug($titlelist),
                            'description' => $titlelist.",".$titlelist,
                            'meta_title' => $titlelist.",".$titlelist,
                            'meta_description' => $titlelist.",".$titlelist,
                            'meta_keyword' => $titlelist.",".$titlelist,
                            "content" =>$titlelist.",".$titlelist,
                            "listyoutube" => json_encode($data),
                            "type" => 0,
                            "crawler_href" =>$search,
                            "price" => 50000,
                            "price_sale" => 50000,
                            "category_id" => $idcate
                        ];
                        //$id = $this->_edu->save($datainsert);
                        if(!empty($idcate)){
                           
                            //$this->save_category($id, $idcate);
                        }
                    }
                }else{
                    $data_mess = [
                        'message' => 'url của bạn không phải của youtube',
                        'type' => 'error'
                    ];
                    die(json_encode($data_mess));
                }
                
            }else{
                // echo "link đã tồn tại trên hệ thống";
                $data = $this->_edu->getByField('crawler_href',$search);
                $data = json_decode($data->listyoutube,true);
            }
            $data['listvd'] = $data;
            $data['linklist'] = $search;
            $html = $this->load->view('public/default/crawler/ajax_listyoutube', $data, TRUE);
            $data_mess = [
                'message' => 'Thành công',
                'type' => 'success',
                'html' => $html
            ];
            die(json_encode($data_mess));
            
        }
        // returnJsonData
        
        
    }//if(!empty($search)
}
 
private function save_category($id, $category_id) {
    if (!empty($category_id)) {
        $this->_edu->delete(['edu_id'=>$id],'edu_category');
        // $data_category[] = ["edu_id" => $id, 'category_id' => $category_id];
        if(!empty($category_id)) foreach ($category_id as $category_idx){
            $tmp = ["edu_id" => $id, 'category_id' => $category_idx];
            $data_category[] = $tmp;
        }

        if(!$this->_edu->insertMultiple($data_category, 'edu_category')){
            $message['type'] = 'error';
            $message['message'] = "Thêm edu_category thất bại !";
            log_message('error', $message['message'] . '=>' . json_encode($data_category));
        }
    }

}   


}//endproductpdu

