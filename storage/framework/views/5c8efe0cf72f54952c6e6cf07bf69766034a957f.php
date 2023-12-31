<?php if(get_setting('home_categories') != null): ?> 
    <?php $home_categories = json_decode(get_setting('home_categories')); ?>
    <?php $__currentLoopData = $home_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $category = \App\Models\Category::find($value); ?>
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e($category->name); ?></span>
                        </h3>
                        <a href="<?php echo e(route('products.category', $category->slug)); ?>" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md"><?php echo e(translate('View More')); ?></a>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                        <?php $__currentLoopData = get_cached_products($category->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-box">
                                <?php echo $__env->make('frontend.partials.product_box_1',['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/frontend/partials/home_categories_section.blade.php ENDPATH**/ ?>