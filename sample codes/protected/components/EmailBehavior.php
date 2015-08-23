<?php
/**
 * EmailBehavior class file
 *
 * @author Gayan
 * @copyright Copyright&copy; 2011 SoNET Systems
 */

/**
 * Used to send emails
 *
 * @package am.admin.component
 */

class EmailBehavior extends CBehavior {
   public $lastError;

   public function sendEmail($email, $subject, $content, $fromAddress = null, $mailReply = null) {
      $this->lastError = null;

      try {
         $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
         $mailerSettings = Yii::app()->params['mailer'];
         $mailer->IsSMTP();
         $mailer->IsHTML();
         $mailer->SMTPAuth = $mailerSettings['smtp_auth'];
         $mailer->Host = $mailerSettings['mail_host'];
         $mailer->Port = $mailerSettings['port'];
         $mailer->From = $fromAddress === null ? $mailerSettings['mail_from'] : $fromAddress;
         $mailer->Username = $mailerSettings['smtp_username'];
         $mailer->Password = $mailerSettings['smtp_password'];
         $mailer->FromName = $mailerSettings['from_name'];
         $mailer->CharSet = 'UTF-8';
         $mailer->Subject = $subject;
         $mailer->AddReplyTo($mailReply === null ? $mailerSettings['mail_reply'] : $mailReply);
         $mailer->AddAddress($email);
         $mailer->Body = $content;

         if (!$mailer->Send()) {
            $this->lastError = 'Error sending email.';
            return false;
         }
      } catch (Exception $ex) {
         $this->lastError = 'Error sending email (response - '.$ex->getMessage().')';
         return false;
      }
      return true;
   }

   public function emailLastError() {
      return $this->lastError;
   }
}