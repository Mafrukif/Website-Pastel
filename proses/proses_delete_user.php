<?php
include "connect.php";

$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";


$message = ""; // Inisialisasi variabel $message

if (!empty($_POST['input_user_validate'])) {
    $query = mysqli_query($conn, "DELETE FROM tb_user WHERE id = '$id'");
    if ($query) {
        $message = '<script>alert("Data berhasil dihapus");
                    window.location="../user"</script>';
    } else {
        $message = '<>alert("Data gagal dihapus");
        window.location="../user"</script>';
    }
}
echo $message;
?>
