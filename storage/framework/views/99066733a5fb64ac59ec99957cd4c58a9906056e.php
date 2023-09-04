

<?php $__env->startSection('content'); ?>

<h4 class="text-center text-muted"><?php echo e(translate('System')); ?></h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
            	<h5 class="mb-0 h6 text-center"><?php echo e(translate('HTTPS Activation')); ?></h5>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'FORCE_HTTPS')" <?php if(env('FORCE_HTTPS') == 'On') echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Maintenance Mode Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'maintenance_mode')" <?php if(get_setting('maintenance_mode') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Disable image encoding?')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'disable_image_optimization')" <?php if(get_setting('disable_image_optimization') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>


<h4 class="text-center text-muted mt-4"><?php echo e(translate('Business Related')); ?></h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Vendor System Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'vendor_system_activation')" <?php if(get_setting('vendor_system_activation') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Classified Product')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'classified_product')" <?php if(get_setting('classified_product') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Wallet System Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'wallet_system')" <?php if(get_setting('wallet_system') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Coupon System Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'coupon_system')" <?php if(get_setting('coupon_system') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Pickup Point Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'pickup_point')" <?php if(get_setting('pickup_point') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Conversation Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'conversation_system')" <?php if(get_setting('conversation_system') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Seller Product Manage By Admin')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'product_manage_by_admin')"
                        <?php if(\App\Models\BusinessSetting::where('type', 'product_manage_by_admin')->first() &&
                                get_setting('product_manage_by_admin') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('After activate this option Cash On Delivery of Seller product will be managed by Admin')); ?>.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Admin Approval On Seller Product')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'product_approve_by_admin')"
                        <?php if(\App\Models\BusinessSetting::where('type', 'product_approve_by_admin')->first() &&
                                get_setting('product_approve_by_admin') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('After activate this option, Admin approval need to seller product')); ?>.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Email Verification')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'email_verification')" <?php if(get_setting('email_verification') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure SMTP correctly to enable this feature.')); ?> <a href="<?php echo e(route('smtp_settings.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Product Query Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'product_query_activation')" <?php if(get_setting('product_query_activation') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <?php if(addon_is_activated('wholesale')): ?>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center"><?php echo e(translate('Wholesale Product for Seller')); ?></h3>
                </div>
                <div class="card-body text-center">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'seller_wholesale_product')" <?php if(get_setting('seller_wholesale_product') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(addon_is_activated('auction')): ?>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center"><?php echo e(translate('Auction Product for Seller')); ?></h3>
                </div>
                <div class="card-body text-center">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'seller_auction_product')" <?php if(get_setting('seller_auction_product') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<h4 class="text-center text-muted mt-4"><?php echo e(translate('Payment Related')); ?></h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header text-center bord-btm">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Paypal Payment Activation')); ?></h3>
            </div>
            <div class="card-body">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/paypal.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'paypal_payment')" <?php if(get_setting('paypal_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert text-center" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Paypal correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Stripe Payment Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img   class="float-left" src="<?php echo e(static_asset('assets/img/cards/stripe.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'stripe_payment')" <?php if(get_setting('stripe_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Stripe correctly to enable this feature.')); ?> <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Mercadopago Payment Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img   class="float-left" src="<?php echo e(static_asset('assets/img/cards/mercadopago.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'mercadopago_payment')" <?php if(get_setting('mercadopago_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Mercadopago correctly to enable this feature.')); ?> <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>   
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('SSlCommerz Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/sslcommerz.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'sslcommerz_payment')" <?php if(get_setting('sslcommerz_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure SSlCommerz correctly to enable this feature.')); ?> <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Instamojo Payment Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/instamojo.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'instamojo_payment')" <?php if(get_setting('instamojo_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Instamojo Payment correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Razor Pay Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/rozarpay.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'razorpay')" <?php if(get_setting('razorpay') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Razor correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('PayStack Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/paystack.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'paystack')" <?php if(get_setting('paystack') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure PayStack correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('VoguePay Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/vogue.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'voguepay')" <?php if(get_setting('voguepay') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure VoguePay correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Payhere Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/payhere.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'payhere')" <?php if(get_setting('payhere') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Payhere correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Ngenius Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/ngenius.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'ngenius')" <?php if(get_setting('ngenius') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Ngenius correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Iyzico Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/iyzico.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'iyzico')" <?php if(get_setting('iyzico') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure iyzico correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Bkash Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/bkash.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'bkash')" <?php if(get_setting('bkash') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure bkash correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Nagad Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/nagad.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'nagad')" <?php if(get_setting('nagad') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure nagad correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Proxy Pay Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/proxypay.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'proxypay')" <?php if(get_setting('proxypay') == '1') echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure proxypay correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Amarpay Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/aamarpay.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'aamarpay')" <?php if(get_setting('aamarpay') == '1'): ?> checked <?php endif; ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure amarpay correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Authorize Net Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/authorizenet.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'authorizenet')" <?php if(get_setting('authorizenet') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure authorize net correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Payku Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/payku.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'payku')" <?php if(get_setting('payku') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure payku net correctly to enable this feature')); ?>. <a href="<?php echo e(route('payment_method.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Cash Payment Activation')); ?></h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="<?php echo e(static_asset('assets/img/cards/cod.png')); ?>" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'cash_payment')" <?php if(get_setting('cash_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
</div>

<h4 class="text-center text-muted mt-4"><?php echo e(translate('Social Media Login')); ?></h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Facebook login')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'facebook_login')" <?php if(get_setting('facebook_login') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Facebook Client correctly to enable this feature')); ?>. <a href="<?php echo e(route('social_login.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Google login')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'google_login')" <?php if(get_setting('google_login') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Google Client correctly to enable this feature')); ?>. <a href="<?php echo e(route('social_login.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Twitter login')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'twitter_login')" <?php if(get_setting('twitter_login') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Twitter Client correctly to enable this feature')); ?>. <a href="<?php echo e(route('social_login.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center"><?php echo e(translate('Apple login')); ?></h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'apple_login')" <?php if(get_setting('apple_login') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <?php echo e(translate('You need to configure Apple Client correctly to enable this feature')); ?>. <a href="<?php echo e(route('social_login.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
                </div>
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
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\toko1\resources\views/backend/setup_configurations/activation.blade.php ENDPATH**/ ?>