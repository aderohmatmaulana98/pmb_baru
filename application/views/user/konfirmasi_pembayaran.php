<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Bukti bayar</h3>
    </div>
    <section class="section">
        <div class="row mb-12 mt-3">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Selamat Datang</h4>
                <p>Silahkan melakukan pembayaran terlebih dahulu</p>
                <hr>
                <p class="mb-0">Pembayaran dapat dilakukan dengan melakukan pembayaran ke nomor virtual account <b><?= $user['no_va'] ?></b> dengan biaya Rp. 200.000,00</p>
            </div>
            <div class="col-lg card shadow p-3">
                <?= $this->session->flashdata('message');  ?>
                <form action="<?= base_url('user/aksi_bayar') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="no_va">No Virtual Account</label>
                        <input type="text" id="no_slip" class="form-control" value="<?= $user['no_va']; ?>" name="no_va" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="bukti_bayar">Upload bukti pembayaran</label>
                        </br>
                        <input type="file" placeholder="Bukti bayar" id="bukti_bayar" name="bukti_bayar" required><br>
                        <small class="text-muted">*Upload dalam format PDF</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </section>
</div>
</div>