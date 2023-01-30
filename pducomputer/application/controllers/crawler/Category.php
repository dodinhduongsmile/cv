<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Symfony\Component\DomCrawler\Crawler;


class Category extends Crawler_Controller
{
    private $_category; 
    private $_product; 
    private $_domain; 
     
    public function __construct(){ 
        parent::__construct();
        $this->load->model(['category_model','product_model']);
        $this->_category     = new Category_model();
        $this->_product      = new Product_model();

        $this->_domain       = 'http://nicemetics.com/';
    } 

	public function index() {
        $html = $this->curl_html("http://nicemetics.com/");
        $crawler = new Crawler($html);
        $crawler->filter('.site_center .ks_left_box')->eq(1)->filter('.left_menu_2')->each(function ($node) {
            $title = $node->filter('a')->text();
            $href  = $node->filter('a')->attr('href');
            $text_slug  = str_replace('.html', '', $href);
            $ex_slug = explode('_', $text_slug);

            $data_detail = $this->detail_type($this->_domain.$href);

            $param_store = [
                'id' => str_replace('pd', '', $ex_slug[0]),
                'title' => $title,
                'type' => 'product',
                'slug' => $ex_slug[1],
                'crawler_href' => $this->_domain.$href,
                'meta_title' => $data_detail['meta_title'],
                'meta_description' => $data_detail['meta_description'],
                'meta_keyword' => $data_detail['meta_keyword'],
                'content' => $data_detail['content']
            ];
            $checkHref = $this->_category->checkHref($this->_domain.$href);
            if (empty($checkHref)) {
                $this->_category->save($param_store);
                echo "insert data $title \n";
            }
        });

        echo 'Done !!!';
	}

    public function detail_type($href)
    {
        $html_detail = $this->curl_html($href);
        $crawler = new Crawler($html_detail);

        $content = $crawler->filter('.list_tin_td1')->html();
        $title         = $crawler->filter('title')->text();
        $description   = $crawler->filter('meta[name="description"]')->attr('content');
        $keyword       = $crawler->filter('meta[name="keywords"]')->attr('content');
        
        $data_store = [
            'meta_title' => $title,
            'content' => $content,
            'meta_description' => $description,
            'meta_keyword' => $keyword
        ];

        return $data_store;
    }

}

