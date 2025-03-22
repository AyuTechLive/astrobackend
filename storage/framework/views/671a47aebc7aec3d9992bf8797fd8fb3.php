<?php $__env->startSection('subhead'); ?>
    <title>Settings</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <form method="POST" enctype="multipart/form-data" id="edit-form">
        <?php echo csrf_field(); ?>
        <h2 class="d-inline intro-y text-lg font-medium mt-10">Settings</h2>
        <button type="submit"class="btn btn-primary shadow-md mr-2 d-inline addbtn mt-10">Save
        </button>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible ">
            </div>
        </div>
        <div id="link-tab" class="p-3">
            <ul class="nav nav-link-tabs" role="tablist">
                <?php $__currentLoopData = $flagGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li id="<?php echo e($loop->index); ?>" class="nav-item flex-1 <?php echo e($loop->first ? 'active' : ''); ?>"
                        role="presentation">
                        <button class="nav-link w-full py-2 <?php echo e($loop->first ? 'active' : ''); ?>" data-tw-toggle="pill"
                            data-tw-target="#<?php echo e($group->flagGroupName); ?>" type="button" role="tab"
                            aria-controls="<?php echo e($group->flagGroupName); ?>" aria-selected="true">
                            <?php echo e($group->flagGroupName); ?>

                        </button>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="setting tab-content mt-5 mastertab">
                <?php $__currentLoopData = $flagGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupIndex => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div id="<?php echo e($group->flagGroupName); ?>"
                        class="tab-pane leading-relaxed <?php echo e($loop->first ? 'active' : ''); ?>" role="tabpanel"
                        aria-labelledby="example-1-tab">
                        <?php if(count($group->systemFlag) > 0): ?>
                            <?php $__currentLoopData = $group->systemFlag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $systemFlagIndex => $systemFlag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($systemFlag->valueType == 'Text'): ?>
                                    <div>
                                        <label for="validation-form-2"
                                            class="form-label w-full flex flex-col sm:flex-row mt-2">
                                            <?php echo e($systemFlag->displayName); ?>

                                            <?php if($systemFlag->description): ?>
                                                <a class="systooltip"><i class="fa fa-info-circle w-4 h-4 ml-1"
                                                        style="margin-top:4px"></i>
                                                    <span class="tooltiptext"><?php echo e($systemFlag->description); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </label>
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]"
                                            value="<?php echo e($systemFlag->name); ?>">
                                        <input onkeypress="return validateJavascript(event);" type="text"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value]"
                                            class="form-control" value="<?php echo e($systemFlag->value); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if($systemFlag->valueType == 'Number'): ?>
                                    <div>
                                        <label for="validation-form-2"
                                            class="form-label w-full flex flex-col sm:flex-row mt-2">
                                            <?php echo e($systemFlag->displayName); ?>

                                            <?php if($systemFlag->description): ?>
                                                <a class="systooltip"><i class="fa fa-info-circle w-4 h-4 ml-1"
                                                        style="margin-top:4px"></i>
                                                    <span class="tooltiptext"><?php echo e($systemFlag->description); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </label>
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]"
                                            value="<?php echo e($systemFlag->name); ?>">
                                        <input type="number"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value]"
                                            class="form-control" required value="<?php echo e($systemFlag->value); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if($systemFlag->valueType == 'Radio'): ?>
                                    <div>
                                        <label for="validation-form-2"
                                            class="form-label w-full flex flex-col sm:flex-row mt-2">
                                            <?php echo e($systemFlag->displayName); ?>

                                            <?php if($systemFlag->description): ?>
                                                <a class="systooltip"><i class="fa fa-info-circle w-4 h-4 ml-1"
                                                        style="margin-top:4px"></i>
                                                    <span class="tooltiptext"><?php echo e($systemFlag->description); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </label>
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]"
                                            value="<?php echo e($systemFlag->name); ?>">

                                        <?php if($systemFlag->name == 'FirstFreeChat'): ?>
                                            <div class="flex flex-col sm:flex-row mt-2">
                                                <div class="form-check mr-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value]"
                                                        value='1'
                                                        <?php echo e($systemFlag->value == '1' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="radio-switch-4">Yes</label>
                                                </div>
                                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                                    <input class="form-check-input" type="radio"
                                                        name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value]"
                                                        value='0' <?php echo e($systemFlag->value == '0' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="radio-switch-5">No</label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($systemFlag->valueType == 'File'): ?>
                                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4 xl:col-span-4  d-inline">
                                        <div class="box p-5  mt-2 text-center">
                                            <label for="validation-form-2" class="form-label w-full  mt-2">
                                                <?php echo e($systemFlag->displayName); ?>

                                            </label>
                                            <input type="hidden"
                                                name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][valueType]"
                                                value="<?php echo e($systemFlag->valueType); ?>">
                                            <input type="hidden"
                                                name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]"
                                                value="<?php echo e($systemFlag->name); ?>">
                                            <div class="settingimg">
                                                <img id="<?php echo e($systemFlag->name); ?>" src="/<?php echo e($systemFlag->value); ?>"
                                                    width="150px" alt="gift">
                                            </div>
                                            <div>
                                                <input type="file" class="mt-2"
                                                    name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value]"
                                                    id="image" onchange="previews('<?php echo e($systemFlag->name); ?>')"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($systemFlag->valueType == 'MultiSelect'): ?>
                                    <div>
                                        <label for="validation-form-2"
                                            class="form-label w-full flex flex-col sm:flex-row mt-2">
                                            <?php echo e($systemFlag->displayName); ?>

                                            <?php if($systemFlag->description): ?>
                                                <a class="systooltip"><i class="fa fa-info-circle w-4 h-4 ml-1"
                                                        style="margin-top:4px"></i>
                                                    <span class="tooltiptext"><?php echo e($systemFlag->description); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </label>
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]"
                                            value="<?php echo e($systemFlag->name); ?>">
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][valueType]"
                                            value="<?php echo e($systemFlag->valueType); ?>">
                                        <select
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value][]"
                                            class="form-control select2 language" multiple
                                            data-placeholder="Choose Language">
                                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value=<?php echo e($lan->id); ?>>
                                                    <?php echo e($lan->languageName); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <?php if($systemFlag->valueType == 'MultiSelectWebLang'): ?>
                                <?php
                                    // Decode JSON if necessary
                                    $selectedLanguages = json_decode($systemFlag->value, true) ?: [];
                                ?>
                                <div>
                                    <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row mt-2">
                                        <?php echo e($systemFlag->displayName); ?>

                                        <?php if($systemFlag->description): ?>
                                            <a class="systooltip">
                                                <i class="fa fa-info-circle w-4 h-4 ml-1" style="margin-top:4px"></i>
                                                <span class="tooltiptext"><?php echo e($systemFlag->description); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </label>
                                    <input type="hidden" name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]" value="<?php echo e($systemFlag->name); ?>">
                                    <input type="hidden" name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][valueType]" value="<?php echo e($systemFlag->valueType); ?>">
                                    <select name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value][]" class="form-control select2 " multiple data-placeholder="Choose Language">
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($lan->languageCode); ?>" <?php echo e(in_array($lan->languageCode, $selectedLanguages) ? 'selected' : ''); ?>>
                                                <?php echo e($lan->languageName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                                <?php if($systemFlag->valueType == 'Video'): ?>
                                    <div>
                                        <label for="image"
                                            class="form-label mt-2"><?php echo e($systemFlag->displayName); ?></label>
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][valueType]"
                                            value="<?php echo e($systemFlag->valueType); ?>">
                                        <input type="hidden"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][name]"
                                            value="<?php echo e($systemFlag->name); ?>">
                                        <video controls id="editMyVideo" style="width:150px;object-fit:cover"
                                            preload="metadata">
                                            <source id="blogvideo" type="video/mp4" src="/<?php echo e($systemFlag->value); ?>">
                                            <track label="English" kind="subtitles" srclang="en" default />
                                        </video>
                                        <input type="file" id="blogImage"
                                            name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][value]"
                                            onchange="editVideoPreviews('<?php echo e($systemFlag->name); ?>',<?php echo e($loop->index); ?>)"
                                            accept="video/mp4">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if(count($group->subGroup) > 0): ?>
                            <?php $__currentLoopData = $group->subGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subGroupIndex => $subGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <h4 class="my-4 text-lg font-medium <?php echo e(strtolower(str_replace(" ","_",$subGroup->flagGroupName))); ?>"> <?php echo e(ucwords($subGroup->flagGroupName)); ?>

                                <?php if($subGroup->description): ?>
                                    <a class="systooltip"><i class="fa fa-info-circle w-4 h-4 ml-1"
                                            style="margin-top:4px"></i>
                                        <span class="tooltiptext"><?php echo e($subGroup->description); ?></span>
                                    </a>
                                <?php endif; ?>
                            </h4>
                                <?php if($subGroup->parentFlagGroupId==2): ?>
                                <div class="mb-2">
                                    <input type="hidden" value="<?php echo e($subGroup->id); ?>" name="flaggroups[<?php echo e($subGroup->id); ?>][id]">
                                    <label>
                                        <input class="form-check-input" type="radio" name="flaggroups[<?php echo e($subGroup->id); ?>][isActive]" value="1" <?php echo e($subGroup->isActive ? 'checked' : ''); ?>>
                                        Enable
                                    </label>
                                    <label>
                                        <input class="form-check-input" type="radio" name="flaggroups[<?php echo e($subGroup->id); ?>][isActive]" value="0" <?php echo e(!$subGroup->isActive ? 'checked' : ''); ?>>
                                        Disable
                                    </label>
                                </div>
                                
                                <?php endif; ?>
                                <div class="box p-3 <?php echo e(strtolower(str_replace(" ","_",$subGroup->flagGroupName))); ?>">
                                    <?php if($subGroup->flagGroupName == "AstrologyAPI"): ?>
                                        <select name="astroApiCallType" id="astroApiCallType">
                                            
                                            <option value="3" <?php echo e($astroApiCallType == 3 ? 'selected' : ''); ?>>Vedic Astro API</option>
                                        </select>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $subGroup->systemFlag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $systemFlagInd => $systemFlag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($systemFlag->valueType == 'Text'): ?>
                                    <?php if($systemFlag->name != 'AstrologyApiUserId' && $systemFlag->name != 'AstrologyApiKey'): ?>
                                        <div>
                                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row mt-2">
                                                <?php echo e($systemFlag->displayName); ?>

                                            </label>
                                            <input type="hidden" name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][name]" value="<?php echo e($systemFlag->name); ?>">
                                            <input onkeypress="return validateJavascript(event);" type="text" name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]" class="form-control" value="<?php echo e($systemFlag->value); ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                        <?php if($systemFlag->valueType == 'Number'): ?>
                                            <div>
                                                <label for="validation-form-2"
                                                    class="form-label w-full flex flex-col sm:flex-row mt-2">
                                                    <?php echo e($systemFlag->displayName); ?>

                                                </label>
                                                <input type="hidden"
                                                    name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][name]"
                                                    value="<?php echo e($systemFlag->name); ?>">
                                                <input type="number"
                                                    name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                    class="form-control" required value="<?php echo e($systemFlag->value); ?>">
                                            </div>
                                        <?php endif; ?>
                                        <?php if($systemFlag->valueType == 'Radio'): ?>
                                        <div>
                                            <label for="validation-form-2"
                                                class="form-label w-full flex flex-col sm:flex-row mt-2">
                                                <?php echo e($systemFlag->displayName); ?>

                                            </label>
                                            <input type="hidden"
                                                name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][name]"
                                                value="<?php echo e($systemFlag->name); ?>">

                                            <?php if($groupIndex==3): ?>
                                                <div class="flex flex-col sm:flex-row mt-2">
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input bucket_radio" type="radio"
                                                            name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                            value='google_bucket'
                                                            <?php echo e($systemFlag->value == 'google_bucket' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="radio-switch-4">Google Bucket</label>
                                                    </div>
                                                    <div class="form-check mr-2 mt-2 sm:mt-0">
                                                        <input class="form-check-input bucket_radio" type="radio"
                                                            name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                            value='aws_bucket'
                                                            <?php echo e($systemFlag->value == 'aws_bucket' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label"
                                                            for="radio-switch-5">AWS Bucket</label>
                                                    </div>
                                                </div>
                                            <?php else: ?>

                                            <div class="flex flex-col sm:flex-row mt-2">
                                                <div class="form-check mr-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                        value='RazorPay'
                                                        <?php echo e($systemFlag->value == 'RazorPay' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="radio-switch-4">Razor
                                                        Pay</label>
                                                </div>
                                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                                    <input class="form-check-input" type="radio"
                                                        name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                        value='Stripe'
                                                        <?php echo e($systemFlag->value == 'Stripe' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label"
                                                        for="radio-switch-5">Stripe</label>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                        <?php if($systemFlag->valueType == 'File'): ?>
                                            <div
                                                class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4 xl:col-span-4 d-inline">
                                                <div class="box p-5  mt-2 text-center">
                                                    <label for="validation-form-2" class="form-label w-full mt-2">
                                                        <?php echo e($systemFlag->displayName); ?>

                                                    </label>
                                                    <input type="hidden"
                                                        name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][valueType]"
                                                        value="<?php echo e($systemFlag->valueType); ?>">
                                                    <input type="hidden"
                                                        name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][name]"
                                                        value="<?php echo e($systemFlag->name); ?>">
                                                    <div class="settingimg">
                                                        <img id="<?php echo e($systemFlag->name); ?>"src="/<?php echo e($systemFlag->value); ?>"
                                                            width="150px" alt="gift">
                                                    </div>
                                                    <div>
                                                        <input type="file" class="mt-2"
                                                            name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                            id="image"
                                                            onchange="previews('<?php echo e($systemFlag->name); ?>')"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($systemFlag->valueType == 'Video'): ?>
                                            <div>
                                                <label for="image"
                                                    class="form-label mt-2"><?php echo e($systemFlag->displayName); ?></label>
                                                <input type="hidden"
                                                    name="group[<?php echo e($groupIndex); ?>][systemFlag][<?php echo e($loop->index); ?>][valueType]"
                                                    value="<?php echo e($systemFlag->valueType); ?>">
                                                <input type="hidden"
                                                    name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][name]"
                                                    value="<?php echo e($systemFlag->name); ?>">
                                                <video controls id="editMyVideo" style="width:150px;object-fit:cover"
                                                    preload="metadata">
                                                    <source id="blogvideo" type="video/mp4"
                                                        src="/<?php echo e($systemFlag->value); ?>">
                                                    <track label="English" kind="subtitles" srclang="en" default />
                                                </video>
                                                <input type="file" id="blogImage"
                                                    name="group[<?php echo e($groupIndex); ?>][subGroup][<?php echo e($subGroupIndex); ?>][systemFlag][<?php echo e($systemFlagInd); ?>][value]"
                                                    onchange="editVideoPreviews('<?php echo e($systemFlag->name); ?>',<?php echo e($loop->index); ?>)"
                                                    accept="video/mp4">
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"  ></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery('.select2').select2({
                allowClear: true,
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });

        var flagGroup = <?php echo e(Js::from($flagGroup)); ?>;
        language = flagGroup.filter(c => c.flagGroupName == 'General');
        language = language[0].systemFlag.filter(c => c.name == 'Language')
        languageKnown = language[0].value.split(',')
        $('.language').val(languageKnown).trigger('change');


        function previews(id) {
            document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
        }

        function editVideoPreviews(id, index) {
            document.getElementById("editMyVideo").style.display = "block";
            blogvideo.src = URL.createObjectURL(event.target.files[0]);
            editMyVideo.load();
            editMyVideo.onended = function() {
                URL.revokeObjectURL(editMyVideo.currentSrc);
            };
            document.getElementById("editMyVideo").controls = true;

        }
    </script>
    <script>
        var spinner = $('.loader');
        jQuery(function() {
            jQuery('#edit-form').submit(function(e) {
                e.preventDefault();
                spinner.show();
                var data = new FormData(this);
                
                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('editSystemFlag')); ?>",
                    data: data,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                     
                        if (jQuery.isEmptyObject(data.error)) {
                            spinner.hide();
                            location.reload();
                        } else {
                            spinner.hide();
                        }
                    }
                });
            });
        });

        $(window).on('load', function() {
            $('.loader').hide();
        });

        function validateJavascript(event) {
            var regex = new RegExp("^[<>]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }

        $(document).on('change','.bucket_radio',function(){
            changeBucketBlock($(this).val());
        });

        function changeBucketBlock(val)
        {
            if(val=='aws_bucket')
            {
                $('.aws_bucket').show();
                $('.google_bucket').hide();
            }
            else
            {
                $('.aws_bucket').hide();
                $('.google_bucket').show();
            }
        }
        $(document).ready(function(){
            changeBucketBlock($('.bucket_radio[checked]').val());
        });
        var select_bucket = $('.select_bucket');        
        $("#ThirdPartyPackage .agora")[1].after(select_bucket[0],select_bucket[1]);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/system-flag.blade.php ENDPATH**/ ?>