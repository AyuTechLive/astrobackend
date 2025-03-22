<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $__env->startSection('content'); ?>
<style>
    .step {
        display: none;
    }

    .step.active {
        display: block;
    }
</style>
<div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
    <div class="container">
        <div class="row afterLoginDisplay">
            <div class="col-md-12 d-flex align-items-center">

                <span style="text-transform: capitalize; ">
                    <span class="text-white breadcrumbs">
                        <a href="<?php echo e(route('front.home')); ?>" style="color:white;text-decoration:none">
                            <i class="fa fa-home font-18"></i>
                        </a>
                        <i class="fa fa-chevron-right"></i> <span class="breadcrumbtext">Astrologer Profile Update</span>
                    </span>
                </span>

            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="container py-5">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <div class="row pt-3 pb-lg-5">
            <div class="col-lg-6 col-12 order-lg-1">
                <form action="<?php echo e(route('front.updateAstrologer')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <!-- Step 1 -->
                    <input type="hidden" name="userId" value="<?php echo e($getAstrologer['recordList']['0']['userId']); ?>">
                    <input type="hidden" name="id" value="<?php echo e($getAstrologer['recordList']['0']['id']); ?>">
                    <div id="step1"
                        class="categorycontent step-1 sychics-join-form position-relative border px-4 pb-4 step active">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Personal Details</small></h2>
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="name">Name<span class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="name" value="<?php echo e($getAstrologer['recordList']['0']['name']); ?>"
                                    name="name" class="form-control rounded">

                            </div>
                            <div class="col-6 mb-3">
                                <label for="email">Email Address<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="email" id="email" value="<?php echo e($getAstrologer['recordList']['0']['email']); ?>"
                                    name="email" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="contactNo">Phone No<span class="color-red font-weight-bold">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="countryCode" value="<?php echo e($user->countryCode); ?>"
                                        name="countryCode" class="form-control rounded-left" style="max-width: 60px;">
                                    <input type="text" value="<?php echo e($getAstrologer['recordList']['0']['contactNo']); ?>"
                                        id="contactNo" name="contactNo" class="form-control rounded-right">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profileImage">Profile<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="file" class="form-control" id="profileImage" name="profileImage"
                                    style="height: 44px">

                                <?php if($getAstrologer['recordList'][0]['profileImage']): ?>
                                    <div id="imagePreviewContainer" class="mt-2">
                                        <img id="imagePreview" src="/<?php echo e($getAstrologer['recordList'][0]['profileImage']); ?>"
                                            alt="Current Profile Image" style="max-width: 100%; max-height: 200px;">
                                            <input type="hidden" id="oldProfileImage" name="oldProfileImage" value="<?php echo e($getAstrologer['recordList'][0]['profileImage'] ?? ''); ?>">
                                    </div>
                                <?php else: ?>
                                    <div id="imagePreviewContainer" class="mt-2" style="display: none;">
                                        <img id="imagePreview" src="#" alt="Profile Image Preview"
                                            style="max-width: 100%; max-height: 200px;">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div id="step2"
                        class="categorycontent step-2 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Skill Details</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="gender">Gender<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="Male" <?php echo e($getAstrologer['recordList'][0]['gender'] === 'Male' ? 'selected' : ''); ?>>Male</option>
                                    <option value="Female" <?php echo e($getAstrologer['recordList'][0]['gender'] === 'Female' ? 'selected' : ''); ?>>Female</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="birthDate">Birth Date<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="date"
                                    value="<?php echo e(date('Y-m-d', strtotime($getAstrologer['recordList'][0]['birthDate']))); ?>"
                                    name="birthDate" id="birthDate" class="form-control rounded border-pink ">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="astrologerCategoryId">Category<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="astrologerCategoryId[]"
                                    id="astrologerCategoryId" multiple>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category['id']); ?>" <?php echo e(in_array($category['id'], array_column($getAstrologer['recordList'][0]['astrologerCategoryId'], 'id')) ? 'selected' : ''); ?>><?php echo e($category['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="primarySkill">Primary Skills<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="primarySkill[]" id="primarySkill" multiple>
                                    <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($skill['id']); ?>" <?php echo e(in_array($skill['id'], array_column($getAstrologer['recordList'][0]['primarySkill'], 'id')) ? 'selected' : ''); ?>>
                                            <?php echo e($skill['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="allSkill">All Skills<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="allSkill[]" id="allSkill" multiple>
                                    <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($skill['id']); ?>" <?php echo e(in_array($skill['id'], array_column($getAstrologer['recordList'][0]['allSkill'], 'id')) ? 'selected' : ''); ?>>
                                            <?php echo e($skill['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="languageKnown">Language<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="languageKnown[]" id="languageKnown" multiple>
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($language->id); ?>" <?php echo e(in_array($language->id, array_column($getAstrologer['recordList'][0]['languageKnown'], 'id')) ? 'selected' : ''); ?>>
                                            <?php echo e($language->languageName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="charge">Add your charge(as per min)<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="<?php echo e($getAstrologer['recordList'][0]['charge']); ?>" id="charge"
                                    name="charge" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="videoCallRate">Add your video charge(as per min)<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="<?php echo e($getAstrologer['recordList'][0]['videoCallRate']); ?>"
                                    id="videoCallRate" name="videoCallRate" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="reportRate">Add your report charge<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="<?php echo e($getAstrologer['recordList'][0]['reportRate']); ?>"
                                    id="reportRate" name="reportRate" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="experienceInYears">Experience in years<span
                                        class="color-red font-weight-bold">*</span></label>

                                <input type="number" value="<?php echo e($getAstrologer['recordList'][0]['experienceInYears']); ?>"
                                    id="experienceInYears" name="experienceInYears" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="dailyContribution">How many hours you can contribute daily?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="<?php echo e($getAstrologer['recordList'][0]['dailyContribution']); ?>"
                                    id="dailyContribution" name="dailyContribution" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="hearAboutAstroguru">Where did you hear about <?php echo e($appname['value']); ?>?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['hearAboutAstroguru']); ?>"
                                    id="hearAboutAstroguru" name="hearAboutAstroguru" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Are you working on any other platform?<span
                                        class="color-red font-weight-bold">*</span></label><br>
                                <input type="radio" id="astro-yes" name="isWorkingOnAnotherPlatform" value="1" <?php echo e(isset($getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform']) && $getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform'] == '1' ? 'checked' : ''); ?>> Yes
                                <input type="radio" id="astro-no" name="isWorkingOnAnotherPlatform" value="0" <?php echo e(isset($getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform']) && $getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform'] == '0' ? 'checked' : ''); ?>> No
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div id="step3"
                        class="categorycontent step-3 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Other Details</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="whyOnBoard">Why do you think we should onboard you?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="awhyOnBoard" name="whyOnBoard" class="form-control rounded"
                                    value="<?php echo e($getAstrologer['recordList'][0]['whyOnBoard']); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="interviewSuitableTime">What is suitable time for interview?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="interviewSuitableTime" name="interviewSuitableTime"
                                    class="form-control rounded"
                                    value="<?php echo e($getAstrologer['recordList'][0]['interviewSuitableTime']); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="currentCity">Which city do you currently live in?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="currentCity" name="currentCity" class="form-control rounded"
                                    value="<?php echo e($getAstrologer['recordList'][0]['currentCity']); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="mainSourceOfBusiness">Main Source of business(Other than astrology)?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="mainSourceOfBusiness" id="mainSourceOfBusiness">
                                    <?php $__currentLoopData = $mainSourceBusiness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($source->jobName); ?>" <?php echo e($getAstrologer['recordList'][0]['mainSourceOfBusiness'] == $source->jobName ? 'selected' : ''); ?>>
                                            <?php echo e($source->jobName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="highestQualification">Select your qualification<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="highestQualification" id="highestQualification">
                                    <?php $__currentLoopData = $highestQualification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value='<?php echo e($highest->qualificationName); ?>' <?php echo e($getAstrologer['recordList'][0]['highestQualification'] == $highest->qualificationName ? 'selected' : ''); ?>>
                                            <?php echo e($highest->qualificationName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="degree">Degree / Diploma<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="degree" id="degree">
                                    <?php $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qua): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value='<?php echo e($qua->degreeName); ?>' <?php echo e($getAstrologer['recordList'][0]['degree'] == $highest->degree ? 'selected' : ''); ?>>
                                            <?php echo e($qua->degreeName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="college">College/School/University name<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['college']); ?>" id="college"
                                    name="college" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="learnAstrology">From where did you learn Astrology?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['learnAstrology']); ?>"
                                    id="learnAstrology" name="learnAstrology" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="instaProfileLink">Instagram profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['instaProfileLink']); ?>"
                                    id="instaProfileLink" name="instaProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="facebookProfileLink">Facebook profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['facebookProfileLink']); ?>"
                                    id="facebookProfileLink" name="facebookProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="linkedInProfileLink">LinkedIn profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['linkedInProfileLink']); ?>"
                                    id="linkedInProfileLink" name="linkedInProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="youtubeChannelLink">Youtube profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['youtubeChannelLink']); ?>"
                                    id="youtubeChannelLink" name="youtubeChannelLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="websiteProfileLink">Website profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['websiteProfileLink']); ?>"
                                    id="websiteProfileLink" name="websiteProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Did anybody referred you?<span
                                        class="color-red font-weight-bold">*</span></label><br>
                                <input type="radio" id="astro-yes" name="isAnyBodyRefer" value="1" <?php echo e(isset($getAstrologer['recordList'][0]['isAnyBodyRefer']) && $getAstrologer['recordList'][0]['isAnyBodyRefer'] == '1' ? 'checked' : ''); ?>> Yes
                                <input type="radio" id="astro-no" name="isAnyBodyRefer" value="0" <?php echo e(isset($getAstrologer['recordList'][0]['isAnyBodyRefer']) && $getAstrologer['recordList'][0]['isAnyBodyRefer'] == '0' ? 'checked' : ''); ?>> No
                            </div>

                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div id="step4"
                        class="categorycontent step-4 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Other Details</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="minimumEarning">Minimum Earning Expection<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['minimumEarning']); ?>"
                                    id="minimumEarning" name="minimumEarning" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="maximumEarning">Maximum Earning Expection<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="<?php echo e($getAstrologer['recordList'][0]['maximumEarning']); ?>"
                                    id="maximumEarning" name="maximumEarning" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="NoofforeignCountriesTravel">Number of the foreign countries you lived/travel
                                    to?<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="NoofforeignCountriesTravel"
                                    id="NoofforeignCountriesTravel">
                                    <?php $__currentLoopData = $countryTravel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $travel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($travel->NoOfCountriesTravell); ?>" <?php echo e($getAstrologer['recordList'][0]['NoofforeignCountriesTravel'] == $travel->NoOfCountriesTravell ? 'selected' : ''); ?>>
                                            <?php echo e($travel->NoOfCountriesTravell); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="currentlyworkingfulltimejob">Are you currently working a fulltime job?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="currentlyworkingfulltimejob"
                                    id="currentlyworkingfulltimejob">
                                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $working): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($working->workName); ?>" <?php echo e($getAstrologer['recordList'][0]['currentlyworkingfulltimejob'] == $working->workName ? 'selected' : ''); ?>>
                                            <?php echo e($working->workName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="loginBio">Long Bio<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="loginBio" name="loginBio"
                                    class="form-control rounded"><?php echo e($getAstrologer['recordList'][0]['loginBio']); ?></textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="goodQuality">What are some good qualities of perfect astrologer?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <textarea id="goodQuality" name="goodQuality"
                                    class="form-control rounded"><?php echo e($getAstrologer['recordList'][0]['goodQuality']); ?></textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="biggestChallenge">What was the biggest challenge you faced and how did you
                                    overcome it?<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="biggestChallenge" name="biggestChallenge"
                                    class="form-control rounded"><?php echo e($getAstrologer['recordList'][0]['biggestChallenge']); ?></textarea>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="whatwillDo">A customer is asking the same question repeatedly: what will you
                                    do?<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="whatwillDo" name="whatwillDo"
                                    class="form-control rounded"><?php echo e($getAstrologer['recordList'][0]['whatwillDo']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    
                    <div id="step5"
                        class="categorycontent step-4 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Your Availability</small>
                        </h2>
                        <div class="row">
                            <?php
                                $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            ?>

                            <?php $__currentLoopData = $daysOfWeek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-12 mb-3">
                                    <label><?php echo e($day); ?></label>
                                    <input type="hidden" name="astrologerAvailability[<?php echo e($index); ?>][day]"
                                        value="<?php echo e($day); ?>">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="<?php echo e(strtolower($day)); ?>-from">From Time</label>
                                            <input type="time" id="<?php echo e(strtolower($day)); ?>-from"
                                                name="astrologerAvailability[<?php echo e($index); ?>][time][0][fromTime]"
                                                class="form-control rounded" placeholder="From Time"
                                                value="<?php echo e(isset($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['fromTime']) ? date('H:i', strtotime($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['fromTime'])) : ''); ?>">
                                        </div>
                                        <div class="col-6">
                                            <label for="<?php echo e(strtolower($day)); ?>-to">To Time</label>
                                            <input type="time" id="<?php echo e(strtolower($day)); ?>-to"
                                                name="astrologerAvailability[<?php echo e($index); ?>][time][0][toTime]"
                                                class="form-control rounded" placeholder="To Time"
                                                value="<?php echo e(isset($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['toTime']) ? date('H:i', strtotime($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['toTime'])) : ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <button class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                id="btnSave">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 sychics-join-info pt-lg-0 pt-5">
                <h2><small class="font-weight-bold">BECOME "<?php echo e(strtoupper($appname['value'])); ?> VERIFIED" ASTROLOGER</small></h2>
                <p>
                    <?php echo e($appname['value']); ?>, one of the best online astrology portals gives you a chance to be a part of
                    its community
                    of best and top-notch Astrologers. Become a part of the team of Astrologers and offer your
                    consultations to clients from all across the globe, &amp; create an online, personalized brand
                    presence.
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
    <?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%' // Ensure Select2 dropdown takes full width of the parent
            });
        });

        let currentStep = 1;
        const totalSteps = 5;

        function nextStep() {
            if (currentStep < totalSteps) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep++;
                document.getElementById('step' + currentStep).classList.add('active');
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep--;
                document.getElementById('step' + currentStep).classList.add('active');
            }
        }


    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileImageInput = document.getElementById('profileImage');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            profileImageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '#';
                    imagePreviewContainer.style.display = 'none';
                }
            });
        });
    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.astrologers.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/astrologers/pages/profileupdate.blade.php ENDPATH**/ ?>