<?php
    session_start();
if (empty($_SESSION['email']) or empty($_SESSION['level'])) {
    echo "<script>alert('Maaf, untuk mengakses halaman ini, anda harus login terlebih dahulu, terima kasih');document.location='index.php'</script>";
    }
    include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Create Login Limits PHP Script</title>
</head>
<body style="background: #ff0058">
    <div class="wrapper">
        <?php
            $sql = "SELECT * FROM users WHERE email='{$_SESSION["email"]}'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
        ?>
        <h2>Welcome, <?php echo $row["name"]; ?> </span></h2>
        <h2>Sebagai, <?php echo $row["level"]; ?> <span class="form"><p><a href="logout.php">Logout</a></p></span></h2>
        <?php } ?>
    </div>
</body>
</html>