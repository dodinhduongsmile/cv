<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

if (!function_exists('getImageThumb')) {
    function getImageThumb($image = '',$width = '',$height= '',$crop = true){
        $_this = & get_instance();
        if(empty($image)) {
            return base_url()."public/default-thumbnail.png";
        }
        if($crop == false || empty($width)) {
            return base_url('public/media').$image;
        }
        $image = trim($image);
        $imageOrigin = MEDIA_PATH."/".$image;
        $sizeText = sprintf('-%dx%d', $width, $height);
        $ext = pathinfo($image,PATHINFO_EXTENSION);
        $newImage = str_replace(".$ext","$sizeText.$ext", $image);
        $pathThumb = MEDIA_PATH .'/thumb/'. $newImage;
        $pathThumb = str_replace('//','/',$pathThumb);

        if(!file_exists($pathThumb)){
            try {
                if(!is_dir(dirname($pathThumb))){
                    mkdir(dirname($pathThumb), 0755, TRUE);
                }
                // import the Intervention Image Manager Class
                // configure with favored image driver (gd by default)
                Image::configure(array('driver' => 'gd'));
    
                // and you are ready to go ...
                if (intval($width) > 0 && intval($height) > 0) {
                    $image = Image::make($imageOrigin)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $image = Image::make($imageOrigin);
                }
                $image->save($pathThumb);
            }
            catch (Exception $e) {
            }
        }

        $thumbnail_new = MEDIA_URL . str_replace('//', '/', 'thumb/'. $newImage);
        return $thumbnail_new.'?v=1';
    }
}


if (!function_exists('getThumbnail')) {
    function getThumbnail($data,$width = '',$height= '',$class='',$crop=true){
        $_this =& get_instance();
        $data = '<img class="lazyloadpd '.$class.'" src="'.$_this->templates_assets.'dot.jpg" data-src="'.getImageThumb($data->thumbnail,$width,$height,$crop).'" alt="'.$data->title.'" title="'.$data->title.'"/>' ;
        echo $data;
    }
}
if (!function_exists('getThumbnailnoajax')) {
    function getThumbnailnoajax($thumbnail,$width = '',$height= '',$crop=true){
        $data = getImageThumb($thumbnail,$width,$height,$crop);
        echo $data;
    }
}

if (!function_exists('getAvatar')) {
    function getAvatar($data,$width = '',$height= '',$class='',$crop=true){
        $_this =& get_instance();
        $data = '<img class="lazyloadpd '.$class.'" src="'.$_this->templates_assets.'dot.jpg" data-src="'.getImageThumb($data->avatar,$width,$height,$crop).'" alt="'.$data->fullname.'"/>' ;
        echo $data;
    }
}

if (!function_exists('getThumbnailStatic')) {
    function getThumbnailStatic($thumbnail,$alt='',$class=''){
        $_this = & get_instance();
        $data = '<img class="lazyloadpd '.$class.'" src="'.$_this->templates_assets.'dot.jpg" data-src="'.MEDIA_URL.$thumbnail.'" alt="'.$alt.'"/>';
        echo $data;
    }
}

if (!function_exists('getImage')) {
    function getImage($thumbnail,$alt='',$width = '',$height= '',$class='',$crop=false){
        $_this =& get_instance();
        $data = '<img class="lazyloadpd '.$class.'" src="'.$_this->templates_assets.'dot.jpg" data-src="'.getImageThumb($thumbnail,$width,$height,$crop).'" alt="'.$alt.'"/>' ;
        echo $data;
    }
}

if (!function_exists('getPathThumb')) {
    function getPathThumb($path){
        /*get path thumb user*/
        $name_file = pathinfo($path, PATHINFO_FILENAME);
        $pathnew = str_replace($name_file, $name_file."_thumb", $path);
        return $pathnew;
    }
}