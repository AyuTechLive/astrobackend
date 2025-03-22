<?php
namespace App\Http\Controllers\frontend\Astrologer;
use App\Http\Controllers\Controller;
use App\Models\Contactus;
use App\Models\UserModel\Kundali;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Session\Session;
class HoroscopeController extends Controller
{
    public function getkundali(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        Artisan::call('cache:clear');
        $session = new Session();
        $token = $session->get('astrotoken');
        $getkundaliprice = Http::withoutVerifying()->post(url('/') . '/api/pdf/price', [
            'token' => $token,
        ])->json();
        $getkundali = Http::withoutVerifying()->post(url('/') . '/api/getkundali', [
            'token' => $token,
        ])->json();
        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
            // dd( $getkundaliprice);
        return view('frontend.astrologers.pages.kundali', [
            'getkundali' => $getkundali,
            'getkundaliprice' => $getkundaliprice,
            'currency' => $currency,
        ]);
    }
    public function kundaliMatch(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        return view('frontend.astrologers.pages.kundali-matching', [
        ]);
    }
    #------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function kundaliMatchReport(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        $KundaliMatching = Http::withoutVerifying()->post(url('/') . '/api/KundaliMatching/report', [
            'male_kundli_id' => $request->male_kundli_id,
            'female_kundli_id' => $request->female_kundli_id,
        ])->json();
        $kundalimale = Kundali::where('id', $request->male_kundli_id)->first();
        $kundalifemale = Kundali::where('id', $request->female_kundli_id)->first();
        // dd($kundalimale);
        return view('frontend.astrologers.pages.kundali-match-report', [
            'KundaliMatching' => $KundaliMatching,
            'kundalimale' => $kundalimale,
            'kundalifemale' => $kundalifemale,
        ]);
    }

    #------------------------------------------------------------------------------------------------------------------------------------------------------
    public function kundaliReport(Request $request)
    {
         $KundaliReport = Http::withoutVerifying()->post(url('/') . '/api/kundali/getKundaliReport', [
            'kundali_id' => $request->kundali_id,
        ])->json();
        // dd($KundaliReport);
        return view('frontend.astrologers.pages.kundali-report',compact('KundaliReport'));
    }
    #------------------------------------------------------------------------------------------------------------------------------------------------------
    public function getPanchang(Request $request)
    {
        if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

        Artisan::call('cache:clear');
        $panchangDate=$request->panchangDate?:Carbon::now();
        $getPanchang = Http::withoutVerifying()->post(url('/') . '/api/get/panchang', [
            'panchangDate' => $panchangDate,
        ])->json();
        return view('frontend.astrologers.pages.panchang', [
            'getPanchang' => $getPanchang,
        ]);
    }
    #--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function horoScope(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        Artisan::call('cache:clear');
        $gethoroscopesign = Http::withoutVerifying()->post(url('/') . '/api/getHororscopeSign')->json();
        return view('frontend.astrologers.pages.horoscopesign', [
            'gethoroscopesign' => $gethoroscopesign,
        ]);
    }
     #--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function dailyHoroscope(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        Artisan::call('cache:clear');
        $gethoroscopesign = Http::withoutVerifying()->post(url('/') . '/api/getHororscopeSign')->json();
        $horoscope = Http::withoutVerifying()->post(url('/') . '/api/getDailyHoroscope', [
            'horoscopeSignId' => $request->horoscopeSignId,
        ])->json();
        $signRcd = DB::table('hororscope_signs')->where('id', $request->horoscopeSignId)->get();
        return view('frontend.astrologers.pages.dailyhoroscope', [
            'horoscope' => $horoscope,
            'gethoroscopesign' => $gethoroscopesign,
            'signRcd' => $signRcd,
        ]);
    }
     #--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function aboutus(Request $request)
    {
        try {
            if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

            $aboutus=DB::table('pages')->where('type','aboutus')->first();
            return view('frontend.astrologers.pages.aboutus',compact('aboutus'));
        } catch (\Exception$e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
    #-------------------------------------------------------------------------------------------------------------------------
    public function privacyPolicy(Request $request)
    {
        try {
            if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

            $privacy=DB::table('pages')->where('type','privacy')->first();
            return view('frontend.astrologers.pages.privacy-policy',compact('privacy'));
        } catch (\Exception$e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
    #-------------------------------------------------------------------------------------------------------------------------
    public function termscondition(Request $request)
    {
        try {
            if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

            $terms=DB::table('pages')->where('type','terms')->first();
            return view('frontend.astrologers.pages.terms-condition',compact('terms'));
        } catch (\Exception$e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
    #--------------------------------------------------------------------------------------------------------------------------------------
    public function getBlog(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        Artisan::call('cache:clear');
        $getblog = Http::withoutVerifying()->post(url('/') . '/api/getBlog')->json();
        return view('frontend.astrologers.pages.blogs', [
            'getblog' => $getblog
        ]);
    }
     #--------------------------------------------------------------------------------------------------------------------------------------
    public function getBlogDetails(Request $request)
    {
        if(!astroauthcheck())
        return redirect()->route('front.astrologerlogin');

        Artisan::call('cache:clear');
        $getblogdetails = Http::withoutVerifying()->post(url('/') . '/api/getBlogById', [
            'id' => $request->id,])->json();
        return view('frontend.astrologers.pages.blog-details', [
            'getblogdetails' => $getblogdetails
        ]);
    }
    #------------------------------------------------------------------------------------------------------------------------------------------
    public function contactUS(Request $request)
    {
        try {
            if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

            $sitenumber = DB::table('systemflag')
                ->where('name', 'sitenumber')
                ->value('value');
            $siteemail = DB::table('systemflag')
                ->where('name', 'siteemail')
                ->value('value');
            $siteaddress = DB::table('systemflag')
                ->where('name', 'siteaddress')
                ->value('value');
                $appName = DB::table('systemflag')
            ->where('name', 'AppName')
            ->select('value')
            ->first();
            return view('frontend.astrologers.pages.contact', compact('sitenumber', 'siteemail', 'siteaddress','appName'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
    #-------------------------------------------------------------------------------------------------------------------------
    public function SavecontactUS(Request $request)
    {
        $request->validate([
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_message' => 'required',
        ]);
        Contactus::create([
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_message' => $request->contact_message,
        ]);
        return response()->json(['success' => 'Form submitted successfully!'], 200);
    }
    #-------------------------------------------------------------------------------------------------------------------------
    public function followerslist(Request $request)
    {
        if(!astroauthcheck())
            return redirect()->route('front.astrologerlogin');

            $astrologerId=astroauthcheck()['astrologerId'];
            $session = new Session();
            $token = $session->get('astrotoken');
            $getastrologerfollower = Http::withoutVerifying()->post(url('/') . '/api/getAstrologerFollower', [
                'token'=>$token,
                'astrologerId' => $astrologerId,
            ])->json();
            // dd($getastrologerfollower);
        return view('frontend.astrologers.pages.followers',compact('getastrologerfollower'));
    }
}
