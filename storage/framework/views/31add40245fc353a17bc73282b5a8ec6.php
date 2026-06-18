 <?php $user = auth()->user(); ?>

 <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
     <div class="mdc-drawer__header">
         <a href="<?php echo e(route('dashboard')); ?>" class="brand-logo">
             <img src="<?php echo e(asset('/assets/images/kalpak-logo.jpeg')); ?>" class="w-100" alt="logo">
         </a>
     </div>
     <div class="mdc-drawer__content">
         <div class="user-info">
             <p class="name"><?php echo e(auth()->user()->name); ?></p>
             <p class="email"><?php echo e(auth()->user()->email); ?></p>
         </div>
         <div class="mdc-list-group">
             <nav class="mdc-list mdc-drawer-menu">
                 <?php if($user->hasPermission('dashboard')): ?>
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                             href="<?php echo e(route('dashboard')); ?>">
                             <i class="fa-solid fa-house"></i> Dashboard
                         </a>
                     </div>
                 <?php endif; ?>
                 <?php if($user->hasPermission('vendors')): ?>
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 <?php echo e(request()->routeIs('vendor.index') ? 'active' : ''); ?>"
                             href="<?php echo e(route('vendor.index')); ?>">
                             <i class="fa-solid fa-shop"></i> Vendor
                         </a>
                     </div>
                 <?php endif; ?>
                 <?php if($user->hasPermission('category')): ?>
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 <?php echo e(request()->routeIs('category.index') ? 'active' : ''); ?>"
                             href="<?php echo e(route('category.index')); ?>">
                             <i class="fa-solid fa-tags"></i> Category
                         </a>
                     </div>
                 <?php endif; ?>
                 <?php if($user->hasPermission('products')): ?>
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 <?php echo e(request()->routeIs('products.index') ? 'active' : ''); ?>"
                             href="<?php echo e(route('products.index')); ?>">
                             <i class="fa-solid fa-boxes-stacked"></i> Products
                         </a>
                     </div>
                 <?php endif; ?>

                 <!--<div class="mdc-list-item mdc-drawer-item">-->
                 <!--    <a class="mdc-expansion-panel-link gap-3" href="#" data-toggle="expansionPanel"-->
                 <!--        data-target="ui-sub-menu">-->
                 <!--        <i class="fa-solid fa-table-list"></i> UI Features-->
                 <!--        <i class="fa-solid fa-angle-right"></i>-->
                 <!--    </a>-->
                 <!--    <div class="mdc-expansion-panel" id="ui-sub-menu">-->
                 <!--        <nav class="mdc-list mdc-drawer-submenu">-->
                 <!--            <div class="mdc-list-item mdc-drawer-item">-->
                 <!--                <a class="mdc-drawer-link" href="#">-->
                 <!--                    Buttons-->
                 <!--                </a>-->
                 <!--            </div>-->
                 <!--            <div class="mdc-list-item mdc-drawer-item">-->
                 <!--                <a class="mdc-drawer-link" href="#">-->
                 <!--                    Typography-->
                 <!--                </a>-->
                 <!--            </div>-->
                 <!--        </nav>-->
                 <!--    </div>-->
                 <!--</div>-->


             </nav>
         </div>
         <div class="profile-actions">
             <a href="javascript:;" class="pt-1">Settings</a>
             <span class="divider pt-4"></span>
             <form method="POST" action="<?php echo e(route('logout')); ?>">
                 <?php echo csrf_field(); ?>

                 <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" style="cursor: pointer;">
                     Logout
                 </a>
             </form>
         </div>

     </div>
 </aside>
<?php /**PATH /home/kalpakon/public_html/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>