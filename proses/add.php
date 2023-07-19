<?php 
include '../koneksi/koneksi.php';

$hal = $_GET['hal'];
$kode_cs = $_GET['kd_cs'];
$kode_produk = $_GET['produk'];

if (isset($_GET['jml'])) {
	$qty = $_GET['jml'];
}

$result = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk = '$kode_produk'");
$row = mysqli_fetch_assoc($result);

$nama_produk = $row['nama'];
$kd = $row['kode_produk'];
$harga = $row['harga'];

if ($hal == 1) {
	$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_produk = '$kode_produk' AND kode_customer = '$kode_cs'");
	$jml = mysqli_num_rows($cek);
	$row1 = mysqli_fetch_assoc($cek);
	if ($jml > 0) {
		$set = $row1['qty'] + 1;
		$update = mysqli_query($conn, "UPDATE keranjang SET qty = '$set' WHERE kode_produk = '$kode_produk' AND kode_customer = '$kode_cs'");
		if ($update) {
			echo "
			<script>
			alert('BERHASIL DITAMBAHKAN KE KERANJANG');
			window.location = '../keranjang.php';
			</script>
			";
			die;
		}
	} else {
		$insert = mysqli_query($conn, "INSERT INTO keranjang VALUES('', '$kode_cs', '$kd', '$nama_produk', '1', '$harga')");
		if ($insert) {
			echo "
			<script>
			alert('BERHASIL DITAMBAHKAN KE KERANJANG');
			window.location = '../keranjang.php';
			</script>
			";
			die;
		}
	}
} else {
	$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_produk = '$kode_produk' AND kode_customer = '$kode_cs'");
	$jml = mysqli_num_rows($cek);
	$row1 = mysqli_fetch_assoc($cek);
	if ($jml > 0) {
		$set = $row1['qty'] + $qty;
		$update = mysqli_query($conn, "UPDATE keranjang SET qty = '$set' WHERE kode_produk = '$kode_produk' AND kode_customer = '$kode_cs'");
		if ($update) {
			echo "
			<script>
			alert('BERHASIL DITAMBAHKAN KE KERANJANG');
			window.location = '../detail_produk.php?produk=".$kode_produk."';
			</script>
			";
			die;
		}
	} else {
		$insert = mysqli_query($conn, "INSERT INTO keranjang VALUES('', '$kode_cs', '$kd', '$nama_produk', '$qty', '$harga')");
		if ($insert) {
			echo "
			<script>
			alert('BERHASIL DITAMBAHKAN KE KERANJANG');
			window.location = '../detail_produk.php?produk=".$kode_produk."';
			</script>
			";
			die;
		}
	}
}

// Create an XML element for the order data
$orderData = new SimpleXMLElement('<order></order>');
$orderData->addChild('kode_cs', $kode_cs);
$orderData->addChild('kode_produk', $kd);
$orderData->addChild('nama_produk', $nama_produk);
$orderData->addChild('quantity', $qty);
$orderData->addChild('harga', $harga);

// Convert SimpleXMLElement to XML string
$xmlContent = $orderData->asXML();

// Save XML content to a file named 'order.xml'
$xmlFile = 'order.xml';
file_put_contents($xmlFile, $xmlContent);
?>
