<?php $__env->startSection('content'); ?>




<div id="otpless-login-page"></div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script id="otpless-sdk" type="text/javascript" src="https://otpless.com/v2/auth.js" data-appid="8CDYOQA61CJAVT3F3VJU"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/user-login.blade.php ENDPATH**/ ?>