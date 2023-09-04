

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-10 col-xxl-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="h6 mb-0"><?php echo e(translate('Server information')); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-striped aiz-table">
                    <thead>
                        <tr>
                            <th><?php echo e(translate('Name')); ?></th>
                            <th data-breakpoints="lg"><?php echo e(translate('Current Version')); ?></th>
                            <th data-breakpoints="lg"><?php echo e(translate('Required Version')); ?></th>
                            <th><?php echo e(translate('Status')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Php versions</td>
                            <td><?php echo e(phpversion()); ?></td>
                            <td>7.3 or 7.4</td>
                            <td>
                                <?php if(floatval(phpversion()) >= 7.3 && floatval(phpversion()) <= 7.4): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>MySQL</td>
                            <td>
                                <?php
                                $results = DB::select( DB::raw("select version()") );
                                $mysql_version =  $results[0]->{'version()'};
                                ?>
                                <?php echo e($mysql_version); ?>

                            </td>
                            <td>5.6+</td>
                            <td>
                                <?php if($mysql_version >= 5.6): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="h6 mb-0"><?php echo e(translate('php.ini Config')); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-striped aiz-table">
                    <thead>
                        <tr>
                            <th><?php echo e(translate('Config Name')); ?></th>
                            <th data-breakpoints="lg"><?php echo e(translate('Current')); ?></th>
                            <th data-breakpoints="lg"><?php echo e(translate('Recommended')); ?></th>
                            <th><?php echo e(translate('Status')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>file_uploads</td>
                            <td>
                                <?php if(ini_get('file_uploads') == 1): ?>
                                On
                                <?php else: ?>
                                Off
                                <?php endif; ?>
                            </td>
                            <td>On</td>
                            <td>
                                <?php if(ini_get('file_uploads') == 1): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>max_file_uploads</td>
                            <td>
                                <?php echo e(ini_get('max_file_uploads')); ?>

                            </td>
                            <td>20+</td>
                            <td>
                                <?php if(ini_get('max_file_uploads') >= 20): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>upload_max_filesize</td>
                            <td>
                                <?php echo e(ini_get('upload_max_filesize')); ?>

                            </td>
                            <td>128M+</td>
                            <td>
                                <?php if(str_replace(['M','G'],"", ini_get('upload_max_filesize')) >= 128): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>post_max_size</td>
                            <td>
                                <?php echo e(ini_get('post_max_size')); ?>

                            </td>
                            <td>128M+</td>
                            <td>
                                <?php if(str_replace(['M','G'],"", ini_get('post_max_size')) >= 128): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>allow_url_fopen</td>
                            <td>
                                <?php if(ini_get('allow_url_fopen') == 1): ?>
                                On
                                <?php else: ?>
                                Off
                                <?php endif; ?>
                            </td>
                            <td>On</td>
                            <td>
                                <?php if(ini_get('allow_url_fopen') == 1): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>max_execution_time</td>
                            <td>
                                <?php if(ini_get('max_execution_time') == '-1'): ?>
                                Unlimited
                                <?php else: ?>
                                <?php echo e(ini_get('max_execution_time')); ?>

                                <?php endif; ?>
                            </td>
                            <td>600+</td>
                            <td>
                                <?php if(ini_get('max_execution_time') == -1 || ini_get('max_execution_time') >= 600): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>max_input_time</td>
                            <td>
                                <?php if(ini_get('max_input_time') == '-1'): ?>
                                Unlimited
                                <?php else: ?>
                                <?php echo e(ini_get('max_input_time')); ?>

                                <?php endif; ?>
                            </td>
                            <td>120+</td>
                            <td>
                                <?php if(ini_get('max_input_time') == -1 || ini_get('max_input_time') >= 120): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>max_input_vars</td>
                            <td>
                                <?php echo e(ini_get('max_input_vars')); ?>

                            </td>
                            <td>1000+</td>
                            <td>
                                <?php if(ini_get('max_input_vars') >= 1000): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>memory_limit</td>
                            <td>
                                <?php if(ini_get('memory_limit') == '-1'): ?>
                                Unlimited
                                <?php else: ?>
                                <?php echo e(ini_get('memory_limit')); ?>

                                <?php endif; ?>
                            </td>
                            <td>256M+</td>
                            <td>
                                <?php
                                    $memory_limit = ini_get('memory_limit');
                                    if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
                                        if ($matches[2] == 'G') {
                                            $memory_limit = $matches[1] * 1024 * 1024 * 1024; // nnnM -> nnn GB
                                        } else if ($matches[2] == 'M') {
                                            $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
                                        } else if ($matches[2] == 'K') {
                                            $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
                                        }
                                    }
                                ?>
                                <?php if(ini_get('memory_limit') == -1 || $memory_limit >= (256 * 1024 * 1024)): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>				
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="h6 mb-0"><?php echo e(translate('Extensions information')); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo e(translate('Extension Name')); ?></th>
                            <th><?php echo e(translate('Status')); ?></th>
                        </tr>
                    </thead>
                    <?php
                    $loaded_extensions = get_loaded_extensions();
                    $required_extensions = ['bcmath', 'ctype', 'json', 'mbstring', 'zip', 'zlib', 'openssl', 'tokenizer', 'xml', 'dom',  'curl', 'fileinfo', 'gd', 'pdo_mysql']
                    ?>
                    <tbody>
                        <?php $__currentLoopData = $required_extensions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extension): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($extension); ?></td>
                            <td>
                                <?php if(in_array($extension, $loaded_extensions)): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="h6 mb-0"><?php echo e(translate('Filesystem Permissions')); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo e(translate('File or Folder')); ?></th>
                            <th><?php echo e(translate('Status')); ?></th>
                        </tr>
                    </thead>
                    <?php
                    $required_paths = ['.env', 'public', 'app/Providers', 'app/Http/Controllers', 'storage', 'resources/views']
                    ?>
                    <tbody>
                        <?php $__currentLoopData = $required_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($path); ?></td>
                            <td>
                                <?php if(is_writable(base_path($path))): ?>
                                <i class="las la-check text-success"></i>
                                <?php else: ?>
                                <i class="las la-times text-danger"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/backend/system/server_status.blade.php ENDPATH**/ ?>