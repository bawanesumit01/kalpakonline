

<?php $__env->startSection('content'); ?>
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">

                        <!-- Breadcrumbs -->
                        <div class="row mx-4">
                            <div class="col-5 align-self-center">
                                <h4 class="mdc-typography--headline4 pt-2">Category</h4>
                                <div class="d-flex align-items-center">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="#" class="text-decoration-none">Home</a>
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Category
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Edit
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-7 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="<?php echo e(route('category.index')); ?>">
                                        <button
                                            class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                            style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                            <i class="fa-solid fa-angle-left pe-1"></i>Back
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- form -->
                        <form class="shadow pt-3" method="POST"
                            action="<?php echo e(route('category.update', $category->category_id)); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="row m-2">

                                <!-- Category Name -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                        <input class="mdc-text-field__input" id="category_name" type="text"
                                            name="category_name"
                                            value="<?php echo e(old('category_name', $category->category_name)); ?>" required autofocus
                                            autocomplete="category_name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="category_name" class="mdc-floating-label">Category Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <?php if(auth()->user()->role === 'superadmin'): ?>
                                    <!-- vendor_id -->
                                    <div class="col-md-6 my-2 ">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <select class="mdc-text-field__input" id="ven" name="vendor_id" required>
                                                <option value="" disabled>Select Vendor</option>
                                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($vendor->vendor_id); ?>"
                                                        <?php echo e(old('vendor_id', $category->vendor_id) == $vendor->vendor_id ? 'selected' : ''); ?>>
                                                        <?php echo e($vendor->vendor_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="vendor_id" class="mdc-floating-label">Vendor</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                            <?php $__errorArgs = ['vendor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- ADMIN → Hidden vendor_id -->
                                    <input type="hidden" name="vendor_id" value="<?php echo e(auth()->user()->vendor->vendor_id); ?>">
                                <?php endif; ?>
                                
                                <!-- cat_image -->
                                <div class="col-md-4 my-2">
                                    <div class="">
                                        <label for="cat_image" class="">Category Image</label>
                                        <input class="" type="file" id="cat_image" name="cat_image"
                                            accept="image/*" onchange="previewCatImage(event)">


                                    </div>

                                    <?php $__errorArgs = ['cat_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img id="catImagePreview" src="<?php echo e(asset('/categoryImage/' . $category->cat_image)); ?>"
                                            alt="Selected Image Preview"
                                            style="width:120px; height:120px; object-fit:cover; border:1px solid #ddd; border-radius:8px;">
                                    </div>
                                </div>



                                <!-- Actions -->
                                <div class="d-flex gap-3 pt-2 mt-5">
                                    <button type="submit"
                                        class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        Update
                                    </button>
                                    <a href="<?php echo e(route('category.index')); ?>"
                                        class="mdc-typography--button mdc-button mdc-button--outlined mdc-button--dense">
                                        Cancel
                                    </a>
                                </div>

                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </main>
    </div>
     <script>
        function previewCatImage(event) {
            const input = event.target;
            const preview = document.getElementById('catImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/admin/category/edit.blade.php ENDPATH**/ ?>