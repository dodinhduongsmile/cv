<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Symfony\Component\DomCrawler\Crawler;

class Post extends Crawler_Controller
{
    private $_category; 
    private $_post; 
    private $_domain; 
    private $_html; 
     
    public function __construct(){ 
        parent::__construct();
        $this->load->model(['category_model','product_model','post_model']);
        $this->_category     = new Category_model();
        $this->_post         = new Post_model();

        $this->_domain       = 'https://nicemetics.vn/';
        $this->_html         = '';
    } 

	public function index($page=21) {
        $html = $this->curl_html("https://nicemetics.vn/ac_tin-tuc.html?curPg=$page");
        $crawler = new Crawler($html);
        $crawler->filter('.center_box .list_tin1')->each(function ($node,$key) {
            $title = $node->filter('.list_tin_td1 a')->text();
            $img   = $node->filter('.list_tin_img1 img')->count() > 0 ? str_replace('small_', 'large_',$node->filter('.list_tin_img1 img')->attr('src')) : '';
            $href  = $node->filter('.list_tin_td1 a')->attr('href');
            $text_slug  = str_replace('.html', '', $href);
            $ex_slug = explode('_', $text_slug);

            $data_detail = $this->detail_type($this->_domain.$href);
            $param_store = [
                'title' => $title,
                'slug' => $ex_slug[1],
                'id' => str_replace('ad', '', $ex_slug[0]),
                'crawler_href' => $this->_domain.$href,
                'meta_title' => $data_detail['meta_title'],
                'meta_description' => $data_detail['meta_description'],
                'meta_keyword' => $data_detail['meta_keyword'],
                'content' => $data_detail['content'],
                'description' => $data_detail['description']
            ];
            $checkHref = $this->_post->checkHref($this->_domain.$href);
            if (empty($checkHref)) {
                if (!empty($img)) {
                    $thumb = md5($img).'.jpg';
                    $dir  = MEDIA_PATH.'post/'. $thumb.'';
                    copy($img, $dir);
                    $param_store['thumbnail'] = '/post/'.$thumb;
                }

                $id = $this->_post->save($param_store);
                $this->save_category($id, $data_detail['category_id']);
                echo "Thêm $title \n";
            }else{
                echo "Đã tồn tại $title \n";
            }
        });
        $page--;
        if ($page == 0) {
            die('Done !!!');
        }else{
            $this->index($page);
        }
        echo 'Done !!!';
	}

    public function detail_type($href)
    {
        $html_detail = $this->curl_html($href);
        $crawler = new Crawler($html_detail);
        $this->_html = '';
        $description  = $crawler->filter('.list_tin1 strong')->eq(0)->text();
        $crawler->filter('.list_tin1 :not(.list_tin_td1):not(h1):not(strong):not(.list_tin_img1)')->each(function ($node) {
            $this->_html.=$node->html();
        });

        $text_category = $crawler->filter('.center_tab_text a')->each(function ($node) {
            $text = $node->text();
            return $text;
        });

        if (!empty($text_category)) foreach ($text_category as $key => $value) {
            if ($value != 'Trang chủ' && $value != 'Tin tức') {
                $data_category = $this->_category->getByField('title',$value,'id,title');
                $category_id   = !empty($data_category) ? $data_category->id : '';
            }
        }

        $meta_title         = $crawler->filter('title')->text();
        $meta_description   = $crawler->filter('meta[name="description"]')->attr('content');
        $meta_keyword       = $crawler->filter('meta[name="keywords"]')->attr('content');
        
        $data_store = [
            'meta_title' => $meta_title,
            'content' => $this->_html,
            'category_id' => !empty($category_id) ? $category_id : '',
            'description' => $description,
            'meta_description' => $meta_description,
            'meta_keyword' => $meta_keyword
        ];

        return $data_store;
    }

    private function save_category($id, $category_id) {
        if (!empty($category_id)) {
            $this->_post->delete(['post_id'=>$id],'post_category');
            $data_category[] = ["post_id" => $id, 'category_id' => $category_id];
            if(!$this->_post->insertMultiple($data_category, 'post_category')){
                $message['type'] = 'error';
                $message['message'] = "Thêm post_category thất bại !";
                log_message('error', $message['message'] . '=>' . json_encode($data_category));
            }
        }

    }

}

