<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Upload Dokumen Persyaratan</h3>
    </div>
    <section class="section">
        <div class="row mb-12 mt-3">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Selamat Datang</h4>
                <p>Petunjuk pengisian :</p>
                <p>1. Masukan kode tiket yang sesuai </p>
                <p>2. Upload tiket dengan format PDF</p>
                <p>3. Submit</p>
                <hr>
                <p class="mb-0"></p>
            </div>
            <div class="col-lg card shadow p-3">
                <?= $this->session->flashdata('message');  ?>
                <form action="<?= base_url('user/aksi_upload_kupon') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="kode_tiket">Kode Tiket</label>
                        <input type="text" id="kode_tiket" class="form-control" name="kode_tiket"
                            placeholder="Kode tiket" required>
                    </div>

                    <div class="mb-3">
                        <label for="scan_tiket">Scan Tiket</label>
                        <input type="file" class="form-control" id="scan_tiket" name="scan_tiket" required>
                        <small class="text-muted">*upload scan tiket dengan format pdf</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </section>
</div>
</div>