

<?php $__env->startSection('subhead'); ?>
    <title>Recharge Amount</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Recharge Amount</h2>
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-skill"
        class="d-inline mt-10 btn btn-primary shadow-md mr-2 addbtn">Add
        Amount</a>
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <?php if(count($rechargeAmount) > 0): ?>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible withoutsearch">
            <table class="table table-report" aria-label="skill">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Amount</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0; ?>
                    <?php
                        $currency = DB::table('systemflag')
                            ->where('name', 'Currency')
                            ->select('value')
                            ->first();
                    ?>
                    <?php $__currentLoopData = $rechargeAmount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>
                            <td>

                                <div class="font-medium whitespace-nowrap"><?php echo e($currency->value); ?><?php echo e($item->amount); ?>

                                </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a id="editbtn" href="javascript:;" onclick="delbtn(<?php echo e($item->id); ?>)"
                                        value="<?php echo e($item->id); ?>" class="flex items-center text-danger"
                                        data-tw-target="#delete-confirmation-modal" data-tw-toggle="modal"><i
                                            data-lucide="trash-2" class="editbtn w-4 h-4 mr-1"></i>Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="intro-y" style="height:100%">
            <div style="display:flex;align-items:center;height:100%;">
                <div style="margin:auto">
                    <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
                    <h3 class="text-center">No Data Available</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- END: Data List -->
    <div id="add-skill" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Add Recharge Amount </h2>
                </div>

                <div id="form-validation" class="p-5">
                    <div class="preview">
                        <form action="<?php echo e(route('addRechargeAmount')); ?>" method="POST" enctype="multipart/form-data"
                            id="add-form">
                            <?php echo csrf_field(); ?>
                            <div class="input-form">
                                <label for="name" class="form-label w-full flex flex-col sm:flex-row">
                                    Amount
                                </label>
                                <input type="text" name="amount" id="amount" class="form-control"
                                    placeholder="Amount" required onKeyDown="numbersOnly(event)">
                                <div class="text-danger print-amount-error-msg mb-2" style="display:none">
                                    <ul></ul>
                                </div>
                            </div>
                            <div class="mt-5"><button type="submit"
                                    class="btn btn-primary shadow-md mr-2 validate-form btn-recharge-submit">Add
                                    Recharge Amount</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- BEGIN: Pagination -->
    <?php if(count($rechargeAmount) > 0): ?>
        <?php if($totalRecords > 0): ?>
            <div>
                <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
                    <?php echo e($totalRecords); ?> entries</div>
        <?php endif; ?>
        <div class="d-inline addbtn intro-y col-span-12">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('rechargeAmount', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('rechargeAmount', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('rechargeAmount', ['page' => $page + 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>

                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process
                            cannot be undone.</div>
                    </div>

                    <form action="<?php echo e(route('deleteRechargeAmount')); ?> " method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <input type="hidden" id="del_id" name="del_id">
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                            <button class="btn btn-danger w-24"><?php echo method_field('DELETE'); ?>Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function delbtn($id) {
            $('#del_id').val($id);
        }

        function numbersOnly(e) {
            var keycode = e.keyCode;
            if ((keycode < 48 || keycode > 57) && (keycode < 96 || keycode > 105) && keycode !=
                9 && keycode != 8 && keycode != 37 && keycode != 38 && keycode != 39 && keycode != 40 && keycode != 46) {
                e.preventDefault();
            }
        }

        function printErrorMsg(msg) {
            jQuery(".print-amount-error-msg").find("ul").html('');
            jQuery.each(msg, function(key, value) {
                if (key == 'amount') {
                    jQuery(".print-amount-error-msg").css('display', 'block');
                    jQuery(".print-amount-error-msg").find("ul").append('<li>' + value + '</li>');
                }
            });
        }
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/recharge-amount.blade.php ENDPATH**/ ?>