<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <div class="col-lg">
                <?= $this->session->flashdata('message');  ?>
                <div class="card">
                    <div class="card-content">
                        <div class="p-3 text-center">
                            <h3>Formulir Penentuan UKT</h3>
                        </div>
                        <div class="card-body">
                            <?php if ($ukt['status_daftar_ulang'] == NULL || $ukt['status_daftar_ulang'] == 0) : ?>
                                <p>Nama Lengkap : <span><?= $ukt['nama_lengkap']; ?></span></p>
                                <p>Status Daftar Ulang : <span class="badge bg-danger">Belum Dikonfirmasi</span></p>
                            <?php else : ?>
                                <p>Nama Lengkap : <span><?= $ukt['nama_lengkap']; ?></span></p>
                                <p>Status Daftar Ulang : <span class="badge bg-success">Terkonfirmasi</span></p>
                            <?php endif; ?>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Pekerjaan</th>
                                        <td><?= $ukt['detail_pekerjaan']; ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                                Lihat slip gaji
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">slip gaji</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body mx-auto">
                                                            <iframe src="<?= base_url('assets/img/ukt/') . $ukt['slip_gaji'] ?>" width="1000" height="600"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pendapatan</th>
                                        <td><?= $ukt['detail_pendapatan']; ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                                Lihat bukti pendapatan
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">bukti pendapatan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body mx-auto">
                                                            <iframe src="<?= base_url('assets/img/ukt/') . $ukt['slip_gaji'] ?>" width="1000" height="600"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kondisi Rumah</th>
                                        <td><?= $ukt['detail_kondisi_rumah']; ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                                                Lihat kondisi rumah
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">kondisi rumah</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body mx-auto">
                                                            <iframe src="<?= base_url('assets/img/ukt/') . $ukt['foto_rumah'] ?>" width="1000" height="600"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Listrik</th>
                                        <td><?= $ukt['detail_listrik']; ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal4">
                                                Lihat struk pembayaran listrik
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">struk pembayaran listrik</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body mx-auto">
                                                            <iframe src="<?= base_url('assets/img/ukt/') . $ukt['struk_listrik'] ?>" width="1000" height="600"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggungan</th>
                                        <td><?= $ukt['detail_tanggungan']; ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal5">
                                                Lihat kartu keluarga
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">kartu keluarga</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body mx-auto">
                                                            <iframe src="<?= base_url('assets/img/ukt/') . $ukt['kartu_keluarga'] ?>" width="1000" height="600"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>