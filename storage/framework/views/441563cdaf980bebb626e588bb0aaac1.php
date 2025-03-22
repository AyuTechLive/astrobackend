<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astrologer Login</title>
    <link rel="icon" href="/<?php echo e($logo['value']); ?>" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .login-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .logo {
            width: 50px;
            margin-right: 10px;
        }

        .site-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .login-title {
            font-size: 20px;
            color: #555;
            margin-bottom: 20px;
        }

        #otpless-login-page {
            margin-top: 20px;
        }

        /* Responsive styles */
        @media (max-width: 600px) {
            .logo {
                width: 40px;
                margin-right: 5px;
            }

            .site-name {
                font-size: 20px;
            }

            .login-title {
                font-size: 18px;
            }

            .login-container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>


    <div class="login-container">
        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
        <div class="login-header">
            <img src="/<?php echo e($logo['value']); ?>" alt="Logo" class="logo">
            <span class="site-name"><?php echo e($appname['value']); ?></span>
        </div>
        <h1 class="login-title">Astrologer Login</h1>
        <div class="login-body">
            <div id="otpless-login-page"></div>
        </div>
        <form method="post" action="<?php echo e(route('front.verifyOTLAstro')); ?>" id="OtpLesslogin">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="otl_token" id="otl_token">
            <input id="contactNo" name="contactNo" type="hidden" value="" />
            <input id="countryCode" name="countryCode" type="hidden" value="" />
        </form>
    </div>
</body>

</html>


<script src="<?php echo e(asset('public/build/assets/jquery.min.js')); ?>"></script>
<script id="otpless-sdk" type="text/javascript" src="https://otpless.com/v2/auth.js"
    data-appid="<?php echo e($otplessAppId['value']); ?>"></script>
<script>
    function otpless(otplessUser) {
        console.log(JSON.stringify(otplessUser));
        $("#otl_token").val(otplessUser.token);
         $("#OtpLesslogin").submit();
    }
</script>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/astrologers/pages/astrologers-login.blade.php ENDPATH**/ ?>