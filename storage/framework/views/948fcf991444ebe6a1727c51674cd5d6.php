<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row pt-3 pb-lg-5">
            <div class="col-lg-6 col-12 order-lg-1">
                <div id="step1" class="categorycontent step-1 sychics-join-form position-relative border px-4 pb-4">
                    <h2 class="py-3 text-center"><small class="font-weight-bold">Astrologer Sign Up</small></h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Name">First Name<span class="color-red font-weight-bold">*</span></label>
                            <input type="text" id="psychics-first-name" maxlength="60"
                                onkeypress="return isCharKey(this)" class="form-control rounded">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="Name">Email Address<span class="color-red font-weight-bold">*</span></label>
                            <input type="text" id="psychics-email" class="form-control rounded">
                        </div>
                        <div class="col-6">
                            <label for="Name">Mobile<span class="color-red font-weight-bold">*</span></label>
                            <input class="form-control ccode select2" id="MobCode"
                            name="MobCode" placeholder="+91" style="width:20%">
                        <input class="form-control mobilenumber text-box single-line"
                            id="ContactMobile" name="ContactMobile"
                            placeholder="Enter Mobile Number" type="text"
                            value="" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-dark">
                                <small>
                                    <input type="checkbox" id="tandc" class="align-baseline">

                                    I Agree To Anytime Astro Astrologers <a class="text-dark"
                                        style="color:#EE4E5E !important"
                                        href="https://expert.anytimeastro.com/expert-terms-of-use" target="_blank">Terms
                                        Of Use</a>&nbsp;and&nbsp;<a class="text-dark" style="color:#EE4E5E !important"
                                        href="https://expert.anytimeastro.com/expert-privacy-policy"
                                        target="_blank">Privacy Policy</a>

                                </small>
                            </label>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="processForOtp();">Sign Up</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 sychics-join-info pt-lg-0 pt-5">
                <h2><small class="font-weight-bold">BECOME "ANYTIME ASTRO VERIFIED" ASTROLOGER: <b
                            class="color-red font-weight-bold">JOIN NOW!</b></small></h2>
                <p>
                    Anytime Astro, one of the best online astrology portals gives you a chance to be a part of its community
                    of best and top-notch Astrologers. Become a part of the team of 1500+ Astrologers and offer your
                    consultations to clients from all across the globe, &amp; create an online, personalized brand presence.
                </p>
                <div class="row py-2">
                    <div class="col-sm-4 col-12 mb-sm-0 mb-3">
                        <div class="border border-danger rounded text-center p-3 h-100">
                            <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/verified-icon.svg')); ?>"
                                class="mb-1">
                            <span class="d-block font-weight-bold">Verified Expert</span>
                            <p class="mb-0">Astrologers</p>
                        </div>
                    </div>

                    <div class="col-sm-4 col-12 mb-sm-0 mb-3">
                        <div class="border border-danger rounded text-center p-3 h-100">
                            <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/24-availability-icon.svg')); ?>"
                                class="mb-1">
                            <span class="d-block font-weight-bold">24/7</span>
                            <p class="mb-0">Availability</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/pages/astrologer-registration.blade.php ENDPATH**/ ?>