<header>
    
<div style="background: #6bb252; color: #fff; padding: 2px 0; position: relative;">
    <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop()" onmouseout="this.start()">
        <span class="mx-5">🛒 Free Delivery on orders above ₹499</span>
        <span class="mx-5">⚡ Flash Sale — Up to 50% OFF on selected items!</span>
        <span class="mx-5">🎁 Use code <strong>KALPAK10</strong> for 10% off your first order</span>
        <span class="mx-5">🚚 Same Day Delivery available in select areas</span>
        <span class="mx-5">✅ 100% Genuine & Quality Products</span>
        <span class="mx-5">📞 Customer Support: +91 XXXXXXXXXX</span>
    </marquee>
</div>
  <div class="container-fluid card shadow">
    <div class="row border-bottom">
      
      <div class="col-sm-4 col-lg-2 text-center text-sm-start d-flex gap-3 justify-content-center justify-content-md-start">
        <div class="d-flex align-items-center my-3 my-sm-0">
          <a href="<?php echo e(route('home.index')); ?>">
            <img src="<?php echo e(asset('/assets/images/kalpak-logo.png')); ?>" alt="logo" class="img-fluid">
          </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar">
          <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#menu"></use></svg>
        </button>
      </div>
      
      <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-4">
        
      </div>

      <div class="col-lg-4">
        
      </div>
      
      <div class="col-sm-8 col-lg-2 d-flex gap-5 align-items-center justify-content-center justify-content-sm-end">
        <ul class="d-flex justify-content-end list-unstyled m-0">
          <li>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role == 'client'): ?>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle text-dark text-decoration-none" data-bs-toggle="dropdown">
                            <svg width="24" height="24"><use xlink:href="#user"></use></svg>
                            <?php echo e(Auth::user()->name); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo e(route('profile')); ?>">My Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('orders')); ?>">My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('customer.logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('customer.login')); ?>" class="text-dark text-decoration-none">
                        Login <svg width="24" height="24"><use xlink:href="#user"></use></svg>
                        
                    </a>
                <?php endif; ?>
          </li>
          
          <!--cart-->
          <li>
            <a href="<?php echo e(route('cart.view')); ?>" class="position-relative p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
              <svg width="24" height="24"><use xlink:href="#shopping-bag"></use></svg>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                   <?php echo e($cartCount ?? 0); ?>

                </span>
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</header><?php /**PATH E:\xampp\htdocs\kalpakonline\resources\views/home/header.blade.php ENDPATH**/ ?>