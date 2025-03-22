<?php
    use Symfony\Component\HttpFoundation\Session\Session;
    $session = new Session();
    $token = $session->get('token');
?>

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
                            <i class="fa fa-chevron-right"></i> <span class="breadcrumbtext">Chat With Astrologer</span>
                        </span>
                    </span>

                </div>
            </div>
        </div>
    </div>


    <div class="py-md-3 expert-search-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" id="experts" style="overflow:hidden;">
                    <div id="expert-search" class="my-3 my-md-0">
                        <!--For Serach Component-->
                        <div class="expert-search-form">
                            <div class="row mx-auto px-2 px-md-0 flex-md-nowrap align-items-center round">
                                <div
                                    class="col-12 col-md-3 col-sm-auto text-left d-flex justify-content-between align-items-center w-100 bg-white px-0">
                                    <h1 class="font-22 font-weight-bold">Chat With Astrologer</h1>
                                    <img src="#" alt="Filter Experts based on Status" width="18" height="18"
                                        class="img-fluid filterIcon float-right d-md-none" onClick="fnSearch()" />
                                </div>
                                <div class="col-ms-12 col-md-3 d-none d-md-block" id="searchExpert">
                                    <form action="<?php echo e(route('front.chatList')); ?>" method="GET">
                                        <div class="search-box">
                                            <input value="<?php echo e(isset($searchTerm) ? $searchTerm : ''); ?>"
                                                class="form-control rounded" name="s" placeholder="Search Astrologers"
                                                type="search" autocomplete="off">
                                            <button type="submit" class="btn btn-link search-btn" id="search-button">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-ms-12 col-md-3 d-none d-md-flex nowrap align-items-center pl-md-0 pt-2 pb-2 "
                                    id="sortExpert">
                                    <select class="form-control font13 rounded" name="sortBy" onchange="onSortExpertList()"
                                        id="psychicOrderBy">
                                        <option value="1" <?php echo e($sortBy == '1' ? 'selected' : ''); ?>>Online</option>
                                        <option value="experienceLowToHigh"
                                            <?php echo e($sortBy == 'experienceLowToHigh' ? 'selected' : ''); ?>>Low Experience</option>
                                        <option value="experienceHighToLow"
                                            <?php echo e($sortBy == 'experienceHighToLow' ? 'selected' : ''); ?>>High Experience
                                        </option>
                                        <option value="priceLowToHigh" <?php echo e($sortBy == 'priceLowToHigh' ? 'selected' : ''); ?>>
                                            Lowest Price</option>
                                        <option value="priceHighToLow" <?php echo e($sortBy == 'priceHighToLow' ? 'selected' : ''); ?>>
                                            Highest Price</option>
                                    </select>

                                </div>

                                <div class="col-ms-12 col-md-3 d-none d-md-flex nowrap align-items-center pl-md-0 pt-2 pb-2"
                                    id="filterExpertCategory">
                                    <select name="astrologerCategoryId" onchange="onFilterExpertCategoryList()"
                                        class="form-control font13 rounded" id="psychicCategories">
                                        <option value="0" <?php echo e($astrologerCategoryId == '0' ? 'selected' : ''); ?>>All
                                        </option>
                                        <?php $__currentLoopData = $getAstrologerCategory['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category['id']); ?>"
                                                <?php echo e($astrologerCategoryId == $category['id'] ? 'selected' : ''); ?>>
                                                <?php echo e($category['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-lg-12 expert-search-section-height">
                <div id="expert-list" class="py-4 ">

                    <?php $__currentLoopData = $getAstrologer['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astrologer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div id="ATAAIOfferTile" class="psychic-card overflow-hidden expertOnline ask-guruji"
                            data-astrologer-id="<?php echo e($astrologer['id']); ?>">
                            <ul class="list-unstyled d-flex mb-0">
                                <li class="mr-3 position-relative psychic-presence status-online" data-status="online"><a
                                        href="<?php echo e(route('front.astrologerDetails', ['id' => $astrologer['id']])); ?>">
                                        <div class="psyich-img position-relative">
                                            <?php if($astrologer['profileImage']): ?>
                                                <img src="/<?php echo e($astrologer['profileImage']); ?>"width="80" height="80"
                                                    style="border-radius:50%;" loading="lazy">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>"
                                                    width="80" height="80" style="border-radius:50%;">
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                    <?php if($astrologer['chatStatus']=='Busy'): ?>
                                    <div class="status-badge specific-Clr-Busy" title="Online"></div>
                                    <?php else: ?>
                                    <div class="status-badge specific-Clr-Online" title="Online"></div>
                                    <div class="status-badge-txt text-center specific-Clr-Online"><span
                                        id=""title="Online"
                                        class="status-badge-txt specific-Clr-Online tooltipex"><?php echo e($astrologer['chatStatus']); ?></span>
                                    </div>
                                    <?php endif; ?>


                                </li>



                                <li class="w-100 overflow-hidden"><a
                                        href="<?php echo e(route('front.astrologerDetails', ['id' => $astrologer['id']])); ?>"
                                        class="colorblack font-weight-semi font16 mt-0 ml-0 mr-0 mb-0 p-0 text-capitalize d-block"
                                        data-toggle="tooltip" title=""><?php echo e($astrologer['name']); ?></a><span
                                        class="font-12 d-block color-red"><?php echo e($astrologer['allSkill']); ?></span><span
                                        class="font-12 d-block exp-language"><?php echo e($astrologer['languageKnown']); ?></span>
                                    <span class="font-12 d-block"> Exp :<?php echo e($astrologer['experienceInYears']); ?> Years</span>
                                    <?php if($astrologer['isFreeAvailable'] == true): ?>
                                        <span class="font-12 font-weight-semi-bold d-flex"> <span
                                                class="exprt-price"><del><?php echo e($currency['value']); ?><?php echo e($astrologer['charge']); ?></del>/Min</span>
                                            <span class="free-badge text-uppercase color-red ml-2">Free</span></span>
                                    <?php else: ?>
                                        <span class="font-12 font-weight-semi-bold d-flex"> <span class="exprt-price">
                                                <?php echo e($currency['value']); ?><?php echo e($astrologer['charge']); ?>/Min</span></span>
                                    <?php endif; ?>
                                </li>

                            </ul>


                            <div class="d-flex align-items-end position-relative">
                                <div class="d-block">
                                    <div class="row">
                                        <div class="psy-review-section col-6"><a href="javascript:void(0);">
                                                <span class="colorblack font-12 m-0 p-0 d-block">
                                                    Category:
                                                    <span class="font-12 font-weight-bold m-0 p-0 color-brown">
                                                        <?php
                                                        $category = $astrologer['astrologerCategory'];
                                                        echo strlen($category) > 40 ? substr($category, 0, 40) . '...' : $category;
                                                        ?>
                                                    </span>
                                                </span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-3 ml-5">
                                            <?php if($astrologer['chatStatus']=='Busy'): ?>
                                            <a class="btn-block btn btn-call  align-items-center ">Busy</a>
                                            <?php else: ?>
                                            <a class="btn-block btn btn-call  align-items-center " role="button"
                                                data-toggle="modal"
                                                <?php if(!authcheck()): ?> data-target="#loginSignUp" <?php else: ?> data-target="#intake" <?php endif; ?>><i
                                                    class="fa-regular fa-comment"></i>
                                                </a>
                                                <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </div>


    
    <div class="modal fade rounded mt-2 mt-md-5 " id="intake" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title font-weight-bold">
                        Intake Form
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <div class="bg-white body">
                        <div class="row ">

                            <div class="col-lg-12 col-12 ">
                                <div class="mb-3 ">

                                    <form class="px-3 font-14" method="post" id="intakeForm">

                                        <?php if(authcheck()): ?>
                                            <input type="hidden" name="userId" value="<?php echo e(authcheck()['id']); ?>">
                                            <input type="hidden" name="countryCode"
                                                value="<?php echo e(authcheck()['countryCode']); ?>">
                                        <?php endif; ?>
                                        <input type="hidden" name="astrologerId" id="astroId" value="">
                                        <input type="hidden" name="charge" id="astroCharge" value="">
                                        <div class="row">
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Name">Name<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="Name" name="name" placeholder="Enter Name"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['name'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="PhoneNumber">Phone No<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="PhoneNumber" name="phoneNumber" placeholder="Enter Phone"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['phoneNumber'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group">
                                                    <label for="Gender">Gender <span class="color-red">*</span></label>
                                                    <select class="form-control" id="Gender" name="gender">
                                                        <option value="Male"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Male' ? 'selected' : ''); ?>>
                                                            Male</option>
                                                        <option value="Female"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Female' ? 'selected' : ''); ?>>
                                                            Female</option>
                                                        <option value="Other"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Other' ? 'selected' : ''); ?>>
                                                            Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="BirthDate">Birthdate<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="BirthDate" name="birthDate" placeholder="Enter Birthdate"
                                                        type="date"
                                                        value="<?php echo e(isset($getIntakeForm['recordList'][0]['birthDate']) ? date('Y-m-d', strtotime($getIntakeForm['recordList'][0]['birthDate'])) : ''); ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="BirthTime">Birthtime<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="BirthTime" name="birthTime" placeholder="Enter Birthtime"
                                                        type="time"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['birthTime'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="BirthPlace">Birthplace<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="BirthPlace" name="birthPlace" placeholder="Enter Birthplace"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['birthPlace'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="MaritalStatus">Marital Status<span
                                                            class="color-red">*</span></label>
                                                    <select class="form-control" id="MaritalStatus" name="maritalStatus">
                                                        <option value="Single"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Single' ? 'selected' : ''); ?>>
                                                            Single</option>
                                                        <option value="Married"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Married' ? 'selected' : ''); ?>>
                                                            Married</option>
                                                        <option value="Divorced"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Divorced' ? 'selected' : ''); ?>>
                                                            Divorced</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Occupation">Occupation<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="Occupation" name="occupation" placeholder="Enter Occupation"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['occupation'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="TopicOfConcern">Topic Of Concern<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="TopicOfConcern" name="topicOfConcern"
                                                        placeholder="Enter Topic Of Concern" type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['topicOfConcern'] ?? ''); ?>">
                                                </div>
                                            </div>

                                            <?php if(authcheck()): ?>
                                                <?php if($isFreeAvailable == false): ?>
                                                <input type="hidden" name="isFreeSession"
                                                value="0">
                                                    <div class="col-12 py-3">
                                                        <div class="form-group mb-0">
                                                            <label>Select Time You want to chat<span
                                                                    class="color-red">*</span></label><br>
                                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                                <label class="btn btn-info btn-sm">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration300" value="300"> 5 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration600" value="600"> 10 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration900" value="900"> 15 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration1200" value="1200"> 20 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration1500" value="1500"> 25 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration1800" value="1800"> 30 mins
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="hidden" name="chat_duration"
                                                        value="<?php echo e($getIntakeForm['default_time']); ?>">
                                                    <input type="hidden" name="isFreeSession"
                                                    value="1">
                                                <?php endif; ?>
                                            <?php endif; ?>



                                        </div>

                                        <div class="col-12 col-md-12 py-3">
                                            <div class="row">

                                                <div class="col-12 pt-md-3 text-center mt-2">
                                                    <button class="font-weight-bold ml-0 w-100 btn btn-chat"
                                                        id="loaderintakeBtn" type="button" style="display:none;"
                                                        disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span> Loading...
                                                    </button>
                                                    <button type="submit"
                                                        class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                        id="intakeBtn">Start Chat</button>
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



    


<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $('.btn-call').on('click', function() {
            var astrologerCard = $(this).closest('.psychic-card');
            var astrologerId = astrologerCard.data('astrologer-id');
            var astroChargeText = astrologerCard.find('.exprt-price').text().trim();

            // Extract numerical value from the charge text
            var astroCharge = parseFloat(astroChargeText.match(/[\d.]+/));

            // Set values to hidden fields
            $('#astroId').val(astrologerId);
            $('#astroCharge').val(astroCharge);

        });



        function onFilterExpertCategoryList() {
            var astrologerCategoryId = $('#psychicCategories').val();
            var url = new URL(window.location.href);
            url.searchParams.set('astrologerCategoryId', astrologerCategoryId);
            window.location.href = url.toString();
        }

        function onSortExpertList() {
            var sortBy = $('#psychicOrderBy').val();
            var url = new URL(window.location.href);
            url.searchParams.set('sortBy', sortBy);
            window.location.href = url.toString();
        }
    </script>

    <script>
         const firestore = firebase.firestore();
        // Function to send a message
        function sendMessage(senderId, receiverId, message, isEndMessage, attachementPath) {
            const chatRef = firestore.collection('chats').doc(`${receiverId}_${senderId}`).collection('userschat').doc(
                receiverId).collection('messages');
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
            $('#intakeBtn').click(function(e) {
                e.preventDefault();




                $('#intakeBtn').hide();
                $('#loaderintakeBtn').show();
                setTimeout(function() {
                    $('#intakeBtn').show();
                    $('#loaderintakeBtn').hide();
                }, 3000);


                var astrocharge = $("#astroCharge").val();


                <?php
                $wallet_amount = '';
                if (authcheck()) {
                    $wallet_amount = authcheck()['totalWalletAmount'];
                }
                ?>

                var formData = $('#intakeForm').serialize();

                // Parse form data as URL parameters
                var urlParams = new URLSearchParams(formData);
                var chat_duration = parseInt(urlParams.get('chat_duration'));

                var chat_duration_minutes = Math.ceil(chat_duration / 60);

                var total_charge = astrocharge * chat_duration_minutes;

                var isFreeAvailable = "<?php echo e($isFreeAvailable); ?>";

                var wallet_amount = "<?php echo e($wallet_amount); ?>";

                // for message send
                var astrologerId = $('#astroId').val();
                <?php if(authcheck()): ?>
                var userId="<?php echo e(authcheck()['id']); ?>";
                <?php endif; ?>
                var formDatas = $('#intakeForm').serializeArray();
                var name = formDatas.find(item => item.name === 'name').value;
                var gender = formDatas.find(item => item.name === 'gender').value;
                var birthDate = formDatas.find(item => item.name === 'birthDate').value;
                var birthTime = formDatas.find(item => item.name === 'birthTime').value;
                var birthPlace = formDatas.find(item => item.name === 'birthPlace').value;
                var maritalStatus = formDatas.find(item => item.name === 'maritalStatus').value;
                var topicOfConcern = formDatas.find(item => item.name === 'topicOfConcern').value;

                <?php if($getAstrologer['recordList']): ?>
                var message = `Hi <?php echo e($getAstrologer['recordList'][0]['name']); ?>

                Below are my details:

                Name: ${name},
                Gender: ${gender},
                DOB: ${birthDate},
                TOB: ${birthTime},
                POB: ${birthPlace},
                Marital status: ${maritalStatus},
                TOPIC: ${topicOfConcern}

                This is an automated message to confirm that chat has started.`;
                <?php endif; ?>

                $.ajax({
                    url: "<?php echo e(route('api.checkChatSessionTaken', ['token' => $token])); ?>",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(!response.recordList)
                            chatRequestWallet();
                        else
                            toastr.error('Your request is already there');

                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });

                function chatRequestWallet()
                {
                     // Check if free chat is available and wallet has sufficient balance
                    if (isFreeAvailable != true) {
                        if (total_charge <= wallet_amount) {
                            AddChatRequestFunc(formData)
                        } else {
                            toastr.error('Insufficient balance. Please recharge your wallet.');
                        }
                    } else {
                        AddChatRequestFunc(formData)
                    }
                }

                function AddChatRequestFunc(formData)
                {
                    $.ajax({
                        url: "<?php echo e(route('api.addChatRequest', ['token' => $token])); ?>",
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            // console.log('Chat Request Sent');
                        },
                        error: function(xhr, status, error) {
                            toastr.error(xhr.responseText);
                        }
                    });
                    $.ajax({
                        url: "<?php echo e(route('api.intakeForm', ['token' => $token])); ?>",
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            sendMessage(userId, astrologerId, message, false,'');
                            setTimeout(function() {
                                toastr.success(
                                    'Chat Request Sent ! you will be notified if astrologer accept your request.'
                                    );
                                window.location.reload();

                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            toastr.error(xhr.responseText);
                        }
                    });
                }


            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/astrologer-chat-list.blade.php ENDPATH**/ ?>