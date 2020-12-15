<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Attachment;
use App\Models\Email;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{

    public function emails()
    {
        return view('emails');
    }

    public function sendEmail()
    {
        return view('send-email');
    }

    public function viewEmail($id)
    {
        $email = Email::where('id', $id)->first();

        return (new SendEmail($email->from, $email->to, $email->subject, $email->html_content))->render();
    }


    public function viewRecipientEmails($email)
    {

        $emails = Email::where('to', $email)->orderBy('id', 'desc')->get();

        return view('recipient-emails')->with('emails', $emails)->with('email', $email);
    }

    public function viewAttachments($id)
    {

        $attachments = Attachment::where('email_id', $id)->get();

        return view('attachments')->with('attachments', $attachments);
    }

    public function downloadAttachment($id)
    {
        $attachment = Attachment::where('id', $id)->first();

        return Storage::download($attachment->path);
    }
}
