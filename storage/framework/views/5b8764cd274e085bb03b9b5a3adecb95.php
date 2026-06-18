

<?php $__env->startSection('content'); ?>
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">

                        <!-- Breadcrumbs -->
                        <div class="row mx-4">
                            <div class="col-5 align-self-center">
                                <h4 class="mdc-typography--headline4 pt-2">Products</h4>
                                <div class="d-flex align-items-center">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="#" class="text-decoration-none">Home</a>
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Product
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Create
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-7 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="<?php echo e(route('products.index')); ?>">
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
                        <form class="shadow pt-3" method="POST" action="<?php echo e(route('products.store')); ?>"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row m-2">
                                <!-- product_name Name -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="product_name" type="text"
                                            name="product_name" value="<?php echo e(old('product_name')); ?>" required autofocus
                                            autocomplete="product_name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="product_name" class="mdc-floating-label">Product Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['product_name'];
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
                                <!-- product_sku  Name -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="product_sku" type="text"
                                            name="product_sku" value="<?php echo e(old('product_sku')); ?>" required autofocus
                                            autocomplete="product_sku">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="product_sku" class="mdc-floating-label">Product SKU</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['product_sku'];
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
                                    <div class="col-md-4 my-2">

                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <select class="mdc-text-field__input" id="vendor_id" name="vendor_id" required>
                                                <option value="" disabled selected></option>
                                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($vendor->vendor_id); ?>"><?php echo e($vendor->vendor_name); ?>

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
                                <!-- category_id -->
                                <div class="col-md-4 my-2">

                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <select class="mdc-text-field__input" id="category_id" name="category_id" required>
                                            <option value="" disabled selected></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->category_id); ?>">
                                                    <?php echo e($category->category_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="category_id" class="mdc-floating-label">Category</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['category_id'];
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
                                <!-- cost_price -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="cost_price" type="number"
                                            name="cost_price" value="<?php echo e(old('cost_price')); ?>" required autofocus
                                            autocomplete="cost_price">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="cost_price" class="mdc-floating-label">Cost Price</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['cost_price'];
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
                                <!-- selling_price -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="selling_price" type="number"
                                            name="selling_price" value="<?php echo e(old('selling_price')); ?>" required autofocus
                                            autocomplete="selling_price">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="selling_price" class="mdc-floating-label">Selling
                                                    Price</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['selling_price'];
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
                                <!-- discount_percent -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="discount_percent" type="number"
                                            name="discount_percent" value="<?php echo e(old('discount_percent')); ?>"
                                            autocomplete="discount_percent">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="discount_percent" class="mdc-floating-label">Discount
                                                    Percent</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['discount_percent'];
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
                                <!-- final_price -->
                                
                                <!-- tax_rate -->
                                
                                <!-- stock_quantity -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="stock_quantity" type="number"
                                            step="0.01" name="stock_quantity" value="<?php echo e(old('stock_quantity')); ?>"
                                            required autofocus autocomplete="stock_quantity">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="stock_quantity" class="mdc-floating-label">Stock
                                                    Quantity</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['stock_quantity'];
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
                                <!-- min_stock_alert -->
                                <div class="col-md-4 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="min_stock_alert" type="number"
                                            step="0.01" name="min_stock_alert" value="<?php echo e(old('min_stock_alert')); ?>"
                                            autocomplete="min_stock_alert">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="min_stock_alert" class="mdc-floating-label">Minimum Stock
                                                    Alert</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['min_stock_alert'];
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
                                <!-- stock_status -->
                                <div class="col-md-4 my-2">

                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <select class="mdc-text-field__input" id="stock_status" name="stock_status"
                                            required>
                                            <option value="in_stock">In Stock</option>
                                            <option value="out_of_stock">Out of Stock</option>
                                            <option value="pre_order">Preorder</option>
                                        </select>
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="stock_status" class="mdc-floating-label">Stock Status</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['stock_status'];
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
                                <!-- short_description -->
                                <div class="col-md-12 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="short_description" type="text"
                                            name="short_description" value="<?php echo e(old('short_description')); ?>"
                                            autocomplete="short_description">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="short_description" class="mdc-floating-label">Short
                                                    Description</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['short_description'];
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
                                <!-- description -->
                                <div class="col-md-12 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea">

                                        <textarea class="mdc-text-field__input" id="description" name="description" rows="4"
                                            autocomplete="description"><?php echo e(old('description')); ?></textarea>

                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="description" class="mdc-floating-label">
                                                    Full Description
                                                </label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>

                                    <?php $__errorArgs = ['description'];
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
                                <!-- main_image -->
                                <div class="col-md-4 my-2">
                                    <div class="">
                                        <label for="main_image" class="">Main Product Image <sub
                                                class="">*</sub> </label>
                                        <input class="" type="file" id="main_image" name="main_image"
                                            accept="image/*" onchange="previewMainImage(event)" required>


                                    </div>

                                    <?php $__errorArgs = ['main_image'];
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
                                        <img id="mainImagePreview" src="#" alt="Selected Image Preview"
                                            style="display:none; width:120px; height:120px; object-fit:cover; border:1px solid #ddd; border-radius:8px;">
                                    </div>
                                </div>
                                <!-- gallery_images -->
                                <div class="col-md-4 my-2">
                                    <div class="">
                                        <label for="gallery_images" class="">
                                            Gallery Images
                                        </label>
                                        <input class="" type="file" id="gallery_images" name="gallery_images[]"
                                            multiple accept="image/*" onchange="previewGalleryImages(event)">

                                    </div>

                                    <?php $__errorArgs = ['gallery_images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <!-- Gallery Preview -->
                                    <div id="galleryPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                                </div>
                                <!-- status -->
                                <div class="col-md-4 my-2">

                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <select class="mdc-text-field__input" id="status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="status" class="mdc-floating-label">Status</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        <?php $__errorArgs = ['status'];
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




                                <!-- Actions -->
                                <div class="flex items-center justify-end mt-5 d-flex gap-3 pt2 ">

                                    <button type="submit"
                                        class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                        style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        function previewMainImage(event) {
            const input = event.target;
            const preview = document.getElementById('mainImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewGalleryImages(event) {
            const previewContainer = document.getElementById('galleryPreview');
            previewContainer.innerHTML = '';

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.border = '1px solid #ddd';
                    img.style.borderRadius = '8px';

                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/admin/products/create.blade.php ENDPATH**/ ?>