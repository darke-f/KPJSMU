<?php  
	$db = mysqli_connect("localhost", "root", "", "inventory");

	if(isset($_POST['upload'])) {
		$name_txt = mysqli_real_escape_string($db, $_POST['name_txt']);
		// $query = mysqli_query($db,"CALL calc('$name_txt')");
		$sql = "CALL cekBarangBeli('$name_txt')";
		$query = $db->query($sql) or die($db->error);
		$row = $query->fetch_row();
		// echo $row[0];
		if($row[0]==0) {
			while(mysqli_next_result($db)); //always use before query
			$query2 = $db->query("SELECT kodeBarang FROM masterbarang ORDER BY kodeBarang DESC LIMIT 1") or die($db->error);
			$row2 = $query2->fetch_assoc();
			// echo "kterakhir: ".$row2['kodeBarang'].", ";
			$kdepan = substr($row2['kodeBarang'], 0, -4);
			$kbelakang = substr($row2['kodeBarang'], -4);
			// echo $kdepan.",".$kbelakang;
			$num = (int) $kbelakang;
			$num = $num + 1;
			$num = sprintf('%04d',$num);
			$kbaru = $kdepan . $num;
			echo "kbaru: ".$kbaru;


			$satuan_txt = mysqli_real_escape_string($db, $_POST['satuan_txt']);
			// echo "satuan: ".$name_txt.$satuan_txt;
			while(mysqli_next_result($db)); //always use before query
			$query3 = $db->query("INSERT INTO masterbarang (kodeBarang, namaBarang, satuanBarang) values ('$kbaru', '$name_txt', '$satuan_txt')") or die($db->error);
			echo "Data barang belum pernah ada. Sukses menambahkan data";
		}

	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>form pembelian</title>
</head>
<body>

	<?php 
		$db = mysqli_connect("localhost", "root", "", "inventory");
		
	 ?>

	 <form method="POST" action>
	 	<div>
	 		<p>nama Barang:</p>
	 		<textarea
	 			rows="1" 
	 			cols="40" 
	 			name="name_txt" 
	 			placeholder="nama barang"
	 		></textarea>
	 	</div>
	 	<div>
	 		<p>satuan Barang:</p>
	 		<textarea
	 			rows="1" 
	 			cols="20" 
	 			name="satuan_txt" 
	 			placeholder="satuan barang"
	 		></textarea>
	 	</div>
	 	<button type="submit" name="upload">submit</button>
	 </form>

</body>
</html>