<?php

include "../config.php";
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
	//Page footer
	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-1);
		//Arial italic 9
		$this->SetFont('Arial','I',9);
		//nomor halaman
		$this->Cell(0,0.8,'Halaman '.$this->PageNo().' dari {nb}',0,0,'C');
	}
}

$pdf = new PDF('P','cm','A4');
$pdf->SetMargins(2,2,2,2);
$pdf->AliasNbPages();
$pdf->AddPage();

    // AWAL REPORT HEADER
    $pdf->SetFont('Times','B',14);
    $pdf->Cell(19,0.5,'Sistem Pendukung Keputusan',0,1,'C');
    $pdf->Cell(19,0.5,'Penentuan Pendirian Pabrik Baru',0,1,'C');
    $pdf->Cell(19,0.5,'Metode SAW',0,1,'C');
    $pdf->Ln(1);
    $pdf->Cell(19,0.5,'Hasil Perangkingan :',0,1,'L');
    // $pdf->Ln(1);

    // REPORT DETAIL
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(2,0.8,'NO.',1,0,'C');
    $pdf->Cell(9,0.8,'Alternatif',1,0,'C');
    $pdf->Cell(6,0.8,'Nilai',1,0,'C');

    // isi tabel sesuai degan tabel hasil
    $pdf->SetFont('Times','',12);
    $no=1;

    $preferenceValues = array(); // Array untuk menyimpan nilai preferensi untuk setiap alternatif
    $criteriaWeights = array(); // Array untuk menyimpan bobot kriteria
    $maxValues = array(); // Array untuk menyimpan nilai maksimum untuk setiap kriteria
    $minValues = array(); // Array untuk menyimpan nilai minimum untuk setiap kriteria

    $sql = "SELECT * FROM kriteria";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      $kriteriaId = $row['id_kriteria'];
      $criteriaWeights[$kriteriaId] = $row['bobot']; //menyimpan bobot kriteria
      // mendapatkan nilai minimum dan maksimum untuk setiap kriteria 
      $sqlMinMax = "SELECT MIN(nilai) AS cost, MAX(nilai) AS benefit FROM normalisasi WHERE id_kriteria = '$kriteriaId'";
      $resultMinMax = $conn->query($sqlMinMax);
      $rowMinMax = $resultMinMax->fetch_assoc();
      $minValues[$kriteriaId] = $rowMinMax['cost'];
      $maxValues[$kriteriaId] = $rowMinMax['benefit'];
    }

        $sqlAlternatif = "SELECT DISTINCT alternatif.nama_alternatif as alt FROM alternatif";
        $resultAlternatif = $conn->query($sqlAlternatif);
        while ($rowAlternatif = $resultAlternatif->fetch_assoc()) {
          $preferenceValue = 0; // Inisialisasi nilai preferensi untuk setiap alternatif

          // Menampilkan nilai-nilai kriteria untuk setiap alternatif
          $sqlKriteria = "SELECT kriteria.id_kriteria as krt, kriteria.atribut as atribut, normalisasi.nilai as nilai 
                          FROM kriteria 
                          LEFT JOIN normalisasi ON kriteria.id_kriteria = normalisasi.id_kriteria 
                          AND normalisasi.id_alternatif = (
                            SELECT id_alternatif 
                            FROM alternatif 
                            WHERE nama_alternatif = '{$rowAlternatif['alt']}' 
                            LIMIT 1
                          )";
                          
          $resultKriteria = $conn->query($sqlKriteria);
          while ($rowKriteria = $resultKriteria->fetch_assoc()) {
            $kriteriaId = $rowKriteria['krt'];
            $nilai = $rowKriteria['nilai'];
            $tipe = $rowKriteria['atribut'];

            // Hitung normalisasinya untuk kriteria saat ini berdasarkan tipe atributnya (cost atau benefit) dan bobotnya (nilai) 
            if ($tipe == 'cost' && $nilai != 0) {
              $normalisasi = $minValues[$kriteriaId] / $nilai;
            } elseif ($tipe == 'benefit' && $maxValues[$kriteriaId] != 0) {
              $normalisasi = $nilai / $maxValues[$kriteriaId];
            } else {
              $normalisasi = 0; // Handle division by zero
            }

            // Hitung nilai preferensi dengan mengalikan normalisasi dengan bobot kriteria
            $preferenceValue += $normalisasi * $criteriaWeights[$kriteriaId];
          }

          // Simpan nilai preferensi dalam array asosiatif
          $preferenceValues[$rowAlternatif['alt']] = $preferenceValue;
        }

        // cek jika $preferenceValues array tidak kosong
        if (!empty($preferenceValues)) {
          // Sort the preference values array in descending order
          arsort($preferenceValues);

            // Tampilkan baris tabel sesuai urutan
            foreach ($preferenceValues as $alternatif => $hasil) {
              // 3 digit setelah koma
            $hasil = round($hasil, 3);
                $pdf->Ln(0.8);
                $pdf->Cell(2,0.8,$no.".",1,0,'C');
                $pdf->Cell(9,0.8,$alternatif,1,0,'C');
                $pdf->Cell(6,0.8,$hasil,1,0,'C');
                $no++;
            }
        }

    $pdf->Output("hasil_metode_saw.pdf","I");
    exit;
?>
