

<?php $__env->startSection('head'); ?>
    <title>Error Page - Midone - Tailwind HTML Admin Template</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php
            $logo = DB::table('systemflag')
                ->where('name', 'AdminLogo')
                ->select('value')
                ->first();
        ?>
        <!-- BEGIN: Error Page -->
        <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
            <div class="-intro-x lg:mr-20">

                <img alt="Midone - HTML Admin Template" style="width: 300px;"class="h-48 lg:h-auto" src="/<?php echo e($logo->value); ?>">
            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-8xl font-medium">404</div>
                <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. This page has gone missing.</div>
                <div class="intro-x text-lg mt-3">You may have mistyped the address or the page may have moved.</div>
                <a
                    class="intro-x btn-primary btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10" href="/admin/login">Back
                    to Home</a>
            </div>
        </div>
        <!-- END: Error Page -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/404.blade.php ENDPATH**/ ?>