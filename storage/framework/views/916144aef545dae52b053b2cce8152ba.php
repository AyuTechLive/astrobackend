<?php $__env->startSection('subhead'); ?>
    <title>Edit Customer</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 mt-2">

            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Edit Customer</h2>
                </div>
                <form method="POST" enctype="multipart/form-data" id="edit-form">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input">
                                        <div>
                                            <input type="hidden" name="field_id" id="field_id" class="form-control"
                                                placeholder="Customer Name" value="<?php echo e($customer['id']); ?>">
                                            <label for="regular-form-1" class="form-label">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Customer Name" value="<?php echo e($customer['name']); ?>"
                                                onkeypress="return Validate(event);" required>
                                        </div>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <div>
                                            <label for="regular-form-1" class="form-label">Contact No</label>
                                            <input id="regular-form-1" type="text" class="form-control" name="contactNo"
                                                placeholder="Contact Number" value="<?php echo e($customer['contactNo']); ?>" required
                                                onKeyDown="numbersOnly(event)" maxlength=10>
                                        </div>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <div>
                                            <label for="validation-form-2"
                                                class="form-label w-full flex flex-col sm:flex-row">
                                                Email
                                            </label>
                                            <input id="validation-form-2" type="email" name="email" class="form-control"
                                                placeholder="example@gmail.com"
                                                onkeypress="return validateJavascript(event);" required
                                                value="<?php echo e($customer['email']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input">
                                        <div>
                                            <label id="input-group" class="form-label">Birth Date</label>
                                            <input type="date" class="form-control" placeholder="Unit"
                                                aria-describedby="input-group-3" name="birthDate"
                                                value="<?php echo e(date('Y-m-d', strtotime($customer['birthDate']))); ?>" required>
                                        </div>
                                    </div>

                                    <div class="input mt-2 sm:mt-0">
                                        <label id="input-group" class="form-label">Birth Time</label>
                                        <input type="time" class="form-control" placeholder="Wholesale" name="birthTime"
                                            aria-describedby="input-group-4" value="<?php echo e($customer['birthTime']); ?>" required>

                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="input-group" class="form-label">Birth Place</label>
                                        <input type="text" class="form-control" placeholder="Birth Place"
                                            name="birthPlace" aria-describedby="input-group-5"
                                            value="<?php echo e($customer['birthPlace']); ?>" onkeypress="return Validate(event);"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div>
                                    <div class="input">
                                        <div>
                                            <label for="validation-form-6"
                                                class="form-label w-full flex flex-col sm:flex-row">
                                                Current Address
                                            </label>
                                            <textarea id="validation-form-6" class="form-control" name="addressLine1" placeholder="Current Address" minlength="10"
                                                onkeypress="return validateJavascript(event);" required><?php echo e($customer['addressLine1']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="input-group" class="form-label">City</label>
                                        <input type="text" class="form-control" placeholder="City" name="location"
                                            aria-describedby="input-group-4" value="<?php echo e($customer['location']); ?>"
                                            onkeypress="return Validate(event);" required>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="input-group" class="form-label">Pin Code</label>
                                        <input type="text" class="form-control" placeholder="Pin Code" name="pincode"
                                            aria-describedby="input-group-5" value="<?php echo e($customer['pincode']); ?>"
                                            onKeyDown="checkPincode(event)" required>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="gender" class="form-label">Select Gender</label>
                                        <select class="form-control" id="gender" name="gender" value="gender">
                                            <option disabled selected>--Select Gender--</option>
                                            <option id="gender" Value="Female"
                                                <?php echo e($customer->gender == 'Female' ? 'selected' : ''); ?>>Female
                                            </option>
                                            <option id="gender" Value="Male"
                                                <?php echo e($customer->gender == 'Male' ? 'selected' : ''); ?>>Male</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <div class="intro-y col-span-12">
                                    <div>
                                        <label for="profile" class="form-label">Profile Image</label>
                                        <img id="thumb" width="150px" src="/<?php echo e($customer['profile']); ?>"
                                            alt="Customer image" onerror="this.style.display='none';" />
                                        <input type="file" class="mt-2" name="profile" id="profile"
                                            onchange="preview()" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button type="submit"class="btn btn-primary shadow-md mr-2">Save
                                </button>
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
        var spinner = $('.loader');

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

        function validateJavascript(event) {
            var regex = new RegExp("^[<>]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }

        function checkPincode(e) {
            let pincode = document.getElementById("pincode").value;
            if (pincode.length >= 6 && (keycode < 48 || keycode > 57) && keycode != 9 && keycode != 8) {
                e.preventDefault();
            }
        }

        function numbersOnly(e) {
            var keycode = e.keyCode;
            let contact = document.getElementById("contactNo").value;
            if (contact.length >= 10 && (keycode < 48 || keycode > 57) && keycode != 9 && keycode != 8) {
                e.preventDefault();
            }
        }

        jQuery(function() {
            jQuery('#edit-form').submit(function(e) {
                e.preventDefault();
                spinner.show();
                var data = new FormData(this);
                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('editUserApi')); ?>",
                    data: data,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (jQuery.isEmptyObject(data.error)) {
                            spinner.hide();
                            location.href = "/admin/customers";
                        } else {
                            toastr.warning(data.error)
                            spinner.hide();
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/edit-customer.blade.php ENDPATH**/ ?>