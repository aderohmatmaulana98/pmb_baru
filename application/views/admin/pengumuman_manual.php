<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <?= $this->session->flashdata('message');  ?>

            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah Pengumuman
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengumuman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('admin/tambah_penguman_manual') ?>" method="post"
                                            enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="gelombang" class="form-label">Gelombang</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="gelombang" id="gelombang" required>
                                                    <option value="" disabled selected>Pilih Gelombang</option>
                                                    <?php foreach($gelombang as $g) : ?>
                                                    <option value="<?= $g['id'] ?>"><?= $g['gelombang'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Upload File Pengumuman</label>
                                                <input class="form-control" type="file" id="file_pengumuman"
                                                    name="file_pengumuman" required>
                                                <small>File harus berbentuk format PDF minimal ukuran maksimal 1
                                                    MB</small>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class='table table-striped' id="example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gelombang</th>
                                <th>Download Pengumuman</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($pengumuman as $p) :
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $p['gelombang'] ?></td>
                                <td><a
                                        href="<?= base_url('assets/img/pengumuman/'.$p['file_pengumuman']) ?>"><?= $p['file_pengumuman'] ?></a>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/hapus_pengumuman_manual/'.$p['id']) ?>"
                                        onclick="javascript: return confirm('Anda yakin akan menghapus ini? ')"><span
                                            class="badge rounded-pill bg-danger">Hapus</span></a>
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