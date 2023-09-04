

<?php $__env->startSection('content'); ?>
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                <?php echo $__env->make('frontend.inc.user_side_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3"><?php echo e(translate('Affiliate')); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="row gutters-10">
                        <div class="col-md-4 mx-auto mb-3" >
                          <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                            <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                                <i class="las la-dollar-sign la-2x text-white"></i>
                            </span>
                            <div class="px-3 pt-3 pb-3">
                                <div class="h4 fw-700 text-center"><?php echo e(single_price(Auth::user()->affiliate_user->balance)); ?></div>
                                <div class="opacity-50 text-center"><?php echo e(translate('Affiliate Balance')); ?></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 mx-auto mb-3" >
                          <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition" onclick="show_affiliate_withdraw_modal()">
                              <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                  <i class="las la-plus la-3x text-white"></i>
                              </span>
                              <div class="fs-18 text-primary"><?php echo e(translate('Affiliate Withdraw Request')); ?></div>
                          </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6"><?php echo e(translate('Affiliate payment history')); ?></h5>
                        </div>
                          <div class="card-body">
                              <table class="table aiz-table mb-0">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th><?php echo e(translate('Date')); ?></th>
                                          <th><?php echo e(translate('Amount')); ?></th>
                                          <th><?php echo e(translate('Payment Method')); ?></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $__currentLoopData = $affiliate_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $affiliate_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <tr>
                                              <td><?php echo e($key+1); ?></td>
                                              <td><?php echo e(date('d-m-Y', strtotime($affiliate_payment->created_at))); ?></td>
                                              <td><?php echo e(single_price($affiliate_payment->amount)); ?></td>
                                              <td><?php echo e(ucfirst(str_replace('_', ' ', $affiliate_payment ->payment_method))); ?></td>
                                          </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                  </tbody>
                              </table>
                              <div class="aiz-pagination">
                                  <?php echo e($affiliate_payments->links()); ?>

                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

    <div class="modal fade" id="affiliate_withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('Affiliate Withdraw Request')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="" action="<?php echo e(route('affiliate.withdraw_request.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label><?php echo e(translate('Amount')); ?> <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control mb-3" name="amount" min="1" max="<?php echo e(Auth::user()->affiliate_user->balance); ?>" placeholder="<?php echo e(translate('Amount')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1"><?php echo e(translate('Confirm')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script>
        function copyToClipboard(btn){
            // var el_code = document.getElementById('referral_code');
            var el_url = document.getElementById('referral_code_url');
            // var c_b = document.getElementById('ref-cp-btn');
            var c_u_b = document.getElementById('ref-cpurl-btn');

            // if(btn == 'code'){
            //     if(el_code != null && c_b != null){
            //         el_code.select();
            //         document.execCommand('copy');
            //         c_b .innerHTML  = c_b.dataset.attrcpy;
            //     }
            // }

            if(btn == 'url'){
                if(el_url != null && c_u_b != null){
                    el_url.select();
                    document.execCommand('copy');
                    c_u_b .innerHTML  = c_u_b.dataset.attrcpy;
                }
            }
        }

        function show_affiliate_withdraw_modal(){
            $('#affiliate_withdraw_modal').modal('show');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\toko1\resources\views/affiliate/frontend/payment_history.blade.php ENDPATH**/ ?>