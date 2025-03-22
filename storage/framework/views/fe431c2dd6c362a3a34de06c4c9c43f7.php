<?php $__env->startSection('subhead'); ?>
    <title>Partner Wise Earning</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $currency = DB::table('systemflag')
            ->where('name', 'Currency')
            ->select('value')
            ->first();
    ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Partner Wise Earning</h2>
    <?php if($totalRecords > 0): ?>
        <a class="btn btn-primary shadow-md mr-2 d-inline mt-10 addbtn printpdf">PDF</a>
        <a class="btn btn-primary shadow-md mr-2 d-inline mt-10 addbtn downloadcsv">CSV</a>
    <?php endif; ?>
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <?php if($totalRecords > 0): ?>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible withoutsearch">
            <table class="table table-report -mt-2" aria-label="partner-wise-earning">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="text-center whitespace-nowrap">ASTROLOGER</th>
                        <th class="text-center whitespace-nowrap">Total Earning</th>
                        <th class="text-center whitespace-nowrap">Chat Earning</th>
                        <th class="text-center whitespace-nowrap">Call Earning</th>
                        <th class="text-center whitespace-nowrap">Report Earning</th>
                        <th class="text-center whitespace-nowrap">Gift Earning</th>
                        <th class="text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $partnerWiseEarning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>

                            <td class="text-center">
                                <?php echo e($earning->astrologerName); ?>

                            </td>
                            <td class="text-center"><?php echo e($currency->value); ?>

                                <?php if($earning->totalEarning): ?>
                                    <?php echo e($earning->totalEarning); ?>

                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php echo e($currency->value); ?>

                                <?php if($earning->chatEarning): ?>
                                    <?php echo e($earning->chatEarning); ?>

                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php echo e($currency->value); ?>

                                <?php if($earning->callEarning): ?>
                                    <?php echo e($earning->callEarning); ?>

                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php echo e($currency->value); ?>

                                <?php if($earning->reportEarning): ?>
                                    <?php echo e($earning->reportEarning); ?>

                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php echo e($currency->value); ?>

                                <?php if($earning->giftEarning): ?>
                                    <?php echo e($earning->giftEarning); ?>

                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>

                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center text-success">
                                    <a id="editbtn"
                                        href="<?php echo e(route('earning-report', ['id' => $earning->astrologerId])); ?>"
                                        class="flex items-center mr-3 " data-tw-target="#edit-modal"
                                        data-tw-toggle="modal"><i data-lucide="eye"
                                            class="editbtn w-4 h-4 mr-1"></i>View</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
            <?php echo e($totalRecords); ?> entries</div>
        <div class="d-inline addbtn intro-y col-span-12">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('partnerWiseEarning', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('partnerWiseEarning', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('partnerWiseEarning', ['page' => $page + 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <div class="intro-y mt-5" style="height:100%">
            <div style="display:flex;align-items:center;height:100%;">
                <div style="margin:auto">
                    <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
                    <h3 class="text-center">No Data Available</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- BEGIN: Delete Confirmation Modal -->
    <!-- END: Delete Confirmation Modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"  ></script>
    <script type="text/javascript">
        var spinner = $('.loader');
        jQuery(function() {
            jQuery('.printpdf').click(function(e) {
                e.preventDefault();
                spinner.show();
                jQuery.ajax({
                    type: 'GET',
                    url: "<?php echo e(route('printPartnerWisePdf')); ?>",
                    data: "",
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        if (jQuery.isEmptyObject(data.error)) {
                            var blob = new Blob([data]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "partnerWiseEarning.pdf";
                            link.click();
                            spinner.hide();
                        } else {
                            spinner.hide();
                        }
                    }
                });
            });
            jQuery('.downloadcsv').click(function(e) {
                e.preventDefault();
                spinner.show();
                jQuery.ajax({
                    type: 'GET',
                    url: "<?php echo e(route('exportPartnerWiseCSV')); ?>",
                    data: "",
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        if (jQuery.isEmptyObject(data.error)) {
                            var blob = new Blob([data]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "partnerWiseEarning.csv";
                            link.click();
                            spinner.hide();
                        } else {
                            spinner.hide();
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/partnerwise-earning.blade.php ENDPATH**/ ?>