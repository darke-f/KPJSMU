<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php 

	$db = mysqli_connect("localhost", "root", "", "inventory");
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT * FROM masterbarang";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> id: ". $row["kodeBarang"]. " - Name: ". $row["namaBarang"]. " -  Satuan: " . $row["satuanBarang"] . " -  notes: " . $row["noteBarang"] . "<br>";
    }
} else {
    echo "0 results";
}

$db->close();

 ?>

</body>
</html>