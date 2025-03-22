<?php $__env->startSection('content'); ?>
    <div class="pt-1 pb-1 bg-red d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">
                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.astrologerindex')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <a href="#"
                                style="color:white;text-decoration:none">Blogs </a>

                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid banner-container">
        <div class="container">
            <div class="banner-content">
                <h1 class="page-title">Astrology, Horoscope, Tarot And More On Blog By Astroway</h1>
                <p>Find all you want to know about Astrology, Tarot, Numerology and other divine sciences with the most
                    insightful articles and blogs on a vast range of topics about love, money, career, marriage, lifestyle
                    and more.</p>
            </div>
        </div>
    </div>

    <div class="content-wrapper ishome">
        <div class="container">

            <div class="heading recentposts h4" style="margin-top:30px;">
                Recent Posts
            </div>

            <div class="row">

                <?php $__currentLoopData = $getblog['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getblog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-4">
                        <div class="content-outer">
                            <img width="365" height="183" src="/<?php echo e($getblog['blogImage']); ?>" loading="lazy"
                                class="img-responsive" alt="11 Most Auspicious Nakshatras for Marriage">
                            <div class="content-desc mt-2">
                                <span
                                    class="author"><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $getblog['postedOn'])->format('d M, Y')); ?>

                                    by <span style="color:#B0121B"><?php echo e($getblog['author']); ?> </span></span>
                                <a class="post-title h3" href="<?php echo e(route('front.astrologers.getBlogDetails', ['id' => $getblog['id']])); ?>"
                                    style="word-break: break-all;"><?php echo e($getblog['title']); ?></a>

                                <p class="read-more" style="color:#B0121B"><a
                                        href="<?php echo e(route('front.astrologers.getBlogDetails', ['id' => $getblog['id']])); ?>"
                                        style="word-break: break-all;">Read More...</a></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.astrologers.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/astrologers/pages/blogs.blade.php ENDPATH**/ ?>