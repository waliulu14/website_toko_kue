<?php 
include 'header.php';
$kd = mysqli_real_escape_string($conn, $_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);
?>

<div class="container" style="padding-bottom: 200px">
	<h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Checkout</b></h2>
	<div class="row">
		<div class="col-md-6">
			<h4>Daftar Pesanan</h4>
			<table class="table table-stripped">
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Harga</th>
					<th>Qty</th>
					<th>Sub Total</th>
				</tr>
				<?php 
				$result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");
				$no = 1;
				$hasil = 0;
				while($row = mysqli_fetch_assoc($result)){
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= $row['nama_produk']; ?></td>
						<td>Rp.<?= number_format($row['harga']); ?></td>
						<td><?= $row['qty']; ?></td>
						<td>Rp.<?= number_format($row['harga'] * $row['qty']);  ?></td>
					</tr>
					<?php 
					$total = $row['harga'] * $row['qty'];
					$hasil += $total;
					$no++;
				}
				?>
				<tr>
					<td colspan="5" style="text-align: right; font-weight: bold;">Grand Total = <?= number_format($hasil); ?></td>
				</tr>
			</table>
		</div>

	</div>
	<div class="row">
	<div class="col-md-6 bg-success">
		<h5>Pastikan Pesanan Anda Sudah Benar</h5>
	</div>
	</div>
	<br>
	<div class="row">
	<div class="col-md-6 bg-warning">
		<h5>isi Form dibawah ini </h5>
	</div>
	</div>
	<br>
	<form action="proses/order.php" method="POST">
		<input type="hidden" name="kode_cs" value="<?= $kd; ?>">
		<div class="form-group">
			<label for="exampleInputEmail1">Nama</label>
			<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama" name="nama" style="width: 557px;" value="<?= isset($rows['nama']) ? $rows['nama'] : ''; ?>" readonly>
			<!-- Use isset() to check if $rows['nama'] is defined before accessing its value -->
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Provinsi</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="prov" value="<?= isset($_POST['prov']) ? $_POST['prov'] : ''; ?>">
					<!-- Use isset() to check if $_POST['prov'] is defined before accessing its value -->
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Kota</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kota" name="kota" value="<?= isset($_POST['kota']) ? $_POST['kota'] : ''; ?>">
					<!-- Use isset() to check if $_POST['kota'] is defined before accessing its value -->
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Alamat</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Alamat" name="almt" value="<?= isset($_POST['almt']) ? $_POST['almt'] : ''; ?>">
					<!-- Use isset() to check if $_POST['almt'] is defined before accessing its value -->
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Kode Pos</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kode Pos" name="kopos" value="<?= isset($_POST['kopos']) ? $_POST['kopos'] : ''; ?>">
					<!-- Use isset() to check if $_POST['kopos'] is defined before accessing its value -->
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Order Sekarang</button>
		<a href="keranjang.php" class="btn btn-danger">Cancel</a>
	</form>
</div>

<?php 
include 'footer.php';
?>
