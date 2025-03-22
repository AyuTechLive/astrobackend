<?php $__env->startSection('subhead'); ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"  ></script>
    <title>Help Support SubCategory</title>
    <style>
        svg {
            display: inherit !important
        }

        .actionbtn {
            display: inline-block
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10">Help Support SubCategory</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="intro-y box mt-5" style="width: 100%">
                <div id="boxed-accordion" class="p-5">
                    <div class="preview">
                        <div id="faq-accordion-2" class="accordion accordion-boxed">
                            <?php $__currentLoopData = $helpSupportSubCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-5" class="accordion-header">
                                        <button class="accordion-button" type="button" data-tw-toggle="collapse"
                                            data-tw-target="#faq-accordion-collapse-5" aria-expanded="true"
                                            aria-controls="faq-accordion-collapse-5">
                                            <?php echo e($category->question); ?>


                                            <div style="float:right">
                                                <a class=" items-center mr-3 text-primary actionbtn" href="javascript:;"
                                                    data-tw-toggle="modal" data-tw-target="#add-helpSupport-sub-category"
                                                    onClick="addHelpSupport(<?php echo e($category->helpSupportId); ?>,<?php echo e($category->id); ?>)">
                                                    <i data-lucide="plus" class="w-4 h-4 mr-1"></i>Add
                                                </a>
                                                <a class=" items-center mr-3 text-success actionbtn"href="<?php echo e(route('helpSupportsubsubCategory', $category->id)); ?>"
                                                    data-tw-toggle="modal" data-tw-target="">
                                                    <i data-lucide="eye" class="w-4 h-4 mr-1"></i>View
                                                </a>
                                                <a class=" items-center mr-3 text-primary actionbtn" href="javascript:;"
                                                    onClick="editHelpSupport(<?php echo e($category->id); ?>,<?php echo e($category->helpSupportId); ?>,'<?php echo e($category->question); ?>',<?php echo e(json_encode($category->answer)); ?>,<?php echo e($category->isChatWithus); ?>)"
                                                    data-tw-toggle="modal" data-tw-target="#edit-helpSupport-sub-category">
                                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Edit
                                                </a>
                                                <a class=" items-center mr-3 text-danger actionbtn" href="javascript:;"
                                                    onclick="deleteSubSupport(<?php echo e($category->id); ?>)" data-tw-toggle="modal"
                                                    data-tw-target="#delete-confirmation-modal">
                                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                                                </a>
                                            </div>
                                        </button>
                                    </div>
                                    <div id="faq-accordion-collapse-5" class="accordion-collapse collapse "
                                        aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                                            <?php echo $category->answer; ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-boxed-accordion" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-lucide="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>

                    </div>
                </div>
            </div>

        </div>



    </div>
    <div id="add-helpSupport-sub-category" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Help Support Sub Subcategory</h2>
                </div>
                <form action="<?php echo e(route('addHelpSupportSubSubCategory')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols gap-2">
                                    <input type="hidden" name="supportId" id="supportId" class="form-control">
                                    <input type="hidden" name="supportQuestionId" id="supportQuestionId"
                                        class="form-control">
                                    <div class="input">
                                        <div>
                                            <label for="que" class="form-label">Title</label>
                                            <input onkeypress="return validateJavascript(event);" type="text" name="title" id="title" class="form-control"
                                                placeholder="Title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="box">
                            <div class="p-5" id="classic-editor">
                                <div class="preview">
                                    <label for="que" class="form-label">Description</label>
                                    <textarea class="form-control  ml-3" id="did" name="did"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input">
                        <div class="p-5">
                            <input id="isChatWithUs" data-target="#checkbox-switch"
                                class="show-code form-check-input mr-2 ml-3" name="isChatWithus" type="checkbox">IS
                            Chat With Us!
                        </div>
                    </div>
                    <div class="pb-8 mt-2 ml-2"><button class="btn btn-primary mr-3">Save
                        </button><a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-helpSupport-sub-category" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Help Support Sub Category</h2>
                </div>
                <form action="<?php echo e(route('editHelpSupportSubCategory')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <div class="sm:grid grid-cols gap-2">
                                    <input type="hidden" name="id" id="id" class="form-control">
                                    <input type="hidden" name="supportId" id="esupportId" class="form-control">
                                    <div class="input">
                                        <div>
                                            <label for="name" class="form-label">Title</label>
                                            <input onkeypress="return validateJavascript(event);" type="text" name="title" id="etitle" class="form-control"
                                                placeholder="Title" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="box">
                            <div class="p-5" id="classic-editor">
                                <div class="preview">
                                    <label for="que" class="form-label">Description</label>
                                    <textarea class="form-control  ml-3" id="editdid" name="editdid"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input">
                        <div class="p-5">
                            <input id="eisChatWithUs" class="show-code form-check-input mr-2 ml-3" name="isChatWithus"
                                type="checkbox">IS
                            Chat With Us!
                        </div>
                    </div>
                    <div class="px-5 pb-5 mt-3"><button class="btn btn-primary shadow-md mr-2">Save</button>
                        <a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>It also delete
                            subcategory</div>
                    </div>

                    <form action="<?php echo e(route('deleteSubSupport')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"  ></script>
    <script type="text/javascript">
        function addHelpSupport($id, $supportId) {

            var id = $id;
            $fid = id;
            $('#supportId').val($fid);
            $('#supportQuestionId').val($supportId);
            var editor = CKEDITOR.instances['did'];
            if (editor) {
                editor.destroy(true);
            }
            CKEDITOR.replace('did');
            var editor = CKEDITOR.instances['did'];
        }

        function editHelpSupport($id, $supportId, $question, $answer, $isChatWithus) {
            var id = $id;
            $fid = id;
            $('#id').val($fid);
            $('#esupportId').val($supportId);
            $('#etitle').val($question);
            $isChatWithus = $isChatWithus ? true : false;
            if ($isChatWithus) {
                $("#eisChatWithUs").attr("checked", "checked");
            } else {
                $("#eisChatWithUs").removeAttr('checked');
            }
            var editor = CKEDITOR.instances['editdid'];
            if (editor) {
                editor.destroy(true);
            }
            CKEDITOR.replace('editdid');
            var editor = CKEDITOR.instances['editdid'];
            CKEDITOR.instances['editdid'].setData($answer)
        }

        function deleteSubSupport($id) {
            $('#del_id').val($id);
        }

        function validateJavascript(event) {
            var regex = new RegExp("^[<>]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }

    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views/pages/help-support-queston-answer.blade.php ENDPATH**/ ?>