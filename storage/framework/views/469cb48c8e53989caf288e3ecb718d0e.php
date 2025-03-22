<?php $__env->startSection('subhead'); ?>
    <title>Product Detail</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $currency = DB::table('systemflag')
            ->where('name', 'Currency')
            ->select('value')
            ->first();
    ?>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Product Details</h2>
    </div>
    <!-- BEGIN: Transaction Details -->
    <?php $__currentLoopData = $astroMallDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astroMall): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="box p-5 rounded-md mt-4">

            <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <img class="tooltip rounded" src="/<?php echo e($astroMall->productImage); ?>"
                        onerror="this.onerror=null;this.src='/build/assets/images/demo.png';" alt="Product image" />

                </div>
                <div class="col-span-12 lg:col-span-7">
                    <div class=" items-center ">
                        <div class="font-medium text-base truncate" style="font-size: 25px"><?php echo e($astroMall->name); ?></div>
                        <div class="font text-base truncate mt-4"><?php echo e($astroMall->features); ?></div>
                        <div class="font-medium text-base truncate mt-3"><?php echo e($currency->value); ?> <?php echo e($astroMall->amount); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php $__currentLoopData = $astroMall->questionAnswer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card border p-2 mt-5 rounded">
                    <div class="col-span-12 lg:col-span-7">
                        <div class=" items-center ">
                            <div class="font-medium text-base truncate" style="font-size: 16px"><?php echo e($product->question); ?>

                            </div>
                            <div class="font text-base truncate "><?php echo e($product->answer); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="mt-5">
                <?php $__currentLoopData = $astroMall->productReview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="intro-y">
                        <div class="card border px-4 py-4 mb-3 flex items-center rounded">

                            <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                <img class="rounded-full" src="/<?php echo e($review->profile); ?>"
                                    onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                    alt="Astrologer image" />
                            </div>

                            <div class="ml-4 mr-auto">
                                <div class="font-medium"><?php echo e($review->userName); ?></div>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <i data-lucide="star" class="text-pending fill-pending/30 w-4 h-4 mr-1"></i>
                                        <i data-lucide="star" class="text-pending fill-pending/30 w-4 h-4 mr-1"></i>
                                        <i data-lucide="star" class="text-pending fill-pending/30 w-4 h-4 mr-1"></i>
                                        <i data-lucide="star" class="text-pending fill-pending/30 w-4 h-4 mr-1"></i>
                                        <i data-lucide="star" class="text-slate-400 fill-slate/30 w-4 h-4 mr-1"></i>
                                    </div>
                                    <div class="text-slate-500 text-xs mt-0.5">(<?php echo e($review->rating); ?>)</div>
                                    <div class="text-slate-500 text-xs mt-0.5 pl-3">
                                        <?php echo e(date('j F Y', strtotime($review->created_at))); ?></div>

                                </div>
                                <div class="font text-base mt-2"><?php echo e($review->review); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!-- END: Transaction Details -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/product-detail.blade.php ENDPATH**/ ?>