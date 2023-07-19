<?php
include 'header.php';

// Create an XML document
$xml = new SimpleXMLElement('<produk></produk>');

$result = mysqli_query($conn, "SELECT * FROM produk");
while ($row = mysqli_fetch_assoc($result)) {
    // Add child element for each product
    $product = $xml->addChild('product');
    $product->addChild('nama', $row['nama']);
    $product->addChild('harga', $row['harga']);
    $product->addChild('deskripsi', $row['deskripsi']);
}

// Save the XML document to a file
$xmlFile = 'produk.xml';
$xml->asXML($xmlFile);

// Rest of your HTML code
?>

<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Produk Kami</b></h2>

    <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM produk");
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="image/produk/<?= $row['image']; ?>" >
                    <div class="caption">
                        <h3><?= $row['nama'];  ?></h3>
                        <h4>Rp.<?= number_format($row['harga']); ?></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="btn btn-warning btn-block">Detail</a> 
                            </div>
                            <?php if(isset($_SESSION['kd_cs'])){ ?>
                                <div class="col-md-6">
                                    <a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
                                </div>
                                <?php 
                            }
                            else{
                                ?>
                                <div class="col-md-6">
                                    <a href="keranjang.php" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
                                </div>

                                <?php 
                            }
                            ?>

                        </div>

                    </div>
                </div>
            </div>
            <?php 
        }
        ?>
    </div>

</div>

<?php 
include 'footer.php';
?>
