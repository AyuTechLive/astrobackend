<style>
    .tab-headbox {
        overflow-x: hidden;
    }

    #kundaliTab {
        float: left;
        display: flex;
        flex-wrap: nowrap;
        cursor: pointer;
    }

    #kundaliTab {
        padding: 0 15px;
        border-bottom: 1px solid #65A9FD !important;
        width:100%;
    }

    .nav-tabs {
        margin-bottom: 22px !important;
        border-bottom: none !important;
    }

    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .nav-tabs .nav-item {
        margin-bottom: -1px;
    }

    #kundaliTab li a.active {
        border-color: #65A9FD #65A9FD #FFFFFF !important;
        color: #5E5E5E;
    }

    #kundaliTab li a {
        font-weight: 600;
        color: #000000;
        white-space: nowrap;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .nav-link {
        display: block;
        padding: .5rem 1rem !important;
    }

    .nav-tabs>li>a {
        background: white !important;
        border-bottom: 1px solid #65A9FD !important;
    }
</style>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row py-3">
        <div class="col-sm-12 mt-4">

            <div class="tab-headbox">
                <ul class="nav nav-tabs" id="kundaliTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#basic">Basic Details</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#planetaryposition">Planetary Position</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#predictions">Predictions</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#shodashvarga">Shodashvarga</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#ashtakvarga">Ashtakvarga</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="kundaliTabContent">
                <div class="tab-pane fade shadow-pink rounded-10 font-14 p-4 active show" id="basic" role="tabpanel"
                    aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="table-theme overflow-visible mb-3 shadow-pink rounded-10-top">
                                <div
                                    class="bg-pink color-red text-center font-weight-semi-bold py-1 px-3 rounded-10-top">
                                    Birth Details
                                </div>
                                <table class="table table-bordered border-pink font-14 mb-1 w-100">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Name
                                            </td>
                                            <td>
                                               <?php echo e($KundaliReport['recordList']['name']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Birth Date
                                            </td>
                                            <td>
                                                <?php echo e($KundaliReport['recordList']['birthDate']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Birth Time
                                            </td>
                                            <td>
                                               <?php echo e($KundaliReport['recordList']['birthTime']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Birth Place
                                            </td>
                                            <td>
                                                <?php echo e($KundaliReport['recordList']['birthPlace']); ?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Latitude
                                            </td>
                                            <td>
                                                <?php echo e($KundaliReport['recordList']['latitude']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Longitude
                                            </td>
                                            <td>
                                                 <?php echo e($KundaliReport['recordList']['longitude']); ?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Rasi
                                            </td>
                                            <td>
                                                 <?php echo e($KundaliReport['planet']['response']['rasi']); ?>

                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Pdf Link
                                            </td>
                                            <td>
                                                <?php if(isset($KundaliReport['recordList']['pdf_link'])): ?>
                                                    <a class="text-black" href="/public/<?php echo e($KundaliReport['recordList']['pdf_link']); ?>">
                                                        <i class="fa-solid fa-file-pdf"></i> Pdf
                                                    </a>
                                                <?php else: ?>
                                                    No PDF found
                                                <?php endif; ?>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="table-theme overflow-visible mb-3 shadow-pink rounded-10-top">
                                <div
                                    class="bg-pink color-red text-center font-weight-semi-bold py-1 px-3 rounded-10-top">
                                    Panchang Details
                                </div>
                                <table class="table table-bordered border-pink font-14 mb-1 w-100">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Tithi
                                            </td>
                                            <td>
                                               <?php echo e($KundaliReport['planet']['response']['panchang']['tithi']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Yoga
                                            </td>
                                            <td>
                                                <?php echo e($KundaliReport['planet']['response']['panchang']['yoga']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Karana
                                            </td>
                                            <td>
                                               <?php echo e($KundaliReport['planet']['response']['panchang']['karana']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Sun Rise
                                            </td>
                                            <td>
                                                <?php echo e($KundaliReport['planet']['response']['panchang']['sunrise_at_birth']); ?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-semi-bold">
                                               Sun Set
                                            </td>
                                            <td>
                                                <?php echo e($KundaliReport['planet']['response']['panchang']['sunset_at_birth']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Ayanamsa
                                            </td>
                                            <td>
                                                 <?php echo e($KundaliReport['planet']['response']['panchang']['ayanamsa_name']); ?>

                                            </td>
                                        </tr>
                                         <tr>
                                            <td class="font-weight-semi-bold">
                                                Hora
                                            </td>
                                            <td>
                                                 <?php echo e($KundaliReport['planet']['response']['panchang']['hora_lord']); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semi-bold">
                                                Day Lord
                                            </td>
                                            <td>
                                                 <?php echo e($KundaliReport['planet']['response']['panchang']['day_lord']); ?>

                                            </td>
                                        </tr>



                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade shadow-pink rounded-10 font-14 p-4" id="planetaryposition" role="tabpanel"
                    aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive table-theme shadow-pink">
                                <table class="table table-bordered border-pink font-14 mb-0">
                                    <thead class="matchV_thead bg-pink color-red">
                                        <tr>
                                            <th class="cellhead">Planet</th>
                                            <th class="cellhead">C</th>
                                            <th class="cellhead">R</th>
                                            <th class="cellhead">Rashi</th>
                                            <th class="cellhead">Local Degree</th>
                                             <th class="cellhead">Global Degree</th>
                                            <th class="cellhead">Nakshatra</th>
                                            <th class="cellhead">Pada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                        // Ensure $KundaliReport['planet']['response'] is an array
                                        $response = $KundaliReport['planet']['response'] ?? [];

                                        // Filter numerical keys (0 to 9)
                                        $filteredData = array_filter($response, function($key) {
                                            return is_int($key);
                                        }, ARRAY_FILTER_USE_KEY);
                                    ?>

                                    <?php $__currentLoopData = $filteredData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planetdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($planetdata['full_name'] ?? 'N/A'); ?></td>
                                           <td><?php echo e(isset($planetdata['is_combust']) && $planetdata['is_combust'] ? 'C' : ''); ?></td>
                                             <td><?php echo e(isset($planetdata['retro']) && $planetdata['retro'] ? 'R' : ''); ?></td>
                                            <td><?php echo e($planetdata['zodiac'] ?? 'N/A'); ?></td>
                                            <td><?php echo e($planetdata['local_degree'] ?? 'N/A'); ?></td>
                                            <td><?php echo e($planetdata['global_degree'] ?? 'N/A'); ?></td>
                                            <td><?php echo e($planetdata['nakshatra'] ?? 'N/A'); ?></td>
                                            <td><?php echo e($planetdata['nakshatra_pada'] ?? 'N/A'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade shadow-pink rounded-10 font-14 p-4" id="shodashvarga" role="tabpanel"
                    aria-labelledby="contact-tab">
                    <h2>Horoscope Chart</h2>
                     <div class="row">

                         <?php
                        $chartNames = [
                            'D1' => 'Rasi',
                            'D2' => 'Hora',
                            'D3' => 'Drekkana',
                            'D4' => 'Chaturthamsa',
                            'D5' => 'Panchamamsa',
                            'D6' => 'Shastamsa',
                            'D7' => 'Saptamsa',
                            'D8' => 'Astamsa',
                            'D9' => 'Navamsa',
                            'D10' => 'Dasamsa',
                            'D11' => 'Rudramsa',
                            'D12' => 'Dwadasamsa',
                            'D16' => 'Shodasamsa',
                            'D20' => 'Vimsamsa',
                            'D24' => 'Siddhamsa',
                            'D27' => 'Nakshatramsa',
                            'D30' => 'Trimsamsa',
                            'D40' => 'Khavedamsa',
                            'D45' => 'Akshavedamsa',
                            'D60' => 'Shastyamsa',
                            'chalit' => 'Chalit',
                            'sun' => 'Sun',
                            'moon' => 'Moon',
                            'kp_chalit'=>'Kp Chalit'
                        ];
                    ?>
                   <?php $__currentLoopData = $KundaliReport['charts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 mt-3">
                            <p class="font-16 mb-1"> <strong><?php echo e($chartNames[$key] ?? $key); ?></strong></p>
                            <?php echo $chart; ?>

                        </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                </div>

                <div class="tab-pane fade shadow-pink rounded-10 font-14 p-4" id="ashtakvarga" role="tabpanel"
                    aria-labelledby="contact-tab">


                    <div class="ds-head-populararticle bg-white">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="font-24">Ashtakvarga</h2>
                                        </div>
                                        <div class="col-12">
                                            <div class="table-users table-theme shadow-pink mb-3">
                                                <table class="table table-bordered border-pink font-14 mb-0"
                                                    cellpadding="0" cellspacing="0" border="0">
                                                    <thead class="font-13">
                                                        <tr class="bg-pink color-red font-weight-normal">
                                                            <th class="cellhead">&nbsp;</th>
                                                            <th>Ar</th>
                                                            <th>Ta</th>
                                                            <th>Ge</th>
                                                            <th>Ca</th>
                                                            <th>Le</th>
                                                            <th>Vi</th>
                                                            <th>Li</th>
                                                            <th>Sc</th>
                                                            <th>Sa</th>
                                                            <th>Ca</th>
                                                            <th>Aq</th>
                                                            <th>Pi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $KundaliReport['ashtakvarga']['response']['ashtakvarga_order']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <?php if($name !== 'Ascendant'): ?>
                                                            <tr>
                                                                <td><?php echo e($name); ?></td>
                                                                <?php $__currentLoopData = $KundaliReport['ashtakvarga']['response']['ashtakvarga_points'][$index]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $points): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <td><?php echo e($points); ?></td>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>Total</td>
                                                            <?php $__currentLoopData = $KundaliReport['ashtakvarga']['response']['ashtakvarga_total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <td><?php echo e($total); ?></td>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade shadow-pink rounded-10 font-14 p-4" id="predictions" role="tabpanel"
                    aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="font-24">Predictions</h2>
                        </div>
                        <div class="col-12">
                            <div class="panel-group my-1" id="accordion">

                              <?php
                                $ordinalWords = [
                                    1 => 'First',
                                    2 => 'Second',
                                    3 => 'Third',
                                    4 => 'Fourth',
                                    5 => 'Fifth',
                                    6 => 'Sixth',
                                    7 => 'Seventh',
                                    8 => 'Eighth',
                                    9 => 'Ninth',
                                    10 => 'Tenth',
                                    11=>'Eleventh',
                                    12=>'Twelth'
                                ];
                            ?>

                            <?php $__currentLoopData = $KundaliReport['personal']['response']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prediction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $houseNumber = $index + 1; // Adjust for 1-based index
                                    $houseWord = $ordinalWords[$houseNumber] ?? $houseNumber; // Fallback to number if not in array
                                ?>

                                <div class="panel panel-default mb-3">
                                    <div class="panel-heading">
                                        <h3 class="panel-title mb-0">
                                            <a class="accordion-toggle font-weight-semi d-block py-2 colorblack font-16"
                                                data-toggle="collapse" data-parent="#accordion" href="#accAbount_<?php echo e($index); ?>">
                                                <?php echo e($houseWord); ?> House
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="accAbount_<?php echo e($index); ?>" class="panel-collapse collapse <?php echo e($index === 0 ? 'show' : ''); ?>" data-parent="#accordion">
                                        <div class="panel-body px-0 px-md-3 py-4 border-top">
                                            <p><?php echo e($prediction['personalised_prediction']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    const tabHeadbox = document.querySelector('.tab-headbox');
    let isDown = false, startX, scrollLeft;

    tabHeadbox.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - tabHeadbox.offsetLeft;
        scrollLeft = tabHeadbox.scrollLeft;
    });

    tabHeadbox.addEventListener('mouseleave mouseup', () => isDown = false);

    tabHeadbox.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        tabHeadbox.scrollLeft = scrollLeft - (e.pageX - tabHeadbox.offsetLeft - startX) * 2;
    });

    tabHeadbox.addEventListener('wheel', (e) => {
        e.preventDefault();
        tabHeadbox.scrollLeft += e.deltaY;
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.astrologers.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/frontend/astrologers/pages/kundali-report.blade.php ENDPATH**/ ?>