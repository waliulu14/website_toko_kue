<?php
include 'header.php';

if(isset($_GET['cek'])){
    $cek = $_GET['cek'];
    mysqli_query($conn, "UPDATE produksi SET cek = '$cek'");
}

if(isset($_GET['page'])){
    $kode = $_GET['kode'];
    $result = mysqli_query($conn, "DELETE FROM inventory WHERE kode_bk = '$kode'");

    if($result){
        echo "
        <script>
        alert('DATA BERHASIL DIHAPUS');
        window.location = 'inventory.php';
        </script>
        ";
    }
}

$result = mysqli_query($conn, "SELECT * FROM inventory ORDER BY kode_bk ASC");

// Membuat file XML
$xml = new XMLWriter();
$xml->openURI("tabel_inventory.xml");
$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('table');

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $xml->startElement('row');

    $xml->writeElement('no', $no);
    $xml->writeElement('kode_bk', $row['kode_bk']);
    $xml->writeElement('nama', $row['nama']);
    $xml->writeElement('qty', $row['qty']);
    $xml->writeElement('satuan', $row['satuan']);
    $xml->writeElement('harga', number_format($row['harga']) . '/' . $row['satuan']);

    $xml->endElement();
    $no++;
}

$xml->endElement();
$xml->endDocument();
$xml->flush();

echo '<div class="container">';
echo '<h2 style="width: 100%; border-bottom: 4px solid gray"><b>Inventory Material</b></h2>';

// Menampilkan tabel HTML
echo '<table class="table table-striped">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">No</th>';
echo '<th scope="col">Kode Material</th>';
echo '<th scope="col">Nama</th>';
echo '<th scope="col">Stok</th>';
echo '<th scope="col">Satuan</th>';
echo '<th scope="col">Harga</th>';
echo '<th scope="col">Action</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$no = 1;
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<th scope="row">' . $no . '</th>';
    echo '<td>' . $row['kode_bk'] . '</td>';
    echo '<td>' . $row['nama'] . '</td>';
    echo '<td>' . $row['qty'] . '</td>';
    echo '<td>' . $row['satuan'] . '</td>';
    echo '<td>' . number_format($row['harga']) . '/' . $row['satuan'] . '</td>';
    echo '<td><a href="edit_inventory.php?kode=' . $row['kode_bk'] . '" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> </a> <a href="inventory.php?kode=' . $row['kode_bk'] . '&page=del" class="btn btn-danger" onclick="return confirm(\'Yakin Ingin Menghapus Data ?\')"><i class="glyphicon glyphicon-trash"></i> </a></td>';
    echo '</tr>';
    $no++;
}

echo '</tbody>';
echo '</table>';

echo '<a href="tm_inventory.php" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Material</a>';
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

echo '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';
echo '<div class="modal-header">';
echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
echo '<h4 class="modal-title" id="myModalLabel">Modal title</h4>';
echo '</div>';
echo '<div class="modal-body">';
echo '...';
echo '</div>';
echo '<div class="modal-footer">';
echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
echo '<button type="button" class="btn btn-primary">Save changes</button>';
echo '</div>';
echo '</div>';
echo '</div>';
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

echo '<a href="tabel_inventory.xml" class="btn btn-primary" target="_blank">Unduh Tabel XML</a>';

include 'footer.php';
?>
