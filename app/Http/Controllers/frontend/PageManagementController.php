<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Contactus;
class PageManagementController extends Controller
{

    public function privacyPolicy(Request $request)
	{

        try {

            $privacy=DB::table('pages')->where('type','privacy')->first();
            return view('frontend.pages.privacy-policy',compact('privacy'));
        } catch (\Exception$e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
	}

    public function termscondition(Request $request)
	{

        try {

            $terms=DB::table('pages')->where('type','terms')->first();
            return view('frontend.pages.terms-condition',compact('terms'));
        } catch (\Exception$e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
	}

    #------------------------------------------------------------------------------------------------------------------------------------------

    public function aboutus(Request $request)
	{

        try {

            $aboutus=DB::table('pages')->where('type','aboutus')->first();
            return view('frontend.pages.aboutus',compact('aboutus'));
        } catch (\Exception$e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
	}


    #-------------------------------------------------------------------------------------------------------------------------
    public function contactUS(Request $request)
    {
        try {
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


            return view('frontend.pages.contact', compact('sitenumber', 'siteemail', 'siteaddress','appName'));
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

        ContactUs::create([
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_message' => $request->contact_message,
        ]);

        return response()->json(['success' => 'Form submitted successfully!'], 200);
    }



    #-------------------------------------------------------------------------------------------------------------------------

}
