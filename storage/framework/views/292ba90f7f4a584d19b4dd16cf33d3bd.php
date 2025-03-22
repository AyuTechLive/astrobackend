<?php $__env->startSection('subhead'); ?>
    <title>Withdrawal Request</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10">Withdrawal Requests</h2>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="<?php echo e(route('withdrawalRequests')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="w-56 relative text-slate-500" style="display:inline-block">
                        <input value="<?php echo e($searchString); ?>" type="text" class="form-control w-56 box pr-10"
                            placeholder="Search..." id="searchString" name="searchString">
                        <?php if(!$searchString): ?>
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        <?php else: ?>
                            <a href="<?php echo e(route('withdrawalRequests')); ?>"><i
                                    class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="x"></i></a>
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
            <table class="table table-report mt-2 " aria-label="withdraw">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Profile</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="whitespace-nowrap">Amount</th>
                        <th class="whitespace-nowrap">Request Date</th>
                        <th class="whitespace-nowrap">Payment Method</th>
                        <th class="whitespace-nowrap">Detail</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0; ?>
                    <?php $__currentLoopData = $withdrawlRequest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>
                            <td>
                                <div class="w-10 h-10 image-fit zoom-in">
                                        <img class="rounded-full"
                                            src="/<?php echo e($request->profileImage); ?>"
                                            onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                            alt="Astrologer image" />
                                </div>
                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap"><?php echo e($request->name); ?> -
                                    <?php echo e($request->contactNo); ?></div>
                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap"><?php echo e($request->withdrawAmount); ?></div>
                            </td>
                            <td>
                                <?php echo e(date('d-m-Y', strtotime($request->created_at)) ? date('d-m-Y h:i', strtotime($request->created_at)) : '--'); ?>

                            </td>
                            <td>
                                <?php if($request->paymentMethod == 2): ?>
                                    UPI
                                <?php else: ?>
                                    Bank Account
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($request->paymentMethod == 2): ?>
                                    UPI:<?php echo e($request->upiId); ?>

                                <?php else: ?>
                                    A/C NO:<?php echo e($request->accountNumber); ?><br>
                                    IFSC:<?php echo e($request->ifscCode); ?><br>
                                    A/C Holder:<?php echo e($request->accountHolderName); ?>

                                <?php endif; ?>

                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap"><?php echo e($request->status); ?></div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <?php if($request->status != 'Released'): ?>
                                        <a id="editbtn" href="javascript:;" onclick="delbtn(<?php echo e($request->id); ?>)"
                                            value="<?php echo e($request->id); ?>" class="flex items-center"
                                            data-tw-target="#delete-confirmation-modal" data-tw-toggle="modal"><i
                                                data-lucide="share" class="editbtn w-4 h-4 mr-1"></i>Release</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($totalRecords > 0): ?>
            <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
                <?php echo e($totalRecords); ?> entries</div>
           
        <?php endif; ?>
        <div class="d-inline addbtn intro-y col-span-12">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination" id="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link"
                            href="<?php echo e(route('withdrawalRequests', ['page' => $page - 1, 'searchString' => $searchString])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('withdrawalRequests', ['page' => $i + 1, 'searchString' => $searchString])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link"
                            href="<?php echo e(route('withdrawalRequests', ['page' => $page + 1, 'searchString' => $searchString])); ?>">
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
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i class="w-16 h-16 text-danger mx-auto mt-3"></i>

                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 py-4">Do you really want to Release This Amount?
                        </div>

                        <form action="<?php echo e(route('releaseAmount')); ?> " method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" id="del_id" name="del_id">
                            <div class="px-5 pb-8 text-center">
                                <button type="button" data-tw-dismiss="modal"
                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                <button data-tw-dismiss="modal" class="btn btn-primary w-24">Release</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('script'); ?>
        <script type="text/javascript">
            function delbtn($id, $name) {
                var id = $id;
                $did = id;

                $('#del_id').val($did);
                $('#id').val($id);
            }
        </script>
        <script>
            $(window).on('load', function() {
                $('.loader').hide();
            })
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/withdrawl.blade.php ENDPATH**/ ?>