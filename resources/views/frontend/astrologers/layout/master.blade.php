<!DOCTYPE html>
<html lang="en">

<head>
    @php
    $logo = DB::table('systemflag')->where('name', 'AdminLogo')->select('value')->first();
    $appname = DB::table('systemflag')
            ->where('name', 'AppName')
            ->select('value')
            ->first();
        $appname = $appname ? $appname->value : 'Astroway';
@endphp
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta
        content="Ask an online astrologer and get instant consultation on top Astrology portal. Accurate astrology predictions and solutions by India's best Astrologers' team."
        name="description" />
    <meta property="Keywords" content="" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description"
        content="Ask an online astrologer and get instant consultation on top Astrology portal. Accurate astrology predictions and solutions by India's best Astrologers' team." />
    <meta name="twitter:title" content="Online Astrology Consultation, Ask an Astrologer - {{ucfirst($appname)}}" />
    <meta name="twitter:image" content="/public/storage/images/AdminLogo1707194841.png" />

    <meta property="og:type" content="website" />
    <meta property="og:title" content="Online Astrology Consultation, Ask an Astrologer - {{ucfirst($appname)}}" />
    <meta property="og:description"
        content="Ask an online astrologer and get instant consultation on top Astrology portal. Accurate astrology predictions and solutions by India's best Astrologers' team." />
    <meta property="og:image" content="/public/storage/images/AdminLogo1707194841.png" />
    <meta property="og:url" content="index.html" />
    <meta property="og:site_name" content="{{ucfirst($appname)}}" />

    <title>Online Astrology Consultation, Ask an Astrologer - {{ucfirst($appname)}}</title>

    <link href="index.html" rel="canonical" />

    <link href="{{asset($logo->value)}}" rel="shortcut icon" type="image/x-icon" />


    <link rel="preconnect" as="font"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2?v=4.7.0"
        type="font/woff2" crossorigin />

    <link rel="stylesheet" href="{{ asset('public/frontend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link href="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/css/font/stylesheet.css') }}"
        rel="stylesheet" />




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" />
    </noscript>

    <link rel="stylesheet"
        href="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/css/carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/css/carousel/owl.carousel.css') }}">
    <link href="{{ asset('public/frontend/select2/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}"
        rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css"
        integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('public/build/assets/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="preload" href="https://translate.google.com/translate_a/element.js?cb=googleTranslateInit" as="script">
    <style>
        body.Is-Offer{
            top: 0px !important;
        }
    </style>


</head>
@include('frontend.astrologers.layout.header')

<body class="english country-in Is-Offer ">
    <div class="wrapper">

        @yield('content')

    </div>
</body>

@include('frontend.astrologers.layout.footer')

@yield('scripts')


<script
    src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/js/carousel/owl.carousel.min.js') }}">
</script>
<script src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/js/carousel/owl.carousel.js') }}">
</script>
<script src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/js/popper.min.js') }}"></script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
<script async src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/js/bootstrap.min.js') }}">
</script>
<script async src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/js/popper.min.js') }}">
</script>
<script async src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/js/momentum.js') }}"></script>
<script async src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/js/bootstrap-datepicker.min.js') }}">
</script>
<script async src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/js/js.cookie.min.js') }}"></script>
<script async src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/bundle/js/AfterLoginJs.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.js"
    integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/js/duDatepicker.js') }}"></script>


@php
    use Illuminate\Support\Facades\DB;
    $webLanguage=DB::table('systemflag')->where('name','WebLanguage')->first();
    $selectedLanguages = json_decode($webLanguage->value, true) ?: [];
    $includedLanguages = implode(',', $selectedLanguages);
@endphp

{{-- <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateInit"></script> --}}


<script>
            (function() {
    // Check if the script is already loaded
    if (typeof google === 'undefined' || !google.translate || !google.translate.TranslateElement) {
        var gtScript = document.createElement('script');
        gtScript.type = 'text/javascript';
        gtScript.async = true;
        gtScript.defer = true;
        gtScript.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateInit';
        document.head.appendChild(gtScript);
    } else {
        console.log('Google Translate script is already loaded.');
    }
})();

var translateInitialized = false;

function googleTranslateInit() {
    if (translateInitialized) {
        console.log('Google Translate already initialized.');
        return; // Prevent multiple initializations
    }

    try {
        new google.translate.TranslateElement(
            {
                pageLanguage: 'en',
                includedLanguages: '{{ $includedLanguages }}',
            },
            'google_translate_button'
        );
        translateInitialized = true; // Mark as initialized

        // Use MutationObserver to detect when the dropdown is rendered
        const observer = new MutationObserver((mutationsList, observer) => {
            const selectLanguageElement = document.querySelector('.goog-te-combo');
            if (selectLanguageElement && selectLanguageElement.options.length > 0) {
                // Change the default text from "Select Language" to "English"
                selectLanguageElement.options[0].text = 'English';
                observer.disconnect(); // Stop observing once the change is made
            }
        });

        // Start observing the document for changes
        observer.observe(document.body, { childList: true, subtree: true });

    } catch (error) {
        console.error('Google Translate failed to initialize:', error);
    }
}
    </script>

</html>
