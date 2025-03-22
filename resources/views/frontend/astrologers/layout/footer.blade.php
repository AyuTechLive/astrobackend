<div class="astroway-footer">
    <div class="bg-brown footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-7 col-lg-9">
                    <div class="row">

                        <div class="col-6 col-md-3">
                            <h4 class="d-block text-white font-16 font-weight-semi-bold mb-3 "><a
                                    href="#"
                                    class="text-white text-decoration-none">Astrology</a> </h4>
                            <ul class="list-unstyled">
                            <li><a href="{{route('front.astrologers.getPanchang')}}"
                            class="font-14 color-pink-light">Today&#39;s Panchang</a></li>
                                <li><a href="{{ route('front.astrologers.kundaliMatch') }}"
                                        class="font-14 color-pink-light">Kundali Matching</a></li>
                                <li><a href="{{ route('front.astrologers.getkundali') }}"
                                        class="font-14 color-pink-light">Free Janam Kundali</a></li>
                            </ul>

                        </div>
                        <div class="col-6 col-md-3">

                            <h4 class="d-block text-white font-16 font-weight-semi-bold mb-3  "><a
                                    href="javascript::void(0);"
                                    class="text-white text-decoration-none">Horoscope </a></h4>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('front.astrologers.horoScope') }}"
                                        class="font-14 color-pink-light">Daily Horoscope</a></li>
                                <li><a href="{{ route('front.astrologers.horoScope') }}"
                                        class="font-14 color-pink-light">Weekly Horoscope</a></li>
                                <li><a href="{{ route('front.astrologers.horoScope') }}"
                                        class="font-14 color-pink-light">Yearly Horoscope</a></li>
                            </ul>

                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-white font-16 font-weight-semi-bold mb-3">Useful Links </h4>
                            <ul class="list-unstyled">
                                <li><a href="{{route('front.astrologers.aboutus')}}"
                                        class="font-14 color-pink-light" target="_blank"
                                        rel="nofollow noopener noreferrer">About Us </a></li>
                                <li><a href="{{route('front.astrologers.contact')}}"
                                        class="font-14 color-pink-light"
                                        rel="nofollow noopener noreferrer">Contact Us </a></li>
                                <li><a href="{{route('front.astrologers.getBlog')}}" class="font-14 color-pink-light"
                                      >Blog</a></li>
                            </ul>

                        </div>
                        <div class="col-6 col-md-3">
                        <h4 class="d-block text-white font-16 font-weight-semi-bold mb-3 ">Policy
                            </h4>
                            <ul class="list-unstyled">
                                <li><a href="{{route('front.astrologers.privacyPolicy')}}"
                                        class="font-14 color-pink-light"
                                        rel="nofollow noopener noreferrer">Privacy Policy</a></li>
                                <li><a href="{{route('front.astrologers.termscondition')}}"
                                        class="font-14 color-pink-light"
                                        rel="nofollow noopener noreferrer">Terms Of Use </a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 offset-md-1 offset-lg-0 pl-md-4">
                    <h4 class="text-white font-16 font-weight-semi-bold mb-4">Download Our Apps</h4>
                    <div class="d-flex d-md-block">
                        <div class="my-2"><a href="javascript:void(0);"
                                rel="nofollow noopener noreferrer"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/google-play.png')}}"
                                    alt="google-play" class="img-fluid" width="183" height="54"
                                    loading="lazy"></a></div>
                        <div class="my-2 ml-2 ml-md-0"><a href="javascript:void(0);"
                                rel="nofollow noopener noreferrer"><img
                                    src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/app-store.png')}}"

                                    alt="app-store" class="img-fluid" width="183" height="54"
                                    loading="lazy"></a></div>
                        <span class="float-none"></span>
                    </div>
                    @php
                        
                        $facebook = DB::table('systemflag')->where('name', 'Facebook')->select('value')->first();
                        $apple = DB::table('systemflag')->where('name', 'Apple')->select('value')->first();
                        $website = DB::table('systemflag')->where('name', 'Website')->select('value')->first();
                        $youtube = DB::table('systemflag')->where('name', 'Youtube')->select('value')->first();
                        $linkedIn = DB::table('systemflag')->where('name', 'LinkedIn')->select('value')->first();
                        $pintrest = DB::table('systemflag')->where('name', 'Pintrest')->select('value')->first();
                        $instagram = DB::table('systemflag')->where('name', 'Instagram')->select('value')->first();

                    @endphp
                     <div class="d-flex mt-2 flex-wrap">
                        <a class="mr-2 mt-2" target="_blank" href="{{$facebook->value}}"
                            rel="nofollow"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/fb.svg')}}"
                                alt="facebook" width="31" height="31" loading="lazy"></a>
                        <a class="mr-2 mt-2" target="_blank" href="#"
                            rel="nofollow"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/twitter.svg')}}"
                                alt="twitter" width="31" height="31" loading="lazy"></a>
                        <a class="mr-2 mt-2" target="_blank"
                            href="{{$linkedIn->value}}" rel="nofollow"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/linkedin.svg')}}"
                                alt="linkedin" width="31" height="31" loading="lazy"></a>
                        <a class="mr-2 mt-2" target="_blank"
                            href="{{$instagram->value}}" rel="nofollow"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/insta.svg')}}"
                                alt="instagram" width="31" height="31" loading="lazy"></a>
                        <a class="mr-2 mt-2" target="_blank"
                            href="{{$youtube->value}}"
                            rel="nofollow"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/youtube.svg')}}"
                                alt="youtube" width="31" height="31" loading="lazy"></a>
                        <a class="mr-2 mt-2" target="_blank" href="{{$pintrest->value}}"
                            rel="nofollow"><img
                                src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/pinterest.svg')}}"
                                alt="pinterest" width="31" height="31" loading="lazy"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-brown-dark copyright">
        <div class="container py-3">
            <p class="text-center text-white mb-1">Copyright &copy; 2020-{{date('Y')}} Astroway. All
                Rights Reserved</p>

        </div>

    </div>
</div>
