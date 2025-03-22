<!DOCTYPE html>
<html lang="en">

<head>
    <title>ReportHistory</title>
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
            <div style="height:100px;width:100px;margin-bottom:10px;">
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
            <th>User</th>
            <th>Astrologer</th>
            <th>Report Type</th>
            <th>Report Date</th>
            <th>Report Charge</th>
        </tr>
        <?php
            $no = 0;
        ?>
        <?php $__currentLoopData = $reportHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(++$no); ?></td>
                <td><?php echo e($history->userName); ?>-<?php echo e($history->userContactNo); ?></td>
                <td><?php echo e($history->astrologerName); ?>-<?php echo e($history->astrologerContactNo); ?></td>
                <td><?php echo e($history->title); ?></td>
                <td> <?php echo e(date('d-m-Y', strtotime($history->created_at)) ? date('d-m-Y', strtotime($history->created_at)) : '--'); ?>

                </td>
                <td><?php echo e($history->reportRate); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

</body>

</html>
<?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/report-history.blade.php ENDPATH**/ ?>