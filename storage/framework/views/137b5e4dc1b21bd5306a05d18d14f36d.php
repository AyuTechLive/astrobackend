<?php $__env->startSection('subhead'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $currency = DB::table('systemflag')
            ->where('name', 'Currency')
            ->select('value')
            ->first();
    ?>
    <div class="loader"></div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Customer Details</h2>
    </div>
    <!-- BEGIN: Profile Info -->

    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="intro-y box  pt-5 mt-5">

            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5 px-5">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <img class="rounded-full" src="/<?php echo e($userDetail->profile); ?>"
                            onerror="this.onerror=null;this.src='/build/assets/images/person.png';" alt="Astrologer image" />
                    </div>
                    <div class="ml-5">
                        <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                            <?php echo e($userDetail->name ? $userDetail->name : '--'); ?></div>
                        <div class="text-slate-500"><?php echo e($userDetail->contactNo ? $userDetail->contactNo : '--'); ?></div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                            <?php echo e($userDetail->email ? $userDetail->email : '--'); ?>

                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3">
                            <i data-lucide="map-pin" class="w-5 h-6 mr-2"></i>
                            <?php echo e($userDetail->addressLine1 ? $userDetail->addressLine1 : '--'); ?>

                        </div>

                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">Details</div>
                    <div class="flex items-center justify-center lg:justify-start mt-2">
                        <div class="flex">
                            Birth Date: <span
                                class="ml-3 font-medium text-success"><?php echo e($userDetail->birthDate ? date('d-m-Y', strtotime($userDetail->birthDate)) : '--'); ?></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center lg:justify-start">
                        <div class="flex mt-2">
                            Birth Time<span
                                class="ml-3 font-medium text-danger"><?php echo e($userDetail->birthTime ? $userDetail->birthTime : '--'); ?></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center lg:justify-start">
                        <div class="flex mt-2">
                            Birth Place<span
                                class="ml-3 font-medium text-warning"><?php echo e($userDetail->birthPlace ? $userDetail->birthPlace : '--'); ?></span>
                        </div>
                    </div>
                </div>
            </div>


            <div id="link-tab" class="p-3">

                <ul class="nav nav-link-tabs" role="tablist">
                    <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1"
                            type="button" role="tab" aria-controls="example-tab-1" aria-selected="true">
                            Call History
                        </button>
                    </li>
                    <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-2"
                            type="button" role="tab" aria-controls="example-tab-2" aria-selected="false">
                            Wallet
                        </button>
                    </li>
                    <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3"
                            type="button" role="tab" aria-controls="example-tab-3" aria-selected="false">
                            Chat History
                        </button>
                    </li>
                    <li id="example-4-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-4"
                            type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                            Order Detail
                        </button>
                    </li>
                    <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-5"
                            type="button" role="tab" aria-controls="example-tab-5" aria-selected="false">
                            Report
                        </button>
                    </li>
                    <li id="example-6-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                            type="button" role="tab" aria-controls="example-tab-6" aria-selected="false">
                            Following List
                        </button>
                    </li>
                    <li id="example-7-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-7"
                            type="button" role="tab" aria-controls="example-tab-7" aria-selected="false">
                            Notification List
                        </button>
                    </li>
                    <li id="example-8-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-8"
                            type="button" role="tab" aria-controls="example-tab-8" aria-selected="false">
                            Gift List
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-5 mastertab">
                    <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel"
                        aria-labelledby="example-1-tab">
                        <?php if(count($userDetail->callRequest->callHistory) > 0): ?>
                            <div class="grid grid-cols-12 gap-6 mt-5">

                                <?php $__currentLoopData = $userDetail->callRequest->callHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $callReq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                                        <div class="box">
                                            <div class="p-5">
                                                <div class="image-fit" style="height:150px;width:150px">

                                                    <img class="rounded-full" src="/<?php echo e($callReq->profileImage); ?>"
                                                        onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                                        alt="Astrologer image" />
                                                </div>
                                                <div class="font-medium text-center lg:text-left lg:mt-3">
                                                    <?php echo e($callReq->astrologerName); ?></div>
                                                <div class="text-slate-600 dark:text-slate-500 mt-2">
                                                    <div class="flex items-center">
                                                        <?php echo e($callReq->created_at); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">

                                                        <?php echo e($callReq->contactNo); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        Call Rate:
                                                        <?php echo e($currency->value); ?><?php echo e($callReq->callRate); ?> /Min
                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        Deduction:
                                                        <?php echo e($currency->value); ?><?php echo e($callReq->deduction); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        Duration:
                                                        <?php echo e($callReq->totalMin); ?> Min
                                                    </div>

                                                    <div
                                                        class="flex items-center mt-2 <?php echo e($callReq->callStatus == 'Accepted' ? 'text-success' : 'text-danger'); ?>">
                                                        <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>
                                                        <?php echo e($callReq->callStatus); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center w-30">
                                <h5>No Call Request Found</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-2-tab">
                        <div class="intro-y box">

                            <div id="basic-tab" class="p-5">
                                <div class="preview">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li id="example-1" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                                data-tw-target="#wallet" type="button" role="tab"
                                                aria-controls="wallet" aria-selected="true">
                                                Wallet Transaction
                                            </button>
                                        </li>
                                        <li id="example-2" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                                data-tw-target="#payments" type="button" role="tab"
                                                aria-controls="payments" aria-selected="false">
                                                Payments Logs
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content border-l border-r border-b">
                                        <div id="wallet" class="tab-pane leading-relaxed p-5 active" role="tabpanel"
                                            aria-labelledby="example-1">
                                            <div class="col-span-12 xl:col-span-4 mt-6">
                                                <div class="mt-5">
                                                    <?php if(count($userDetail->walletTransaction->wallet) > 0): ?>
                                                        <?php $__currentLoopData = $userDetail->walletTransaction->wallet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="intro-y">
                                                                <div class="box px-4 py-4 mb-3 flex items-center">
                                                                    <div class="ml-4 mr-auto">
                                                                        <?php if($wallet->transactionType != 'Gift'): ?>
                                                                            <div class="font-medium">
                                                                                <?php echo e($wallet->transactionType); ?> with
                                                                                <?php echo e($wallet->name); ?> for
                                                                                <?php echo e($wallet->totalMin); ?>

                                                                                minutes
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <div class="font-medium">
                                                                                Send
                                                                                <?php echo e($wallet->transactionType); ?> to
                                                                                <?php echo e($wallet->name); ?>

                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <div class="text-slate-500 text-xs mt-0.5">
                                                                            <?php echo e(date('j-F-Y H:i a', strtotime($wallet->created_at))); ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center">

                                                                        <div
                                                                            class="ml-4 mr-auto <?php echo e($wallet->amount ? 'text-success' : 'text-danger'); ?>">
                                                                            <div class="font-medium">
                                                                                <?php echo e($currency->value); ?><?php echo e($wallet->amount); ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <div class="text-center w-30">
                                                            <h5>No Wallet Transaction Found</h5>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="payments" class="tab-pane leading-relaxed p-5" role="tabpanel"
                                            aria-labelledby="example-2">
                                            <div class="col-span-12 xl:col-span-4 mt-6">
                                                <div class="mt-5">
                                                    <?php if(count($userDetail->paymentLogs->payment) > 0): ?>
                                                        <?php $__currentLoopData = $userDetail->paymentLogs->payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="intro-y">
                                                                <div class="box px-4 py-4 mb-3 flex items-center">
                                                                    <div class="ml-4 mr-auto">
                                                                        <div class="font-medium">
                                                                            Recharge</div>
                                                                        <div class="text-slate-500 text-xs mt-0.5">
                                                                            <?php echo e(date('j-F-Y H:i a', strtotime($payments->created_at))); ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center">

                                                                        <div class="ml-4 mr-auto">
                                                                            <div class="font-medium">
                                                                                <?php echo e($currency->value); ?><?php echo e($payments->amount); ?>

                                                                            </div>
                                                                            <div
                                                                                class="text-slate-500 text-x mt-0.5 <?php echo e($payments->paymentStatus == 'Success' || $payments->paymentStatus == 'success' ? 'text-success' : 'text-danger'); ?>">
                                                                                <?php echo e($payments->paymentStatus); ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <div class="text-center w-30">
                                                            <h5>No Payments Logs Found</h5>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="example-tab-3" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-3-tab">
                        <?php if(count($userDetail->chatRequest->chatHistory) > 0): ?>
                            <div class="grid grid-cols-12 gap-6 mt-5">
                                <?php $__currentLoopData = $userDetail->chatRequest->chatHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chatReq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                                        <div class="box">
                                            <div class="p-5">
                                                <div class="image-fit" style="height:150px;width:150px">
                                                    <img class="rounded-full" src="/<?php echo e($chatReq->profileImage); ?>"
                                                        onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                                        alt="Astrologer image" />
                                                </div>
                                                <div class="font-medium text-center lg:text-left lg:mt-3">
                                                    <?php echo e($chatReq->astrologerName); ?></div>
                                                <div class="text-slate-600 dark:text-slate-500 mt-2">
                                                    <div class="flex items-center">
                                                        <?php echo e($chatReq->created_at); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                                                        <?php echo e($chatReq->contactNo); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        Rate:
                                                        <?php if($chatReq->chatRate): ?>
                                                            <?php echo e($currency->value); ?><?php echo e($chatReq->chatRate); ?>/min
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        Deduction:
                                                        <?php echo e($chatReq->deduction); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        Duration:
                                                        <?php if($chatReq->totalMin): ?>
                                                            <?php echo e($chatReq->totalMin); ?> Min
                                                        <?php endif; ?>
                                                    </div>
                                                    <div
                                                        class="flex items-center mt-2 <?php echo e($chatReq->chatStatus == 'Pending' ? 'text-success' : 'text-danger'); ?>">
                                                        <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>
                                                        <?php echo e($chatReq->chatStatus); ?>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center w-30">
                                <h5>No Chat Request Found</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-4-tab">
                        <?php if(count($userDetail->orders->order) > 0): ?>
                            <div class="grid grid-cols-12 gap-6 mt-5">
                                <?php $__currentLoopData = $userDetail->orders->order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                                        <div class="box">
                                            <div class="p-5">
                                                <div class="image-fit" style="height:150px;width:150px">
                                                    <img alt="Product image" class="rounded-full"
                                                        style="width: 100%; height: 100%;"
                                                        src="/<?php echo e($order->productImage); ?>"onerror="this.onerror=null;this.src='/build/assets/images/default.jpg';" />

                                                </div>
                                                <div class="font-medium text-center lg:text-left lg:mt-3 text-success"
                                                    style="font-size: 18px">
                                                    <?php echo e($order->productCategory); ?> - <?php echo e($order->productName); ?></div>
                                                <div class="text-slate-600 dark:text-slate-500 mt-0.9">
                                                    <div class="flex items-center mt-0.8" style="word-break:break-all">
                                                        <?php echo e($order->orderAddressName); ?><?php echo e($order->flatNo); ?>,<?php echo e($order->locality); ?>,<?php echo e($order->city); ?>,<?php echo e($order->state); ?>,<?php echo e($order->country); ?>,<?php echo e($order->pincode); ?>

                                                    </div>

                                                    <div class="flex items-center mt-2">
                                                        <div class="items-center text-danger mr-2">Payable Amount:</div>
                                                        <?php echo e($currency->value); ?><?php echo e($order->payableAmount); ?>

                                                    </div>
                                                    <div class="flex items-center mt0.2">
                                                        <div class="items-center text-danger mr-2">GST:</div>
                                                        <?php echo e($order->gstPercent); ?>%
                                                    </div>
                                                    <div class="flex items-center mt-0.6">
                                                        <div class="items-center text-danger mr-2"> Total Amount:</div>
                                                        <?php echo e($currency->value); ?><?php echo e($order->totalPayable); ?>

                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        <?php echo e($order->created_at); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center w-30">
                                <h5>No Order Detail Found</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="example-tab-5" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-5-tab">
                        <div class="col-span-12 xl:col-span-4 mt-6">
                            <div class="mt-5">
                                <?php if(count($userDetail->reportRequest->reportHistory) > 0): ?>
                                    <?php $__currentLoopData = $userDetail->reportRequest->reportHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="intro-y">
                                            <div class="box px-4 py-4 mb-3 flex items-center">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium text-success">
                                                        <?php echo e($report->firstName); ?> <?php echo e($report->lastName); ?>

                                                    </div>
                                                    <div class="text-slate-500 text-x mt-0.5">
                                                        <?php echo e(date('j-F-Y H:i a', strtotime($report->created_at))); ?>

                                                    </div>
                                                    <div class="text-slate-900 text-x mt-0.9">
                                                        <?php echo e($report->title); ?>

                                                    </div>
                                                    <div class="text text mt-0.9">
                                                        <?php echo e($currency->value); ?><?php echo e($report->reportRate); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-center w-30">
                                        <h5>No Report Found</h5>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-6-tab">
                        <div class="grid grid-cols-12 gap-6 mt-5">

                            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                                <?php if(count($userDetail->follower) > 0): ?>
                                    <table class="table table-report -mt-2" aria-label="follower">
                                        <thead>
                                            <tr>
                                                <th class="whitespace-nowrap">#</th>
                                                <th class="whitespace-nowrap">PROFILE</th>
                                                <th class="whitespace-nowrap">NAME</th>
                                                <th class="text-center whitespace-nowrap">CONTACT NO</th>
                                                <th class="text-center whitespace-nowrap">DATE</th>
                                                <th class="text-center whitespace-nowrap">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 0;
                                            ?>

                                            <?php $__currentLoopData = $userDetail->follower; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="intro-x">
                                                    <td><?php echo e(++$no); ?> </td>
                                                    <td>
                                                        <div class="flex">
                                                            <div class="w-10 h-10 image-fit zoom-in">
                                                                <img class="rounded-full"
                                                                    src="/<?php echo e($follower->profileImage); ?>"
                                                                    onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                                                    alt="Astrologer image" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="font-medium whitespace-nowrap"><?php echo e($follower->name); ?>

                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?php echo e($follower->contactNo); ?></td>
                                                    <td class="text-center whitespace-nowrap">
                                                        <?php echo e(date('d-m-Y', strtotime($follower->followingDate))); ?>

                                                    </td>
                                                    <td class="table-report__action w-56">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3 text-success"
                                                                href="/admin/astrologers/<?php echo e($follower->id); ?>">
                                                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i>View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="text-center w-30">
                                        <h5>No Followers Found</h5>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div id="example-tab-7" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-7-tab">
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                            <?php if(count($userDetail->notification) > 0): ?>
                                <table class="table table-report mt-2" aria-label="">
                                    <thead>
                                        <tr>
                                            <th class="whitespace-nowrap">#</th>
                                            <th class="whitespace-nowrap" style="text-align: center">TITLE</th>
                                            <th class="whitespace-nowrap" style="text-align: center">DESCRIPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                        ?>

                                        <?php $__currentLoopData = $userDetail->notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="intro-x">
                                                <td><?php echo e(++$no); ?> </td>
                                                <td>
                                                    <div class="font-medium" style="text-align: center">
                                                        <?php echo e($notification->title); ?>

                                                    </div>
                                                </td>
                                                <td class="text-center"><?php echo e($notification->description); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="text-center w-30">
                                    <h5>No Notification List Found</h5>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="example-tab-8" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-8-tab">
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                            <?php if(count($userDetail->sendGifts->gifts) > 0): ?>
                                <table class="table table-report mt-2" aria-label="gifts">
                                    <thead>
                                        <tr>
                                            <th class="whitespace-nowrap">#</th>
                                            <th class="whitespace-nowrap" style="text-align: center">Name</th>
                                            <th class="whitespace-nowrap" style="text-align: center">GIFT NAME</th>
                                            <th class="whitespace-nowrap" style="text-align: center">AMOUNT</th>
                                            <th class="whitespace-nowrap" style="text-align: center">DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                        ?>

                                        <?php $__currentLoopData = $userDetail->sendGifts->gifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="intro-x">
                                                <td><?php echo e(++$no); ?> </td>
                                                <td>
                                                    <div class="font-medium" style="text-align: center">
                                                        <?php echo e($gift->astrolgoerName); ?>

                                                    </div>
                                                </td>
                                                <td class="text-center"><?php echo e($gift->giftName); ?></td>
                                                <td class="text-center">
                                                    <?php echo e($currency->value); ?><?php echo e($gift->giftAmount ? $gift->giftAmount : 0); ?>

                                                </td>
                                                <td class="text-center">
                                                    <?php echo e(date('d-m-Y', strtotime($gift->created_at))); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="text-center w-30">
                                    <h5>No Gift List Found</h5>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript"></script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/customer-detail.blade.php ENDPATH**/ ?>