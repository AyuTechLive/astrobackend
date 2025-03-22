<?php $__env->startSection('subhead'); ?>
    <title>Tickets</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10">Tickets</h2>
    <?php if(count($tickit) > 0): ?>
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible withoutsearch">

                <table class="table table-report -mt-2" aria-label="ticket">
                    <thead class="sticky-top">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">TICKET NO</th>
                            <th class="text-center">SUBJECT</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">CREATED DATE</th>
                            <th class="text-center">DESCRIPTION</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 0;
                        ?>
                        <?php $__currentLoopData = $tickit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="intro-x">
                                <td><?php echo e(++$no); ?></td>
                                <td>
                                    <div class="font-medium text-center"><?php echo e($ticket->ticketNumber); ?></div>
                                </td>
                                <td>
                                    <div class="font-medium text-center"><?php echo e($ticket->subject); ?></div>
                                </td>
                                <td>
                                    <div class="font-medium text-center"><?php echo e($ticket->ticketStatus); ?></div>
                                </td>
                                <td>
                                    <div class="font-medium text-center"><?php echo e($ticket->userName); ?> - <?php echo e($ticket->contactNo); ?></div>
                                </td>
                                <td>
                                    <div class="font-medium text-center"><?php echo e(date('d-m-Y', strtotime($ticket->created_at))); ?>

                                    </div>
                                </td>
                                <td>
                                    <div class="font-medium text-center"><?php echo e($ticket->description); ?>

                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-center items-center">
                                        <a id="editbtn" href=<?php echo e(route('chats', $ticket->id)); ?>

                                            class="flex items-center mr-3 "><i data-lucide="message-square"
                                                class="editbtn w-4 h-4 mr-1"></i>Chat</a>
                                        <?php if($ticket->ticketStatus != 'CLOSED'): ?>
                                            <a id="editbtn" href="javascript:;" onclick="closeTicket(<?php echo e($ticket->id); ?>)"
                                                class="flex items-center text-danger mr-3" data-tw-target="#verified"
                                                data-tw-toggle="modal"><i data-lucide="cross"
                                                    class="editbtn w-4 h-4 mr-1"></i>Close
                                                Ticket</a>
                                            
                                        <?php endif; ?>
                                        <a id="editbtn" href="javascript:;" class="flex items-center mr-3 "
                                            data-tw-target="#reviewModel" data-tw-toggle="modal"
                                            onclick="getReview(<?php echo e($ticket->ticketReview); ?>)"><i data-lucide="eye"
                                                class="editbtn w-4 h-4 mr-1"></i>Review</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
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
    <?php if($totalRecords > 0): ?>
        <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
            <?php echo e($totalRecords); ?> entries</div>
    <?php endif; ?>
    <?php if(count($tickit) > 0): ?>
        <div class="d-inline addbtn intro-y col-span-12 ">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('tickets', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link" href="<?php echo e(route('tickets', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('tickets', ['page' => $page + 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
    <div id="verified" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <div class="text-3xl mt-5">Are You Sure?</div>
                        <div class="text-slate-500 mt-2">You want Close Ticket!</div>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="close-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="ticket_id" name="ticket_id">
                        <div class="px-5 pb-8 text-center"><button class="btn btn-primary mr-3">Yes, Close it!
                            </button><a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24">Cancel</a>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="reviewModel" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Ticket Review</h2>
                </div>
                <div class="modal-body">
                    <h6 id="review"></h6>
                    <div class="px-5 text-right">
                        <a type="button" data-tw-dismiss="modal" class="btn btn-secondary w-24">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function closeTicket($id) {
            var id = $id;
            $fid = id;
            $('#ticket_id').val($fid);
        }

        function pauseTicket($id) {
            var id = $id;
            $fid = id;
            $('#ticket_id').val($fid);
        }
        var spinner = $('.loader');
        jQuery(function() {
            jQuery('#close-form').submit(function(e) {
                e.preventDefault();
                spinner.show();
                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('closeTicket')); ?>",
                    data: new FormData(this),
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
            jQuery('#pause-form').submit(function(e) {
                e.preventDefault();
                spinner.show();
                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('pauseTicket')); ?>",
                    data: new FormData(this),
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

        function filterData() {
            user_filter = $('#user_filter').val();
            $ajax({
                url: "<?php echo e(url('filter_user')); ?>?filter_user=" + user_filter,
                success: function(data) {

                }
            })
        }

        function searchData() {
            $("#user_filter").select2({
                placeholder: "Select a Name",
                allowClear: true
            });
        }

        function showEditor() {

        }

        function getReview($review) {
            $rev = $review && $review.length > 0 ? $review[0].review : "No Review Found"
            document.getElementById('review').innerHTML = $rev
        }
    </script>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/pages/ticket.blade.php ENDPATH**/ ?>