<?php $__env->startSection('subhead'); ?>
    <title>Daily Horoscope</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <div class="grid-cols-12 mt-10" style="width:100%">
        <h2 class="d-inline intro-y text-lg font-medium  mr-2 dailytitle">Daily Horoscope</h2>
        <form action="<?php echo e(route('dailyHoroscope')); ?>" method="POST" enctype="multipart/form-data" class="addbtn">
            <?php echo csrf_field(); ?>
            <div class="relative w-56 mx-auto horodate" style="display: inline-block; margin-left: 13px;
        ">
                <div
                    class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <input type="text" id="filterDate" name="filterDate" class="datepicker form-control pl-12"
                    data-single-mode="true" value=<?php echo e($filterDate); ?>>
            </div>
            
            <button style="display:inline-flex;top: 4px; position: relative;" id="deletebtn"
                class="btn btn-primary mr-2 mb-2"><i data-lucide="filter" class="deletebtn w-4 h-4 mr-2"></i>Apply</button>
        </form>
    </div>
 

<?php if($totalRecords > 0): ?>
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible list-table mt-5">
        <table class="table table-report -mt-2" aria-label="call-history">
            <thead class="sticky-top">
                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class=" whitespace-nowrap">Zodiac</th>
                    <th class=" whitespace-nowrap">Lucky Color</th>
					<th class=" whitespace-nowrap">Lucky Color Code</th>
                    <th class="text-center whitespace-nowrap">Lucky Number</th>
                    <th class="text-center whitespace-nowrap">Total Score</th>
                    <th class="text-center whitespace-nowrap">Physique</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Finances</th>
                    <th class="text-center whitespace-nowrap">Relationship</th>
                    <th class="text-center whitespace-nowrap">Career</th>
                    <th class="text-center whitespace-nowrap">Travel</th>
                    <th class="text-center whitespace-nowrap">Family</th>
                    <th class="text-center whitespace-nowrap">Friends</th>
                    <th class="text-center whitespace-nowrap">Health</th>
                    <th class="text-center whitespace-nowrap">Response</th>
                    <th class="text-center whitespace-nowrap">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 0;
                ?>
                <?php $__currentLoopData = $dailyHoroscope; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $horoscope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="intro-x">
                        <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>

                        <td>
                            <?php echo e($horoscope->zodiac); ?>

                        </td>
						  <td>
                            <?php echo e($horoscope->lucky_color); ?>

                        </td>
                        <td>
                            <h6
                            style="background-color:<?php echo e($horoscope->lucky_color_code); ?>;color:<?php echo e($horoscope->lucky_color_code); ?>

                            ">
                            <?php echo e($horoscope->lucky_color_code); ?>

                        </h6>
                        </td>
                        <td class="text-center"><?php echo e($horoscope->lucky_number); ?></td>
                        <td class="text-center">
                            <?php echo e($horoscope->total_score); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->physique); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->status); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->finances); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->relationship); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->career); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->travel); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->family); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->friends); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->health); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e(implode(' ', array_slice(explode(' ', $horoscope->bot_response), 0, 5))); ?>

                        </td>
                        <td class="text-center">
                            <?php echo e($horoscope->date); ?>

                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
        <?php echo e($totalRecords); ?> entries</div>
    <div class="d-inline addbtn intro-y col-span-12">
        <nav class="w-full sm:w-auto sm:mr-auto">
            <ul class="pagination" id="pagination">
                <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                    <a class="page-link"
                        href="<?php echo e(route('dailyHoroscope', ['page' => $page - 1, 'searchString' => $searchString])); ?>">
                        <i class="w-4 h-4" data-lucide="chevron-left"></i>
                    </a>
                </li>
                <?php for($i = 0; $i < $totalPages; $i++): ?>
                    <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                        <a class="page-link"
                            href="<?php echo e(route('dailyHoroscope', ['page' => $i + 1, 'searchString' => $searchString])); ?>"><?php echo e($i + 1); ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                    <a class="page-link"
                        href="<?php echo e(route('dailyHoroscope', ['page' => $page + 1, 'searchString' => $searchString])); ?>">
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
        $(document).ready(function() {
            CKEDITOR.config.removeButtons = 'Image';
        });

        function getDate() {
            $(".datepicker").on("change", function() {
                let pickedDate = $("input").val();
            });
        }

        function editbtn($id, $category, $signId, $description, $horoscopeDate, $percentage) {
            $('#horoscopeId').val($id);
            $('#category').val($category);
            $('#horoscopeSignId').val($signId);
            $('#description').val($description);
            $('#percentage').val($percentage);
            var newdate = $horoscopeDate.split("-");
            var date = newdate[2].split(" ");
            date = newdate[0] + '-' + newdate[1] + '-' + date[0]
            $('#horoscopeDate').val(date);
            var editor = CKEDITOR.instances['editdescription'];
            if (editor) {
                editor.destroy(true);
            }
            CKEDITOR.replace('editdescription');
            var editor = CKEDITOR.instances['editdescription'];
            CKEDITOR.instances['editdescription'].setData($description)
        }

        function deletebtn($id, $horoscopeDate) {
            $('#del_id').val($id);
            $('#horoscope_date').val($horoscopeDate);
        }

        function showEditor() {
            var editor = CKEDITOR.instances['description'];
            if (editor) {
                editor.destroy(true);
            }
            CKEDITOR.replace('description', {
                toolbar: 'simple'
            });
            var editor = CKEDITOR.instances['description'];
            CKEDITOR.config.removeButtons = 'Image';
        }

        function numbersOnly(e) {
            var keycode = e.keyCode;
            if ((keycode < 48 || keycode > 57) && keycode != 9 && keycode != 8) {
                e.preventDefault();
            }
        }
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/daily-horoscope.blade.php ENDPATH**/ ?>