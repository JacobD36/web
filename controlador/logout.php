<?php
    session_start();
    session_destroy();
    //header ('Location: ../index.php');
?>
<script type="text/javascript">
    location.assign("../index.php");
</script>