<?php
class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('torrent_model');
	}

	public function view($page = 'home',$pagestart=0) {

	    if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php')) {
			// Whoops, we don't have a page for that!
			show_404();
	    }

		//$pagestart = $this->uri->segment(3, 0);
	    $data['title'] = ucfirst($page); // Capitalize the first letter

		$data['torrents'] = $this->torrent_model->get_torrents($pagestart);
			
	    $this->load->view('templates/header', $data);
	    $this->load->view('pages/'.$page, $data);
	    
	    $this->load->library('pagination');

$config['base_url'] = 'http://localhost/workspace/tail.remote/index.php/pages/view/home/';
$config['total_rows'] = $this->torrent_model->get_torrent_count();
$config['per_page'] = 20;

$config['full_tag_open'] = "<ul class='pagination'>";
$config['full_tag_close'] ="</ul>";
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
$config['next_tag_open'] = "<li>";
$config['next_tagl_close'] = "</li>";
$config['prev_tag_open'] = "<li>";
$config['prev_tagl_close'] = "</li>";
$config['first_tag_open'] = "<li>";
$config['first_tagl_close'] = "</li>";
$config['last_tag_open'] = "<li>";
$config['last_tagl_close'] = "</li>";

$this->pagination->initialize($config);
$data['links']= $this->pagination->create_links();

	    $this->load->view('templates/footer', $data);
	}
}
