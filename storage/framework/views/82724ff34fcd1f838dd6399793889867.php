<?php $__env->startSection('content'); ?>
<style>
    .psychic-card .btn {
    min-width: 130px;
    height: 35px;
    font-size: 20px;
}
</style>
    <div class="ds-head-body">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 expert-search-section-height-favourites">
                    <h1 class="h2 font-weight-bold colorblack mb-1 mb-md-4 mt-sm-3">
                        My Followings
                    </h1>
                    <div class="list py-4 " id="expert-list">

                        <?php $__currentLoopData = $getfollowing['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getfollowing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div id="psychic-card-618160" class="psychic-card overflow-hidden  expertOnline  "
                                data-psychic-id="618160">
                                <ul class="list-unstyled d-flex mb-0">
                                    <li class="mr-3 position-relative psychic-presence status-618160"
                                        data-status="Available" data-chata="₹0" data-calla="₹ 0"><a
                                            href="<?php echo e(route('front.astrologerDetails', ['id' => $getfollowing['id']])); ?>">
                                            <div class="psyich-img position-relative"><img
                                                    src="/<?php echo e($getfollowing['profileImage']); ?>" width="80" height="80"
                                                    style="border-radius:50%;" loading="lazy">
                                            </div>
                                        </a>
                                        <div id="psychic-618160-badge" class="status-badge specific-Clr-Online"
                                            title="Online">
                                        </div>
                                        <div class="status-badge-txt text-center specific-Clr-Online"><span
                                                id="psychic-618160-badge-txt"></span></div>
                                    </li>
                                    <li class="w-100 overflow-hidden"><a
                                            href="<?php echo e(route('front.astrologerDetails', ['id' => $getfollowing['id']])); ?>"
                                            class="colorblack font-weight-semi font16 mt-0 ml-0 mr-0 mb-0 p-0 text-capitalize d-block"
                                            data-toggle="tooltip"><?php echo e($getfollowing['name']); ?></a><span
                                            class="font-12 d-block color-red"><?php echo e($getfollowing['allSkill']); ?></span><span
                                            class="font-12 d-block exp-language"><?php echo e($getfollowing['languageKnown']); ?></span><span
                                            class="font-12 d-block"> Exp :<?php echo e($getfollowing['experienceInYears']); ?></span>
                                    </li>
                                </ul>
                                <div class="">
                                    <div class="d-block">
                                        <div class="d-flex justify-content-end"><a
                                                href="<?php echo e(route('front.astrologerDetails', ['id' => $getfollowing['id']])); ?>"
                                                class="btn-block btn btn-primary" role="button"
                                               >View</a></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>
            </div>
        </div>



    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/my-following.blade.php ENDPATH**/ ?>