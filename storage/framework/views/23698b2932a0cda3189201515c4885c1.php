<?php $__env->startSection('content'); ?>
    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">
                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.home')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <a href="<?php echo e(route('front.getLiveAstro')); ?>"
                                style="color:white;text-decoration:none">Live Astrologers</a>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <div class="live-stream-astrologer p-3">
        <div class="container">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="d-block d-md-flex bg-white remote-playerlist-container">
                        <div class="remote-playerlist-inner position-relative  p-2">


                            <div id="remote-playerlist" class="remote-playerlist position-relative">
                                <div
                                    class="user-gift-expert position-absolute d-none align-items-center justify-content-center w-100">
                                    <div id="usergift-animation" class="h-100">
                                    </div>
                                </div>

                                <div id="remote-playerlist-controls" class="remote-playerlist-controls position-absolute">
                                    <div
                                        class="playerlist-control-top-left d-flex align-items-center justify-content-center position-absolute">
                                        <?php if($liveAstrologer->profileImage): ?>
                                        <img id="expertImgLive" src="/<?php echo e($liveAstrologer->profileImage); ?>" width="28"
                                            height="28">

                                            <?php else: ?>
                                            <img id="expertImgLive" src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>" width="28"
                                            height="28">
                                        <?php endif; ?>

                                        <span class="text-white ml-1" style="line-height: 12px;">
                                            <span id="expertNameLive"><?php echo e($liveAstrologer->name); ?></span>
                                            <br>
                                            <div class="text-white ml-1 text-truncate-width" id="cohostName"
                                                style="font-size: 11px;"></div>
                                        </span>
                                        <span id="cohost-timer" class="text-white ml-xxl-3 mi-1 position-relative d-none"
                                            style="line-height: 12px;">
                                            | <span style="width:30px; position:relative; display:inline-block">
                                                <span class="now playing" id="cohostName-music">
                                                    <span class="bar n1">A</span>
                                                    <span class="bar n2">B</span>
                                                    <span class="bar n4">D</span>
                                                </span>
                                            </span>
                                            <span id="wait-timer"></span>
                                        </span>
                                    </div>



                                    <div
                                        class="playerlist-control-top-right d-flex align-items-center justify-content-center position-absolute">
                                        <span class="text-white ml-1"><i class="fa fa-eye mr-1"></i><span
                                                id="view-count"></span></span>
                                    </div>
                                    <div
                                        class="playerlist-control-top-right-2 d-flex align-items-center justify-content-center position-absolute">
                                        <a href="<?php echo e(route('front.getLiveAstro')); ?>" class="text-white">
                                            <i class="fa-solid fa-arrow-left"></i></a>
                                    </div>


                                    <div id="price-div" class="playerlist-control-bottom-right-price position-absolute">
                                        <a href="javascript:void(0)" data-toggle="modal"
                                            <?php if(!authcheck()): ?> data-toggle="modal" data-target="#loginSignUp"  <?php else: ?> data-target="#CallChatConnect" <?php endif; ?>>
                                            <div class="py-3 text-center position-relative">
                                                <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/livestream/ls_telephone.png')); ?>"
                                                    class="position-absolute" width="55" height="52">
                                            </div>

                                            <span class="d-block text-white px-3 font-weight-bold ">Call Now</span>
                                            <span class="d-block bg-yellow rounded px-3 py-1 colorblack"
                                                id="expertPrice"><span
                                                    class="font-weight-bold d-block"><?php echo e($currency['value']); ?><?php echo e($liveAstrologer->charge); ?>/Min</span>
                                        </a>
                                    </div>

                                    <div
                                        class="playerlist-control-bottom-right-share align-items-center justify-content-center position-absolute d-none">
                                        <div class="btn-group dropleft">
                                            <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                    class="fa fa-share-alt text-white"></i></span>
                                            <div class="dropdown-menu dropdown-menu-right p-0 m-0 mr-2">
                                                <a href=""><i class="fa fa-facebook text-white"></i></a>
                                                <a href=""><i class="fa fa-twitter text-white"></i></a>
                                                <a href=""><i class="fa fa-whatsapp text-white"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="playerlist-control-bottom-right-fav align-items-center justify-content-center position-absolute d-none">
                                        <a href=""><i class="fa fa-heart text-white"></i></a>
                                    </div>
                                </div>


                                <div id="host" class="row d-block h-100">

                                    <div id="hostVideo" class="d-block h-100">
                                        <div class="content h-100" id="remote-playerlists">

                                        </div>
                                    </div>
                                </div>
                                <div id="cohost" class="row d-block h-100">

                                    <div id="coHostVideo">
                                        <div class="content1 h-100" id="content1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="dispMobileChat" class="remote-playerlist-chat m-2 position-relative">
                            <h3 class="font-weight-bold font-24 d-md-block d-none pb-2 border-bottom">CHAT <span
                                    class="color-red">ROOM</span></h3>
                            <div class="log-container position-relative font-14" id="log"
                                style="background:url(<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/livestream/stream-chat-bg.png')); ?>)">



                            </div>
                            <div class="input-field channel-padding d-flex align-items-center justify-content-between">
                                <div class="position-relative w-100">
                                    <input type="text" placeholder="Say Hi...!" autocomplete="off"
                                        class="channel-input" id="channelMessage">

                                </div>
                                <button
                                    class=" btn btn-raised btn-primary waves-effect waves-light ml-2 bg-red d-flex align-items-center justify-content-center"
                                    id="send_channel_message">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                                <a href="javascript:void(0)" data-toggle="modal"
                                    <?php if(!authcheck()): ?> data-target="#loginSignUp" <?php else: ?> data-target="#gift_popup" <?php endif; ?>
                                    class="btn btn-raised btn-primary waves-effect waves-light ml-2 bg-red d-flex align-items-center justify-content-center"
                                    id="send_gift">
                                    <i class="fa-solid fa-gift"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="waitlist-item-htm" class="d-none">

        </div>
        <div class="modal fade rounded modalcenter" id="waitlist">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title text-center w-100 ml-auto font-weight-bold">Waitlist</h4>

                    </div>

                    <!-- Modal body -->
                    <div class="modal-body overflow-auto">
                        <p class="font-weight-bold m-0">In this room</p>
                        <div id="room-item">
                        </div>
                        <div class="text-center">
                            <span class="m-0 text-center text-white playerlist-control-top-right"
                                style=" background: #D8D8D8; color: #000 !important; padding: 1px 10px 2px;border-radius:unset;">Others
                                are waiting</span>
                        </div>
                        <div id="waitlist-items"></div>
                    </div>
                    <div class="modal-footer p-0">
                        <div class="w-100 text-center">
                            <a onclick="joinwaitlist(0);" id="Waitlist-join-wait" class="btn btn-Waitlist">Connect
                                Now</a>
                            <a onclick="LeaveWaitlistConfirm();" id="Waitlist-exit-wait"
                                class="btn btn-Waitlist d-none">Exit Waitlist</a>

                            <p class="font-weight-bold mb-0">Wait time - <span id="waiting-time"
                                    class="color-red">00:00</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade rounded modalcenter" id="CallChatConnect">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <div class="position-relative  text-center w-100">
                            <div class="astro-prfile-section">
                                <div class="bg-white d-inline-block expert-porfile-pic">
                                    <?php if($liveAstrologer->profileImage): ?>
                                    <img id="model-expert-image" class="rounded-circle"
                                        src="/<?php echo e($liveAstrologer->profileImage); ?>" width="90" height="90">
                                        <?php else: ?>
                                        <img id="model-expert-image" class="rounded-circle"
                                        src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>" width="90" height="90">
                                        <?php endif; ?>
                                </div>
                            </div>
                            <h3 class="d-block font-weight-bold font-24" id="model-expert-name">
                                <?php echo e($liveAstrologer->name); ?></h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between py-3">
                            <div class="d-flex align-items-center">
                                <div class="ml-2" style="line-height: 21px;">
                                    <p class="font-16 m-0">To Access More Feautures Download Our App</span>
                                    </p>

                                </div>
                            </div>

                        </div>
                        <div class="d-flex align-items-center justify-content-center py-3">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);"><img
                                        src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/app-store.png')); ?>"
                                        alt="app-store" class="img-fluid" width="143" height="54" loading="lazy">
                                </a>

                                <a href="javascript:void(0);" class="ml-3"><img
                                        src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/google-play.png')); ?>"
                                        alt="google-play" class="img-fluid" width="143" height="54"
                                        loading="lazy">
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade rounded modalcenter" id="connectPopup" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="position-relative  text-center w-100">
                            <div class="astro-prfile-section">
                                <div class="bg-white d-inline-block expert-porfile-pic">
                                    <img id="model-expert-image-confirm" class="rounded-circle"
                                        src="/<?php echo e($liveAstrologer->profileImage); ?>" width="90" height="90">
                                </div>
                            </div>
                            <h3 class="d-block font-weight-bold font-24" id="model-expert-name-confirm">
                                <?php echo e($liveAstrologer->name); ?></h3>
                            <p> is available now for a session.</p>
                        </div>
                    </div>
                    <div class="modal-footer p-0">
                        <div class="w-100 text-center d-flex m-0">
                            <a onclick="LeaveAudioCall(false, false);" class="btn col-3 bg-red text-white"><i
                                    class="fa fa-phone"></i></a>
                            <a onclick="joinwaitlist(1);" class="btn col-9 bg-green text-white"><i
                                    class="fa fa-phone"></i> Start the Call</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade rounded modalcenter" id="endSessionConfirm" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="position-relative  text-center w-100 mt-5">
                            <h2>Confirmation</h2>
                            <p>Are you sure you want to end the current session?</p>
                        </div>
                    </div>
                    <div class="modal-footer p-0">
                        <div class="w-100 text-center d-flex m-0">
                            <a class="btn col-6 bg-red text-white close rounded-0 d-flex align-items-center justify-content-center"
                                data-dismiss="modal">No</a>
                            <a onclick="LeaveAudioCall(true, false);"
                                class="btn col-6 bg-green text-white rounded-0 d-flex align-items-center justify-content-center">Yes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade rounded modalcenter" id="ModelleaveQueue" tabindex="-1" role="dialog"
            aria-labelledby="myModelModelleaveQueue" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body px-0">
                        <div class="position-relative  text-center w-100">
                            <div class=" astro-prfile-section">
                                <div class="bg-white d-inline-block expert-porfile-pic">
                                    <img id="leave-expert-image" class="rounded-circle"
                                        src="/<?php echo e($liveAstrologer->profileImage); ?>" width="90" height="90">
                                </div>
                            </div>
                            <h3 class="d-block font-weight-bold font-24" id="leave-expert-name">
                                <?php echo e($liveAstrologer->name); ?></h3>
                        </div>
                        <div class="bg-pink text-center p-2" style="box-shadow: inset 0px 0px 3px #ffbbbb !important ">
                            <p class="mb-2">Your call will be connected in </p>
                            <p class="mb-0">
                                <span><span id="leave-hh" class="color-red font-weight-bold"
                                        style="font-size:30px;"></span><span>Hrs</span></span>
                                <span><span id="leave-mm" class="color-red font-weight-bold"
                                        style="font-size:30px;"></span><span>Min</span></span>
                                <span><span id="leave-ss" class="color-red font-weight-bold"
                                        style="font-size:30px;"></span><span>Sec</span></span>
                            </p>
                        </div>
                        <div class="text-center py-2">
                            Are you sure you want to leave the waitlist? You will be added at the end of the queue if you
                            join again.
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pb-4">

                        <button type="button" class="btn btn-cancel colorblack px-5 mr-2"
                            data-dismiss="modal">Cancel</button>
                        <a onclick="LeaveWaitlist();" id="join-wait" class="btn btn-Waitlist">Exit Waitlist</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade rounded modalcenter" id="gift_popup" tabindex="-1" aria-labelledby="myModel_gift_popup"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <form id="giftForm">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <!-- Modal body -->
                        <div class="modal-body px-0">
                            <div class="position-relative  text-center w-100">
                                <h3 class="d-block font-weight-bold font-20" id="leave-expert-name">Send a Gift</h3>
                                <div style="box-shadow: inset 0px 0px 3px #ccc !important ">
                                    <h4 class="d-block font-weight-bold  py-2 font-16" id="leave-expert-name">Available
                                        Wallet
                                        Balance <span class="color-red"><?php echo e($currency['value']); ?> <span id="gift-wallet-balance"
                                                class="font-weight-bold"><?php echo e($wallet_amount); ?></span></span></h4>
                                </div>
                            </div>

                            <div class="bg-white text-center p-2">
                                <div id="loadGiftItems" class="loadGiftItems d-flex flex-wrap">
                                    <?php $__currentLoopData = $getGift['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="loadGiftItem d-flex align-items-center justify-content-center rounded"
                                            id="user-gift-8">
                                            <a data-gift-id="<?php echo e($gift['id']); ?>">
                                                <img src="/<?php echo e($gift['image']); ?>" style="width: 60px;height:60px;">
                                                <p style="margin-bottom: 0;" class="gift-name text-nowrap">
                                                    <?php echo e($gift['name']); ?></p><?php echo e($currency['value']); ?> <?php echo e($gift['amount']); ?>

                                            </a>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>



                        </div>

                        <input type="hidden" name="astrologerId" value="<?php echo e($liveAstrologer->astrologerId); ?>">
                        <input type="hidden" name="giftId" value="">
                        <input type="hidden" id="giftAmount" value="<?php echo e($gift['amount']); ?>">
                        <input type="hidden" id="giftName" value="<?php echo e($gift['name']); ?>">




                        <div class="d-flex align-items-center justify-content-center pb-4">
                            <?php if($wallet_amount > 0): ?>
                                <a class="btn btn-Waitlist recharge-gift active"
                                    href="<?php echo e(route('front.walletRecharge')); ?>">Recharge</a>
                                <a id="send-gift" class="btn btn-Waitlist send-gift active">Send</a>
                                <button class="btn btn-Waitlist send-gift active" id="send-giftBtn" type="button"
                                    style="display:none;" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span> Loading...
                                </button>
                            <?php else: ?>
                                <a href="<?php echo e(route('front.walletRecharge')); ?>" id="recharge-gift"
                                    class="btn btn-Waitlist recharge-gift active">Recharge</a>
                                <a class="btn btn-Waitlist send-gift ">Send</a>
                            <?php endif; ?>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('public/frontend/agora/AgoraRTC_N-4.20.2.js')); ?>"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/agora-rtm-sdk@1.3.1/index.js"></script>




    <script>
        $(document).ready(function() {
            $('.loadGiftItem').on('click', function() {
                $('.loadGiftItem').css({
                    'box-shadow': '',
                    'background': ''
                });
                $(this).css({
                    'box-shadow': '0px 3px 6px #EE4E5E33',
                    'background': '#FFF5F6'
                });


                var selectedGiftId = $(this).find('a').attr('data-gift-id');
                $('input[name="giftId"]').val(selectedGiftId);


            });




        });
    </script>

    <script>
        // Rtm Section

        var isLoggedIn = false;
        $("#send_channel_message").prop("disabled", true);

        // Form Click Event
        $(document).ready(function() {

            var accountName = '';
            <?php if(authcheck()): ?>
                var accountName = "liveAstrologer_<?php echo e(authcheck()['id']); ?>";
            <?php endif; ?>

            var agoraAppId = appid;

            var RtmToken = "<?php echo e($RtmToken['rtmToken']); ?>";
            // RtmClient
            const rTmclient = AgoraRTM.createInstance(agoraAppId, {
                enableLogUpload: false
            });

            // Login
            rTmclient.login({
                uid: accountName,
                token: RtmToken,
            }).then(() => {
                console.log('AgoraRTM client login success. Username: ' + accountName);
                isLoggedIn = true;

                // Channel Join
                var channelName = "liveAstrologer_<?php echo e($liveAstrologer->astrologerId); ?>";

                channel = rTmclient.createChannel(channelName);
                // console.log(channel);
                // document.getElementById("channelNameBox").innerHTML = channelName;
                channel.join().then(() => {
                    console.log('AgoraRTM client channel join success.');
                    $("#send_channel_message").prop("disabled", false);

                    sendMSG('Joined!');

                    // Click event handler for sending messages
                    // $("#send_channel_message").click(function() {
                    //     var singleMessage = $('#channelMessage').val();
                    //     sendMSG(singleMessage);
                    // });

                    // $('#channelMessage').keypress((e) => {
                    //     if (e.which === 13) {
                    //         $('#send_channel_message').click();
                    //         var singleMessage = $('#channelMessage').val();
                    //         sendMSG(singleMessage);
                    //     }
                    // });
                    function sendMessageHandler() {
                            var singleMessage = $('#channelMessage').val();
                            sendMSG(singleMessage);
                        }
                        $("#send_channel_message").click(sendMessageHandler);
                    $('#channelMessage').keypress((e) => {
                        if (e.which === 13) {
                            sendMessageHandler();
                        }
                    });

                    // Event listener for receiving messages
                    channel.on('ChannelMessage', (message, senderId) => {

                        var messageParts = message.text.split('&&');
                        var senderName = messageParts[0];
                        var messageContent = messageParts[1];
                        if(messageParts[2]){
                            var imageUrl = messageParts[2];
                        }else{
                            var imageUrl = "<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>";
                        }

                        var senderId = messageParts[4];

                        if (!messageContent.includes("GIF_MSG::"))
                        {
                            // Construct the HTML for the received message
                            var receivedMessageHtml = `
                                        <div class="chatmsg d-flex mb-2" user="${senderId}">
                                            <span class="user-profile-pic">
                                                <img src="${imageUrl}"
                                                    style="width:40px;height:40px; border-radius:50%; margin-right:5px;">
                                            </span>
                                            <span>
                                                <span class="font-weight-bold d-block">${senderName}</span>
                                                <span class="d-block">${messageContent}</span>
                                            </span>
                                        </div>
                                    `;

                            // Append the received message HTML to the log container
                            $("#log").append(receivedMessageHtml);
                        }




                    });


                    function sendMSG(singleMessage) {
                        var accountName = '';
                        var imageUrl = '';
                        <?php if(authcheck()): ?>
                            var accountName = "<?php echo e(authcheck()['name']); ?>";
                            <?php if(authcheck()['profile']): ?>
                            var imageUrl = "<?php echo e(url('/')); ?>" +
                                "/<?php echo e(authcheck()['profile']); ?>";
                            <?php else: ?>{
                                var imageUrl = "<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>";
                            }
                            <?php endif; ?>
                        <?php endif; ?>

                        // Construct the message string with delimiters '&&'
                        var message = accountName + "&&" + singleMessage +
                            "&&" + imageUrl + "&&null&&" + accountName;

                        // Assuming 'channel' is your channel object
                        channel.sendMessage({
                            text: message
                        }).then(() => {
                            // console.log("Message sent successfully.");
                            // console.log("Your message was: " +
                            //     singleMessage + " by " + accountName
                            // );

                            if (!singleMessage.includes("GIF_MSG::"))
                            {
                                // Construct the HTML for the sent message
                                var sentMessageHtml = `
                                    <div class="chatmsg d-flex mb-2" user="${accountName}">
                                        <span class="user-profile-pic">
                                            <img src="${imageUrl}"
                                                style="width:40px;height:40px; border-radius:50%; margin-right:5px;">
                                        </span>
                                        <span>
                                            <span class="font-weight-bold d-block">${accountName}</span>
                                            <span class="d-block">${singleMessage}</span>
                                        </span>
                                    </div>
                                `;
                                // Append the sent message HTML to the log container
                                $("#log").append(sentMessageHtml);
                            }

                            // Clear the message input field
                            $('#channelMessage').val('');
                        }).catch(error => {
                            toastr.error(
                                "Message wasn't sent due to an error: ",
                                error);
                        });
                    }



                    $('#send-gift').click(function(e) {
                e.preventDefault();

                var wallet_amount = "<?php echo e($wallet_amount); ?>";

                var giftAmount = $("#giftAmount").val();
                var giftName = $("#giftName").val();


                if (giftAmount > wallet_amount) {
                    toastr.error('Insufficient balance. Please recharge your wallet.');
                    return false;
                }

                <?php
                    use Symfony\Component\HttpFoundation\Session\Session;
                    $session = new Session();
                    $token = $session->get('token');
                ?>

                $('#send-gift').hide();
                $('#send-giftBtn').show();
                setTimeout(function() {
                    $('#send-gift').show();
                    $('#send-giftBtn').hide();
                }, 5000);


                var formData = $('#giftForm').serialize();


                $.ajax({
                    url: '<?php echo e(route('api.sendGifts', ['token' => $token])); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {

                        var new_wallet_amount = response.wallet_balance.amount;
                        $('#gift-wallet-balance').text(new_wallet_amount);
                        toastr.success('Gift Sent Successfully');
                        sendMSG('GIF_MSG::Sent '+giftName+' Gift 🎁');
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });
            });



                    channel.getMembers().then((value) => {
                        // console.log("Members count: " + value.length);
                        $("#view-count").text(value.length);
                    }).catch(error => {
                        console.error("Error fetching members count: ", error);
                    });



                }).catch(error => {
                    console.log('AgoraRTM client channel join failed: ', error);
                }).catch(err => {
                    console.log('AgoraRTM client login failure: ', err);
                });
            });
        });


        // RtC Section

        var token = "<?php echo e($liveAstrologer->token); ?>";
        var channel = "<?php echo e($liveAstrologer->channelName); ?>";
        var appid = "<?php echo e($agoraAppIdValue); ?>";


        // create Agora client
        var client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });


        var localTracks = {
            videoTrack: null,
            audioTrack: null
        };
        var localTrackState = {
            videoTrackEnabled: true,
            audioTrackEnabled: true
        }
        var remoteUsers = {};
        // Agora client options
        var options = {
            appid: appid,
            channel: channel,
            uid: null,
            token: token,
            role: "audience"
        };



        $("#audience-join").click(function(e) {
            options.role = "audience";
        })

        options.role = "audience";


        $(document).ready(async function() {

            await join();


        });

        $("#leave").click(function(e) {
            leave();
        })

        async function join() {
            // create Agora client
            client.setClientRole(options.role);
            $("#mic-btn").prop("disabled", false);
            $("#video-btn").prop("disabled", false);
            if (options.role === "audience") {
                $("#mic-btn").prop("disabled", true);
                $("#video-btn").prop("disabled", true);
                // add event listener to play remote tracks when remote user publishs.
                client.on("user-published", handleUserPublished);
                client.on("user-joined", handleUserJoined);
                client.on("user-left", handleUserLeft);
            }
            // join the channel
            options.uid = await client.join(options.appid, options.channel, options.token);

        }

        async function leave() {
            for (trackName in localTracks) {
                var track = localTracks[trackName];
                if (track) {
                    track.stop();
                    track.close();
                    $('#mic-btn').prop('disabled', true);
                    $('#video-btn').prop('disabled', true);
                    localTracks[trackName] = undefined;
                }
            }
            // remove remote users and player views
            remoteUsers = {};
            $("#remote-playerlists").html("");
            // leave the channel
            await client.leave();
            $("#local-player-name").text("");
            $("#host-join").attr("disabled", false);
            $("#audience-join").attr("disabled", false);
            $("#leave").attr("disabled", true);
            hideMuteButton();
            console.log("Client successfully left channel.");
        }

        async function subscribe(user, mediaType) {
            const uid = user.uid;
            // subscribe to a remote user
            await client.subscribe(user, mediaType);
            // console.log("Successfully subscribed.");
            if (mediaType === 'video') {


                const player = $(`
                <div id="player-${uid}" class="player d-inline"></div>
            `);

                $("#remote-playerlists").append(player);
                user.videoTrack.play(`player-${uid}`);
            }
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        }

        // Handle user published
        function handleUserPublished(user, mediaType) {
            const id = user.uid;
            remoteUsers[id] = user;
            subscribe(user, mediaType);
        }

        function handleBroadcastEnd() {
            window.location.href = "<?php echo e(route('front.getLiveAstro')); ?>";
        }


        // Handle user joined
        function handleUserJoined(user, mediaType) {
            const id = user.uid;
            remoteUsers[id] = user;
            subscribe(user, mediaType);


        }

        // Handle user left
        function handleUserLeft(user) {
            const id = user.uid;
            delete remoteUsers[id];
            $(`#player-wrapper-${id}`).remove();


            if (Object.keys(remoteUsers).length === 0) {
                handleBroadcastEnd();
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8212\htdocs\resources\views/frontend/pages/live-astrologer-details.blade.php ENDPATH**/ ?>