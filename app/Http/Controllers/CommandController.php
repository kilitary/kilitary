<?php

namespace App\Http\Controllers;

use App\XRandom;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class CommandController extends Controller
{
    public function sync(Request $request)
    {
        $list['rand'] = "<a href='/command/sync?/' style='font-size:11px;font-variant: small-caps;font-family: consolas'>" .
            (XRandom::sign(XRandom::get(0, 32))) .
            '</a>';
        $list['transaction/tx'] = \Str::orderedUuid();
        $list['transaction/rx'] = \Str::orderedUuid();

        foreach(hash_algos() as $algo) {
            $hash = hash($algo, $list['rand']);
            $list[$algo] = $hash . " <a target=_blank href='https://google.com/search?q=%2B" . substr($hash, 0, 7) . "'>[?]</a>" .
                " <a target=_blank href='https://google.com/search?q=related:" . substr($hash, 0, 6) . "'>[I]</a>" .
                " <a target=_blank href='https://google.com/search?q=inurl:" . substr($hash, 0, 7) . "'>[L]</a>" .
                " <a target=_blank href='https://google.com/search?q=" . substr($hash, 0, 6) . "'>[E]</a>" .
                " <a target=_blank href='https://google.com/search?q=site:github.com%20" . substr($hash, 0, 6) . "'>[C]</a>";

        }

        $pass = [
            '<font color=green class="blinking-green">pass</font>',
            '<font color=red class="blinking-red">fail</font>',
            '<font color=orange class="blinking-orange">middleware</font>'
        ];
        $list['check'] = $pass[XRandom::get(0, 2)];

        $anshlus = [
            '<font color=green class="blinking-green">allowed</font>',
            '<font color=red class="blinking-red">burnout</font>',
            '<font color=orange class="blinking-orange">disallowed</font>'
        ];
        $list['fastAnshlusAllowed'] = $anshlus[XRandom::get(0, 2)];

        return view('list', compact('list'));
    }

    public function play(Request $request)
    {
        $val = XRandom::getAu(26);
        $list['val'] = $val;

        return view('list', compact('list'));
    }

    public function command(Request $request, $command)
    {
        $ret = self::$command($request);

        return $ret;
    }

    public function mail(Request $request)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isMail();                                            // Send using SMTP
            //$mail->Host = 'smtp1.example.com';                    // Set the SMTP server to send through
            //$mail->SMTPAuth = true;                                   // Enable SMTP authentication
            //$mail->Username = 'user@example.com';                     // SMTP username
            //$mail->Password = 'secret';                               // SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            //$mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('root@kilitary.ru', 'Mailer');
            $mail->addAddress('deconf@ya.ru', 'Joe User');     // Add a recipient
            $mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $ret = $mail->send();
            return ['ok' => $ret];
        } catch(Exception $e) {
            return ['error' => $mail->ErrorInfo];
        }
    }
}

