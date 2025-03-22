@extends('frontend.astrologers.layout.master')

<style>
    .rounded {
        border: 1px solid #e4e5e6;
        border-radius: 10px !important;
    }

    .attachment-icon {
        cursor: pointer;
    }

    .attachment-icon i {
        padding: 10px;
        color: #aaa;
    }

    .attachment-icon:hover i {
        color: #333;
    }

    .chat-message-right {
        max-width: 70% !important;
    }

    .chat-message-left {
        max-width: 70% !important;
    }
</style>

@section('content')
    @if (astroauthcheck())
        @php
            $userId = request()->query('partnerId');
            $astrologerId = astroauthcheck()['astrologerId'];
            $chatId = request()->query('chatId');

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
                            <i class="fa fa-chevron-right"></i> <span
                                class="breadcrumbtext">Chat</span>
                        </span>

                    </span>

                </div>
            </div>
        </div>
    </div>

    <main class="content">
        <div class="container p-0">

            <h1 class="h3 mb-3 mt-4 ml-4">Chat</h1>

            <div class="card ">
                <div class="row g-0">

                    <div class="col-12 col-lg-12 col-xl-12">

                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    @if($getUser['recordList'][0]['profile'])
                                    <img src="/{{ $getUser['recordList'][0]['profile'] }}"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    @else
                                    <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png') }}"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    @endif
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong>{{ $getUser['recordList'][0]['name'] ?? 'User' }}
                                    </strong>
                                    {{-- <div class="text-muted small"><i>100 seconds</i></div> --}}
                                </div>

                                <div id="timerContainer">
                                    <div class="text-muted small">
                                        <span id="statusText">Waiting to Join</span>
                                        <span id="remainingTime" class="color-red" style="display: none;"></span>
                                        <button class="btn view-more" id="endChat">End</button>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="position-relative">
                            <div class="chat-messages p-4">

                            </div>

                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <label for="fileInput" class="attachment-icon">
                                            <input type="file" id="fileInput" class="d-none"> <!-- Hidden file input -->
                                            <i class="fas fa-paperclip"></i> <!-- Attachment icon -->
                                        </label>
                                    </div>
                                    <input type="text" id="fileDisplay" class="form-control" placeholder="Choose a file">
                                    <button class="btn btn-chat">Send</button>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection


@section('scripts')
    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            const fileInput = this;
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
            document.getElementById('fileDisplay').value = fileName;
        });

        var userId = "{{ $userId }}";
        var astrologerId = "{{ $astrologerId }}";



        const firestore = firebase.firestore();

        // Function to send a message
        function sendMessage(senderId, receiverId, message, isEndMessage, attachementPath) {
            const chatRef = firestore.collection('chats').doc(`${senderId}_${receiverId}`).collection('userschat').doc(
                senderId).collection('messages');
            const timestamp = new Date();
            // Generate a unique ID for the message
            const messageId = chatRef.doc().id;

            chatRef.doc(messageId).set({
                    id: null,
                    createdAt: timestamp,
                    invitationAcceptDecline: null,
                    isDelete: false,
                    isEndMessage: isEndMessage,
                    isRead: false,
                    messageId: messageId,
                    reqAcceptDecline: null,
                    status: null,
                    updatedAt: timestamp,
                    url: null,
                    userId1: senderId,
                    userId2: receiverId,
                    message: message,
                    attachementPath: attachementPath, // Pass attachementPath to the message object
                })
                .then(() => {
                    // console.log("Message sent with ID: ", messageId);
                })
                .catch((error) => {
                    console.error("Error sending message: ", error);
                });
        }

        $(document).ready(function() {
            $(document).on('click', '.btn-chat', function() {
                // console.log('Button clicked');

                const messageInput = $(this).closest('.input-group').find('.form-control');
                // console.log('Input field value:', messageInput.val());

                const message = messageInput.val().trim();
                // console.log('Trimmed message:', message);

                const fileInput = $(this).closest('.input-group').find('#fileInput')[0];
                const file = fileInput.files[0]; // Get the selected file

                if (message !== '' || file) { // Check if message or file is not empty
                    console.log('Message or file is not empty');

                    // Check if file is present, if so, upload it to Firebase Storage
                    if (file) {
                        const storageRef = firebase.storage().ref();
                        const fileName = `${astrologerId}_${userId}/${file.name}`;
                        const fileRef = storageRef.child(fileName);

                        fileRef.put(file).then((snapshot) => {
                            console.log('File uploaded successfully');
                            snapshot.ref.getDownloadURL().then((downloadURL) => {
                                // console.log('File download URL:', downloadURL);
                                // Send the message as null when a file is attached
                                sendMessage(astrologerId, userId, null, false,
                                    downloadURL); // Pass download URL to sendMessage
                                messageInput.val('');
                                fileInput.value = ''; // Clear file input after sending
                            });
                        }).catch((error) => {
                            console.error('Error uploading file:', error);
                        });

                    } else {
                        // If no file, simply send the message
                        sendMessage(astrologerId,userId, message, false,
                            ''); // Pass empty string as attachment path
                        messageInput.val('');
                    }
                } else {
                    toastr.error('Message and file are empty');
                }
            });
        });







        function fetchAndRenderMessages(receiverId, senderId) {
            const senderChatRef = firestore.collection('chats').doc(`${receiverId}_${senderId}`).collection('userschat')
                .doc(receiverId).collection('messages');

            senderChatRef.orderBy('createdAt', 'asc').onSnapshot(snapshot => {
                snapshot.docChanges().forEach(change => {
                    if (change.type === 'added') {
                        const message = change.doc.data();
                        renderMessage(message, receiverId);
                    }
                });
            });
        }



        function renderMessage(message, receiverId) {
            const chatMessagesContainer = document.querySelector('.chat-messages');
            const isScrolledToBottom = chatMessagesContainer.scrollHeight - chatMessagesContainer.clientHeight <=
                chatMessagesContainer.scrollTop + 1;

            const messageElement = document.createElement('div');
            messageElement.classList.add('chat-message');

            const timestamp = message.createdAt.toDate();
            const formattedTime = timestamp.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit'
            });



            var newupdateTime = new Date("{{ $chatrequest->updated_at }}").toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
            var newtimestamp = timestamp.toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
            @if(astroauthcheck()['profile'])
                var astroprofile = "/{{ astroauthcheck()['profile']}}";
            @else
                var astroprofile = "{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png') }}";
            @endif

            @if($getUser['recordList'][0]['profile'])
            var userprofile="/{{$getUser['recordList'][0]['profile']}}";
            @else
            var userprofile="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png') }}";
            @endif

            if (message.isEndMessage == true) {
                messageElement.innerHTML = `
            <div class="chat-message chat-message-center d-flex m-3" style="justify-content: center;">
                <div class="color-red bg-pink rounded-pill border py-1 px-3 mr-3 mb-2 text-center" style="width: 60%;">
                    ${message.message}
                </div>
            </div>`;
            } else if (message.userId1 != receiverId) {
                // Message sent by the receiver, render on the left side
                messageElement.classList.add('chat-message-left');
                messageElement.innerHTML = `
        <div>
            <img src="${userprofile}" class="rounded-circle mr-1" alt="Sender" width="40" height="40">
            <div class="text-muted small text-nowrap mt-2">${formattedTime}</div>
        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3 mb-2">
            <div class="font-weight-bold mb-1">{{ $getUser['recordList'][0]['name'] }}</div>
            ${message.attachementPath ? renderAttachment(message.attachementPath) : `<p>${message.message}</p>`}
        </div>`;

            } else {
                // Message sent by the sender, render on the right side
                messageElement.classList.add('chat-message-right');
                messageElement.innerHTML = `
            <div>
                <img src="${astroprofile}" class="rounded-circle mr-1" alt="You" width="40" height="40">
                <div class="text-muted small text-nowrap mt-2">${formattedTime}</div>
            </div>
            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3 mb-2">
                <div class="font-weight-bold mb-1">You</div>
                ${message.attachementPath ? renderAttachment(message.attachementPath) : `<p>${message.message}</p>`}
            </div>`;
            }





            chatMessagesContainer.appendChild(messageElement);

            if (isScrolledToBottom) {
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }
        }


        // Function to render attachment based on its type
        function renderAttachment(attachementPath) {
            if (!attachementPath) return ''; // No attachment provided

            return `<img src="${attachementPath}" style="max-height:250px;" alt="Attachment" class="img-fluid">`;


        }

        // Function to check if a URL points to an image
        function isImage(url) {
            return /\.(jpeg|jpg|gif|png)$/i.test(url);
        }


        document.addEventListener('DOMContentLoaded', function() {
            fetchAndRenderMessages(astrologerId, userId);
        });
    </script>

<script>
  $(document).ready(function() {
        let timer;
        let timerStarted = false;

        var updateTime = new Date("{{ $chatrequest->updated_at }}").getTime();
        var chatDuration = {{ $chatrequest->chat_duration }};
        // var currentTime = new Date().getTime();
        // var elapsedTime = Math.floor((currentTime - updateTime) / 1000);
        // var remainingTime = chatDuration - elapsedTime;
        let currentTime = remainingTime = elapsedTime='';

         $.get("{{ route('front.getDateTime') }}", function(response) {
            // Assuming the response contains the server time in 'Y-m-d H:i:s' format
            currentTime = new Date(response).getTime();

            // Calculate elapsed time and remaining time
            let elapsedTime = Math.floor((currentTime - updateTime) / 1000);
            remainingTime = chatDuration - elapsedTime;

            // Ensure remainingTime is not negative
            if (remainingTime < 0) {
                remainingTime = 0;
            }



        }).fail(function() {
            console.error("Error fetching server time");
        });

        function updateTimer() {
            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;
            var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            document.getElementById('remainingTime').innerHTML = formattedTime + '&nbsp;&nbsp;&nbsp;';
        }

        function startTimer() {
            if (timerStarted) return;
            timerStarted = true;

            $('#statusText').text('Remaining :');
            $('#remainingTime').show();

            timer = setInterval(function() {
                remainingTime--;
                if (remainingTime < 0) {
                    remainingTime = 0;
                    clearInterval(timer);
                    alert('Chat time is over');
                    sendMessage(astrologerId, userId, "{{ astroauthcheck()['name'] }} -> Chat Ended", true, null);
                        setTimeout(function() {
                            window.location.href = "{{ route('front.astrologerindex') }}";
                        }, 2000);
                }
                updateTimer();
            }, 1000);
        }

        function checkChatStatus() {
            $.ajax({
                url: '/astrologer/check-chat-status', // Adjust the URL as necessary
                method: 'GET',
                data: { chatId: '{{ $chatId }}' },
                success: function(response) {
                    if (response.chatStatus === 'Confirmed' && remainingTime > 0 && !timerStarted) {
                        startTimer();
                    } else if (response.chatStatus === 'Completed') {
                        clearInterval(timer);
                        timerStarted = false;

                        $('#statusText').text('Remaining :');
                        $('#remainingTime').text('00:00');
                        $('#remainingTime').show();

                        setTimeout(function() {
                            window.location.href = "{{ route('front.astrologerindex') }}";
                        }, 2000);
                    } else if (response.chatStatus !== 'Confirmed') {
                        $('#statusText').text('Waiting to Join');
                        $('#remainingTime').hide();
                        clearInterval(timer);
                        timerStarted = false;
                    }
                }
            });
        }

        setInterval(checkChatStatus, 3000); // Check every 3 seconds
        updateTimer();
    });

    $('#endChat').click(function(e) {
        window.location.href = "{{ route('front.astrologerindex') }}";
        sendMessage(astrologerId, userId, "{{ astroauthcheck()['name'] }} -> Chat Ended", true, null);
    });
</script>



@endsection
