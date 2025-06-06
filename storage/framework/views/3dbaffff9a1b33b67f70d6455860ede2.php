<style>
    .table-container {
    max-height: 400px; /* Adjust the maximum height as needed */
    overflow-y: auto;
}
</style>
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
                        <h1 class="h2 font-weight-bold colorblack">My Wallet</h1>
                        <p>Check your balance, add money and see your complete transaction history here.</p>
                    </div>
                    <div class="d-flex pb-3 align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="row flex-nowrap align-items-center">
                                <div class="col-auto pr-0">
                                    <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/Payment.svg')); ?>"
                                        alt="Wallet">
                                </div>
                                <div class="col-auto pr-0">
                                    <h3 class="font22 orangecolor font-weight-semibold m-0 p-0">
                                        <span id="wallbalance"
                                            class="color-red"><?php echo e($currency['value']); ?><?php echo e($getProfile['data']['totalWalletAmount']); ?></span>

                                    </h3>
                                    <span class="font-12 colorblack font-weight-semi">Current Balance</span>
                                </div>
                            </div>
                        </div>
                        <div class=" text-right">
                            <button class="btn  btn-chat chatbrown" id="walletPlanLoader" type="button"
                                style="display:none;" disabled="">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading..
                            </button>

                            <a href="<?php echo e(route('front.walletRecharge')); ?>" class="btn btn-chat" id="btnAddMoney">Add
                                Money</a>
                        </div>
                    </div>

                    <div class="d-flex flex-nowrap nav nav-tabs">
                        <a data-toggle="tab" id="paymentLog" href="#paymentLogsTable"
                            class="text-decoration-none  colorbrown weight500 py-2 py-sm-3 px-2 px-sm-3 d-inline-block border-bottom borderbrown">
                            Payment Logs
                        </a>
                        <a data-toggle="tab" id="walletTransaction" href="#walletTransactionTable"
                            class="text-decoration-none text-dark py-2 py-sm-3 px-2 px-sm-3 d-inline-block">
                            Wallet Transaction
                        </a>
                    </div>



                    <div class="tab-content mt-3">
                        <div class="table-responsive  tab-pane fade show active" id="paymentLogsTable">
                            <div class="row pt-1 pb-3" id="historydate">
                                <div class="col-md-12">
                                    <h3 class="font16 font-weight-bold py-4">Payment Logs</h3>

                                </div>
                            </div>
                            <div class="table-container">
                            <table class="table">
                                <!-- Payment Logs Table Content -->
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Payment Mode</th>
                                        <th>Amount</th>
                                        <th>Cashback Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $getUserById['recordList'][0]['paymentLogs']['payment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $walletdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($walletdata)): ?>
                                            <tr>
                                                <td><?php echo e($walletdata['orderId']); ?></td>
                                                <td><?php echo e($walletdata['paymentMode']); ?></td>
                                                <td><?php echo e($currency['value']); ?><?php echo e(number_format($walletdata['amount'], 2)); ?>

                                                </td>
                                                <td><?php echo e($currency['value']); ?><?php echo e(number_format($walletdata['cashback_amount'], 2)); ?>

                                                </td>
                                                <?php if($walletdata['paymentStatus'] == 'success'): ?>
                                                    <td class="text-success"><?php echo e($walletdata['paymentStatus']); ?></td>
                                                <?php else: ?>
                                                    <td class="text-danger"><?php echo e($walletdata['paymentStatus']); ?></td>
                                                <?php endif; ?>
                                                <td><?php echo e($walletdata['created_at']); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        </div>

                        <div class="table-responsive  tab-pane fade" id="walletTransactionTable">
                            <div class="row pt-1 pb-3" id="historydate">
                                <div class="col-md-12">
                                    <h3 class="font16 font-weight-bold py-4">Transaction History</h3>

                                </div>
                            </div>
                            <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Transaction Details</th>
                                        <th>Amount</th>
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
                                                                <?php echo e($walletdata['transactionType']); ?> with
                                                                <?php echo e($walletdata['name']); ?> for
                                                                <?php echo e($walletdata['totalMin']); ?> minutes
                                                            <?php elseif($walletdata['transactionType'] == 'astromallOrder' && $walletdata['isCredit']==0): ?>
                                                                Product Ordered
                                                            <?php elseif($walletdata['transactionType'] == 'astromallOrder' && $walletdata['isCredit']==1): ?>
                                                            Product Cancelled
                                                            <?php elseif($walletdata['transactionType'] == 'Gift'): ?>
                                                                Sent <?php echo e($walletdata['transactionType']); ?> to
                                                                <?php echo e($walletdata['name']); ?>

                                                            <?php else: ?>
                                                                <?php echo e($walletdata['transactionType']); ?> Received
                                                            <?php endif; ?>
                                                        </h5>
                                                    </div>
                                                    <div class="font-12 text-muted">
                                                        <?php echo e(date('j-F-Y H:i a', strtotime($walletdata['created_at']))); ?>

                                                    </div>
                                                </td>
                                                <?php if($walletdata['transactionType'] == 'Cashback'): ?>
                                                <td class="text-success">
                                                    <div class="font-medium">+<?php echo e($currency['value']); ?><?php echo e($walletdata['amount']); ?></div>
                                                </td>
                                                <?php elseif($walletdata['transactionType'] == 'astromallOrder' && $walletdata['isCredit']==1): ?>
                                                <td class="text-success">
                                                    <div class="font-medium">+<?php echo e($currency['value']); ?><?php echo e($walletdata['amount']); ?></div>
                                                </td>
                                                 <?php else: ?>
                                                 <td class="text-danger">
                                                    <div class="font-medium">-<?php echo e($currency['value']); ?><?php echo e($walletdata['amount']); ?></div>
                                                </td>
                                                 <?php endif; ?>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>



                </div>


            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    $(document).ready(function(){
        $("#paymentLog").on('click',function(){
            $('#paymentLog').addClass("border-bottom borderbrown colorbrown");
            $('#paymentLog').removeClass("text-dark");
            $('#walletTransaction').removeClass("border-bottom borderbrown colorbrown");
            $('#walletTransaction').addClass("text-dark");
        });

        $("#walletTransaction").on('click',function(){
            $('#walletTransaction').addClass("border-bottom borderbrown colorbrown ");
            $('#walletTransaction').removeClass("text-dark");
            $('#paymentLog').removeClass("border-bottom borderbrown colorbrown");
            $('#paymentLog').addClass("text-dark");
        });
    });
</script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/my-wallet.blade.php ENDPATH**/ ?>