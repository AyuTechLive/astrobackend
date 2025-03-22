<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php
        $logo = DB::table('systemflag')
            ->where('name', 'AdminLogo')
            ->select('value')
            ->first();
    ?>
    <div style=" display: grid;
    grid-template-columns: auto auto ;">
        <div style="display: inline-block">
            <div style="height:100px;width:100px;margin-bottom:10px">
                <img alt="AstroGuru image" class="logo__image w-6"
                    src="<?php echo e($logo->value); ?>"
                    style="height:100%;width:100%;object-fit:cover;border-radius:50%">
            </div>
        </div>
        <div style="display: inline-block;float:right">
            <h4><?php echo e($title); ?></h4>
            <p><?php echo e($date); ?></p>
        </div>
    </div>
    <table class="table table-bordered" aria-label="order-request-rreport">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Amount</th>
            <th>GST</th>
            <th>PaymentMethod</th>
            <th>OrderDate</th>
            <th>OrderStatus</th>
            <th>OrderAddress</th>
        </tr>
        <?php
            $no = 0;
        ?>
        <?php $__currentLoopData = $orderRequest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(++$no); ?></td>
                <td><?php echo e($order->userName); ?></td>
                <td><?php echo e($order->productName); ?>(<?php echo e($order->categoryName); ?>)</td>
                <td><?php echo e($order->payableAmount); ?></td>
                <td><?php echo e($order->gstAmount); ?></td>
                <td><?php echo e($order->paymentMethod); ?></td>
                <td><?php echo e(date('d-m-Y', strtotime($order->created_at)) ? date('d-m-Y h:i', strtotime($order->created_at)) : '--'); ?>

                </td>
                <td><?php echo e($order->orderStatus); ?></td>
                <td><?php echo e($order->flatNo); ?>,<?php echo e($order->landmark); ?>,<?php echo e($order->city); ?>,<?php echo e($order->state); ?>,<?php echo e($order->country); ?>-<?php echo e($order->pincode); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/order-request-report.blade.php ENDPATH**/ ?>