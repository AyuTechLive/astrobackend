<?php $__env->startSection('subhead'); ?>
    <title>Customers</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Customers</h2>
    <?php if($totalRecords > 0): ?>
        <a class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn printpdf">PDF</a>
        <a class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn downloadcsv">CSV</a>
    <?php endif; ?>
    <a class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn" href="customers/add">Add Customer</a>
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-money" class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn rechargewallet" >Recharge Wallet</a>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="<?php echo e(route('customers')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="w-56 relative text-slate-500" style="display:inline-block">
                        <input value="<?php echo e($searchString); ?>" type="text" class="form-control w-56 box pr-10"
                            placeholder="Search..." id="searchString" name="searchString">
                        <?php if(!$searchString): ?>
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        <?php else: ?>
                            <a href="<?php echo e(route('customers')); ?>"><i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                                    data-lucide="x"></i></a>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary shadow-md mr-2">Search</button>
                </form>
            </div>
        </div>
    </div>
    <?php if($totalRecords > 0): ?>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible list-table">
            <table class="table table-report mt-2" aria-label="customer-list">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">PROFILE</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="text-center whitespace-nowrap">CONTACT NO.</th>
                        <th class="text-center whitespace-nowrap">EMAIL</th>
                        <th class="text-center whitespace-nowrap">BIRTH DATE</th>
                        <th class="text-center whitespace-nowrap">BIRTH TIME</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="todo-list">
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>
                            <td>
                                <div class="flex">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        <img class="rounded-full" src="/<?php echo e($user->profile); ?>"
                                            onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                            alt="Customer image" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap"><?php echo e($user->name ? $user->name : '--'); ?></div>
                            </td>
                            <td class="text-center"><?php echo e($user->contactNo ? $user->contactNo : '--'); ?></td>
                            <td class="text-center"><?php echo e($user->email ? $user->email : '--'); ?></td>
                            <td class="text-center">
                                <?php echo e(date('d-m-Y', strtotime($user->birthDate)) ? date('d-m-Y', strtotime($user->birthDate)) : '--'); ?>

                            </td>
                            <td class="text-center"><?php echo e($user->birthTime ? $user->birthTime : '--'); ?></td>

                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3 text-success" href="customers/<?php echo e($user->id); ?>">
                                        <i data-lucide="eye" class="w-4 h-4 mr-1"></i>View
                                    </a>
                                    <a class="flex items-center mr-3" href="customers/edit/<?php echo e($user->id); ?>">
                                        <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Edit
                                    </a>
                                    <a type="button" href="javascript:;" class="flex items-center deletebtn text-danger"
                                        data-tw-toggle="modal" data-tw-target="#deleteModal"
                                        onclick="delbtn(<?php echo e($user->id); ?>)">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <?php if($totalRecords > 0): ?>
        <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of <?php echo e($totalRecords); ?> entries</div>
    <?php endif; ?>
    <div class="d-inline intro-y col-span-12 addbtn">
        <nav class="w-full sm:w-auto sm:mr-auto">
            <ul class="pagination" id="pagination">
                <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                    <a class="page-link"
                        href="<?php echo e(route('customers', ['page' => $page - 1, 'searchString' => $searchString])); ?>">
                        <i class="w-4 h-4" data-lucide="chevron-left"></i>
                    </a>
                </li>
    
                <?php
                    $showPages = 15; // Number of pages to show at a time
                    $halfShowPages = floor($showPages / 2);
                    $startPage = max(1, $page - $halfShowPages);
                    $endPage = min($startPage + $showPages - 1, $totalPages);
                ?>
    
                <?php if($startPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="<?php echo e(route('customers', ['page' => 1, 'searchString' => $searchString])); ?>">1</a>
                    </li>
                    <?php if($startPage > 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
    
                <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo e($page == $i ? 'active' : ''); ?>">
                        <a class="page-link"
                            href="<?php echo e(route('customers', ['page' => $i, 'searchString' => $searchString])); ?>"><?php echo e($i); ?></a>
                    </li>
                <?php endfor; ?>
    
                <?php if($endPage < $totalPages): ?>
                    <?php if($endPage < $totalPages - 1): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="<?php echo e(route('customers', ['page' => $totalPages, 'searchString' => $searchString])); ?>"><?php echo e($totalPages); ?></a>
                    </li>
                <?php endif; ?>
    
                <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                    <a class="page-link"
                        href="<?php echo e(route('customers', ['page' => $page + 1, 'searchString' => $searchString])); ?>">
                        <i class="w-4 h-4" data-lucide="chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
    <?php else: ?>
        <div class="intro-y" style="height:100%">
            <div style="display:flex;align-items:center;height:100%;">
                <div style="margin:auto">
                    <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
                    <h3 class="text-center">No Data Available</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- END: Pagination -->

    

    <div id="add-money" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Recharge Wallet</h2>
                </div>
                <form method="POST" enctype="multipart/form-data" id="add-data">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="">
                                <div class="sm:grid grid-cols gap-2  ">
                                    <div class="input">
                                        <div>
                                            <label for="name" class="form-label">Select User</label>
                                            <select data-placeholder="Select users" class="form-control select2" id="userId" name="userId">
                                                <option value="" disabled selected required>--Select User--</option>
                                                <?php $__currentLoopData = $userdatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($userdata->userId); ?>" required><?php echo e($userdata->userName); ?> - <?php echo e($userdata->usercontactNo?$userdata->usercontactNo:$userdata->email); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <div class="text-danger print-userId-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:grid grid-cols gap-2 py-4">
                                    <div class="input">
                                        <div>
                                            <label for="amount" class="form-label">Amount</label>
                                            <input type="number" name="amount" id="amount" class="form-control"
                                                placeholder="Amount" required >
                                            <div class="text-danger print-amount-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button type="submit"
                                    class="btn btn-primary shadow-md mr-2 btn-submit">Add Money</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->

    <div id="deleteModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process
                            cannot be undone.</div>
                    </div>
                    <form action="<?php echo e(route('deleteUser')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <input type="hidden" id="del_id" name="del_id">
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                            <button class="btn btn-danger w-24">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- END: Delete Confirmation Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"  ></script>
<script>
    $(document).ready(function() {
        jQuery('.select2').select2();
    });
</script>
<script>

function Validate(event) {
            var regex = new RegExp("^[0-9-!@#$%&<>*?]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }


        function numbersOnly(e) {
            var keycode = e.keyCode;
            if (!(keycode != 9 && e.shiftKey == false && (keycode == 46 || keycode == 8 || keycode ==
                    37 ||
                    keycode == 39 || (keycode >=
                        48 && keycode <= 57)))) {
                e.preventDefault();
            }
        }


        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        jQuery("#add-data").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('rechargewallet')); ?>",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.message); // Display success message using Toastr
                        spinner.hide();
                        location.reload();
                    } else {
                        toastr.warning(data.error[0]); // Display error message using Toastr
                        spinner.hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    spinner.hide();
                    toastr.error('An error occurred while processing your request.'); // Display generic error message
                }
            });
        });






        function printErrorMsg(msg) {
            jQuery(".print-name-error-msg").find("ul").html('');
            jQuery(".print-amount-error-msg").find("ul").html('');
            jQuery(".print-image-error-msg").find("ul").html('');
            jQuery.each(msg, function(key, value) {
                if (key == 'name') {
                    jQuery(".print-name-error-msg").css('display', 'block');
                    jQuery(".print-name-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'amount') {
                    jQuery(".print-amount-error-msg").css('display', 'block');
                    jQuery(".print-amount-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'image') {
                    jQuery(".print-image-error-msg").css('display', 'block');
                    jQuery(".print-image-error-msg").find("ul").append('<li>' + value + '</li>');
                }

            });
        }
</script>

    <script type="text/javascript">
        <?php if(Session::has('error')): ?>
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("<?php echo e(session('error')); ?>");
        <?php endif; ?>
        function delbtn($id) {
            var id = $id;
            $did = id;

            $('#del_id').val($did);
            $('#id').val($id);
        }
    </script>
    <script type="text/javascript">
        var spinner = $('.loader');
        jQuery(function() {
            jQuery('.printpdf').click(function(e) {
                e.preventDefault();
                spinner.show();
                var searchString = $("#searchString").val();
                jQuery.ajax({
                    type: 'GET',
                    url: "<?php echo e(route('printcustomerlist')); ?>",
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
                            link.download = "customerList.pdf";
                            link.click();
                            spinner.hide();
                            // location.reload();
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
                    url: "<?php echo e(route('exportcustomerCSV')); ?>",
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
                            link.download = "customerList.csv";
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

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/customer-list.blade.php ENDPATH**/ ?>