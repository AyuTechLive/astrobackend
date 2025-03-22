<?php $__env->startSection('content'); ?>
    <div class="pt-1 pb-1 bg-red d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">
                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.home')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> Privacy Policy
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="ds-head-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <h2 class="h2 font-weight-bold color-off-black mb-4 cat-heading"><?php echo e($privacy->title); ?></h2>
                    <?php echo $privacy->description; ?>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/privacy-policy.blade.php ENDPATH**/ ?>