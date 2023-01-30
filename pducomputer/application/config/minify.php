<?php
/**
 * Minify config Class
 *
 * PHP Version 5.3
 *
 * @category  PHP
 * @package   Controller
 * @author    Slawomir Jasinski <slav123@gmail.com>
 * @copyright 2015 All Rights Reserved SpiderSoft
 * @license   Copyright 2015 All Rights Reserved SpiderSoft
 * @link      http://www.spidersoft.com.au/projects/codeigniter-minify/
 */

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Minify config file
 *
 * @category  PHP
 * @package   Controller
 * @author    Slawomir Jasinski <slav123@gmail.com>
 * @copyright 2015 All Rights Reserved SpiderSoft
 * @license   Copyright 2015 All Rights Reserved SpiderSoft
 * @link      http://www.spidersoft.com.au/projects/codeigniter-minify/
 */

// output path where the compiled files will be stored (default value: 'assets')
$config['assets_dir'] = 'public';

// optional - path where the compiled css files will be stored (default value: '' - for backward compatibility)
$config['assets_dir_css'] = 'public/css';

// optional - path where the compiled js files will be stored (default value: '' - for backward compatibility)
$config['assets_dir_js'] = 'public/js';

// where to look for css files (default value: 'assets/css')
$config['css_dir'] = 'public/css';

// where to look for js files (default value: 'assets/js')
$config['js_dir'] = 'public/js';

// default file name for css (default value: 'style.css')
$config['css_file'] = 'style_minified.min.css';

// default file name for js (default value: 'scripts.js')
$config['js_file'] = 'script_minified.min.js';

// default tag for css (default value: '<link href="%s" rel="stylesheet" type="text/css" />')
$config['css_tag'] = '<link href="%s" rel="stylesheet" type="text/css" />';

// default tag for js (default value: '<script type="text/javascript" src="%s"></script>')
$config['js_tag'] = '<script type="text/javascript" src="%s"></script>';

// use html tags on output and return as a string (default value: 'TRUE')
// if html_tags === FALSE - array with links to assets is returned
$config['html_tags'] = TRUE;

// use automatic file names (default value: 'FALSE')
$config['auto_names'] = TRUE;

// use to enable versioning your assets (default value: 'FALSE')
$config['versioning'] = TRUE;

// automatically deploy when there are any changes in files (default value: 'TRUE')
$config['deploy_on_change'] = TRUE;

// compress files or not (default value: 'TRUE')
$config['compress'] = TRUE;

// compression engine setting (default values: 'minify' and 'closurecompiler')
$config['compression_engine'] = array(
    'css' => 'minify', // minify || cssmin
    'js'  => 'jsmin' // closurecompiler || jsmin || jsminplus
);

// when you use closurecompiler as compression engine you can choose compression level (default value: 'SIMPLE_OPTIMIZATIONS')
// avaliable options: "WHITESPACE_ONLY", "SIMPLE_OPTIMIZATIONS" or "ADVANCED_OPTIMIZATIONS"
$config['closurecompiler']['compilation_level'] = 'SIMPLE_OPTIMIZATIONS';


// End of file minify.php
// Location: ./application/config/minify.php
