@extends('frontend.astrologers.layout.master')

<link rel="stylesheet" href="{{ asset('public/frontend/agora/index.css') }}">
<style>
    @media only screen and (max-width: 767px) {
     #local-player div:first-child,
     #remote-playerlist div:first-child {
         min-height: 0px !important;
         position: unset !important;
     }
 }


 </style>

@section('content')
    @if (astroauthcheck())
        @php
            $userId = $callrequest->userId;
            $astrologerId = astroauthcheck()['astrologerId'];
            $callId = request()->query('callId');
            $call_type = request()->query('call_type');
        @endphp
    @endif

    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">

                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="{{ route('front.astrologerindex') }}" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <span class="breadcrumbtext">Call</span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <input id="appid" type="hidden" placeholder="enter appid" value="{{ $agoraAppIdValue->value }}">
    <input id="token" type="hidden" placeholder="enter token" value="{{ $callrequest->token }}">
    <input id="channel" type="hidden" placeholder="enter channel name" value="{{ $callrequest->channelName }}">

    <section class="container">
        <div class=" row">
            <div class="col-md-2 col-sm-12 order-md-0 order-2 bottom-sm-0 bottom-buttons">
                <div class="navigation flex-sm-column h-100">
                    <span id="remainingTime" class="color-red">{{ $callrequest->call_duration }}</span>
                    <button class="video-action-button mic" onclick="toggleMic()" id="mic-icon">
                        <i class="fas fa-microphone"></i>
                    </button>
                    @if($call_type==11)
                    <button class="video-action-button camera" onclick="toggleVideo()" id="video-icon">
                        <i class="fas fa-video"></i>
                    </button>
                    @endif

                    <button class="video-action-button maximize">
                        <i class="fa-solid fa-expand"></i>
                    </button>

                    <button class="video-action-button endcall" id="leave">Leave</button>


                    <div class="video-call-actions ">
                    </div>
                </div>
            </div>
            <div class="app-main col-md-9 col-sm-12 order-sm-0">
                <div class="video-call-wrapper shadow">
                    <div class="video-participant">
                        <div class="participant-actions">
                            {{-- <button class="btn-mute"></button>
                            <button class="btn-camera"></button> --}}
                        </div>

                        <a href="javascript:void(0);" class="name-tag" id="local-player-name"></a>
                        <div id="local-player" class="player"></div>
                        @if (astroauthcheck()['profile'])
                            <img src="/{{ astroauthcheck()['profile'] }}" alt="participant">
                        @else
                            <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png') }}"
                                alt="participant">
                        @endif
                    </div>
                    <div class="video-participant">
                        <div class="participant-actions">
                            {{-- <button class="btn-mute"></button>
                            <button class="btn-camera"></button> --}}
                        </div>
                        <a href="javascript:void(0);" class="name-tag" id="remote-player-name"></a>
                        <div id="remote-playerlist"></div>
                        @if ($getUser['recordList'][0]['profile'])
                            <img src="/{{ $getUser['recordList'][0]['profile'] }}" alt="participant">
                        @else
                            <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png') }}"
                                alt="participant">
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@section('scripts')
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

        function endCall() {
            toastr.success('Call Ended Successfully');
            window.location.href = "{{ route('front.astrologerindex') }}";
        }
    </script>
    <script src="{{ asset('public/frontend/agora/AgoraRTC_N-4.20.2.js') }}"></script>
    <script src="{{ asset('public/frontend/agora/index.js') }}"></script>


    <script>
        $(document).ready(function() {
            var callDuration = {{ $callrequest->call_duration }};
            var timerInterval;
            var statusCheckInterval;

            $("#local-player-name").text("{{ astroauthcheck()['name'] }}");
            $("#remote-player-name").text("{{ $getUser['recordList'][0]['name'] }}");

            function fetchCallStatus() {
                $.ajax({
                    url: '{{ route('front.callStatus', ['callId' => $callrequest->id]) }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.call.callStatus === 'Confirmed') {
                            var updateTime = new Date(response.call.updated_at)
                        .getTime(); // Use updated_at from the response
                            startTimer(updateTime);
                            clearInterval(statusCheckInterval);
                        }
                    }
                });
            }

            function startTimer(updateTime) {
                // var currentTime = new Date().getTime();
                // var elapsedTime = Math.floor((currentTime - updateTime) / 1000);
                // var remainingTime = callDuration - elapsedTime;
                let currentTime = remainingTime = elapsedTime='';
                $.get("{{ route('front.getDateTime') }}", function(response) {
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

                function updateTimer() {
                    var minutes = Math.floor(remainingTime / 60);
                    var seconds = remainingTime % 60;

                    var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') +
                        seconds;
                    document.getElementById('remainingTime').innerHTML = formattedTime;
                }

                // Initial display
                updateTimer();

                timerInterval = setInterval(function() {
                    remainingTime--;
                    if (remainingTime < 0) {
                        remainingTime = 0;
                    }
                    updateTimer();

                    if (remainingTime <= 0) {
                        endCall();
                        clearInterval(timerInterval);
                    }
                }, 1000);
            }


            // Initial status check
            fetchCallStatus();
            // Check the status every second
            statusCheckInterval = setInterval(fetchCallStatus, 2000);

            // Initial display of remaining time
            document.getElementById('remainingTime').innerHTML = formatTime(callDuration);

            function formatTime(seconds) {
                var minutes = Math.floor(seconds / 60);
                seconds = seconds % 60;
                return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            }
        });
    </script>
@endsection
