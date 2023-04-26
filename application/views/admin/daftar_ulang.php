<div class="main-content container-fluid">
    <div class="page-title mb-3">
        <h3><?= $title; ?></h3>
    </div>
    <section class="section">
        <div class="row mb-2 mx-auto">
            <?= $this->session->flashdata('message');  ?>

            <div class="row justify-content-center">
                <div class="card col-md-4" style="background: #ff9933;">
                    <div class="card-body text-white">
                        <h5 class="card-title text-dark"><b>D1 - Seni Karawitan</b></h5>
                        <p>Lulus : </p>
                        <p>Daftar ulang : </p>
                        <a href="<?= base_url('admin/daftar_ulang_karawitan') ?>" class="btn btn-secondary">Lihat</a>
                    </div>
                </div>
                <div class="card col-md-4 mx-2" style="background: #ff9933;">
                    <div class="card-body text-white">
                        <h5 class="card-title text-dark"><b>D1 - Seni Tari</b></h5>
                        <p>Lulus : </p>
                        <p>Daftar ulang : </p>
                        <a href="<?= base_url('admin/daftar_ulang_tari') ?>" class="btn btn-secondary">Lihat</a>
                    </div>
                </div>
                <div class="card col-md-4" style="background: #ff9933;">
                    <div class="card-body text-white">
                        <h5 class="card-title text-dark"><b>D1 - Kriya Kulit</b></h5>
                        <p>Lulus : </p>
                        <p>Daftar ulang : </p>
                        <a href="<?= base_url('admin/daftar_ulang_kriya') ?>" class="btn btn-secondary">Lihat</a>
                    </div>
                </div>
            </div>
    </section>
</div>
</div>