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
                                <th scope="col">Dari tanggal</th>
                                <th scope="col">Sampai tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($jadwal_daftar_ulang as $jdu) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $jdu['jadwal_daftar_ulang']; ?></td>
                                    <td><?= $jdu['sampai_tanggal']; ?></td>
                                    <td>
                                        <?php if ($jdu['is_active'] == 1) : ?>
                                            Aktif
                                        <?php else : ?>
                                            Non Aktif
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a type="button" class="btn badge bg-success" data-bs-toggle="modal" data-bs-target="#exampleModal1<?= $jdu['id']; ?>">
                                            Edit
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal1<?= $jdu['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit jadwal daftar ulang</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('admin/edit_jadwal_daftar_ulang') ?>" method="POST" enctype="multipart/form-data">
                                                            <div class="mb-3">
                                                                <label for="jadwal_daftar_ulang" class="form-label">Jadwal daftar ulang</label>
                                                                <input type="datetime-local" class="form-control" value="<?= $jdu['jadwal_daftar_ulang']; ?>" id="jadwal_daftar_ulang" name="jadwal_daftar_ulang" aria-describedby="jadwal_daftar_ulang" required>
                                                                <input type="text" class="form-control" value="<?= $jdu['id']; ?>" id="id" name="id" aria-describedby="id" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="sampai_tanggal" class="form-label">Sampai tanggal</label>
                                                                <input type="datetime-local" class="form-control" value="<?= $jdu['sampai_tanggal']; ?>" id="sampai_tanggal" name="sampai_tanggal" aria-describedby="sampai_tanggal" required>
                                                            </div>
                                                            <div>
                                                                <label for="jadwal_daftar_ulang" class="form-label">Status</label>
                                                                <select class="form-select" name="is_active" id="is_active" aria-label="is_active">
                                                                    <option value="" disabled selected>Pilih status</option>
                                                                    <option value="0">Tidak aktif</option>
                                                                    <option value="1">Aktif</option>
                                                                </select>
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