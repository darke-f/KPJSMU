<?php
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

    $sql = "SELECT * FROM $tablename";
    $res = $conn->query($sql);

    While($row = $res->fetch_assoc()) {
        $query = "INSERT INTO $newtablename (kodeBarang,namaBarang,satuanBarang,saldoAwal,saldoAkhir) VALUES ('$row[kodeBarang]','$row[namaBarang]','$row[satuanBarang]',$row[saldoAkhir],$row[saldoAkhir])";
        if(!$conn->query($query)) {
            echo "Pemindahan Data gagal";
        }
    }

?>