<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Breadcrumbs Class
 *
 * This class manages the breadcrumb object
 *
 * @package		Breadcrumb
 * @version		1.0
 * @author 		Buti <buti@nobuti.com>
 * @copyright 	Copyright (c) 2012, Buti
 * @link		https://github.com/nobuti/codeigniter-breadcrumb
 */
class Breadcrumbs {

    /**
     * Breadcrumbs stack
     *
     */
    private $breadcrumbs = array();
    protected $current_url;

    /**
     * Constructor
     *
     * @access	public
     *
     */
    public function __construct()
    {
        $this->ci =& get_instance();

        // Load config file
        $this->ci->load->config('breadcrumbs');

        // Get breadcrumbs display options
        $this->tag_open = $this->ci->config->item('tag_open');
        $this->tag_close = $this->ci->config->item('tag_close');
        $this->divider = $this->ci->config->item('divider');
        $this->crumb_open = $this->ci->config->item('crumb_open');
        $this->crumb_close = $this->ci->config->item('crumb_close');
        $this->crumb_last_open = $this->ci->config->item('crumb_last_open');
        $this->crumb_divider = $this->ci->config->item('crumb_divider');
        log_message('debug', "Breadcrumbs Class Initialized");
    }

    public function init($config){
        $this->tag_open = $config['tag_open'];
        $this->tag_close = $config['tag_close'];
        $this->divider = $config['crumb_divider'];
        $this->crumb_open = $config['crumb_open'];
        $this->crumb_close = $config['crumb_close'];
        $this->crumb_last_open = $config['crumb_last_open'];
        $this->crumb_divider = $config['crumb_divider'];
    }

    // --------------------------------------------------------------------

    /**
     * Append crumb to stack
     *
     * @access	public
     * @param	string $page
     * @param	string $href
     * @return	void
     */
    function push($page, $href)
    {
        // no page or href provided
        if (!$page OR !$href) return;

        // Prepend site url
        //$href = site_url($href);

        // push breadcrumb
        $this->breadcrumbs[$href] = array(
            'page' => $page,
            'href' => $href,
        );
    }

    // --------------------------------------------------------------------

    /**
     * Prepend crumb to stack
     *
     * @access	public
     * @param	string $page
     * @param	string $href
     * @return	void
     */
    function unshift($page, $href)
    {
        // no crumb provided
        if (!$page OR !$href) return;

        // Prepend site url
        //$href = site_url($href);

        // add at firts
        array_unshift($this->breadcrumbs, array(
                'page' => $page,
                'href' => $href,
            )
        );
    }

    // --------------------------------------------------------------------

    /**
     * Generate breadcrumb
     *
     * @access	public
     * @return	string
     */
    function show()
    {

        if ($this->breadcrumbs) {

            // set output variable
            $output = $this->tag_open;
            // construct output
            $i = 1;
            foreach ($this->breadcrumbs as $key => $crumb) {
                if ($i == 1) {
                    if ($this->ci->uri->segment(1) === 'amp') {
                        $output .= $this->crumb_open . '<span class="br-icon"><amp-img layout="responsive" width="20" height="20" src="'. TEMPLATES_ASSETS. 'asset/img/icon/home.svg'.'"></amp-img></span>';
                        $output .= '<a href="' . $crumb['href'] . '" title="' . $crumb['page'] . '">' . $crumb['page'] . '</a>';
                        $output .= $this->crumb_divider.$this->crumb_close;
                    } else {
                        $output .= $this->crumb_open . '';
                        $output .= '<a href="' . $crumb['href'] . '" title="' . $crumb['page'] . '">' . $crumb['page'] . '</a>';
                        $output .= $this->crumb_divider.$this->crumb_close;
                    }
                } else {
                    $output .= $this->crumb_open.'<a href="' . $crumb['href'] . '" title="' . $crumb['page'] . '">' . $crumb['page'] . '</a> '.$this->crumb_divider.$this->crumb_close;
                }

                $i++;
            }
            // return output
            return $output . $this->tag_close . PHP_EOL;
        }

        // no crumbs
        return '';
    }

}