<style>
    .card {
        border: 2px solid #ffd70085 !important;
        overflow: hidden;
        /* width: max-content; */
    }

    .card-body {

        background: #ffd7001f;
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
    }

    .status {
        gap: 4%;
        display: flex;
    }

    .status {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .nodata{
    color: #DFDCC9;
    font-size: 25px;
    }
    .astrorequests{
        overflow-y: auto;
         max-height: 400px;
         min-height:200px;
         height: 400px;
    }



</style>
<?php $__env->startSection('content'); ?>
<?php
     use Symfony\Component\HttpFoundation\Session\Session;
?>

<div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
    <div class="container">
        <div class="row afterLoginDisplay">
            <div class="col-md-12 d-flex align-items-center">
                <span style="text-transform: capitalize; ">
                    <span class="text-white breadcrumbs">
                        <a href="<?php echo e(route('front.astrologerindex')); ?>" style="color:white;text-decoration:none">
                            <i class="fa fa-home font-18"></i>
                        </a>
                        <i class="fa fa-chevron-right"></i> Astrologer

                    </span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row p-3">
        <div class="col-12 mb-4">
            <h2 class="cat-heading-match font-weight-bold text-center">Explore Your Path with Astrology</h2>
            <div>
                <p class="pt-3 text-center">Explore the mysteries of the zodiac, uncover your birth chart's secrets, and navigate planetary alignments.</p>
                <p class="text-center ">Delve into the intricate tapestry of astrology with personalized horoscopes, insightful birth charts, and transformative guidance. Explore the mysteries of the stars and unlock the secrets of your destiny.</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card m-1 px-0">
                <div class="card-body text-center py-3">
                    <span class="card-title">Chat Request</span>
                </div>
                <ul class="list-group list-group-flush astrorequests"  id="chatRequests">

                    <?php if(isset($getChatRequest['recordList']) && count($getChatRequest['recordList']) > 0): ?>
                    <?php $__currentLoopData = $getChatRequest['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <form action="" id="chatForm">
                        <li class="list-group-item d-flex justify-content-center align-items-center">
                            <input type="hidden" name="chatId" id="chatId" value="<?php echo e($request['chatId']); ?>">
                            <input type="hidden" name="partnerId" id="partnerId" value="<?php echo e($request['userId']); ?>">
                            <input type="hidden" name="userId" id="userId" value="<?php echo e($request['astrologerId']); ?>">
                            <div class="d-flex justify-content-between">
                                <div class="w-25 pr-1">
                                    <?php if($request['profile']): ?>
                                    <img src="/<?php echo e($request['profile']); ?>" class="rounded-circle img-fluid" alt="Avatar">
                                    <?php else: ?>
                                    <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>" class="rounded-circle img-fluid" alt="Avatar">
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex flex-column">
                                    <span><?php echo e($request['name']); ?></span>
                                    <div class="d-flex">
                                        <i class="fa fa-calendar mt-1" aria-hidden="true"></i>&nbsp;<span><?php echo e(date('d-m-Y', strtotime($request['chatcreatedat']))); ?></span>
                                    </div>
                                </div>
                                <div class="status">
                                    <a class="bg-light-success text-dark border border-success px-3 py-2 acceptchat">Accept</a>
                                    <a class="badge bg-light-danger text-dark border border-danger px-3 py-2 rejectchat">Reject</a>
                                </div>
                            </div>
                        </li>
                    </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <li class="list-group-item d-flex justify-content-center align-items-center h-100">
                        <div class="d-flex justify-content-between">
                        <p class="text-center card-title nodata">No Record Found !</p>
                        </div>
                    </li>
                <?php endif; ?>

                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card m-1 px-0">
                <div class="card-body text-center py-3">
                    <span class="card-title">Call Request</span>
                </div>
                <ul class="list-group list-group-flush astrorequests"  id="callRequests">
                    <?php if(isset($getCallRequest['recordList']) && count($getCallRequest['recordList']) > 0): ?>
                    <?php $__currentLoopData = $getCallRequest['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <form  id="callForm">
                        <li class="list-group-item d-flex justify-content-center align-items-center">
                            <input type="hidden" name="callId" id="callId" value="<?php echo e($request['callId']); ?>">
                            <input type="hidden" name="partnerId" id="partnerId" value="<?php echo e($request['userId']); ?>">
                            <input type="hidden" name="userId" id="userId" value="<?php echo e($request['astrologerId']); ?>">
                            <input type="hidden" id="call_type" name="call_type" value="<?php echo e($request['call_type']); ?>">
                            <div class="d-flex justify-content-between">
                                <div class="w-25 pr-1">
                                    <?php if($request['profile']): ?>
                                    <img src="/<?php echo e($request['profile']); ?>" class="rounded-circle img-fluid" alt="Avatar">
                                    <?php else: ?>
                                    <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>" class="rounded-circle img-fluid" alt="Avatar">
                                    <?php endif; ?>                                </div>
                                <div class="d-flex flex-column">
                                    <span><?php echo e($request['name']); ?></span>
                                    <div class="d-flex">
                                        <i class="fa fa-calendar mt-1" aria-hidden="true"></i>&nbsp;<span><?php echo e(date('d-m-Y', strtotime($request['callcreatedat']))); ?></span>
                                    </div>
                                    <?php if($request['call_type']==10): ?>
                                    <div class="d-flex">
                                        <i class="fa-solid fa-phone mt-1"></i>&nbsp;<span>Audio Call</span>
                                    </div>
                                    <?php else: ?>
                                    <div class="d-flex">
                                        <i class="fas fa-video mt-1"></i>&nbsp;<span>Video Call</span>
                                    </div>
                                    <?php endif; ?>

                                </div>
                                <div class="status">
                                    <a class="badge bg-light-success text-dark border border-success px-3 py-2 acceptcall">Accept</a>
                                    <a class="badge bg-light-danger text-dark border border-danger px-3 py-2 rejectcall" >Reject</a>
                                </div>
                            </div>
                        </li>
                    </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <li class="list-group-item d-flex justify-content-center align-items-center h-100">
                        <div class="d-flex justify-content-between">
                        <p class="text-center card-title nodata">No Record Found !</p>
                        </div>
                    </li>
                <?php endif; ?>


                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card m-1 px-0">
                <div class="card-body text-center py-3">
                    <span class="card-title">Report Request</span>
                </div>
                <ul class="list-group list-group-flush astrorequests" id="reportRequests">
                    <?php if(isset($getUserReport['recordList']) && count($getUserReport['recordList']) > 0): ?>
                    <?php $__currentLoopData = $getUserReport['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getUserReport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                    <span class="text-dark font-weight-bold ml-2"><?php echo e($getUserReport['reportType']); ?></span>
                    </div>
                    <li class="list-group-item d-flex justify-content-center align-items-center reportList"
                    data-toggle="modal" data-target="#reportModal" data-id="<?php echo e($getUserReport['id']); ?>" style="cursor: pointer;">
                        <div class="d-flex justify-content-between">
                            <div class="w-25 pr-1">
                                <img src="/<?php echo e($getUserReport['profile']); ?>" class="rounded-circle img-fluid" alt="Avatar">
                            </div>
                            <div class="d-flex flex-column">
                                <span><?php echo e($getUserReport['firstName']); ?> <?php echo e($getUserReport['lastName']); ?></span>
                                <div class="d-flex">
                                    <i class="fa fa-calendar mt-1 " aria-hidden="true"></i>&nbsp;<span><?php echo e(date('d-m-Y', strtotime($getUserReport['birthDate']))); ?></span>
                                </div>
                                <div class="d-flex">
                                <i class="fa fa-clock mt-1"></i>&nbsp;<span><?php echo e($getUserReport['birthTime']); ?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <li class="list-group-item d-flex justify-content-center align-items-center h-100">
                        <div class="d-flex justify-content-between">
                        <p class="text-center card-title nodata">No Record Found !</p>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 0px;">
                <h3 class="modal-title" id="reportModalLabel">Report Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reportForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- User details and file upload form elements will be populated here -->
                </div>
                <div class="modal-footer "style="border-top : 0px;">
                    <button type="submit" style="font-weight: 600;" class="btn btn-warning">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>


<script>

    // ------------------------------------Chat Section----------------------------------------------------------------------
    $(document).on('click','.acceptchat',function(e) {
            e.preventDefault();

            <?php
                $session = new Session();
                $token = $session->get('astrotoken');
                $astrologerId=astroauthcheck()['astrologerId'];
            ?>

            var form = $(this).closest('form');
            var formData = form.serialize();

            var astrologerId="<?php echo e(astroauthcheck()['astrologerId']); ?>";


            var chatId = formData.split("chatId=")[1];
            chatId = parseInt(chatId, 10);

            var partnerId = formData.split("partnerId=")[1];
            partnerId = parseInt(partnerId, 10);





            $.ajax({
                url: "<?php echo e(route('api.insertChatRequest', ['token' => $token,'astrologerId' =>$astrologerId])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                      $.ajax({
                            url: "<?php echo e(route('api.acceptChatRequest', ['token' => $token])); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                 console.log(response);
                                toastr.success('Chat Started Successfully..Wait');
                                window.location.href = "<?php echo e(route('front.astrologerchat')); ?>" + "?partnerId=" +
                                partnerId + "&chatId=" + chatId;
                            },
                            error: function(xhr, status, error) {
                                toastr.error(xhr.responseText);
                            }
                        });

                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });

        // Reject Chat

        $(document).on('click','.rejectchat',function(e) {
            e.preventDefault();

            <?php
                $token = $session->get('astrotoken');
            ?>

            var form = $(this).closest('form');
            var formData = form.serialize();

            $.ajax({
                url: "<?php echo e(route('api.rejectChatRequest', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Chat Rejected Successfully.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });

</script>



<script>

        $(document).on('click','.acceptcall',function(e) {
            e.preventDefault();

            <?php
                $session = new Session();
                $token = $session->get('astrotoken');
                $astrologerId=astroauthcheck()['astrologerId'];
            ?>

            var form = $(this).closest('form');
            var formData = form.serialize();

            var astrologerId="<?php echo e(astroauthcheck()['astrologerId']); ?>";


            var callId = formData.split("callId=")[1];
            callId = parseInt(callId, 10);

            var partnerId = formData.split("partnerId=")[1];
            partnerId = parseInt(partnerId, 10);
            var call_type = formData.split("call_type=")[1];
            partnerId = parseInt(call_type, 10);



            $.ajax({
                url: "<?php echo e(route('api.acceptCallRequest', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {

                    toastr.success('Please wait...');
                    $.ajax({
                        url: '<?php echo e(route("api.generateRtcToken")); ?>',
                        type: 'POST',
                        data: {
                            appID: '<?=$agoraAppIdValue->value; ?>',
                            appCertificate: '<?=$agorcertificateValue->value; ?>',
                            channelName: '<?php echo e($channel_name); ?>'
                        },
                        success: function(response) {
                            var RtcToken = response.rtcToken;


                            $.ajax({
                                url: '<?php echo e(route("api.storeToken")); ?>',
                                type: 'POST',
                                data: {
                                    channelName: '<?php echo e($channel_name); ?>',
                                    token:RtcToken,
                                    callId:callId,
                                },
                                success: function(response_call) {
                                    toastr.success('Call accepted successfully');
                                    window.location.href = "<?php echo e(route('front.astrologercall')); ?>" + "?callId=" + callId + "&call_type=" + call_type;
                                },
                                error: function(xhr, status, error) {
                                    var errorMessage = JSON.parse(xhr.responseText).error.paymentMethod[0];
                                    toastr.error(errorMessage);
                                }
                            });

                        },
                        error: function(xhr, status, error) {
                            toastr.error(xhr.responseText);
                        }
                    });


                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });

        // Reject Chat

        $(document).on('click','.rejectcall',function(e) {

            // e.preventDefault();

            <?php
                $token = $session->get('astrotoken');
            ?>

            var form = $(this).closest('form');
            var formData = form.serialize();

            $.ajax({
                url: "<?php echo e(route('api.rejectCallRequest', ['token' => $token])); ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Call Rejected Successfully.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });

</script>

<script>

    $(document).ready(function() {
            function fetchChatRequests() {
                $.ajax({
                    url: '/astrologer/get-chat-requests',
                    method: 'POST',
                    data: { astrologerId: '<?php echo e(astroauthcheck()['astrologerId']); ?>' },
                    success: function(data) {
                        updateChatRequests(data.recordList);
                    }
                });
            }

            function fetchCallRequests() {
                $.ajax({
                    url: '/astrologer/get-call-requests',
                    method: 'POST',
                    data: { astrologerId: '<?php echo e(astroauthcheck()['astrologerId']); ?>' },
                    success: function(data) {
                        updateCallRequests(data.recordList);
                    }
                });
            }

            function fetchReportRequests() {
                $.ajax({
                    url: '/astrologer/get-report-requests',
                    method: 'POST',
                    data: { astrologerId: '<?php echo e(astroauthcheck()['astrologerId']); ?>' },
                    success: function(data) {
                        updateReportRequests(data.recordList);
                    }
                });
            }

            function updateChatRequests(requests) {
                const chatRequests = $('#chatRequests');
                chatRequests.empty();
                if (requests && requests.length > 0) {
                    requests.forEach(request => {
                        const profileImg = request.profile ? `/${request.profile}` : '<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>';
                        chatRequests.append(`
                            <form id="chatForm">
                                <li class="list-group-item d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="chatId" id="chatId" value="${request.chatId}">
                                    <input type="hidden" name="partnerId" id="partnerId" value="${request.userId}">
                                    <input type="hidden" name="userId" id="userId" value="${request.astrologerId}">
                                    <div class="d-flex justify-content-between">
                                        <div class="w-25 pr-1">
                                            <img src="${profileImg}" class="rounded-circle img-fluid" alt="Avatar">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span>${request.name}</span>
                                            <div class="d-flex">
                                                <i class="fa fa-calendar mt-1" aria-hidden="true"></i>&nbsp;<span>${new Date(request.chatcreatedat).toLocaleDateString()}</span>
                                            </div>
                                        </div>
                                        <div class="status">
                                            <a class="badge bg-light-success text-dark border border-success  px-3 py-2 acceptchat">Accept</a>
                                            <a class="badge bg-light-danger text-dark border border-danger  px-3 py-2 rejectchat">Reject</a>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        `);
                    });
                } else {
                    chatRequests.append('<li class="list-group-item d-flex justify-content-center align-items-center h-100"><p class="text-center card-title nodata">No Record Found !</p></li>');
                }
            }

            function updateCallRequests(requests) {
                const callRequests = $('#callRequests');
                callRequests.empty();
                if (requests && requests.length > 0) {
                    requests.forEach(request => {
                        const profileImg = request.profile ? `/${request.profile}` : '<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>';
                        callRequests.append(`
                            <form id="callForm">
                                <li class="list-group-item d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="callId" id="callId" value="${request.callId}">
                                    <input type="hidden" name="partnerId" id="partnerId" value="${request.userId}">
                                    <input type="hidden" name="userId" id="userId" value="${request.astrologerId}">
                                    <input type="hidden" id="call_type" name="call_type" value="${request.call_type}">
                                    <div class="d-flex justify-content-between">
                                        <div class="w-25 pr-1">
                                            <img src="${profileImg}" class="rounded-circle img-fluid" alt="Avatar">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span>${request.name}</span>
                                            <div class="d-flex">
                                                <i class="fa fa-calendar mt-1" aria-hidden="true"></i>&nbsp;<span>${new Date(request.callcreatedat).toLocaleDateString()}</span>
                                            </div>
                                            ${request.call_type == 10 ?
                                            '<div class="d-flex"><i class="fa-solid fa-phone mt-1"></i>&nbsp;<span>Audio Call</span></div>' :
                                            '<div class="d-flex"><i class="fas fa-video mt-1"></i>&nbsp;<span>Video Call</span></div>'}
                                        </div>
                                        <div class="status">
                                            <a class="badge bg-light-success text-dark border border-success  px-3 py-2 acceptcall">Accept</a>
                                            <a class="badge bg-light-danger text-dark border border-danger  px-3 py-2 rejectcall">Reject</a>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        `);
                    });
                } else {
                    callRequests.append('<li class="list-group-item d-flex justify-content-center align-items-center h-100"><p class="text-center card-title nodata">No Record Found !</p></li>');
                }
            }

            function updateReportRequests(requests) {
                const reportRequests = $('#reportRequests');
                reportRequests.empty();
                if (requests && requests.length > 0) {
                    requests.forEach(request => {
                        const profileImg = request.profile ? `/${request.profile}` : '<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>';
                        reportRequests.append(`
                            <div><span class="text-dark font-weight-bold ml-2">${request.reportType}</span></div>
                            <li class="list-group-item d-flex justify-content-center align-items-center reportList"  data-toggle="modal" data-target="#reportModal" data-id="${request.id}" style="cursor: pointer;">
                                <div class="d-flex justify-content-between">
                                    <div class="w-25 pr-1">
                                        <img src="${profileImg}" class="rounded-circle img-fluid" alt="Avatar">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span>${request.firstName} ${request.lastName}</span>
                                        <div class="d-flex">
                                            <i class="fa fa-calendar mt-1 " aria-hidden="true"></i>&nbsp;<span>${new Date(request.birthDate).toLocaleDateString()}</span>
                                        </div>
                                        <div class="d-flex">
                                            <i class="fa fa-clock mt-1"></i>&nbsp;<span>${request.birthTime}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `);
                    });
                } else {
                    reportRequests.append('<li class="list-group-item d-flex justify-content-center align-items-center h-100"><p class="text-center card-title nodata">No Record Found !</p></li>');
                }
            }

            // Call the fetch functions to load data initially
            fetchChatRequests();
            fetchCallRequests();
            fetchReportRequests();


            setInterval(fetchChatRequests, 6000);
            setInterval(fetchCallRequests, 6000);
            setInterval(fetchReportRequests, 6000);
        });
    </script>
<script>
    $(document).ready(function() {
        // Click event handler for list items (assuming .list-group-item is the class of your list items)
            $(document).on('click','.reportList',function(e) {
                e.preventDefault();
            var reportId = $(this).data('id');

            $.ajax({
                url: '/api/getUserReportRequestById',
                method: 'POST',
                data: {
                    id: reportId
                },
                success: function(response) {
                    if (response.status === 200 && response.recordList.length > 0) {
                        var record = response.recordList[0];

                        var profileImage = record.profile ? record.profile : '<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png')); ?>';
                        var html = `
                            <div>
                                <div class="user-card">
                                    <input type="hidden" id="id" name="id" value="${record.id}">
                                    <div class="user-card-img">
                                        <img src="/${profileImage}" alt="Report Image" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="user-card-info">
                                        <h2>${record.firstName} ${record.lastName}</h2>
                                        <p><span>Contact No:</span> ${record.contactNo}</p>
                                        <p><span>Gender:</span> ${record.gender}</p>
                                        <p><span>Birth Date:</span> ${record.birthDate}</p>
                                        <p><span>Birth Time:</span> ${record.birthTime}</p>
                                        <p><span>Birth Place:</span> ${record.birthPlace}</p>
                                        <p><span>Occupation:</span> ${record.occupation}</p>
                                        <p><span>Marital Status:</span> ${record.maritalStatus}</p>
                                        <p><span>Report Type:</span> ${record.reportType}</p>
                                        <p><span>Comments:</span> ${record.comments}</p>
                                        <!-- Add any additional details here -->
                                    </div>
                                </div>
                                <div class="mt-3 mb-3 container">
                                    <label for="reportFile" class="form-label">Upload PDF</label>
                                    <input type="file" accept=".pdf" class="form-control" id="reportFile"  style="height: 44px">
                                    <input type="hidden" class="form-control" id="Base64reportFile" name="reportFile">
                                </div>
                            </div>`;
                        $('.modal-body').html(html);
                        $('#reportModal').modal('show');
                    } else {
                        console.log('Error: No record found or unexpected status ' + response.status);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
        $(document).on('change','#reportFile', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var binaryString = e.target.result;
                    var base64String = btoa(binaryString);
                    $('#Base64reportFile').val(base64String);
                };
                reader.readAsBinaryString(file);
            }
        });
        // Form submission handler
        $('#reportForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '<?php echo e(route("api.addUserReportFile")); ?>',
                method: 'POST',
                data: {
                    id:$('#id').val(),
                    reportFile:$('#Base64reportFile').val()
                },
                success: function(response) {
                    console.log(response);
                    if (response.status === 200) {
                        toastr.success('Pdf Uploded Successfully');
                        window.location.href="<?php echo e(route('front.astrologerindex')); ?>";
                    } else {
                        console.log('Error: No record found or unexpected status ' + response.status);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.astrologers.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/astrologers/pages/index.blade.php ENDPATH**/ ?>