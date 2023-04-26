<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head><body>
    <div class ="container">
    <table style="border: 2px ;">
        <tr>
            <td style="padding: 0px; border: 2px ;" align="center">
                <img src="<?= base_url('assets/landing/assets/img/akn/logo_akn.png'); ?>" height="120px" width="120px" alt="Gambar">
            </td>
            <td width="0%" style="border: 2px ;">
                <div>
                <h4 class="text-center">AKADEMI KOMUNITAS NEGERI SENI DAN BUDAYA YOGYAKARTA</h4>
                <p class="text-center">Jl. Parangtritis No.364, Pandes, Panggungharjo, <br> Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188</p>
                </div>
            </td>
        </tr>
    </table>

    <hr style=" border: 0; border-style: inset; border-top: 1px solid #000;">
    <h4 class="text-center mt-3">DATA NILAI TEST CALON MAHASISWA</h4>
    <table class="mt-3" style="width: 100%;">
        <tr class="text-center" style="font-size: 16px;">
            <th style="border: 1px solid black;" scope="col">
                No
            </th>
            <th style="border: 1px solid black;" scope="col">No Pendaftaran</th>
            <th style="border: 1px solid black;" scope="col">Nama</th>
            <th style="border: 1px solid black;" scope="col">Prodi</th>
            <th style="border: 1px solid black;" scope="col">Praktek</th>
            <th style="border: 1px solid black;" scope="col">Wawancara</th>
            <th style="border: 1px solid black;" scope="col">Skor</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($data_calon_mahasiswa as $dcm) : ?>
            <tr class="text-center" style="font-size: 18px;">
                <th scope="row" class="text-center" class="py-4" style="border: 1px solid black;"><?= $i; ?></th>
                <td class="py-4" style="border: 1px solid black; "><?= $dcm['no_pendaftaran'] ?></td>
                <td class="py-4" style="border: 1px solid black; "><?= ucwords(strtolower($dcm['nama_lengkap'])) ?></td>
                <td class="py-4" style="border: 1px solid black; "><?= $dcm['nama_prodi'] ?></td>
                <td class="py-4" style="border: 1px solid black; "><?= $dcm['praktek'] ?></td>
                <td class="py-4" style="border: 1px solid black; "><?= $dcm['wawancara'] ?></td>
                <td class="py-4" style="border: 1px solid black; "><?= $dcm['skor'] ?></td>
            </tr>
        <?php $i++; endforeach; ?>
    </table> <br><br><br><br><br>
    <div class="d-flex justify-content-center" style="font-size: 18px;">
    <table>
        <tr>
            <td>
                Penguji 1
                <br><br><br><br>
            </td>
            <td width="70">

            </td>
            <td>
                Penguji 2
                <br><br><br><br>
            </td>
			<td width="70">

            </td>
		
			<td>
                Penguji 3
                <br><br><br><br>
            </td>
			<td width="70">

            </td>

            <td>
                Penguji 4
                <br><br><br><br>
            </td>
        </tr>
        <tr>
            <td>
                <p style="line-height: 70%;">............................<hr></p>
            </td>
            <td width="60">

            </td>
            <td>
                <p style="line-height: 70%;">............................<hr></p>
            </td>
			<td width="60">

            </td>
			<td>
                <p style="line-height: 70%;">............................<hr></p>
            </td>
			<td width="60">

            </td>

			<td>
                <p style="line-height: 70%;">............................<hr></p>
            </td>
        </tr>
        <tr>
            <td>
                NIP.
            </td>
            <td width="60">

            </td>
            <td>
                NIP.
            </td>
			<td width="60">

</td>
			<td>
                NIP.
            </td>
			<td width="60">

			<td>
                NIP.
            </td>

</td>
        </tr>
        
    </table>
    </div>
    </div>
</body></html>
