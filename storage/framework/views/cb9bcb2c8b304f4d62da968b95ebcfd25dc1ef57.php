

<?php $__env->startSection('content'); ?>

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center">
            <h1 class="h3"><?php echo e(translate('All Colors')); ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="<?php if(auth()->user()->can('add_color')): ?> col-lg-7 <?php else: ?> col-lg-12 <?php endif; ?>">
            <div class="card">
                <form class="" id="sort_colors" action="" method="GET">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Colors')); ?></h5>
                        <div class="col-md-5">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control form-control-sm" id="search" name="search"
                                    <?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?>
                                    placeholder="<?php echo e(translate('Type color name & Enter')); ?>">
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo e(translate('Name')); ?></th>
                                <th class="text-right"><?php echo e(translate('Options')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(($key+1) + ($colors->currentPage() - 1)*$colors->perPage()); ?></td>
                                    <td><?php echo e($color->name); ?></td>
                                    <td class="text-right">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_color')): ?>
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="<?php echo e(route('colors.edit', ['id' => $color->id, 'lang' => env('DEFAULT_LANGUAGE')])); ?>"
                                                title="<?php echo e(translate('Edit')); ?>">
                                                <i class="las la-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_color')): ?>
                                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="<?php echo e(route('colors.destroy', $color->id)); ?>"
                                                title="<?php echo e(translate('Delete')); ?>">
                                                <i class="las la-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        <?php echo e($colors->appends(request()->input())->links()); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_color')): ?>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><?php echo e(translate('Add New Color')); ?></h5>
                    </div>
                    <div class="card-body">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('colors.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group mb-3">
                                <label for="name"><?php echo e(translate('Name')); ?></label>
                                <input type="text" placeholder="<?php echo e(translate('Name')); ?>" id="name" name="name"
                                    class="form-control" value="<?php echo e(old('name')); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name"><?php echo e(translate('Color Code')); ?></label>
                                <input type="text" placeholder="<?php echo e(translate('Color Code')); ?>" id="code" name="code"
                                    class="form-control" value="<?php echo e(old('code')); ?>" required>
                            </div>
                            <div class="form-group mb-3 text-right">
                                <button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0 h6"><?php echo e(translate('Color filter activation')); ?></h3>
                    </div>
                    <div class="card-body text-center">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateSettings(this, 'color_filter_activation')" <?php if(get_setting('color_filter_activation') == 1) echo "checked";?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function updateSettings(el, type){
            if($(el).is(':checked')){
                var value = 1;
            }
            else{
                var value = 0;
            }
            
            $.post('<?php echo e(route('business_settings.update.activation')); ?>', {_token:'<?php echo e(csrf_token()); ?>', type:type, value:value}, function(data){
                if(data == '1'){
                    AIZ.plugins.notify('success', '<?php echo e(translate('Settings updated successfully')); ?>');
                }
                else{
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/backend/product/color/index.blade.php ENDPATH**/ ?>