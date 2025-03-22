

<?php $__env->startSection('subhead'); ?>
    <title>Edit Profile</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="grid grid-cols-11 gap-x-6 mt-5 pb-20">
        <div class="intro-y col-span-12 2xl:col-span-12">
            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Edit Profile</h2>
                </div>
                <form method="POST" enctype="multipart/form-data" id="edit-profile">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input">
                                        <div>
                                            <input type="hidden" name="field_id" id="field_id" class="form-control"
                                                placeholder="Name" value="<?php echo e($user['id']); ?>">
                                            <label for="name" class="form-label">Name</label>
                                            <input id="name" name="name" type="text" class="form-control"
                                                placeholder="Name" value="<?php echo e($user['name']); ?>" required
                                                onkeypress="return Validate(event);">
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div>
                                            <label id="amount" class="form-label">Email</label>
                                            <input type="text" id="email" name="email" class="form-control"
                                                placeholder="Email" aria-describedby="input-group-3"
                                                value="<?php echo e($user['email']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div class="input">
                                        <div>
                                            <label for="productImage" class="form-label">ProfileImage</label>
                                            <img id="thumb" width="150px" src="/<?php echo e($user['profile']); ?>"
                                                alt="Profile image" onerror="this.style.display='none'"; />
                                            <input type="file" class="mt-2" name="profile" id="profile"
                                                onchange="preview()" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button class="btn btn-primary shadow-md mr-2">Edit Profile</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function preview() {
            document.getElementById("thumb").style.display = "block";
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }

        function Validate(event) {
            var regex = new RegExp("^[0-9-!@#$%&<>*?]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }
        jQuery("#edit-profile").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('editProfileApi')); ?>",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (jQuery.isEmptyObject(data.error)) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        location.href = "/admin/dashboard"
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/edit-profile.blade.php ENDPATH**/ ?>