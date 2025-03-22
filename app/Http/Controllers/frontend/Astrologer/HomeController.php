<?php

namespace App\Http\Controllers\frontend\Astrologer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

        //  dd(astroauthcheck()['astrologerId']);
        $astrologerId=astroauthcheck()['astrologerId'];

        Artisan::call('cache:clear');

        $getChatRequest = Http::withoutVerifying()->post(url('/') . '/api/chatRequest/get', [
            'astrologerId' => $astrologerId,
        ])->json();


        $getCallRequest = Http::withoutVerifying()->post(url('/') . '/api/callRequest/get', [
            'astrologerId' => $astrologerId,
        ])->json();
        // dd($getCallRequest);
        $getUserReport = Http::withoutVerifying()->post(url('/') . '/api/getUserReport', [
            'astrologerId' => $astrologerId,
        ])->json();

        $agoraAppIdValue = DB::table('systemflag')
        ->where('name', 'AgoraAppId')
        ->select('value')
        ->first();

        $agorcertificateValue = DB::table('systemflag')
        ->where('name', 'AgoraAppCertificate')
        ->select('value')
        ->first();

        $channel_name='astrowayGuruLive_'.astroauthcheck()['astrologerId'].'';

        $getUserReportRequestById = Http::withoutVerifying()->post(url('/') . '/api/getUserReportRequestById', [
            'id' => $request->id,
        ])->json();

            // dd($getChatRequest);
        return view('frontend.astrologers.pages.index',compact('getChatRequest','getCallRequest','getUserReport','agoraAppIdValue','agorcertificateValue','channel_name','getUserReportRequestById'));
    }


    public function getChatRequests(Request $request)
{
    Artisan::call('cache:clear');
    $astrologerId = astroauthcheck()['astrologerId'];
    $getChatRequest = Http::withoutVerifying()->post(url('/') . '/api/chatRequest/get', [
        'astrologerId' => $astrologerId,
    ])->json();

    return response()->json($getChatRequest);
}

public function getCallRequests(Request $request)
{
    Artisan::call('cache:clear');
    $astrologerId = astroauthcheck()['astrologerId'];
    $getCallRequest = Http::withoutVerifying()->post(url('/') . '/api/callRequest/get', [
        'astrologerId' => $astrologerId,
    ])->json();

    return response()->json($getCallRequest);
}

public function getReportRequests(Request $request)
{
    Artisan::call('cache:clear');
    $astrologerId = astroauthcheck()['astrologerId'];
    $getUserReport = Http::withoutVerifying()->post(url('/') . '/api/getUserReport', [
        'astrologerId' => $astrologerId,
    ])->json();

    return response()->json($getUserReport);
}

}
