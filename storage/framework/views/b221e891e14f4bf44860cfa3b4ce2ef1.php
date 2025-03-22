<?php if(Auth()->user()): ?>



<?php $__env->startSection('head'); ?>
    <?php echo $__env->yieldContent('subhead'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('../layout/components/mobile-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('../layout/components/top-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="flex overflow-hidden">
        <nav class="side-nav">
            <ul>
                <?php
                    $side_menu = [];
                    $user = auth()->user();
                    $teamMember = DB::table('teammember')
                        ->where('userId', $user->id)
                        ->first();
                    $pages = [];
                    if ($teamMember) {
                        $rolePages = DB::table('rolepages')
                            ->join('adminpages', 'adminpages.id', 'rolepages.adminPageId')
                            ->where('teamRoleId', $teamMember->teamRoleId)
                            ->select('adminpages.*')
                            ->get();
                        $pageGroup = DB::table('adminpages')
                            ->whereNull('pageGroup')
                            ->get();
                        for ($i = 0; $i < count($pageGroup); $i++) {
                            $pages = DB::table('adminpages')
                                ->where('pageGroup', $pageGroup[$i]->id)
                                ->get();
                            $pageGroup[$i]->sub_menu = [];
                            if ($pages && count($pages) > 0) {
                                for ($j = 0; $j < count($rolePages); $j++) {
                                    $id = $rolePages[$j]->id;
                                    $result = array_filter(json_decode($pages), function ($event) use ($id) {
                                        return $event->id === $id;
                                    });
                                    if ($result && count($result) > 0) {
                                        array_push($pageGroup[$i]->sub_menu, $rolePages[$j]);
                                    }
                                }
                            }
                        }
                        for ($i = 0; $i < count($pageGroup); $i++) {
                            if ($pageGroup[$i]->sub_menu && count($pageGroup[$i]->sub_menu) > 0) {
                                array_push($side_menu, $pageGroup[$i]);
                            }
                        }
                        $parentPages = DB::table('rolepages')
                            ->join('adminpages', 'adminpages.id', 'rolepages.adminPageId')
                            ->where('teamRoleId', $teamMember->teamRoleId)
                            ->whereNull('adminpages.pageGroup')
                            ->select('adminpages.*')
                            ->get();
                        $side_menu = array_merge($side_menu, json_decode($parentPages));
                    } else {
                        $pageGroup = DB::table('adminpages')
                            ->whereNull('pageGroup')
                            ->get();
                        for ($i = 0; $i < count($pageGroup); $i++) {
                            $pages = DB::table('adminpages')
                                ->where('pageGroup', $pageGroup[$i]->id)
                                ->get();
                            $pageGroup[$i]->sub_menu = [];
                            if ($pages && count($pages) > 0) {
                                $pageGroup[$i]->sub_menu = $pages;
                            }
                        }
                        $side_menu = $pageGroup;
                    }
                    $side_menu = collect( $side_menu);
                    $side_menu =  $side_menu->sortBy('displayOrder');
                ?>
                <?php $__currentLoopData = $side_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuKey => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($menu == 'devider'): ?>
                        <li class="side-nav__devider my-6"></li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo e(isset($menu->route) ? route($menu->route) : 'javascript:;'); ?>"
                                class="<?php echo e($first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu'); ?>">
                                <div class="side-menu__icon">
                                    <i data-lucide="<?php echo e($menu->icon); ?>"></i>
                                </div>
                                <div class="side-menu__title">
                                    <?php echo e($menu->pageName); ?>

                                    <?php if(isset($menu->sub_menu) && count($menu->sub_menu) > 0): ?>
                                        <div
                                            class="side-menu__sub-icon <?php echo e($first_level_active_index == $menuKey ? 'transform rotate-180' : ''); ?>">
                                            <i data-lucide="chevron-down"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <?php if(isset($menu->sub_menu)): ?>
                                <ul class="<?php echo e($first_level_active_index == $menuKey ? 'side-menu__sub-open' : ''); ?>">
                                    <?php $__currentLoopData = $menu->sub_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuKey => $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e(isset($subMenu->route) ? route($subMenu->route) : 'javascript:;'); ?>"
                                                class="<?php echo e($second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu'); ?>">
                                                <div class="side-menu__icon">
                                                    
                                                    <i data-lucide="<?php echo e($subMenu->icon); ?>"></i>
                                                </div>
                                                <div class="side-menu__title">
                                                    <?php echo e($subMenu->pageName); ?>

                                                    <?php if(isset($subMenu->sub_menu)): ?>
                                                        <div
                                                            class="side-menu__sub-icon <?php echo e($second_level_active_index == $subMenuKey ? 'transform rotate-180' : ''); ?>">
                                                            <i data-lucide="chevron-down"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </a>
                                            <?php if(isset($subMenu->sub_menu)): ?>
                                                <ul
                                                    class="<?php echo e($second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : ''); ?>">
                                                    <?php $__currentLoopData = $subMenu->sub_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lastSubMenuKey => $lastSubMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <a href="<?php echo e(isset($lastSubMenu->route) ? route($lastSubMenu->route) : 'javascript:;'); ?>"
                                                                class="<?php echo e($third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu'); ?>">
                                                                <div class="side-menu__icon">
                                                                    <i data-lucide="zap"></i>
                                                                </div>
                                                                <div class="side-menu__title"><?php echo e($lastSubMenu->pageName); ?>

                                                                </div>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <?php echo $__env->yieldContent('subcontent'); ?>
        </div>
        <!-- END: Content -->
    </div>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('../layout/main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8212\htdocs\resources\views////layout/side-menu.blade.php ENDPATH**/ ?>