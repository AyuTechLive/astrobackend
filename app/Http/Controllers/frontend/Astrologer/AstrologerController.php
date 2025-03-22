<?php

namespace App\Http\Controllers\frontend\Astrologer;

use App\Http\Controllers\Controller;
use App\Models\AstrologerCategory;
use App\Models\AdminModel\TravelCountry;
use App\Models\AdminModel\MainSourceOfBusiness;
use App\Models\AdminModel\HighestQualification;
use App\Models\AdminModel\DegreeOrDiploma;
use App\Models\AdminModel\FulltimeJob;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\AstrologerModel\AstrologerAvailability;
use App\Models\UserModel\UserDeviceDetail;
use Illuminate\Support\Str;
use App\Models\AdminModel\User;
use App\Models\AstrologerModel\Astrologer;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Session\Session;

class AstrologerController extends Controller
{
    public function AstrologerAccount()
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');


        $getAstrologer = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => astroauthcheck()['astrologerId']
        ])->json();
        $user= DB::table('users')->where('id','=', $getAstrologer['recordList'][0]['userId'])->first();


        $categories = AstrologerCategory::all();
        $skills = Skill::all();

        $languages = DB::table('languages')->get();
        $mainSourceBusiness = MainSourceOfBusiness::query()->get();
        $highestQualification = HighestQualification::query()->get();
        $qualifications = DegreeOrDiploma::query()->get();
        $jobs = FulltimeJob::query()->get();
        $countryTravel = TravelCountry::query()->get();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $appname = $getsystemflag->where('name', 'AppName')->first();

        return view('frontend.astrologers.pages.profileupdate',compact('getAstrologer','user','categories','skills','languages','mainSourceBusiness','highestQualification','qualifications','jobs','countryTravel','getsystemflag','appname'));
    }

    #---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function updateAstrologer(Request $request)
    {
        DB::beginTransaction();
        try {

            // dd($request->all());

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'contactNo' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'birthDate' => 'required',
                'dailyContribution' => 'required',
                'languageKnown' => 'required',
                'primarySkill' => 'required',
                'allSkill' => 'required',
                'interviewSuitableTime' => 'required',
                'mainSourceOfBusiness' => 'required',
                'minimumEarning' => 'required',
                'maximumEarning' => 'required',
                'NoofforeignCountriesTravel' => 'required',
                'currentlyworkingfulltimejob' => 'required',
                'goodQuality' => 'required',
                'biggestChallenge' => 'required',
                'whatwillDo' => 'required',
                'charge' => 'required',
                'whyOnBoard' => 'required',
                'highestQualification' => 'required',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (request('profileImage')) {
                // Encode the new profile image
                $profileImage = base64_encode(file_get_contents($request->file('profileImage')));
            } else {
                // No new profile image provided
                $profileImage = null;
            }

            if ($profileImage) {

                if (Str::contains($profileImage, 'storage')) {
                    $path = $profileImage;
                } else {
                    $time = Carbon::now()->timestamp;
                    $destinationPath = 'public/storage/images/';
                    $imageName = 'astrologer_' . $request->id . '_' . $time;
                    $path = $destinationPath . $imageName . '.png';

                    $isFile = explode('.', $path);
                    if (!(file_exists($path) && count($isFile) > 1)) {
                        file_put_contents($path, base64_decode($profileImage));
                    }

                    if (request('oldProfileImage')) {
                        $oldImagePath = request('oldProfileImage');
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
            } else {
                $path = request('oldProfileImage');
            }


            $user = User::find($request->userId);
            if ($user) {
                $user->name = $request->name;
                $user->contactNo = $request->contactNo;
                $user->email = $request->email;
                $user->birthDate = $request->birthDate;
                $user->profile = $path;
                $user->gender = $request->gender;
                $user->location = $request->currentCity;
                $user->countryCode = $request->countryCode;
                $user->update();
            }
            $astrologer = Astrologer::find($request->id);
            if ($astrologer) {
                $astrologer->name = $request->name;
                $astrologer->userId = $request->userId;
                $astrologer->email = $request->email;
                $astrologer->contactNo = $request->contactNo;
                $astrologer->gender = $request->gender;
                $astrologer->birthDate = $request->birthDate;
                $astrologer->primarySkill = implode(',', ($request->primarySkill));
                $astrologer->allSkill = implode(',', $request->allSkill);
                $astrologer->languageKnown = implode(',', $request->languageKnown);
                $astrologer->profileImage = $path;
                $astrologer->charge = $request->charge;
                $astrologer->experienceInYears = $request->experienceInYears;
                $astrologer->dailyContribution = $request->dailyContribution;
                $astrologer->hearAboutAstroguru = $request->hearAboutAstroguru;
                $astrologer->isWorkingOnAnotherPlatform = $request->isWorkingOnAnotherPlatform;
                $astrologer->whyOnBoard = $request->whyOnBoard;
                $astrologer->interviewSuitableTime = $request->interviewSuitableTime;
                $astrologer->currentCity = $request->currentCity;
                $astrologer->mainSourceOfBusiness = $request->mainSourceOfBusiness;
                $astrologer->highestQualification = $request->highestQualification;
                $astrologer->degree = $request->degree;
                $astrologer->college = $request->college;
                $astrologer->learnAstrology = $request->learnAstrology;
                $astrologer->astrologerCategoryId = implode(',', $request->astrologerCategoryId);
                $astrologer->instaProfileLink = $request->instaProfileLink;
                $astrologer->linkedInProfileLink = $request->linkedInProfileLink;
                $astrologer->facebookProfileLink = $request->facebookProfileLink;
                $astrologer->websiteProfileLink = $request->websiteProfileLink;
                $astrologer->youtubeChannelLink = $request->youtubeChannelLink;
                $astrologer->isAnyBodyRefer = $request->isAnyBodyRefer;
                $astrologer->minimumEarning = $request->minimumEarning;
                $astrologer->maximumEarning = $request->maximumEarning;
                $astrologer->loginBio = $request->loginBio;
                $astrologer->NoofforeignCountriesTravel = $request->NoofforeignCountriesTravel;
                $astrologer->currentlyworkingfulltimejob = $request->currentlyworkingfulltimejob;
                $astrologer->goodQuality = $request->goodQuality;
                $astrologer->biggestChallenge = $request->biggestChallenge;
                $astrologer->whatwillDo = $request->whatwillDo;
                $astrologer->videoCallRate = $request->videoCallRate;
                $astrologer->reportRate = $request->reportRate ? $request->reportRate : 0;
                $astrologer->nameofplateform = $request->nameofplateform;
                $astrologer->monthlyEarning = $request->monthlyEarning;
                $astrologer->referedPerson = $request->referedPerson;
                $astrologer->update();
                if ($request->userDeviceDetails) {
                    $userDeviceDetails = UserDeviceDetail::find($request->userId);
                    if ($userDeviceDetails) {

                        $userDeviceDetails->userId = $user->id;
                        $userDeviceDetails->appId = $request->appId;
                        $userDeviceDetails->deviceId = $request->deviceId;
                        $userDeviceDetails->fcmToken = $request->fcmToken;
                        $userDeviceDetails->deviceLocation = $request->deviceLocation;
                        $userDeviceDetails->deviceManufacturer = $request->deviceManufacturer;
                        $userDeviceDetails->deviceModel = $request->deviceModel;
                        $userDeviceDetails->appVersion = $request->appVersion;
                        $userDeviceDetails->update();
                    } else {
                        $userDeviceDetails = UserDeviceDetail::create([
                            'userId' => $request->userId,
                            'appId' => $request->appId,
                            'deviceId' => $request->deviceId,
                            'fcmToken' => $request->fcmToken,
                            'deviceLocation' => $request->deviceLocation,
                            'deviceManufacturer' => $request->deviceManufacturer,
                            'deviceModel' => $request->deviceModel,
                            'appVersion' => $request->appVersion,
                        ]);
                    }
                }
                if ($request->astrologerAvailability) {

                    $availability = DB::Table('astrologer_availabilities')
                        ->where('astrologerId', '=', $request->id)->delete();
                    $request->astrologerId = $astrologer->id;
                    foreach ($request->astrologerAvailability as $astrologeravailable) {
                        foreach ($astrologeravailable['time'] as $availability) {
                            AstrologerAvailability::create([
                                'astrologerId' => $request->id,
                                'day' => $astrologeravailable['day'],
                                'fromTime' => $availability['fromTime'],
                                'toTime' => $availability['toTime'],
                                'createdBy' => $astrologer['id'],
                                'modifiedBy' => $astrologer['id'],
                            ]);
                        }
                    }
                }
                $astrologer->astrologerAvailability = $request->astrologerAvailability;

                $astrologer->allSkill = array_map('intval', explode(',', $astrologer->allSkill));
                $astrologer->primarySkill = array_map('intval', explode(',', $astrologer->primarySkill));
                $astrologer->languageKnown = array_map('intval', explode(',', $astrologer->languageKnown));
                $astrologer->astrologerCategoryId =
                    array_map('intval', explode(',', $astrologer->astrologerCategoryId));
                $allSkill = DB::table('skills')
                    ->whereIn('id', $astrologer->allSkill)
                    ->select('name', 'id')
                    ->get();
                $primarySkill = DB::table('skills')
                    ->whereIn('id', $astrologer->primarySkill)
                    ->select('name', 'id')
                    ->get();
                $languageKnown = DB::table('languages')
                    ->whereIn('id', $astrologer->languageKnown)
                    ->select('languageName', 'id')
                    ->get();
                $catgory = DB::table('astrologer_categories')
                    ->whereIn('id', $astrologer->astrologerCategoryId)
                    ->select('name', 'id')
                    ->get();
                $astrologer->allSkill = $allSkill;
                $astrologer->primarySkill = $primarySkill;
                $astrologer->languageKnown = $languageKnown;
                $astrologer->astrologerCategoryId = $catgory;
                DB::commit();
                return redirect()->back()->with('success', 'Your Profile Update Successfully !');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    #-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    public function getAstrologerWallet(Request $request)
    {
        Artisan::call('cache:clear');
        if (!astroauthcheck())
            return redirect()->route('front.astrologerindex');
        $session = new Session();
        $token = $session->get('astrotoken');
        $getAstrologer = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => astroauthcheck()['astrologerId'],

        ])->json();
        $getProfile = Http::withoutVerifying()->post(url('/') . '/api/getProfile', [
            'token' => $token,
        ])->json();
        $withdrawlrequest = Http::withoutVerifying()->post(url('/') . '/api/withdrawlrequest/get', [
            'astrologerId' => astroauthcheck()['astrologerId']
        ])->json();

        // dd($withdrawlrequest);

        $withdrawMethod = DB::table('withdrawmethods')
        ->get();

        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        return view('frontend.astrologers.pages.astrologer-wallet', [
            'getAstrologer' => $getAstrologer,
            'getProfile' => $getProfile,
            'currency' => $currency,
            'withdrawMethod' => $withdrawMethod,
            'withdrawlrequest' => $withdrawlrequest,
        ]);
    }
    #--------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function AstrologerWalletRecharge(Request $request)
    {
        Artisan::call('cache:clear');
        if (!astroauthcheck())
            return redirect()->route('front.astrologerindex');
        $session = new Session();
        $token = $session->get('astrotoken');
        $getRechargeAmount = Http::withoutVerifying()->post(url('/') . '/api/getRechargeAmount')->json();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $gstvalue = $getsystemflag->where('name', 'Gst')->first();
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        $getamount = collect($getRechargeAmount['recordList']);
        $selectedamount = $getamount->first();
        $getProfile = Http::withoutVerifying()->post(url('/') . '/api/getProfile', [
            'token' => $token,
        ])->json();
        return view('frontend.astrologers.pages.astrologer-wallet-recharge', [
            'getRechargeAmount' => $getRechargeAmount,
            'gstvalue' => $gstvalue,
            'currency' => $currency,
            'selectedamount' => $selectedamount,
            'getProfile' => $getProfile,
        ]);
    }
    #----------------------------------------------------------------------------------------------------------------------------------------------------------
    public function getAstrologerChat(Request $request)
    {
        Artisan::call('cache:clear');
        if (!astroauthcheck())
            return redirect()->route('front.astrologerindex');
        $session = new Session();
        $token = $session->get('astrotoken');
        $getAstrologerChat = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => astroauthcheck()['astrologerId'],
            // 'astrologerId' => 102,
        ])->json();
        // dd($getAstrologerChat);
        $getProfile = Http::withoutVerifying()->post(url('/') . '/api/getProfile', [
            'token' => $token,
        ])->json();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        return view('frontend.astrologers.pages.astrologer-chats', [
            'getAstrologerChat' => $getAstrologerChat,
            'getProfile' => $getProfile,
            'currency' => $currency,
        ]);
    }
    #----------------------------------------------------------------------------------------------------------------------------------------------------------
    public function getAstrologerCall(Request $request)
    {
        Artisan::call('cache:clear');
        if (!astroauthcheck())
            return redirect()->route('front.astrologerindex');
        $session = new Session();
        $token = $session->get('astrotoken');
        $getAstrologerCall = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => astroauthcheck()['astrologerId'],
            // 'astrologerId' => 102,
        ])->json();
        $getProfile = Http::withoutVerifying()->post(url('/') . '/api/getProfile', [
            'token' => $token,
        ])->json();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        return view('frontend.astrologers.pages.astrologer-calls', [
            'getAstrologerCall' => $getAstrologerCall,
            'getProfile' => $getProfile,
            'currency' => $currency,
        ]);
    }
    #----------------------------------------------------------------------------------------------------------------------------------------------------------
    public function getAstrologerReport(Request $request)
    {
        Artisan::call('cache:clear');
        if (!astroauthcheck())
            return redirect()->route('front.astrologerindex');
        $session = new Session();
        $token = $session->get('astrotoken');
        $getAstrologerReport = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerById', [
            'astrologerId' => astroauthcheck()['astrologerId'],
            // 'astrologerId' => 104,
        ])->json();
        $getProfile = Http::withoutVerifying()->post(url('/') . '/api/getProfile', [
            'token' => $token,
        ])->json();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        return view('frontend.astrologers.pages.astrologer-reports', [
            'getAstrologerReport' => $getAstrologerReport,
            'getProfile' => $getProfile,
            'currency' => $currency,
        ]);
    }
    #--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function LiveAstrologers(Request $request)
    {
        Artisan::call('cache:clear');
        $liveAstrologer = DB::table('liveastro')
            ->join('astrologers', 'astrologers.id', '=', 'liveastro.astrologerId')
            ->where('liveastro.isActive', '=', true)
            ->select('astrologers.name', 'astrologers.profileImage', 'liveastro.*', 'astrologers.charge', 'astrologers.videoCallRate')
            ->orderBy('id', 'DESC')
            ->where('liveastro.astrologerId', astroauthcheck()['astrologerId'])
            ->first();
        if (!$liveAstrologer)
            return redirect()->route('front.astrologerindex');
        $wallet_amount = '';
        if (astroauthcheck())
            $wallet_amount = astroauthcheck()['totalWalletAmount'];
        $getGift = Http::withoutVerifying()->post(url('/') . '/api/getGift')->json();
        $agoraAppIdValue = DB::table('systemflag')
        ->where('name', 'AgoraAppId')
        ->select('value')
        ->first();
        $agorcertificateValue = DB::table('systemflag')
        ->where('name', 'AgoraAppCertificate')
        ->select('value')
        ->first();
        $RtmToken = Http::withoutVerifying()->post(url('/') . '/api/generateToken', [
            'appID' => $agoraAppIdValue->value,
            'appCertificate' => $agorcertificateValue->value,
            'user' => 'liveAstrologer_' . astroauthcheck()['id'],
            'channelName' =>$liveAstrologer->channelName
        ])->json();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        return view('frontend.astrologers.pages.live-astrologer', [
            'liveAstrologer' => $liveAstrologer,
            'wallet_amount' => $wallet_amount,
            'getGift' => $getGift,
            'agoraAppIdValue' => $agoraAppIdValue->value,
            'currency'=>$currency,
            'RtmToken'=>$RtmToken
        ]);
    }
}
