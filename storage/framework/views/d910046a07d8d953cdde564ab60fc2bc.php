

<?php $__env->startSection('subhead'); ?>
    <title>Team Member</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $currency = DB::table('systemflag')
            ->where('name', 'Currency')
            ->select('value')
            ->first();
    ?>
    <div class="loader"></div>
    <h2 class="d-inline intro-y text-lg font-medium mt-10">Team List</h2>
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-team"
        class="d-inline mt-10 addbtn btn btn-primary shadow-md mr-2"
        onclick="document.getElementById('add-data').reset();">Add
        Team List</a>
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <?php if(count($teamMembers) > 0): ?>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible withoutsearch">
            <table class="table table-report -mt-2" aria-label="team">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">PROFILE</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="text-center whitespace-nowrap">EMAIL</th>
                        <th class="text-center whitespace-nowrap">CONTACT NO</th>
                        <th class="text-center whitespace-nowrap">TEAM ROLE</th>
                        <th class="text-center whitespace-nowrap">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?> </td>
                            <td>
                                <div class="flex">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        <img class="rounded-full" src="/<?php echo e($team->profile); ?>"
                                            onerror="this.onerror=null;this.src='/build/assets/images/default.jpg';"
                                            alt="Astrologer image" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap"><?php echo e($team->name); ?></div>
                            </td>

                            <td class="text-center"><?php echo e($team->email); ?></td>
                            <td class="text-center"><?php echo e($team->contactNo); ?></td>
                            <td class="text-center"><?php echo e($team->teamRole); ?></td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a id="editbtn" href="javascript:;"
                                        onclick="editbtn(<?php echo e($team->id); ?> , '<?php echo e($team->name); ?>','<?php echo e($team->profile); ?>','<?php echo e($team->email); ?>','<?php echo e($team->contactNo); ?>',<?php echo e($team->teamRoleId); ?>)"
                                        class="flex items-center mr-3 " data-tw-target="#edit-modal"
                                        data-tw-toggle="modal"><i data-lucide="check-square"
                                            class="editbtn w-4 h-4 mr-1"></i>Edit</a>
                                    <a id="editbtn" href="javascript:;" onclick="delbtn(<?php echo e($team->id); ?>,<?php echo e($team->userId); ?>)"
                                        value="<?php echo e($team->id); ?>" class="flex items-center text-danger"
                                        data-tw-target="#delete-confirmation-modal" data-tw-toggle="modal"><i
                                            data-lucide="trash-2" class="editbtn w-4 h-4 mr-1"></i>Delete</a>
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
                        <a class="page-link" href="<?php echo e(route('team-list', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('team-list', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('team-list', ['page' => $page + 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <div class="intro-y" style="height:100%">
            <div style="display:flex;align-items:center;height:100%;">
                <div style="margin:auto">
                    <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
                    <h3 class="text-center">No Data Available</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- END: Data List -->
    <div id="add-team" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" onclick="addTeamList()">Add Team List</h2>
                </div>
                <form method="POST" enctype="multipart/form-data" id="add-data">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="">
                                    <label for="post-form-3" class="form-label">Select Role</label>
                                    <select data-placeholder="Select categories" class="form-control" id="bannerTypeId"
                                        name="teamRoleId">
                                        <option value="" disabled selected>--Select Role--
                                        </option>
                                        <?php $__currentLoopData = $teamMem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option id="teamRoleId" value=<?php echo e($role->id); ?>>
                                                <?php echo e($role->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="text-danger print-teamRoleId-error-msg mb-2" style="display:none">
                                        <ul></ul>
                                    </div>
                                </div>
                                <div class="sm:grid grid-cols gap-2">
                                    <div class="input">
                                        <div>
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Name" onkeypress="return Validate(event);">
                                            <div class="text-danger print-name-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="intro-y col-span-12">
                                        <div>
                                            <label for="profile" class="form-label mt-2"
                                                style="display: block;">Profile</label>
                                            <img id="thumb" width="150px" alt="team" style="display:none" />
                                            <input type="file" class="mt-2" name="profile" id="profile"
                                                onchange="preview()" class="form-control" accept="image/*">
                                            <div class="text-danger print-image-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:grid grid-cols gap-2 py-4">
                                    <div class="input">
                                        <div>
                                            <label for="email" class="form-label">Email</label>
                                            <input onkeypress="return validateJavascript(event);" type="email" name="email" id="email" class="form-control"
                                                placeholder="example@gmail.com">
                                            <div class="text-danger print-email-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:grid grid-cols gap-2">
                                    <div class="input">
                                        <div>
                                            <label for="contactNo" class="form-label">Contact No</label>
                                            <input type="text" name="contactNo" id="contactNo" class="form-control"
                                                placeholder="Contact No" onKeyDown="numbersOnly(event)" maxlength="10">
                                            <div class="text-danger print-contactNo-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:grid grid-cols gap-2 mt-2">
                                    <div class="input">
                                        <div>
                                            <label for="password" class="form-label">Password</label>
                                            <input onkeypress="return validateJavascript(event);" type="password" name="password" id="password" class="form-control"
                                                placeholder="******">
                                            <div class="text-danger print-password-error-msg mb-2" style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5"><button type="submit"
                                    class="btn btn-primary shadow-md mr-2 btn-submit">Add
                                    Team Member</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Team Member</h2>
                </div>
                <form id="edit-data" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols gap-2">
                                    <div class="">
                                        <label for="post-form-3" class="form-label">Select Role</label>
                                        <select data-placeholder="Select categories" class="form-control" id="teamRoleId"
                                            name="teamRoleId">
                                            <option value="" disabled selected>--Select Role--
                                            </option>
                                            <?php $__currentLoopData = $teamMem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value=<?php echo e($role->id); ?>>
                                                    <?php echo e($role->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="text-danger print-teamRoleId-error-msg mb-2" style="display:none">
                                            <ul></ul>
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div>
                                            <input type="hidden" id="filed_id" name="filed_id">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" id="id" class="form-control"
                                                placeholder="Name" onkeypress="return Validate(event);">
                                                <div class="text-danger print-name-error-msg mb-2" style="display:none">
                                                    <ul></ul>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 gap-6">
                                        <div class="intro-y col-span-12">
                                            <div>
                                                <label for="image" class="form-label"
                                                    style="display: block;">Profile</label>
                                                <img id="thumbs" width="150px" alt="team"
                                                    onerror="this.style.display='none';">
                                                <input type="file" class="mt-2" name="profile"
                                                    onchange="previews()" accept="image/*">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols gap-2 py-4">
                                        <div class="input">
                                            <div>
                                                <label for="email" class="form-label">Email</label>
                                                <input onkeypress="return validateJavascript(event);" type="email" name="email" id="aid" class="form-control"
                                                    placeholder="example@gmail.com">
                                                <div class="text-danger print-email-error-msg mb-2" style="display:none">
                                                    <ul></ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols gap-2">
                                        <div class="input">
                                            <div>
                                                <label for="contactNo" class="form-label">Contact No</label>
                                                <input type="text" name="contactNo" id="cid"
                                                    class="form-control" placeholder="Contact No"
                                                    onKeyDown="numbersOnly(event)" maxlength="10">
                                                <div class="text-danger print-contactNo-error-msg mb-2" style="display:none">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols gap-2 mt-2">
                                        <div class="input">
                                            <div>
                                                <label for="password" class="form-label">Password</label>
                                                <input onkeypress="return validateJavascript(event);" type="password" name="password" id="epassword" class="form-control"
                                                    placeholder="Enter new password if you want to change old password">
                                                <div class="text-danger print-password-error-msg mb-2" style="display:none">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols gap-2 mt-2">
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
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process
                            cannot be undone.</div>
                    </div>

                    <form action="<?php echo e(route('deleteMember')); ?> " method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <input type="hidden" id="userId" name="userId">
                        <input type="hidden" id="del_id" name="del_id">
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                            <button class="btn btn-danger w-24"><?php echo method_field('DELETE'); ?>Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="verified" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <div class="text-3xl mt-5">Are You Sure?</div>
                        <div class="text-slate-500 mt-2" id="active">You want Active!</div>
                    </div>
                    <form action="<?php echo e(route('giftStatusApi')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="status_id" name="status_id">
                        <div class="px-5 pb-8 text-center"><button class="btn btn-primary mr-3" id="btnActive">Yes,
                                Active it!
                            </button><a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24"
                                onclick="location.reload();">Cancel</a>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
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
        function editbtn($id, $name, $profile, $email, $contactNo, $teamRoleId) {
            jQuery(".print-name-error-msg").find("ul").html('');
            jQuery(".print-contactNo-error-msg").find("ul").html('');
            jQuery(".print-email-error-msg").find("ul").html('');
            jQuery(".print-teamRoleId-error-msg").find("ul").html('');
            jQuery(".print-password-error-msg").find("ul").html('');

            var id = $id;
            var gid = $id;
            var aid = $id;
            $cid = id;

            $('#filed_id').val($cid);
            $('#id').val($name);
            $('#aid').val($email);
            $('#cid').val($contactNo);
            $('#teamRoleId').val($teamRoleId);
            document.getElementById("thumbs").src = "/" + $profile;
        }

        function delbtn($id, $userId) {
            $('#del_id').val($id);
            // $('#id').val($id);
            $('#userId').val($userId);
        }

        function editGift($id, $name, $isActive) {
            var id = $id;
            $fid = id;
            var active = $isActive ? 'Inactive' : 'Active';
            document.getElementById('active').innerHTML = "You want to " + active;
            document.getElementById('btnActive').innerHTML = "Yes, " +
                active + " it";

            $('#status_id').val($fid);
            $('#id').val($name);
        }

        function preview() {
            document.getElementById("thumb").style.display = "block";
            thumb.src = URL.createObjectURL(event.target.files[0]);
            jQuery(".print-image-error-msg").find("ul").html('');
        }

        function previews() {
            document.getElementById("thumbs").style.display = "block";
            thumbs.src = URL.createObjectURL(event.target.files[0]);
        }

        function Validate(event) {
            var regex = new RegExp("^[0-9-!@#$%&<>*?]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }


        function numbersOnly(e) {
            var keycode = e.keyCode;
            if (!(keycode != 9 && e.shiftKey == false && (keycode == 46 || keycode == 8 || keycode ==
                    37 ||
                    keycode == 39 || (keycode >=
                        48 && keycode <= 57)))) {
                e.preventDefault();
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

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        jQuery("#add-data").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('addTeamApi')); ?>",
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
        jQuery("#edit-data").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('editTeamMemberApi')); ?>",
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
            jQuery(".print-name-error-msg").find("ul").html('');
            jQuery(".print-contactNo-error-msg").find("ul").html('');
            jQuery(".print-email-error-msg").find("ul").html('');
            jQuery(".print-teamRoleId-error-msg").find("ul").html('');
            jQuery(".print-password-error-msg").find("ul").html('');
            jQuery.each(msg, function(key, value) {
                if (key == 'name') {
                    jQuery(".print-name-error-msg").css('display', 'block');
                    jQuery(".print-name-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'contactNo') {
                    jQuery(".print-contactNo-error-msg").css('display', 'block');
                    jQuery(".print-contactNo-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'email') {
                    jQuery(".print-email-error-msg").css('display', 'block');
                    jQuery(".print-email-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'teamRoleId') {
                    jQuery(".print-teamRoleId-error-msg").css('display', 'block');
                    jQuery(".print-teamRoleId-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                if (key == 'password') {
                    jQuery(".print-password-error-msg").css('display', 'block');
                    jQuery(".print-password-error-msg").find("ul").append('<li>' + value + '</li>');
                }
                else {
                    toastr.warning(value);
                }

            });
        }

        function addTeamList() {
            document.getElementById("thumbs").style.display = "none";
            jQuery(".print-name-error-msg").find("ul").html('');
            jQuery(".print-contactNo-error-msg").find("ul").html('');
            jQuery(".print-email-error-msg").find("ul").html('');
            jQuery(".print-teamRoleId-error-msg").find("ul").html('');
            jQuery(".print-password-error-msg").find("ul").html('');
        }
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/team-list.blade.php ENDPATH**/ ?>