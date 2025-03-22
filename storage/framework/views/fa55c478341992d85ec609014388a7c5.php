<?php $__env->startSection('content'); ?>
    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">
                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.home')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <a href="<?php echo e(route('front.getMyWallet')); ?>"
                                style="color:white;text-decoration:none">My Wallet</a>
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
                        <h1 class="h2 font-weight-bold colorblack">Transaction History</h1>
                        <p>Check your complete transaction history here.</p>
                    </div>


                    <div class="row pt-1 pb-3" id="historydate">
                        <div class="col-md-12">
                            <h3 class="font16 font-weight-bold py-4">Wallet Transaction History</h3>

                        </div>
                    </div>

                    

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-red text-white">
                                    <tr>
                                        <th class="font-weight-semi-bold">Transaction Details</th>
                                        <th class="font-weight-semi-bold">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $getUserById['recordList'][0]['walletTransaction']['wallet']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $walletdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($walletdata)): ?>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h5>
                                                        <?php if($walletdata['transactionType'] == 'Call' || $walletdata['transactionType'] == 'Chat'): ?>
                                                            <?php echo e($walletdata['transactionType']); ?> with <?php echo e($walletdata['name']); ?> for <?php echo e($walletdata['totalMin']); ?> minutes
                                                        <?php elseif($walletdata['transactionType'] == 'astromallOrder'): ?>
                                                            Product Ordered
                                                        <?php elseif($walletdata['transactionType'] == 'Gift'): ?>
                                                            Sent <?php echo e($walletdata['transactionType']); ?> to <?php echo e($walletdata['name']); ?>

                                                            <?php else: ?>
                                                            <?php echo e($walletdata['transactionType']); ?> Received
                                                        <?php endif; ?>
                                                    </h5>
                                                    </div>
                                                    <div class="font-12 text-muted">
                                                        <?php echo e(date('j-F-Y H:i a', strtotime($walletdata['created_at']))); ?>

                                                    </div>
                                                </td>
                                                <td class="<?php echo e($walletdata['amount'] ? 'text-success' : 'text-danger'); ?>">
                                                    <div class="font-medium"><?php echo e($walletdata['amount']); ?></div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                </div>

                <input type="hidden" value="0" id="flag">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/wallet-transaction.blade.php ENDPATH**/ ?>