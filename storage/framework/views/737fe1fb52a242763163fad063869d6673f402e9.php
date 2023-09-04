

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6"><?php echo e(translate('Minimum Order Amount Settings')); ?></h5>
            </div>
            <form action="<?php echo e(route('business_settings.update')); ?>" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                   <?php echo csrf_field(); ?>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="control-label"><?php echo e(translate('Minimum Order Amount Check')); ?></label>
                        </div>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="hidden" name="types[]" value="minimum_order_amount_check">
                                <input value="1" name="minimum_order_amount_check" type="checkbox" <?php if(get_setting('minimum_order_amount_check') == 1): ?>
                                    checked
                                <?php endif; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="minimum_order_amount">
                        <div class="col-md-4">
                            <label class="control-label"><?php echo e(translate('Set Minimum Order Amount')); ?></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="minimum_order_amount" value="<?php echo e(get_setting('minimum_order_amount')); ?>" placeholder="<?php echo e(translate('Minimum Order Amount')); ?>" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><?php echo e(translate('Save')); ?></button>
                    </div>
              </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/backend/setup_configurations/order_configuration/index.blade.php ENDPATH**/ ?>