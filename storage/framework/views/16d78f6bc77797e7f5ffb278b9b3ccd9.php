<style>
    .btn-cancel{
        background: gold !important;
        box-shadow: 0 2px 3px #ffd70080 !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        border-radius: 40px !important;

        white-space: nowrap !important;
    }

    .table td, .table th {
        vertical-align: baseline !important;

    }
    .btn.view-pdf {

    border-radius: 30px;
    font-size: 15px;
    padding: 8px 30px;
    box-shadow: 0 3px 6px #ee4e5e29;
    font-weight: 500;
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
                                style="color:white;text-decoration:none">My Orders</a>
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
                        <h1 class="h2 font-weight-bold colorblack">My Orders</h1>
                        <p>Check your orders history here.</p>
                    </div>


                    <div class="row pt-1 pb-3" id="historydate">
                        <div class="col-md-12">
                            <h3 class="font16 font-weight-bold py-4">Orders History</h3>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-red text-white">
                                <tr>
                                    <th class="font-weight-semi-bold text-center">
                                      Invoice
                                    </th>
                                    <th class="font-weight-semi-bold text-center">
                                        Product Name
                                    </th>

                                    <th class="font-weight-semi-bold text-center">
                                        Image

                                    </th>

                                    <th class="font-weight-semi-bold text-center">
                                        Price

                                    </th>
                                    <th class="font-weight-semi-bold text-center">
                                        Tax

                                    </th>
                                    <th class="font-weight-semi-bold text-center">
                                        Total
                                    </th>

                                    <th class="font-weight-semi-bold text-center">
                                        Status
                                    </th>
                                    <th class="font-weight-semi-bold text-center">
                                        Date
                                    </th>
                                    <th class="font-weight-semi-bold text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php $__currentLoopData = $getUserById['recordList'][0]['orders']['order']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($orderdata)): ?>
                                    <tr>
                                        <td><a class="colorblack btn view-pdf" href="<?php echo e($orderdata['invoice_link']); ?>"><i class="fa-solid fa-file-pdf color-red"></i></a></td>
                                        <td><?php echo e($orderdata['productName']); ?></td>
                                        <td><img src="/<?php echo e($orderdata['productImage']); ?>" alt="User" class="img-fluid"></td>
                                        <td><?php echo e($orderdata['productAmount']); ?></td>
                                        <td><?php echo e($orderdata['gstPercent']); ?>%</td>
                                        <td><?php echo e($orderdata['totalPayable']); ?></td>
                                        <?php if($orderdata['orderStatus']=='Pending'): ?>
                                            <td class="text-warning"><?php echo e($orderdata['orderStatus']); ?></td>
                                        <?php elseif($orderdata['orderStatus']=='Cancelled'): ?>
                                            <td class="text-danger"><?php echo e($orderdata['orderStatus']); ?></td>
                                        <?php else: ?>
                                            <td class="text-success"><?php echo e($orderdata['orderStatus']); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo e($orderdata['created_at']); ?></td>
                                        <td>
                                            <?php if($orderdata['orderStatus']!='Cancelled' && $orderdata['orderStatus']!='Delivered'): ?>
                                                <form class="cancel-form">
                                                    <input type="hidden" value="<?php echo e($orderdata['id']); ?>" name="id">
                                                    <a class="btn btn-cancel cancel-btn">Cancel</a>
                                                </form>
                                            <?php endif; ?>
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

<?php $__env->startSection('scripts'); ?>

<script>
$(document).ready(function() {
    $('.cancel-btn').click(function(e) {
        e.preventDefault();



        <?php
            use Symfony\Component\HttpFoundation\Session\Session;
            $session = new Session();
            $token = $session->get('token');
        ?>

        Swal.fire({
            title: 'Are you sure you want to cancel the order?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = $(this).closest('.cancel-form').serialize();
                // console.log(formData);

                $.ajax({
                    url: '<?php echo e(route("api.cancelOrder",['token' => $token])); ?>',
                    type: 'POST',
                    data: formData,

                    success: function(response) {
                        toastr.success('Order Cancelled Successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = JSON.parse(xhr.responseText).error.paymentMethod[0];
                        toastr.error(errorMessage);
                    }
                });
            }
        });
    });
});

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/my-orders.blade.php ENDPATH**/ ?>