<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2 container">
            <?= $this->session->flashdata('message');  ?>

            <div class="card shadow">
                <div class="py-3">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">Tambah Jadwal Beasiswa</a>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Beasiswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= base_url('admin/tambah_jadwal_beasiswa') ?>" method="POST">
                                        <div class="mb-3">
                                            <label for="nama_beasiswa" class="form-label">Nama Beasiswa</label>
                                            <input type="text" class="form-control" name="nama_beasiswa" id="nama_beasiswa" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dari_tanggal" class="form-label">Dari Tanggal</label>
                                            <input type="datetime-local" class="form-control" name="dari_tanggal" id="dari_tanggal" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sampai_tanggal" class="form-label">Sampai Tanggal</label>
                                            <input type="datetime-local" class="form-control" name="sampai_tanggal" id="sampai_tanggal" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="is_active" class="form-label">Status</label>
                                            <select class="form-select" name="is_active" required>
                                                <option value="" selected disabled>Pilih Status</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Non Aktif</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Beasiswa</th>
                                <th scope="col">Dari Tanggal</th>
                                <th scope="col">Sampai Tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($jadwal_beasiswa as $jb) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $jb['nama_beasiswa']; ?></td>
                                    <td><?= date('d-m-Y H:s', strtotime($jb['dari_tanggal'])); ?></td>
                                    <td><?= date('d-m-Y H:s', strtotime($jb['sampai_tanggal'])); ?></td>
                                    <td>
                                        <?php if ($jb['is_active'] == 1) : ?>
                                            Aktif
                                        <?php else : ?>
                                            Non Aktif
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a type="button" class="btn badge bg-success" data-bs-toggle="modal" data-bs-target="#exampleModal1<?= $jb['id']; ?>">
                                            Edit
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal1<?= $jb['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Beasiswa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form action="<?= base_url('admin/edit_jadwal_beasiswa') ?>" method="POST">
                                                            <div class="mb-3">
                                                                <label for="nama_beasiswa" class="form-label">Nama Beasiswa</label>
                                                                <input type="text" class="form-control" value="<?= $jb['nama_beasiswa']; ?>" name="nama_beasiswa" id="nama_beasiswa" required>
                                                                <input type="text" class="form-control" value="<?= $jb['id']; ?>" name="id" id="id" required hidden>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="dari_tanggal" class="form-label">Dari Tanggal</label>
                                                                <input type="datetime-local" class="form-control" value="<?= $jb['dari_tanggal']; ?>" name="dari_tanggal" id="dari_tanggal" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="sampai_tanggal" class="form-label">Sampai Tanggal</label>
                                                                <input type="datetime-local" class="form-control" value="<?= $jb['sampai_tanggal']; ?>" name="sampai_tanggal" id="sampai_tanggal" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="is_active" class="form-label">Status</label>
                                                                <select class="form-select" name="is_active" required>
                                                                    <option value="" selected disabled>Pilih Status</option>
                                                                    <?php if ($jd['is_active'] == 1) : ?>
                                                                        <option value="1" selected>Aktif</option>
                                                                        <option value="0">Tidak Aktif</option>
                                                                    <?php else : ?>
                                                                        <option value="1">Aktif</option>
                                                                        <option value="0" selected>Non Aktif</option>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class=" modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                </div>

                <a class="btn badge bg-danger" onclick="javascript: return confirm('Anda yakin akan menghapus ini? ')" href="<?= base_url('admin/delete_jadwal_beasiswa/' . $jb['id']) ?>">Hapus</a>
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