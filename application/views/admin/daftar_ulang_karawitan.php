<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2 container">
            <?= $this->session->flashdata('message');  ?>

            <div class="card shadow p-3">
                <div class="table-responsive">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Mahasiswa</th>
                                <th scope="col">Prodi</th>
                                <th scope="col">Total bobot UKT</th>
                                <th scope="col">Jenis UKT</th>
                                <th scope="col">Status daftar ulang</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($ukt as $u) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $u['nama_lengkap']; ?></td>
                                    <td><?= $u['nama_prodi']; ?></td>
                                    <td><?= $u['total_bobot']; ?></td>
                                    <td><?= $u['jenis_ukt']; ?></td>
                                    <td>
                                        <?php if ($u['status_daftar_ulang'] == NULL || $u['status_daftar_ulang'] == 0) : ?>
                                            <span class="badge bg-danger">Belum Dikonfirmasi</span>
                                        <?php else : ?>
                                            <span class="badge bg-success">Terkonfirmasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span>
                                            <a class="badge bg-primary mb-2" href="<?= base_url('admin/detail_ukt/' . $u['id']) ?>">Lihat</a>
                                            <a class="badge bg-warning mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $u['id']; ?>" href="#">Edit UKT</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?= $u['id']; ?>" tabindex=" -1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah UKT</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url('admin/edit_ukt') ?>" method="post">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Uang Kuliah Tunggal</label>
                                                                    <select class="form-select" name="ukt" id="ukt" required>
                                                                        <?php if ($u['jenis_ukt'] == 'UKT 1') : ?>
                                                                            <option value="UKT 1" selected>UKT 1</option>
                                                                            <option value="UKT 2">UKT 2</option>
                                                                        <?php else : ?>
                                                                            <option value="UKT 1">UKT 1</option>
                                                                            <option value="UKT 2" selected>UKT 2</option>
                                                                        <?php endif; ?>

                                                                    </select>
                                                                    <input type="text" class="form-control" id="id" name="id" value="<?= $u['id'] ?>" hidden>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="badge bg-danger mb-2" onclick="javascript: return confirm('Anda yakin akan menghapus ini? ')" href="<?= base_url('admin/hapus_daftar_ulang/' . $u['id'] . '/' . str_replace(' ', '', $title) . '/' . $u['id_user']) ?>">Hapus</a>
                                            <?php if ($u['status_daftar_ulang'] == NULL || $u['status_daftar_ulang'] == 0) : ?>
                                                <a class="badge bg-success mb-2" href="<?= base_url('admin/konfirmasi_daftar_ulang/' . $u['id'] . '/' . str_replace(' ', '', $title)) ?>">Konfirmasi</a>
                                            <?php else : ?>
                                                <a class="badge bg-danger mb-2" href="<?= base_url('admin/batal_konfirmasi_daftar_ulang/' . $u['id'] . '/' . str_replace(' ', '', $title)) ?>">batalkan</a>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
</div>