<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */


/**
 * send_email.
 *
 * @param string $subject    Subject
 * @param string $body       Message
 * @param string $attachment Attachment
 * @param mixed  $emailTo    Email to send to
 * @param array  $headers    Headers if any
 *
 * @return bool
 */
if (!function_exists('send_mail')) {

    function send_email($subject = null, $body = null, $attachment = null, $emailTo = null, $headers = [])
    {
        if (is_null($subject) || is_null($body) || is_null($emailTo)) return;

        $settings = service('settings');

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($settings->info->site_email, $settings->info->site_title);
        $email->setSubject($subject);
        $email->addTo($emailTo);
        $email->addContent("text/html", $body);

        if (!is_null($attachment)) {
            $email->addAttachment($attachment);
        }

        if ($headers) {
            foreach ($headers as $key => $value) {
                $email->addHeader($key, $value);
            }
        }

        $sendGrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        $response = $sendGrid->send($email);

        if ($response) {
            if (!is_null($attachment)) {
                unlink($attachment);
            }

            return true;
        }

        return false;
    }
}
