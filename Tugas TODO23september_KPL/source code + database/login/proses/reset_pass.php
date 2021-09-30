<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Login</title>
</head>
<body style="background: #b40b54">
    <div class="wrapper">
        <h2 class="title" style="border-left: 5px solid  #b40b54">Reset Password</h2>
        <?php
                if($_GET['key'] && $_GET['reset'])
                {
                include('../config.php');
                $email=$_GET['key'];
                $pass=$_GET['reset']; 
                
                $select=mysqli_query($conn, "SELECT email,password FROM users WHERE email='$email' AND password='$pass'");
                if(mysqli_num_rows($select)==1)
                {
                ?>
                <form action="" method="post" class="form">
                    <div class="input-field">
                        <label for="email" class="input-label">Masukkan Password baru</label>
                        <input type="password" name="password" id="password" class="input" placeholder="Masukkan password" required>
                    </div>
                    <div class="input-field">
                        <label for="cpassword" class="input-label">Konfirmasi Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="input" placeholder="Konfirmasi password" required>
                    </div>
                    <div>
                    </div>
                    <button class="btn" style="background: #b40b54" name="submit">submit</button>
                </form>
            </div>
         <?php
                  } else {
                      echo "Data Tidak Ditemukan";
                  }
                } else {
                  header('location:../index.php');
                }
                ?>
                <?php
        if(isset($_POST['submit']))
        {
          include('../config.php');
          $email=$_GET['key'];
          $pass=mysqli_real_escape_string($conn, md5($_POST["password"]));
          $cpassword = mysqli_real_escape_string($conn, md5($_POST["cpassword"]));
            if($pass === $cpassword){
                $select=mysqli_query($conn, "UPDATE users SET password='$pass' WHERE email='$email'");
                header('location:../index.php');
            }else{
            echo "<script>alert('terjadi kesalah coba ulangi ');</script>";
             }
        }
        ?>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>