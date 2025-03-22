<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customers</title>
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
                <img alt="AstroGuru image" class="logo__image w-6" src="<?php echo e($logo->value); ?>"
                    style="height:100%;width:100%;object-fit:cover;border-radius:50%">
            </div>
        </div>
        <div style="display: inline-block;float:right">
            <h4><?php echo e($title); ?></h4>
            <p><?php echo e($date); ?></p>
        </div>
    </div>

    <table class="table table-bordered" aria-label="myPdf">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact No</th>
            <th>Birth Date</th>
            <th>Birth Time</th>
        </tr>
        <?php
            $no = 0;
        ?>
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(++$no); ?></td>
                <td><?php echo e($cus->name); ?></td>
                <td><?php echo e($cus->contactNo); ?></td>
                <td> <?php echo e(date('d-m-Y', strtotime($cus->birthDate)) ? date('d-m-Y', strtotime($cus->birthDate)) : '--'); ?>

                </td>
                <td><?php echo e($cus->birthTime); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/customerList.blade.php ENDPATH**/ ?>