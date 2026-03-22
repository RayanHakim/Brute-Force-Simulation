<?php
/**
 * LAB: Brute Force Simulation (Vulnerable Version)
 * Deskripsi: Halaman login sederhana tanpa batasan percobaan (Rate Limiting).
 * Tujuan: Demonstrasi kerentanan terhadap serangan kamus/brute force otomatis.
 */

// Konfigurasi Kredensial (Simulasi PIN 3 Digit)
$pin_target = "812"; 
$message = "Silakan Login";

// Handler autentikasi
if (isset($_POST['pin'])) {
    if ($_POST['pin'] === $pin_target) {
        // Response sukses untuk dideteksi oleh skrip audit (Python)
        echo "SUCCESS: Login Berhasil!"; 
        exit;
    } else {
        $message = "PIN Salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Brute Force Lab - Vulnerable</title>
</head>
<body style="font-family: Arial; text-align: center; padding-top: 50px; background-color: #fcf2f2;">

    <div style="display: inline-block; background: white; padding: 20px; border: 1px solid #ffcccc; border-radius: 8px;">
        <h2>Sistem Login (Vulnerable) ❌</h2>
        <p style="color: #555;"><?php echo $message; ?></p>

        <form method="POST">
            <label>Masukkan PIN (3 Digit):</label><br><br>
            <input type="password" name="pin" maxlength="3" required 
                   style="padding: 10px; width: 80%; border: 1px solid #ccc; text-align: center; font-size: 1.2em;"><br><br>
            
            <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;">
                Login ke Sistem
            </button>
        </form>
    </div>

    <p style="margin-top: 20px;"><a href="secure_login.php">Beralih ke Versi Terproteksi</a></p>

</body>
</html>