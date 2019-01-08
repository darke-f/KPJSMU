<?php
    require_once 'connect.php';

    $sql = "SELECT * FROM tutup_bulan";
    $res = $conn->query($sql);

    if($row = $res->fetch_assoc()) {
        $date = new DateTime ($row['current']);
    }

    $monthdate = $date->format('MY');
    $tablename = "stokbarang_$monthdate";

    $sql = "UPDATE $tablename SET pemasukan = 0";
    $conn->query($sql);
    $sql = "UPDATE $tablename SET pengeluaran = 0";
    $conn->query($sql);

    $sql = "SELECT mb.kodeBarang, mb.namaBarang, mb.satuanBarang, SUM(b.quantity) AS jumlah_beli FROM belihdr JOIN belidtl b ON (belihdr.noTransaksiBeli=b.noTransaksiBeli) JOIN masterbarang mb ON (b.kodeBarang = mb.kodeBarang) WHERE DATE_FORMAT(belihdr.tanggalTransaksiBeli, '%b%Y') = '$monthdate' GROUP BY mb.kodeBarang";
    $res = $conn->query($sql);

    While($row = $res->fetch_assoc()) {
        $query = "INSERT INTO $tablename (kodeBarang,namaBarang,satuanBarang,pemasukan) VALUES ('$row[kodeBarang]','$row[namaBarang]','$row[satuanBarang]',$row[jumlah_beli]) ON DUPLICATE KEY UPDATE pemasukan = pemasukan + $row[jumlah_beli]";
        if(!$conn->query($query)) {
            echo "Pemindahan Data gagal";
        }
        else {
            echo "success";
        }
    }

    $sql = "SELECT mb.kodeBarang, mb.namaBarang, mb.satuanBarang, SUM(j.quantity) AS jumlah_jual FROM jualhdr JOIN jualdtl j ON (jualhdr.noTransaksiJual=j.noTransaksiJual) JOIN masterbarang mb ON (j.kodeBarang = mb.kodeBarang) WHERE DATE_FORMAT(jualhdr.tanggalTransaksiJual, '%b%Y') = '$monthdate' GROUP BY mb.kodeBarang";
    $res = $conn->query($sql);

    While($row = $res->fetch_assoc()) {
        $query = "INSERT INTO $tablename (kodeBarang,namaBarang,satuanBarang,pengeluaran) VALUES ('$row[kodeBarang]','$row[namaBarang]','$row[satuanBarang]',$row[jumlah_jual]) ON DUPLICATE KEY UPDATE pengeluaran = pengeluaran + $row[jumlah_jual]";
        if(!$conn->query($query)) {
            echo "Pemindahan Data gagal";
        }
        else {
            echo "success";
        }
    }

    $sql = "UPDATE $tablename SET saldoAkhir = saldoAwal + pemasukan - pengeluaran";
    $conn->query($sql);

?>