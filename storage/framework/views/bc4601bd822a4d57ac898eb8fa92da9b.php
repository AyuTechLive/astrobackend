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
                            <i class="fa fa-chevron-right"></i> <a href="<?php echo e(route('front.getLiveAstro')); ?>"
                                style="color:white;text-decoration:none">Live Astrologers</a>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-pink">
        <div class="container">
            <div class="d-flex py-3 align-items-center justify-content-between">
                <div>
                    <h2 class="cat-heading live-session text-left text-capitalize">INTERACTIVE LIVE SESSIONS</h2>
                    <p class="cat-description pt-2 mb-0 text-left">Talk to premium Astrologers through Free Live Sessions
                    </p>
                </div>
                <div>
                    <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/livestream/live-event.png')); ?>"
                        class="img-fluid" width="74" height="70" alt="live-event">
                </div>
            </div>
        </div>
    </div>


    <div>
        <div class="container">
            <div class="row py-3 py-md-5">
                <div class="col-sm-12">
                    <h2 class="cat-heading live-home pb-2">LIVE SESSIONS</h2>
                </div>
            </div>

            <?php if($liveastro['recordList']): ?>
            <div class="d-flex flex-wrap pb-5">

                <?php $__currentLoopData = $liveastro['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $live): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="live-astrologer gif-animation-enable position-relative m-2"
                    style="background:url('<?php echo e(asset('public/frontend/astrowaycdn/astroway/category/banner/643714c2-9893-4183-85fc-ed89513a2a0d.jpg')); ?>')">
                    <div class="position-absolute top-part">
                        <span class="bg-red px-2 text-white d-inline-flex align-items-center rounded font-12"><i
                                class="fa fa-circle font-11 mr-1"></i>Live</span>
                    </div>
                    <div class="d-flex h-100 align-items-center">
                        <div class="position-relative profile-pic">
                            <?php if($live['profileImage']): ?>
                            <img src="/<?php echo e($live['profileImage']); ?>"
                                class="expert-profile-pic"  width="100" height="145" loading="lazy">
                            <?php else: ?>
                            <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>"
                            class="expert-profile-pic"  width="100" height="145" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class=" ml-2">
                            <p class="mb-0 pb-0 text-white font-16 text-capitalize"><a
                                    href="#"  class="text-white"> <?php echo e($live['name']); ?></a></p>


                        </div>
                    </div>
                    <div class="position-absolute bottom-part">
                        <a href="<?php echo e(route('front.LiveAstroDetails',['astrologerId'=>$live['astrologerId']])); ?>"
                            class="btn join-now-btn font-12 text-white d-flex align-items-center justify-content-center">Join
                            Now</a>
                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <?php else: ?>

                <h3 class="d-flex justify-content-center mb-5">No Live Astrologer Found</3>

                <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8212\htdocs\resources\views/frontend/pages/live-astrologers.blade.php ENDPATH**/ ?>