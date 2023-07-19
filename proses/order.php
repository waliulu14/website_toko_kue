<?php
include '../koneksi/koneksi.php';

$kd_cs = $_POST['kode_cs'];
$nama = $_POST['nama'];
$prov = $_POST['prov'];
$kota = $_POST['kota'];
$alamat = $_POST['almt'];
$kopos = $_POST['kopos'];
$tanggal = date('yy-m-d');

$kode = mysqli_query($conn, "SELECT invoice FROM produksi ORDER BY invoice DESC");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['invoice'], 3, 4);
$add = (int) $num + 1;

if (strlen($add) == 1) {
    $format = "INV000" . $add;
} elseif (strlen($add) == 2) {
    $format = "INV00" . $add;
} elseif (strlen($add) == 3) {
    $format = "INV0" . $add;
} else {
    $format = "INV" . $add;
}

$keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd_cs'");

// Create an XML element for the order data
$orderData = new SimpleXMLElement('<order></order>');
$orderData->addChild('invoice', $format);
$orderData->addChild('kode_customer', $kd_cs);
$orderData->addChild('nama', $nama);
$orderData->addChild('tanggal', $tanggal);
$orderData->addChild('provinsi', $prov);
$orderData->addChild('kota', $kota);
$orderData->addChild('alamat', $alamat);
$orderData->addChild('kode_pos', $kopos);

while ($row = mysqli_fetch_assoc($keranjang)) {
    $kd_produk = $row['kode_produk'];
    $nama_produk = $row['nama_produk'];
    $qty = $row['qty'];
    $harga = $row['harga'];
    $status = "Pesanan Baru";

    $order = mysqli_query($conn, "INSERT INTO produksi VALUES('', '$format', '$kd_cs', '$kd_produk', '$nama_produk', '$qty', '$harga', '$status', '$tanggal', '$prov', '$kota', '$alamat', '$kopos', '0', '0', '0')");

    // Create an XML element for each product in the order
    $product = $orderData->addChild('product');
    $product->addChild('kode_produk', $kd_produk);
    $product->addChild('nama_produk', $nama_produk);
    $product->addChild('quantity', $qty);
    $product->addChild('harga', $harga);
}

$del_keranjang = mysqli_query($conn, "DELETE FROM keranjang WHERE kode_customer = '$kd_cs'");

if ($del_keranjang) {
    // Convert SimpleXMLElement to XML string
    $xmlContent = $orderData->asXML();

    // Save XML content to a file named 'order.xml'
    $xmlFile = 'order.xml';
    file_put_contents($xmlFile, $xmlContent);

    header("location:../selesai.php");
}
?>
