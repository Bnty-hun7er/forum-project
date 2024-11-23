<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// OAuth credentials
$CLIENT_ID = '97133365412-80jmdvl9ssrl0vp214f0b9fmrj7g9ptp.apps.googleusercontent.com';
$CLIENT_SECRET = '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';
$REDIRECT_URI = 'https://developers.google.com/oauthplayground';
$REFRESH_TOKEN = '1//04cZ1ofK1j3UICgYIARAAGAQSNwF-L9Ir9vMKLXrYKWUtcqcARa5rmNfoI5nB1SvcK9YkSs9_xp5uaT0Uptg8VpPNuTRkCIBhCaI';

function sendMail($recipientEmail, $subject, $message) {
    try {
        // OAuth2 Access Token generation
        $oAuth2Client = new \Google_Client();
        $oAuth2Client->setClientId($CLIENT_ID);
        $oAuth2Client->setClientSecret($CLIENT_SECRET);
        $oAuth2Client->setAccessType('offline');
        $oAuth2Client->setRedirectUri($REDIRECT_URI);
        $oAuth2Client->setAccessToken($REFRESH_TOKEN);

        $accessToken = $oAuth2Client->fetchAccessTokenWithRefreshToken($REFRESH_TOKEN);

        // PHPMailer Setup
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set up OAuth2 for Google SMTP
        $mail->AuthType = PHPMailer::AUTH_OAUTH;
        $mail->oauthUserEmail = 'mikeadhil2002@gmail.com';
        $mail->oauthClientId = $CLIENT_ID;
        $mail->oauthClientSecret = $CLIENT_SECRET;
        $mail->oauthRefreshToken = $REFRESH_TOKEN;
        $mail->oauthAccessToken = $accessToken['access_token'];

        // Email Details
        $mail->setFrom('mikeadhil2002@gmail.com', 'SUPER USER TESTER 😎');
        $mail->addAddress($recipientEmail); // Recipient
        $mail->Subject = $subject;
        $mail->Body    = $message; // Plain text body
        $mail->isHTML(true);
        $mail->AltBody = strip_tags($message); // For clients that don't support HTML

        // Send Email
        $mail->send();
        return "Email sent successfully";
    } catch (Exception $e) {
        return "Error: {$mail->ErrorInfo}";
    }
}

// Form handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientEmail = $_POST['recipientemail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $result = sendMail($recipientEmail, $subject, $message);
    echo $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <form method="POST" action="">
        <label for="recipientemail">Recipient Email:</label>
        <input type="email" name="recipientemail" id="recipientemail" required><br>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required><br>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea><br>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
