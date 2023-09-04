

<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3"><?php echo e(translate('All Attributes')); ?></h1>
	</div>
</div>

<div class="row">
	<div class="<?php if(auth()->user()->can('add_product_attribute')): ?> col-lg-7 <?php else: ?> col-lg-12 <?php endif; ?>">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6"><?php echo e(translate('Attributes')); ?></h5>
			</div>
			<div class="card-body">
				<table class="table aiz-table mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo e(translate('Name')); ?></th>
							<th><?php echo e(translate('Values')); ?></th>
							<th class="text-right"><?php echo e(translate('Options')); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($key+1); ?></td>
								<td><?php echo e($attribute->getTranslation('name')); ?></td>
								<td>
									<?php $__currentLoopData = $attribute->attribute_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<span class="badge badge-inline badge-md bg-soft-dark"><?php echo e($value->value); ?></span>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="text-right">
									<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_product_attribute_values')): ?>
										<a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="<?php echo e(route('attributes.show', $attribute->id)); ?>" title="<?php echo e(translate('Attribute values')); ?>">
											<i class="las la-cog"></i>
										</a>
									<?php endif; ?>
									<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_product_attribute')): ?>
										<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="<?php echo e(route('attributes.edit', ['id'=>$attribute->id, 'lang'=>env('DEFAULT_LANGUAGE')] )); ?>" title="<?php echo e(translate('Edit')); ?>">
											<i class="las la-edit"></i>
										</a>
									<?php endif; ?>
									<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_product_attribute')): ?>
										<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="<?php echo e(route('attributes.destroy', $attribute->id)); ?>" title="<?php echo e(translate('Delete')); ?>">
											<i class="las la-trash"></i>
										</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_product_attribute')): ?>
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">
						<h5 class="mb-0 h6"><?php echo e(translate('Add New Attribute')); ?></h5>
				</div>
				<div class="card-body">
					<form action="<?php echo e(route('attributes.store')); ?>" method="POST">
						<?php echo csrf_field(); ?>
						<div class="form-group mb-3">
							<label for="name"><?php echo e(translate('Name')); ?></label>
							<input type="text" placeholder="<?php echo e(translate('Name')); ?>" id="name" name="name" class="form-control" required>
						</div>
						<div class="form-group mb-3 text-right">
							<button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/backend/product/attribute/index.blade.php ENDPATH**/ ?>