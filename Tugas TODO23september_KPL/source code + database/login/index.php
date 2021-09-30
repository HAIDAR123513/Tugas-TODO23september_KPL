<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    include 'config.php';
     session_start();
    if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        $query = mysqli_query($conn, "SELECT name,email,level FROM users WHERE id = $id");
        $row = mysqli_fetch_assoc($query);
        if ($key === md5($row['name'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['level'] = $row['level'];
           if ($row['level'] == "Admin") {
                    header('location:welcome_Admin.php');
                } elseif ($row['level'] == "Staff") {
                    header('location:welcome_Staff.php');
                } elseif ($row['level'] == "Member") {
                    header('location:welcome.php');
                } 


        } 
        


    }

    if (isset($_POST["login"])) {
        include 'config.php';
        
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
        $level = mysqli_escape_string($conn, $_POST['level']);
        $tgl = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM users WHERE email='{$email}' AND level='{$level}'";
        $result = mysqli_query($conn, $sql);
        $user_valid = mysqli_fetch_array($result);

        //uji jika username terdaftar
        if ($user_valid) {
            //jika username terdaftar
            //cek password sesuai atau tidak
            if ($password == $user_valid['password']) {
                 if($user_valid['is_verified']==1){
                    if (isset($_POST['remember'])) {
                        setcookie('id', $user_valid['id'], time()+3600);
                        setcookie('key', md5($user_valid['name']), time()+3600);

                    }
                mysqli_query($conn, "UPDATE users SET log='{$tgl}' WHERE email='{$email}'");

                //jika password sesuai
                //buat session
                $_SESSION['email'] = $user_valid['email'];
                $_SESSION['name'] = $user_valid['name'];
                $_SESSION['level'] = $user_valid['level'];

                //uji level user
                if ($level == "Admin") {
                    header('location:welcome_Admin.php');
                } elseif ($level == "Staff") {
                    header('location:welcome_Staff.php');
                } elseif ($level == "Member") {
                    header('location:welcome.php');
                } 
            } else {
                echo "<script>alert('Email belum terferivikasi!');document.location='index.php'</script>";
            }
            } else {
                echo "<script>alert('Maaf, Login Gagal, Password anda tidak sesuai!');document.location='index.php'</script>";
            }
        } else {
            echo "<script>alert('Maaf, Login Gagal, Username anda tidak terdaftar!');document.location='index.php'</script>";
        }
    }

     if (isset($_POST["submit"])) {
        include 'config.php';
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $sql = "SELECT name,email,password FROM users WHERE email='{$email}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)==1) {
             while($row=mysqli_fetch_array($result))
                {
                  $name=$row['name'];
                  $email=$row['email'];
                  $pass=$row['password'];
                }
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/OAuth.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/POP3.php';
            require 'PHPMailer/src/SMTP.php';
            //Create a new PHPMailer instance
        $mail = new PHPMailer;

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // SMTP::DEBUG_OFF = off (for production use)
        // SMTP::DEBUG_CLIENT = client messages
        // SMTP::DEBUG_SERVER = client and server messages
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption mechanism to use - STARTTLS or SMTPS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'oriszeoulus@gmail.com';

        //Password to use for SMTP authentication
        $mail->Password = 'z00mm00.';

        //Set who the message is to be sent from
        $mail->setFrom('oriszeoulus@gmail.com', 'Your website service');

        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress($email, $name);

        //Set the subject line
        $mail->Subject = 'Reset Password - login web';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $body = "Hi, ".$name."<br>Plase verif your reset password before login our website : <a href='http://localhost/login/proses/reset_pass.php?reset=$pass&key=$email'>$pass<a>";
        $mail->Body = $body;
        //Replace the plain text body with one created manually
        $mail->AltBody = 'Reset Password';

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;
        } else {
            echo "<script>alert('link verifikasi telah dikirim.');document.location='index.php'</script>";            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }


          
        } else { echo "<script> alert('Email anda tidak terdaftar di sistem');document.location = 'index.php'; </script>";}
        

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body style="background: #ffa100">
    <div class="wrapper">
        <h2 class="title">Login</h2>
        <form action="" method="post" class="form">
            <div class="input-field">
                <label for="email" class="input-label">Email</label>
                <input type="email" name="email" id="email" class="input" placeholder="Masukkan email" required>
            </div>
            <div class="input-field">
                <label for="password" class="input-label">Password</label>
                <input type="password" name="password" id="password" class="input" placeholder="Masukkan password" required>
            </div>
            <div>
            <label for="email" class="input-label">User Option</label>
            <select class="form-select" aria-label="Default select example" name="level">
              <option selected>Plilih Level User</option>
              <option value="Admin">Admin</option>
              <option value="Member">Member</option>
              <option value="Staff">Staff</option>
            </select>
            </div>
             <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
              </div>
            <button class="btn" style="background: #ffa100" name="login">Login</button>
            <p>Buat Akun! <a href="register.php">Register</a>.</p>
             <p>Lupa password? <a href="#exampleModal" data-bs-toggle="modal">Reset Password</a>.</p>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
              <div class="modal-body">
                <div >
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Masukkan email yang terdaftar pada web</div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary">Reset</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
              </form>
            </div>
          </div>
        </div>
            </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>