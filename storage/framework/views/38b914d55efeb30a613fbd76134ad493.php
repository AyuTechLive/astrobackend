<?php

    use Symfony\Component\HttpFoundation\Session\Session;
    use Illuminate\Support\Facades\Artisan;
    use App\Models\AstrologerModel\AstrologerStory;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    if (astroauthcheck()) {
        $session = new Session();
        $token = $session->get('astrotoken');
        Artisan::call('cache:clear');
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
            ->where('userId', astroauthcheck()['id'])
            ->get();

        $twentyFourHoursAgo = Carbon::now()->subHours(24);
        $stories = AstrologerStory::select(
            '*',
            DB::raw(
                '(Select Count(story_view_counts.id) as StoryViewCount from story_view_counts where storyId=astrologer_stories.id) as StoryViewCount',
            ),
        )
            ->where('created_at', '>=', $twentyFourHoursAgo)
            ->where('created_at', '<=', Carbon::now())
            ->where('astrologerId', astroauthcheck()['astrologerId'])
            ->orderBy('created_at', 'DESC')
            ->get();
    }
    $logo = DB::table('systemflag')->where('name', 'AdminLogo')->select('value')->first();
    $appName = DB::table('systemflag')->where('name', 'AppName')->select('value')->first();

    $agoraAppIdValue = DB::table('systemflag')->where('name', 'AgoraAppId')->select('value')->first();

    $agorcertificateValue = DB::table('systemflag')->where('name', 'AgoraAppCertificate')->select('value')->first();

    $channel_name = 'AstrowayGuruLive_' . astroauthcheck()['astrologerId'] . '';

    $astrologerId = DB::table('liveastro')
        ->where('astrologerId', astroauthcheck()['astrologerId'])
        ->select('astrologerId')
        ->first();

    $getsystemflag = Http::withoutVerifying()
        ->post(url('/') . '/api/getSystemFlag')
        ->json();
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
        #notificationList {
            width: 370px !important;
        }
    }

    .hidden {
        display: none;
    }


    .profilediv {
        border-radius: 50%;
        display: inline-block;
        padding: 3px;
        background: linear-gradient(#fffefe 0 0) padding-box, linear-gradient(to right, #9c20aa, #fb3570) border-box;
        border: 3px solid transparent;
    }



    


</style>


<div class="wzrk-alert wzrk-hidden  wiz-show-animate">
    <div class="wzrk-alert-heading">Would you like to receive Push Notifications?</div>
    <div class="wzrk-alert-body">We promise to only send you relevant content and give you updates on your transactions
    </div>
    <div class="wzrk-button-container"><button id="wzrk-cancel" class="No thanks">No thanks</button><button
            id="wzrk-confirm" class="Sign me Up!" style="background-color: rgb(242, 128, 70);">Sign me up!</button></div>
</div>



<div class="modal fade rounded mt-2 mt-md-5 " id="storymodal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold">
                    Story Form
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body pt-0 pb-0">
                <div class="bg-white body">
                    <div class="row ">
                        <div class="col-lg-12 col-12 ">
                            <div class="mb-3 ">
                                <form class="px-3 font-14" method="post" id="storyForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12 col-md-12 py-2">
                                            <div class="form-group">
                                                <label for="Type">Select Type <span
                                                        class="color-red">*</span></label>
                                                <select class="form-control" id="Type" name="mediaType"
                                                    onchange="toggleInputFields()">
                                                    <option value="text">Text</option>
                                                    <option value="image">Image</option>
                                                    <option value="video">Video</option>
                                                </select>
                                                <input type="hidden" name="astrologerId"
                                                    value="<?php echo e(astroauthcheck()['astrologerId']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 py-2 hidden" id="text-input-group">
                                            <div class="form-group mb-0">
                                                <label for="textInput">Text<span class="color-red">*</span></label>
                                                <input id="textInput" name="media"
                                                    class="form-control border-pink matchInTxt shadow-none">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 py-2 hidden" id="image-input-group">
                                            <div class="form-group mb-0">
                                                <label for="fileInput">File<span class="color-red">*</span></label>
                                                <input type="file" id="fileInput" name="media[]" multiple
                                                    accept=".jpeg, .png, .gif" style="height:44px;"
                                                    class="form-control border-pink matchInTxt shadow-none">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 py-2 hidden" id="video-input-group">
                                            <div class="form-group mb-0">
                                                <label for="videoFileInput">File<span class="color-red">*</span></label>
                                                <input type="file" id="videoFileInput" name="videoMedia"
                                                    accept="video/*" style="height:44px;"
                                                    class="form-control border-pink matchInTxt shadow-none">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 py-3">
                                        <div class="row">
                                            <div class="col-12 pt-md-3 text-center mt-2">
                                                <button class="font-weight-bold ml-0 w-100 btn btn-chat"
                                                    id="callloaderintakeBtn" type="button" style="display:none;"
                                                    disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span> Loading...
                                                </button>
                                                <button type="submit" class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                    id="storyBtn">Upload Story</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<!-- Story Modal -->
<div class="modal fade" id="storyModal" tabindex="-1" aria-labelledby="storyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img id="astrologerProfileImage" src="" alt="Astrologer Profile Image" class="rounded-circle"
                    style="height: 40px;width:40px">
                <span class="modal-title mt-2 ml-2" id="astrologerName"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators" id="carouselIndicators"></ol>
                    <div class="carousel-inner" id="carouselInner"></div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
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


                    <a class="navbar-brand" href="<?php echo e(route('front.astrologerindex')); ?>">
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
                                        <div class="list-group list-group-flush dropdown mb-3">
                                            <a href="javascript:void(0)"
                                                class="mb-0 border-bottom text-decoration-none border-pink text-uppercase font-weight-semi-bold">
                                                Astrology
                                            </a>
                                            <a class="dropdown-caret dropdownmob dropdown-toggle position-absolute px-1"
                                                style="width:20px;right:0!important" id="navbarDropdown2"
                                                role="button" data-toggle="dropdown" aria-expanded="false"><b
                                                    class="caret"></b></a>
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
                                                style="width:20px;right:0!important" id="navbarDropdown2"
                                                role="button" data-toggle="dropdown" aria-expanded="false"><b
                                                    class="caret"></b></a>
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
                                                style="width:20px;right:0!important" id="navbarDropdown4"
                                                role="button" data-toggle="dropdown" aria-expanded="false"><b
                                                    class="caret"></b></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown4">
                                                <a href="<?php echo e(route('front.getPanchang')); ?>"
                                                    class="dropdown-item list-unstyled py-1 font-14">Today&#39;s
                                                    Panchang</a>
                                            </div>
                                        </div>



                                    </div>


                                    <ul class="navbar-nav pt-3 px-3 w-100 d-lg-none">



                                        <?php if(empty($astrologerId)): ?>
                                            <li class="nav-item">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <input type="hidden" name="astrologerId"
                                                        value="<?php echo e(astroauthcheck()['astrologerId']); ?>">
                                                    <a  class="btn btn-chat other-country goLiveBtn"
                                                        id="goLiveBtn"><i class="fa-solid fa-circle-play"></i>&nbsp;
                                                        Go Live</a>

                                                </div>

                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center header-call-chat-btn w-50 justify-content-end">


                    <?php if(empty($astrologerId)): ?>
                        <div class="btn-groups d-none d-lg-flex mr-md-5" style="width:155px;">
                            <input type="hidden" name="astrologerId"
                                value="<?php echo e(astroauthcheck()['astrologerId']); ?>">
                            <a href="#" class="btn btn-chat other-country goLiveBtn" id="goLiveBtn"><i
                                    class="fa-solid fa-circle-play"></i>&nbsp; Go Live</a>
                            

                        </div>
                    <?php endif; ?>

                    <div id="google_translate_button" style="height:38px;"></div>


                    <ul class="list-inline mb-0 d-flex align-items-center userprofileicon">


                        <?php if(astroauthcheck()): ?>

                            <li class="list-inline-item">
                                <div class="dropdown ">
                                    <a class="btn dropdown-toggle p-0" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                        <?php if(astroauthcheck()['profile']): ?>
                                            <img src="/<?php echo e(astroauthcheck()['profile']); ?>" alt="User"
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


                                                <?php if($stories && count($stories) > 0): ?>

                                                    <div class="position-relative profilediv">
                                                        <?php if(astroauthcheck()['profile']): ?>
                                                            <img src="/<?php echo e(astroauthcheck()['profile']); ?>"
                                                                alt="User"
                                                                class="img-fluid astrostory rounded-circle">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>"
                                                                alt="User"
                                                                class="img-fluid astrostory rounded-circle">
                                                        <?php endif; ?>
                                                        <i class="fa-solid fa-circle-plus position-absolute"
                                                            style="right: -10px;" data-toggle="modal"
                                                            data-target="#storymodal"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="position-relative ">
                                                        <?php if(astroauthcheck()['profile']): ?>
                                                            <img src="/<?php echo e(astroauthcheck()['profile']); ?>"
                                                                alt="User" class="img-fluid ">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>"
                                                                alt="User" class="img-fluid ">
                                                        <?php endif; ?>
                                                        <i class="fa-solid fa-circle-plus position-absolute"
                                                            style="right: 63px;" data-toggle="modal"
                                                            data-target="#storymodal"></i>
                                                    </div>
                                                <?php endif; ?>


                                                <div>
                                                    <h2 class="pt-3">
                                                        <?php echo e(str_repeat('X', 6) . substr(astroauthcheck()['contactNo'], -4)); ?>


                                                    </h2>
                                                    <h3></h3>
                                                </div>
                                            </li>
                                            <li class="d-lg-block">
                                                <div>
                                                    <a class="dropdown-item "
                                                        href="<?php echo e(route('front.profileupdate')); ?>">
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
                                                        href="<?php echo e(route('front.getAstrologerWallet')); ?>">
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
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('front.getAstrologerChat')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-comment-dots"></i>
                                                        </span>
                                                        <span>My Chats</span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('front.getAstrologerCall')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-phone"></i>
                                                        </span>
                                                        <span>My Calls</span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('front.getAstrologerReport')); ?>">
                                                        <span class="mr-2">
                                                            <i class="fa-solid fa-file"></i>
                                                        </span>
                                                        <span>My Report</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="d-block">
                                                <div>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('front.followerslist')); ?>">
                                                        <span class="mr-2">
                                                            <i class='fas fa-user-check'></i>
                                                        </span>
                                                        <span>My Followers</span>
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
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-storage.js"></script>

<script>
    function toggleInputFields() {
        var type = document.getElementById("Type").value;
        var textInputGroup = document.getElementById("text-input-group");
        var imageInputGroup = document.getElementById("image-input-group");
        var videoInputGroup = document.getElementById("video-input-group");

        textInputGroup.classList.add("hidden");
        imageInputGroup.classList.add("hidden");
        videoInputGroup.classList.add("hidden");

        if (type === "text") {
            textInputGroup.classList.remove("hidden");
        } else if (type === "image") {
            imageInputGroup.classList.remove("hidden");
        } else if (type === "video") {
            videoInputGroup.classList.remove("hidden");
        }
    }

    // Initialize the form with the correct input fields shown based on the default selection
    window.onload = function() {
        toggleInputFields();
    }
</script>
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
            url: "<?php echo e(route('front.astrologerlogout')); ?>", // URL of your logout route
            type: 'GET',
            success: function(response) {

                toastr.success('Logged out successfully');

                setTimeout(function() {
                    window.location.href = "<?php echo e(route('front.astrologerlogin')); ?>";
                }, 1000);
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('.goLiveBtn').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Do you want to start a live session ?',
                // icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Go Live'
            }).then((result) => {
                if (result.isConfirmed) {


                    $.ajax({
                        url: '<?php echo e(route('api.generateRtcToken')); ?>',
                        type: 'POST',
                        data: {
                            appID: '<?= $agoraAppIdValue->value ?>',
                            appCertificate: '<?= $agorcertificateValue->value ?>',
                            channelName: '<?php echo e($channel_name); ?>'
                        },
                        success: function(response) {
                            var RtcToken = response.rtcToken;
                            console.log(RtcToken);


                            $.ajax({
                                url: '<?php echo e(route('api.addLiveAstrologerWeb')); ?>',
                                type: 'POST',
                                data: {
                                    channelName: '<?php echo e($channel_name); ?>',
                                    token: RtcToken,
                                    astrologerId: '<?php echo e(astroauthcheck()['astrologerId']); ?>'
                                },
                                success: function(response_live) {
                                    toastr.success(
                                        'Go live Successfully');
                                    console.log(response_live);
                                    window.location.href =
                                        "<?php echo e(route('front.LiveAstrologers')); ?>";
                                },
                                error: function(xhr, status, error) {
                                    var errorMessage = JSON.parse(xhr
                                            .responseText).error
                                        .paymentMethod[0];
                                    toastr.error(errorMessage);
                                }
                            });



                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error(xhr.responseText);
                        }
                    });

                }
            });
        });
    });

    function showPopup() {
        $(".wzrk-hidden").removeClass("wzrk-hidden");
      }


    window.onload = function() {
        var context = new AudioContext();
        console.log(context.state);

       // Check if the context state is 'suspended'
        if (context.state === 'suspended') {
            showPopup();

            $('#wzrk-confirm').on('click', function() {
                context.resume().then(() => {
                    $(".wzrk-alert").addClass("wzrk-hidden");
                    console.log('Playback resumed successfully');
                });
            });

            $('#wzrk-cancel').on('click', function() {
                $(".wzrk-alert").addClass("wzrk-hidden");
                console.log('User denied audio playback');
            });
        }

    }

    // Notification Update
    <?php
        $token = $session->get('astrotoken');
    ?>
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



                notificationList.innerHTML = '';
                notificationCount.innerText = data.recordList.length; // Update notification count

                data.recordList.forEach(notification => {
                    const ChatStatus = notification.chatStatus === 'Pending';
                    const CallStatus = notification.callStatus === 'Pending';

                    if (notification.id > lastchild && lastchild != undefined && ( ChatStatus || CallStatus))
                        playSound("<?php echo e(asset('public/sound/livechat-129007.mp3')); ?>");

                    let route = '#';
                    let bgClass = '';
                    if (ChatStatus || CallStatus) {
                        route = "<?php echo e(route('front.astrologerindex')); ?>";
                        bgClass = 'bg-pink';
                    }

                    notificationList.innerHTML += `
                        <li class="d-lg-block ${bgClass}" not-id="${notification.id}">
                            <div>
                                <a class="dropdown-item" href="${route}">
                                    <span class="mr-2 accSet accSettingWeb">
                                        <i class="fa-solid fa-bell"></i>
                                    </span>
                                    <span>${notification.title}</span>
                                </a>
                            </div>
                        </li>
                    `;
                });

            })
            .catch(error => console.error('Error fetching notifications:', error));
    }, 4000);

    // Clear Notification
    $('#clearNotifications').click(function(e) {
        e.preventDefault();

        <?php
            $token = $session->get('astrotoken');
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

    // Upload Srory
    $('#storyBtn').click(function(e) {
        e.preventDefault();

        <?php
            $token = $session->get('astrotoken');
        ?>

        var formData = new FormData($('#storyForm')[0]);

        if (formData.get('mediaType') == 'video') {
            formData.append('media', formData.get('videoMedia'));
        }

        $.ajax({
            url: "<?php echo e(route('api.addStory', ['token' => $token])); ?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Story Added Successfully');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                toastr.error(xhr.responseText);
            }
        });
    });
</script>
<script>
    function playSound(url) {
        const audio = new Audio(url);
        audio.play();
    }

    $(document).ready(function() {
        $('.astrostory').on('click', function() {
            var astrologerId = "<?php echo e(astroauthcheck()['astrologerId']); ?>";
            var astrologerName = "<?php echo e(astroauthcheck()['name']); ?>";
            var astrologerProfile = "/<?php echo e(astroauthcheck()['profile']); ?>";
            // console.log(astrologerProfile);

            if (!astrologerProfile) {
                astrologerProfile =
                    'public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png';
            }
            // Make an AJAX request to get the stories
            $.ajax({
                url: '/astrologer/' + astrologerId + '/stories',
                method: 'GET',
                success: function(response) {
                    openStoryModal(response, astrologerName, astrologerProfile);
                },
                error: function(error) {
                    console.error('Error fetching stories:', error);
                }
            });
        });
    });

    function openStoryModal(stories, name, profileImage) {
        var modal = $('#storyModal');
        var astrologerProfileImage = $('#astrologerProfileImage');
        var astrologerName = $('#astrologerName');
        var carouselIndicators = $('#carouselIndicators');
        var carouselInner = $('#carouselInner');
        var modalTitle = $('#astrologerName');

        // Clear existing slides and indicators
        carouselIndicators.empty();
        carouselInner.empty();

        // Add new slides and indicators
        stories.forEach((story, index) => {
            var indicator = $('<li>')
                .attr('data-target', '#carouselExampleIndicators')
                .attr('data-slide-to', index);
            if (index === 0) {
                indicator.addClass('active');
            }
            carouselIndicators.append(indicator);

            var carouselItem = $('<div>')
                .addClass('carousel-item');
            if (index === 0) {
                carouselItem.addClass('active');
            }

            if (story.mediaType === 'image') {
                var img = $('<img>')
                    .addClass('d-block w-100')
                    .attr('src', '/' + story.media);
                carouselItem.append(img);
            } else if (story.mediaType === 'video') {
                var video = $('<video>')
                    .addClass('d-block w-100')
                    .attr('controls', true);
                var source = $('<source>')
                    .attr('src', '/' + story.media)
                    .attr('type', 'video/mp4');
                video.append(source);
                carouselItem.append(video);
            } else if (story.mediaType === 'text') {
                var text = $('<div>')
                    .addClass('d-block w-100 text-center')
                    .css({
                        'padding': '20px',
                        'font-size': calculateFontSize(story.media)
                    })
                    .text(story.media);
                carouselItem.append(text);
            }
            <?php if(authcheck()): ?>
                trackStoryView(story.id);
            <?php endif; ?>
            carouselInner.append(carouselItem);
        });

        modalTitle.text(name);
        astrologerProfileImage.attr('src', profileImage);

        modal.modal('show');

        // Stop auto sliding
        $('.carousel').carousel('pause');


        function calculateFontSize(text) {
            var baseFontSize = 30;
            var maxLength = 200;
            var fontSize = baseFontSize;

            if (text.length > maxLength) {
                fontSize = baseFontSize - ((text.length - maxLength) / 10);
            }

            return fontSize + 'px';
        }


        function trackStoryView(storyId) {
            $.ajax({
                url: 'astrologer/viewstory',
                method: 'POST',
                data: {
                    storyId: storyId
                },
                success: function(response) {
                    console.log(response.message);
                },
                error: function(error) {
                    console.error('Error viewing story:', error);
                }
            });
        }
    }
</script>
<?php /**PATH C:\xampp8212\htdocs\resources\views/frontend/astrologers/layout/header.blade.php ENDPATH**/ ?>