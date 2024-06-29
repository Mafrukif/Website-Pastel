<?php
include "connect.php";

$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$foto = (isset($_POST['foto'])) ? htmlentities($_POST['foto']) : "";

$message = ""; // Initialize $message variable

if (!empty($_POST['input_user_validate'])) {
    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete related records from tb_list_order
        $query1 = mysqli_query($conn, "DELETE FROM tb_list_order WHERE menu = '$id'");
        
        // Delete the record from tb_daftar_menu
        $query2 = mysqli_query($conn, "DELETE FROM tb_daftar_menu WHERE id = '$id'");

        if ($query1 && $query2) {
            // Commit the transaction
            mysqli_commit($conn);
            
            // Remove the associated photo file
            unlink("../assets/img/$foto");

            $message = '<script>alert("Data berhasil dihapus"); window.location="../menu"</script>';
        } else {
            // Rollback the transaction in case of an error
            mysqli_rollback($conn);

            $message = '<script>alert("Data gagal dihapus"); window.location="../menu"</script>';
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of an exception
        mysqli_rollback($conn);

        $message = '<script>alert("Data gagal dihapus"); window.location="../menu"</script>';
    }
}

echo $message;
?>
