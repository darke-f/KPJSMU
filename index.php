<?php require_once 'connect.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <br>
	<a href="masterbarang.php"> master barang</a><br>
	<a href="mastercustomer.php"> master customer</a><br>
	<a href="mastersupplier.php"> master supplier</a><br>
	<a href="formbeli.php">form pembelian</a><br>
    <?php

        /*$sql = "UPDATE tutup_bulan SET current = '2019-01-01'";
        $res = $conn->query($sql);*/

        $sql = "SELECT * FROM tutup_bulan";
        $res = $conn->query($sql);

        if($row = $res->fetch_assoc()) {
            $date = new DateTime ($row['current']);
            $newdate = new DateTime ($row['current']);
            $newdate->modify('+1 month');
        }
        
        $date_string = $newdate->format('Y-m-d');
        //echo $date_string;
        $monthdate = $date->format('MY');
        $newmonthdate = $newdate->format('MY');
        //echo $result;

        $tablename = "stokbarang_$monthdate";
        $newtablename = "stokbarang_$newmonthdate";

       $sql = "CREATE TABLE $newtablename (kodeBarang char(6) NOT NULL PRIMARY KEY,
        namaBarang varchar(40) DEFAULT NULL,
        satuanBarang varchar(10) DEFAULT NULL,
        saldoAwal int(11) DEFAULT 0,
        pemasukan int(11) DEFAULT 0,
        pengeluaran int(11) DEFAULT 0,
        saldoAkhir int(11) DEFAULT 0,
        FOREIGN KEY (kodeBarang) REFERENCES masterbarang(kodeBarang) ON UPDATE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        if ($conn->query($sql) === TRUE) {
            echo "Table created successfully";
            $sql = "UPDATE tutup_bulan SET current = '$date_string' ";
            if ($conn->query($sql) === TRUE) {
                echo "SET Success";

                $sql = "SELECT * FROM $tablename";
                $res = $conn->query($sql);

                While($row = $res->fetch_assoc()) {
                    $query = "INSERT INTO $newtablename (kodeBarang,namaBarang,satuanBarang,saldoAwal,saldoAkhir) VALUES ('$row[kodeBarang]','$row[namaBarang]','$row[satuanBarang]',$row[saldoAkhir],$row[saldoAkhir])";
                    if(!$conn->query($query)) {
                        echo "Pemindahan Data gagal";
                    }
                }
            } else {
                echo "Error during update on tutup_bulan: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $conn->error;
        }

    ?>
</body>
</html>