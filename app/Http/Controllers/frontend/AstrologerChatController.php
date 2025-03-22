<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Session\Session;
use Carbon\Carbon;


class AstrologerChatController extends Controller
{
    public function chatList(Request $request)
    {
		$userId='';
		if(authcheck()){
		$userId=authcheck()['id'];
		}

        $session = new Session();
        $token = $session->get('token');

        Artisan::call('cache:clear');
        $sortBy = $request->sortBy;
        $astrologerCategoryId=(int)$request->astrologerCategoryId;
        $searchTerm = $request->input('s');

        $getAstrologer = Http::withoutVerifying()->post(url('/') . '/api/getAstrologer', ['sortBy' => $sortBy,'astrologerCategoryId'=>$astrologerCategoryId,'userId'=>$userId,'s' => $searchTerm])->json();

        $getAstrologerCategory = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerCategory')->json();

        $getIntakeForm = Http::withoutVerifying()->post(url('/') . '/api/chatRequest/getIntakeForm', [
            'token' => $token,
        ])->json();



        $isFreeChat = DB::table('systemflag')->where('name', 'FirstFreeChat')->select('value')->first();
        $isFreeAvailable=true;
        if ($isFreeChat->value == 1) {
            if ($userId) {
                $isChatRequest = DB::table('chatrequest')->where('userId', $userId)->where('chatStatus', '=', 'Completed')->first();
                $isCallRequest = DB::table('callrequest')->where('userId', $userId)->where('callStatus', '=', 'Completed')->first();
                if ($isChatRequest || $isCallRequest) {
                    $isFreeAvailable = false;
                } else {
                    $isFreeAvailable = true;
                }
            }
        } else {
            $isFreeAvailable = false;
        }

        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();



        return view('frontend.pages.astrologer-chat-list', [
            'getAstrologer' => $getAstrologer,
            'getAstrologerCategory' => $getAstrologerCategory,
            'sortBy' => $sortBy,
            'astrologerCategoryId' => $astrologerCategoryId,
            'getIntakeForm' => $getIntakeForm,
            'isFreeAvailable' => $isFreeAvailable,
            'searchTerm' => $searchTerm,
            'currency' => $currency,

        ]);
    }

    public function chat(Request $request)
    {

        if(!authcheck())
            return redirect()->route('front.home');

        $chatrequest=DB::table('chatrequest')->where('userId',authcheck()['id'])->where('id',$request->chatId)->first();

        if($chatrequest->chatStatus!='Confirmed')
            return redirect()->route('front.home');

            $session = new Session();
            $token = $session->get('token');

        Artisan::call('cache:clear');



        $getUserNotification = Http::withoutVerifying()->post(url('/') . '/api/getUserNotification', [
            'token' => $token,
        ])->json();

        $getAstrologer = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => $request->astrologerId,
        ])->json();


        return view('frontend.pages.chatpage', [
            'getAstrologer' => $getAstrologer,
            'chatrequest' => $chatrequest,
            'getUserNotification' => $getUserNotification,
        ]);
    }


    public function getMyChat(Request $request)
    {
        Artisan::call('cache:clear');

        if(!authcheck())
            return redirect()->route('front.home');

        $session = new Session();
        $token = $session->get('token');

        $getUserById = Http::withoutVerifying()->post(url('/') . '/api/getUserById',[
            'userId' => authcheck()['id'],
        ])->json();



        $getProfile = Http::withoutVerifying()->post(url('/') . '/api/getProfile',[
            'token' => $token,
        ])->json();


        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();

        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();



        return view('frontend.pages.my-chats', [
            'getUserById' => $getUserById,
            'getProfile' => $getProfile,
            'currency' => $currency,

        ]);
    }


    public function getChatHistory(Request $request)
    {

        if(!authcheck())
            return redirect()->route('front.home');


            $session = new Session();
            $token = $session->get('token');

        Artisan::call('cache:clear');


        $getUserNotification = Http::withoutVerifying()->post(url('/') . '/api/getUserNotification', [
            'token' => $token,
        ])->json();

        $getAstrologer = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => $request->astrologerId,
        ])->json();

        $getUserHistoryReview = Http::withoutVerifying()->post(url('/') . '/api/getUserHistoryReview', [
            'userId' => authcheck()['id'],
            'astrologerId' => $request->astrologerId,
        ])->json();




        return view('frontend.pages.chat-history', [
            'getAstrologer' => $getAstrologer,
            'getUserNotification' => $getUserNotification,
            'getUserHistoryReview' => $getUserHistoryReview,
        ]);
    }

    public function getDateTime(Request $request)
    {
        return Carbon::now()->format('Y-m-d H:i:s');
    }
}
