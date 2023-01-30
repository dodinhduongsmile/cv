<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Symfony\Component\DomCrawler\Crawler;

class Product extends Crawler_Controller
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

        $this->_domain       = 'https://ketsatgiadinh.vn/';
    } 

    public function convert_data()
    {
        $data = $this->_product->getData(['limit'=>1000]);
        $i = 1;
        if (!empty($data)) foreach ($data as $key => $value) {
            $day = $i++;
            $param_store['created_time'] = date('2019-m-d H:i:s',strtotime("+$day hours"));
            $param_store['updated_time'] = date('2019-m-d H:i:s',strtotime("+$day hours"));
            $this->_product->update(['id'=>$value->id],$param_store);
        }
        echo "Done";
    }
    public function deletedata()
    {
        $this->db->truncate('product');
        echo "xóa hết xong";
    }
    public function attribute()
    {
        $attr = '{"nha_san_xuat":{"value":"","name":"Nh\u00e0 s\u1ea3n xu\u1ea5t","key":""},"dung_luong_ram":{"value":"","name":"dung l\u01b0\u1ee3ng ram","key":""},"loai_ram":{"value":"","name":"Lo\u1ea1i ram","key":""},"so_khe_cam_ram":{"value":"","name":"S\u1ed1 khe c\u1eafm ram","key":""},"dung_luong_toi_da_ram":{"value":"","name":"Dung l\u01b0\u1ee3ng t\u1ed1i \u0111a Ram","key":""},"socket":{"value":"","name":"SOCKET","key":""},"loai_o_cung":{"value":"","name":"lo\u1ea1i \u1ed5 c\u1ee9ng","key":""},"dung_luong_o_cung":{"value":"","name":"Dung l\u01b0\u1ee3ng \u1ed5 c\u1ee9ng","key":""},"toc_do_o_cung":{"value":"","name":"T\u1ed1c \u0111\u1ed9 \u1ed5 c\u1ee9ng","key":""},"do_rong_man_hinh":{"value":"","name":"\u0111\u1ed9 r\u1ed9ng m\u00e0n h\u00ecnh","key":""},"do_phan_giai_man_hinh":{"value":"","name":"\u0110\u1ed9 ph\u00e2n gi\u1ea3i m\u00e0n h\u00ecnh","key":""},"vi_xu_ly_cpu":{"value":"","name":"Vi x\u1eed l\u00fd CPU","key":""},"nhu_cau_su_dung":{"value":"","name":"Nhu c\u1ea7u s\u1eed d\u1ee5ng","key":""},"ten_vga_roi":{"value":"","name":"T\u00ean VGA r\u1eddi","key":""},"bo_nho_vga":{"value":"","name":"b\u1ed9 nh\u1edb vga","key":""},"cong_xuat_nguon_pc":{"value":"","name":"C\u00f4ng xu\u1ea5t ngu\u1ed3n pc","key":""},"mau_vo_case_pc":{"value":"","name":"M\u00e0u v\u1ecf case pc","key":""},"chat_lieu_vo_case_pc":{"value":"","name":"Ch\u1ea5t li\u1ec7u v\u1ecf case pc","key":""},"model":{"value":"","name":"Model, m\u00e3 m\u00e1y"},"chi_tiet_cpu":{"value":"","name":"Th\u00f4ng s\u1ed1 chi ti\u1ebft cpu"},"chi_tiet_vga":{"value":"","name":"Th\u00f4ng s\u1ed1 chi ti\u1ebft VGA, GPU"},"chipset":{"value":"","name":"Chipset"},"lan":{"value":"Chu\u1ea9n 10\/100\/1000 Mbps Ethernet LAN","name":"Giao Ti\u1ebfp M\u1ea1ng LAN"},"battery":{"value":"","name":"PIN\/Battery"},"he_dieu_hanh":{"value":"","name":"OS - H\u1ec7 \u0111i\u1ec1u h\u00e0nh"},"o_dia_quang":{"value":"C\u00f3 (\u0111\u1ecdc, ghi d\u1eef li\u1ec7u)","name":"\u1ed4 \u0111\u0129a quang CD\/DVD"},"can_nang":{"value":"","name":"C\u00e2n n\u1eb7ng"},"kich_thuoc":{"value":"","name":"\u00edch th\u01b0\u1edbc"},"mau_vo":{"value":"","name":"M\u00e0u V\u1ecf"},"more":{"value":"4 x USB 3.0, HDMI (K\u1ebeT N\u1ed0I TIVI, M\u00c1Y CHI\u1ebeU...VV...),LAN (RJ45), VGA - K\u1ebeT N\u1ed0I M\u00c1Y CHI\u1ebeU, T\u00cdCH H\u1ee2P MICROPHONE - HEADPHONE, Camera, Bluetooth","name":"C\u1ed5ng Giao Ti\u1ebfp & T\u00ednh N\u0103ng M\u1edf R\u1ed9ng"},"video_baotri":{"value":"","name":"Video h\u01b0\u1edbng d\u1eabn b\u1ea3o d\u01b0\u1ee1ng"}}';
        return $attr;
    }
    //crawler danh mục tcc
	public function indextcc($page=1) {
        
        // $totalpage = 11;//sửa dòng 114,94 cho phù hợp
        // for($page = 1; $page<= $totalpage; $page++){



        $html = $this->curl_html("https://laptoptcc.com/danh-muc/laptop-dell/page/8/");
        $crawler = new Crawler($html);
        set_time_limit(0);
        //danhmuc
        $crawler->filter('ul.products.columns-4')->filter('li')->each(function ($node) {//danh mục
            $link_item = $node->filter('a.woocommerce-LoopProduct-link.woocommerce-loop-product__link')->attr('href');
            //detail
            $crawler2 = new Crawler($this->curl_html($link_item));
            if ($crawler2->filter('a.woocommerce-main-image.zoom img')->count() > 0) {
               
                $thumbnail   = $crawler2->filter('a.woocommerce-main-image.zoom img')->eq(0)->attr('src');
                $href  = $link_item;
                $title = str_replace('tcc','pdu',$crawler2->filter('h1.product_title.entry-title')->text());
                $text_price_sale = $crawler2->filter('.entry-summary ins .woocommerce-Price-amount')->count() > 0 ? $crawler2->filter('.entry-summary ins .woocommerce-Price-amount bdi')->text() : '';
                $slug = $this->toSlug($title);

                $price_sale = (int)preg_replace('/[^0-9]/', '', $text_price_sale)-1500000;
                $price = (int)$price_sale + 1000000;

                 $content = $crawler2->filter('.electro-description table')->count() > 0 ? $crawler2->filter('.electro-description table')->eq(0)->html() : '';
                $data_album = $crawler2->filter('.electro-description img')->each(function ($node) {
                    $img = $node->attr('src');
                    return $img;
                });
                if (!empty($data_album) && count($data_album) > 1) foreach ($data_album as $key => $value) {
                    if ($key > 0) {
                        $thumb = $slug.'-pducomputer-'.$key.'.jpg';
                        $dir  = MEDIA_PATH.'product/'. $thumb.'';
                        copy($value, $dir);
                        $thumb_arr[] = '/product/'.$thumb;
                    }
                }
                $album = count($data_album) > 1 ? array_unique($thumb_arr) : '';
                $param_store = [
                    'title' => $title,
                    'price' => $price,
                    'slug' => $slug,
                    'crawler_href' => $href,
                    'price_sale' => $price_sale,
                    'content' => $title."<br/>".$content,
                    'description' => $title."<br/>".$title,
                    'album' => !empty($album) ? json_encode($album) : '',
                    'product_type_id' => 1,//dell=1
                    'code' => "tc".rand(10,1000),
                    'quality' => 1,
                    'layout' => "laptop",
                    'attribute' => $this->attribute(),
                    'guarantee' => "12 tháng",
                    'meta_title' => $title."<br/>".$title,
                    'meta_description' => $title."<br/>".$title,
                    'meta_keyword' => $title."<br/>".$title,
                    'created_time' => date('Y-m-d H:i:s',strtotime("11/01/2017")),
                    'updated_time' => date('Y-m-d H:i:s',strtotime("11/01/2017"))
                ];
                $checkHref = $this->_product->checkHref($href);
                if (empty($checkHref)) {
                    $thumb = $slug.'-pducomputer-laptoppdu.jpg';
                    $dir  = MEDIA_PATH.'product/'. $thumb.'';
                    copy($thumbnail, $dir);
                    $param_store['thumbnail'] = '/product/'.$thumb;

                    $id = $this->_product->save($param_store);
                    $this->save_category($id, 107);//017=laptopdell | hp-106 | lenlovo-115 | asus-116, acer-117 | sony-118

                    echo "Thêm $title \n";
                }else{
                    echo "Đã tồn tại $title \n";
                }
                
                
            }else{
                echo "lỗi link".$link_item;
            }

            // if($i == 2){dd();}
        });//end danhmuc
    // };//endfor
        echo "chưa vào được loop";
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

    //crawler data sản phẩm
    public function index2($page = 1)
    {
        $html = $this->curl_html("https://ketsatgiadinh.vn/pa_ket-qua-tim-kiem.html?curPg=$page");
        $crawler = new Crawler($html);
        $crawler->filter('.site_center .center_box table')->eq(1)->filter('td')->each(function ($node) {
            if ($node->filter('.qc_home_img img')->count() > 0) {
                $img   = str_replace('small_', 'large_', $node->filter('.qc_home_img img')->attr('src'));
                $href  = $node->filter('.qc_home_img a')->attr('href');
                $title = $node->filter('.qc_home_title a')->text();
                $text_price = $node->filter('.qc_home_price_1')->count() > 0 ? $node->filter('.qc_home_price_1 strike')->text() : '';
                $text_price_sale = $node->filter('.qc_home_price[align="center"]')->count() > 0 ? $node->filter('.qc_home_price[align="center"]')->text() : '';

                $price = preg_replace('/[^0-9]/', '', $text_price);
                $price_sale = preg_replace('/[^0-9]/', '', $text_price_sale);

                $detail_product = $this->detail_product($this->_domain.$href);
                $text_slug = $this->toSlug(str_replace('.html', '', $href));
                $ex_slug = explode('_', $text_slug);
                $data_id = $detail_product['data_id'];
                $param_store = [
                    'id' => str_replace('pc', '', $ex_slug[0]),
                    'title' => $title,
                    'price' => $price,
                    'slug' => $ex_slug[1],
                    'crawler_href' => $this->_domain.$href,
                    'price_sale' => $price_sale,
                    'content' => $detail_product['content'],
                    'album' => $detail_product['album'],
                    'product_type_id' => !empty($detail_product['product_type_id']) ? $detail_product['product_type_id'] : '',
                    'code' => $detail_product['code'],
                    'viewed' => $detail_product['viewed'],
                    'quality' => $detail_product['quality'],
                    'guarantee' => $detail_product['guarantee'],
                    'meta_title' => $detail_product['meta_title'],
                    'meta_description' => $detail_product['meta_description'],
                    'meta_keyword' => $detail_product['meta_keyword'],
                    'size' => $detail_product['size'],
                    'mass' => $detail_product['mass'],
                    'created_time' => date('Y-m-d H:i:s',strtotime("+$data_id hours")),
                    'updated_time' => date('Y-m-d H:i:s',strtotime("+$data_id hours"))
                ];
                $checkHref = $this->_product->checkHref($this->_domain.$href);
                if (empty($checkHref)) {
                    $thumb = md5($img).'.jpg';
                    $dir  = MEDIA_PATH.'product/'. $thumb.'';
                    copy($img, $dir);
                    $param_store['thumbnail'] = '/product/'.$thumb;

                    $id = $this->_product->save($param_store);
                    $this->save_category($id, $detail_product['category_id']);

                    echo "Thêm $title \n";
                }else{
                    echo "Đã tồn tại $title \n";
                }
            }

        });
        $page++;
        if ($page == 19) {
            die('Done !!!');
        }else{
            $this->index2($page);
        }
        echo 'Done !!!';
    }

    private function save_category($id, $category_id) {
        if (!empty($category_id)) {
            $this->_product->delete(['product_id'=>$id],'product_category');
            $data_category[] = ["product_id" => $id, 'category_id' => $category_id];
            if(!$this->_product->insertMultiple($data_category, 'product_category')){
                $message['type'] = 'error';
                $message['message'] = "Thêm product_category thất bại !";
                log_message('error', $message['message'] . '=>' . json_encode($data_category));
            }
        }

    }

    public function detail_product($href)
    {
        $thumb_arr = [];
        $html_detail = $this->curl_html($href);
        $crawler = new Crawler($html_detail);

        $data_album = $crawler->filter('.center_content table td')->eq(0)->filter('a')->each(function ($node) {
            $img = str_replace('small_', 'large_',$node->filter('img')->attr('src'));
            return $img;
        });

        $dom_main = $crawler->filter('.center_content .center_box')->eq(0);
        $data_id  = preg_replace('/[^0-9]/', '', $dom_main->filterXPath('//a[contains(@title, "Chọn in báo giá")]')->attr('href'));
        $text_code    = $dom_main->filterXPath('//div[contains(text(), "Mã sản phẩm:")]')->text();
        $text_size    = $dom_main->filterXPath('//div[contains(text(), "Kích thước:")]')->count() > 0 ? $dom_main->filterXPath('//div[contains(text(), "Kích thước:")]')->text() : '';
        $text_mass    = $dom_main->filterXPath('//div[contains(text(), "Trọng lượng:")]')->count() > 0 ? $dom_main->filterXPath('//div[contains(text(), "Trọng lượng:")]')->text() : '';
        $text_viewed  = $dom_main->filterXPath('//div[contains(text(), "Lượt xem:")]')->text();
        $text_guarantee  = $dom_main->filterXPath('//div[contains(text(), "Bảo hành:")]')->count() > 0 ? $dom_main->filterXPath('//div[contains(text(), "Bảo hành:")]')->text() : '';
        $text_quality = $dom_main->filterXPath('//div[contains(text(), "Tình trạng:")]')->count() > 0 ? $dom_main->filterXPath('//div[contains(text(), "Tình trạng:")]')->text() : '';
        $qt = !empty($text_quality) ? str_replace('Tình trạng: ', '', $text_quality) : '';

        $text_category = $dom_main->filterXPath('//div[contains(text(), "Thương hiệu:")]')->filter('a')->count() > 0 ? $dom_main->filterXPath('//div[contains(text(), "Thương hiệu:")]')->filter('a')->text() : '';
        $data_category = !empty($text_category) ? $this->_category->getByField('title',$text_category,'id,title') : '';
        
        $text_product_type = $dom_main->filterXPath('//div[contains(text(), "Loại sản phẩm:")]')->filter('a')->count() > 0 ? $dom_main->filterXPath('//div[contains(text(), "Loại sản phẩm:")]')->filter('a')->text() : '';

        $data_product_type = !empty($text_product_type) ? $this->_product_type->getByField('title',$text_product_type,'id,title') : '';

        $content = $crawler->filter('.center_content table tr')->eq(1)->html();

        $meta_description   = $crawler->filter('meta[name="description"]')->attr('content');
        $meta_keyword       = $crawler->filter('meta[name="keywords"]')->attr('content');
        $meta_title         = $crawler->filter('title')->text();

        if (!empty($data_album) && count($data_album) > 1) foreach ($data_album as $key => $value) {
            if ($key > 0) {
                $thumb = md5($value).'.jpg';
                $dir  = MEDIA_PATH.'product/'. $thumb.'';
                copy($value, $dir);
                $thumb_arr[] = '/product/'.$thumb;
            }
        }
        $album = count($data_album) > 1 ? array_unique($thumb_arr) : '';
        $param_store = [
            'album' => !empty($album) ? json_encode($album) : '',
            'content' => $content,
            'size' => !empty($text_size) ? str_replace('Kích thước: ', '', $text_size) : '',
            'mass' => !empty($text_mass) ? str_replace('Trọng lượng: ', '', $text_mass) : '',
            'meta_description' => $meta_description,
            'meta_keyword' => $meta_keyword,
            'meta_title' => $meta_title,
            'category_id' => !empty($data_category) ? $data_category->id : '',
            'product_type_id' => !empty($data_product_type) ? $data_product_type->id : '',
            'code' => !empty($text_code) ? str_replace('Mã sản phẩm: ', '', $text_code) : '',
            'viewed' => !empty($text_viewed) ? str_replace('Lượt xem: ', '', $text_viewed) : 0,
            'quality' => $qt == 'Còn hàng' ? 1 : 0,
            'data_id' => $data_id,
            'guarantee' => !empty($text_guarantee) ? str_replace('Bảo hành: ', '', $text_guarantee) : '',
        ];
        return $param_store;
    }


    // crawler content


    public function content_product()
    {
        $data_product = $this->_product->getData(['limit'=>1000]);
        if (!empty($data_product)) foreach ($data_product as $key => $value) {
            $html_detail = $this->curl_html($value->crawler_href);
            $crawler = new Crawler($html_detail);

            $html_content = $crawler->filter('.content_table')->html();

            $content  = $crawler->filter('.center_content table tr')->eq(1)->html();
            $content1 = explode('SẢN PHẨM ĐƯỢC PHÂN PHỐI BỞI:', $html_content);

            $data_content = $content.$content1[0].'</strong></p>';
            $this->_product->update(['id'=>$value->id],['content'=>$data_content]);
            echo "update product $value->title \n";
            $data_content = $content1 = $content = $html_content = null;
        }
        
        echo "Done";
    }
}

