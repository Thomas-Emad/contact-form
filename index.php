<?php
// Creating Array For Errors
$errors_form = ['username' => false, 'email' => false, 'cell' => false, 'msg' => false];
$send_mail = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Global Variables
  $user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $cell = filter_var($_POST['cellphone'], FILTER_SANITIZE_NUMBER_INT);
  $msg = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  // Contations
  if (strlen($user) < 3) {
    $errors_form['username'] = True;
    $send_mail = false;
  }
  if (strlen($msg) < 10) {
    $errors_form['msg'] = True;
    $send_mail = false;
  }
  if (filter_var($email, FILTER_VALIDATE_EMAIL) == False) {
    $errors_form['email'] = True;
    $send_mail = false;
  }

  if ($send_mail == true) {
    include 'phpmailer.php';
    //Content
    $mail->Subject = 'Contact Form';
    $mail->Body = "
      <h1 style='text-align:center;'>Contact Form</h1>
      <h2>Information</h2>
      <p><b>Email:</b> $email</p>
      <p><b>Name:</b> $user</p>
      <p><b>Number Phone:</b> $cell</p>
      <h2 style='text-align:center;'>Message</h2>
      <p>$msg</p>";
    $mail->send();

    $user = '';
    $email = '';
    $cell = '';
    $msg = '';
    $good_send = 'Send Email';
    // header("Location: " . __FILE__);
    // exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/all.min.css" />
</head>

<body>
  <div class="container">
    <form action="" method="POST">
      <h1>Contact Form</h1>
      <?php if (isset($good_send)) {
        echo "<div class='good_send'>$good_send</div>";
      } ?>
      <div class="group">
        <input type="text" name="username" placeholder="Write Your Name" value="<?php if (isset($user)) echo $user; ?>" />
        <i class="fa-solid fa-user"></i>
        <span class="sh">*</span>
        <?php
        if ($errors_form['username'] == True) {
          echo '<p class="error">- Username Must Be Larger Than 3 Characters.</p>';
        }
        ?>
      </div>
      <div class="group">
        <input type="text" name="email" placeholder="Write Your email" value="<?php if (isset($email)) echo $email; ?>" />
        <i class="fa-solid fa-envelope"></i>
        <span class="sh">*</span>
        <?php
        if ($errors_form['email'] == True) {
          echo '<p class="error">- You Need Write Good Email.</p>';
        }
        ?>
      </div>
      <div class="group">
        <input type="text" name="cellphone" placeholder="Write Your Cell Phone" value="<?php if (isset($cell)) echo $cell; ?>" />
        <i class="fa-solid fa-phone"></i>
      </div>
      <div class="group">
        <textarea name="message" placeholder="Write Your Message"><?php if (isset($msg)) echo $msg; ?></textarea>
        <i class="fa-solid fa-message message"></i>
        <span class="sh">*</span>
        <?php
        if ($errors_form['msg'] == True) {
          echo '<p class="error">- Message Can\'t Send Befour Write Larger Than (10) Letters.</p>';
        }
        ?>
      </div>
      <input type="submit" value="Send Your Message" />
    </form>
  </div>
</body>

</html>