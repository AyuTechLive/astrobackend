<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar" style="background-color:#426f7f">
        <a href="" class="flex mr-auto">
            <?php
                $logo = DB::table('systemflag')
                    ->where('name', 'AdminLogo')
                    ->select('value')
                    ->first();
            ?>
            <img alt="Midone - HTML Admin Template" class="w-6" src="/<?php echo e($logo->value); ?>">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler">
            <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler">
            <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
        <ul class="scrollable__content py-2">
            <?php $__currentLoopData = $side_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuKey => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($menu == 'devider'): ?>
                    <li class="menu__devider my-6"></li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo e(isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;'); ?>"
                            class="<?php echo e($first_level_active_index == $menuKey ? 'menu menu--active' : 'menu'); ?>">
                            <div class="menu__icon">
                                <i data-lucide="<?php echo e($menu['icon']); ?>"></i>
                            </div>
                            <div class="menu__title">
                                <?php echo e($menu['title']); ?>

                                <?php if(isset($menu['sub_menu'])): ?>
                                    <i data-lucide="chevron-down"
                                        class="menu__sub-icon <?php echo e($first_level_active_index == $menuKey ? 'transform rotate-180' : ''); ?>"></i>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php if(isset($menu['sub_menu'])): ?>
                            <ul class="<?php echo e($first_level_active_index == $menuKey ? 'menu__sub-open' : ''); ?>">
                                <?php $__currentLoopData = $menu['sub_menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuKey => $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;'); ?>"
                                            class="<?php echo e($second_level_active_index == $subMenuKey ? 'menu menu--active' : 'menu'); ?>">
                                            <div class="menu__icon">
                                                <i data-lucide="activity"></i>
                                            </div>
                                            <div class="menu__title">
                                                <?php echo e($subMenu['title']); ?>

                                                <?php if(isset($subMenu['sub_menu'])): ?>
                                                    <i data-lucide="chevron-down"
                                                        class="menu__sub-icon <?php echo e($second_level_active_index == $subMenuKey ? 'transform rotate-180' : ''); ?>"></i>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                        <?php if(isset($subMenu['sub_menu'])): ?>
                                            <ul
                                                class="<?php echo e($second_level_active_index == $subMenuKey ? 'menu__sub-open' : ''); ?>">
                                                <?php $__currentLoopData = $subMenu['sub_menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lastSubMenuKey => $lastSubMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a href="<?php echo e(isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;'); ?>"
                                                            class="<?php echo e($third_level_active_index == $lastSubMenuKey ? 'menu menu--active' : 'menu'); ?>">
                                                            <div class="menu__icon">
                                                                <i data-lucide="zap"></i>
                                                            </div>
                                                            <div class="menu__title"><?php echo e($lastSubMenu['title']); ?></div>
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
    </div>
</div>
<!-- END: Mobile Menu -->
<?php /**PATH /var/www/vhosts/astroway.diploy.in/httpdocs/resources/views////layout/components/mobile-menu.blade.php ENDPATH**/ ?>