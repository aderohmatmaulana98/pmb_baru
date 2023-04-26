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
                        <div class="card-body">
                            <h4 class="card-title">Formulir Penentuan UKT</h4>
                            <p class="card-text">
                                Isilah form ini dengan sebenar - benarnya.
                            </p>
                            <form action="<?= base_url('user/tambah_ukt'); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <select name="pekerjaan" class="form-control form-select" required>
                                            <option value="" disabled selected>Pilih Pekerjaan</option>
                                            <?php foreach ($pekerjaan as $p) : ?>
                                                <option value="<?= $p['id']; ?>"><?= $p['detail_pekerjaan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="pendapatan">Pendapatan</label>
                                        <select name="pendapatan" class="form-control form-select" required>
                                            <option value="" disabled selected>Pilih Pendapatan</option>
                                            <?php foreach ($pendapatan as $pd) : ?>
                                                <option value="<?= $pd['id']; ?>"><?= $pd['detail_pendapatan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="kondisi_rumah">Kondisi Rumah</label>
                                        <select name="kondisi_rumah" class="form-control form-select" required>
                                            <option value="" disabled selected>Pilih Kondisi Rumah</option>
                                            <?php foreach ($kondisi_rumah as $kr) : ?>
                                                <option value="<?= $kr['id']; ?>"><?= $kr['detail_kondisi_rumah']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="listrik">Listrik</label>
                                        <select name="listrik" class="form-control form-select" required>
                                            <option value="" disabled selected>Pilih Listrik</option>
                                            <?php foreach ($listrik as $l) : ?>
                                                <option value="<?= $l['id']; ?>"><?= $l['detail_listrik']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="Tanggungan">Tanggungan</label>
                                        <select name="tanggungan" class="form-control form-select" required>
                                            <option value="">Pilih Tanggungan</option>
                                            <?php foreach ($tanggungan as $t) : ?>
                                                <option value="<?= $t['id']; ?>"><?= $t['detail_tanggungan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="slip_gaji" class="form-label">Bukti Slip Gaji</label>
                                        <input class="form-control" type="file" name="slip_gaji" id="slip_gaji" required>
                                        <small>File diupload dengan format PDF dan Ukuran kurang dari 10 MB</small>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="foto_rumah" class="form-label">Foto Rumah (Depan, Samping, Atap, Ruang Tamu dan Dapur)</label>
                                        <input class="form-control" type="file" name="foto_rumah" id="foto_rumah" required>
                                        <small>File diupload dengan format PDF dan Ukuran kurang dari 10 MB</small>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="pembayaran_listrik" class="form-label">Struk/Bukti Pembayaran Listrik 2 bulan Terakhir</label>
                                        <input class="form-control" type="file" name="pembayaran_listrik" id="pembayaran_listrik">
                                        <small>File diupload dengan format PDF dan Ukuran kurang dari 10 MB</small>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                                        <input class="form-control" type="file" name="kartu_keluarga" id="kartu_keluarga" required>
                                        <small>File diupload dengan format PDF dan Ukuran kurang dari 10 MB</small>
                                    </div>
                                </div>
                                <div class="form-actions d-flex justify-content-end">
                                    <button type="submit" onclick="javascript: return confirm('Dengan ini saya menyatakan bahwa data yang saya isikan benar!')" class="btn btn-primary me-1">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>