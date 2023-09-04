

<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3"><?php echo e(translate('All Brands')); ?></h1>
	</div>
</div>

<div class="row">
	<div class="<?php if(auth()->user()->can('add_brand')): ?> col-lg-7 <?php else: ?> col-lg-12 <?php endif; ?>">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6"><?php echo e(translate('Brands')); ?></h5>
				</div>
				<div class="col-md-4">
					<form class="" id="sort_brands" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"<?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Type name & Enter')); ?>">
						</div>
					</form>
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table aiz-table mb-0">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th><?php echo e(translate('Name')); ?></th>
		                    <th><?php echo e(translate('Logo')); ?></th>
		                    <th class="text-right"><?php echo e(translate('Options')); ?></th>
		                </tr>
		            </thead>
		            <tbody>
		                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                    <tr>
		                        <td><?php echo e(($key+1) + ($brands->currentPage() - 1)*$brands->perPage()); ?></td>
		                        <td><?php echo e($brand->getTranslation('name')); ?></td>
								<td>
		                            <img src="<?php echo e(uploaded_asset($brand->logo)); ?>" alt="<?php echo e(translate('Brand')); ?>" class="h-50px">
		                        </td>
		                        <td class="text-right">
									<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_brand')): ?>
										<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="<?php echo e(route('brands.edit', ['id'=>$brand->id, 'lang'=>env('DEFAULT_LANGUAGE')] )); ?>" title="<?php echo e(translate('Edit')); ?>">
											<i class="las la-edit"></i>
										</a>
									<?php endif; ?>
									<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_brand')): ?>
										<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="<?php echo e(route('brands.destroy', $brand->id)); ?>" title="<?php echo e(translate('Delete')); ?>">
											<i class="las la-trash"></i>
										</a>
									<?php endif; ?>
		                        </td>
		                    </tr>
		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		            </tbody>
		        </table>
		        <div class="aiz-pagination">
                	<?php echo e($brands->appends(request()->input())->links()); ?>

            	</div>
		    </div>
		</div>
	</div>
	<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_brand')): ?>
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0 h6"><?php echo e(translate('Add New Brand')); ?></h5>
				</div>
				<div class="card-body">
					<form action="<?php echo e(route('brands.store')); ?>" method="POST">
						<?php echo csrf_field(); ?>
						<div class="form-group mb-3">
							<label for="name"><?php echo e(translate('Name')); ?></label>
							<input type="text" placeholder="<?php echo e(translate('Name')); ?>" name="name" class="form-control" required>
						</div>
						<div class="form-group mb-3">
							<label for="name"><?php echo e(translate('Logo')); ?> <small>(<?php echo e(translate('120x80')); ?>)</small></label>
							<div class="input-group" data-toggle="aizuploader" data-type="image">
								<div class="input-group-prepend">
										<div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
								</div>
								<div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
								<input type="hidden" name="logo" class="selected-files">
							</div>
							<div class="file-preview box sm">
							</div>
						</div>
						<div class="form-group mb-3">
							<label for="name"><?php echo e(translate('Meta Title')); ?></label>
							<input type="text" class="form-control" name="meta_title" placeholder="<?php echo e(translate('Meta Title')); ?>">
						</div>
						<div class="form-group mb-3">
							<label for="name"><?php echo e(translate('Meta Description')); ?></label>
							<textarea name="meta_description" rows="5" class="form-control"></textarea>
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

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    function sort_brands(el){
        $('#sort_brands').submit();
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1487960/public_html/elesindoshop.com/resources/views/backend/product/brands/index.blade.php ENDPATH**/ ?>