<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="d-block text-left">
                <?php if(get_setting('system_logo_white') != null): ?>
                    <img class="mw-100" src="<?php echo e(uploaded_asset(get_setting('system_logo_white'))); ?>" class="brand-icon" alt="<?php echo e(get_setting('site_name')); ?>">
                <?php else: ?>
                    <img class="mw-100" src="<?php echo e(static_asset('assets/img/logo.png')); ?>" class="brand-icon" alt="<?php echo e(get_setting('site_name')); ?>">
                <?php endif; ?>
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" name="" placeholder="<?php echo e(translate('Search in menu')); ?>" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_dashboard')): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="aiz-side-nav-link">
                            <i class="las la-home aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Dashboard')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- POS Addon-->
                <?php if(addon_is_activated('pos_system') && (auth()->user()->can('pos_manager') || auth()->user()->can('pos_configuration'))): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-tasks aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('POS System')); ?></span>
                            <?php if(env("DEMO_MODE") == "On"): ?>
                                <span class="badge badge-inline badge-danger">Addon</span>
                            <?php endif; ?>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pos_manager')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('poin-of-sales.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['poin-of-sales.index', 'poin-of-sales.create'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('POS Manager')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pos_configuration')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('poin-of-sales.activation')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('POS Configuration')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Product -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_new_product', 'show_all_products','show_in_house_products','show_seller_products','show_digital_products','product_bulk_import','product_bulk_export','view_product_categories', 'view_all_brands','view_product_attributes','view_colors','view_product_reviews'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Products')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_new_product')): ?>
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="<?php echo e(route('products.create')); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Add New product')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_all_products')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('products.all')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('All Products')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_in_house_products')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('products.admin')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['products.admin', 'products.create', 'products.admin.edit'])); ?>" >
                                        <span class="aiz-side-nav-text"><?php echo e(translate('In House Products')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(get_setting('vendor_system_activation') == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_seller_products')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('products.seller')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['products.seller', 'products.seller.edit'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Seller Products')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_digital_products')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('digitalproducts.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['digitalproducts.index', 'digitalproducts.create', 'digitalproducts.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Digital Products')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product_bulk_import')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('product_bulk_upload.index')); ?>" class="aiz-side-nav-link" >
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Bulk Import')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product_bulk_export')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('product_bulk_export.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Bulk Export')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_product_categories')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('categories.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Category')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_brands')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('brands.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])); ?>" >
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Brand')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_product_attributes')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('attributes.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['attributes.index','attributes.create','attributes.edit','attributes.show','edit-attribute-value'.''])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Attribute')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_colors')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('colors')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['colors','colors.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Colors')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_product_reviews')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('reviews.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Product Reviews')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Auction Product -->
                <?php if(addon_is_activated('auction')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_auction_product','view_all_auction_products','view_inhouse_auction_products','view_seller_auction_products','view_auction_product_orders'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-gavel aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Auction Products')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <!--Submenu-->
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_auction_product')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a class="aiz-side-nav-link" href="<?php echo e(route('auction_products.admin.create')); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Add New auction product')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_auction_products')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('auction.all_products')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['auction_product_edit.admin','product_bids.admin'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('All Auction Products')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_auction_product_orders')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('auction_products_orders')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['auction_products_orders.index'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Auction Products Orders')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Wholesale Product -->
                <?php if(addon_is_activated('wholesale')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_wholesale_product','view_all_wholesale_products','view_inhouse_wholesale_products','view_sellers_wholesale_products'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-luggage-cart aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Wholesale Products')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_wholesale_product')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a class="aiz-side-nav-link" href="<?php echo e(route('wholesale_product_create.admin')); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Add New Wholesale Product')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_wholesale_products')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('wholesale_products.all')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['wholesale_product_edit.admin'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('All Wholesale Products')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_inhouse_wholesale_products')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('wholesale_products.in_house')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['wholesale_product_edit.admin'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('In House Wholesale Products')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_sellers_wholesale_products')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('wholesale_products.seller')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['wholesale_product_edit.admin'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Seller Wholesale Products')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Sale -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_orders', 'view_inhouse_orders','view_seller_orders','view_pickup_point_orders'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-money-bill aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Sales')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_orders')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('all_orders.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['all_orders.index', 'all_orders.show'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('All Orders')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_inhouse_orders')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('inhouse_orders.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['inhouse_orders.index', 'inhouse_orders.show'])); ?>" >
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Inhouse orders')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_seller_orders')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('seller_orders.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['seller_orders.index', 'seller_orders.show'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Seller Orders')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_pickup_point_orders')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('pick_up_point.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['pick_up_point.index','pick_up_point.order_show'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Pick-up Point Order')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Deliver Boy Addon-->
                <?php if(addon_is_activated('delivery_boy')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_delivery_boy','add_delivery_boy','delivery_boy_payment_history','collected_histories_from_delivery_boy','order_cancle_request_by_delivery_boy','delivery_boy_configuration'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-truck aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Delivery Boy')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_delivery_boy')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('delivery-boys.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('All Delivery Boy')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_delivery_boy')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('delivery-boys.create')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Add Delivery Boy')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delivery_boy_payment_history')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('delivery-boys-payment-histories')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Payment Histories')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('collected_histories_from_delivery_boy')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('delivery-boys-collection-histories')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Collected Histories')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order_cancle_request_by_delivery_boy')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('delivery-boy.cancel-request')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Cancel Request')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delivery_boy_configuration')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('delivery-boy-configuration')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Configuration')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Refund addon -->
                <?php if(addon_is_activated('refund_request')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_refund_requests','view_approved_refund_requests','view_rejected_refund_requests','refund_request_configuration'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-backward aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Refunds')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_refund_requests')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('refund_requests_all')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['refund_requests_all', 'reason_show'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Refund Requests')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_approved_refund_requests')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('paid_refund')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Approved Refunds')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_rejected_refund_requests')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('rejected_refund')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Rejected Refunds')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('refund_request_configuration')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('refund_time_config')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Refund Configuration')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>  
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Customers -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_customers','view_classified_products','view_classified_packages'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Customers')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_customers')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('customers.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Customer list')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(get_setting('classified_product') == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_classified_products')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('classified_products')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Classified Products')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_classified_packages')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('customer_packages.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['customer_packages.index', 'customer_packages.create', 'customer_packages.edit'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Classified Packages')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Sellers -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_seller','seller_payment_history','view_seller_payout_requests','seller_commission_configuration','view_all_seller_packages','seller_verification_form_configuration'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Sellers')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_seller')): ?>
                                <li class="aiz-side-nav-item">
                                    <?php
                                        $sellers = \App\Models\Shop::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                                    ?>
                                    <a href="<?php echo e(route('sellers.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history','sellers.approved','sellers.profile_modal','sellers.show_verification_request'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('All Seller')); ?></span>
                                        <?php if($sellers > 0): ?><span class="badge badge-info"><?php echo e($sellers); ?></span> <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seller_payment_history')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('sellers.payment_histories')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Payouts')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_seller_payout_requests')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('withdraw_requests_all')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Payout Requests')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seller_commission_configuration')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('business_settings.vendor_commission')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Seller Commission')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(addon_is_activated('seller_subscription')): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_seller_packages')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('seller_packages.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['seller_packages.index', 'seller_packages.create', 'seller_packages.edit'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Seller Packages')); ?></span>
                                            <?php if(env("DEMO_MODE") == "On"): ?>
                                                <span class="badge badge-inline badge-danger">Addon</span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seller_verification_form_configuration')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('seller_verification_form.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Seller Verification Form')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                
                <li class="aiz-side-nav-item">
                    <a href="<?php echo e(route('uploaded-files.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['uploaded-files.create'])); ?>">
                        <i class="las la-folder-open aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text"><?php echo e(translate('Uploaded Files')); ?></span>
                    </a>
                </li>

                <!-- Reports -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['in_house_product_sale_report','seller_products_sale_report','products_stock_report','product_wishlist_report','user_search_report','commission_history_report','wallet_transaction_report'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Reports')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('in_house_product_sale_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('in_house_sale_report.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['in_house_sale_report.index'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('In House Product Sale')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seller_products_sale_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('seller_sale_report.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['seller_sale_report.index'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Seller Products Sale')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_stock_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('stock_report.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['stock_report.index'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Products Stock')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product_wishlist_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('wish_report.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['wish_report.index'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Products wishlist')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_search_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('user_search_report.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['user_search_report.index'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('User Searches')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('commission_history_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('commission-log.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Commission History')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('wallet_transaction_report')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('wallet-history.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Wallet Recharge History')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                
                <!--Blog System-->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_blogs','view_blog_categories'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Blog System')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_blogs')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('blog.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['blog.create', 'blog.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('All Posts')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_blog_categories')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('blog-category.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['blog-category.create', 'blog-category.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Categories')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- marketing -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_flash_deals','send_newsletter','send_bulk_sms','view_all_subscribers','view_all_coupons'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Marketing')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_flash_deals')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('flash_deals.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Flash deals')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_newsletter')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('newsletters.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Newsletters')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(addon_is_activated('otp_system') && auth()->user()->can('send_bulk_sms')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('sms.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Bulk SMS')); ?></span>
                                        <?php if(env("DEMO_MODE") == "On"): ?>
                                            <span class="badge badge-inline badge-danger">Addon</span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_subscribers')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('subscribers.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Subscribers')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(get_setting('coupon_system') == 1 && auth()->user()->can('view_all_coupons') ): ?>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('coupon.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['coupon.index','coupon.create','coupon.edit'])); ?>">
                                    <span class="aiz-side-nav-text"><?php echo e(translate('Coupon')); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Support -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_support_tickets','view_all_product_conversations','view_all_product_queries'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-link aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Support')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_support_tickets')): ?>
                                <?php
                                    $support_ticket = DB::table('tickets')
                                                ->where('viewed', 0)
                                                ->select('id')
                                                ->count();
                                ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('support_ticket.admin_index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['support_ticket.admin_index', 'support_ticket.admin_show'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Ticket')); ?></span>
                                        <?php if($support_ticket > 0): ?><span class="badge badge-info"><?php echo e($support_ticket); ?></span><?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_product_conversations')): ?>
                                <?php
                                    $conversation = \App\Models\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();
                                ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('conversations.admin_index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['conversations.admin_index', 'conversations.admin_show'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Product Conversations')); ?></span>
                                        <?php if(count($conversation) > 0): ?>
                                            <span class="badge badge-info"><?php echo e(count($conversation)); ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(get_setting('product_query_activation') == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_product_queries')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('product_query.index')); ?>"
                                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['product_query.index','product_query.show'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Product Queries')); ?></span>                           
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Affiliate Addon -->
                <?php if(addon_is_activated('affiliate_system')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['affiliate_registration_form_config','affiliate_configurations','view_affiliate_users','view_all_referral_users','view_affiliate_withdraw_requests','view_affiliate_logs'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-link aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Affiliate System')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('affiliate_registration_form_config')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('affiliate.configs')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Affiliate Registration Form')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('affiliate_configurations')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('affiliate.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Affiliate Configurations')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_affiliate_users')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('affiliate.users')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['affiliate.users', 'affiliate_users.show_verification_request', 'affiliate_user.payment_history'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Affiliate Users')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_referral_users')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('refferals.users')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Referral Users')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_affiliate_withdraw_requests')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('affiliate.withdraw_requests')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Affiliate Withdraw Requests')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_affiliate_logs')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('affiliate.logs.admin')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Affiliate Logs')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Offline Payment Addon-->
                <?php if(addon_is_activated('offline_payment')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_manual_payment_methods','view_all_offline_wallet_recharges','view_all_offline_customer_package_payments','view_all_offline_seller_package_payments'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-money-check-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Offline Payment System')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_manual_payment_methods')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('manual_payment_methods.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['manual_payment_methods.index', 'manual_payment_methods.create', 'manual_payment_methods.edit'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Manual Payment Methods')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_offline_wallet_recharges')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('offline_wallet_recharge_request.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Offline Wallet Recharge')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if(get_setting('classified_product') == 1 && auth()->user()->can('view_all_offline_customer_package_payments')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('offline_customer_package_payment_request.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Offline Customer Package Payments')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(addon_is_activated('seller_subscription') && auth()->user()->can('view_all_offline_seller_package_payments')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('offline_seller_package_payment_request.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Offline Seller Package Payments')); ?></span>
                                            <?php if(env("DEMO_MODE") == "On"): ?>
                                                <span class="badge badge-inline badge-danger">Addon</span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Paytm Addon -->
                <?php if(addon_is_activated('paytm') && auth()->user()->can('asian_payment_gateway_configuration')): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-mobile-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Asian Payment Gateway')); ?></span>
                            <?php if(env("DEMO_MODE") == "On"): ?>
                                <span class="badge badge-inline badge-danger">Addon</span>
                            <?php endif; ?>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('paytm.index')); ?>" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text"><?php echo e(translate('Set Asian PG Credentials')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Club Point Addon-->
                <?php if(addon_is_activated('club_point')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['club_point_configurations','set_club_points','view_users_club_points'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="lab la-btc aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('Club Point System')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('club_point_configurations')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('club_points.configs')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Club Point Configurations')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('set_club_points')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('set_product_points')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['set_product_points', 'product_club_point.edit'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Set Product Point')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_users_club_points')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('club_points.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['club_points.index', 'club_point.details'])); ?>">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('User Points')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!--OTP addon -->
                <?php if(addon_is_activated('otp_system')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['otp_configurations','sms_templates','sms_providers_configurations','send_bulk_sms'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('OTP System')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('otp_configurations')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('otp.configconfiguration')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('OTP Configurations')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sms_templates')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('sms-templates.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('SMS Templates')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sms_providers_configurations')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('otp_credentials.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Set OTP Credentials')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(addon_is_activated('african_pg')): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['african_pg_configuration','african_pg_credentials_configuration'])): ?>
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text"><?php echo e(translate('African Payment Gateway Addon')); ?></span>
                                <?php if(env("DEMO_MODE") == "On"): ?>
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                <?php endif; ?>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('african_pg_configuration')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('african.configuration')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('African PG Configurations')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('african_pg_credentials_configuration')): ?>
                                    <li class="aiz-side-nav-item">
                                        <a href="<?php echo e(route('african_credentials.index')); ?>" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text"><?php echo e(translate('Set African PG Credentials')); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Website Setup -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['header_setup','footer_setup','view_all_website_pages','website_appearance'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.footer', 'website.header'])); ?>" >
                            <i class="las la-desktop aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Website Setup')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('header_setup')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('website.header')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Header')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('footer_setup')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('website.footer', ['lang'=>  App::getLocale()] )); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.footer'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Footer')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_website_pages')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('website.pages')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Pages')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('website_appearance')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('website.appearance')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Appearance')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Setup & Configurations -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['general_settings','features_activation','language_setup','currency_setup','vat_&_tax_setup',
                        'pickup_point_setup','smtp_settings','payment_methods_configurations','order_configuration','file_system_&_cache_configuration',
                        'social_media_logins','facebook_chat','facebook_comment','analytics_tools_configuration','google_recaptcha_configuration','google_map_setting',
                        'google_firebase_setting','shipping_configuration','shipping_country_setting','manage_shipping_states','manage_shipping_cities','manage_zones','manage_carriers'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Setup & Configurations')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('general_settings')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('general_setting.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('General Settings')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('features_activation')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('activation.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Features activation')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('language_setup')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('languages.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Languages')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('currency_setup')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('currency.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Currency')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vat_&_tax_setup')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('tax.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['tax.index', 'tax.create', 'tax.store', 'tax.show', 'tax.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Vat & TAX')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pickup_point_setup')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('pick_up_points.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['pick_up_points.index','pick_up_points.create','pick_up_points.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Pickup point')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('smtp_settings')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('smtp_settings.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('SMTP Settings')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment_methods_configurations')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('payment_method.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Payment Methods')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order_configuration')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('order_configuration.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Order Configuration')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('file_system_&_cache_configuration')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('file_system.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('File System & Cache Configuration')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('social_media_logins')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('social_login.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Social media Logins')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['facebook_chat','facebook_comment'])): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Facebook')); ?></span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('facebook_chat')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('facebook_chat.index')); ?>" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Facebook Chat')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('facebook_comment')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('facebook-comment')); ?>" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Facebook Comment')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['analytics_tools_configuration','google_recaptcha_configuration','google_map_setting','google_firebase_setting'])): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Google')); ?></span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analytics_tools_configuration')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('google_analytics.index')); ?>" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Analytics Tools')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('google_recaptcha_configuration')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('google_recaptcha.index')); ?>" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Google reCAPTCHA')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('google_map_setting')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('google-map.index')); ?>" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Google Map')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('google_firebase_setting')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('google-firebase.index')); ?>" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Google Firebase')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['shipping_configuration','shipping_country_setting','manage_shipping_states','manage_shipping_cities','manage_zones','manage_carriers'])): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Shipping')); ?></span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('shipping_configuration')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('shipping_configuration.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update'])); ?>">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Shipping Configuration')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('shipping_country_setting')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('countries.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['countries.index','countries.edit','countries.update'])); ?>">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Shipping Countries')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_shipping_states')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('states.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['states.index','states.edit','states.update'])); ?>">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Shipping States')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_shipping_cities')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('cities.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['cities.index','cities.edit','cities.update'])); ?>">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Shipping Cities')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_zones')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('zones.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['zones.index','zones.create','zones.edit'])); ?>">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Shipping Zones')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_carriers')): ?>
                                            <li class="aiz-side-nav-item">
                                                <a href="<?php echo e(route('carriers.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['carriers.index','carriers.create','carriers.edit'])); ?>">
                                                    <span class="aiz-side-nav-text"><?php echo e(translate('Shipping Carrier')); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Staffs -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_all_staffs','view_staff_roles'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Staffs')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_staffs')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('staffs.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('All staffs')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_staff_roles')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('roles.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])); ?>">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Staff permissions')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['system_update','server_status'])): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('System')); ?></span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system_update')): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('system_update')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text"><?php echo e(translate('Update')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('server_status')): ?>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('system_server')); ?>" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text"><?php echo e(translate('Server status')); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Addon Manager -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_addons')): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('addons.index')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['addons.index', 'addons.create'])); ?>">
                            <i class="las la-wrench aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text"><?php echo e(translate('Addon Manager')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
<?php /**PATH C:\laragon\www\toko1\resources\views/backend/inc/admin_sidenav.blade.php ENDPATH**/ ?>