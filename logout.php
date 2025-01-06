<?php
session_start();
session_destroy();
?>
<script type="text/javascript">
    alert('Selamat, Anda Berhasil Logout.');
    location.href = "index.php";
</script>