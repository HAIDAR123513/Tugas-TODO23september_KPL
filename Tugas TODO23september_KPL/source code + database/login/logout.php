<?php
    session_start();
    session_unset();
    session_destroy();

    setcookie('id', '', time()-3700);
    setcookie('key', '', time()-3700);

    header("Location: index.php");
?>