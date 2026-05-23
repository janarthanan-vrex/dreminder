<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email',
            'phone' => 'nullable|numeric|digits_between:5,10',
            'subject'    => 'required|string|max:200',
            'message'    => 'required|string|min:10',
        ]);

        Mail::send(
            'emails.contact',
            ['data' => $validated],
            function ($mail) use ($validated) {

                $mail->to('jana2407@yopmail.com')
                    ->subject($validated['subject']);
            }
        );

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully'
        ]);
    }

}
