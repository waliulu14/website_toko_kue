<?php
include '../koneksi/koneksi.php';

$kode = mysqli_query($conn, "SELECT kode_customer FROM customer ORDER BY kode_customer DESC");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['kode_customer'], 1, 4);
$add = (int) $num + 1;

if (strlen($add) == 1) {
    $format = "C000" . $add;
} elseif (strlen($add) == 2) {
    $format = "C00" . $add;
} elseif (strlen($add) == 3) {
    $format = "C0" . $add;
} else {
    $format = "C" . $add;
}

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$tlp = $_POST['telp'];
$konfirmasi = $_POST['konfirmasi'];

$hash = password_hash($password, PASSWORD_DEFAULT);

if ($password == $konfirmasi) {
    $cek = mysqli_query($conn, "SELECT username FROM customer WHERE username = '$username'");
    $jml = mysqli_num_rows($cek);

    if ($jml == 1) {
        echo "
        <script>
        alert('USERNAME SUDAH DIGUNAKAN');
        window.location = '../register.php';
        </script>
        ";
        die;
    }

    $result = mysqli_query($conn, "INSERT INTO customer VALUES ('$format','$nama', '$email', '$username', '$hash', '$tlp')");

    if ($result) {
        // Create an XML element for the registration data
        $registration = new SimpleXMLElement('<registration></registration>');
        $registration->addChild('kode_customer', $format);
        $registration->addChild('nama', $nama);
        $registration->addChild('email', $email);
        $registration->addChild('username', $username);
        $registration->addChild('telepon', $tlp);

        // Convert SimpleXMLElement to XML string
        $xmlContent = $registration->asXML();

        // Save XML content to a file named 'registration.xml'
        $xmlFile = 'registration.xml';
        file_put_contents($xmlFile, $xmlContent);

        echo "
        <script>
        alert('REGISTER BERHASIL');
        window.location = '../user_login.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
    alert('KONFIRMASI PASSWORD TIDAK SAMA');
    window.location = '../register.php';
    </script>
    ";
}
?>
