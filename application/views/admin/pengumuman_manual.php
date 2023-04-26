<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <?= $this->session->flashdata('message');  ?>

            <div class="card">
                <div class="card-body">

                    <table class='table table-striped' id="example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Tahun Ajaran</th>
                                <th>Kode Tiket</th>
                                <th>Scan Tiket</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($jalur_pkl as $jp) :
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $jp['nik'] ?></td>
                                <td><?= $jp['nama_lengkap'] ?></td>
                                <td><?= $jp['tahun_ajaran'] ?></td>
                                <td><?= $jp['kode_tiket'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal1">
                                        Lihat
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal1" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Scan Tiket
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body mx-auto">
                                                    <iframe
                                                        src="<?= base_url('assets/img/tiket/') . $jp['scan_tiket'] ?>"
                                                        width="1000" height="600"></iframe>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php if ($jp['status'] == 0) : ?>
                                <td><span class="badge bg-danger">Pending</span></td>
                                <?php else : ?>
                                <td><span class="badge bg-success">Verified</span></td>
                                <?php endif; ?>

                                <td>
                                    <?php if ($jp['status'] == 0) : ?>
                                    <a href="<?= base_url("admin/konfirmasi_jalur_pkl/") . $jp['id'] ?>"><span
                                            class="badge bg-success">Konfirmasi</span></a>
                                    <?php else : ?>
                                    <a href="<?= base_url("admin/batalkan_konfirmasi_jalur_pkl/") . $jp['id']  ?>"><span
                                            class="badge bg-danger">Batalkan</span></a>
                                    <?php endif; ?>
                                    <a href="<?= base_url("admin/hapus_jalur_pkl/") . $jp['id'] . '/' . $jp['user_id'] ?>"
                                        onclick="javascript: return confirm('Anda yakin akan menghapus ini? ')"><span
                                            class="badge bg-danger">Hapus</span></a>
                                </td>
                            </tr>
                            <?php $i++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
</div>