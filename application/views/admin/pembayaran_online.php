<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <?= $this->session->flashdata('message');  ?>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class='table table-striped' id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kode Virtual Account</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Jalur</th>
                                    <th>Status Pembayaran</th>
                                    <th>Total Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                            foreach ($pembayaran_online as $po) :
                            ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $po['nik'] ?></td>
                                    <td><?= $po['nama_lengkap'] ?></td>
                                    <td><?= $po['no_pembayaran'] ?></td>
                                    <td><?= $po['tahun_ajaran'] ?></td>
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
                                                        <h5 class="modal-title" id="exampleModalLabel">Bukti Bayar</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body mx-auto">
                                                        <iframe
                                                            src="<?= base_url('assets/img/bukti_bayar/') . $po['bukti_bayar'] ?>"
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
                                    <td><?= $po['jalur_pendaftaran'] ?></td>
                                    <?php if ($po['status_pembayaran'] == 0) : ?>
                                    <td><span class="badge bg-danger">Pending</span></td>
                                    <?php else : ?>
                                    <td><span class="badge bg-success">Setlement</span></td>
                                    <?php endif; ?>

                                    <td><?= $po['total_pembayaran'] ?></td>
                                    <td>
                                        <?php if ($po['status_pembayaran'] == 0) : ?>
                                        <a href="<?= base_url("admin/konfirmasi_pembayaran_online/") . $po['id'] ?>"><span
                                                class="badge bg-success">Konfirmasi</span></a>
                                        <?php else : ?>
                                        <a
                                            href="<?= base_url("admin/batalkan_konfirmasi_pembayaran_online/") . $po['id']  ?>"><span
                                                class="badge bg-danger">Batalkan</span></a>
                                        <?php endif; ?>

                                        <a href="<?= base_url("admin/hapus_pembayaran_online/") . $po['id'] . '/' . $po['user_id'] ?>"
                                            onclick="javascript: return confirm('Anda yakin akan menghapus ini? ')"><span
                                                class="badge bg-danger">Hapus</span></a>

                                        <a href="<?= base_url("admin/cetak_bukti_pembayaran/") . $po['id'] ?>"><span
                                                class="badge bg-primary">Cetak</span></a>
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
        </div>
    </section>
</div>