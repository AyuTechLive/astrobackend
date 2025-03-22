<?php

namespace App\Http\Controllers\frontend\Astrologer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Session\Session;

class ChatController extends Controller
{
    public function astrologerchat(Request $request)
    {

        if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

        $chatrequest=DB::table('chatrequest')->where('userId',$request->partnerId)->where('id',$request->chatId)->first();


            $session = new Session();
            $token = $session->get('astrotoken');

        Artisan::call('cache:clear');



        $getUserNotification = Http::withoutVerifying()->post(url('/') . '/api/getUserNotification', [
            'token' => $token,
        ])->json();

        $getAstrologer = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => astroauthcheck()['astrologerId'],
        ])->json();

        $getUser = Http::withoutVerifying()->post(url('/') . '/api/getUserById', [
            'userId' => $request->partnerId,
        ])->json();



        return view('frontend.astrologers.pages.astrologer-chatpage', [
            'getAstrologer' => $getAstrologer,
            'chatrequest' => $chatrequest,
            'getUserNotification' => $getUserNotification,
            'getUser' => $getUser,
        ]);
    }

    public function chatStatus(Request $request)
    {
        $chatId = $request->query('chatId');
        $chat =DB::table('chatrequest')->where('id',$chatId)->first();
        return response()->json(['chatStatus' => $chat->chatStatus]);
    }
}
