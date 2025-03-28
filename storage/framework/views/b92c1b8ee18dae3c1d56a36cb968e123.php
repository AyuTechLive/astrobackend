<?php
// include header file
// include 'header.php';
define('PAY_PAGE_CONFIG', config('paypage-payment'));
?>
<!DOCTYPE html>
<!-- Html Start -->
<html>
<!-- Head Start -->

<head>
    <!-- Page Title -->
    <title>Pay Page</title>
    <!-- /Page Title -->
    <!-- Load load bootstrap and fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- /Load load bootstrap and fontawesome -->
</head>
<!-- /Head End -->
<!-- Body Start -->

<body>
    <div class="text-center mt-5">
        <div class="col-lg-12 text-center">
            <!-- exclamation Icon -->
            <i class="fa fa-exclamation-triangle fa-5x text-warning"></i>
            <!-- /exclamation Icon -->
            <h1>Payment status is Pending</h1>
            <!-- URL for back to checkout form -->
            <a href="<?= getAppUrl() ?>" title="Back to Checkout Form">Back to Checkout Form</a>
            <!-- /URL for back to checkout form -->
        </div>
    </div>
</body>
<!-- /Body Start -->

</html>
<!-- /Html End --><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/payment/payment-pending.blade.php ENDPATH**/ ?>