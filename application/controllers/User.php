<?php

use phpDocumentor\Reflection\Types\This;

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_log_in();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('base_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('template/footer');
    }

    public function formulir()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user = $data['user']['id'];
        $data['user_id'] = $data['user']['id'];
        $role_id = $data['user']['role_id'];

        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id_user")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id_user")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];



            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }

            if ($cek_verifikasi == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu verifikasi pembayaran ! </div>');
                redirect('user/tunggu');
            }
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {
            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $id_user")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $id_user")->row_array();
            $cek_verifikasi =  $cek_verifikasi['status'];

            if ($data['user']['status_bayar'] == NULL && $cek_syarat == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi persyaratan terlebih dahulu </div>');
                redirect('user/upload_syarat');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        } else {
            $cek_tiket = $this->db->query("SELECT count(tiket.id) as id_tiket
            FROM tiket, user
            WHERE tiket.id_user = user.id
            AND tiket.id_user = $id_user")->row_array();
            $cek_tiket = $cek_tiket['id_tiket'];

            $cek_verifikasi = $this->db->query("SELECT tiket.status
            FROM tiket, user
            WHERE tiket.id_user = user.id
            AND user.id = $id_user")->row_array();
            $cek_verifikasi =  $cek_verifikasi['status'];

            if ($data['user']['status_bayar'] == NULL && $cek_tiket == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti tiket terlebih dahulu </div>');
                redirect('user/upload_kupon');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        }

        $data['provinsi'] = $this->base_model->getDataProv();
        $data['prodi'] = $this->db->get('prodi')->result_array();
        $data['sekolah'] = $this->db->get('sekolah')->result_array();
        $data['kabupaten_diy'] = $this->db->get('kabupaten_diy')->result_array();

        $sql2 = "SELECT DISTINCT(sekolah.status) FROM sekolah";
        $data['status_sekolah'] = $this->db->query($sql2)->result_array();

        $sesi = $data['user']['role_id'];
        $cek_isi = $data['user']['cek_isi'];

        $sql = "SELECT * FROM th_ajaran WHERE th_ajaran.is_active = 1";

        $data['th_ajaran'] = $this->db->query($sql)->result_array();

        $sql3 = "SELECT user.id AS id_user, user.nik, user.`email`, pendaftar.*, prodi.`nama_prodi`, prodi.`ruangan_praktek`, prodi.`ruangan_wawancara`
        FROM user, pendaftar, prodi
        WHERE user.`id` = pendaftar.`id_user_calon_mhs` 
        AND pendaftar.`id_prodi` = prodi.`id` AND user.id = $id_user";

        $data['pendaftar'] = $this->db->query($sql3)->result_array();


        if ($cek_isi == 0 && $sesi == 4) {
            $data['title'] = 'Formulir Pendaftaran';
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/formulir1', $data);
            $this->load->view('template/footer');
        } elseif ($cek_isi == 1 && $sesi == 4) {
            $data['title'] = 'Formulir Pendaftaran';

            $sql = "SELECT * 
            FROM user, `pendaftar`, provinsi, kabupaten, kecamatan
            WHERE user.`id` = pendaftar.`id_user_calon_mhs`
            AND pendaftar.id_provinsi = provinsi.id
            AND pendaftar.id_kabupaten = kabupaten.id
            AND pendaftar.id_kecamatan = kecamatan.id
            AND user.role_id = $sesi
            AND user.id = $id_user";

            $data['formulir'] = $this->db->query($sql)->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/data_formulir', $data);
            $this->load->view('template/footer');
        }
    }
    public function cetak_kartu_test($id, $id_user)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT pendaftar.`no_pendaftaran`, pendaftar.`nama_lengkap`, pendaftar.`tempat_lahir`, pendaftar.`tanggal_lahir`, pendaftar.`jenis_kelamin`, prodi.nama_prodi, prodi.ruangan_praktek, prodi.ruangan_wawancara, jadwal.`tgl_test`, pendaftar.pas_foto, th_ajaran.tahun_ajaran,jadwal.gelombang
        FROM user, pendaftar, jadwal, prodi, th_ajaran
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND jadwal.`id` = pendaftar.`id_jadwal`
        AND prodi.id = pendaftar.`id_prodi`
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
    public function biodata()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user = $data['user']['id'];
        $sesi = $data['user']['role_id'];
        $this->load->library('dompdf_gen');

        $sql = "SELECT * 
        FROM user, `pendaftar`, provinsi, kabupaten, kecamatan
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND pendaftar.id_provinsi = provinsi.id
        AND pendaftar.id_kabupaten = kabupaten.id
        AND pendaftar.id_kecamatan = kecamatan.id
        AND user.role_id = $sesi
        AND user.id = $id_user";
        $data['biodata'] = $this->db->query($sql)->result_array();
        $this->load->view('user/biodata', $data);

        $paper_size = 'A4';
        $orientation = 'potrait';

        $html = $this->output->get_output();
        $this->dompdf->set_paper($paper_size, $orientation);

        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream('biodata.pdf', array('Attachment' => 0));
    }
    public function kabupaten()
    {
        $idprov = $this->input->post('id');
        $data = $this->base_model->getDataKabupaten($idprov);
        $output = '<option value="">Pilih Kabupaten</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->kabupaten . '</option>';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function sekolah_asal()
    {
        $idkab = $this->input->post('id');
        $data = $this->base_model->getDataSekolah($idkab);
        $output = '<option value="">Pilih Sekolah</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->nama_sekolah . '">' . $row->nama_sekolah . '</option>';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function kabupaten_asal_orang_tua()
    {
        $idprov = $this->input->post('id');
        $data = $this->base_model->getDataKabupaten($idprov);
        $output = '<option value="">Pilih Kabupaten asal orangtua</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->kabupaten . '</option>';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function kecamatan()
    {
        $idkabupaten = $this->input->post('id');
        $data = $this->base_model->getDataKecamatan($idkabupaten);
        $output = '<option value="" disabled selected>Pilih Kecamatan</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->nama_kecamatan . '</option>';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function aksi_tambah_formulir()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $nama_lengkap = $this->input->post('nama_lengkap');
        $jalur_seleksi = $this->input->post('jalur_seleksi');
        $prodi = $this->input->post('prodi');
        $prodi2 = $this->input->post('prodi2');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $provinsi_tempat_lahir = $this->input->post('provinsi_tempat_lahir');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $status_pernikahan = $this->input->post('status_pernikahan');
        $agama = $this->input->post('agama');
        $nisn = $this->input->post('nisn');
        $no_hp = $this->input->post('no_hp');
        $email = $data['user']['email'];
        $alamat = $this->input->post('alamat_lengkap');
        $provinsi_tinggal = $this->input->post('provinsi');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('kecamatan');
        $kodepos = $this->input->post('kode_pos');
        $kewarganegaraan = $this->input->post('kewarganegaraan');
        $no_daftar = "PMB-" . rand(0, 1000);
        $pas_foto = $_FILES['pas_foto'];

        if ($pas_foto = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/pas_foto';
            $config['allowed_types'] = 'png|jpg|jpeg|gif';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('pas_foto')) {
                echo "Upload Gagal";
                die();
            } else {
                $pas_foto = $this->upload->data('file_name');
            }
        }
        $id_user_calon_mhs = $data['user']['id'];

        $sql7 = "SELECT th_ajaran.`id` FROM th_ajaran WHERE th_ajaran.`is_active` = 1";
        $tahun_ajaran = $this->db->query($sql7)->row_array();
        $tahun_ajaran = $tahun_ajaran['id'];

        $gelombang = $this->db->query("SELECT `th_ajaran`.`id` 
        FROM `th_ajaran`
        WHERE th_ajaran.`is_active` = 1")->row_array();
        $gelombang = $tahun_ajaran['id'];

        $data = [
            'no_pendaftaran' => $no_daftar,
            'nama_lengkap' => $nama_lengkap,
            'jalur_seleksi' => $jalur_seleksi,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tgl_lahir,
            'provinsi_tempat_lahir' => $provinsi_tempat_lahir,
            'agama' => $agama,
            'nisn' => $nisn,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
            'telepon' => $no_hp,
            'status_pernikahan' => $status_pernikahan,
            'kode_pos' => $kodepos,
            'kewarganegaraan' => $kewarganegaraan,
            'id_prodi' => $prodi,
            'id_prodi2' => $prodi2,
            'id_provinsi' => $provinsi_tinggal,
            'id_kabupaten' => $kabupaten,
            'id_kecamatan' => $kecamatan,
            'id_th_ajaran' => $tahun_ajaran,
            'id_pengumuman' => NULL,
            'id_jadwal' => $gelombang,
            'date_created' => date("Y-m-d"),
            'id_user_calon_mhs' => $id_user_calon_mhs,
            'pas_foto' => $pas_foto,
            'status_finalisasi' => 0,
            'status_validasi_berkas' => 0
        ];
        $this->db->set($data);
        $this->db->insert('pendaftar');
        $sql3 = "SELECT pendaftar.date_created 
                    FROM pendaftar, user 
                    WHERE user.id = pendaftar.id_user_calon_mhs
                    AND user.id = $id_user_calon_mhs";
        $date_created = $this->db->query($sql3)->row_array();
        $date_created = date('Y-m-d');
        $sql2 = "SELECT jadwal.tgl_berakhir FROM jadwal";
        $id_jadwal = 1;
        $tgl_berakhir = $this->db->query($sql2)->result_array();

        $jumlah_jadwal = count($tgl_berakhir);

        for ($i = 0; $i < $jumlah_jadwal; $i++) {
            if ($date_created > $tgl_berakhir[$i]['tgl_berakhir']) {
                $id_jadwal += 1;
            }
        }


        // $sql4 = "UPDATE pendaftar , user 
        //             SET pendaftar.id_jadwal = $id_jadwal 
        //             WHERE user.id = pendaftar.id_user_calon_mhs
        //             AND user.id = $id_user_calon_mhs";

        // $this->db->query($sql4);

        // $sql = "UPDATE user SET user.cek_isi = 1 WHERE user.id = $id_user_calon_mhs";

        // $this->db->query($sql);
        $sql = "UPDATE user SET user.isi_biodata = 1 WHERE user.id = $id_user_calon_mhs";

        $this->db->query($sql);

        $sql6 = "SELECT pendaftar.pas_foto FROM pendaftar WHERE pendaftar.id_user_calon_mhs = $id_user_calon_mhs";

        $foto = $this->db->query($sql6)->row_array();
        $foto = base_url('assets/img/pas_foto/') . $foto['pas_foto'];

        $this->generate_qrcode($foto, $no_daftar);

        // $this->_email($nama_lengkap, $email);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data diri berhasil disimpan. </div>');
        redirect('user/formulir');
    }
    public function aksi_tambah_sekolah_asal()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $nama_sekolah = $this->input->post('nama_sekolah');
        $nama_sekolah1 = $this->input->post('nama_sekolah1');

        if ($nama_sekolah == 'lainnya') {
            $nama_sekolah2 = $nama_sekolah1;
        } else {
            $nama_sekolah2 = $nama_sekolah;
        }
        $jenis_sekolah = $this->input->post('jenis_sekolah');
        $provinsi_asal_sekolah = $this->input->post('provinsi_asal_sekolah');
        $alamat_lengkap_sekolah = $this->input->post('alamat_lengkap_sekolah');
        $status_kelulusan = $this->input->post('status_kelulusan');
        $jurusan = $this->input->post('jurusan');
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

        $id_user_calon_mhs = $data['user']['id'];

        $data = [
            'nama_sekolah' => $nama_sekolah2,
            'jenis_sekolah' => $jenis_sekolah,
            'alamat_lengkap_sekolah' => $alamat_lengkap_sekolah,
            'jurusan' => $jurusan,
            'status_kelulusan' => $status_kelulusan,
            'tahun_lulus' => $tahun_lulus,
            'no_ijazah' => $no_ijazah,
            'tgl_ijazah' => $tgl_ijazah,
            'bhs_indo_smt3' => $bhs_indonesia_smt3,
            'bhs_inggris_smt3' => $bhs_inggris_smt3,
            'matematika_smt3' => $matematika_smt3,
            'bhs_indo_smt4' => $bhs_indonesia_smt4,
            'bhs_inggris_smt4' => $bhs_inggris_smt4,
            'matematika_smt4' => $matematika_smt4,
            'bhs_indo_smt5' => $bhs_indonesia_smt5,
            'bhs_inggris_smt5' => $bhs_inggris_smt5,
            'matematika_smt5' => $matematika_smt5,
            'bhs_indonesia' => $bhs_indonesia,
            'bhs_inggris' => $bhs_inggris,
            'matematika' => $matematika,
            'id_user_calon_mhs' => $id_user_calon_mhs,
            'id_provinsi' => $provinsi_asal_sekolah
        ];
        $this->db->set($data);
        $this->db->insert('detail_sekolah');

        $sql = "UPDATE user SET user.isi_sekolah_asal = 1 WHERE user.id = $id_user_calon_mhs";
        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data sekolah berhasil disimpan. </div>');
        redirect('user/formulir');
    }
    public function aksi_tambah_prestasi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $jenis_kegiatan_lomba = $this->input->post('jenis_kegiatan_lomba');
        $tingkat_kejuaraan = $this->input->post('tingkat_kejuaraan');
        $prestasi_juara_ke = $this->input->post('prestasi_juara_ke');
        $id_user_calon_mhs = $data['user']['id'];

        
        $bukti = $_FILES['bukti'];

        if ($bukti = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/bukti_sertifikat';
            $config['allowed_types'] = 'pdf|png|jpg|jpeg|PNG';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('bukti')) {
                echo "Upload Gagal";
                die();
            } else {
                $bukti = $this->upload->data('file_name');
            }
        }

        $data = [
            'jenis_kegiatan_lomba' => $jenis_kegiatan_lomba,
            'tingkat_kejuaraan' => $tingkat_kejuaraan,
            'prestasi_juara_ke' => $prestasi_juara_ke,
            'bukti' => $bukti,
            'id_user_calon_mhs' => $id_user_calon_mhs
        ];

        $this->db->insert('data_prestasi', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data prestasi berhasil disimpan. </div>');
        redirect('user/formulir');
    }
    public function prestasi_selesai()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user_calon_mhs = $data['user']['id'];
        $sql = "UPDATE user SET user.isi_prestasi = 1 WHERE user.id = $id_user_calon_mhs";
        $this->db->query($sql);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data prestasi telah disimpan. </div>');
        redirect('user/formulir');
    }
    public function aksi_tambah_data_ortu()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user_calon_mhs = $data['user']['id'];

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

        $data = [
            'nama_ayah' => $nama_ayah,
            'pendidikan_terakhir_ayah' => $pendidikan_terakhir_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'penghasilan_ayah' => $penghasilan_ayah,
            'nama_ibu' => $nama_ibu,
            'pendidikan_terakhir_ibu' => $pendidikan_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'penghasilan_ibu' => $penghasilan_ibu,
            'alamat_lengkap_ortu' => $alamat_lengkap_ortu,
            'id_provinsi_asal_ortu' => $provinsi_asal_orang_tua,
            'id_kabupaten_ortu' => $kabupaten_asal_orang_tua,
            'kode_pos_ortu' => $kodepos_alamat_orang_tua,
            'telepon_ortu' => $no_telp_orang_tua,
            'nama_wali' => $nama_wali,
            'pekerjaan_wali' => $pekerjaan_wali,
            'alamat_lengkap_wali' => $alamat_lengkap_wali,
            'id_user_calon_mhs' => $id_user_calon_mhs
        ];

        $this->db->insert('data_ortu', $data);

        $sql = "UPDATE user SET user.isi_data_ortu = 1 WHERE user.id = $id_user_calon_mhs";
        $this->db->query($sql);
        $sql1 = "UPDATE user SET user.cek_isi = 1 WHERE user.id = $id_user_calon_mhs";
        $this->db->query($sql1);

        $sql2 = "SELECT pendaftar.id 
        FROM user, pendaftar
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND user.`id` = $id_user_calon_mhs";

        $id_pendaftar = $this->db->query($sql2)->row_array();
        $id_pendaftar = $id_pendaftar['id'];

        $sql = "UPDATE pendaftar, user
                SET pendaftar.status_finalisasi = 1
                WHERE pendaftar.id_user_calon_mhs = user.id
                AND user.id = $id_user_calon_mhs
                AND pendaftar.id =  $id_pendaftar";
        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data orang tua berhasil disimpan. </div>');
        redirect('user/berhasil_daftar');
    }
    public function generate_qrcode($foto, $no_daftar)
    {
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/img/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $no_daftar . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = $foto; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }

    public function _email($nama_lengkap, $email)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'aknsbyogyakarta@gmail.com',
            'smtp_pass' => 'aknsbyogya2014',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        $this->email->initialize($config);
        $this->email->from('aknsbyogyakarta@gmail.com', 'Akademi Komunitas Negeri Seni dan Budaya Yogyakarta');
        $this->email->to($email);
        $this->email->subject('Pendaftaran Berhasil');
        $this->email->message('Hai ' . "$nama_lengkap" . '<br><br><br>
			Selamat anda telah berhasil mendaftar PMB Akademi Komunitas Negeri Seni dan Budaya Yogyakarta<br><br>	
			Berikutnya silahkan unduh kartu test melalui link dibawah ini: <br><br>

			1. Unduh kartu test <a href="' . base_url() . 'user/cetak_kartu_test' . '">disini</a><br> 
			2. Unduh Formulir <a href="' . base_url() . 'user/biodata' . '">disini</a><br> 
			
			Terimaksih telah mendaftar penerimaan mahasiswa baru<br><br>
			-Akademi Komunitas Negeri Seni dan Budaya Yogyakarta');

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
        }
    }

    public function berhasil_daftar()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Formulir';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/berhasil_daftar', $data);
        $this->load->view('template/footer');
    }
    public function my_profil()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'My Profile';
        $role_id = $data['user']['role_id'];
        $cek_isi = $data['user']['cek_isi'];
        $id = $data['user']['id'];

        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];

            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }

            if ($cek_verifikasi == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu verifikasi pembayaran ! </div>');
                redirect('user/tunggu');
            }
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {
            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $id")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $id")->row_array();


            if ($data['user']['status_bayar'] == NULL && $cek_syarat == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi persyaratan terlebih dahulu </div>');
                redirect('user/upload_syarat');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        }

        if ($cek_isi == 0 && $role_id == 4) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi formulir terlebih dahulu ! </div>');
            redirect('user/formulir');
        }

        $sql = "SELECT * 
        FROM user, `pendaftar`
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND user.id = $id";

        $data['pengguna'] = $this->db->query($sql)->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/my_profil', $data);
        $this->load->view('template/footer');
    }
    public function change_password()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Change Password';
        $id = $data['user']['id'];
        $role_id = $data['user']['role_id'];
        $cek_isi = $data['user']['cek_isi'];

        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
        FROM pembayaran_online, user
        WHERE pembayaran_online.id_user = user.id
        AND pembayaran_online.id_user = $id")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
        FROM pembayaran_online, user
        WHERE pembayaran_online.id_user = user.id
        AND pembayaran_online.id_user = $id")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];

            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }

            if ($cek_verifikasi == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu verifikasi pembayaran ! </div>');
                redirect('user/tunggu');
            }
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {
            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $id")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $id")->row_array();


            if ($data['user']['status_bayar'] == NULL && $cek_syarat == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi persyaratan terlebih dahulu </div>');
                redirect('user/upload_syarat');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        }

        if ($cek_isi == 0 && $role_id == 4) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi formulir terlebih dahulu ! </div>');
            redirect('user/formulir');
        }

        $this->form_validation->set_rules('current_password', 'Password saat ini', 'required|trim');
        $this->form_validation->set_rules('new_password', 'Password baru', 'required|trim|min_length[6]|matches[konfirmasi_password]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi password', 'required|trim|min_length[6]|matches[new_password]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('template/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Password saat ini salah !
		  </div>');

                redirect('user/change_password');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password baru tidak boleh sama dengan saat ini !
                  </div>');
                    redirect('user/change_password');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password berhasil diubah !
                  </div>');
                    redirect('user/change_password');
                }
            }
        }
    }

    public function pengumuman()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pengumuman';

        $role_id = $data['user']['role_id'];
        $cek_isi = $data['user']['cek_isi'];
        $user_id = $data['user']['id'];
        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $user_id")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $user_id")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];

            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }

            if ($cek_verifikasi == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu verifikasi pembayaran ! </div>');
                redirect('user/tunggu');
            }
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {
            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $user_id")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $user_id")->row_array();


            if ($data['user']['status_bayar'] == NULL && $cek_syarat == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi persyaratan terlebih dahulu </div>');
                redirect('user/upload_syarat');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        }

        if ($cek_isi == 0 && $role_id == 4) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi formulir terlebih dahulu ! </div>');
            redirect('user/formulir');
        }

        $sql = "SELECT user.`id`,user.`nik`, pendaftar.`nama_lengkap`, nilai_test.`praktek`, `nilai_test`.`wawancara`, nilai_test.`skor`, pendaftar.id_pengumuman, prodi.`nama_prodi`
        FROM user, pendaftar, nilai_test, prodi
        WHERE user.`id` = pendaftar.`id_user_calon_mhs`
        AND pendaftar.`id` = nilai_test.`id_pendaftar`
        AND pendaftar.`id_prodi` = prodi.`id`
        AND user.`id` = $user_id";

        $data['pengumuman'] = $this->db->query($sql)->row_array();

        $data['gelombang'] = $this->db->query("SELECT pendaftar.id_jadwal FROM user, pendaftar WHERE pendaftar.id_user_calon_mhs = user.id AND user.id = $user_id")->row_array();

        $gelombang = $data['gelombang']['id_jadwal'];
        
        $data['pengumuman_manual'] = $this->db->query("SELECT pengumuman_manual.id, jadwal.gelombang, pengumuman_manual.file_pengumuman 
        FROM pengumuman_manual, jadwal WHERE pengumuman_manual.id_jadwal = jadwal.id AND jadwal.id = $gelombang")->result_array();
        
        $data['cek_pengumuman_manual'] = $this->db->query("SELECT count(pengumuman_manual.id)
        FROM pengumuman_manual, jadwal WHERE pengumuman_manual.id_jadwal = jadwal.id AND jadwal.id = $gelombang")->result_array();
   


        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/pengumuman', $data);
        $this->load->view('template/footer');
    }
    public function detail_formulir($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Detail Formulir';

        $sql = "SELECT pendaftar.`nama_lengkap`,pendaftar.`nisn`, pendaftar.`jalur_seleksi`, prodi.`nama_prodi`, pendaftar.`id_prodi2`, pendaftar.`tempat_lahir`, pendaftar.`tanggal_lahir`, pendaftar.`provinsi_tempat_lahir`, user.`nik`, pendaftar.`jenis_kelamin`, pendaftar.`status_pernikahan`, pendaftar.`agama`, pendaftar.`telepon`, user.`email`, pendaftar.`alamat`, provinsi.`nama_provinsi`, kabupaten.`kabupaten`, kecamatan.`nama_kecamatan`, pendaftar.`kode_pos`, pendaftar.`kewarganegaraan`, pendaftar.`pas_foto`
        FROM user 
        INNER JOIN pendaftar ON user.id = pendaftar.`id_user_calon_mhs`
        INNER JOIN prodi ON prodi.`id` = pendaftar.`id_prodi`
        INNER JOIN prodi as prodi2 ON prodi2.`id` = pendaftar.`id_prodi2`
        INNER JOIN provinsi ON pendaftar.`id_provinsi` = provinsi.`id`
        INNER JOIN kabupaten ON kabupaten.`id` = pendaftar.`id_kabupaten`
        INNER JOIN kecamatan ON kecamatan.`id` = pendaftar.`id_kecamatan`
        WHERE user.id = $id";
        $data['detail_form'] = $this->db->query($sql)->row_array();

        $sql1 = "SELECT user.id,detail_sekolah.`nama_sekolah`, detail_sekolah.`jenis_sekolah`, detail_sekolah.`id_provinsi`, detail_sekolah.`alamat_lengkap_sekolah`, detail_sekolah.`jurusan`, detail_sekolah.`status_kelulusan`, detail_sekolah.`tahun_lulus`, detail_sekolah.`no_ijazah`, detail_sekolah.`tgl_ijazah`,detail_sekolah.`bhs_indo_smt3`, detail_sekolah.`bhs_inggris_smt3`, detail_sekolah.`matematika_smt3`,detail_sekolah.`bhs_indo_smt4`, detail_sekolah.`bhs_inggris_smt4`, detail_sekolah.`matematika_smt4`,detail_sekolah.`bhs_indo_smt5`, detail_sekolah.`bhs_inggris_smt5`, detail_sekolah.`matematika_smt5` ,detail_sekolah.`bhs_indonesia`, detail_sekolah.`bhs_inggris`, detail_sekolah.`matematika`, provinsi.`nama_provinsi`
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

        $sql3 = "SELECT data_prestasi.`id`,user.nik, data_prestasi.`jenis_kegiatan_lomba`, data_prestasi.`tingkat_kejuaraan`, data_prestasi.`prestasi_juara_ke`
        FROM data_prestasi, user
        WHERE data_prestasi.`id_user_calon_mhs` = user.`id`
        AND user.id = $id";
        $data['data_prestasi'] = $this->db->query($sql3)->result_array();

        $sql4 = "SELECT data_ortu.`nama_ayah`, data_ortu.`pendidikan_terakhir_ayah`, data_ortu.`pekerjaan_ayah`, data_ortu.`penghasilan_ayah`, data_ortu.`nama_ibu`, data_ortu.`pendidikan_terakhir_ibu`, data_ortu.`pekerjaan_ibu`, data_ortu.`penghasilan_ibu`, data_ortu.`alamat_lengkap_ortu`, data_ortu.`id_provinsi_asal_ortu`, data_ortu.`id_kabupaten_ortu`, data_ortu.`kode_pos_ortu`, data_ortu.`telepon_ortu`, data_ortu.`nama_wali`, data_ortu.`pekerjaan_wali`, data_ortu.`alamat_lengkap_wali`, provinsi.`nama_provinsi`, kabupaten.`kabupaten`
        FROM data_ortu, user, provinsi, kabupaten
        WHERE data_ortu.`id_user_calon_mhs` = user.`id`
        AND data_ortu.`id_provinsi_asal_ortu` = provinsi.`id`
        AND data_ortu.`id_kabupaten_ortu` = kabupaten.`id`
        AND user.`id` = $id";
        $data['data_ortu'] = $this->db->query($sql4)->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/detail_formulir', $data);
        $this->load->view('template/footer');
    }
    public function bayar()
    {
        $data['title'] = 'Pembayaran';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/konfirmasi_pembayaran', $data);
        $this->load->view('template/footer');
    }
    public function aksi_bayar()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user = $data['user']['id'];
        $jalur_pendaftaran = $data['user']['jalur_pendaftaran'];
        $no_slip = $this->input->post('no_va');
        $bukti_bayar = $_FILES['bukti_bayar'];

        if ($bukti_bayar = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/bukti_bayar';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('bukti_bayar')) {
                echo "Upload Gagal";
                die();
            } else {
                $bukti_bayar = $this->upload->data('file_name');
            }
        }

        $data = [
            'id_user' => $id_user,
            'no_pembayaran' => $no_slip,
            'jalur_pendaftaran' => $jalur_pendaftaran,
            'bukti_bayar' => $bukti_bayar,
            'status_pembayaran' => 0,
            'total_pembayaran' => 200000,
            'date_created' => time()
        ];

        $this->db->insert('pembayaran_online', $data);

        $sql = "UPDATE user SET  user.status_bayar=1 
		WHERE user.id=$id_user";

        $this->db->query($sql);


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Bukti bayar berhasil di simpan. </div>');
        redirect('user/tunggu');
    }
    public function tunggu()
    {
        $data['title'] = 'Tunggu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $data['user']['id'];
        $role_id = $data['user']['role_id'];

        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
                                                    FROM pembayaran_online, user
                                                    WHERE pembayaran_online.id_user = user.id
                                                    AND pembayaran_online.id_user = $id")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
                                                    FROM pembayaran_online, user
                                                    WHERE pembayaran_online.id_user = user.id
                                                    AND pembayaran_online.id_user = $id")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];
            
            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }
            
          
            if ($data['user']['status_bayar'] == 1 && $cek_pembayaran > 0 && $cek_verifikasi == 1) {
                redirect('user/formulir');
            }

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/tunggu', $data);
            $this->load->view('template/footer');
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {

            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $id")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $id")->row_array();

            $cek_verifikasi =  $cek_verifikasi['status'];


            if ($data['user']['status_bayar'] == 1 && $cek_syarat > 0 &&  $cek_verifikasi == 1) {
                // var_dump("hallo");
                // die;
                redirect('user/formulir');
            }

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/tunggu_prestasi', $data);
            $this->load->view('template/footer');
        } else {

            $cek_tiket = $this->db->query("SELECT count(tiket.id) as id_tiket
            FROM tiket, user
            WHERE tiket.id_user = user.id
            AND tiket.id_user = $id")->row_array();
            $cek_tiket  = $cek_tiket['id_tiket'];

            $cek_verifikasi = $this->db->query("SELECT tiket.status
            FROM tiket, user
            WHERE tiket.id_user = user.id
            AND user.id = $id")->row_array();

            $cek_verifikasi =  $cek_verifikasi['status'];


            if ($data['user']['status_bayar'] == 1 && $cek_tiket > 0 &&  $cek_verifikasi == 1) {

                redirect('user/formulir');
            }

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/tunggu_pkl', $data);
            $this->load->view('template/footer');
        }
    }
    public function edit_profil()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user =  $data['user']['id'];
        $data['profil'] = $this->db->query("SELECT * FROM user, pendaftar WHERE user.id = pendaftar.id_user_calon_mhs AND user.id = $id_user")->row_array();

        $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('no_wa', 'Nomor Whatsapp', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/edit_profil', $data);
            $this->load->view('template/footer');
        } else {
            $nik = $this->input->post('nik');
            $nama_lengkap = $this->input->post('nama_lengkap');
            $email = $this->input->post('email');
            $no_wa = $this->input->post('no_wa');
            $tempat_lahir = $this->input->post('tempat_lahir');
            $tanggal_lahir = $this->input->post('tanggal_lahir');
            $alamat = $this->input->post('alamat');

            $upload_image = $_FILES['foto']['name'];

            if ($upload_image) {
                $config['upload_path']          = './assets/admin_panel/assets/images/avatar';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.png') {
                        unlink(FCPATH, './assets/admin_panel/assets/images/avatar/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->query("UPDATE user SET user.image = '$new_image' WHERE user.id = $id_user");
                } else {
                    die;
                }
            }

            $this->db->query("UPDATE user, pendaftar
            SET user.nik = $nik, pendaftar.nama_lengkap = '$nama_lengkap', pendaftar.tempat_lahir = '$tempat_lahir', 
            user.no_whatsapp = '$no_wa', pendaftar.tanggal_lahir = '$tanggal_lahir', 
            user.email='$email', pendaftar.alamat = '$alamat'
            WHERE user.id = pendaftar.id_user_calon_mhs
            AND user.id = $id_user");

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Profile berhasil di ubah!
		  </div>');
            redirect('user/my_profil');
        }
    }
    public function pengajuan_beasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pengajuan Beasiswa';

        $id = $data['user']['id'];
        $role_id = $data['user']['role_id'];
        $cek_isi = $data['user']['cek_isi'];

        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];

            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }

            if ($cek_verifikasi == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu verifikasi pembayaran ! </div>');
                redirect('user/tunggu');
            }
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {
            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $id")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $id")->row_array();


            if ($data['user']['status_bayar'] == NULL && $cek_syarat == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi persyaratan terlebih dahulu </div>');
                redirect('user/upload_syarat');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        }

        if ($cek_isi == 0 && $role_id == 4) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi formulir terlebih dahulu ! </div>');
            redirect('user/formulir');
        }
        $jadwal_beasiswa = $this->db->query('SELECT * FROM jadwal_beasiswa WHERE id = 1')->row_array();
        $cek_jadwal = $jadwal_beasiswa['is_active'];

        if ($cek_jadwal == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Pengajuan Beasiswa Belum Dibuka ! </div>');
            redirect('user/formulir');
        }
        $data['pengajuan_beasiswa'] = $this->db->query("SELECT pengajuan_beasiswa.id, pengajuan_beasiswa.surat_pengajuan_beasiswa, pengajuan_beasiswa.ktp, pengajuan_beasiswa.status_penerimaan, user.nama_lengkap
                                                        FROM pengajuan_beasiswa, user
                                                        WHERE pengajuan_beasiswa.id_user = user.id
                                                        AND user.id = $id")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/pengajuan_beasiswa', $data);
        $this->load->view('template/footer');
    }
    public function aksi_pengajuan_beasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id_user = $data['user']['id'];

        $surat_pengajuan = $_FILES['surat_pengajuan'];

        if ($surat_pengajuan = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/surat_pengajuan_beasiswa';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('surat_pengajuan')) {
                echo "Upload Gagal";
                die();
            } else {
                $surat_pengajuan = $this->upload->data('file_name');
            }
        }

        $ktp = $_FILES['scan_ktp'];

        if ($ktp = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/ktp';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('scan_ktp')) {
                echo "Upload Gagal";
                die();
            } else {
                $ktp = $this->upload->data('file_name');
            }
        }

        $data = [
            'id_user' => $id_user,
            'surat_pengajuan_beasiswa' => $surat_pengajuan,
            'ktp' => $ktp,
            'status_penerimaan' => 'P',
        ];

        $this->db->insert('pengajuan_beasiswa', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Permohonan berhasil diajukan!
      </div>');
        redirect('user/pengajuan_beasiswa');
    }
    public function edit_pengajuan_beasiswa()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id_user = $data['user']['id'];

        $data['pengajuan_beasiswa'] = $this->db->query("SELECT pengajuan_beasiswa.surat_pengajuan_beasiswa, pengajuan_beasiswa.ktp, pengajuan_beasiswa.status_penerimaan, user.nama_lengkap
                                                        FROM pengajuan_beasiswa, user
                                                        WHERE pengajuan_beasiswa.id_user = user.id
                                                        AND user.id = $id_user")->row_array();


        $surat_pengajuan = $_FILES['surat_pengajuan']['name'];

        if ($surat_pengajuan != NULL) {

            if ($surat_pengajuan) {
                $config['upload_path']          = './assets/img/surat_pengajuan_beasiswa';
                $config['allowed_types']        = 'pdf';

                $this->upload->initialize($config);

                if ($this->upload->do_upload('surat_pengajuan')) {
                    $old_image = $data['pengajuan_beasiswa']['surat_pengajuan_beasiswa'];

                    if ($old_image != 'default.pdf') {
                        unlink(FCPATH, './assets/img/surat_pengajuan_beasiswa/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->query("UPDATE pengajuan_beasiswa,user SET pengajuan_beasiswa.surat_pengajuan_beasiswa = '$new_image' WHERE user.id = pengajuan_beasiswa.id_user AND user.id = $id_user");
                } else {
                    echo "Upload gagal";
                    die;
                }
            }
        }

        $ktp = $_FILES['scan_ktp']['name'];

        if ($ktp != NULL) {

            if ($ktp) {
                $config['upload_path']          = './assets/img/ktp';
                $config['allowed_types']        = 'pdf';

                $this->upload->initialize($config);

                if ($this->upload->do_upload('scan_ktp')) {
                    $old_image = $data['pengajuan_beasiswa']['ktp'];
                    if ($old_image != 'default.pdf') {
                        unlink(FCPATH, './assets/img/ktp/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->query("UPDATE pengajuan_beasiswa,user SET pengajuan_beasiswa.ktp = '$new_image' WHERE user.id = pengajuan_beasiswa.id_user AND user.id = $id_user");
                } else {
                    echo "Upload gagal";
                    die;
                }
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Pengajuan beasiswa berhasil di ubah!
              </div>');
        redirect('user/pengajuan_beasiswa');
    }
    public function delete_pengajuan_beasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pengajuan_beasiswa');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Pengajuan beasiswa berhasil dihapus.
      </div>');

        redirect('user/pengajuan_beasiswa');
    }
    public function daftar_ulang()
    {
        $data['title'] = 'Daftar Ulang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user = $data['user']['id'];
        $cek_isi_ukt = $data['user']['isi_data_ukt'];
        $role_id = $data['user']['role_id'];
        $cek_isi = $data['user']['cek_isi'];
        if ($data['user']['jalur_pendaftaran'] == 'Reguler') {
            $cek_pembayaran = $this->db->query("SELECT count(pembayaran_online.status_pembayaran) as status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id_user")->row_array();
            $cek_pembayaran = $cek_pembayaran['status_pembayaran'];
            $cek_verifikasi = $this->db->query("SELECT pembayaran_online.status_pembayaran
                                                FROM pembayaran_online, user
                                                WHERE pembayaran_online.id_user = user.id
                                                AND pembayaran_online.id_user = $id_user")->row_array();
            $cek_verifikasi = $cek_verifikasi['status_pembayaran'];

            if ($data['user']['status_bayar'] == NULL && $cek_pembayaran == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi bukti bayar terlebih dahulu ! </div>');
                redirect('user/bayar');
            }

            if ($cek_verifikasi == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu verifikasi pembayaran ! </div>');
                redirect('user/tunggu');
            }
        } elseif ($data['user']['jalur_pendaftaran'] == 'Prestasi') {
            $cek_syarat = $this->db->query("SELECT count(daftar_jalur_prestasi.id) as id_jalur_prestasi
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND daftar_jalur_prestasi.id_user = $id_user")->row_array();
            $cek_syarat = $cek_syarat['id_jalur_prestasi'];

            $cek_verifikasi = $this->db->query("SELECT daftar_jalur_prestasi.status
            FROM daftar_jalur_prestasi, user
            WHERE daftar_jalur_prestasi.id_user = user.id
            AND user.id = $id_user")->row_array();


            if ($data['user']['status_bayar'] == NULL && $cek_syarat == 0 && $role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi persyaratan terlebih dahulu </div>');
                redirect('user/upload_syarat');
            } elseif ($cek_verifikasi == 0 ||  $cek_verifikasi == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Tunggu konfirmasi dari admin </div>');
                redirect('user/tunggu');
            }
        }
        if ($cek_isi == 0 && $role_id == 4) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Isi formulir terlebih dahulu ! </div>');
            redirect('user/formulir');
        }
        $cek_kelulusan = $this->db->query("SELECT id_pengumuman
                                            FROM pendaftar, user
                                            WHERE pendaftar.`id_user_calon_mhs` = user.`id`
                                            AND user.id = $id_user")->row_array();

        $cek_jadwal_daftar_ulang = $this->db->query("SELECT * FROM jadwal_daftar_ulang WHERE id = 1")->row_array();
        if ($cek_jadwal_daftar_ulang['is_active'] == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Pendaftaran ulang belum dibuka
          </div>');

            redirect('user/formulir');
        }

        if ($cek_kelulusan['id_pengumuman'] == NULL || $cek_kelulusan['id_pengumuman'] == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Tidak bisa melakukan daftar ulang karena belum terbit pengumuman.
          </div>');

            redirect('user/formulir');
        } elseif ($cek_kelulusan['id_pengumuman'] == 2) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Tidak bisa melakukan daftar ulang karena tidak lulus.
          </div>');

            redirect('user/formulir');
        }

        $data['ukt'] = $this->db->query("SELECT ukt.id, ukt.status_daftar_ulang, ukt.slip_gaji, ukt.foto_rumah, ukt.struk_listrik, ukt.kartu_keluarga, ukt_pekerjaan.detail_pekerjaan, ukt_pekerjaan.bobot, ukt_pendapatan.detail_pendapatan, ukt_pendapatan.bobot, ukt_kondisi_rumah.detail_kondisi_rumah, ukt_kondisi_rumah.bobot, ukt_listrik.detail_listrik, ukt_listrik.bobot, ukt_tanggungan.detail_tanggungan, ukt_tanggungan.bobot
        FROM ukt, ukt_kondisi_rumah, ukt_listrik, ukt_pekerjaan, ukt_pendapatan, ukt_tanggungan, user
        WHERE ukt.id_ukt_pekerjaan = ukt_pekerjaan.id
        AND ukt.id_ukt_pendapatan = ukt_pendapatan.id
        AND ukt.id_ukt_kondisi_rumah = ukt_kondisi_rumah.id
        AND ukt.id_ukt_listrik = ukt_listrik.id
        AND ukt.id_ukt_tanggungan = ukt_tanggungan.id
        AND ukt.id_user = user.id
        AND user.id = $id_user")->row_array();


        $data['pekerjaan'] = $this->db->get('ukt_pekerjaan')->result_array();
        $data['pendapatan'] = $this->db->get('ukt_pendapatan')->result_array();
        $data['kondisi_rumah'] = $this->db->get('ukt_kondisi_rumah')->result_array();
        $data['listrik'] = $this->db->get('ukt_listrik')->result_array();
        $data['tanggungan'] = $this->db->get('ukt_tanggungan')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        if ($cek_isi_ukt == NULL || $cek_isi_ukt == 0) {
            $this->load->view('user/daftar_ulang', $data);
        } else {
            $this->load->view('user/detail_ukt');
        }
        $this->load->view('template/footer');
    }
    public function tambah_ukt()
    {
        $data['title'] = 'Daftar Ulang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user = $data['user']['id'];

        $pekerjaan = $this->input->post('pekerjaan');
        $pendapatan = $this->input->post('pendapatan');
        $kondisi_rumah = $this->input->post('kondisi_rumah');
        $listrik = $this->input->post('listrik');
        $tanggungan = $this->input->post('tanggungan');

        $slip_gaji = $_FILES['slip_gaji'];

        if ($slip_gaji = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/ukt';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('slip_gaji')) {
                echo "Upload Gagal";
                die();
            } else {
                $slip_gaji = $this->upload->data('file_name');
            }
        }

        $foto_rumah = $_FILES['foto_rumah'];

        if ($foto_rumah = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/ukt';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('foto_rumah')) {
                echo "Upload Gagal";
                die();
            } else {
                $foto_rumah = $this->upload->data('file_name');
            }
        }

        $pembayaran_listrik = $_FILES['pembayaran_listrik'];

        if ($pembayaran_listrik = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/ukt';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('pembayaran_listrik')) {
                echo "Upload Gagal";
                die();
            } else {
                $pembayaran_listrik = $this->upload->data('file_name');
            }
        }

        $kartu_keluarga = $_FILES['kartu_keluarga'];

        if ($kartu_keluarga = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/ukt';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('kartu_keluarga')) {
                echo "Upload Gagal";
                die();
            } else {
                $kartu_keluarga = $this->upload->data('file_name');
            }
        }
        $bobot_pekerjaan = $this->db->query("SELECT ukt_pekerjaan.bobot FROM ukt_pekerjaan WHERE ukt_pekerjaan.id = $pekerjaan")->row();
        $bobot_pendapatan = $this->db->query("SELECT ukt_pendapatan.bobot FROM ukt_pendapatan WHERE ukt_pendapatan.id = $pendapatan")->row();
        $bobot_kondisi_rumah = $this->db->query("SELECT ukt_kondisi_rumah.bobot FROM ukt_kondisi_rumah WHERE ukt_kondisi_rumah.id = $kondisi_rumah")->row();
        $bobot_listrik = $this->db->query("SELECT ukt_listrik.bobot FROM ukt_listrik WHERE ukt_listrik.id = $listrik")->row();
        $bobot_tanggungan = $this->db->query("SELECT ukt_tanggungan.bobot FROM ukt_tanggungan WHERE ukt_tanggungan.id = $tanggungan")->row();
        $total_bobot = ($bobot_pekerjaan->bobot + $bobot_pendapatan->bobot + $bobot_kondisi_rumah->bobot + $bobot_listrik->bobot + $bobot_tanggungan->bobot) / 5;
        $jenis_ukt = '';

        if ($total_bobot <= 2.5) {
            $jenis_ukt = 'UKT 1';
        } else {
            $jenis_ukt = 'UKT 2';
        }

        $data = [
            'id_ukt_pekerjaan' => $pekerjaan,
            'id_ukt_pendapatan' => $pendapatan,
            'id_ukt_kondisi_rumah' => $kondisi_rumah,
            'id_ukt_listrik' => $listrik,
            'id_ukt_tanggungan' => $tanggungan,
            'slip_gaji' => $slip_gaji,
            'foto_rumah' => $foto_rumah,
            'struk_listrik' => $pembayaran_listrik,
            'kartu_keluarga' => $kartu_keluarga,
            'total_bobot' => $total_bobot,
            'jenis_ukt' => $jenis_ukt,
            'id_user' => $id_user
        ];

        $this->db->insert('ukt', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        UKT berhasil diajukan.
      </div>');

        $this->db->query("UPDATE user
                        SET isi_data_ukt = 1
                        WHERE user.id = $id_user");

        redirect('user/daftar_ulang');
    }
    public function upload_syarat()
    {
        $data['title'] = 'Dokumen Persyaratan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/upload_syarat', $data);
        $this->load->view('template/footer');
    }
    public function aksi_upload_syarat()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $data['user']['id'];

        $surat_rekomendasi = $_FILES['surat_rekomendasi'];

        if ($surat_rekomendasi = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/jalur_prestasi';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('surat_rekomendasi')) {
                echo "Upload Gagal";
                die();
            } else {
                $surat_rekomendasi = $this->upload->data('file_name');
            }
        }

        $portofolio = $this->input->post('portofolio');

        $data = [
            'id_user' => $id,
            'surat_rekomendasi' => $surat_rekomendasi,
            'portofolio' => $portofolio,
            'status' => 0,
        ];

        $this->db->insert('daftar_jalur_prestasi', $data);

        $sql = "UPDATE user SET  user.status_bayar=1 
		WHERE user.id=$id";

        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Persyaratan jalur prestasi berhasil diajukan, mohon tunggu konfirmasi dari admin
        </div>');
        redirect('user/tunggu');
    }
    public function upload_kupon()
    {
        $data['title'] = 'Upload tiket';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/upload_kupon', $data);
        $this->load->view('template/footer');
    }
    public function aksi_upload_kupon()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $data['user']['id'];

        $scan_tiket = $_FILES['scan_tiket'];

        if ($scan_tiket = '') {
            # code...
        } else {
            $config['upload_path'] = './assets/img/tiket';
            $config['allowed_types'] = 'pdf';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('scan_tiket')) {
                echo "Upload Gagal";
                die();
            } else {
                $scan_tiket = $this->upload->data('file_name');
            }
        }

        $kode_tiket = $this->input->post('kode_tiket');

        $data = [
            'id_user' => $id,
            'kode_tiket' => $kode_tiket,
            'scan_tiket' => $scan_tiket,
            'status' => 0,
        ];

        $this->db->insert('tiket', $data);

        $sql = "UPDATE user SET  user.status_bayar=1 
		WHERE user.id=$id";

        $this->db->query($sql);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-start" role="alert">
        Tiket telah diterima, mohon tunggu konfirmasi dari admin
        </div>');
        redirect('user/tunggu');
    }
}