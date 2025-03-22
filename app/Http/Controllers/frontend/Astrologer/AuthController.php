<?php

namespace App\Http\Controllers\frontend\Astrologer;

use App\Http\Controllers\Controller;
use App\Models\AdminModel\DegreeOrDiploma;
use App\Models\AdminModel\FulltimeJob;
use App\Models\AdminModel\HighestQualification;
use App\Models\AdminModel\Language;
use App\Models\AdminModel\MainSourceOfBusiness;
use App\Models\AdminModel\TravelCountry;
use App\Models\AdminModel\User;
use App\Models\AstrologerCategory;
use App\Models\AstrologerModel\Astrologer;
use App\Models\AstrologerModel\AstrologerAvailability;
use App\Models\Skill;
use App\Models\UserModel\UserDeviceDetail;
use App\Models\UserModel\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Session\Session;


class AuthController extends Controller
{
    public function astrologerlogin()
    {

        if(astroauthcheck())
            return redirect()->route('front.astrologerindex');

        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);

        $otplessAppId = $getsystemflag->where('name', 'otplessAppId')->first();
        $logo = $getsystemflag->where('name', 'AdminLogo')->first();
        $appname = $getsystemflag->where('name', 'AppName')->first();

        return view('frontend.astrologers.pages.astrologers-login',compact('otplessAppId','logo','appname'));
    }


    public function validateOTLtoken($token)
    {
        $client_id = DB::table('systemflag')->where('name', 'otplessClientId')->select('value')->first();
        $secret_key = DB::table('systemflag')->where('name', 'otplessSecretKey')->select('value')->first();
         $curl = curl_init();

         curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://auth.otpless.app/auth/userInfo',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS => 'token='.$token.'&client_id='.$client_id->value.'&client_secret='.$secret_key->value.'',
         CURLOPT_HTTPHEADER => array(
             'Content-Type: application/x-www-form-urlencoded'
         ),
         ));

         $response = curl_exec($curl);

         curl_close($curl);
         return json_decode($response,true);
    }


    public function verifyOTLAstro(Request $request)
    {

       $verifiedData=$this->validateOTLtoken($request->otl_token);

       if($verifiedData['authentication_details']['phone']){

        $login = Http::withoutVerifying()->post(url('/') . '/api/loginAppAstrologer', [
            'contactNo' => $verifiedData['authentication_details']['phone']['phone_number'],
        ])->json();

        if($login['status']!=400){
            $session = new Session();
            $session->set('astrotoken',$login['token']);

            return redirect()->route('front.astrologerindex');
        }else{
            return redirect()->route('front.astrologerlogin', ['error' => $login['message']]);
        }


       }elseif($verifiedData['authentication_details']['email']){
            $login = Http::withoutVerifying()->post(url('/') . '/api/loginAppAstrologer', [
                'email' => $verifiedData['authentication_details']['email']['email'],
            ])->json();
            // dd($login);
            if($login['status']!=400){
                $session = new Session();
                $session->set('astrotoken',$login['token']);
                return redirect()->route('front.astrologerindex');
            }else{
                return redirect()->route('front.astrologerlogin', ['error' => $login['message']]);
            }

       }

    }

    // registration part
    public function astrologerregister()
    {
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

        return view('frontend.astrologers.pages.astrologers-registration',compact('categories','skills','languages','mainSourceBusiness','qualifications','jobs','countryTravel','highestQualification','appname'));
    }


    public function astrologerstore(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'contactNo' => 'required|unique:users,contactNo',
                'email' => 'required|unique:users,email',
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
                $profileImage = base64_encode(file_get_contents($request->file('profileImage')));
            }else {
                $profileImage = null;
            }
            if ($profileImage) {
                if (Str::contains($profileImage, 'storage')) {
                    $path = $profileImage;
                } else {
                    $time = Carbon::now()->timestamp;
                    $destinationpath = 'public/storage/images/';
                    $imageName = 'astrologer_' . $request->id . $time;
                    $path = $destinationpath . $imageName . '.png';
                    $isFile = explode('.', $path);
                    if (!(file_exists($path) && count($isFile) > 1)) {
                        file_put_contents($path, base64_decode($profileImage));
                    }
                }
            } else {
                $path = null;
            }

       // Create User
            $user = new User();
            $user->name = $request->name;
            $user->contactNo = $request->contactNo;
            $user->email = $request->email;
            $user->birthDate = $request->birthDate;
            $user->profile = $path;
            $user->gender = $request->gender;
            $user->location = $request->currentCity;
            $user->countryCode = $request->countryCode;
            $user->save();

            // Get the last inserted ID of the user
            $userId = $user->id;

             UserRole::create([
                 'userId' => $userId,
                 'roleId' => 2,
             ]);

            // Create Astrologer
            $astrologer = new Astrologer();
            $astrologer->name = $request->name;
            $astrologer->userId = $userId;
            $astrologer->email = $request->email;
            $astrologer->contactNo = $request->contactNo;
            $astrologer->gender = $request->gender;
            $astrologer->birthDate = $request->birthDate;
            $astrologer->primarySkill = implode(',', $request->primarySkill);
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
            $astrologer->reportRate = $request->reportRate;
            $astrologer->nameofplateform = $request->nameofplateform;
            $astrologer->monthlyEarning = $request->monthlyEarning;
            $astrologer->referedPerson = $request->referedPerson;
            $astrologer->save();

            $astroId = $astrologer->id;

            // Additional processing for availability if required

            if ($request->astrologerAvailability) {
                $availability = DB::Table('astrologer_availabilities')
                    ->where('astrologerId', '=', $request->id)->delete();
                foreach ($request->astrologerAvailability as $astrologeravailable) {
                    if (array_key_exists('time', $astrologeravailable)) {
                        foreach ($astrologeravailable['time'] as $availability) {
                            if ($availability['fromTime']) {
                                $availability['fromTime'] = Carbon::createFromFormat('H:i', $availability['fromTime'])->format('h:i A');
                            }
                            if ($availability['toTime']) {
                                $availability['toTime'] = Carbon::createFromFormat('H:i', $availability['toTime'])->format('h:i A');
                            }
                            AstrologerAvailability::create([
                                'astrologerId' => $astroId,
                                'day' => $astrologeravailable['day'],
                                'fromTime' => $availability['fromTime'],
                                'toTime' => $availability['toTime'],
                                'createdBy' => $astroId,
                                'modifiedBy' => $astroId,
                            ]);
                        }
                    }
                }
            }

            if ($request->userDeviceDetails) {
                UserDeviceDetail::create([
                    'userId' => $user->id,
                    'appId' => $request->appId,
                    'deviceId' => $request->deviceId,
                    'fcmToken' => $request->fcmToken,
                    'deviceLocation' => $request->deviceLocation,
                    'deviceManufacturer' => $request->deviceManufacturer,
                    'deviceModel' => $request->deviceModel,
                    'appVersion' => $request->appVersion,
                ]);
            }else{
                UserDeviceDetail::create([
                    'userId' => $user->id,
                    'appId' => 1,

                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Form Submitted Successfully ,You can login after verification');


        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerindex');
        $session = new Session();
        $token = $session->get('astrotoken');
        $logout = Http::withoutVerifying()->post(url('/') . '/api/logout', [
            'token' => $token,
        ])->json();
        $session = new Session();
        $session->remove('astrotoken');
        return response()->json([
            "message" => "Logout User Successfully",
        ], 200);
    }
}
