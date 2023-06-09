<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <div class="row text-center mb-5 border-white border-2" id="judul">
                <div class="col-md-3 bg-info btn" id="judul_biodata">
                    <h6 class="card-subtitle text-white btn btn-lg col-lg">BIODATA </h6>
                </div>
                <div class="col-md-3 bg-primary btn" id="judul_sekolah_asal">
                    <h6 class="card-subtitle text-white btn btn-lg col-lg">SEKOLAH ASAL</h6>
                </div>
                <div class="col-md-3 bg-primary btn" id="judul_prestasi">
                    <h6 class="card-subtitle text-white btn btn-lg col-lg">PRESTASI</h6>
                </div>
                <div class="col-md-3 bg-primary btn" id="judul_data_orang_tua">
                    <h6 class="card-subtitle text-white btn btn-lg col-lg">DATA ORANG TUA</h6>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card p-5" id="biodata">
                <form action="<?= base_url('user/aksi_tambah_formulir') ?>" method="POST" enctype="multipart/form-data">
                    <div class=" mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                            value="<?= $detail_form['nama_lengkap']; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="jalur_seleksi" class="form-label">Jalur Seleksi</label>
                        <input type="text" class="form-control" id="jalur_seleksi" name="jalur_seleksi"
                            value="<?= $detail_form['jalur_seleksi']; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="jalur_seleksi" class="form-label">Prodi Pilihan 1</label>
                        <select class="form-select" id="prodi" name="prodi" disabled required>
                            <?php foreach ($prodi as $p) : ?>
                            <option <?= ($p['nama_prodi'] == $detail_form['nama_prodi']) ? 'selected' : '' ?>
                                value="<?= $p['id'] ?>"><?= $p['nama_prodi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jalur_seleksi" class="form-label">Prodi Pilihan 2</label>
                        <select class="form-select" id="prodi" name="prodi" disabled required>
                            <?php foreach ($prodi as $p) : ?>
                            <option <?= ($p['id'] == $detail_form['id_prodi2']) ? 'selected' : '' ?>
                                value="<?= $p['id'] ?>"><?= $p['nama_prodi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    value="<?= $detail_form['tempat_lahir']; ?>" readonly required>
                            </div>
                            <div class="col-lg-6">
                                <input type="date" class="form-control" id="tgl_lahir"
                                    value="<?= $detail_form['tanggal_lahir']; ?>" name="tgl_lahir" readonly required>
                            </div>
                            <small>Sesuaikan dengan ijazah</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="provinsi_tempat_lahir" class="form-label">Provinsi Tempat Lahir</label>
                        <select class="form-select" id="provinsi_tempat_lahir" name="provinsi_tempat_lahir" disabled
                            required>
                            <option value="" selected disabled>Pilih Provinsi</option>
                            <?php foreach ($provinsi as $prov_lahir) : ?>
                            <option
                                <?= ($prov_lahir['nama_provinsi'] == $detail_form['provinsi_tempat_lahir']) ? 'selected' : '' ?>
                                value="<?= $prov_lahir['nama_provinsi'] ?>"><?= $prov_lahir['nama_provinsi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $user['nik']; ?>"
                            readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn"
                            value="<?= $detail_form['nisn']; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" disabled required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option <?= ('1' == $detail_form['jenis_kelamin']) ? 'selected' : '' ?> value="1">Laki -
                                Laki</option>
                            <option <?= ('2' == $detail_form['jenis_kelamin']) ? 'selected' : '' ?> value="2">Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                        <select class="form-select" id="status_pernikahan" name="status_pernikahan" disabled required>
                            <option value="" disabled>Pilih Status Pernikahan</option>
                            <option <?= ('Sudah Menikah' == $detail_form['status_pernikahan']) ? 'selected' : '' ?>
                                value="Sudah Menikah">Sudah Menikah</option>
                            <option <?= ('Belum Menikah' == $detail_form['status_pernikahan']) ? 'selected' : '' ?>
                                value="Belum Menikah">Belum Menikah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-control" disabled required>
                            <option value="" disabled>Pilih Agama</option>
                            <option <?= ('Islam' == $detail_form['agama']) ? 'selected' : '' ?> value="Islam">Islam
                            </option>
                            <option <?= ('Kristen Protestan' == $detail_form['agama']) ? 'selected' : '' ?>
                                value="Kristen Protestan">Kristen Protestan</option>
                            <option <?= ('Katholik' == $detail_form['agama']) ? 'selected' : '' ?> value="Katholik">
                                Katholik</option>
                            <option <?= ('Hindu' == $detail_form['agama']) ? 'selected' : '' ?> value="Hindu">Hindu
                            </option>
                            <option <?= ('Budha' == $detail_form['agama']) ? 'selected' : '' ?> value="Budha">Budha
                            </option>
                            <option <?= ('Kong Hu Cu' == $detail_form['agama']) ? 'selected' : '' ?> value="Kong Hu Cu">
                                Kong Hu Cu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No Hp / Whatsapp</label>
                        <input type="number" class="form-control" id="no_hp" name="no_hp"
                            value="<?= $detail_form['telepon'] ?>" readonly required>
                        <small>Masukan dengan awalan kode 62xxxx (format internasional)</small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>"
                            readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" id="alamat_lengkap" cols="30" rows="10"
                            readonly required><?= $detail_form['alamat']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="provinsi_tempat_tinggal" class="form-label">Provinsi Tempat Tinggal</label>
                        <select name="provinsi" class="form-control" id="provinsi" disabled required>
                            <option value="" disabled>Pilih Provinsi</option>
                            <?php foreach ($provinsi as $prov) : ?>
                            <option <?= ($prov['nama_provinsi'] == $detail_form['nama_provinsi']) ? 'selected' : '' ?>
                                value="<?= $prov['id']; ?>"><?= $prov['nama_provinsi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kabupaten_tempat_tinggal" class="form-label">Kabupaten Tempat Tinggal</label>
                        <select name="kabupaten" class="form-control" id="kabupaten" disabled required>
                            <?php foreach ($kabupaten as $kab) : ?>
                            <option <?= ($kab['kabupaten'] == $detail_form['kabupaten']) ? 'selected' : '' ?>
                                value="<?= $kab['id'] ?>"><?= $kab['kabupaten'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kecamatan_tempat_tinggal" class="form-label">Kecamatan Tempat Tinggal</label>
                        <select name="kecamatan" class="form-control" id="kecamatan" disabled required>
                            <?php foreach ($kecamatan as $kec) : ?>
                            <option <?= ($kec['nama_kecamatan'] == $detail_form['nama_kecamatan']) ? 'selected' : '' ?>
                                value="<?= $kec['id'] ?>"><?= $kec['nama_kecamatan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode_pos" class="form-label">Kode Pos Tempat Tinggal</label>
                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                            value="<?= $detail_form['kode_pos'] ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <input type="text" class="form-control" id="kewarganegaraan"
                            value="<?= $detail_form['kewarganegaraan'] ?>" name="kewarganegaraan" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Pas foto</label> <br>
                        <img src="<?= base_url('assets/img/pas_foto/') . $detail_form['pas_foto'] ?>" width="150"
                            height="208">
                    </div>
                </form>
            </div>

            <div class="card visually-hidden p-5" id="data_sekolah">
                <form action="<?= base_url('user/aksi_tambah_sekolah_asal'); ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah</label><br>
                        <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah"
                            value="<?= $detail_sekolah['nama_sekolah']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_sekolah" class="form-label">Jenis Sekolah</label>
                        <select name="jenis_sekolah" class="form-select" id="jenis_sekolah" disabled required>
                            <option value="" selected disabled>Pilih Jenis Sekolah</option>
                            <?php foreach ($status_sekolah as $ss) : ?>
                            <option <?= ($ss['status'] == $detail_sekolah['jenis_sekolah']) ? 'selected' : '' ?>
                                value="<?= $ss['status'] ?>"><?= $ss['status'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="provinsi_asal_sekolah" class="form-label">Provinsi Asal Sekolah</label>
                        <select name="provinsi_asal_sekolah" class="form-select" id="provinsi_asal_sekolah" disabled
                            required>
                            <option value="" disabled>Pilih Asal Sekolah</option>
                            <?php foreach ($provinsi as $pr) : ?>
                            <option <?= ($pr['id'] == $detail_sekolah['id_provinsi']) ? 'selected' : '' ?>
                                value="<?= $pr['id'] ?>"><?= $pr['nama_provinsi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_lengkap_sekolah" class="form-label">Alamat Lengkap Sekolah</label>
                        <textarea name="alamat_lengkap_sekolah" class="form-control" id="alamat_lengkap_sekolah"
                            cols="30" rows="10" readonly
                            required><?= $detail_sekolah['alamat_lengkap_sekolah']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan"
                            value="<?= $detail_sekolah['jurusan']; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="status_kelulusan" class="form-label">Status Kelulusan</label>
                        <select class="form-select" name="status_kelulusan" id="status_kelulusan" disabled required>
                            <option disabled>Pilih status kelulusan</option>
                            <option <?= ('0' == $detail_sekolah['status_kelulusan']) ? 'selected' : '' ?> value="0">
                                Belum Lulus</option>
                            <option <?= ('1' == $detail_sekolah['status_kelulusan']) ? 'selected' : '' ?> value="1">
                                Sudah Lulus</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="number" class="form-control" id="tahun_lulus"
                            value="<?= $detail_sekolah['tahun_lulus']; ?>" name="tahun_lulus" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="no_ijazah" class="form-label">No Ijazah</label>
                        <input type="text" class="form-control" id="no_ijazah" name="no_ijazah"
                            value="<?= $detail_sekolah['no_ijazah']; ?>" readonly required>
                        <small>Jika belum ada, isi dengan angka 0 atau -</small>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_ijazah" class="form-label">Tanggal Ijazah</label>
                        <input type="date" class="form-control" id="tgl_ijazah"
                            value="<?php echo date("Y-m-d", strtotime($detail_sekolah['tgl_ijazah'])); ?>"
                            name="tgl_ijazah" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="data_nilai" class="form-label">Data Nilai Raport SMT III</label>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="bhs_indonesia_smt3" class="form-label">Bhs Indonesia</label>
                                <input type="text" class="form-control" id="bhs_indonesia_smt3"
                                    name="bhs_indonesia_smt3" value="<?= $detail_sekolah['bhs_indo_smt3']; ?>" readonly
                                    required>
                            </div>
                            <div class="col-lg-4">
                                <label for="bhs_inggris_smt3" class="form-label">Bhs Inggris</label>
                                <input type="text" class="form-control" id="bhs_inggris_smt3" name="bhs_inggris_smt3"
                                    value="<?= $detail_sekolah['bhs_inggris_smt3']; ?>" readonly required>
                            </div>
                            <div class="col-lg-4">
                                <label for="matematika_smt3" class="form-label">Matematika</label>
                                <input type="text" class="form-control" id="matematika_smt3" name="matematika_smt3"
                                    value="<?= $detail_sekolah['matematika_smt3']; ?>" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="data_nilai" class="form-label">Data Nilai Raport SMT IV</label>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="bhs_indonesia_smt4" class="form-label">Bhs Indonesia</label>
                                <input type="text" class="form-control" id="bhs_indonesia_smt4"
                                    name="bhs_indonesia_smt4" value="<?= $detail_sekolah['bhs_indo_smt4']; ?>" readonly
                                    required>
                            </div>
                            <div class="col-lg-4">
                                <label for="bhs_inggris_smt4" class="form-label">Bhs Inggris</label>
                                <input type="text" class="form-control" id="bhs_inggris_smt4" name="bhs_inggris_smt4"
                                    value="<?= $detail_sekolah['bhs_inggris_smt4']; ?>" readonly required>
                            </div>
                            <div class="col-lg-4">
                                <label for="matematika_smt4" class="form-label">Matematika</label>
                                <input type="text" class="form-control" id="matematika_smt4" name="matematika_smt4"
                                    value="<?= $detail_sekolah['matematika_smt4']; ?>" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="data_nilai" class="form-label">Data Nilai Raport SMT V</label>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="bhs_indonesia_smt5" class="form-label">Bhs Indonesia</label>
                                <input type="text" class="form-control" id="bhs_indonesia_smt5"
                                    name="bhs_indonesia_smt5" value="<?= $detail_sekolah['bhs_indo_smt5']; ?>" readonly
                                    required>
                            </div>
                            <div class="col-lg-4">
                                <label for="bhs_inggris_smt5" class="form-label">Bhs Inggris</label>
                                <input type="text" class="form-control" id="bhs_inggris_smt5" name="bhs_inggris_smt5"
                                    value="<?= $detail_sekolah['bhs_inggris_smt5']; ?>" readonly required>
                            </div>
                            <div class="col-lg-4">
                                <label for="matematika_smt5" class="form-label">Matematika</label>
                                <input type="text" class="form-control" id="matematika_smt5" name="matematika_smt5"
                                    value="<?= $detail_sekolah['matematika_smt5']; ?>" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="data_nilai" class="form-label">Data Nilai Ujian Akhir Nasional/EBTANAS</label>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="bhs_indonesia" class="form-label">Bhs Indonesia</label>
                                <input type="text" class="form-control" id="bhs_indonesia" name="bhs_indonesia"
                                    value="<?= $detail_sekolah['bhs_indonesia']; ?>" readonly required>
                            </div>
                            <div class="col-lg-4">
                                <label for="bhs_inggris" class="form-label">Bhs Inggris</label>
                                <input type="text" class="form-control" id="bhs_inggris" name="bhs_inggris"
                                    value="<?= $detail_sekolah['bhs_inggris']; ?>" readonly required>
                            </div>
                            <div class="col-lg-4">
                                <label for="matematika" class="form-label">Matematika</label>
                                <input type="text" class="form-control" id="matematika" name="matematika"
                                    value="<?= $detail_sekolah['matematika']; ?>" readonly required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card visually-hidden p-5" id="data_prestasi">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jenis Kegiatan Lomba</th>
                            <th scope="col">Tingkat Kejuaraan</th>
                            <th scope="col">Prestasi Juara Ke</th>
                            <th scope="col">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data_prestasi as $dp) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $dp['jenis_kegiatan_lomba']; ?></td>
                            <td><?= $dp['tingkat_kejuaraan']; ?></td>
                            <td><?= $dp['prestasi_juara_ke']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal1<?= $dp['id'] ?>">
                                    Lihat
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal1<?= $dp['id'] ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Bukti Sertifikat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body mx-auto">
                                                <iframe
                                                    src="<?= base_url('assets/img/bukti_sertifikat/') . $dp['bukti']; ?>"
                                                    width="800" height="600"></iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card p-5 visually-hidden" id="data_ortu">
                <form action="<?= base_url('user/aksi_tambah_data_ortu') ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah"
                            value="<?= $data_ortu['nama_ayah']; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan_terakhir_ayah" class="form-label">Pendidikan Terakhir Ayah</label>
                        <select class="form-select" name="pendidikan_terakhir_ayah" id="pendidikan_terakhir_ayah"
                            disabled required>
                            <option disabled>Pilih pendidikan terakhir ayah</option>
                            <option <?= ('SD' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="SD">SD</option>
                            <option <?= ('SMP' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="SMP">SMP</option>
                            <option <?= ('SMA/SMK' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="SMA/SMK">SMA/SMK</option>
                            <option <?= ('D3' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="D3">D3</option>
                            <option <?= ('S1' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="S1">S1</option>
                            <option <?= ('S2' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="S2">S2</option>
                            <option <?= ('S3' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="S3">S3</option>
                            <option <?= ('Tidak Ada' == $data_ortu['pendidikan_terakhir_ayah']) ? 'selected' : '' ?>
                                value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah"
                            value="<?= $data_ortu['pekerjaan_ayah']; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="penghasilan_ayah" class="form-label">Penghasilan Ayah</label>
                        <select class="form-select" id="penghasilan_ayah" name="penghasilan_ayah" disabled required>
                            <option selected disabled>Pilih Penghasilan Ayah</option>
                            <option
                                <?= ('Kurang dari Rp.500.000' == $data_ortu['penghasilan_ayah']) ? 'selected' : '' ?>
                                value="Kurang dari Rp.500.000">Kurang dari Rp.500.000</option>
                            <option
                                <?= ('Rp.1.000.000-Rp.1999.999' == $data_ortu['penghasilan_ayah']) ? 'selected' : '' ?>
                                value="Rp.1.000.000-Rp.1999.999">Rp.1.000.000-Rp.1999.999</option>
                            <option
                                <?= ('Rp.2.000.000-Rp.4999.999' == $data_ortu['penghasilan_ayah']) ? 'selected' : '' ?>
                                value="Rp.2.000.000-Rp.4999.999">Rp.2.000.000-Rp.4999.999</option>
                            <option
                                <?= ('Rp.5.000.000-Rp.20.000.000' == $data_ortu['penghasilan_ayah']) ? 'selected' : '' ?>
                                value="Rp.5.000.000-Rp.20.000.000">Rp.5.000.000-Rp.20.000.000</option>
                            <option
                                <?= ('Lebih dari Rp.20.000.000' == $data_ortu['penghasilan_ayah']) ? 'selected' : '' ?>
                                value="Lebih dari Rp.20.000.000">Lebih dari Rp.20.000.000</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" readonly
                            value="<?= $data_ortu['nama_ibu'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan_ibu" class="form-label">Pendidikan Terakhir Ibu</label>
                        <select class="form-select" name="pendidikan_ibu" id="pendidikan_ibu" disabled>
                            <option disabled>Pilih pendidikan terakhir ibu</option>
                            <option <?= ('SD' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?> value="SD">
                                SD</option>
                            <option <?= ('SMP' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?>
                                value="SMP">SMP</option>
                            <option <?= ('SMA/SMK' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?>
                                value="SMA/SMK">SMA/SMK</option>
                            <option <?= ('D3' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?> value="D3">
                                D3</option>
                            <option <?= ('S1' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?> value="S1">
                                S1</option>
                            <option <?= ('S2' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?> value="S2">
                                S2</option>
                            <option <?= ('S3' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?> value="S3">
                                S3</option>
                            <option <?= ('Tidak Ada' == $data_ortu['pendidikan_terakhir_ibu']) ? 'selected' : '' ?>
                                value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu"
                            value="<?= $data_ortu['pekerjaan_ibu']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="penghasilan_ibu" class="form-label">Penghasilan Ibu</label>
                        <select class="form-select" id="penghasilan_ibu" name="penghasilan_ibu" required disabled>
                            <option disabled>Pilih Penghasilan Ibu</option>
                            <option <?= ('Kurang dari Rp.500.000' == $data_ortu['penghasilan_ibu']) ? 'selected' : '' ?>
                                value="Kurang dari Rp.500.000">Kurang dari Rp.500.000</option>
                            <option
                                <?= ('Rp.1.000.000-Rp.1999.999' == $data_ortu['penghasilan_ibu']) ? 'selected' : '' ?>
                                value="Rp.1.000.000-Rp.1999.999">Rp.1.000.000-Rp.1999.999</option>
                            <option
                                <?= ('Rp.2.000.000-Rp.4999.999' == $data_ortu['penghasilan_ibu']) ? 'selected' : '' ?>
                                value="Rp.2.000.000-Rp.4999.999">Rp.2.000.000-Rp.4999.999</option>
                            <option
                                <?= ('Rp.5.000.000-Rp.20.000.000' == $data_ortu['penghasilan_ibu']) ? 'selected' : '' ?>
                                value="Rp.5.000.000-Rp.20.000.000">Rp.5.000.000-Rp.20.000.000</option>
                            <option
                                <?= ('Lebih dari Rp.20.000.000' == $data_ortu['penghasilan_ibu']) ? 'selected' : '' ?>
                                value="Lebih dari Rp.20.000.000">Lebih dari Rp.20.000.000</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_lengkap_ortu" class="form-label">Alamat Lengkap Orang Tua</label>
                        <textarea name="alamat_lengkap_ortu" class="form-control" id="alamat_lengkap_ortu" cols="30"
                            rows="10" required readonly><?= $data_ortu['alamat_lengkap_ortu']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="provinsi_asal_orang_tua" class="form-label">Provinsi Asal Orang Tua</label>
                        <select name="provinsi_asal_orang_tua" class="form-control" id="provinsi_asal_orang_tua"
                            disabled required>
                            <option value="" selected disabled>Pilih Provinsi Asal Orang Tua</option>
                            <?php foreach ($provinsi as $prov) : ?>
                            <option <?= ($prov['id'] == $data_ortu['id_provinsi_asal_ortu']) ? 'selected' : '' ?>
                                value="<?= $prov['id']; ?>"><?= $prov['nama_provinsi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kabupaten_asal_orang_tua" class="form-label">Kabupaten Asal Orang Tua</label>
                        <select name="kabupaten_asal_orang_tua" class="form-control" id="kabupaten_asal_orang_tua"
                            disabled required>
                            <option value="" selected disabled>Pilih Kabupaten Asal Orang Tua</option>
                            <?php foreach ($kabupaten as $kab) : ?>
                            <option <?= ($kab['id'] == $data_ortu['id_kabupaten_ortu']) ? 'selected' : '' ?>
                                value="<?= $kab['id']; ?>"><?= $kab['kabupaten']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kodepos_alamat_orang_tua" class="form-label">Kodepos Alamat Orang Tua</label>
                        <input type="text" class="form-control" id="kodepos_alamat_orang_tua"
                            name="kodepos_alamat_orang_tua" readonly value="<?= $data_ortu['kode_pos_ortu'] ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp_orang_tua" class="form-label">No Telp Orang Tua</label>
                        <input type="text" class="form-control" id="no_telp_orang_tua" name="no_telp_orang_tua"
                            value="<?= $data_ortu['telepon_ortu'] ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_wali" class="form-label">Nama Wali (Jika Ada)</label>
                        <input type="text" class="form-control" id="nama_wali" name="nama_wali"
                            value="<?= $data_ortu['nama_wali'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan_wali" class="form-label">Pekerjaan Wali</label>
                        <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali"
                            value="<?= $data_ortu['pekerjaan_wali'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_lengkap_wali" class="form-label">Alamat Lengkap Wali</label>
                        <textarea name="alamat_lengkap_wali" class="form-control" id="alamat_lengkap_wali" cols="30"
                            rows="10" readonly><?= $data_ortu['alamat_lengkap_wali'] ?></textarea>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#judul_biodata').click(function() {
        $("#judul_biodata").removeClass("bg-primary");
        $("#judul_biodata").addClass("col-md-3 bg-info btn");
        $("#judul_sekolah_asal").removeClass("bg-info");
        $("#judul_sekolah_asal").addClass("col-md-3 bg-primary btn");
        $("#judul_prestasi").removeClass("bg-info");
        $("#judul_prestasi").addClass("col-md-3 bg-primary btn");
        $("#judul_data_orang_tua").removeClass("bg-info");
        $("#judul_data_orang_tua").addClass("col-md-3 bg-primary btn");
        $("#biodata").removeClass("visually-hidden");
        $("#data_sekolah").addClass("visually-hidden");
        $("#data_prestasi").addClass("visually-hidden");
        $("#data_ortu").addClass("visually-hidden");

    });
    $('#judul_sekolah_asal').click(function() {
        $("#judul_biodata").removeClass("bg-info");
        $("#judul_biodata").addClass("col-md-3 bg-primary btn");
        $("#judul_prestasi").removeClass("bg-info");
        $("#judul_prestasi").addClass("col-md-3 bg-primary btn");
        $("#judul_sekolah_asal").removeClass("bg-primary");
        $("#judul_sekolah_asal").addClass("col-md-3 bg-info btn");
        $("#judul_data_orang_tua").removeClass("bg-info");
        $("#judul_data_orang_tua").addClass("col-md-3 bg-primary btn");
        $("#biodata").addClass("visually-hidden");
        $("#data_sekolah").removeClass("visually-hidden");
        $("#data_prestasi").addClass("visually-hidden");
        $("#data_ortu").addClass("visually-hidden");
    });
    $('#judul_prestasi').click(function() {
        $("#judul_biodata").removeClass("bg-info");
        $("#judul_biodata").addClass("col-md-3 bg-primary btn");
        $("#judul_sekolah_asal").removeClass("bg-info");
        $("#judul_sekolah_asal").addClass("col-md-3 bg-primary btn");
        $("#judul_prestasi").removeClass("bg-primary");
        $("#judul_prestasi").addClass("col-md-3 bg-info btn");
        $("#judul_data_orang_tua").removeClass("bg-info");
        $("#judul_data_orang_tua").addClass("col-md-3 bg-primary btn");
        $("#biodata").addClass("visually-hidden");
        $("#data_sekolah").addClass("visually-hidden");
        $("#data_prestasi").removeClass("visually-hidden");
        $("#data_ortu").addClass("visually-hidden");
    });
    $('#judul_data_orang_tua').click(function() {
        $("#judul_biodata").removeClass("bg-info");
        $("#judul_biodata").addClass("col-md-3 bg-primary btn");
        $("#judul_data_orang_tua").removeClass("bg-primary");
        $("#judul_data_orang_tua").addClass("col-md-3 bg-info btn");
        $("#judul_sekolah_asal").removeClass("bg-info");
        $("#judul_sekolah_asal").addClass("col-md-3 bg-primary btn");
        $("#judul_prestasi").removeClass("bg-info");
        $("#judul_prestasi").addClass("col-md-3 bg-primary btn");
        $("#biodata").addClass("visually-hidden");
        $("#data_sekolah").addClass("visually-hidden");
        $("#data_prestasi").addClass("visually-hidden");
        $("#data_ortu").removeClass("visually-hidden");
    });
});
</script>