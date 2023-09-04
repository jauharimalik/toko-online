

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center"><?php echo e(translate('S3 File System Credentials')); ?></h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="<?php echo e(route('payment_method.update')); ?>" method="POST">
                        <input type="hidden" name="payment_method" value="paypal">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_ACCESS_KEY_ID">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('AWS_ACCESS_KEY_ID')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_ACCESS_KEY_ID" value="<?php echo e(env('AWS_ACCESS_KEY_ID')); ?>" placeholder="<?php echo e(translate('AWS_ACCESS_KEY_ID')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_SECRET_ACCESS_KEY">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('AWS_SECRET_ACCESS_KEY')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_SECRET_ACCESS_KEY" value="<?php echo e(env('AWS_SECRET_ACCESS_KEY')); ?>" placeholder="<?php echo e(translate('AWS_SECRET_ACCESS_KEY')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_DEFAULT_REGION">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('AWS_DEFAULT_REGION')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_DEFAULT_REGION" value="<?php echo e(env('AWS_DEFAULT_REGION')); ?>" placeholder="<?php echo e(translate('AWS_DEFAULT_REGION')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_BUCKET">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('AWS_BUCKET')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_BUCKET" value="<?php echo e(env('AWS_BUCKET')); ?>" placeholder="<?php echo e(translate('AWS_BUCKET')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_URL">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('AWS_URL')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_URL" value="<?php echo e(env('AWS_URL')); ?>" placeholder="<?php echo e(translate('AWS_URL')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center"><?php echo e(translate('S3 File System Activation')); ?></h3>
                </div>
                <div class="card-body">
                    <label class="aiz-switch mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'FILESYSTEM_DRIVER')" <?php if(env('FILESYSTEM_DRIVER') == 's3') echo "checked";?>>
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center"><?php echo e(translate('Cache & Session Driver')); ?></h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="<?php echo e(route('payment_method.update')); ?>" method="POST">
                        <input type="hidden" name="payment_method" value="paypal">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="CACHE_DRIVER">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('CACHE_DRIVER')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="CACHE_DRIVER">
                                    <option value="file" <?php if(env('CACHE_DRIVER') == "file"): ?> selected <?php endif; ?>><?php echo e(translate('file')); ?></option>
                                    <option value="redis" <?php if(env('CACHE_DRIVER') == "redis"): ?> selected <?php endif; ?>><?php echo e(translate('redis')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="SESSION_DRIVER">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('SESSION_DRIVER')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="SESSION_DRIVER">
                                    <option value="file" <?php if(env('SESSION_DRIVER') == "file"): ?> selected <?php endif; ?>><?php echo e(translate('file')); ?></option>
                                    <option value="redis" <?php if(env('SESSION_DRIVER') == "redis"): ?> selected <?php endif; ?>><?php echo e(translate('redis')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center"><?php echo e(translate('Redis Configuration (If you use redis as any of the drivers)')); ?></h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="<?php echo e(route('payment_method.update')); ?>" method="POST">
                        <input type="hidden" name="payment_method" value="paypal">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="REDIS_HOST">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('REDIS_HOST')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="REDIS_HOST" value="<?php echo e(env('REDIS_HOST')); ?>" placeholder="<?php echo e(translate('REDIS_HOST')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="REDIS_PASSWORD">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('REDIS_PASSWORD')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="REDIS_PASSWORD" value="<?php echo e(env('REDIS_PASSWORD')); ?>" placeholder="<?php echo e(translate('REDIS_PASSWORD')); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="REDIS_PORT">
                            <div class="col-lg-4">
                                <label class="control-label"><?php echo e(translate('REDIS_PORT')); ?></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="REDIS_PORT" value="<?php echo e(env('REDIS_PORT')); ?>" placeholder="<?php echo e(translate('REDIS_PORT')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/backend/setup_configurations/file_system.blade.php ENDPATH**/ ?>