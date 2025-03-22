<?php $__env->startSection('subhead'); ?>
    <title>Kundali Earnings</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $currency = DB::table('systemflag')
            ->where('name', 'Currency')
            ->select('value')
            ->first();
    ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Kundali Earnings</h2>
    <?php if($totalRecords > 0): ?>
        <a data-tw-toggle="modal" data-tw-target="#add-skill"
            class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn printpdf">PDF</a>
        <a class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn downloadcsv">CSV</a>
    <?php endif; ?>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="<?php echo e(route('kundaliearning')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="w-56 relative text-slate-500" style="display:inline-block">
                        <input value="<?php echo e($searchString); ?>" type="text" class="form-control w-56 box pr-10"
                            placeholder="Search..." id="searchString" name="searchString">
                        <?php if(!$searchString): ?>
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        <?php else: ?>
                            <a href="<?php echo e(route('kundaliearning')); ?>"><i
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
                        <th class="text-center whitespace-nowrap">USER TYPE</th>
                        <th class="text-center whitespace-nowrap">USER</th>
                        <th class="text-center whitespace-nowrap">DATE</th>
                        <th class="text-center whitespace-nowrap">KUNDALI TYPE</th>
                        <th class="text-center whitespace-nowrap">COST</th>
                        <th class="text-center whitespace-nowrap">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $kundaliEarnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>

                            <td class="text-center"> 
                                <?php echo e($req->user_type); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e($req->userName); ?> - <?php echo e($req->userContactNo); ?>

                            </td>
                           

                            <td class="text-center">
                                <?php echo e(date('d-m-Y', strtotime($req->created_at)) ? date('d-m-Y ', strtotime($req->created_at)) : '--'); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e($req->kundaliType); ?>

                            </td>
                            <td class="text-center">
                                <?php if($req->kundaliType=='small'): ?>
                                20
                                <?php elseif($req->kundaliType=='medium'): ?>
                                30
                                <?php elseif($req->kundaliType=='large'): ?>
                                49
                                <?php endif; ?>
                            </td>

                            <?php if($req->pdf_link!=null): ?>
                            <td class="text-center">
                                <div class="flex justify-center items-center">
                                    
                                        <a class="flex items-center mr-3 text-success" href="<?php echo e(url('public/'.$req->pdf_link)); ?>"
                                            target="_blank">
                                            <i data-lucide="download" class="w-4 h-4 mr-1"></i>DownloadFile
                                        </a>
                                </div>
                            </td>
                            <?php else: ?>
                            <td class="text-center">
                              No Pdf Available
                            </td>
                            <?php endif; ?>

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
                            href="<?php echo e(route('kundaliearning', ['page' => $page - 1, 'searchString' => $searchString])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('kundaliearning', ['page' => $i + 1, 'searchString' => $searchString])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link"
                            href="<?php echo e(route('kundaliearning', ['page' => $page + 1, 'searchString' => $searchString])); ?>">
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

    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/kundali-earnings.blade.php ENDPATH**/ ?>