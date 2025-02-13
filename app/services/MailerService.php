<?php

namespace Services;

use Config\MailerConfig;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailerService
{
    protected PHPMailer $mail;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setupServer();
    }

    /**
     * @throws Exception
     */
    private function setupServer(): void
    {
        //Server settings
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host = MailerConfig::HOST;                           //Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                                     //Enable SMTP authentication
        $this->mail->Username = MailerConfig::USERNAME;                   //SMTP username
        $this->mail->Password = MailerConfig::PASSWORD;                   //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port = MailerConfig::PORT;                           //TCP port to connect to
        try {
            $this->mail->setFrom(MailerConfig::USERNAME, 'The Festival');
            $this->mail->addReplyTo(MailerConfig::USERNAME, 'Information');
        } catch (Exception $e) {
            throw new Exception("Message could not be sent. MailerService Error: {$e->getMessage()}");
        }
    }

    /**
     * @throws Exception
     */
    public function sendMail(
        string $to = "",
        string $toName = "",
        string $subject = "Unknown",
        string $body = "empty",
        ?array $attachment = null,
        string $altBody = ""
    ): void
    {
        try {
            //Recipients
            $this->mail->setFrom(MailerConfig::USERNAME, 'Haarlem Festival');
            $this->mail->addAddress($to, $toName);

            //Content
            $this->mail->isHTML();
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody;

            if ($attachment != null) {
                foreach ($attachment as $file) {
                    $this->mail->addAttachment($file);
                }
            }

            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Message could not be sent. Error: {$e->getMessage()}");
        }
    }
}
