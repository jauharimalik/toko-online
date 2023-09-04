

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6"><?php echo e(translate('Affiliate Users')); ?></h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo e(translate('Name')); ?></th>
                <th data-breakpoints="lg"><?php echo e(translate('Phone')); ?></th>
                <th data-breakpoints="lg"><?php echo e(translate('Email Address')); ?></th>
                <th data-breakpoints="lg"><?php echo e(translate('Verification Info')); ?></th>
                <th><?php echo e(translate('Approval')); ?></th>
                <th data-breakpoints="lg"><?php echo e(translate('Due Amount')); ?></th>
                <th width="10%" class="text-right"><?php echo e(translate('Options')); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $affiliate_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $affiliate_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($affiliate_user->user != null): ?>
                    <tr>
                        <td><?php echo e(($key+1) + ($affiliate_users->currentPage() - 1)*$affiliate_users->perPage()); ?></td>
                        <td><?php echo e($affiliate_user->user->name); ?></td>
                        <td><?php echo e($affiliate_user->user->phone); ?></td>
                        <td><?php echo e($affiliate_user->user->email); ?></td>
                        <td>
                            <?php if($affiliate_user->informations != null): ?>
                                <a href="<?php echo e(route('affiliate_users.show_verification_request', $affiliate_user->id)); ?>">
                                    <span class="badge badge-inline badge-info"><?php echo e(translate('Show')); ?></span>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_approved(this)" value="<?php echo e($affiliate_user->id); ?>" type="checkbox" <?php if($affiliate_user->status == 1) echo "checked";?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <?php if($affiliate_user->balance >= 0): ?>
                                <?php echo e(single_price($affiliate_user->balance)); ?>

                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pay_to_affiliate_user')): ?>
                                <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm" onclick="show_payment_modal('<?php echo e($affiliate_user->id); ?>');" title="<?php echo e(translate('Pay Now')); ?>">
                                    <i class="las la-money-bill"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('affiliate_users_payment_history')): ?>
                                <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="<?php echo e(route('affiliate_user.payment_history', encrypt($affiliate_user->id))); ?>" title="<?php echo e(translate('Payment History')); ?>">
                                    <i class="las la-history"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="aiz-pagination">
          <?php echo e($affiliate_users->appends(request()->input())->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="modal fade" id="payment_modal">
		    <div class="modal-dialog">
		        <div class="modal-content" id="modal-content">

		        </div>
		    </div>
		</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function show_payment_modal(id){
            $.post('<?php echo e(route('affiliate_user.payment_modal')); ?>',{_token:'<?php echo e(@csrf_token()); ?>', id:id}, function(data){
                $('#payment_modal #modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }

        function update_approved(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('affiliate_user.approved')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '<?php echo e(translate('Approved sellers updated successfully')); ?>');
                }
                else{
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/affiliate/users.blade.php ENDPATH**/ ?>