<link rel="stylesheet" href="<?php echo e(asset('public/frontend/agora/index.css')); ?>">
<style>
    #local-player div:first-child ,#remote-playerlist div:nth-child(3){
        min-height:150px !important;
        position: unset !important;
    }

</style>

<?php $__env->startSection('content'); ?>
    <?php if(authcheck()): ?>
        <?php
            $userId = authcheck()['id'];
            $astrologerId = request()->query('astrologerId');
            $callId = request()->query('callId');
            $call_type = request()->query('call_type');
        ?>
    <?php endif; ?>

    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">

                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.home')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <span class="breadcrumbtext">Call</span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <input id="appid" type="hidden" placeholder="enter appid" value="<?php echo e($agoraAppIdValue); ?>">
    <input id="token" type="hidden" placeholder="enter token" value="<?php echo e($callrequest->token); ?>">
    <input id="channel" type="hidden" placeholder="enter channel name" value="<?php echo e($callrequest->channelName); ?>">

    <section class="container">
        <div class=" row">
            <div class="col-md-2 col-sm-12 order-md-0 order-2 bottom-sm-0 bottom-buttons">
                <div class="navigation flex-sm-column h-100">
                    <span id="remainingTime" class="color-red"><?php echo e($callrequest->call_duration); ?></span>
                    <button class="video-action-button mic" onclick="toggleMic()" id="mic-icon">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <?php if($call_type==11): ?>
                    <button class="video-action-button camera" onclick="toggleVideo()" id="video-icon">
                        <i class="fas fa-video"></i>
                    </button>
                    <?php endif; ?>

                    <button class="video-action-button maximize">
                        <i class="fa-solid fa-expand"></i>
                    </button>
                    <form id="endCallForm" class="d-inline-block">
                        <input type="hidden" name="callId" value="<?php echo e($callId); ?>">
                        <input type="hidden" name="totalMin" id="totalMin" value="">
                        <button class="video-action-button endcall" id="leave">Leave</button>
                    </form>

                    <div class="video-call-actions ">
                    </div>
                </div>
            </div>
            <div class="app-main col-md-9 col-sm-12 order-sm-0">
                <div class="video-call-wrapper shadow">
                    <div class="video-participant">
                        <div class="participant-actions">
                            
                        </div>

                        <a href="javascript:void(0);" class="name-tag" id="local-player-name">Mayank Sharma</a>
                        <div id="local-player" class="player"></div>
                        <?php if(authcheck()['profile']): ?>
                        <img src="/<?php echo e(authcheck()['profile']); ?>" alt="participant">
                        <?php else: ?>
                        <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>" alt="participant">
                        <?php endif; ?>
                    </div>
                    <div class="video-participant">
                        <div class="participant-actions">
                            
                        </div>
                        <a href="javascript:void(0);" class="name-tag" id="remote-player-name">Guru Parmanand</a>
                        <div id="remote-playerlist"></div>
                        <?php if($getAstrologer['recordList'][0]['profileImage']): ?>
                        <img src="/<?php echo e($getAstrologer['recordList'][0]['profileImage']); ?>" alt="participant">
                        <?php else: ?>
                        <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>" alt="participant">
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('button.mode-switch').click(function() {
                $('body').toggleClass('dark');
            });

            $(".btn-close-right").click(function() {
                $(".right-side").removeClass("show");
                $(".expand-btn").addClass("show");
            });

            $(".expand-btn").click(function() {
                $(".right-side").addClass("show");
                $(this).removeClass("show");
            });
        });
    </script>
    <script src="<?php echo e(asset('public/frontend/agora/AgoraRTC_N-4.20.2.js')); ?>"></script>
    <script src="<?php echo e(asset('public/frontend/agora/index.js')); ?>"></script>

    <script>
       var updateTime = new Date("<?php echo e($callrequest->updated_at); ?>").getTime();
        var callDuration = <?php echo e($callrequest->call_duration); ?>;

        let currentTime = remainingTime = elapsedTime='';
        $.get("<?php echo e(route('front.getDateTime')); ?>", function(response) {
            // Assuming the response contains the server time in 'Y-m-d H:i:s' format
            currentTime = new Date(response).getTime();

            // Calculate elapsed time and remaining time
            let elapsedTime = Math.floor((currentTime - updateTime) / 1000);
            remainingTime = callDuration - elapsedTime;
            // Ensure remainingTime is not negative
            if (remainingTime < 0) {
                remainingTime = 0;
            }
        // startTimer();

        }).fail(function() {
            console.error("Error fetching server time");
        });

        // var currentTime = new Date().getTime();
        // var elapsedTime = Math.floor((currentTime - updateTime) / 1000);
        // var remainingTime = callDuration - elapsedTime;

        $("#local-player-name").text("<?php echo e(authcheck()['name']); ?>");
        $("#remote-player-name").text("<?php echo e($getAstrologer['recordList'][0]['name']); ?>");

        function updateTimer() {
            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;

            var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

            document.getElementById('remainingTime').innerHTML = formattedTime;
        }

        // Update the timer every second
        updateTimer();
        var timerInterval = setInterval(function() {
            remainingTime--;
            if (remainingTime < 0) {
                remainingTime = 0;

            }
            updateTimer();

            if (remainingTime <= 0) {
                endCall();
                clearInterval(timerInterval);

            }

            var totalSeconds = callDuration - remainingTime;


            $("#leave").prop("disabled", true);
            if (totalSeconds >= 60) {
                $("#leave").prop("disabled", false);
            }

        }, 1000);




        let callEnded = false;

    function endCall() {
        if (callEnded) {
            return;
        }
        callEnded = true;

        <?php
            use Symfony\Component\HttpFoundation\Session\Session;
            $session = new Session();
            $token = $session->get('token');
        ?>

        var totalSeconds = callDuration - remainingTime;
        $("#totalMin").val(totalSeconds);

        var formData = $('#endCallForm').serialize();

        $.ajax({
            url: "<?php echo e(route('api.endCall', ['token' => $token])); ?>",
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Call Ended Successfully');
                window.location.href = "<?php echo e(route('front.home')); ?>";
            },
            error: function(xhr, status, error) {
                toastr.error(xhr.responseText);
            }
        });
    }

    $(window).on('beforeunload', function () {
        if (!callEnded) {
                endCall();
            }

    });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/callpage.blade.php ENDPATH**/ ?>