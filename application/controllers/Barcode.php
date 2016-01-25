<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends CI_Controller {

	public $nama_tabel = 'data';

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('welcome_message',$output);
	}

	public function index()
	{
		$crud = new grocery_CRUD();
		$crud->set_crud_url_path(site_url('Barcode/index'));

		$crud->set_table('data');//Nama Tabel
		$crud->set_subject('Barcode');
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_print();
		$crud->add_action('Generate Barcode', '', '','barcode-icon',array($this,'ca_barcode'));//Custom Action
	 
		$output = $crud->render();

		//Config Halaman
		$output->judul_besar = 'Barcode';
		$output->judul_kecil = 'Generate Barcode';
		$output->m_barcode = TRUE;
		$this->_example_output($output);
	}

	public function ca_barcode($primary_key , $row)
	{
	    return site_url('barcode/get_barcode').'/'.$row->nomor;
	}

	public function get_barcode($code)
    {
        $this->set_barcode($code);
    }

    private function set_barcode($code)
    {
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
    }

}

/* End of file Barcode.php */
/* Location: ./application/controllers/Barcode.php */