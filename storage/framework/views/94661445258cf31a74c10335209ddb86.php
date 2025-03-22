

<?php $__env->startSection('subhead'); ?>
    <title>Report Request History</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $currency = DB::table('systemflag')
            ->where('name', 'Currency')
            ->select('value')
            ->first();
    ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Report Request History</h2>
    <?php if($totalRecords > 0): ?>
        <a data-tw-toggle="modal" data-tw-target="#add-skill"
            class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn printpdf">PDF</a>
        <a class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn downloadcsv">CSV</a>
    <?php endif; ?>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="<?php echo e(route('reportrequest')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="w-56 relative text-slate-500" style="display:inline-block">
                        <input value="<?php echo e($searchString); ?>" type="text" class="form-control w-56 box pr-10"
                            placeholder="Search..." id="searchString" name="searchString">
                        <?php if(!$searchString): ?>
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        <?php else: ?>
                            <a href="<?php echo e(route('reportrequest')); ?>"><i
                                    class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="x"></i></a>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary shadow-md mr-2">Search</button>
                </form>
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <?php if($totalRecords > 0): ?>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible list-table">
            <table class="table table-report -mt-2" aria-label="call-history">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class=" whitespace-nowrap">USER</th>
                        <th class="text-center whitespace-nowrap">ASTROLOGER</th>
                        <th class="text-center whitespace-nowrap">REPORT TYPE</th>
                        <th class="text-center whitespace-nowrap">REPORT DATE</th>
                        <th class="text-center whitespace-nowrap">REPORT CHARGE</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $reportRequest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>

                            <td>
                                <?php echo e($req->userName); ?> - <?php echo e($req->userContactNo); ?>

                            </td>
                            <td class="text-center"><?php echo e($req->astrologerName); ?> - <?php echo e($req->astrologerContactNo); ?></td>
                            <td class="text-center">
                                <?php echo e($req->title); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e(date('d-m-Y', strtotime($req->created_at)) ? date('d-m-Y ', strtotime($req->created_at)) : '--'); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e($currency->value); ?> <?php echo e($req->reportRate); ?>

                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <button
                                        onclick="getDetail('<?php echo e($req->firstName); ?>','<?php echo e($req->lastName); ?>','<?php echo e($req->contactNo); ?>','<?php echo e($req->gender); ?>','<?php echo e(date('d-m-Y', strtotime($req->birthDate)) ? date('d-m-Y ', strtotime($req->birthDate)) : ''); ?>','<?php echo e($req->birthTime); ?>','<?php echo e($req->birthPlace); ?>','<?php echo e($req->occupation); ?>','<?php echo e($req->maritalStatus); ?>','<?php echo e($req->answerLanguage); ?>','<?php echo e($req->partnerName); ?>','<?php echo e(date('d-m-Y', strtotime($req->partnerBirthDate)) ? date('d-m-Y ', strtotime($req->partnerBirthDate)) : ''); ?>','<?php echo e($req->partnerBirthTime); ?>','<?php echo e($req->partnerBirthPlace); ?>','<?php echo e($req->comments); ?>')"
                                        data-tw-target="#detail" data-tw-toggle="modal"
                                        class="flex items-center mr-3 text-success">
                                        <i data-lucide="eye" class="w-4 h-4 mr-1"></i>View
                                    </button>
                                    <?php if($req->reportFile): ?>
                                        <a class="flex items-center mr-3 text-success" href="/<?php echo e($req->reportFile); ?>"
                                            target="_blank">
                                            <i data-lucide="download" class="w-4 h-4 mr-1"></i>DownloadFile
                                        </a>
                                    <?php endif; ?>
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
                <ul class="pagination" id="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link"
                            href="<?php echo e(route('reportrequest', ['page' => $page - 1, 'searchString' => $searchString])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('reportrequest', ['page' => $i + 1, 'searchString' => $searchString])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link"
                            href="<?php echo e(route('reportrequest', ['page' => $page + 1, 'searchString' => $searchString])); ?>">
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
    <div id="detail" class="modal " tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Request Data</h2>
                </div>
                <div id="details" class="p-3">
                </div>
                <div class="px-5 pb-8"><a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <!-- END: Delete Confirmation Modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"  ></script>
    <script type="text/javascript">
        var spinner = $('.loader');

        function getDetail($firstName, $lastName, $contactNo, $gender, $birthDate, $birthTime, $birthPlace, $occupation,
            $maritalStatus, $answerLanguage, $partnerName, $partnerBirthDate, $partnerBirthTime, $partnerBirthPlace,
            $comments) {
            document.getElementById('details').innerHTML =
                "<table class='table table-report'><tbody><tr class='intro-x'><td><b>Name</b></td><td> " + $firstName +
                " " +
                $lastName +
                "</td></tr><tr><td><b>Contact</b></td><td> " + $contactNo + "</td></tr><tr><td><b>Gender</b></td><td> " +
                $gender +
                "</td></tr><tr><td><b>BirthDate</b></td><td>" + $birthDate +
                "</td></tr><tr><td><b>BirthTime</b></td><td>" +
                $birthTime +
                "</td></tr><tr><td><b>BirthPlace</b></td><td>" + $birthPlace +
                "</td></tr><tr><td><b>Occupation</b></td><td>" +
                $occupation +
                "</td></tr><tr><td> <b>Marital Status</b></td><td>" + $maritalStatus +
                "</td></tr><tr><td><b>Answer In Language</b></td><td>" +
                $answerLanguage + "</td></tr><tr><td><b>Comments</b> </td><td>" + $comments +
                "</td></tr><tr><td><b>Partner Name</b></td><td> " + $partnerName +
                "</td></tr><tr><td><b>Partner BirthDate</b></td><td>" + $partnerBirthDate +
                "</td></tr><tr><td><b>Partner BirthTime</b></td><td>" +
                $partnerBirthTime + "</td></tr><tr><td><b>Partner Birth Place</b></td><td>" + $partnerBirthPlace +
                "</td></tr></tbody></table>"
        }
        jQuery(function() {
            jQuery('.printpdf').click(function(e) {
                e.preventDefault();
                spinner.show();
                var searchString = $("#searchString").val();
                jQuery.ajax({
                    type: 'GET',
                    url: "<?php echo e(route('printReport')); ?>",
                    data: {
                        "searchString": searchString,
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        if (jQuery.isEmptyObject(data.error)) {
                            var blob = new Blob([data]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "ReportHistory.pdf";
                            link.click();
                            spinner.hide();
                            location.reload();
                        } else {
                            spinner.hide();
                        }
                    }
                });
            });
            jQuery('.downloadcsv').click(function(e) {
                e.preventDefault();
                spinner.show();
                var searchString = $("#searchString").val();
                jQuery.ajax({
                    type: 'GET',
                    url: "<?php echo e(route('exportReportCSV')); ?>",
                    data: {
                        "searchString": searchString,
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        if (jQuery.isEmptyObject(data.error)) {
                            var blob = new Blob([data]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "reportHistory.csv";
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

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/report-request.blade.php ENDPATH**/ ?>