<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
    }
    public function aaa()
    {
        $this->load->database('membership');
        $query = "select * from member_product_list";
        $result = $this->db->query($query) ;
        
        print_r( $result->row_array() );
    }
    public function kikiki()
    {
        echo "디비도 접근되고 비밀리에 통계업무 같은 부분은들은 미리 만들어 놓고 생색내기를 해 볼까 생각중입니다.";
    }
}
