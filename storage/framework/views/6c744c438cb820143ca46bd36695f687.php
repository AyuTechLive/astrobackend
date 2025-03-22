<?php $__env->startSection('subhead'); ?>
    <title>Edit Product</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="grid grid-cols-11 gap-x-6 mt-5 pb-20">
        <div class="intro-y col-span-12 2xl:col-span-12">
            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Edit Product</h2>
                </div>
                <form action="<?php echo e(route('editProductApi')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input">
                                        <div>
                                            <input type="hidden" name="field_id" id="field_id" class="form-control"
                                                placeholder="Customer Name" value="<?php echo e($product['id']); ?>">
                                            <label for="name" class="form-label">Name</label>
                                            <input id="name" name="name" type="text" class="form-control"
                                                placeholder="Name" value="<?php echo e($product['name']); ?>" required
                                                onkeypress="return Validate(event);">
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div>
                                            <label id="amount" class="form-label">Amount</label>
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                placeholder="Amount" aria-describedby="input-group-3"
                                                value="<?php echo e($product['amount']); ?>" required onKeyDown="numbersOnly(event)">
                                        </div>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="productCategoryId" class="form-label">Product Category</label>
                                        <select class="form-control" id="productCategoryId" name="productCategoryId"
                                            value="productCategoryId">
                                            <option disabled selected value="">--Select Category--</option>
                                            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option id="productCategoryId" value=<?php echo e($category['id']); ?>

                                                    <?php echo e($product->productCategoryId == $category['id'] ? 'selected' : ''); ?>>
                                                    <?php echo e($category['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div>
                                    <div class="input">
                                        <div>
                                            <label for="features" class="form-label w-full flex flex-col sm:flex-row">
                                                Features
                                            </label>
                                            <textarea onkeypress="return validateJavascript(event);" id="features" required class="form-control" name="features" placeholder="Features" minlength="10" required><?php echo e($product['features']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div class="input">
                                        <div>
                                            <label for="productImage" class="form-label">Product Image</label>
                                            <img id="thumb" width="150px" src="/<?php echo e($product['productImage']); ?>"
                                                alt="Product image"
                                                onerror="this.style.display='none'";/>
                                            <input type="file"
                                                class="mt-2" name="productImage" id="productImage" onchange="preview()"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button class="btn btn-primary shadow-md mr-2">Save</button>
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

        function validateJavascript(event) {
            var regex = new RegExp("^[<>]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }

        function numbersOnly(e) {
            var keycode = e.keyCode;
            if ((keycode < 48 || keycode > 57) && (keycode < 96 || keycode > 105) && keycode !=
                9 && keycode != 8 && keycode != 37 && keycode != 38 && keycode != 39 && keycode != 40 && keycode != 46) {
                e.preventDefault();
            }
        }
    </script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/ckeditor-classic.js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/edit-product.blade.php ENDPATH**/ ?>