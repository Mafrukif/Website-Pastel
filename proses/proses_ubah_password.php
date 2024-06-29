<?php
session_start();
include "connect.php";

// Ambil data dari form dengan sanitasi
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$passwordlama = isset($_POST['passwordlama']) ? md5(htmlentities($_POST['passwordlama'])) : "";
$passwordbaru = isset($_POST['passwordbaru']) ? md5(htmlentities($_POST['passwordbaru'])) : "";
$repasswordbaru = isset($_POST['repasswordbaru']) ? md5(htmlentities($_POST['repasswordbaru'])) : "";

// Enkripsi password
$passwordlama_md5 = md5($passwordlama);
$passwordbaru_md5 = md5($passwordbaru);
$repasswordbaru_md5 = md5($repasswordbaru);

if (!empty($_POST['ubah_password_validate'])) {
    // Cek password lama
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $_SESSION['username_pastel'], $passwordlama_md5);
    $stmt->execute();
    $result = $stmt->get_result();
    $hasil = $result->fetch_array();

    if ($hasil) {
        if ($passwordbaru_md5 === $repasswordbaru_md5) {
            // Update password baru
            $stmt = $conn->prepare("UPDATE tb_user SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $passwordbaru_md5, $_SESSION['username_pastel']);
            if ($stmt->execute()) {
                echo '<script>alert("Password berhasil diubah");
                      window.history.back();</script>';
            } else {
                echo '<script>alert("Password gagal diubah");
                      window.history.back();</script>';
            }
        } else {
            echo '<script>alert("Password baru tidak sama");
                  window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Password lama tidak sesuai");
              window.history.back();</script>';
    }
} else {
    header('Location: ../home');
    exit();
}
?>
