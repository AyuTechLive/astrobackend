<?php

    use Symfony\Component\HttpFoundation\Session\Session;
    use Illuminate\Support\Facades\Artisan;

    Artisan::call('cache:clear');
    if (authcheck()) {
        $session = new Session();
        $token = $session->get('token');

        $getProfile = Http::withoutVerifying()
            ->post(url('/') . '/api/getProfile', [
                'token' => $token,
            ])
            ->json();

        $getUserNotification = Http::withoutVerifying()
            ->post(url('/') . '/api/getUserNotification', [
                'token' => $token,
            ])
            ->json();

        $chatrequest = DB::table('chatrequest')
            ->where('userId', authcheck()['id'])
            ->get();
    }
        $logo = DB::table('systemflag')
            ->where('name', 'AdminLogo')
            ->select('value')
            ->first();
        $appName = DB::table('systemflag')
            ->where('name', 'AppName')
            ->select('value')
            ->first();



        $getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
        $getsystemflag = collect($getsystemflag['recordList']);
        $currency = $getsystemflag->where('name', 'currencySymbol')->first();
        $appId = $getsystemflag->where('name', 'firebaseappId')->first();
        $measurementId = $getsystemflag->where('name', 'firebasemeasurementId')->first();
        $messagingSenderId = $getsystemflag->where('name', 'firebasemessagingSenderId')->first();
        $storageBucket = $getsystemflag->where('name', 'firebasestorageBucket')->first();
        $projectId = $getsystemflag->where('name', 'firebaseprojectId')->first();
        $authDomain = $getsystemflag->where('name', 'firebaseauthDomain')->first();
        $databaseURL = $getsystemflag->where('name', 'firebasedatabaseURL')->first();
        $apiKey = $getsystemflag->where('name', 'firebaseapiKey')->first();
        $otplessAppId = $getsystemflag->where('name', 'otplessAppId')->first();


?>



<style>
    .scrollable-menu {
        max-height: 450px;
        /* Adjust this value as needed */
        overflow-y: auto;

    }

    .dropdown-menu.show {
        display: block;
    }

    .btn-chataccept {
        border-radius: 30px;
        border: 1px solid #5bbe2a;
        background-color: #5bbe2a !important;
        color: white !important;
    }

    .btn-chatreject {
        border-radius: 30px;
        border: 1px solid #ee4e5e;
        background-color: #ffffff !important;
        color: #ee4e5e !important;
    }

    .btn.clear-notification {
        font-size: 15px !important;
        padding: 8px 30px !important;
    }

    .btn.clear-notification:hover,
    .btn.clear-notification:focus,
    .btn.clear-notification:active {
        color: #fff !important;
        background: #ee4e5e !important;
    }

    @media screen and (max-width: 520px) {
    #notificationList{
        width: 370px !important;
    }
}



</style>


<div class="wzrk-alert wzrk-hidden  wiz-show-animate">
    <div class="wzrk-alert-heading">Would you like to receive Push Notifications?</div>
    <div class="wzrk-alert-body">We promise to only send you relevant content and give you updates on your transactions
    </div>
    <div class="wzrk-button-container"><button id="wzrk-cancel" class="No thanks">No thanks</button><button
            id="wzrk-confirm" class="Sign me Up!" style="background-color: rgb(242, 128, 70);">Sign me up!</button></div>
</div>

<div class="header">
    <nav class="navbar navbar-light fixed-top">
        <div class="container">
            <div class="d-flex align-items-center w-100 justify-content-between">
                <div class="d-flex align-items-center w-50">
                    <button class="navbar-toggler d-inline d-lg-none mr-2" type="button" data-toggle="collapse"
                        data-target="#main_nav" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"
                            style="background-image:url(<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/nav-toggle.svg')); ?>);"></span>
                    </button>


                    <a class="navbar-brand" href="<?php echo e(route('front.home')); ?>">
                        <div class="d-flex align-items-center">
                            <img src="/<?php echo e($logo->value); ?>" alt="<?php echo e($appName->value); ?>" class="img-fluid"
                                width="53" height="53">
                            <div class="astroway-logo-ntext ml-2">
                                <span class="astroway-logo-text"><?php echo e($appName->value); ?></span>
                                <span class="astroway-logo-subtext">Consult Online Astrologers Anytime</span>
                            </div>
                        </div>
                    </a>

                    <div class="collapse navbar-collapse position-absolute" id="main_nav">
                        <div class="container">
                            <div class="w-100">
                                <div class="row my-4">
                                    <div class="col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush dropdown ">
                                            <a href="javascript:void(0)"
                                                class="mb-0 border-bottom text-decoration-none border-pink text-uppercase font-weight-semi-bold">
                                                Astrology Online
                                            </a>
                                            <a class="dropdown-caret dropdownmob dropdown-toggle position-absolute px-1"
                                                style="width:20px;right:0!important" role="button" id="navbarDropdown"
                                                data-toggle="dropdown" aria-expanded="false"><b class="caret"></b></a>
                                            <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                                                <a href="<?php echo e(route('front.talkList')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Talk To
                                                    Astrologer</a>
                                                <a href="<?php echo e(route('front.chatList')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Chat With
                                                    Astrologer</a>


                                                <?php
                                                    $getAstrologerCategory = Http::withoutVerifying()
                                                        ->post(url('/') . '/api/getAstrologerCategory')
                                                        ->json();

                                                ?>

                                                <?php $__currentLoopData = $getAstrologerCategory['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a class="dropdown-item list-unstyled py-1 font-14"
                                                        href="<?php echo e(route('front.chatList', ['astrologerCategoryId' => $category['id']])); ?>"><?php echo e($category['name']); ?></a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush dropdown mb-3">
                                            <a href="javascript:void(0)"
                                                class="mb-0 border-bottom text-decoration-none border-pink text-uppercase font-weight-semi-bold">
                                                Astrology
                                            </a>
                                            <a class="dropdown-caret dropdownmob dropdown-toggle position-absolute px-1"
                                                style="width:20px;right:0!important" id="navbarDropdown2" role="button"
                                                data-toggle="dropdown" aria-expanded="false"><b class="caret"></b></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                                <a href="<?php echo e(route('front.kundaliMatch')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Kundali
                                                    Matching</a>
                                                <a href="<?php echo e(route('front.getkundali')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Free Janam
                                                    Kundali</a>
                                            </div>
                                        </div>
                                        <div class="list-group list-group-flush dropdown mb-3">
                                            <a href="javascript:void(0)"
                                                class="mb-0 border-bottom text-decoration-none border-pink text-uppercase font-weight-semi-bold">
                                                Horoscope
                                            </a>
                                            <a class="dropdown-caret dropdownmob dropdown-toggle position-absolute px-1"
                                                style="width:20px;right:0!important" id="navbarDropdown2" role="button"
                                                data-toggle="dropdown" aria-expanded="false"><b class="caret"></b></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                                <a href="<?php echo e(route('front.horoScope')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Daily
                                                    Horoscope</a>
                                                <a href="<?php echo e(route('front.horoScope')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Weekly
                                                    Horoscope</a>
                                                <a href="<?php echo e(route('front.horoScope')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Yearly
                                                    Horoscope</a>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush dropdown mb-3">
                                            <a href="javascript:void(0)"
                                                class="mb-0 border-bottom text-decoration-none border-pink text-uppercase font-weight-semi-bold">
                                                Panchang
                                            </a>
                                            <a class="dropdown-caret dropdownmob dropdown-toggle position-absolute px-1"
                                                style="width:20px;right:0!important" id="navbarDropdown4" role="button"
                                                data-toggle="dropdown" aria-expanded="false"><b class="caret"></b></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown4">
                                                <a href="<?php echo e(route('front.getPanchang')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Today&#39;s
                                                    Panchang</a>
                                            </div>
                                        </div>

                                        <div class="list-group list-group-flush dropdown mb-3">
                                            <a href="javascript:void(0)"
                                                class="mb-0 border-bottom text-decoration-none border-pink text-uppercase font-weight-semi-bold">
                                                Report
                                            </a>
                                            <a class="dropdown-caret dropdownmob dropdown-toggle position-absolute px-1"
                                                style="width:20px;right:0!important" id="navbarDropdown4" role="button"
                                                data-toggle="dropdown" aria-expanded="false"><b class="caret"></b></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown4">
                                                <a href="<?php echo e(route('front.reportList')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Get Report</a>
                                            </div>
                                        </div>

                                    </div>


                                    <ul class="navbar-nav pt-3 px-3 w-100 d-lg-none">
                                        <li class="nav-item">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="<?php echo e(route('front.talkList')); ?>"
                                                    class="btn btn-block btn-chat other-country m-0 w-100 nav-link"><img
                                                        src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/call.svg')); ?>">
                                                    Talk To Astrologer</a>

                                            </div>

                                        </li>
                                        <li class="nav-item pt-3">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="<?php echo e(route('front.chatList')); ?>"
                                                    class="btn btn-block btn-chat m-0 w-100 nav-link"><img
                                                        src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/chat.svg')); ?>">
                                                    Chat With Astrologer</a>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center header-call-chat-btn w-50 justify-content-end">
                    <div class="btn-groups d-none d-lg-flex mr-md-3">
                        <a href="<?php echo e(route('front.talkList')); ?>" id="callPg"
                            class="btn btn-chat other-country"><img
                                src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/call.svg')); ?>"
                                alt="call"> Talk To Astrologer</a>
                        <a href="<?php echo e(route('front.chatList')); ?>" id="chatPg" class="btn btn-chat"><img
                                src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/chat.svg')); ?>"
                                alt="chat"> Chat With Astrologer</a>
                    </div>

                    <div id="google_translate_button" style="height:38px;"></div>


                    <ul class="list-inline mb-0 d-flex align-items-center userprofileicon">


                        <?php if(authcheck()): ?>

                            <li class="list-inline-item">
                                <div class="dropdown ">
                                    <a class="btn dropdown-toggle p-0" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                        <?php if(authcheck()['profile']): ?>
                                            <img src="/<?php echo e(authcheck()['profile']); ?>" alt="User"
                                                class="img-fluid">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img.png')); ?>"
                                                alt="" class="psychic-img img-fluid">
                                        <?php endif; ?>


                                    </a>
                                    <div class="dropdown-menu user-options fadeInUp5px dropdown-menu-right dropdown-menu-lg-left"
                                        aria-labelledby="dropdownMenuLink">
                                        <ul>
                                            <li class="namedisplay d-block text-center">


                                                <?php if(authcheck()['profile']): ?>
                                                    <img src="/<?php echo e(authcheck()['profile']); ?>" alt="User"
                                                        class="img-fluid">
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>"
                                                        alt="User" class="img-fluid">
                                                <?php endif; ?>

                                                <div>
                                                    <h2 class="pt-3"><?php echo e(str_repeat('X', 6) . substr(authcheck()['contactNo'], -4)); ?>


                                                    </h2>
                                                    <h3></h3>
                                                </div>
                                            </li>
                                            <li class="d-lg-block">
                                                <div>
                                                    <a class="dropdown-item "
                                                        href="<?php echo e(route('front.getMyAccount')); ?>">
                                                        <span class="mr-2 accSet accSettingWeb">
                                                            <i class="fa-solid fa-user"></i>

                                                        </span>
                                                        <span>My Account</span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center pr-2"
                                                        href="<?php echo e(route('front.getMyWallet')); ?>">
                                                        <span>
                                                            <span class="mr-2">
                                                                <i class="fa-solid fa-wallet"></i>
                                                            </span>

                                                            <span>My Wallet</span>
                                                        </span>
                                                        <span class="gWalletbalance color-red bg-pink"
                                                            style="border-radius:20px; padding:2px 10px; font-size:12px;"><?php echo e($currency['value']); ?><?php echo e($getProfile['data']['totalWalletAmount']); ?></span>

                                                    </a>
                                                </div>
                                            </li>



                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item" href="<?php echo e(route('front.getMyChat')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-comment-dots"></i>
                                                        </span>
                                                        <span>My Chats</span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item" href="<?php echo e(route('front.getMyCall')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-phone"></i>
                                                        </span>
                                                        <span>My Calls</span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item" href="<?php echo e(route('front.myOrders')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-cart-shopping"></i>
                                                        </span>
                                                        <span>My Orders</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item" href="<?php echo e(route('front.getMyReport')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-file"></i>
                                                        </span>
                                                        <span>My Reports</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item" href="<?php echo e(route('front.getMyFollowing')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-circle-user"></i>
                                                        </span>
                                                        <span>My Following</span>
                                                    </a>
                                                </div>
                                            </li>

                                            

                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item" id="logout" href="javascript:void()"
                                                        onclick="logout()">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-right-from-bracket"></i>
                                                        </span>
                                                        <span>Sign Out</span>
                                                    </a>
                                                </div>
                                            </li>



                                        </ul>
                                    </div>
                                </div>
                            </li>

                            
                            <li class="list-inline-item ml-4">
                                <div class="dropdown">
                                    <a class="btn  p-0" style="width: 30px" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa-solid fa-bell"></i>
                                        <span class="badge badge-danger badge-counter" id="notificationCount">0</span>
                                    </a>
                                    <div class="dropdown-menu user-options fadeInUp5px dropdown-menu-right dropdown-menu-lg-left scrollable-menu"
                                        aria-labelledby="dropdownMenuLink" id="notificationDropdown">
                                        <ul id="notificationList">
                                            <?php $__currentLoopData = $getUserNotification['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li
                                                    class="d-lg-block <?php if($notification['chatStatus'] == 'Accepted' || $notification['callStatus'] == 'Accepted'): ?> bg-pink <?php endif; ?>">
                                                    <div>
                                                        <a class="dropdown-item"
                                                            <?php if($notification['chatStatus'] == 'Accepted'): ?> onclick="setIds('<?php echo e($notification['chatId']); ?>', '<?php echo e($notification['astrologerId']); ?>')" data-toggle="modal" data-target="#chatinfomodal"
                                                            <?php elseif($notification['callStatus'] == 'Accepted'): ?> onclick="setCallIds('<?php echo e($notification['callId']); ?>', '<?php echo e($notification['astrologerId']); ?>')" data-toggle="modal" data-target="#callinfomodal" <?php endif; ?>>
                                                            <span class="mr-2 accSet accSettingWeb">
                                                                <i class="fa-solid fa-bell"></i>
                                                            </span>
                                                            <span><?php echo e($notification['title']); ?></span>
                                                        </a>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php if(count($getUserNotification['recordList']) > 0): ?>
                                            <a class="dropdown-item text-center btn clear-notification"
                                                id="clearNotifications">Clear Notifications</a>
                                        <?php else: ?>
                                            <ul id="notificationList">
                                                <li class="d-lg-block">
                                                    <span class="dropdown-item text-center ">No Notification Yet</span>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>



                            
                        <?php else: ?>
                            <li class="list-inline-item usericon"><a style="cursor:pointer;"
                                    class="colorblack font-weight-semi loginSignUp d-flex align-items-center"
                                    data-toggle="modal" data-target="#loginSignUp">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31.001"
                                        viewBox="0 0 31 31.001">
                                        <path id="Path_22197" data-name="Path 22197"
                                            d="M-1542.569-660.735a15.4,15.4,0,0,0-10.96-4.54,15.4,15.4,0,0,0-10.96,4.54,15.4,15.4,0,0,0-4.54,10.96,15.4,15.4,0,0,0,4.54,10.96,15.4,15.4,0,0,0,10.96,4.54,15.4,15.4,0,0,0,10.96-4.54,15.4,15.4,0,0,0,4.54-10.96A15.4,15.4,0,0,0-1542.569-660.735Zm-18.529,22.2a1.407,1.407,0,0,1,.058-.37,7.822,7.822,0,0,1,8.253-6.134,7.787,7.787,0,0,1,7.043,6.061.694.694,0,0,1,.021.279,13.477,13.477,0,0,1-7.806,2.48A13.475,13.475,0,0,1-1561.1-638.538Zm2.805-13.283a4.915,4.915,0,0,1,4.932-4.9,4.914,4.914,0,0,1,4.89,4.938,4.9,4.9,0,0,1-4.932,4.89A4.9,4.9,0,0,1-1558.293-651.821Zm14.155,11.807c-.047-.121-.1-.26-.148-.425a9.72,9.72,0,0,0-5.4-5.721,6.706,6.706,0,0,0,3.021-5.721,6.469,6.469,0,0,0-2-4.705,6.7,6.7,0,0,0-9.414-.021,6.5,6.5,0,0,0-1.994,5.449,6.659,6.659,0,0,0,3,4.994,10.164,10.164,0,0,0-5.644,6.344,13.518,13.518,0,0,1-4.367-9.956,13.568,13.568,0,0,1,13.552-13.552,13.568,13.568,0,0,1,13.552,13.552A13.514,13.514,0,0,1-1544.138-640.014Z"
                                            transform="translate(1569.03 665.275)" />
                                    </svg>
                                    <span class="d-none d-lg-inline ml-2 text-nowrap">Sign In </span></a>
                            </li>
                        <?php endif; ?>

                        

                    </ul>
                    <button class="navbar-toggler collapsed d-lg-inline position-relative border-0 d-none ml-2"
                        type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="navbarCollapse"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span style="color: #000">
                            <i class="fa-solid fa-list"></i>
                        </span>
                    </button>

                </div>
            </div>
        </div>
    </nav>
</div>


<div id="chatinfomodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm h-100 d-flex align-items-center">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title font-weight-bold">
                    Accept Chat Request
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <form id="chatForm">
                    <input type="hidden" name="chatId" id="chatIdInput" value="">
                    <input type="hidden" id="astrologerIdInput" name="astrologerId" value="">
                    <div class="text-center">
                        <a class="btn btn-chataccept  active d-inline-block m-2" id="startchat" role="button"
                            data-toggle="modal">
                            Start Chat
                        </a>
                        <a class="btn btn-chatreject active d-inline-block m-2" id="rejectchat" role="button"
                            data-toggle="modal">
                            Reject Chat
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>



<div id="callinfomodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm h-100 d-flex align-items-center">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title font-weight-bold">
                    Accept Call Request
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <form id="callForm">
                    <input type="hidden" name="callId" id="callIdInput" value="">
                    <input type="hidden" id="astrologerIdInput" name="astrologerId" value="">
                    <input type="hidden" id="calltypeInput" name="call_type" value="">
                    <div class="text-center">
                        <a class="btn btn-chataccept  active d-inline-block m-2" id="startcall" role="button"
                            data-toggle="modal">
                            Start Call
                        </a>
                        <a class="btn btn-chatreject active d-inline-block m-2" id="rejectcall" role="button"
                            data-toggle="modal">
                            Reject Call
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>



<div class="modal fade rounded mt-2 mt-md-5 login-offer" id="loginSignUp" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body pt-0 pb-0">
                <div class="login-offer-bg d-none">
                    <p class="text-white font-22 text-center font-weight-bold p-0 m-0 offertxt1">Get
                        Consultation from Experts</p>
                    <p class="text-center p-0 m-0 offertxt2 ">First Chat Free</p>

                </div>
                <button type="button" class="close login-sig-close-btn loginCloseBut" data-dismiss="modal"
                    aria-hidden="true">
                    ×
                </button>
                <div class="bg-white body">
                    <div class="row ">
                        <div class="col-md-12 px-4 py-5">

                            <ul class="nav nav-tabs">

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="LoginRegisterWithOTP">
                                    <div id="otpless-login-page"></div>

                                    <form method="post" action="<?php echo e(route('front.verifyOTL')); ?>" id="OtpLesslogin">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="otl_token" id="otl_token">
                                        <input id="contactNo" name="contactNo" type="hidden" value="" />
                                        <input id="countryCode" name="countryCode" type="hidden" value="" />
                                    </form>


                                </div>

                                <div class="tab-pane " id="Login">


                                    <div class="col-md-12 text-center">
                                        <h3><b>Welcome Back!</b></h3>
                                    </div>
                                    <div>
                                        <p class="colorblack mt-md-2 mt-2 text-center pb-md-0 pb-2 mb-0"> Sign
                                            in to your account</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script id="otpless-sdk" type="text/javascript" src="https://otpless.com/v2/auth.js" data-appid="<?php echo e($otplessAppId['value']); ?>"></script>
<script>
    function otpless(otplessUser) {
            console.log(JSON.stringify(otplessUser));
            $("#otl_token").val(otplessUser.token);
            $("#OtpLesslogin").submit();
        }
</script>


<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-storage.js"></script>



<script>
    var firebaseConfig = {
        apiKey: "<?php echo e($apiKey['value']); ?>",
        databaseURL: "<?php echo e($databaseURL['value']); ?>",
        authDomain: "<?php echo e($authDomain['value']); ?>",
        projectId: "<?php echo e($projectId['value']); ?>",
        storageBucket: "<?php echo e($storageBucket['value']); ?>",
        messagingSenderId: "<?php echo e($messagingSenderId['value']); ?>",
        appId: "<?php echo e($appId['value']); ?>",
        measurementId: "<?php echo e($measurementId['value']); ?>"
    };

    firebase.initializeApp(firebaseConfig);

</script>



<script>
    function logout() {
        $.ajax({
            url: "<?php echo e(route('front.logout')); ?>", // URL of your logout route
            type: 'GET',
            success: function(response) {

                toastr.success('Logged out successfully');

                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    }



</script>

<?php if(authcheck()): ?>
    <script>
       // Store the IDs of notifications that have already triggered a modal
let processedNotifications = new Set();

function setIds(chatId, astrologerId) {
    document.getElementById('chatIdInput').value = chatId;
    document.getElementById('astrologerIdInput').value = astrologerId;
}

function setCallIds(callId, astrologerId,call_type) {
    document.getElementById('callIdInput').value = callId;
    document.getElementById('astrologerIdInput').value = astrologerId;
    document.getElementById('calltypeInput').value = call_type;
}

// ---------------------

function showPopup() {
    let lastPopupShown = localStorage.getItem('popupTimestamp');
    let currentTime = new Date().getTime();

    // Check if the popup has been shown in the last 24 hours
    if (!lastPopupShown || currentTime - lastPopupShown > 24 * 60 * 60 * 1000) {
        $(".wzrk-alert").removeClass("wzrk-hidden");
    }
}

// Set event listeners for the buttons
$('#wzrk-cancel').on('click', function () {
    $(".wzrk-alert").addClass("wzrk-hidden");
    localStorage.setItem('popupTimestamp', new Date().getTime());
});

$('#wzrk-confirm').on('click', function () {
    $(".wzrk-alert").addClass("wzrk-hidden");
    localStorage.setItem('popupTimestamp', new Date().getTime());
    // You can add the functionality for signing up here
});

// Show popup on page load
$(document).ready(function () {
    showPopup();
});

// Handle audio context
window.onload = function() {
    var context = new (window.AudioContext || window.webkitAudioContext)();
    context.resume().then(() => {
        console.log('Playback resumed successfully');
    });
};


setInterval(function() {
    fetch("<?php echo e(route('api.getUserNotification', ['token' => $token])); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            const notificationList = document.getElementById('notificationList');
            const notificationCount = document.getElementById('notificationCount');

            var lastchild = $("#notificationList li:first-child").attr('not-id');
            lastchild = lastchild==undefined?0:parseInt(lastchild);
            console.log(lastchild);

            notificationList.innerHTML = '';
            notificationCount.innerText = data.recordList.length; // Update notification count

            data.recordList.forEach(notification => {
                const isChatAccepted = notification.chatStatus === 'Accepted';
                const isCallAccepted = notification.callStatus === 'Accepted';


                if (notification.id > lastchild && lastchild != undefined && ( isChatAccepted || isCallAccepted))
                        playSound("<?php echo e(asset('public/sound/livechat-129007.mp3')); ?>");

                notificationList.innerHTML += `
                    <li class="d-lg-block ${isChatAccepted || isCallAccepted ? 'bg-pink' : ''}" not-id="${notification.id}">
                        <div>
                            <a class="dropdown-item" ${isChatAccepted ? `onclick="setIds('${notification.chatId}', '${notification.astrologerId}')" data-toggle="modal" data-target="#chatinfomodal"` : (isCallAccepted ? `onclick="setCallIds('${notification.callId}', '${notification.astrologerId}','${notification.call_type}')" data-toggle="modal" data-target="#callinfomodal"` : '')}>
                                <span class="mr-2 accSet accSettingWeb">
                                    <i class="fa-solid fa-bell"></i>
                                </span>
                                <span>${notification.title}</span>
                            </a>
                        </div>
                    </li>
                `;

                // Check if the notification has already been processed
                if ((isChatAccepted || isCallAccepted) && !processedNotifications.has(notification.id)) {
                    // Add the notification ID to the set of processed notifications
                    processedNotifications.add(notification.id);

                    // Open the respective modal if the condition matches
                    if (isChatAccepted) {
                        setIds(notification.chatId, notification.astrologerId);
                        $('#chatinfomodal').modal('show');
                    } else if (isCallAccepted) {
                        setCallIds(notification.callId, notification.astrologerId,notification.call_type);

                        $('#callinfomodal').modal('show');
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching notifications:', error));
}, 4000);


function playSound(url) {
        const audio = new Audio(url);
        audio.play();
    }





        // Start Chat

        $('#startchat').click(function(e) {
            e.preventDefault();

            <?php
                $token = $session->get('token');

            ?>

            var formData = $('#chatForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();
            var chatId = $("#chatIdInput").val();


            $.ajax({
                url: "<?php echo e(route('api.acceptChatRequestFromCustomer', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Chat Started Successfully..Wait');
                    window.location.href = "<?php echo e(route('front.chat')); ?>" + "?astrologerId=" +
                        astrologerId + "&chatId=" + chatId;
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });

        // Reject Chat

        $('#rejectchat').click(function(e) {
            e.preventDefault();

            <?php
                $token = $session->get('token');
            ?>

            var formData = $('#chatForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();

            $.ajax({
                url: "<?php echo e(route('api.rejectChatRequestFromCustomer', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Chat Rejected Successfully.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });


        // Start Call

        $('#startcall').click(function(e) {
            e.preventDefault();

            <?php
                $token = $session->get('token');

            ?>

            var formData = $('#callForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();
            var callId = $("#callIdInput").val();
            var call_type = $("#calltypeInput").val();


            $.ajax({
                url: "<?php echo e(route('api.acceptCallRequestFromCustomer', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Call Started Successfully..Wait');
                    window.location.href = "<?php echo e(route('front.call')); ?>" + "?astrologerId=" +
                        astrologerId + "&callId=" + callId + "&call_type=" + call_type;
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });


        // Reject Call

        $('#rejectcall').click(function(e) {
            e.preventDefault();

            <?php
                $token = $session->get('token');
            ?>

            var formData = $('#callForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();

            $.ajax({
                url: "<?php echo e(route('api.rejectCallRequestFromCustomer', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Call Rejected Successfully.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });




        // Notification Clear


        $('#clearNotifications').click(function(e) {
            e.preventDefault();

            <?php
                $token = $session->get('token');
            ?>


            $.ajax({
                url: "<?php echo e(route('api.deleteAllUserNotification', ['token' => $token])); ?>",
                type: 'POST',
                success: function(response) {
                    toastr.success('Notification Cleared Successfully');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });
    </script>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/layout/header.blade.php ENDPATH**/ ?>