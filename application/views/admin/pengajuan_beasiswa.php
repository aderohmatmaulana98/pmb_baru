<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title ?></h3>
    </div>
    <section class="section mt-4">
        <div class="card p-2">
            <div class="p-4">
                <div>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Ajukan Beasiswa</a>
                    <a href="https://docs.google.com/document/d/1BZQNqNKMDeihrS3w7G1woDn6OYZq3OXY/edit?usp=sharing&ouid=107200090220997921035&rtpof=true&sd=true" class="btn btn-primary">Download Surat Pengajuan</a>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajukan Beasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('user/aksi_pengajuan_beasiswa') ?>" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="surat_pengajuan" class="form-label">Upload Surat Pengajuan Beasiswa</label>
                                        <input class="form-control" type="file" id="surat_pengajuan" name="surat_pengajuan" required>
                                        <small>Format file harus PDF</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="scan_ktp" class="form-label">Scan KTP/Surat domisili DIY</label>
                                        <input class="form-control" type="file" id="scan_ktp" name="scan_ktp" required>
                                        <small>Format file harus PDF</small>
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
            </div>

            <div class="card-body">
                <?= $this->session->flashdata('message');  ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="example" class="display">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Surat Pengajuan Beasiswa</th>
                                <th scope="col">KTP DIY/Surat Domisili</th>
                                <th scope="col">Status Penerimaan</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($pengajuan_beasiswa as $pb) : ?>
                                <tr>
                                    <th scope="row"><?= $no; ?></th>
                                    <td><!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                            Lihat Surat Pengajuan
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Surat Pengajuan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body mx-auto">
                                                        <iframe src="<?= base_url('assets/img/surat_pengajuan_beasiswa/') . $pb['surat_pengajuan_beasiswa'] ?>" width="1000" height="600"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                            Lihat KTP
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Kartu Tanda Penduduka</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body mx-auto">
                                                        <iframe src="<?= base_url('assets/img/ktp/') . $pb['ktp'] ?>" width="1000" height="600"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($pb['status_penerimaan'] == 'P') : ?>
                                            <span class="badge rounded-pill bg-warning">Pending</span>
                                        <?php elseif ($pb['status_penerimaan'] == 'T') : ?>
                                            <span class="badge rounded-pill bg-danger">Ditolak</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-success">Diterima</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($pb['status_penerimaan'] == 'P') : ?>
                                            <a class="btn badge bg-success" href="<?= base_url('admin/terima_beasiswa/' . $pb['id']) ?>">Terima</a>
                                            <a class="btn badge bg-danger" href="<?= base_url('admin/tolak_beasiswa/' . $pb['id']) ?>">Tolak</a>
                                        <?php else : ?>
                                            <a class="btn badge bg-danger" href="<?= base_url('admin/batalkan_beasiswa/' . $pb['id']) ?>">Batalkan</a>
                                        <?php endif; ?>
                                        <span>||</span>
                                        <span class="btn badge bg-success" data-bs-toggle="modal" data-bs-target="#exampleModal3">Edit</span>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Pengajuan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('user/edit_pengajuan_beasiswa') ?>" method="post" enctype="multipart/form-data">
                                                            <div class="mb-3">
                                                                <label for="surat_pengajuan" class="form-label">Upload Surat Pengajuan Beasiswa</label>
                                                                <input class="form-control" type="file" id="surat_pengajuan" name="surat_pengajuan">
                                                                <small>Format file harus PDF</small>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="scan_ktp" class="form-label">Scan KTP/Surat domisili DIY</label>
                                                                <input class="form-control" type="file" id="scan_ktp" name="scan_ktp">
                                                                <small>Format file harus PDF</small>
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
                                        <a href="<?= base_url('user/delete_pengajuan_beasiswa/') . $pb['id']  ?>" onclick="javascript: return confirm('Anda yakin akan menghapus ini? ')"><span class="badge bg-danger">Delete</span></a>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
</div>