<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Attachment;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendEmail(Request $request)
    {

        $this->validate($request, [
            'from' => 'required|email|max:255',
            'to' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'text_content' => 'required|max:1000',
            'html_content' => 'required|max:2000',
            'attachments.*.file' => 'nullable|max:10000|mimes:jpg,jpeg,png,gif,pdf,doc,docx'
        ]);

        $emailSent = false;

        try{
            Mail::send(new SendEmail($request->from, $request->to, $request->subject, $request->text_content));

            $email = Email::create([
                'from' => $request->from,
                'to' => $request->to,
                'subject' => $request->subject,
                'text_content' => $request->text_content,
                'html_content' => $request->html_content,
                'status' => 'sent'
            ]);

            if(!empty($request->attachments))
            {
                foreach($request->attachments as $attachment)
                {
                    $fileName = $attachment['file']->getClientOriginalName();

                    Storage::putFileAs('attachments', $attachment['file'], $fileName);

                    $attachment = Attachment::create([
                       'email_id' => $email->id,
                       'path' => 'attachments/' . $fileName
                    ]);
                }
            }

            $emailSent = true;

        }catch (\Exception $e)
        {
            Log::warning($e);

            $email = Email::create([
                'from' => $request->from,
                'to' => $request->to,
                'subject' => $request->subject,
                'text_content' => $request->text_content,
                'html_content' => $request->html_content,
                'status' => 'failed'
            ]);
        }

        return response()->json(['sent' => $emailSent], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmails()
    {

        $emails = Email::orderBy('id', 'desc')->get();

        return response()->json(['emails' => $emails], 200);
    }
}
