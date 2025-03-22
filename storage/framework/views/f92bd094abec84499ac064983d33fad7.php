

<?php $__env->startSection('subhead'); ?>
    <title>Add TeamRole</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 mt-2">

            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Edit Team Role</h2>
                </div>
                <form method="POST" action="<?php echo e(route('editTeamRoleApi')); ?>" enctype="multipart/form-data" id="add-form">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid gap-2">
                                    <div class="input">
                                        <div>
                                            <label for="regular-form-1" class="form-label">Name</label>
                                            <input id="name" name="id" type="hidden" class="form-control inputs"
                                                placeholder="Role Name" value="<?php echo e($role->id); ?>"required>
                                            <input id="name" name="name" type="text" class="form-control inputs"
                                                placeholder="Role Name" value="<?php echo e($role->name); ?>"required>
                                            <div class="text-danger print-name-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageIndex => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="mt-2">
                                                <input type="hidden" name="page[<?php echo e($pageIndex); ?>][page][id]"
                                                    value="<?php echo e($page->id); ?>">
                                                <input id="<?php echo e($page->id); ?>"
                                                    class="show-code d-inline form-check-input mr-2 ml-3"
                                                    name="page[<?php echo e($pageIndex); ?>][page][value]" type="checkbox"
                                                    <?php echo e($page->isPermitted ? 'checked' : ''); ?>>
                                                <p class="d-inline"><?php echo e($page->pageName); ?>

                                                </p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button type="submit" class="btn btn-primary shadow-md mr-2">
                                    Save</button>
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
        <?php if(Session::has('error')): ?>
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("<?php echo e(session('error')); ?>");
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/edit-team-role.blade.php ENDPATH**/ ?>