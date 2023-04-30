<?php

use phpDocumentor\Reflection\Types\This;

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_log_in();
        $this->load->model('Base_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';
        $data['pmb'] = $this->db->get('pmb')->row_array();
        $data['pmb'] = $data['pmb']['buka'];


        $sql = "SELECT count(id) as jumlah FROM pendaftar";

        $data['pendaftar'] = $this->db->query($sql)->row_array();
        $data['pendaftar'] = $data['pendaftar']['jumlah'];

        $sql1 = "SELECT count(user.`id`) as jumlah
        FROM user, pendaftar, nilai_test, prodi
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND pendaftar.`id` = nilai_test.`id_pendaftar`
        AND pendaftar.`id_prodi` = prodi.`id`
        AND pendaftar.`id_pengumuman` = 1";

        $data['diterima'] = $this->db->query($sql1)->row_array();
        $data['diterima'] = $data['diterima']['jumlah'];

        $sql2 = "SELECT count(user.`id`) as jumlah
        FROM user, pendaftar, nilai_test, prodi
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND pendaftar.`id` = nilai_test.`id_pendaftar`
        AND pendaftar.`id_prodi` = prodi.`id`
        AND pendaftar.`id_pengumuman` = 2";

        $data['tidak_lulus'] = $this->db->query($sql2)->row_array();
        $data['tidak_lulus'] = $data['tidak_lulus']['jumlah'];

        $sql3 = "SELECT count(pendaftar.id) as jumlah
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        AND nilai_test.`skor` IS NULL";

        $data['belum_dinilai'] = $this->db->query($sql3)->row_array();

        $data['belum_dinilai'] = $data['belum_dinilai']['jumlah'];

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template/footer');
    }

    public function aktivasi()
    {
        $status = $this->input->post('aktif');

        $sql = "UPDATE pmb SET pmb.buka = $status";

        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Status PMB telah diubah !
		  </div>');

        redirect('admin/index');
    }

    public function role()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role';
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Role berhasil ditambahkan !
		  </div>');

            redirect('admin/role');
        }
    }

    public function roleAccess($role_id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role Access';
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/roleaccess', $data);
        $this->load->view('template/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Akses Di ubah !
		  </div>');
    }
    public function jadwal()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Jadwal PMB';

        $data['jadwal'] = $this->db->get('jadwal')->result_array();

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/jadwal', $data);
            $this->load->view('template/footer');
        }
    }
    public function tambah_jadwal()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $gelombang = $this->input->post('gelombang');
        $tgl_buka = $this->input->post('tgl_buka');
        $tgl_tutup = $this->input->post('tgl_tutup');
        $tgl_test = $this->input->post('tgl_test');
        $status = $this->input->post('status');

        $data = [
            'gelombang' => $gelombang,
            'tgl_buka' => $tgl_buka,
            'tgl_berakhir' => $tgl_tutup,
            'tgl_test' => $tgl_test,
            'is_active' => $status
        ];

        $this->db->insert('jadwal', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Jadwal PMB berhasil ditambahkan.
		  </div>');

        redirect('admin/jadwal');
    }

    public function edit_jadwal()
    {
        $gelombang = $this->input->post('gelombang');
        $tgl_buka = $this->input->post('tgl_buka');
        $tgl_tutup = $this->input->post('tgl_berakhir');
        $tgl_test = $this->input->post('tgl_test');
        $status = $this->input->post('status');
        $id = $this->input->post('id');

        $data = [
            'gelombang' => $gelombang,
            'tgl_buka' => $tgl_buka,
            'tgl_berakhir' => $tgl_tutup,
            'tgl_test' => $tgl_test,
            'is_active' => $status
        ];

        $this->db->where('id', $id);
        $this->db->update('jadwal', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Jadwal PMB berhasil diubah.
		  </div>');

        redirect('admin/jadwal');
    }

    public function delete_jadwal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jadwal');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Jadwal berhasil dihapus.
      </div>');

        redirect('admin/jadwal');
    }

    public function delete_detail_verifikasi_pembayaran($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Detail verifikasi pembayaran berhasil dihapus.
      </div>');

        redirect("admin/detail_verifikasi/$id");
    }

    public function data_calon_mahasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Data Prodi';
        $data['title'] = 'Data Nilai';
        $data['prodi'] = $this->db->get('prodi')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/data_calon_mahasiswa', $data);
        $this->load->view('template/footer');
    }

    public function detail($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Data Calon Mahasiswa';

        $data['tahun_ajaran'] = $this->db->get('th_ajaran')->result_array();
        $data['jadwal'] = $this->db->get('jadwal')->result_array();

        $sql = "SELECT pendaftar.`no_pendaftaran`, user.`nik`, pendaftar.`nama_lengkap`, prodi.`nama_prodi`, nilai_test.praktek, nilai_test.wawancara, nilai_test.skor, th_ajaran.tahun_ajaran, pendaftar.id_pengumuman
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        WHERE prodi.`id` = $id
        ";

        $data['data_calon_mahasiswa'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/detail', $data);
        $this->load->view('template/footer');
    }

    public function cetak_data_calon_mhs()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Data Calon Mahasiswa';

        $th_ajaran = $this->input->post('th_ajaran');
        $gelombang = $this->input->post('gelombang');

        //$this->load->library('dompdf_gen');
        $sql = "SELECT pendaftar.`no_pendaftaran`, user.`nik`, pendaftar.`nama_lengkap`, prodi.`nama_prodi`, nilai_test.praktek, nilai_test.wawancara, nilai_test.skor, pendaftar.id_th_ajaran, th_ajaran.tahun_ajaran, pendaftar.id_pengumuman, jadwal.gelombang
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran
        ON pendaftar.`id_th_ajaran` = th_ajaran.id
        INNER JOIN jadwal
        ON pendaftar.id_jadwal = jadwal.id
        WHERE pendaftar.id_th_ajaran = $th_ajaran
        AND jadwal.id = $gelombang
        ORDER BY nilai_test.skor DESC
        ";

        $data['data_calon_mahasiswa'] = $this->db->query($sql)->result_array();

        $this->load->view('admin/cetak_data_calon_mhs', $data);

        // $paper_size = 'A4';
        // $orientation = 'potrait';

        // $html = $this->output->get_output();
        // $this->dompdf->set_paper($paper_size, $orientation);

        //$this->dompdf->load_html($html);
        //$this->dompdf->render();
        //$this->dompdf->stream('data calon mahasiswa.pdf', array('Attachment' => 0));
    }

    public function buat_akun_penyeleksi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Buat Akun Penyeleksi';
        $data['penyeleksi'] = $this->db->get_where('user', ['role_id' => 3])->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/buat_akun_penyeleksi', $data);
        $this->load->view('template/footer');
    }
    public function aksi_akun_penyeleksi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $nik = $this->input->post('nik');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $data = [
            'nik' => $nik,
            'nama_lengkap' => $nama_lengkap,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'date_created' => time(),
            'image' => 'default.png',
            'is_active' => 1,
            'role_id' => 3
        ];

        $this->db->insert('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Akun penyeleksi berhasil dibuat.
      </div>');

        redirect('admin/buat_akun_penyeleksi');
    }
    public function delete_penyeleksi($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Akun Penyeleksi berhasil dihapus.
      </div>');

        redirect('admin/buat_akun_penyeleksi');
    }
    public function tahun_ajaran()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Tahun Ajaran';

        $data['tahun_ajaran'] = $this->db->get('th_ajaran')->result_array();

        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/tahun_ajaran', $data);
            $this->load->view('template/footer');
        } else {
            $tahun_ajaran = $this->input->post('tahun_ajaran');
            $status = $this->input->post('status');

            $data = [
                'tahun_ajaran' => $tahun_ajaran,
                'is_active' => $status
            ];

            $this->db->insert('th_ajaran', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Tahun ajaran berhasil ditambahkan.
      </div>');

            redirect('admin/tahun_ajaran');
        }
    }

    public function edit_tahun_ajaran()
    {
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $status = $this->input->post('status');

        $id = $this->input->post('id');

        $data = [
            'tahun_ajaran' => $tahun_ajaran,
            'is_active' => $status,
            'id' => $id
        ];

        $this->db->where('id', $id);
        $this->db->update('th_ajaran', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Tahun Ajaran berhasil diubah.
		  </div>');

        redirect('admin/tahun_ajaran');
    }


    public function delete_tahun_ajaran($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('th_ajaran');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Tahun ajaran berhasil dihapus.
      </div>');

        redirect('admin/tahun_ajaran');
    }

    public function pengumuman()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Terbitkan Pengumuman';

        $data['th_ajaran'] = $this->db->get('th_ajaran')->result_array();
        $data['prodi'] = $this->db->get('prodi')->result_array();
        $data['jadwal'] = $this->db->get('jadwal')->result_array();

        $th_ajaran = $this->input->post('th_ajaran');

        $sql = "SELECT pendaftar.id, pendaftar.`no_pendaftaran`, user.`nik`, pendaftar.`nama_lengkap`, prodi.`nama_prodi`, nilai_test.praktek, nilai_test.wawancara, nilai_test.skor, th_ajaran.tahun_ajaran
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        AND nilai_test.`skor` IS NULL
        AND `th_ajaran`.`id` = '$th_ajaran'
        ";

        $sql1 = "SELECT COUNT(pendaftar.id) as jumlah
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        AND nilai_test.`skor` IS NULL
        AND `th_ajaran`.`id` = '$th_ajaran'
        ";

        $sql2 = "SELECT `th_ajaran`.`tahun_ajaran`
                    FROM th_ajaran
                    WHERE th_ajaran.id = '$th_ajaran'";

        $tahun_ajaran = $this->db->query($sql2)->row_array();

        $tahun_ajaran = $tahun_ajaran['tahun_ajaran'];


        $data['cek_data'] = $this->db->query($sql1)->row_array();
        $data['cek_data'] = $data['cek_data']['jumlah'];

        $data['pengumuman'] = $this->db->query($sql)->result_array();

        $this->form_validation->set_rules('th_ajaran', 'Tahun Ajaran', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/pengumuman', $data);
            $this->load->view('template/footer');
        } else {
            if ($data['cek_data'] > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $data['cek_data'] . ' Data belum dinilai
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">' . ' Semua peserta di tahun ajaran ' . $tahun_ajaran . ' telah dinilai 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            }

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/pengumuman', $data);
            $this->load->view('template/footer');
        }
    }
    public function terbit_pengumuman()
    {
        $th_ajaran = $this->input->post('tahun_ajaran');
        $prodi = $this->input->post('prodi');
        $gelombang = $this->input->post('gelombang');
        $jumlah = $this->input->post('jumlah');
        // $jumlah = $jumlah += 1;

        $sql3 = "SELECT COUNT(pendaftar.id) as jumlah
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        INNER JOIN jadwal
        ON jadwal.`id` = pendaftar.`id_jadwal`
        WHERE nilai_test.`skor` IS NULL
        AND `th_ajaran`.`id` = $th_ajaran
        AND jadwal.`id` = $gelombang
        AND prodi.`id` = $prodi";

        $data['cek_data'] = $this->db->query($sql3)->row_array();
        $data['cek_data'] = $data['cek_data']['jumlah'];

        if ($data['cek_data'] > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Masih ada peserta yang belum dinilai, silahkan cek kembali!
      </div>');

            redirect('admin/pengumuman');
        }

        $sql = "SELECT pendaftar.id, pendaftar.`no_pendaftaran`, user.`nik`, pendaftar.`nama_lengkap`, prodi.`nama_prodi`, nilai_test.praktek, nilai_test.wawancara, nilai_test.skor, th_ajaran.tahun_ajaran
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        INNER JOIN jadwal
        ON jadwal.`id` = pendaftar.`id_jadwal`
        AND nilai_test.`skor` IS NOT NULL
        AND `th_ajaran`.`id` = '$th_ajaran'
        AND jadwal.`id` = $gelombang
        AND prodi.`id` = $prodi
        ORDER BY `nilai_test`.`skor` DESC
        LIMIT $jumlah ";

        $keterima = $this->db->query($sql)->result_array();

        $jumlah_keterima = count($keterima);

        if ($jumlah_keterima == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Tidak ada calon mahasiswa pada tahun ajaran tersebut.
      </div>');
            redirect('admin/pengumuman');
        }

        $sql1 = "SELECT pendaftar.id, pendaftar.`no_pendaftaran`, user.`nik`, pendaftar.`nama_lengkap`, prodi.`nama_prodi`, nilai_test.praktek, nilai_test.wawancara, nilai_test.skor, th_ajaran.tahun_ajaran, pendaftar.id_pengumuman
        FROM nilai_test
        RIGHT JOIN pendaftar
        ON pendaftar.`id` = nilai_test.id_pendaftar
        INNER JOIN user
        ON pendaftar.`id_user_calon_mhs` = user.`id`
        INNER JOIN prodi
        ON pendaftar.`id_prodi` = prodi.`id`
        INNER JOIN th_ajaran 
        ON pendaftar.id_th_ajaran = th_ajaran.id
        INNER JOIN jadwal
        ON jadwal.`id` = pendaftar.`id_jadwal`
        AND nilai_test.`skor` IS NOT NULL
        AND `th_ajaran`.`id` = '$th_ajaran'
        AND jadwal.`id` = $gelombang
        AND prodi.`id` = $prodi
        ORDER BY `nilai_test`.`skor` DESC";

        $cek_mahasiswa = $this->db->query($sql1)->result_array();

        for ($i = 0; $i < count($cek_mahasiswa); $i++) {
            $where = $keterima[$i]['id'];
            $where1 = $cek_mahasiswa[$i]['id'];
            if ($keterima[$i]['id'] == $cek_mahasiswa[$i]['id']) {
                $sql2 = "UPDATE pendaftar SET pendaftar.id_pengumuman = 1 WHERE pendaftar.id = $where AND pendaftar.id_prodi = $prodi AND pendaftar.id_jadwal = $gelombang AND pendaftar.id_th_ajaran = $th_ajaran";
                $this->db->query($sql2);
            } else {
                $sql2 = "UPDATE pendaftar SET pendaftar.id_pengumuman = 2 WHERE pendaftar.id = $where1 AND pendaftar.id_prodi = $prodi AND pendaftar.id_jadwal = $gelombang AND pendaftar.id_th_ajaran = $th_ajaran";
                $this->db->query($sql2);
            }
        }


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Pengumuman berhasi diterbitkan.
      </div>');
        redirect('admin/pengumuman');
    }
    public function data_belum_finalisasi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Data Belum Finalisasi';


        $sql = "SELECT user.id AS id_user,user.nama_lengkap AS nama_user,user.no_whatsapp, user.date_created as tanggal_buat, user.nik, user.`email`, pendaftar.*, prodi.`nama_prodi`, prodi.`ruangan_praktek`, prodi.`ruangan_wawancara`
        FROM user
        LEFT JOIN pendaftar
        ON pendaftar.`id_user_calon_mhs` = user.id
        LEFT JOIN prodi
        ON prodi.`id` = pendaftar.`id_prodi`
        WHERE user.`role_id` = 4
        AND pendaftar.`status_finalisasi` IS NULL 
        OR pendaftar.`status_finalisasi` = 0";

        $data['pendaftar'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/data_belum_finalisasi', $data);
        $this->load->view('template/footer');
    }
    public function detail_formulir($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Data Belum Finalisasi';
        $data['judul'] = 'Detail Formulir';

        $sql = "SELECT user.id as id_user, pendaftar.id,pendaftar.`nama_lengkap`, pendaftar.`jalur_seleksi`, prodi.`nama_prodi`, pendaftar.`id_prodi2`, pendaftar.`tempat_lahir`, pendaftar.`tanggal_lahir`, pendaftar.`provinsi_tempat_lahir`, user.`nik`, pendaftar.`jenis_kelamin`, pendaftar.`status_pernikahan`, pendaftar.`agama`, pendaftar.`telepon`, user.`email`, pendaftar.`alamat`, provinsi.`nama_provinsi`, kabupaten.`kabupaten`, kecamatan.`nama_kecamatan`, pendaftar.`kode_pos`, pendaftar.`kewarganegaraan`, pendaftar.`pas_foto`, pendaftar.status_finalisasi, pendaftar.status_validasi_berkas, pendaftar.id_pengumuman
        FROM user 
        INNER JOIN pendaftar ON user.id = pendaftar.`id_user_calon_mhs`
        INNER JOIN prodi ON prodi.`id` = pendaftar.`id_prodi`
        INNER JOIN prodi as prodi2 ON prodi2.`id` = pendaftar.`id_prodi2`
        INNER JOIN provinsi ON pendaftar.`id_provinsi` = provinsi.`id`
        INNER JOIN kabupaten ON kabupaten.`id` = pendaftar.`id_kabupaten`
        INNER JOIN kecamatan ON kecamatan.`id` = pendaftar.`id_kecamatan`
        WHERE user.id = $id";
        $data['detail_form'] = $this->db->query($sql)->row_array();

        $sql1 = "SELECT user.id,detail_sekolah.`nama_sekolah`, detail_sekolah.`jenis_sekolah`, detail_sekolah.`id_provinsi`, detail_sekolah.`alamat_lengkap_sekolah`, detail_sekolah.`jurusan`, detail_sekolah.`status_kelulusan`, detail_sekolah.`tahun_lulus`, detail_sekolah.`no_ijazah`, detail_sekolah.`tgl_ijazah`,detail_sekolah.`bhs_indo_smt3`, detail_sekolah.`bhs_inggris_smt3`, detail_sekolah.`matematika_smt3`,detail_sekolah.`bhs_indo_smt4`, detail_sekolah.`bhs_inggris_smt4`, detail_sekolah.`matematika_smt4`,detail_sekolah.`bhs_indo_smt5`, detail_sekolah.`bhs_inggris_smt5`, detail_sekolah.`matematika_smt5`, detail_sekolah.`bhs_indonesia`, detail_sekolah.`bhs_inggris`, detail_sekolah.`matematika`, provinsi.`nama_provinsi`
        FROM detail_sekolah, user, provinsi
        WHERE detail_sekolah.`id_user_calon_mhs` = user.`id`
        AND provinsi.`id` = detail_sekolah.`id_provinsi`
        AND user.`id` = $id";
        $data['detail_sekolah'] = $this->db->query($sql1)->row_array();

        $data['prodi'] = $this->db->get('prodi')->result_array();
        $data['provinsi'] = $this->db->get('provinsi')->result_array();
        $data['kabupaten'] = $this->db->get('kabupaten')->result_array();
        $data['kecamatan'] = $this->db->get('kecamatan')->result_array();
        $data['sekolah'] = $this->db->get('sekolah')->result_array();

        $sql2 = "SELECT DISTINCT(sekolah.status) FROM sekolah";
        $data['status_sekolah'] = $this->db->query($sql2)->result_array();

        $sql3 = "SELECT data_prestasi.`id`, user.id as id_user, user.nik, data_prestasi.`jenis_kegiatan_lomba`, data_prestasi.`tingkat_kejuaraan`, data_prestasi.`prestasi_juara_ke`,data_prestasi.`bukti`
        FROM data_prestasi, user
        WHERE data_prestasi.`id_user_calon_mhs` = user.`id`
        AND user.id = $id";
        $data['data_prestasi'] = $this->db->query($sql3)->result_array();

        $sql4 = "SELECT user.id, user.nik, data_ortu.`nama_ayah`, data_ortu.`pendidikan_terakhir_ayah`, data_ortu.`pekerjaan_ayah`, data_ortu.`penghasilan_ayah`, data_ortu.`nama_ibu`, data_ortu.`pendidikan_terakhir_ibu`, data_ortu.`pekerjaan_ibu`, data_ortu.`penghasilan_ibu`, data_ortu.`alamat_lengkap_ortu`, data_ortu.`id_provinsi_asal_ortu`, data_ortu.`id_kabupaten_ortu`, data_ortu.`kode_pos_ortu`, data_ortu.`telepon_ortu`, data_ortu.`nama_wali`, data_ortu.`pekerjaan_wali`, data_ortu.`alamat_lengkap_wali`, provinsi.`nama_provinsi`, kabupaten.`kabupaten`
        FROM data_ortu, user, provinsi, kabupaten
        WHERE data_ortu.`id_user_calon_mhs` = user.`id`
        AND data_ortu.`id_provinsi_asal_ortu` = provinsi.`id`
        AND data_ortu.`id_kabupaten_ortu` = kabupaten.`id`
        AND user.`id` = $id";
        $data['data_ortu'] = $this->db->query($sql4)->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/detail_formulir', $data);
        $this->load->view('template/footer');
    }
    public function edit_data_biodata()
    {
        $id = $this->input->post('id');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $jalur_seleksi = $this->input->post('jalur_seleksi');
        $prodi = $this->input->post('prodi');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $provinsi_tempat_lahir = $this->input->post('provinsi_tempat_lahir');
        $nik = $this->input->post('nik');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $status_pernikahan = $this->input->post('status_pernikahan');
        $agama = $this->input->post('agama');
        $no_hp = $this->input->post('no_hp');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat_lengkap');
        $provinsi_tinggal = $this->input->post('provinsi');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('kecamatan');
        $kodepos = $this->input->post('kode_pos');
        $kewarganegaraan = $this->input->post('kewarganegaraan');

        $sql = "UPDATE user, pendaftar
        SET pendaftar.`nama_lengkap` = '$nama_lengkap', pendaftar.`jalur_seleksi` = '$jalur_seleksi', pendaftar.`id_prodi` = $prodi, pendaftar.`tempat_lahir` = '$tempat_lahir', pendaftar.`tanggal_lahir`= '$tgl_lahir',
        pendaftar.provinsi_tempat_lahir = '$provinsi_tempat_lahir', user.nik = $nik, pendaftar.jenis_kelamin = '$jenis_kelamin', pendaftar.status_pernikahan = '$status_pernikahan', pendaftar.agama = '$agama',
        pendaftar.telepon = $no_hp, user.email = '$email', pendaftar.alamat = '$alamat',
        pendaftar.id_provinsi = $provinsi_tinggal, pendaftar.id_kabupaten = $kabupaten,
        pendaftar.id_kecamatan = $kecamatan, pendaftar.kode_pos = $kodepos,
        pendaftar.kewarganegaraan = '$kewarganegaraan'
        WHERE user.id = pendaftar.id_user_calon_mhs
        AND user.id = $id";

        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Biodata berhasil diubah.
      </div>');
        redirect('admin/detail_formulir/' . $nik);
    }
    public function edit_data_sekolah()
    {
        $id = $this->input->post('id');
        $nama_sekolah = $this->input->post('nama_sekolah');
        $jenis_sekolah = $this->input->post('jenis_sekolah');
        $provinsi_asal_sekolah = $this->input->post('provinsi_asal_sekolah');
        $alamat_lengkap_sekolah = $this->input->post('alamat_lengkap_sekolah');
        $jurusan = $this->input->post('jurusan');
        $status_kelulusan = $this->input->post('status_kelulusan');
        $tahun_lulus = $this->input->post('tahun_lulus');
        $no_ijazah = $this->input->post('no_ijazah');
        $tgl_ijazah = $this->input->post('tgl_ijazah');
        $bhs_indonesia_smt3 = $this->input->post('bhs_indonesia_smt3');
        $bhs_inggris_smt3 = $this->input->post('bhs_inggris_smt3');
        $matematika_smt3 = $this->input->post('matematika_smt3');
        $bhs_indonesia_smt4 = $this->input->post('bhs_indonesia_smt4');
        $bhs_inggris_smt4 = $this->input->post('bhs_inggris_smt4');
        $matematika_smt4 = $this->input->post('matematika_smt4');
        $bhs_indonesia_smt5 = $this->input->post('bhs_indonesia_smt5');
        $bhs_inggris_smt5 = $this->input->post('bhs_inggris_smt5');
        $matematika_smt5 = $this->input->post('matematika_smt5');
        $bhs_indonesia = $this->input->post('bhs_indonesia');
        $bhs_inggris = $this->input->post('bhs_inggris');
        $matematika = $this->input->post('matematika');

        $nik = $this->input->post('nik');

        $sql = "UPDATE user, detail_sekolah
        SET detail_sekolah.nama_sekolah = '$nama_sekolah', detail_sekolah.jenis_sekolah = '$jenis_sekolah', detail_sekolah.id_provinsi = $provinsi_asal_sekolah, detail_sekolah.alamat_lengkap_sekolah = '$alamat_lengkap_sekolah', detail_sekolah.jurusan='$jurusan', detail_sekolah.status_kelulusan = $status_kelulusan, detail_sekolah.tahun_lulus = $tahun_lulus, detail_sekolah.no_ijazah = '$no_ijazah', detail_sekolah.tgl_ijazah = '$tgl_ijazah', detail_sekolah.bhs_indonesia = $bhs_indonesia, detail_sekolah.bhs_inggris = $bhs_inggris, detail_sekolah.matematika = $matematika,detail_sekolah.bhs_indo_smt3 = $bhs_indonesia_smt3, detail_sekolah.bhs_inggris_smt3 = $bhs_inggris_smt3, detail_sekolah.matematika_smt3 = $matematika_smt3, detail_sekolah.bhs_indo_smt4 = $bhs_indonesia_smt4, detail_sekolah.bhs_inggris_smt4 = $bhs_inggris_smt4, detail_sekolah.matematika_smt4 = $matematika_smt4, detail_sekolah.bhs_indo_smt5 = $bhs_indonesia_smt5, detail_sekolah.bhs_inggris_smt5 = $bhs_inggris_smt5, detail_sekolah.matematika_smt5 = $matematika_smt5
        WHERE user.id = detail_sekolah.id_user_calon_mhs
        AND user.id = $id";
        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Data sekolah berhasil diubah.
      </div>');
        redirect('admin/detail_formulir/' . $nik);
    }
    public function edit_data_prestasi()
    {
        $jenis_kegiatan_lomba = $this->input->post('jenis_kegiatan_lomba');
        $tingkat_kejuaraan = $this->input->post('tingkat_kejuaraan');
        $prestasi_juara_ke = $this->input->post('prestasi_juara_ke');
        $nik = $this->input->post('nik');
        $id = $this->input->post('id');
        $id_user = $this->input->post('id_user');

        // var_dump($jenis_kegiatan_lomba, $tingkat_kejuaraan, $prestasi_juara_ke);
        // die;

        $sql = "UPDATE data_prestasi, user
                SET data_prestasi.jenis_kegiatan_lomba = '$jenis_kegiatan_lomba', data_prestasi.tingkat_kejuaraan = '$tingkat_kejuaraan', data_prestasi.prestasi_juara_ke = '$prestasi_juara_ke'
                WHERE user.id = data_prestasi.id_user_calon_mhs
                AND user.id = $id_user 
                AND data_prestasi.id =$id";
        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
			Data prestasi berhasil diubah!
		  </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function edit_data_ortu()
    {
        $id_user = $this->input->post('id');
        $nik = $this->input->post('nik');
        $nama_ayah = $this->input->post('nama_ayah');
        $pendidikan_terakhir_ayah = $this->input->post('pendidikan_terakhir_ayah');
        $pekerjaan_ayah = $this->input->post('pekerjaan_ayah');
        $penghasilan_ayah = $this->input->post('penghasilan_ayah');
        $nama_ibu = $this->input->post('nama_ibu');
        $pendidikan_ibu = $this->input->post('pendidikan_ibu');
        $pekerjaan_ibu = $this->input->post('pekerjaan_ibu');
        $penghasilan_ibu = $this->input->post('penghasilan_ibu');
        $alamat_lengkap_ortu = $this->input->post('alamat_lengkap_ortu');
        $provinsi_asal_orang_tua = $this->input->post('provinsi_asal_orang_tua');
        $kabupaten_asal_orang_tua = $this->input->post('kabupaten_asal_orang_tua');
        $kodepos_alamat_orang_tua = $this->input->post('kodepos_alamat_orang_tua');
        $no_telp_orang_tua = $this->input->post('no_telp_orang_tua');
        $nama_wali = $this->input->post('nama_wali');
        $pekerjaan_wali = $this->input->post('pekerjaan_wali');
        $alamat_lengkap_wali = $this->input->post('alamat_lengkap_wali');

        $sql = "UPDATE data_ortu, user
                SET data_ortu.nama_ayah = '$nama_ayah', data_ortu.pendidikan_terakhir_ayah = '$pendidikan_terakhir_ayah',
                data_ortu.pekerjaan_ayah = '$pekerjaan_ayah', data_ortu.penghasilan_ayah = '$penghasilan_ayah', data_ortu.nama_ibu = '$nama_ibu', data_ortu.pendidikan_terakhir_ibu = '$pendidikan_ibu', data_ortu.pekerjaan_ibu = '$pekerjaan_ibu', data_ortu.penghasilan_ibu = '$penghasilan_ibu', data_ortu.alamat_lengkap_ortu = '$alamat_lengkap_ortu', data_ortu.id_provinsi_asal_ortu = '$provinsi_asal_orang_tua', data_ortu.id_kabupaten_ortu='$kabupaten_asal_orang_tua', data_ortu.kode_pos_ortu = '$kodepos_alamat_orang_tua', data_ortu.telepon_ortu = '$no_telp_orang_tua', data_ortu.nama_wali = '$nama_wali', data_ortu.pekerjaan_wali = '$pekerjaan_wali', data_ortu.alamat_lengkap_wali = '$alamat_lengkap_wali'
                WHERE data_ortu.id_user_calon_mhs = user.id
                AND user.id = $id_user";
        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
			Data orangtua berhasil diubah!
		  </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function finalisasi($nik, $id_user, $id)
    {
        $sql = "UPDATE pendaftar, user
                SET pendaftar.status_finalisasi = 1
                WHERE pendaftar.id_user_calon_mhs = user.id
                AND user.id = $id_user
                AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
			Data berhasil difinalisasi!
		  </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function batal_finalisasi($nik, $id_user, $id)
    {
        $sql = "UPDATE pendaftar, user
                SET pendaftar.status_finalisasi = 0
                WHERE pendaftar.id_user_calon_mhs = user.id
                AND user.id = $id_user
                AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
			Finalisasi berhasil dibatalkan!
		  </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function status_validasi_berkas($nik, $id_user, $id)
    {
        $sql = "UPDATE pendaftar, user
                SET pendaftar.status_validasi_berkas = 1
                WHERE pendaftar.id_user_calon_mhs = user.id
                AND user.id = $id_user
                AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
			Berkas berhasil divalidasi!
		  </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function batal_status_validasi_berkas($nik, $id_user, $id)
    {
        $sql = "UPDATE pendaftar, user
                SET pendaftar.status_validasi_berkas = 0
                WHERE pendaftar.id_user_calon_mhs = user.id
                AND user.id = $id_user
                AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
			Validasi berkas dibatalkan!
		  </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function hapus_prestasi($nik, $id)
    {
        $sql = "DELETE FROM data_prestasi 
                WHERE data_prestasi.id = $id";
        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Data berhasil dihapus !
      </div>');
        redirect("admin/detail_formulir/$nik");
    }
    public function surat_pernyataan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Surat Pernyataan';

        $data['surat_pernyataan'] = $this->db->get('surat_pernyataan')->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/surat_pernyataan', $data);
        $this->load->view('template/footer');
    }
    public function aksi_surat_pernyataan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $surat = $this->input->post('editor1');

        $data = [
            'surat_pernyataan' => $surat
        ];
        $this->db->insert('surat_pernyataan', $data);

        $this->db->where('id', 2);
        $this->db->update('surat_pernyataan', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Surat pernyataan berhasil diubah !!
      </div>');
        redirect("admin/surat_pernyataan");
    }
    public function data_sudah_finalisasi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Data Sudah Finalisasi';

        $sql = "SELECT user.id AS id_user, user.nik, user.`email`, pendaftar.*, prodi.`nama_prodi`, prodi2.nama_prodi as prodi2, prodi.`ruangan_praktek`, prodi.`ruangan_wawancara`
        FROM user, pendaftar, prodi, prodi as prodi2
        WHERE user.`id` = pendaftar.`id_user_calon_mhs` 
        AND pendaftar.`id_prodi` = prodi.`id`
        AND pendaftar.id_prodi2 = prodi2.id
        AND pendaftar.`status_finalisasi` = 1";

        $data['pendaftar'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/data_sudah_finalisasi', $data);
        $this->load->view('template/footer');
    }
    public function cetak_kartu_test($id, $id_user)
    {
        setlocale(LC_ALL, 'id-ID', 'id_ID');

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $this->load->library('dompdf_gen');
        $sql = "SELECT pendaftar.`no_pendaftaran`, pendaftar.`nama_lengkap`, pendaftar.`tempat_lahir`, pendaftar.`tanggal_lahir`, 
        pendaftar.`jenis_kelamin`, prodi.nama_prodi, prodi2.nama_prodi as nama_prodi2, prodi.ruangan_praktek, prodi.ruangan_wawancara,
        jadwal.`tgl_test`,  jadwal.`tgl_test2`, jadwal.test_tulis, pendaftar.pas_foto, th_ajaran.tahun_ajaran,jadwal.gelombang
        FROM user, pendaftar, jadwal, prodi, th_ajaran, prodi as prodi2
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND jadwal.`id` = pendaftar.`id_jadwal`
        AND prodi.id = pendaftar.`id_prodi`
        AND prodi2.id = pendaftar.`id_prodi2`
        AND th_ajaran.id = pendaftar.id_th_ajaran
        AND user.`id` = $id_user";
        $data['kartu_test'] = $this->db->query($sql)->row_array();

        $sql1 = "SELECT *
        FROM user, pendaftar, prodi, provinsi, kabupaten, kecamatan
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND pendaftar.`id_prodi` = prodi.`id`
        AND pendaftar.`id_provinsi` = provinsi.`id`
        AND pendaftar.`id_kabupaten` = kabupaten.`id`
        AND pendaftar.`id_kecamatan` = kecamatan.`id`
        AND user.`id` = $id_user
        AND pendaftar.`id` = $id";

        $data['data_diri'] = $this->db->query($sql1)->row_array();

        $sql4 = "SELECT * 
        FROM user, data_prestasi
        WHERE user.id = data_prestasi.`id_user_calon_mhs`
        AND user.id = $id_user";
        $data['prestasi'] = $this->db->query($sql4)->result_array();

        $sql5 = "SELECT * 
        FROM user, data_ortu, provinsi, kabupaten
        WHERE user.`id` = data_ortu.`id_user_calon_mhs`
        AND data_ortu.`id_provinsi_asal_ortu` = provinsi.`id`
        AND data_ortu.`id_kabupaten_ortu` = kabupaten.`id`
        AND user.`id` = $id_user";
        $data['ortu'] = $this->db->query($sql5)->row_array();

        $sql6 = "SELECT *
        FROM user, detail_sekolah, provinsi
        WHERE user.id = detail_sekolah.`id_user_calon_mhs`
        AND provinsi.`id` = detail_sekolah.`id_provinsi`
        AND user.id = $id_user";
        $data['sekolah'] = $this->db->query($sql6)->row_array();

        $data['surat_pernyataan'] = $this->db->get('surat_pernyataan')->row_array();

        $data['foto'] = $data['kartu_test']['pas_foto'];
        // $this->qrcode($data['foto']);
        $this->load->view('user/kartu_test', $data);
        // $paper_size = 'A4';
        // $orientation = 'potrait';

        // $html = $this->output->get_output();
        // $this->dompdf->set_paper($paper_size, $orientation);

        // $this->dompdf->load_html($html);
        // $this->dompdf->render();
        // $this->dompdf->stream('kartu test.pdf', array('Attachment' => 0));
    }
    public function delete_pendaftar($id_user)
    {
        $sql = "UPDATE user
        SET cek_isi = NULL, isi_biodata = 0, isi_sekolah_asal = 0, isi_prestasi = 0, isi_data_ortu = 0
        WHERE user.id = $id_user";
        $this->db->query($sql);

        $this->db->where('id_user_calon_mhs', $id_user);
        $this->db->delete('pendaftar');

        $this->db->where('id_user_calon_mhs', $id_user);
        $this->db->delete('data_ortu');

        $this->db->where('id_user_calon_mhs', $id_user);
        $this->db->delete('data_prestasi');

        $this->db->where('id_user_calon_mhs', $id_user);
        $this->db->delete('detail_sekolah');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Pendaftaran berhasil dihapus !!
      </div>');
        redirect("admin/data_belum_finalisasi");
    }
    public function export_excel_lulus()
    {
        $data['data_mhs'] = $this->db->query('SELECT *
                            FROM user
                            LEFT JOIN pendaftar
                            ON pendaftar.`id_user_calon_mhs` = user.`id`
                            LEFT JOIN provinsi
                            ON pendaftar.`id_provinsi` = provinsi.`id`
                            LEFT JOIN kabupaten
                            ON pendaftar.`id_kabupaten` = kabupaten.`id`
                            LEFT JOIN kecamatan
                            ON pendaftar.`id_kecamatan` = kecamatan.`id`
                            LEFT JOIN prodi
                            ON pendaftar.`id_prodi` = prodi.`id`
                            WHERE user.`role_id` = 4
                            AND pendaftar.id_pengumuman = 1')->result();
        $ortu = $this->db->query('SELECT *
                        FROM user
                        LEFT JOIN data_ortu
                        ON data_ortu.`id_user_calon_mhs` = user.`id`
                        LEFT JOIN provinsi
                        ON provinsi.`id` = data_ortu.`id_provinsi_asal_ortu`
                        LEFT JOIN kabupaten
                        ON kabupaten.`id` = data_ortu.`id_kabupaten_ortu`
                        INNER JOIN pendaftar
                        ON pendaftar.`id_user_calon_mhs` = user.`id`
                        WHERE user.`role_id` = 4
                        AND pendaftar.id_pengumuman = 1')->result();

        $sekolah = $this->db->query('SELECT * 
                    FROM user
                    LEFT JOIN detail_sekolah
                    ON user.id = detail_sekolah.`id_user_calon_mhs`
                    LEFT JOIN provinsi
                    ON detail_sekolah.`id_provinsi` = provinsi.`id`
                    INNER JOIN pendaftar
                    ON pendaftar.`id_user_calon_mhs` = user.`id`
                    WHERE user.`role_id` = 4
                    AND pendaftar.id_pengumuman = 1')->result();

        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Admin");
        $objPHPExcel->getProperties()->setLastModifiedBy("Admin");
        $objPHPExcel->getProperties()->setTitle("Data Calon Mahasiswa Lulus");
        $objPHPExcel->getProperties()->setSubject("");
        $objPHPExcel->getProperties()->setDescription("");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Calon Mahasiswa Lulus')->mergeCells('A1:BB2')->getStyle()->getFont()->setSize(26)->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Calon Mahasiswa Lulus')->mergeCells('A1:BB2')->getStyle()->getAlignment('A1')->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'NO PENDAFTAR');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'JALUR SELEKSI');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'NAMA LENGKAP');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'PRODI');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'JENIS KELAMIN');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'PROVINSI TEMPAT LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'TEMPAT LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'TGL LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'TELP/WA');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'EMAIL');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'AGAMA');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ALAMAT');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'KECAMATAN TEMPAT TINGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'KODE POS TEMPAT TINGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'KEWARGANEGARAAN');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'STATUS PERNIKAHAN');

        $objPHPExcel->getActiveSheet()->setCellValue('R3', 'NO TELEPON ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'NAMA AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'PENDIDIKAN TERAKHIR AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'PEKERJAAN AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'PENGHASILAN AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'NAMA IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'PENDIDIKAN TERAKHIR IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'PEKERJAAN IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'PENGHASILAN IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'ALAMAT ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'PROVINSI ASAL ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'KOTA/KABUPATEN ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AD3', 'KODE POS ALAMAT ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AE3', 'NAMA WALI');
        $objPHPExcel->getActiveSheet()->setCellValue('AF3', 'PEKERJAAN WALI');
        $objPHPExcel->getActiveSheet()->setCellValue('AG3', 'ALAMAT LENGKAP WALI');

        $objPHPExcel->getActiveSheet()->setCellValue('AH3', 'TAHUN LULUS SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AI3', 'JURUSAN SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ3', 'JENIS SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AK3', 'NAMA SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AL3', 'PROVINSI ASAL SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AM3', 'ALAMAT LENGKAP SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AN3', 'STATUS KELULUSAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AO3', 'NO IJAZAH SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AP3', 'TANGGAL IJAZAH SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ3', 'NILAI BHS INDONESIA (SMT III)');
        $objPHPExcel->getActiveSheet()->setCellValue('AR3', 'NILAI BHS INGGRIS (SMT III)');
        $objPHPExcel->getActiveSheet()->setCellValue('AS3', 'NILAI MATEMATIKA (SMT III)');
        $objPHPExcel->getActiveSheet()->setCellValue('AT3', 'NILAI BHS INDONESIA (SMT IV)');
        $objPHPExcel->getActiveSheet()->setCellValue('AU3', 'NILAI BHS INGGRIS (SMT IV)');
        $objPHPExcel->getActiveSheet()->setCellValue('AV3', 'NILAI MATEMATIKA (SMT IV)');
        $objPHPExcel->getActiveSheet()->setCellValue('AW3', 'NILAI BHS INDONESIA (SMT V)');
        $objPHPExcel->getActiveSheet()->setCellValue('AX3', 'NILAI BHS INGGRIS (SMT V)');
        $objPHPExcel->getActiveSheet()->setCellValue('AY3', 'NILAI MATEMATIKA (SMT V)');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ3', 'NILAI UN BHS INDONESIA');
        $objPHPExcel->getActiveSheet()->setCellValue('BA3', 'NILAI UN BHS INGGRIS');
        $objPHPExcel->getActiveSheet()->setCellValue('BB3', 'NILAI UN MATEMATIKA');

        $baris = 4;
        $x = 1;

        foreach ($data['data_mhs'] as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $x);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $data->no_pendaftaran);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $data->jalur_seleksi);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $data->nama_lengkap);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $data->nama_prodi);
            if ($data->jenis_kelamin == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, "Laki - Laki");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, "Perempuan");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $data->provinsi_tempat_lahir);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $data->tempat_lahir);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $data->tanggal_lahir);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $data->telepon);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, $data->email);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, $data->agama);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, $data->alamat);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, $data->nama_kecamatan);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, $data->kode_pos);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, $data->kewarganegaraan);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, $data->status_pernikahan);
            $x++;
            $baris++;
        }
        $baris1 = 4;
        foreach ($ortu as $ot) {
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris1, $ot->telepon_ortu);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $baris1, $ot->nama_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $baris1, $ot->pendidikan_terakhir_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $baris1, $ot->pekerjaan_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $baris1, $ot->penghasilan_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $baris1, $ot->nama_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $baris1, $ot->pendidikan_terakhir_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $baris1, $ot->pekerjaan_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $baris1, $ot->penghasilan_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('AA' . $baris1, $ot->alamat_lengkap_ortu);
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $baris1, $ot->nama_provinsi);
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $baris1, $ot->kabupaten);
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $baris1, $ot->kode_pos_ortu);
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $baris1, $ot->nama_wali);
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $baris1, $ot->pekerjaan_wali);
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $baris1, $ot->alamat_lengkap_wali);
            $baris1++;
        }

        $baris2 = 4;
        foreach ($sekolah as $skl) {
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $baris2, $skl->tahun_lulus);
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $baris2, $skl->jurusan);
            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $baris2, $skl->jenis_sekolah);
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $baris2, $skl->nama_sekolah);
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $baris2, $skl->nama_provinsi);
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $baris2, $skl->alamat_lengkap_sekolah);
            if ($skl->status_kelulusan == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('AN' . $baris2, "Sudah Lulus");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('AN' . $baris2, "Belum Lulus");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $baris2, $skl->no_ijazah);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $baris2, $skl->tgl_ijazah);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $baris2, $skl->bhs_indo_smt3);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $baris2, $skl->bhs_inggris_smt3);
            $objPHPExcel->getActiveSheet()->setCellValue('AS' . $baris2, $skl->matematika_smt3);
            $objPHPExcel->getActiveSheet()->setCellValue('AT' . $baris2, $skl->bhs_indo_smt4);
            $objPHPExcel->getActiveSheet()->setCellValue('AU' . $baris2, $skl->bhs_inggris_smt4);
            $objPHPExcel->getActiveSheet()->setCellValue('AV' . $baris2, $skl->matematika_smt4);
            $objPHPExcel->getActiveSheet()->setCellValue('AW' . $baris2, $skl->bhs_indo_smt5);
            $objPHPExcel->getActiveSheet()->setCellValue('AX' . $baris2, $skl->bhs_inggris_smt5);
            $objPHPExcel->getActiveSheet()->setCellValue('AY' . $baris2, $skl->matematika_smt5);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ' . $baris2, $skl->bhs_indonesia);
            $objPHPExcel->getActiveSheet()->setCellValue('BA' . $baris2, $skl->bhs_inggris);
            $objPHPExcel->getActiveSheet()->setCellValue('BB' . $baris2, $skl->matematika);
            $baris2++;
        }



        $filename = "Data-Mahasiswa" . date("d-m-Y") . '.xlsx';

        $objPHPExcel->getActiveSheet()->setTitle("Data Mahasiswa");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');

        exit;
    }
    public function export_excel_tidak_lulus()
    {
        $data['data_mhs'] = $this->db->query('SELECT *
                            FROM user
                            LEFT JOIN pendaftar
                            ON pendaftar.`id_user_calon_mhs` = user.`id`
                            LEFT JOIN provinsi
                            ON pendaftar.`id_provinsi` = provinsi.`id`
                            LEFT JOIN kabupaten
                            ON pendaftar.`id_kabupaten` = kabupaten.`id`
                            LEFT JOIN kecamatan
                            ON pendaftar.`id_kecamatan` = kecamatan.`id`
                            LEFT JOIN prodi
                            ON pendaftar.`id_prodi` = prodi.`id`
                            WHERE user.`role_id` = 4
                            AND pendaftar.id_pengumuman = 2')->result();

        $ortu = $this->db->query('SELECT *
                FROM user
                LEFT JOIN data_ortu
                ON data_ortu.`id_user_calon_mhs` = user.`id`
                LEFT JOIN provinsi
                ON provinsi.`id` = data_ortu.`id_provinsi_asal_ortu`
                LEFT JOIN kabupaten
                ON kabupaten.`id` = data_ortu.`id_kabupaten_ortu`
                INNER JOIN pendaftar
                ON pendaftar.`id_user_calon_mhs` = user.`id`
                WHERE user.`role_id` = 4
                AND pendaftar.id_pengumuman = 2')->result();

        $sekolah = $this->db->query('SELECT * 
                    FROM user
                    LEFT JOIN detail_sekolah
                    ON user.id = detail_sekolah.`id_user_calon_mhs`
                    LEFT JOIN provinsi
                    ON detail_sekolah.`id_provinsi` = provinsi.`id`
                    INNER JOIN pendaftar
                    ON pendaftar.`id_user_calon_mhs` = user.`id`
                    WHERE user.`role_id` = 4
                    AND pendaftar.id_pengumuman = 2')->result();

        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Admin");
        $objPHPExcel->getProperties()->setLastModifiedBy("Admin");
        $objPHPExcel->getProperties()->setTitle("Data Calon Mahasiswa Tidak Lulus");
        $objPHPExcel->getProperties()->setSubject("");
        $objPHPExcel->getProperties()->setDescription("");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Calon Mahasiswa Tidak Lulus')->mergeCells('A1:BB2')->getStyle()->getFont()->setSize(26)->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Calon Mahasiswa Tidak Lulus')->mergeCells('A1:BB2')->getStyle()->getAlignment('A1')->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'NO PENDAFTAR');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'JALUR SELEKSI');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'NAMA LENGKAP');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'PRODI');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'JENIS KELAMIN');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'PROVINSI TEMPAT LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'TEMPAT LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'TGL LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'TELP/WA');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'EMAIL');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'AGAMA');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ALAMAT');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'KECAMATAN TEMPAT TINGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'KODE POS TEMPAT TINGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'KEWARGANEGARAAN');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'STATUS PERNIKAHAN');

        $objPHPExcel->getActiveSheet()->setCellValue('R3', 'NO TELEPON ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'NAMA AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'PENDIDIKAN TERAKHIR AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'PEKERJAAN AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'PENGHASILAN AYAH');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'NAMA IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'PENDIDIKAN TERAKHIR IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'PEKERJAAN IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'PENGHASILAN IBU');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'ALAMAT ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'PROVINSI ASAL ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'KOTA/KABUPATEN ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AD3', 'KODE POS ALAMAT ORANG TUA');
        $objPHPExcel->getActiveSheet()->setCellValue('AE3', 'NAMA WALI');
        $objPHPExcel->getActiveSheet()->setCellValue('AF3', 'PEKERJAAN WALI');
        $objPHPExcel->getActiveSheet()->setCellValue('AG3', 'ALAMAT LENGKAP WALI');

        $objPHPExcel->getActiveSheet()->setCellValue('AH3', 'TAHUN LULUS SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AI3', 'JURUSAN SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ3', 'JENIS SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AK3', 'NAMA SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AL3', 'PROVINSI ASAL SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AM3', 'ALAMAT LENGKAP SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AN3', 'STATUS KELULUSAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AO3', 'NO IJAZAH SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AP3', 'TANGGAL IJAZAH SMTA');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ3', 'NILAI BHS INDONESIA (SMT III)');
        $objPHPExcel->getActiveSheet()->setCellValue('AR3', 'NILAI BHS INGGRIS (SMT III)');
        $objPHPExcel->getActiveSheet()->setCellValue('AS3', 'NILAI MATEMATIKA (SMT III)');
        $objPHPExcel->getActiveSheet()->setCellValue('AT3', 'NILAI BHS INDONESIA (SMT IV)');
        $objPHPExcel->getActiveSheet()->setCellValue('AU3', 'NILAI BHS INGGRIS (SMT IV)');
        $objPHPExcel->getActiveSheet()->setCellValue('AV3', 'NILAI MATEMATIKA (SMT IV)');
        $objPHPExcel->getActiveSheet()->setCellValue('AW3', 'NILAI BHS INDONESIA (SMT V)');
        $objPHPExcel->getActiveSheet()->setCellValue('AX3', 'NILAI BHS INGGRIS (SMT V)');
        $objPHPExcel->getActiveSheet()->setCellValue('AY3', 'NILAI MATEMATIKA (SMT V)');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ3', 'NILAI UN BHS INDONESIA');
        $objPHPExcel->getActiveSheet()->setCellValue('BA3', 'NILAI UN BHS INGGRIS');
        $objPHPExcel->getActiveSheet()->setCellValue('BB3', 'NILAI UN MATEMATIKA');

        $baris = 4;
        $x = 1;

        foreach ($data['data_mhs'] as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $x);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $data->no_pendaftaran);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $data->jalur_seleksi);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $data->nama_lengkap);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $data->nama_prodi);
            if ($data->jenis_kelamin == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, "Laki - Laki");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, "Perempuan");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $data->provinsi_tempat_lahir);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $data->tempat_lahir);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $data->tanggal_lahir);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $data->telepon);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, $data->email);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, $data->agama);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, $data->alamat);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, $data->nama_kecamatan);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, $data->kode_pos);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, $data->kewarganegaraan);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, $data->status_pernikahan);
            $x++;
            $baris++;
        }
        $baris1 = 4;
        foreach ($ortu as $ot) {
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris1, $ot->telepon_ortu);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $baris1, $ot->nama_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $baris1, $ot->pendidikan_terakhir_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $baris1, $ot->pekerjaan_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $baris1, $ot->penghasilan_ayah);
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $baris1, $ot->nama_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $baris1, $ot->pendidikan_terakhir_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $baris1, $ot->pekerjaan_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $baris1, $ot->penghasilan_ibu);
            $objPHPExcel->getActiveSheet()->setCellValue('AA' . $baris1, $ot->alamat_lengkap_ortu);
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $baris1, $ot->nama_provinsi);
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $baris1, $ot->kabupaten);
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $baris1, $ot->kode_pos_ortu);
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $baris1, $ot->nama_wali);
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $baris1, $ot->pekerjaan_wali);
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $baris1, $ot->alamat_lengkap_wali);
            $baris1++;
        }

        $baris2 = 4;
        foreach ($sekolah as $skl) {
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $baris2, $skl->tahun_lulus);
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $baris2, $skl->jurusan);
            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $baris2, $skl->jenis_sekolah);
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $baris2, $skl->nama_sekolah);
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $baris2, $skl->nama_provinsi);
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $baris2, $skl->alamat_lengkap_sekolah);
            if ($skl->status_kelulusan == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('AN' . $baris2, "Sudah Lulus");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('AN' . $baris2, "Belum Lulus");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $baris2, $skl->no_ijazah);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $baris2, $skl->tgl_ijazah);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $baris2, $skl->bhs_indo_smt3);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $baris2, $skl->bhs_inggris_smt3);
            $objPHPExcel->getActiveSheet()->setCellValue('AS' . $baris2, $skl->matematika_smt3);
            $objPHPExcel->getActiveSheet()->setCellValue('AT' . $baris2, $skl->bhs_indo_smt4);
            $objPHPExcel->getActiveSheet()->setCellValue('AU' . $baris2, $skl->bhs_inggris_smt4);
            $objPHPExcel->getActiveSheet()->setCellValue('AV' . $baris2, $skl->matematika_smt4);
            $objPHPExcel->getActiveSheet()->setCellValue('AW' . $baris2, $skl->bhs_indo_smt5);
            $objPHPExcel->getActiveSheet()->setCellValue('AX' . $baris2, $skl->bhs_inggris_smt5);
            $objPHPExcel->getActiveSheet()->setCellValue('AY' . $baris2, $skl->matematika_smt5);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ' . $baris2, $skl->bhs_indonesia);
            $objPHPExcel->getActiveSheet()->setCellValue('BA' . $baris2, $skl->bhs_inggris);
            $objPHPExcel->getActiveSheet()->setCellValue('BB' . $baris2, $skl->matematika);
            $baris2++;
        }



        $filename = "Data-Mahasiswa" . date("d-m-Y") . '.xlsx';

        $objPHPExcel->getActiveSheet()->setTitle("Data Mahasiswa");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');

        exit;
    }
    public function export_belum_final()
    {
        $data['data_mhs'] = $this->db->query('SELECT * FROM user WHERE user.role_id = 4')->result();

        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Admin");
        $objPHPExcel->getProperties()->setLastModifiedBy("Admin");
        $objPHPExcel->getProperties()->setTitle("Data Calon Mahasiswa Belum Final");
        $objPHPExcel->getProperties()->setSubject("");
        $objPHPExcel->getProperties()->setDescription("");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Calon Mahasiswa Belum Final')->mergeCells('A1:E2')->getStyle()->getFont()->setSize(14)->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Calon Mahasiswa Belum Final')->mergeCells('A1:E2')->getStyle()->getAlignment('A1')->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'NAMA LENGKAP');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'NIK');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'NO WA');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'EMAIL');

        $baris = 4;
        $x = 1;

        foreach ($data['data_mhs'] as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $x);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $data->nama_lengkap);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $data->nik);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $data->no_whatsapp);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $data->email);
            $x++;
            $baris++;
        }

        $filename = "Data-Mahasiswa-Belum-Final" . date("d-m-Y") . '.xlsx';

        $objPHPExcel->getActiveSheet()->setTitle("Data Mahasiswa");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');

        exit;
    }
    public function verifikasi_bayar()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Verifikasi Bayar';

        $sql = "SELECT * FROM `th_ajaran`";

        $data['tahun_ajaran'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/verifikasi_bayar', $data);
        $this->load->view('template/footer');
    }

    public function detail_verifikasi($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Detail Verifikasi Pembayaran';


        // var_dump($id);
        // die;



        // $sql = "SELECT user.id, user.nik, user.nama_lengkap, user.`no_slip`,user.`bukti_bayar`, th_ajaran.id as id_tahun_ajaran, user.status_bayar 
        // FROM user, th_ajaran, pendaftar
        // WHERE pendaftar.`id_th_ajaran` = th_ajaran.`id`
        // AND user.`id` = pendaftar.`id_user_calon_mhs`
        // AND user.`id_th_ajaran` = th_ajaran.`id`
        // AND `th_ajaran`.`id` = $id";

        $sql = "SELECT user.id, user.nik, user.nama_lengkap, user.`no_slip`,user.`bukti_bayar`,  th_ajaran.id AS id_tahun_ajaran, user.`status_bayar`
        FROM user, th_ajaran
        WHERE user.`id_th_ajaran`  = th_ajaran.`id`
        AND `user`.`id_th_ajaran` = $id
        AND user.`no_slip` IS NOT NULL
        AND user.`bukti_bayar` IS NOT NULL
		";

        $data['detail_verifikasi'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/detail_verifikasi', $data);
        $this->load->view('template/footer');
    }

    public function konfirmasi($id_tahun_ajaran, $id)
    {
        $sql = "UPDATE user
                SET user.status_bayar = 1
                WHERE user.id = $id";

        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Status Berhasil diubah !!
      </div>');
        redirect("admin/detail_verifikasi/$id_tahun_ajaran");
    }
    public function batal_konfirmasi($id_tahun_ajaran, $id)
    {
        $sql = "UPDATE user
                SET user.status_bayar = 0
                WHERE user.id = $id";

        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Status Berhasil diubah !!
      </div>');
        redirect("admin/detail_verifikasi/$id_tahun_ajaran");
    }
    public function pembayaran()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';

        $sql = "SELECT pembayaran.id, user.nik, user.`nama_lengkap`,pembayaran.angkatan, pembayaran.jalur, pembayaran.`kode_transaksi`, th_ajaran.`tahun_ajaran`, total_pembayaran
                FROM user, pembayaran, th_ajaran
                WHERE user.`id` = pembayaran.`id_user`
                AND user.`id_th_ajaran` = th_ajaran.`id`
                AND user.role_id = 4";
        $data['pembayaran'] = $this->db->query($sql)->result_array();

        $data['calon_mhs'] = $this->db->get_where('user', ['role_id' => 4])->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/pembayaran', $data);
        $this->load->view('template/footer');
    }

    public function aksi_pembayaran()
    {
        $kode_transaksi = $this->db->query("SELECT MAX(pembayaran.`kode_transaksi`) as kode_bayar FROM pembayaran")->row_array();
        $kode_transaksi = $kode_transaksi['kode_bayar'];
        $urutan = (int)substr($kode_transaksi, 8, 4);
        $urutan++;
        $tanggal = date('dmY');
        $kodeTransaksi = $tanggal . sprintf('%' . '04s', $urutan);
        $nik = $this->input->post('nik');
        $angkatan = $this->input->post('angkatan');
        $jalur = $this->input->post('jalur');
        $total_pembayaran = $this->input->post('total_pembayaran');

        // $cek_data = $this->db->query("SELECT COUNT(user.id) as jumlah FROM user, pembayaran WHERE user.id = pembayaran.id_user AND pembayaran.kode_transaksi = $kodeTransaksi")->row_array();
        // $cek_data = $cek_data['jumlah'];
        $id_user = $this->db->query("SELECT user.id FROM user WHERE user.nik = $nik")->row_array();
        $id_user = $id_user['id'];

        $data = [
            'kode_transaksi' => $kodeTransaksi,
            'angkatan' => $angkatan,
            'jalur' => $jalur,
            'total_pembayaran' => $total_pembayaran,
            'id_user' => $id_user
        ];

        //     if ($cek_data > 0) {
        //         $this->session->set_flashdata('message', '<div class="alert alert-danger text-start" role="alert">
        //     Data sudah ada !!
        //   </div>');
        //         redirect("admin/pembayaran");
        //     }

        $this->db->insert('pembayaran', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Pembayaran berhasil ditambahkan !!
      </div>');
        redirect("admin/pembayaran");
    }
    public function cetak_pembayaran($nik)
    {
        $data['pembayaran'] = $this->db->query("SELECT pembayaran.*, user.nama_lengkap, user.nik FROM user, pembayaran WHERE user.id = pembayaran.id_user AND user.nik = $nik")->row_array();
        $this->load->view('admin/cetak_pembayaran', $data);
    }
    public function pengajuan_beasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pengajuan Beasiswa';

        $data['pengajuan_beasiswa'] = $this->db->query("SELECT pengajuan_beasiswa.id, pengajuan_beasiswa.surat_pengajuan_beasiswa, pengajuan_beasiswa.ktp, pengajuan_beasiswa.status_penerimaan, user.nama_lengkap
        FROM pengajuan_beasiswa, user
        WHERE pengajuan_beasiswa.id_user = user.id")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/pengajuan_beasiswa', $data);
        $this->load->view('template/footer');
    }
    public function jadwal_beasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Jadwal Beasiswa';

        $data['jadwal_beasiswa'] = $this->db->query("SELECT * FROM jadwal_beasiswa")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/jadwal_beasiswa', $data);
        $this->load->view('template/footer');
    }
    public function tambah_jadwal_beasiswa()
    {
        $data = [
            'nama_beasiswa' => $this->input->post('nama_beasiswa'),
            'dari_tanggal' => $this->input->post('dari_tanggal'),
            'sampai_tanggal' => $this->input->post('sampai_tanggal'),
            'is_active' => $this->input->post('is_active')
        ];

        $this->db->insert('jadwal_beasiswa', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Jadwal beasiswa berhasil ditambahkan !!
      </div>');
        redirect("admin/jadwal_beasiswa");
    }
    public function edit_jadwal_beasiswa()
    {
        $id = $this->input->post('id');

        $nama_beasiswa = $this->input->post('nama_beasiswa');
        $dari_tanggal = $this->input->post('dari_tanggal');
        $sampai_tanggal = $this->input->post('sampai_tanggal');
        $is_active = $this->input->post('is_active');

        $this->db->query("UPDATE jadwal_beasiswa
        SET nama_beasiswa = '$nama_beasiswa', dari_tanggal = '$dari_tanggal', sampai_tanggal = '$sampai_tanggal', is_active = '$is_active'
        WHERE id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Jadwal beasiswa berhasil diubah !!
      </div>');
        redirect("admin/jadwal_beasiswa");
    }
    public function delete_jadwal_beasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jadwal_beasiswa');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Jadwal Beasiswa Berhasil Di hapus.
      </div>');

        redirect('admin/jadwal_beasiswa');
    }
    public function terima_beasiswa($id)
    {
        $this->db->query("UPDATE pengajuan_beasiswa
            SET pengajuan_beasiswa.status_penerimaan = 'A'
            WHERE id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
            Status pengajuan beasiswa berhasil diubah !!
          </div>');
        redirect("admin/pengajuan_beasiswa");
    }
    public function tolak_beasiswa($id)
    {
        $this->db->query("UPDATE pengajuan_beasiswa
            SET pengajuan_beasiswa.status_penerimaan = 'T'
            WHERE id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
            Status pengajuan beasiswa berhasil diubah !!
          </div>');
        redirect("admin/pengajuan_beasiswa");
    }
    public function batalkan_beasiswa($id)
    {
        $this->db->query("UPDATE pengajuan_beasiswa
            SET pengajuan_beasiswa.status_penerimaan = 'P'
            WHERE id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
            Status pengajuan beasiswa berhasil diubah !!
          </div>');
        redirect("admin/pengajuan_beasiswa");
    }
    public function kelulusan()
    {
        $lulus_di = $this->input->post('lulus_di');
        $id_user = $this->input->post('id_user');
        $id = $this->input->post('id_pendaftar');
        $sql = "UPDATE pendaftar, user
        SET pendaftar.id_pengumuman = 1, pendaftar.lulus_di = '$lulus_di'
        WHERE pendaftar.id_user_calon_mhs = user.id
        AND user.id = $id_user
        AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
    Status calon mahasiswa lulus
  </div>');
        redirect("admin/data_sudah_finalisasi");
    }
    public function tidak_kelulusan($id_user, $id)
    {
        $sql = "UPDATE pendaftar, user
        SET pendaftar.id_pengumuman = 2
        WHERE pendaftar.id_user_calon_mhs = user.id
        AND user.id = $id_user
        AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
    Status calon mahasiswa lulus
  </div>');
        redirect("admin/data_sudah_finalisasi");
    }
    public function batalkan_kelulusan($id_user, $id)
    {
        $sql = "UPDATE pendaftar, user
        SET pendaftar.id_pengumuman = NULL, pendaftar.lulus_di = NULL
        WHERE pendaftar.id_user_calon_mhs = user.id
        AND user.id = $id_user
        AND pendaftar.id = $id";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
    Kelulusan dibatalkan
  </div>');
        redirect("admin/data_sudah_finalisasi");
    }
    public function jadwal_daftar_ulang()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Jadwal Daftar Ulang';

        $data['jadwal_daftar_ulang'] = $this->db->query("SELECT * FROM jadwal_daftar_ulang")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/jadwal_daftar_ulang', $data);
        $this->load->view('template/footer');
    }
    public function edit_jadwal_daftar_ulang()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $this->input->post('id');

        $jadwal_daftar_ulang = $this->input->post('jadwal_daftar_ulang');
        $sampai_tanggal = $this->input->post('sampai_tanggal');
        $is_active = $this->input->post('is_active');

        $this->db->query("UPDATE jadwal_daftar_ulang
        SET jadwal_daftar_ulang = '$jadwal_daftar_ulang', sampai_tanggal = '$sampai_tanggal', is_active = '$is_active'
        WHERE id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Jadwal daftar ulang berhasil diubah !!
      </div>');
        redirect("admin/jadwal_daftar_ulang");
    }
    public function daftar_ulang_mahasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Ulang';

        $data['ukt'] = $this->db->query("SELECT ukt.id, ukt.status_daftar_ulang, ukt.slip_gaji, ukt.foto_rumah, ukt.struk_listrik, ukt.kartu_keluarga, ukt_pekerjaan.detail_pekerjaan, ukt_pekerjaan.bobot, ukt_pendapatan.detail_pendapatan, ukt_pendapatan.bobot, ukt_kondisi_rumah.detail_kondisi_rumah, ukt_kondisi_rumah.bobot, ukt_listrik.detail_listrik, ukt_listrik.bobot, ukt_tanggungan.detail_tanggungan, ukt_tanggungan.bobot
        FROM ukt, ukt_kondisi_rumah, ukt_listrik, ukt_pekerjaan, ukt_pendapatan, ukt_tanggungan, user
        WHERE ukt.id_ukt_pekerjaan = ukt_pekerjaan.id
        AND ukt.id_ukt_pendapatan = ukt_pendapatan.id
        AND ukt.id_ukt_kondisi_rumah = ukt_kondisi_rumah.id
        AND ukt.id_ukt_listrik = ukt_listrik.id
        AND ukt.id_ukt_tanggungan = ukt_tanggungan.id
        AND ukt.id_user = user.id")->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/daftar_ulang', $data);
        $this->load->view('template/footer');
    }
    public function daftar_ulang_karawitan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Ulang Karawitan';

        $data['ukt'] = $this->db->query("SELECT ukt.id, ukt.status_daftar_ulang, ukt.slip_gaji, ukt.foto_rumah, ukt.struk_listrik, ukt.kartu_keluarga, ukt_pekerjaan.detail_pekerjaan, ukt_pekerjaan.bobot, ukt_pendapatan.detail_pendapatan, ukt_pendapatan.bobot, ukt_kondisi_rumah.detail_kondisi_rumah, ukt_kondisi_rumah.bobot, ukt_listrik.detail_listrik, ukt_listrik.bobot, ukt_tanggungan.detail_tanggungan, ukt_tanggungan.bobot, user.nama_lengkap, prodi.nama_prodi, user.id AS id_user, ukt.total_bobot, ukt.jenis_ukt
        FROM ukt, ukt_kondisi_rumah, ukt_listrik, ukt_pekerjaan, ukt_pendapatan, ukt_tanggungan, user, pendaftar, prodi
        WHERE ukt.id_ukt_pekerjaan = ukt_pekerjaan.id
        AND ukt.id_ukt_pendapatan = ukt_pendapatan.id
        AND ukt.id_ukt_kondisi_rumah = ukt_kondisi_rumah.id
        AND ukt.id_ukt_listrik = ukt_listrik.id
        AND ukt.id_ukt_tanggungan = ukt_tanggungan.id
        AND ukt.id_user = user.id
        AND user.id = pendaftar.id_user_calon_mhs
        AND pendaftar.id_prodi = prodi.id
        AND prodi.id = 2")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/daftar_ulang_karawitan', $data);
        $this->load->view('template/footer');
    }
    public function daftar_ulang_tari()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Ulang Tari';

        $data['ukt'] = $this->db->query("SELECT ukt.id, ukt.status_daftar_ulang, ukt.slip_gaji, ukt.foto_rumah, ukt.struk_listrik, ukt.kartu_keluarga, ukt_pekerjaan.detail_pekerjaan, ukt_pekerjaan.bobot, ukt_pendapatan.detail_pendapatan, ukt_pendapatan.bobot, ukt_kondisi_rumah.detail_kondisi_rumah, ukt_kondisi_rumah.bobot, ukt_listrik.detail_listrik, ukt_listrik.bobot, ukt_tanggungan.detail_tanggungan, ukt_tanggungan.bobot, user.nama_lengkap, prodi.nama_prodi,user.id AS id_user, ukt.total_bobot, ukt.jenis_ukt
        FROM ukt, ukt_kondisi_rumah, ukt_listrik, ukt_pekerjaan, ukt_pendapatan, ukt_tanggungan, user, pendaftar, prodi
        WHERE ukt.id_ukt_pekerjaan = ukt_pekerjaan.id
        AND ukt.id_ukt_pendapatan = ukt_pendapatan.id
        AND ukt.id_ukt_kondisi_rumah = ukt_kondisi_rumah.id
        AND ukt.id_ukt_listrik = ukt_listrik.id
        AND ukt.id_ukt_tanggungan = ukt_tanggungan.id
        AND ukt.id_user = user.id
        AND user.id = pendaftar.id_user_calon_mhs
        AND pendaftar.id_prodi = prodi.id
        AND prodi.id = 1")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/daftar_ulang_tari', $data);
        $this->load->view('template/footer');
    }
    public function daftar_ulang_kriya()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Ulang Kriya';

        $data['ukt'] = $this->db->query("SELECT ukt.id, ukt.status_daftar_ulang, ukt.slip_gaji, ukt.foto_rumah, ukt.struk_listrik, ukt.kartu_keluarga, ukt_pekerjaan.detail_pekerjaan, ukt_pekerjaan.bobot, ukt_pendapatan.detail_pendapatan, ukt_pendapatan.bobot, ukt_kondisi_rumah.detail_kondisi_rumah, ukt_kondisi_rumah.bobot, ukt_listrik.detail_listrik, ukt_listrik.bobot, ukt_tanggungan.detail_tanggungan, ukt_tanggungan.bobot, user.nama_lengkap, prodi.nama_prodi, user.id AS id_user, ukt.total_bobot, ukt.jenis_ukt
        FROM ukt, ukt_kondisi_rumah, ukt_listrik, ukt_pekerjaan, ukt_pendapatan, ukt_tanggungan, user, pendaftar, prodi
        WHERE ukt.id_ukt_pekerjaan = ukt_pekerjaan.id
        AND ukt.id_ukt_pendapatan = ukt_pendapatan.id
        AND ukt.id_ukt_kondisi_rumah = ukt_kondisi_rumah.id
        AND ukt.id_ukt_listrik = ukt_listrik.id
        AND ukt.id_ukt_tanggungan = ukt_tanggungan.id
        AND ukt.id_user = user.id
        AND user.id = pendaftar.id_user_calon_mhs
        AND pendaftar.id_prodi = prodi.id
        AND prodi.id = 3")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/daftar_ulang_kriya', $data);
        $this->load->view('template/footer');
    }
    public function konfirmasi_daftar_ulang($id, $title)
    {
        $this->db->query("UPDATE ukt
                            SET ukt.status_daftar_ulang = 1
                            WHERE ukt.id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Status daftar ulang telah terkonfirmasi !
      </div>');
        if ($title == 'DaftarUlangKarawitan') {

            redirect("admin/daftar_ulang_karawitan");
        } elseif ($title == 'DaftarUlangTari') {
            redirect("admin/daftar_ulang_tari");
        } else {
            redirect("admin/daftar_ulang_kriya");
        }
    }
    public function batal_konfirmasi_daftar_ulang($id, $title)
    {
        $this->db->query("UPDATE ukt
                            SET ukt.status_daftar_ulang = NULL
                            WHERE ukt.id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Konfirmasi daftar ulang berhasil dibatalkan !
      </div>');
        if ($title == 'DaftarUlangKarawitan') {
            redirect("admin/daftar_ulang_karawitan");
        } elseif ($title == 'DaftarUlangTari') {
            redirect("admin/daftar_ulang_tari");
        } else {
            redirect("admin/daftar_ulang_kriya");
        }
    }
    public function hapus_daftar_ulang($id, $title, $id_user)
    {
        $this->db->query("DELETE FROM ukt WHERE ukt.id= $id");

        $this->db->query("UPDATE user
                            SET user.isi_data_ukt = 0
                            WHERE user.id = $id_user");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Formulir isian penetuan UKT berhasil dihapus !
      </div>');
        if ($title == 'DaftarUlangKarawitan') {
            redirect("admin/daftar_ulang_karawitan");
        } elseif ($title == 'DaftarUlangTari') {
            redirect("admin/daftar_ulang_tari");
        } else {
            redirect("admin/daftar_ulang_kriya");
        }
    }
    public function detail_ukt($id)
    {
        $data['title'] = 'Formulir UKT';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['ukt'] = $this->db->query("SELECT ukt.id, ukt.status_daftar_ulang, ukt.slip_gaji, ukt.foto_rumah, ukt.struk_listrik, ukt.kartu_keluarga, ukt_pekerjaan.detail_pekerjaan, ukt_pekerjaan.bobot, ukt_pendapatan.detail_pendapatan, ukt_pendapatan.bobot, ukt_kondisi_rumah.detail_kondisi_rumah, ukt_kondisi_rumah.bobot, ukt_listrik.detail_listrik, ukt_listrik.bobot, ukt_tanggungan.detail_tanggungan, ukt_tanggungan.bobot, user.nama_lengkap
        FROM ukt, ukt_kondisi_rumah, ukt_listrik, ukt_pekerjaan, ukt_pendapatan, ukt_tanggungan, user
        WHERE ukt.id_ukt_pekerjaan = ukt_pekerjaan.id
        AND ukt.id_ukt_pendapatan = ukt_pendapatan.id
        AND ukt.id_ukt_kondisi_rumah = ukt_kondisi_rumah.id
        AND ukt.id_ukt_listrik = ukt_listrik.id
        AND ukt.id_ukt_tanggungan = ukt_tanggungan.id
        AND ukt.id_user = user.id
        AND ukt.id = $id")->row_array();

        $data['pekerjaan'] = $this->db->get('ukt_pekerjaan')->result_array();
        $data['pendapatan'] = $this->db->get('ukt_pendapatan')->result_array();
        $data['kondisi_rumah'] = $this->db->get('ukt_kondisi_rumah')->result_array();
        $data['listrik'] = $this->db->get('ukt_listrik')->result_array();
        $data['tanggungan'] = $this->db->get('ukt_tanggungan')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/detail_ukt');
        $this->load->view('template/footer');
    }
    public function edit_ukt()
    {
        $id = $this->input->post('id');
        $ukt = $this->input->post('ukt');

        $this->db->query("UPDATE ukt
        SET ukt.jenis_ukt = '$ukt' 
        WHERE ukt.id = $id;");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Jenis UKT berhasi diubah !
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function pembayaran_online()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran Online';

        $data['pembayaran_online'] = $this->db->query("SELECT pembayaran_online.id,user.id as user_id, user.nik, user.nama_lengkap, pembayaran_online.no_pembayaran, pembayaran_online.bukti_bayar, pembayaran_online.status_pembayaran, pembayaran_online.total_pembayaran, th_ajaran.tahun_ajaran, pembayaran_online.jalur_pendaftaran
                                                    FROM user, pembayaran_online, th_ajaran
                                                    WHERE user.id = pembayaran_online.id_user
                                                    AND th_ajaran.id = user.id_th_ajaran
                                                    AND user.id = pembayaran_online.id_user")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/pembayaran_online', $data);
        $this->load->view('template/footer');
    }
    public function cetak_bukti_pembayaran()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran Online';

        $data['pembayaran'] = $this->db->query("SELECT pembayaran_online.id,user.id as user_id, user.nik, user.nama_lengkap, pembayaran_online.no_pembayaran, pembayaran_online.bukti_bayar, pembayaran_online.status_pembayaran, pembayaran_online.total_pembayaran, th_ajaran.tahun_ajaran, pembayaran_online.jalur_pendaftaran
                                                    FROM user, pembayaran_online, th_ajaran
                                                    WHERE user.id = pembayaran_online.id_user
                                                    AND th_ajaran.id = user.id_th_ajaran
                                                    AND user.id = pembayaran_online.id_user")->row_array();
        $this->load->view('admin/cetak_bukti_pembayaran', $data);
    }
    public function konfirmasi_pembayaran_online($id)
    {
        $this->db->query("UPDATE pembayaran_online
                            SET pembayaran_online.status_pembayaran = 1
                            WHERE pembayaran_online.id = $id");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Pembayaran berhasil dikonfirmasi
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function batalkan_konfirmasi_pembayaran_online($id)
    {
        $this->db->query("UPDATE pembayaran_online
                            SET pembayaran_online.status_pembayaran = 0
                            WHERE pembayaran_online.id = $id");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Konfirmasi berhasi dibatalkan
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_pembayaran_online($id, $id_user)
    {
        $this->db->query("DELETE FROM pembayaran_online WHERE pembayaran_online.id = $id");
        $this->db->query("UPDATE user
                            SET user.status_bayar = NULL
                            WHERE user.id = $id_user");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Pembayaran berhasil dihapus !
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function jalur_prestasi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Konfirmasi Persyaratan';

        $data['jalur_prestasi'] = $this->db->query("SELECT daftar_jalur_prestasi.id,user.id as user_id, user.nik, user.nama_lengkap,  th_ajaran.tahun_ajaran, daftar_jalur_prestasi.surat_rekomendasi, daftar_jalur_prestasi.portofolio, daftar_jalur_prestasi.status
                                                    FROM user, daftar_jalur_prestasi, th_ajaran
                                                    WHERE user.id = daftar_jalur_prestasi.id_user
                                                    AND th_ajaran.id = user.id_th_ajaran
                                                    AND user.id = daftar_jalur_prestasi.id_user")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/jalur_prestasi', $data);
        $this->load->view('template/footer');
    }
    public function konfirmasi_syarat_jalur_prestasi($id)
    {
        $this->db->query("UPDATE daftar_jalur_prestasi
                            SET daftar_jalur_prestasi.status = 1
                            WHERE daftar_jalur_prestasi.id = $id");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Persyaratan berhasil dikonfirmasi
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function batalkan_konfirmasi_syarat_jalur_prestasi($id)
    {
        $this->db->query("UPDATE daftar_jalur_prestasi
                            SET daftar_jalur_prestasi.status = 0
                            WHERE daftar_jalur_prestasi.id = $id");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Konfirmasi berhasi dibatalkan
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_jalur_prestasi($id, $id_user)
    {
        $this->db->query("DELETE FROM daftar_jalur_prestasi WHERE daftar_jalur_prestasi.id = $id");
        $this->db->query("UPDATE user
                            SET user.status_bayar = NULL
                            WHERE user.id = $id_user");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Pengajuan berhasil dihapus !
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function jalur_pkl()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Konfirmasi Tiket';

        $data['jalur_pkl'] = $this->db->query("SELECT tiket.id,user.id as user_id, user.nik, user.nama_lengkap,  th_ajaran.tahun_ajaran, tiket.kode_tiket, tiket.scan_tiket, tiket.status
                                                    FROM user, tiket, th_ajaran
                                                    WHERE th_ajaran.id = user.id_th_ajaran
                                                    AND user.id = tiket.id_user")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/jalur_pkl', $data);
        $this->load->view('template/footer');
    }
    public function konfirmasi_jalur_pkl($id)
    {
        $this->db->query("UPDATE tiket
                            SET tiket.status = 1
                            WHERE tiket.id = $id");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Tiket berhasil dikonfirmasi
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function batalkan_konfirmasi_jalur_pkl($id)
    {
        $this->db->query("UPDATE tiket
                            SET tiket.status = 0
                            WHERE tiket.id = $id");

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Konfirmasi berhasi dibatalkan
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_jalur_pkl($id, $id_user)
    {
        $this->db->query("DELETE FROM tiket WHERE tiket.id = $id");
        $this->db->query("UPDATE user
                            SET user.status_bayar = NULL
                            WHERE user.id = $id_user");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Tiket berhasil dihapus !
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function pengumuman_manual()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pengumuman Manual';

        $sql = "SELECT pengumuman_manual.id, jadwal.id as id_jadwal, jadwal.gelombang, pengumuman_manual.file_pengumuman 
        FROM pengumuman_manual, jadwal WHERE pengumuman_manual.id_jadwal = jadwal.id";
        $data['pengumuman'] = $this->db->query($sql)->result_array();

        $data['gelombang'] = $this->db->get('jadwal')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/pengumuman_manual', $data);
        $this->load->view('template/footer');
    }
    public function tambah_penguman_manual()
    {
        $gelombang = $this->input->post('gelombang');
        $file_pengumuman = $_FILES['file_pengumuman'];

        if ($file_pengumuman = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/pengumuman';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file_pengumuman')) {
                echo "Upload Gagal";
                die();
            } else {
                $file_pengumuman = $this->upload->data('file_name');
            }
        }

        $data = [
            'id_jadwal' => $gelombang,
            'file_pengumuman' => $file_pengumuman,
        ];

        $this->db->insert('pengumuman_manual', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Data berhasil ditambahkan !
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_pengumuman_manual($id)
    {
        $this->db->query("DELETE FROM pengumuman_manual WHERE pengumuman_manual.id = $id");
        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Pengumuman berhasil dihapus !
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
}