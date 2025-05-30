<?php $__env->startSection('subhead'); ?>
    <title>Dashboard</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5"></h2>
                        <?php if(auth()->guard()->guest()): ?>
                            <h3>Guest</h3>
                        <?php endif; ?>
                    </div>
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <a href="<?php echo e(route('callHistory')); ?>">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="phone-call" class="report-box__icon text-primary"></i>
                                                <div class="ml-auto">
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6"><?php echo e($dash['totalCallRequest']); ?>

                                            </div>
                                            <div class="text-base text-slate-500 mt-1">Call Request</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <a href="<?php echo e(route('chatHistory')); ?>">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">

                                            <div class="flex">
                                                <i data-lucide="message-square" class="report-box__icon text-pending"></i>
                                                <div class="ml-auto">

                                                </div>
                                            </div>

                                            <div class="text-3xl font-medium leading-8 mt-6"><?php echo e($dash['totalChatRequest']); ?>

                                            </div>
                                            <div class="text-base text-slate-500 mt-1">Chat Request</div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <a href="<?php echo e(route('reportrequest')); ?>">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file-text" class="report-box__icon text-warning"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            <?php echo e($dash['totalReportRequest']); ?>

                                        </div>
                                        <div class="text-base text-slate-500 mt-1">Report Request</div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <a href="<?php echo e(route('partnerWiseEarning')); ?>">
                                    <div class="report-box">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="indian-rupee" class="report-box__icon text-success"></i>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6"><?php echo e($dash['totalEarning']); ?>

                                            </div>
                                            <div class="text-base text-slate-500 mt-1">Total Earning</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <a href="<?php echo e(route('customers')); ?>">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="user" class="report-box__icon text-success"></i>
                                                <div class="ml-auto">
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6"><?php echo e($dash['totalCustomer']); ?>

                                            </div>
                                            <div class="text-base text-slate-500 mt-1">Total Customer</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <a href="<?php echo e(route('astrologers')); ?>">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-lucide="user" class="report-box__icon text-success"></i>
                                                <div class="ml-auto">
                                                </div>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6"><?php echo e($dash['totalAstrologer']); ?>

                                            </div>
                                            <div class="text-base text-slate-500 mt-1">Total Astrologer</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="col-span-12 lg:col-span-6 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Monthly Earning Report</h2>
                       
                    </div>
                    <h6>Last 12 Months</h6>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="report-chart">
                            <div class="h-[275px]">
                                <canvas id="myChart" height="100px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-6 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Monthly Request</h2>
                        
                    </div>
                    <h6>Last 12 Months</h6>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="report-chart">
                            <div class="h-[275px]">
                                <canvas id="requestChart" height="100px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Weekly Top Products -->
        <div class="col-span-12 mt-6">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">Top Astrologer</h2>
                <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                </div>
            </div>
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" aria-label="">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Profile</th>
                            <th class="whitespace-nowrap">Name</th>
                            <th class="text-center whitespace-nowrap">ContactNo</th>
                            <th class="text-center whitespace-nowrap">Total Request</th>
                            <th class="text-center whitespace-nowrap">Languages</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dash['topAstrologer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img class="rounded-full" src="/<?php echo e($top->profileImage); ?>"
                                                onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                                alt="Astrologer image" />
                                        </div>
                                    </div>
                                </td>
                                <td class="w-40">
                                    <a class="font-medium whitespace-nowrap"><?php echo e($top->name); ?></a>
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                    </div>
                                </td>
                                <td class="text-center w-40"><?php echo e($top->contactNo); ?></td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center">
                                        <i data-lucide="phone-call" class="w-4 h-4 mr-2"></i>
                                        <?php echo e($top->totalCallRequest); ?> /<i data-lucide="message-square"
                                            class="w-4 h-4 mr-2 ml-2"></i><?php echo e($top->totalChatRequest); ?>


                                    </div>
                                </td>
                                <td class="w-40 text-center">
                                    <a class="font-medium whitespace-nowrap"><?php echo e($top->languageKnown); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

        </div>
        <?php if(count($dash['unverifiedAstrologer']) > 0): ?>
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Unverified Astrologers</h2>
                    <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                    </div>
                </div>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2" aria-label="astrologer">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Profile</th>
                                <th class="whitespace-nowrap">Name</th>
                                <th class="text-center whitespace-nowrap">ContactNo</th>
                                <th class="text-center whitespace-nowrap">Skills</th>
                                <th class="text-center whitespace-nowrap">Languages</th>
                                <th class="text-center whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dash['unverifiedAstrologer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unverified): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="tooltip rounded-full" alt="profileImage"
                                                    src="/<?php echo e($unverified->profileImage); ?>"
                                                    onerror="this.onerror=null;this.src='/build/assets/images/person.png';" />
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-40">
                                        <a class="font-medium whitespace-nowrap"><?php echo e($unverified->name); ?></a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                        </div>
                                    </td>
                                    <td class="text-center w-40"><?php echo e($unverified->contactNo); ?></td>
                                    <td class="w-40">
                                        <div class="flex items-center justify-center">
                                            <a class="font-medium whitespace-nowrap"><?php echo e($unverified->allSkill); ?></a>
                                        </div>
                                    </td>
                                    <td class="w-40 text-center">
                                        <a class="font-medium whitespace-nowrap"><?php echo e($unverified->languageKnown); ?></a>
                                    </td>
                                    <td class="w-40 text-center">
                                        <div class="flex justify-center items-center">
                                            <a onclick="editbtn(<?php echo e($unverified->id); ?>,<?php echo e($unverified->isVerified); ?>)"
                                                href="javascript:;" data-tw-target="#verifiedAstrologer"id="editbtn"
                                                class="flex items-center mr-3 text-success" data-tw-toggle="modal">
                                                <?php if($unverified->isVerified): ?>
                                                    <i style="color:brown"
                                                        data-lucide="<?php echo e($unverified->isVerified ? 'lock' : 'unlock'); ?>"
                                                        class="w-4 h-4 mr-1"></i>
                                                <?php else: ?>
                                                    <i data-lucide="<?php echo e($unverified->isVerified ? 'lock' : 'unlock'); ?>"
                                                        class="w-4 h-4 mr-1"></i>
                                                <?php endif; ?>
                                                <?php if($unverified->isVerified): ?>
                                                    <span style="color:brown"> UnVerified</span>
                                                <?php else: ?>
                                                    Verified
                                                <?php endif; ?>
                                            </a>
                                            <a class="flex items-center mr-3 text-success"
                                                href="astrologers/<?php echo e($unverified->id); ?>">
                                                <i data-lucide="eye" class="w-4 h-4 mr-1"></i>View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

            </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <!-- END: Weekly Top Products -->
    </div>
    <div id="verifiedAstrologer" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <div class="text-3xl mt-5">Are You Sure?</div>
                        <div class="text-slate-500 mt-2" id="verified">You want Verified!</div>
                    </div>
                    <form action="<?php echo e(route('verifiedAstrologer')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="filed_id" name="filed_id">
                        <div class="px-5 pb-8 text-center"><button class="btn btn-primary mr-3" id="btnVerified">Yes,
                                Verified it!
                            </button><a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24"
                                onclick="location.reload();">Cancel</a>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        function editbtn($id, $isVerified) {
            var id = $id;
            $cid = id;

            $('#filed_id').val($cid);
            var verified = $isVerified ? 'UnVerified' : 'Verified';
            document.getElementById('verified').innerHTML = "You want to " + verified;
            document.getElementById('btnVerified').innerHTML = "Yes, " +
                verified + " it";
        }
        var labels = <?php echo e(Js::from($labels)); ?>;
        var users = <?php echo e(Js::from($data)); ?>;
        var calls = <?php echo e(Js::from($callData)); ?>;
        var chats = <?php echo e(Js::from($chatData)); ?>;
        var reports = <?php echo e(Js::from($reportData)); ?>;

        const data = {
            labels: labels,
            datasets: [{
                label: 'Earning',
                backgroundColor: '#426f80',
                borderColor: '#426f80',
                data: users,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
        const barChartData = {
            labels: labels,
            datasets: [{
                    label: 'Call',
                    backgroundColor: '#426f80',
                    borderColor: '#426f80',
                    data: calls,
                },
                {
                    label: 'Chat',
                    backgroundColor: '#fea42d',
                    borderColor: '#fea42d',
                    data: chats,
                }, {
                    label: 'Report',
                    backgroundColor: '#ddd',
                    borderColor: '#ddd',
                    data: reports,
                }
            ]
        };

        const requestConfig = {
            type: 'bar',
            data: barChartData,
            options: {}
        };

        const requestChart = new Chart(
            document.getElementById('requestChart'),
            requestConfig
        );
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/dashboard-overview-1.blade.php ENDPATH**/ ?>