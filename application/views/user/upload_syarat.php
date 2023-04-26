<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Upload Dokumen Persyaratan</h3>
    </div>
    <section class="section">
        <div class="row mb-12 mt-3">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Selamat Datang</h4>
                <p>Petunjuk pengisian :</p>
                <p>1. Download template surat rekomendasi </p>
                <p>2. Masukan file surat rekomendasi ke inputan surat rekomendasi</p>
                <p>3. Buat link google drive, isi google drive dengan file portofolio dan sertifikat dukung lainnya</p>
                <p>4. Masukan link goggle drive kedalam inputan portofolio dan sertifikat dukung lainnya</p>
                <p>5. submit</p>
                <hr>
                <p class="mb-0"></p>
            </div>
            <div class="col-lg card shadow p-3">
                <?= $this->session->flashdata('message');  ?>
                <form action="<?= base_url('user/aksi_upload_syarat') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="surat_rekomendasi">Surat rekomendasi</label>
                        <input type="file" id="surat_rekomendasi" class="form-control" name="surat_rekomendasi" placeholder="Link google drive" required>
                        <small>*download template disini <a href="https://s.id/Surat-Rekomendasi" target="_blank" rel="noopener noreferrer">s.id/Surat-Rekomendasi</a>, format dalam bentuk PDF</small>
                    </div>

                    <div class="mb-3">
                        <label for="bukti_bayar">Portofolio dan sertifikat dukung lainnya</label>
                        <input type="text" class="form-control" placeholder="Link google drive" id="portofolio" name="portofolio" required>
                        <small class="text-muted">*download template disini <a href="https://s.id/template-portfolio" target="_blank" rel="noopener noreferrer">s.id/template-portfolio</a></small>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </section>
</div>
</div>