
<style>
    .table-container {
        max-height: 400px;
        /* Adjust the maximum height as needed */
        overflow-y: auto;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">
                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.astrologerindex')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <a href="<?php echo e(route('front.getAstrologerReport')); ?>"
                                style="color:white;text-decoration:none">My Reports</a>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="inpage">
                    <div class="text-left pb-md-4 pb-2">
                        <h1 class="h2 font-weight-bold colorblack">My Reports</h1>
                        <p>Check your complete report history here.</p>
                    </div>
                    <div class="table-responsive" id="walletTransactionTable">
                        <div class="row pt-1 pb-3" id="historydate">
                            <div class="col-md-12">
                                <h3 class="font16 font-weight-bold py-4">Report History</h3>

                            </div>
                        </div>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Transaction Details</th>
                                        <th>Report Rate</th>
                                        <!-- <th class="text-center">View Report</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $getAstrologerReport['recordList'][0]['report']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($reportdata)): ?>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h5>
                                                            Received Report
                                                            <?php echo e($reportdata['name']); ?>


                                                        </h5>
                                                    </div>
                                                    <div class="font-12 text-muted">
                                                        <?php echo e(date('j-F-Y H:i a', strtotime($reportdata['created_at']))); ?>


                                                    </div>
                                                    <div class="font-12 text-muted mt-1">
                                                        <span class="text-success">Completed</span>

                                                    </div>

                                                </td>

                                                <td class="text-success">
                                                    <div class="font-medium">
                                                        <?php echo e($currency['value']); ?><?php echo e($reportdata['reportRate']); ?></div>
                                                </td>
<!-- 
                                                <td class="text-center">
                                                    <?php if($reportdata['reportFile']): ?>
                                                    <a href="/<?php echo e($reportdata['reportFile']); ?>" class="btn btn-chat">View</a>
                                                    <?php endif; ?>
                                                </td> -->
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.astrologers.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/astrologers/pages/astrologer-reports.blade.php ENDPATH**/ ?>