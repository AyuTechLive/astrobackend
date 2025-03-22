<?php $__env->startSection('subhead'); ?>
    <title>Commissions</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="d-inline intro-y text-lg font-medium mt-10">Commissions</h2>
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-skill"
        class="d-inline addbtn btn btn-primary shadow-md mr-2 mt-10" onclick="clearModel()">Add
        Commission</a>
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <?php if(count($commission) > 0): ?>
    
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible withoutsearch">
            <table class="table table-report -mt-2" aria-label="commission-list">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class=" whitespace-nowrap">COMMISSION TYPE</th>
                        <th class="text-center whitespace-nowrap">ASTROLOGER</th>
                        <th class="text-center whitespace-nowrap">COMMISSION</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 0;
                    ?>
                    
                    <?php $__currentLoopData = $commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(++$no); ?></td>

                            <td>
                                <?php echo e($commi->commssionType); ?>

                            </td>
                            <td class="text-center"><?php echo e($commi->astrologerName); ?></td>
                            <td class="text-center">
                                <?php echo e($commi->commission); ?>%
                            </td>

                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a id="editbtn" href="javascript:;"
                                        onclick="editbtn(<?php echo e($commi->id); ?> , '<?php echo e($commi->astrologerId); ?>','<?php echo e($commi->commissionTypeId); ?>', '<?php echo e($commi->commission); ?>')"
                                        class="flex items-center mr-3 " data-tw-target="#edit-modal"
                                        data-tw-toggle="modal"><i data-lucide="check-square"
                                            class="editbtn w-4 h-4 mr-1"></i>Edit</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($totalRecords > 0): ?>
            <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
                <?php echo e($totalRecords); ?> entries</div>
        <?php endif; ?>
        <div class="d-inline addbtn intro-y col-span-12">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('commissions', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('commissions', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('commissions', ['page' => $page + 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <div class="intro-y mt-5" style="height:100%">
            <div style="display:flex;align-items:center;height:100%;">
                <div style="margin:auto">
                    <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
                    <h3 class="text-center">No Data Available</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- BEGIN: Delete Confirmation Modal -->

    <div id="add-skill" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Add Commission</h2>
                </div>
                <form enctype="multipart/form-data" id="commission-form">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols gap-2">
                                    <div class="input mt-2 sm:mt-0">
                                        <label class="form-label">Commission Type</label>
                                        <select class="form-control" id="commissionType" name="commissionTypeId"
                                            value="commissionTypeId" required>
                                            <?php $__currentLoopData = $commissionType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option  value=<?php echo e($commission['id']); ?>>
                                                    <?php echo e($commission['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="text-danger print-commissionTypeId-error-msg mb-2" style="display:none">
                                            <ul></ul>
                                        </div>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="astrologerId" class="form-label">Astrologer</label>
                                        <select data-placeholder="Search User" class="form-control" id="astrologerId"
                                            name="astrologerId" value="astrologerId" required>
                                            <?php $__currentLoopData = $astrologer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option id="astrologerId" value=<?php echo e($astro->id); ?>>
                                                    <?php echo e($astro->name); ?>-<?php echo e($astro->contactNo); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="text-danger print-astrologerId-error-msg mb-2" style="display:none">
                                            <ul></ul>
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div>
                                            <label for="commission" class="form-label">Commission(%)</label>
                                            <input type="text" name="commission" id="commission" class="form-control"
                                                placeholder="Commission" onKeyDown="numbersOnly(event)" maxlength="3"
                                                max="100">
                                            <div class="text-danger print-commission-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button type="submit"class="btn btn-primary shadow-md mr-2">Add
                                    Commission</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Commission</h2>
                </div>
                <form method="POST" enctype="multipart/form-data" id="edit-commission-form">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols gap-2">
                                    <div class="input mt-2 sm:mt-0">
                                        <input type="hidden" id="filed_id" name="filed_id">
                                        <label class="form-label">Commission Type</label>
                                        <select class="form-control" id="commissionTypeId" name="commissionTypeId">
                                            <option disabled selected>--Select Commission Type--</option>
                                            <?php $__currentLoopData = $commissionType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value=<?php echo e($commission['id']); ?>>
                                                    <?php echo e($commission['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="text-danger print-commissionTypeId-error-msg mb-2"
                                            style="display:none">
                                            <ul></ul>
                                        </div>
                                    </div>
                                    <div class="input mt-2 sm:mt-0">
                                        <label id="astrologerId" class="form-label">Astrologer</label>
                                        <select data-placeholder="Search User" class="form-control" id="editastrologerId"
                                            name="astrologerId" value="astrologerId" required>
                                            <?php $__currentLoopData = $astrologer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option id="astrologerId" value=<?php echo e($astro->id); ?>>
                                                    <?php echo e($astro->name); ?>-<?php echo e($astro->contactNo); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="text-danger print-astrologerId-error-msg mb-2" style="display:none">
                                            <ul></ul>
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div>
                                            <label for="commission" class="form-label">Commission(%)</label>
                                            <input type="text" name="commission" id="editcommission"
                                                class="form-control" placeholder="Commission" required
                                                onKeyDown="numbersOnly(event)">
                                            <div class="text-danger print-commission-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button
                                    type="submit"class="btn btn-primary shadow-md mr-2">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    <!-- END: Delete Confirmation Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"  ></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"  ></script>
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        <?php if(Session::has('error')): ?>
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>
        $(document).ready(function() {
            jQuery('.js-example-basic-single').select2();
        });

        function clearModel() {
            jQuery(".print-commissionTypeId-error-msg").find("ul").html('');
            jQuery(".print-commission-error-msg").find("ul").html('');
            jQuery(".print-astrologerId-error-msg").find("ul").html('');
            var ele = document.getElementById('commission-form').reset();
        }

        function editbtn($id, $astrologerId, $commissionTypeId, $commission) {
            jQuery(".print-commissionTypeId-error-msg").find("ul").html('');
            jQuery(".print-commission-error-msg").find("ul").html('');
            jQuery(".print-astrologerId-error-msg").find("ul").html('');
            var id = $id;
            $cid = id;
            $('#filed_id').val($cid);
            $('#editastrologerId').val($astrologerId);
            $('#commissionTypeId').val($commissionTypeId);
            $('#editcommission').val($commission);
        }

        function delbtn($id, $name) {
            var id = $id;
            $did = id;

            $('#del_id').val($did);
            $('#astrologerId').val($id);
        }

        function numbersOnly(e) {
            var keycode = e.keyCode;
            if ((keycode < 48 || keycode > 57) && (keycode < 96 || keycode > 105) && keycode !=
                9 && keycode != 8 && keycode != 37 && keycode != 38 && keycode != 39 && keycode != 40 && keycode != 46) {
                e.preventDefault();
            }
        }

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        jQuery("#commission-form").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('addCommissionApi')); ?>",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (jQuery.isEmptyObject(data.error)) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        location.reload();
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });

        });

        jQuery("#edit-commission-form").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('editCommissionApi')); ?>",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (jQuery.isEmptyObject(data.error)) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        location.reload();
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });

        });


        function printErrorMsg(msg) {
            jQuery(".print-commissionTypeId-error-msg").find("ul").html('');
            jQuery(".print-commission-error-msg").find("ul").html('');
            jQuery(".print-astrologerId-error-msg").find("ul").html('');
            jQuery.each(msg, function(key, value) {
                if (key == 'commissionTypeId') {
                    jQuery(".print-commissionTypeId-error-msg").css('display', 'block');
                    jQuery(".print-commissionTypeId-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'commission') {
                    jQuery(".print-commission-error-msg").css('display', 'block');
                    jQuery(".print-commission-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'astrologerId') {
                    jQuery(".print-astrologerId-error-msg").css('display', 'block');
                    jQuery(".print-astrologerId-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (!key) {
                    toastr.error(value);
                }

            });
        }
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/commission-list.blade.php ENDPATH**/ ?>