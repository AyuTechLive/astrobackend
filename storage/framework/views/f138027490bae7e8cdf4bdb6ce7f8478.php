<!DOCTYPE html>
<html lang="en">

<head>
    <title>Astrologers</title>
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
            <th>Gender</th>
            <th>Total Call Request</th>
            <th>Total Chat Request</th>
            <th>Status</th>
        </tr>
        <?php
            $no = 0;
        ?>
        <?php $__currentLoopData = $astrologers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(++$no); ?></td>
                <td><?php echo e($ast->name); ?></td>
                <td><?php echo e($ast->contactNo); ?></td>
                <td> <?php echo e($ast->gender); ?>

                </td>
                <td><?php echo e($ast->totalCallRequest); ?></td>
                <td><?php echo e($ast->totalChatRequest); ?></td>
                <td>
                    <?php if($ast->isVerified): ?>
                        Verified
                    <?php else: ?>
                        UnVerified
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

</body>

</html>
<?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/astrologerList.blade.php ENDPATH**/ ?>