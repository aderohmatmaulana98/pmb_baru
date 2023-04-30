<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?= $title ?></h3>
    </div>
    <section class="section mt-4">
        <div class="row mb-2">
            <div class="my-4">
                <?php if($cek_pengumuman_manual == 0) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Belum Ada Pengumuman
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php else : ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    Pengumuman Sudah Terbit
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                        </div>
                        <table class='table table-striped' id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gelombang</th>
                                    <th>Download Pengumuman</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                            foreach ($pengumuman_manual as $p) :
                            ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $p['gelombang'] ?></td>
                                    <td><a href="<?= base_url('assets/img/pengumuman/'.$p['file_pengumuman']) ?>">Download
                                            Disini</a>
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
</div>