<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation $form_validation The form validation library
 */
class Auth extends STEVEN_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library(array('ion_auth', 'form_validation'));
    $this->load->helper(array('url', 'language', 'form'));

    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

    $this->lang->load('auth');
  }

  public function login()
  {
    if ($this->ion_auth->logged_in() == true) redirect(site_admin_url());
    $this->_render_page('admin/auth/login');

  }

  public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
  {

    $this->viewdata = (empty($data)) ? $this->data : $data;

    $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

    // This will return html on 3rd argument being true
    if ($returnhtml) {
      return $view_html;
    }
  }
}
