<?php
include 'header.php';

$result = mysqli_query($conn, "SELECT * FROM produk");

// Create XMLWriter object
$xml = new XMLWriter();
$xml->openURI("master_produk.xml");
$xml->startDocument();
$xml->setIndent(true);

// Start root element
$xml->startElement('products');

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    // Start product element
    $xml->startElement('product');

    // Write product details as sub-elements
    $xml->writeElement('no', $no);
    $xml->writeElement('kode_produk', $row['kode_produk']);
    $xml->writeElement('nama', $row['nama']);
    $xml->writeElement('image', $row['image']);
    $xml->writeElement('harga', 'Rp.' . number_format($row['harga']));

    // End product element
    $xml->endElement();
    $no++;
}

// End root element
$xml->endElement();

$xml->endDocument();
$xml->flush();

echo '<div class="container">';
echo '<h2 style="width: 100%; border-bottom: 4px solid gray"><b>Master Produk</b></h2>';

// Display table
echo '<table class="table table-striped">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">No</th>';
echo '<th scope="col">Kode Produk</th>';
echo '<th scope="col">Nama Produk</th>';
echo '<th scope="col">Image</th>';
echo '<th scope="col">Harga</th>';
echo '<th scope="col">Action</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$no = 1;
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $no . '</td>';
    echo '<td>' . $row['kode_produk'] . '</td>';
    echo '<td>' . $row['nama'] . '</td>';
    echo '<td><img src="../image/produk/' . $row['image'] . '" width="100"></td>';
    echo '<td>Rp.' . number_format($row['harga']) . '</td>';
    echo '<td><a href="edit_produk.php?kode=' . $row['kode_produk'] . '" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> </a> <a href="proses/del_produk.php?kode=' . $row['kode_produk'] . '" class="btn btn-danger" onclick="return confirm(\'Yakin Ingin Menghapus Data ?\')"><i class="glyphicon glyphicon-trash"></i> </a> <a href="bom.php?kode=' . $row['kode_produk'] . '" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i> Lihat BOM</a></td>';
    echo '</tr>';
    $no++;
}

echo '</tbody>';
echo '</table>';

echo '<a href="tm_produk.php" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Produk</a>';
echo '</div>';

echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';

echo '<a href="master_produk.xml" class="btn btn-primary" target="_blank">Unduh Tabel XML</a>';

include 'footer.php';
?>
