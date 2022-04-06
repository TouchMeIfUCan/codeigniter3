<?php  

class Data_asisten extends CI_Controller{

    //ini adalah controller data_asisten yang ada di folder C:\xampp\htdocs\asisten\application\controllers\admin

    public function __construct(){
        parent::__construct();

        if($this->session->userdata('role_id') != '1'){
           $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
           Anda belum login!
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>');
         redirect('auth/login'); 
        }      
    }

    public function index()
    {
         $data['asisten'] = $this->model_asisten->tampil_data()->result();
         $this->load->view( 'templates_admin/header');
         $this->load->view( 'templates_admin/sidebar');
         $this->load->view( 'admin/data_asisten', $data);
         $this->load->view( 'templates_admin/footer');
    }

    public function tambah_aksi()
    {
        $nama_art       = $this->input->post('nama_art');
        $keterangan     = $this->input->post('keterangan');
        $kategori       = $this->input->post('kategori');
        $harga          = $this->input->post('harga');
        $stok           = $this->input->post('stok');
        $gambar         = $_FILES['gambar']['name'];
        if ($gambar =''){}else{
            $config ['upload_path'] = './uploads';
            $config ['allowed_types'] = 'jpg|jpeg|png';

            $this->load->library('upload', $config);
            if(!$this->upload->do_upload('gambar')){
                echo "Gambar Gagal Upload!";
            }else{
                $gambar=$this->upload->data('file_name');
            }
        }
        $data = array(
            'nama_art'   => $nama_art,
            'keterangan' => $kategori,
            'kategori'   => $kategori,
            'harga'      => $harga,
            'stok'       => $stok,
            'gambar'     => $gambar,  
        );
        $this->model_asisten->tambah_asisten($data, 'tbl_art');
        redirect('admin/data_asisten/index');
    }

    public function edit($id)
    {
        $where = array('id_art' =>$id);
        $data['asisten'] = $this->model_asisten->edit_asisten($where, 'tbl_art')->result();
        $this->load->view( 'templates_admin/header');
        $this->load->view( 'templates_admin/sidebar');
        $this->load->view( 'admin/edit_asisten',$data);
        $this->load->view( 'templates_admin/footer');
    }

    public function update(){
        $id             = $this->input->post('id_art');
        $nama_art       = $this->input->post('nama_art');
        $keterangan     = $this->input->post('keterangan');
        $kategori       = $this->input->post('kategori');
        $harga          = $this->input->post('harga');
        $stok           = $this->input->post('stok');

        $data = array(
            'nama_art'      => $nama_art,
            'keterangan'    => $keterangan,
            'kategori'      => $kategori,
            'harga'         => $harga,
            'stok'          => $stok,
        );

        $where = array( 'id_art' => $id);

        $this->model_asisten->update_data($where,$data, 'tbl_art');
        redirect('admin/data_asisten/index');

    }

    public function hapus ($id){
        $where = array( 'id_art' => $id);
        $this->model_asisten->hapus_data($where, 'tbl_art');
        redirect('admin/data_asisten/index');
    }   
} 
