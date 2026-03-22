<?php
/**
 * LAB: Brute Force Simulation (File-Based Shield)
 * Mekanisme: Atomic File Logging & Rate Limiting
 * Deskripsi: Implementasi pertahanan sisi server menggunakan validasi waktu 
 * berbasis file untuk memitigasi serangan otomatis (Botting) tanpa ketergantungan pada Database.
 */

// Konfigurasi Kredensial & Log
$pin_target = "812";
$log_file = "request_log.txt"; 

// Capturing current timestamp in microseconds for high precision
$now = microtime(true);

/**
 * LOGIKA PERTAHANAN: Time-Threshold Validation
 * Memvalidasi jeda waktu antar permintaan masuk.
 * Threshold: 0.2 detik (Batas kecepatan yang dianggap non-human/bot).
 */
if (file_exists($log_file)) {
    // Membaca timestamp permintaan terakhir dari storage
    $last_time = (float)file_get_contents($log_file);
    $selisih = $now - $last_time;

    // Deteksi Anomali: Jika request masuk di bawah ambang batas (Threshold)
    if ($selisih < 0.2) {
        // Update timestamp tetap dilakukan untuk menjaga state blokir jika bot terus menyerang
        file_put_contents($log_file, $now);
        
        // Response header 429: Standar HTTP untuk "Too Many Requests"
        header('HTTP/1.1 429 Too Many Requests');
        die("BERBAHAYA: Bot Terdeteksi! Kecepatan request tidak wajar: " . round($selisih, 4) . "s. Akses ditolak.");
    }
}

/**
 * PERSISTENCE:
 * Mencatat timestamp permintaan saat ini ke dalam file log.
 * Menggunakan file-based untuk menghindari delay sinkronisasi Session di localhost.
 */
file_put_contents($log_file, $now);

// Handler Autentikasi
if (isset($_POST['pin'])) {
    if ($_POST['pin'] === $pin_target) {
        // Output sukses untuk pengenalan pola (pattern recognition) oleh skrip audit Python
        echo "SUCCESS: Login Berhasil!";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Brute Force Lab - File Shield</title>
</head>
<body style="font-family: Arial; text-align: center; padding-top: 50px; background-color: #e8f4f8;">

    <div style="display: inline-block; background: white; padding: 20px; border: 1px solid #aaddee; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2>Sistem Login (File-Based Shield) ✅</h2>
        <p style="color: #555;">Proteksi Aktif: <strong>Atomic Time-Locking</strong></p>

        <form method="POST">
            <label>Masukkan PIN (3 Digit):</label><br><br>
            <input type="password" name="pin" maxlength="3" required 
                   style="padding: 10px; width: 80%; border: 1px solid #ccc; text-align: center; font-size: 1.2em;"><br><br>
            
            <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold;">
                Login Aman
            </button>
        </form>
    </div>

    <p style="margin-top: 20px;">
        <small>Mekanisme Pertahanan: <strong>Shared File State</strong> (Tanpa Database)</small>
    </p>
    <p><a href="vulnerable_login.php" style="color: #3498db; text-decoration: none;">&larr; Kembali ke Versi Vulnerable</a></p>

</body>
</html>