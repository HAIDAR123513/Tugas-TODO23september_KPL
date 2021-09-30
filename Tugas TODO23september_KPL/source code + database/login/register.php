<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    session_start();
    if (isset($_POST["submit"])) {
        include 'config.php';

   
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/OAuth.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/POP3.php';
    require 'PHPMailer/src/SMTP.php';

        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
        $cpassword = mysqli_real_escape_string($conn, md5($_POST["cpassword"]));
        $level = mysqli_real_escape_string($conn, $_POST["level"]);
        $code = mysqli_real_escape_string($conn, md5($email.date('Y-m-d')));

       if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
                echo "<script>alert('{$email} - This email has already taken.');</script>";
            }else {
                if ($password === $cpassword) {
        $sql = "INSERT INTO users (name,email,password,level,verif_code)VALUES('$name','$email','$password','$level','$code')";
        $result = mysqli_query($conn,$sql);

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
        $mail->Subject = 'Verification Account - login web';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $body = "Hi, ".$name."<br>Plase verif your email before access our website : <br> http://localhost/login/proses/confirmEmail.php?code=".$code;
        $mail->Body = $body;
        //Replace the plain text body with one created manually
        $mail->AltBody = 'Verification Account';

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;
        } else {
            echo "<script>alert('Registrasi Berhasil silahkan verif dan login.');document.location='index.php'</script>";            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
                }else {
                    echo "<script>alert('Password and confirm password do not match.');</script>";
             }
         }
    }
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
<body style="background: #ffa100">
    <div class="wrapper">
        <h2 class="title">Register</h2>
        <form action="" method="post" class="form" >
            <div class="input-field">
                <label for="name" class="input-label">Full Name</label>
                <input type="name" name="name" id="name" class="input" placeholder="Enter your full name" required>
            </div>
            <div class="input-field">
                <label for="email" class="input-label">Email</label>
                <input type="email" name="email" id="email" class="input" placeholder="Enter your email" required>
            </div>
            <div class="input-field">
                <label for="password" class="input-label">Password</label>
                <input type="password" name="password" id="password" class="input" placeholder="Enter your password" required>
            </div>
            <div class="input-field">
                <label for="cpassword" class="input-label">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" class="input" placeholder="Enter your confirm password" required>
            </div>
            <div class="input-field">
                <label for="limit" class="input-label">User Option</label>
                <select id="limit" name="level" class="input" required>
                    <option value="" disabled selected>pilih level user</option>
                    <option value="Member">Member</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <button class="btn" style="background: #ffa100" name="submit">Register</button>
            <p>You have already an account! <a href="index.php">Login</a>.</p>
        </form>
    </div>
</body>
</html>