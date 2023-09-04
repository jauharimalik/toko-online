

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
                            <a href="<?php echo e(route('affiliate.payment_settings')); ?>">
                                <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                    <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                        <i class="las la-dharmachakra la-3x text-white"></i>
                                    </span>
                                    <div class="fs-18 text-primary"><?php echo e(translate('Configure Payout')); ?></div>
                                </div>
                            </a>
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

                    <?php if(addon_is_activated('affiliate_system')
                        && \App\Models\AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status): ?>
                        <div class="row">
                            <?php
                                if(Auth::user()->referral_code == null){
                                    Auth::user()->referral_code = substr(Auth::user()->id.Str::random(), 0, 10);
                                    Auth::user()->save();
                                }
                                $referral_code = Auth::user()->referral_code;
                                $referral_code_url = URL::to('/users/registration')."?referral_code=$referral_code";
                            ?>
                            <div class="col">
                                <div class="card">
                                    <div class="form-box-content p-3">
                                        <div class="form-group">
                                            <textarea id="referral_code_url" class="form-control" readonly type="text" ><?php echo e($referral_code_url); ?></textarea>
                                        </div>
                                        <button type=button id="ref-cpurl-btn" class="btn btn-primary float-right" data-attrcpy="<?php echo e(translate('Copied')); ?>" onclick="copyToClipboard('url')" ><?php echo e(translate('Copy Url')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <br>
                    
                    <div class="card">
                        <form class="" id="sort_blogs" action="" method="GET">
                            <div class="card-header row">
                                <div class="col text-center text-md-left">
                                    <h5 class="mb-md-0 h6"><?php echo e(translate('Affiliate Stats')); ?></h5>
                                </div>
                                <div class="col-md-5 col-xl-4">
                                    <div class="input-group mb-0">
                                        <select class="form-control aiz-selectpicker" name="type" data-live-search="true">
                                            <option value="">Choose</option>
                                            <option value="Today" <?php if($type == 'Today'): ?> selected <?php endif; ?>>Today</option>
                                            <option value="7" <?php if($type == '7'): ?> selected <?php endif; ?>>Last 7 Days</option>
                                            <option value="30" <?php if($type == '30'): ?> selected <?php endif; ?>>Last 30 Days</option>
                                        </select>
                                        <button class="btn btn-primary input-group-append" type="submit"><?php echo e(translate('Filter')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div class="card-body">
                            <div class="row gutters-10">
                                <div class="col-md-3 mx-auto mb-3">
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    <?php if($affliate_stats->count_click): ?>
                                                        <?php echo e($affliate_stats->count_click); ?>

                                                    <?php else: ?> 
                                                        0
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary"><?php echo e(translate('No of click')); ?></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mx-auto mb-3" >
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    <?php if($affliate_stats->count_item): ?>
                                                        <?php echo e($affliate_stats->count_item); ?>

                                                    <?php else: ?> 
                                                        0
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary"><?php echo e(translate('No of item')); ?></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mx-auto mb-3" >
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    <?php if($affliate_stats->count_delivered): ?>
                                                        <?php echo e($affliate_stats->count_delivered); ?>

                                                    <?php else: ?> 
                                                        0
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary"><?php echo e(translate('No of deliverd')); ?></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mx-auto mb-3" >
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    <?php if($affliate_stats->count_cancel): ?>
                                                        <?php echo e($affliate_stats->count_cancel); ?>

                                                    <?php else: ?> 
                                                        0
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary"><?php echo e(translate('No of cancel')); ?></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6"><?php echo e(translate('Affiliate Earning History')); ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(translate('Referral User')); ?></th>
                                    <th><?php echo e(translate('Amount')); ?></th>
                                    <th data-breakpoints="lg"><?php echo e(translate('Order Id')); ?></th>
                                    <th data-breakpoints="lg"><?php echo e(translate('Referral Type')); ?></th>
                                    <th data-breakpoints="lg"><?php echo e(translate('Product')); ?></th>
                                    <th data-breakpoints="lg"><?php echo e(translate('Date')); ?></th>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $affiliate_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $affiliate_log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(($key+1) + ($affiliate_logs->currentPage() - 1)*$affiliate_logs->perPage()); ?></td>
                                        <td>
                                            <?php if($affiliate_log->user_id !== null): ?>
                                                <?php echo e($affiliate_log->user->name); ?>

                                            <?php else: ?>
                                                <?php echo e(translate('Guest').' ('. $affiliate_log->guest_id.')'); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(single_price($affiliate_log->amount)); ?></td>
                                        <td>
                                            <?php if($affiliate_log->order_id != null): ?>
                                                <?php echo e($affiliate_log->order->code); ?>

                                            <?php else: ?>
                                                <?php echo e($affiliate_log->order_detail->order->code); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td> <?php echo e(ucwords(str_replace('_',' ', $affiliate_log->affiliate_type))); ?></td>
                                        <td>
                                            <?php if($affiliate_log->order_detail_id != null): ?>
                                                <?php echo e($affiliate_log->order_detail->product->name); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($affiliate_log->created_at->format('d, F Y')); ?> </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                <?php echo e($affiliate_logs->links()); ?>

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

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\toko1\resources\views/affiliate/frontend/index.blade.php ENDPATH**/ ?>