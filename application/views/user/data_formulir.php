<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 mx-auto mt-3">
            <div class="card pt-4">
                <h2 class="text-center mb-3">Data Formulir Pendaftaran</h2>
                <!-- <div class="text-center">
                    <a href="<?= base_url('user/cetak_kartu_test') ?>" class="btn btn-primary"> <i data-feather="printer" width="20"></i> Cetak Kartu Test</a>
                    <a href="<?= base_url('user/biodata') ?>" class="btn btn-primary"><i data-feather="printer" width="20"></i> Data Cetak Formulir</a>
                </div> -->
                <div class="card-body">
                    <?= $this->session->flashdata('message');  ?>
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" class="display">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">No Pendaftaran</th>
                                    <th scope="col">Program Studi</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Tempat & Tgl Lahir</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Gelombang</th>
                                    <th scope="col">No WA</th>
                                    <th scope="col">Status Finalisasi</th>
                                    <th scope="col">Status Status Validasi Berkas</th>
                                    <th scope="col">Status Seleksi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($pendaftar as $p) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $p['nik']; ?></td>
                                        <td><?= $p['no_pendaftaran']; ?></td>
                                        <td><?= $p['nama_prodi']; ?></td>
                                        <td><?= $p['nama_lengkap']; ?></td>
                                        <td>
                                            <?php if ($p['jenis_kelamin'] == 1) : ?>
                                                Laki - Laki
                                            <?php else : ?>
                                                Perempuan
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $p['tempat_lahir'] . ' ' . date('d-M-Y', strtotime($p['tanggal_lahir'])); ?></td>
                                        <td><?= $p['email']; ?></td>
                                        <td>
                                            <span class="badge bg-danger">Gelombang <?= $p['id_jadwal']; ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><i class="fab fa-whatsapp"></i><?= ' ' . $p['telepon']; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($p['status_finalisasi'] == 1) : ?>
                                                <span class="badge bg-success">finalisasi</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Belum finalisasi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['status_validasi_berkas'] == 1) : ?>
                                                <span class="badge bg-success">Valid</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Belum divalidasi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['id_pengumuman'] == NULL) : ?>
                                                <span class="badge bg-warning">Belum diumumkan</span>
                                            <?php elseif ($p['id_pengumuman'] == 1) : ?>
                                                <span class="badge bg-success">Lulus</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Tidak Lulus</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['status_finalisasi'] == 1) : ?>
                                                <a href="<?= base_url('user/cetak_kartu_test/' . $p['id'] . '/' . $p['id_user']) ?>" class="btn btn-success btn-sm">Cetak</a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('user/detail_formulir/' . $user_id) ?>" class="btn btn-primary btn-sm">Lihat</a>
                                        </td>
                                    </tr>
                                <?php $i++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>