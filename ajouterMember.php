<?php
require('fpdf.php');
require('phpqrcode/qrlib.php');
class Connect{
    static $host='localhost';
    static $user='root';
    static $pw='';
    static $db='qrcode';
    public function selectdata($r){
        $cnx=new PDO("mysql:host=".self::$host.";dbname=".self::$db."",self::$user."",self::$pw);
        $e=$cnx->query($r);
        return $e;
    }
    public function updatedata($r){
        $cnx=new PDO("mysql:host=".self::$host.";dbname=".self::$db."",self::$user."",self::$pw);
        $e=$cnx->exec($r);
        return $e;
    }
}
class Contreleur{
    public function ajouter( $name, $phone, $email, $address){
        $c=new Connect();
        $e=$c->updatedata("INSERT INTO member (name, phone, email, address) VALUES ( '$name', $phone, '$email', '$address')");
        return $e;
    }
}
if(isset($_POST['btn'])) {
    // Form was submitted, process the data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $c = new Contreleur();
    $e = $c->ajouter($name, $phone, $email, $address);

    if($e){
        $pdf = new FPDF();
        $pdf->AddPage();

        // Add some text to the PDF
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Member Information:');
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Name: '.$name);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Phone: '.$phone);

        // Generate the QR code
        $qrData = $phone; // Member's phone number
        $qrFile = 'qrcode.png';
        $qrSize = 10;  // Adjust this value for larger size (default is 3)
        QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, $qrSize);

        // Add QR code to the PDF
        $pdf->Image($qrFile, 10, 50, 40, 40);

        // Force download the PDF
        $pdf->Output('D', 'member.pdf');

        // Optionally delete the temporary QR code image file
        unlink($qrFile);
    } else {
        echo "Error inserting member data.";
    }
}
?>

<html>
    <body>
    <form action="ajouterMember.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address"><br>

        <input type="submit" value="Add Member" id="btn" name="btn">
    </form>
    </body>
</html>
