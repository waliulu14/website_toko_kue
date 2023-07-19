<?php
include '../../koneksi/koneksi.php';
$kode = $_POST['kd_material'];
$nama = $_POST['nama'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$tanggal = date("y-m-d");

$result = mysqli_query($conn, "UPDATE inventory SET kode_bk = '$kode', nama='$nama', qty = '$stok', satuan='$satuan', harga='$harga',tanggal='$tanggal' where kode_bk = '$kode'");

if ($result) {
    echo "
    <script>
    alert('DATA BERHASIL DIUPDATE');
    window.location = '../inventory.php';
    </script>
    ";
}

// Create a new XML document
$dom = new DOMDocument('1.0');
$dom->formatOutput = true;

// Create the root element
$root = $dom->createElement('Updated_Inventory');
$dom->appendChild($root);

// Add the updated inventory details
$inventory = $dom->createElement('Inventory');
$root->appendChild($inventory);

$inventory->setAttribute('Kode_BK', $kode);
$inventory->setAttribute('Nama', $nama);
$inventory->setAttribute('Qty', $stok);
$inventory->setAttribute('Satuan', $satuan);
$inventory->setAttribute('Harga', $harga);
$inventory->setAttribute('Tanggal', $tanggal);

// Save the XML document
$xmlString = $dom->saveXML();
$dom->save('updated_inventory.xml');
?>
