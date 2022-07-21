<?php
    $conn = mysqli_connect('localhost', 'root', '', 'db_lr');
    $verification_id = mysqli_real_escape_string($conn, $_GET['verification_id']);
    mysqli_query($conn, "update tabel_user set verification_status='1' where verification_id='$verification_id'");
?>
<script>
    window.location.href = 'login.php';
</script>