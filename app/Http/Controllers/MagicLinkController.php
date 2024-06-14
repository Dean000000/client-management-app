<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MagicLinkController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();
        
        $token = Hash::make($user->email . now());

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => $token, 'created_at' => now()]
        );

        $link = url('/magic-link/' . urlencode($token) . '?email=' . urlencode($user->email));

        Mail::send('emails.magic-link', ['link' => $link], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Your Magic Login Link');
        });

        return back()->with('message', 'We have emailed your magic login link!');
    }

    public function login(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->query('email');

        $record = DB::table('password_resets')->where('email', $email)->first();

        if (!$record || !Hash::check($record->token, $token)) {
            return redirect('/login')->withErrors(['Invalid or expired magic link.']);
        }

        $user = DB::table('users')->where('email', $email)->first();

        Auth::loginUsingId($user->id);

        DB::table('password_resets')->where('email', $email)->delete();

        return redirect('/assets');
    }
}
