<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\Brand\BrandController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\Collection\CollectionController;
use App\Http\Controllers\Color\ColorController;
use App\Http\Controllers\ContactInformation\ContactInformationController;
use App\Http\Controllers\Material\MaterialController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Size\SizeController;
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\Status\StatusController;
use App\Http\Controllers\SubCategory\SubCategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AssignRoleUser\AssignRoleUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Favourite\FavouriteController;
use App\Http\Controllers\OfferDetail\OfferDetailController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\SheetTemplate\SheetTemplateController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::prefix('auth')->group(function () {
    // Registration
    // Route::post('register', [RegisterController::class, 'index'])->name('auth.register');
    // Login
    Route::post('login', [LoginController::class, 'index'])->name('auth.login');
    // forget password
    Route::post('forget-password', [ResetPasswordController::class, 'forgetPassword'])->name('auth.forget-password');
    //reset password
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('auth.reset-password');
    // Logout
    Route::middleware('auth:api')->post('logout', [LoginController::class, 'logout'])->name('auth.logout');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    // Route::prefix('admin')->middleware('auth:api', 'dynamicAuthorization')->group(function () {
    // //role routes
    Route::prefix('role')->namespace('Role')->group(function () {
        // Get all roles    
        Route::get('all', [RoleController::class, 'all'])->name('role.all');
        // Get a specific role by ID
        Route::get('get/{role}', [RoleController::class, 'get'])->name('role.get');
        // Create a new role
        Route::post('create', [RoleController::class, 'create'])->name('role.create');
        // Update an existing role
        Route::post('update/{role}', [RoleController::class, 'update'])->name('role.update');
        // Delete a role
        Route::delete('delete/{role}', [RoleController::class, 'delete'])->name('role.delete');
        // Get soft deleted roles
        Route::get('get-delete-soft', [RoleController::class, 'getSoftDeleted'])->name('role.get-delete-soft');
        // Restore a soft deleted role
        Route::post('restore/{role}', [RoleController::class, 'restore'])->name('role.restore');
        // Change role permission
        Route::post('change-permission/{role}', [RoleController::class, 'changePermission'])->name('role.change-permission');
    });

    // Product Routes
    Route::prefix('product')->namespace('Product')->group(function () {
        // Get all products
        Route::get('all', [ProductController::class, 'all'])->name('product.all');
        // Get a specific product by ID
        Route::get('get/{product}', [ProductController::class, 'get'])->name('product.get');
        // Create a new product
        Route::post('create', [ProductController::class, 'create'])->name('product.create');
        // Update an existing product
        Route::post('update/{product}', [ProductController::class, 'update'])->name('product.update');
        // Delete a product
        Route::delete('delete/{product}', [ProductController::class, 'delete'])->name('product.delete');
        // Get soft deleted products
        Route::get('get-delete-soft', [ProductController::class, 'getSoftDeleted'])->name('product.get-delete-soft');
        // Restore a soft deleted product
        Route::post('restore/{product}', [ProductController::class, 'restore'])->name('product.restore');
    });

    // Category Routes
    Route::prefix('category')->namespace('Category')->group(function () {
        // Get all categories
        Route::get('all', [CategoryController::class, 'all'])->name('category.all');
        // Get a specific category by ID
        Route::get('get/{category}', [CategoryController::class, 'get'])->name('category.get');
        // Create a new category
        Route::post('create', [CategoryController::class, 'create'])->name('category.create');
        // Update an existing category
        Route::post('update/{category}', [CategoryController::class, 'update'])->name('category.update');
        // Delete a category
        Route::delete('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [CategoryController::class, 'getSoftDeleted'])->name('category.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
    });

    // Sub-Category Routes
    Route::prefix('sub-category')->namespace('SubCategory')->group(function () {
        // Get all sub-categories
        Route::get('all', [SubCategoryController::class, 'all'])->name('sub-category.all');
        // Get a specific sub-category by ID
        Route::get('get/{subCategory}', [SubCategoryController::class, 'get'])->name('sub-category.get');
        // Create a new sub-category
        Route::post('create', [SubCategoryController::class, 'create'])->name('sub-category.create');
        // Update an existing sub-category
        Route::post('update/{subCategory}', [SubCategoryController::class, 'update'])->name('sub-category.update');
        // Delete a sub-category
        Route::delete('delete/{subCategory}', [SubCategoryController::class, 'delete'])->name('sub-category.delete');
    });

    // City Routes
    Route::prefix('city')->namespace('City')->group(function () {
        // Get all cities
        Route::get('all', [CityController::class, 'all'])->name('city.all');
        // Get a specific city by ID
        Route::get('get/{city}', [CityController::class, 'get'])->name('city.get');
        // Create a new city
        Route::post('create', [CityController::class, 'create'])->name('city.create');
        // Update an existing city
        Route::post('update/{city}', [CityController::class, 'update'])->name('city.update');
        // Delete a city
        Route::delete('delete/{city}', [CityController::class, 'delete'])->name('city.delete');
    });

    // Address Routes
    Route::prefix('address')->namespace('Address')->group(function () {
        // Get all Addresses
        Route::get('all', [AddressController::class, 'all'])->name('address.all');
        // Get a specific Address by ID
        Route::get('get/{address}', [AddressController::class, 'get'])->name('address.get');
        // Create a new Address
        Route::post('create', [AddressController::class, 'create'])->name('address.create');
        // Update an existing Address
        Route::post('update/{address}', [AddressController::class, 'update'])->name('address.update');
        // Delete a Address
        Route::delete('delete/{address}', [AddressController::class, 'delete'])->name('address.delete');
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [AddressController::class, 'getSoftDeleted'])->name('address.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{address}', [AddressController::class, 'restore'])->name('address.restore');
    });
    // Collection Routes
    Route::prefix('collection')->namespace('Collection')->group(function () {
        // Get all Collectiones
        Route::get('all', [CollectionController::class, 'all'])->name('collection.all');
        // Get a specific Collection by ID
        Route::get('get/{collection}', [CollectionController::class, 'get'])->name('collection.get');
        // Create a new Collection
        Route::post('create', [CollectionController::class, 'create'])->name('collection.create');
        // Update an existing Collection
        Route::post('update/{collection}', [CollectionController::class, 'update'])->name('collection.update');
        // Delete a Collection
        Route::delete('delete/{collection}', [CollectionController::class, 'delete'])->name('collection.delete');
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [CollectionController::class, 'getSoftDeleted'])->name('collection.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{collection}', [CollectionController::class, 'restore'])->name('collection.restore');
    });

    // Color Routes
    Route::prefix('color')->namespace('Color')->group(function () {
        // Get all Collectiones
        Route::get('all', [ColorController::class, 'all'])->name('color.all');
        // Get a specific Collection by ID
        Route::get('get/{color}', [ColorController::class, 'get'])->name('color.get');
        // Create a new Collection
        Route::post('create', [ColorController::class, 'create'])->name('color.create');
        // Update an existing Collection
        Route::post('update/{color}', [ColorController::class, 'update'])->name('color.update');
        // Delete a Collection
        Route::delete('delete/{color}', [ColorController::class, 'delete']);
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [ColorController::class, 'getSoftDeleted'])->name('color.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{color}', [ColorController::class, 'restore'])->name('color.restore');
    });

    // Size Routes
    Route::prefix('size')->namespace('Size')->group(function () {
        // Get all Collectiones
        Route::get('all', [SizeController::class, 'all'])->name('size.all');
        // Get a specific Collection by ID
        Route::get('get/{size}', [SizeController::class, 'get'])->name('size.get');
        // Create a new Collection
        Route::post('create', [SizeController::class, 'create'])->name('size.create');
        // Update an existing Collection
        Route::post('update/{size}', [SizeController::class, 'update'])->name('size.update');
        // Delete a Collection
        Route::delete('delete/{size}', [SizeController::class, 'delete']);
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [SizeController::class, 'getSoftDeleted'])->name('size.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{size}', [SizeController::class, 'restore'])->name('size.restore');
    });

    // Material Routes
    Route::prefix('material')->namespace('Material')->group(function () {
        // Get all Collectiones
        Route::get('all', [MaterialController::class, 'all'])->name('material.all');
        // Get a specific Collection by ID
        Route::get('get/{material}', [MaterialController::class, 'get'])->name('material.get');
        // Create a new Collection        
        Route::post('create', [MaterialController::class, 'create'])->name('material.create');
        // Update an existing Collection
        Route::post('update/{material}', [MaterialController::class, 'update'])->name('material.update');
        // Delete a Collection
        Route::delete('delete/{material}', [MaterialController::class, 'delete']);
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [MaterialController::class, 'getSoftDeleted'])->name('material.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{material}', [MaterialController::class, 'restore'])->name('material.restore');
    });

    // Brand Routes
    Route::prefix('brand')->namespace('Brand')->group(function () {
        // Get all Collectiones
        Route::get('all', [BrandController::class, 'all'])->name('brand.all');
        // Get a specific Collection by ID
        Route::get('get/{brand}', [BrandController::class, 'get'])->name('brand.get');
        // Create a new Collection
        Route::post('create', [BrandController::class, 'create'])->name('brand.create');
        // Update an existing Collection
        Route::post('update/{brand}', [BrandController::class, 'update'])->name('brand.update');
        // Delete a Collection
        Route::delete('delete/{brand}', [BrandController::class, 'delete']);
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [BrandController::class, 'getSoftDeleted'])->name('brand.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{brand}', [BrandController::class, 'restore'])->name('brand.restore');
    });
    // Branch Routes
    Route::prefix('branch')->namespace('Branch')->group(function () {
        // Get all Collectiones
        Route::get('all', [BranchController::class, 'all'])->name('branch.all');
        // Get a specific Collection by ID
        Route::get('get/{branch}', [BranchController::class, 'get'])->name('branch.get');
        // Create a new Collection
        Route::post('create', [BranchController::class, 'create'])->name('branch.create');
        // Update an existing Collection
        Route::post('update/{branch}', [BranchController::class, 'update'])->name('branch.update');
        // Delete a Collection
        Route::delete('delete/{branch}', [BranchController::class, 'delete'])->name('branch.delete');
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [BranchController::class, 'getSoftDeleted'])->name('branch.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{branch}', [BranchController::class, 'restore'])->name('branch.restore');
    });
    // Satus Routes
    Route::prefix('status')->namespace('Status')->group(function () {
        // Get all Collectiones
        Route::get('all', [StatusController::class, 'all'])->name('status.all');
        // Get a specific Collection by ID
        Route::get('get/{status}', [StatusController::class, 'get'])->name('status.get');
        // Create a new Collection
        Route::post('create', [StatusController::class, 'create'])->name('status.create');
        // Update an existing Collection
        Route::post('update/{status}', [StatusController::class, 'update'])->name('status.update');
        // Delete a Collection
        Route::delete('delete/{status}', [StatusController::class, 'delete'])->name('status.delete');
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [StatusController::class, 'getSoftDeleted'])->name('status.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{status}', [StatusController::class, 'restore'])->name('status.restore');
    });

    // Slider Routes
    Route::prefix('slider')->namespace('Slider')->group(function () {
        // Get all Collectiones
        Route::get('all', [SliderController::class, 'all'])->name('slider.all');
        // Get a specific Collection by ID
        Route::get('get/{slider}', [SliderController::class, 'get'])->name('slider.get');
        // Create a new Collection
        Route::post('create', [SliderController::class, 'create'])->name('slider.create');
        // Update an existing Collection
        Route::post('update/{slider}', [SliderController::class, 'update'])->name('slider.update');
        // Delete a Collection
        Route::delete('delete/{slider}', [SliderController::class, 'delete'])->name('slider.delete');
    });
    // Contact Information Routes
    Route::prefix('contact')->namespace('Contact')->group(function () {
        // Get all Collectiones
        Route::get('all', [ContactInformationController::class, 'all'])->name('contact.all');
        // Get a specific Collection by ID
        Route::get('get/{contact}', [ContactInformationController::class, 'get'])->name('contact.get');
        // Create a new Collection
        Route::post('create', [ContactInformationController::class, 'create'])->name('contact.create');
        // Update an existing Collection
        Route::post('update/{contact}', [ContactInformationController::class, 'update'])->name('contact.update');
        // Delete a Collection
        Route::delete('delete/{contact}', [ContactInformationController::class, 'delete'])->name('contact.delete');
        // Get soft deleted Collectiones
        Route::get('get-delete-soft', [ContactInformationController::class, 'getSoftDeleted'])->name('contact.get-delete-soft');
        // Restore a soft deleted Collection
        Route::post('restore/{contact}', [ContactInformationController::class, 'restore'])->name('contact.restore');
    });
    // User Routes
    Route::prefix('user')->namespace('User')->group(function () {
        // Get all Users
        Route::get('all', [UserController::class, 'all'])->name('user.all');
        // Get a specific User by ID
        Route::get('get/{user}', [UserController::class, 'get'])->name('user.get');
        // Create a new User
        Route::post('create', [UserController::class, 'create'])->name('user.create');
        // Update an existing User
        Route::post('update/{user}', [UserController::class, 'update'])->name('user.update');
        // Delete a User
        Route::delete('delete/{user}', [UserController::class, 'delete'])->name('user.delete');
        // Get soft deleted Users
        Route::get('get-delete-soft', [UserController::class, 'getSoftDeleted'])->name('user.get-delete-soft');
        // Restore a soft deleted User
        Route::post('restore/{user}', [UserController::class, 'restore'])->name('user.restore');
    });
    // Role Routes
    Route::prefix('role')->namespace('Role')->group(function () {
        // Get all Roles
        Route::get('all', [RoleController::class, 'all'])->name('role.all');
        // Get a specific Role by ID
        Route::get('get/{role}', [RoleController::class, 'get'])->name('role.get');
        // Create a new Role
        Route::post('create', [RoleController::class, 'create'])->name('role.create');
        // Update an existing Role
        Route::post('update/{role}', [RoleController::class, 'update'])->name('role.update');
        // Delete a Role
        Route::delete('delete/{role}', [RoleController::class, 'delete'])->name('role.delete');
    });
    // AssignRoleUser Routes
    Route::prefix('user-assign-role')->namespace('UserAssignRole')->group(function () {
        // Get all AssignRoleUsers
        Route::get('all', [AssignRoleUserController::class, 'all'])->name('user-assign-role.all');
        // Get a specific AssignRoleUser by ID
        Route::get('get/{role}', [AssignRoleUserController::class, 'get'])->name('user-assign-role.get');
        // Create a new AssignRoleUser
        Route::post('create', [AssignRoleUserController::class, 'create'])->name('user-assign-role.create');
        // Update an existing AssignRoleUser
        Route::post('update/{role}', [AssignRoleUserController::class, 'update'])->name('user-assign-role.update');
        // Delete a AssignRoleUser
        Route::delete('delete/{role}', [AssignRoleUserController::class, 'delete'])->name('user-assign-role.delete');
    });

    // Offer Routes
    Route::prefix('offer')->namespace('Offer')->group(function () {
        // Get all Offers
        Route::get('all', [OfferDetailController::class, 'all'])->name('offer.all');
        // Get a specific Offer by ID
        Route::get('get/{offer}', [OfferDetailController::class, 'get'])->name('offer.get');
        // Create a new Offer
        Route::post('create', [OfferDetailController::class, 'create'])->name('offer.create');
        // Update an existing Offer
        Route::post('update/{offer}', [OfferDetailController::class, 'update'])->name('offer.update');
        // Delete a Offer
        Route::delete('delete/{offer}', [OfferDetailController::class, 'delete'])->name('offer.delete');
    });

    // Favourite Routes
    Route::prefix('favourite')->namespace('Favourite')->group(function () {
        // Get all Favourites
        Route::get('all', [FavouriteController::class, 'all'])->name('favourite.all');
        // Get a specific Favourite by ID
        Route::get('get/{favourite}', [FavouriteController::class, 'get'])->name('favourite.get');
        // Create a new Favourite
        Route::post('create', [FavouriteController::class, 'create'])->name('favourite.create');
        // Update an existing Favourite
        Route::post('update/{favourite}', [FavouriteController::class, 'update'])->name('favourite.update');
        // Delete a Favourite
        Route::delete('delete/{favourite}', [FavouriteController::class, 'delete'])->name('favourite.delete');
    });

    // Order Routes
    Route::prefix('order')->namespace('Order')->group(function () {
        // Get all Orders
        Route::get('all', [OrderController::class, 'all'])->name('order.all');
        // Get a specific Order by ID
        Route::get('get/{order}', [OrderController::class, 'get'])->name('order.get');
        // Create a new Order
        Route::post('create', [OrderController::class, 'create'])->name('order.create');
        // Update an existing Order
        Route::post('update/{order}', [OrderController::class, 'update'])->name('order.update');
        // Delete a Order
        Route::delete('delete/{order}', [OrderController::class, 'delete'])->name('order.delete');
        // grand total
        Route::get('grand-total', [OrderController::class, 'getGrandTotal'])->name('order.grand-total');
    });
    // cart routes
    Route::prefix('cart')->namespace('Cart')->group(function () {
        // Get all Carts
        Route::get('all', [CartController::class, 'all'])->name('cart.all');
        // Get a specific Cart by ID
        Route::get('get/{cart}', [CartController::class, 'get'])->name('cart.get');
        // Create a new Cart
        Route::post('create', [CartController::class, 'create'])->name('cart.create');
        // Update an existing Cart
        Route::post('update/{cart}', [CartController::class, 'update'])->name('cart.update');
        // Delete a Cart
        Route::delete('delete/{cart}', [CartController::class, 'delete'])->name('cart.delete');
    });

    // coupon routes
    Route::prefix('coupon')->namespace('Coupon')->group(function () {
        // Get all Carts
        Route::get('all', [CouponController::class, 'all'])->name('coupon.all');
        // Get a specific Cart by ID
        Route::get('get/{coupon}', [CouponController::class, 'get'])->name('coupon.get');
        // Create a new Cart
        Route::post('create', [CouponController::class, 'create'])->name('coupon.create');
        // Update an existing Cart
        Route::post('update/{coupon}', [CouponController::class, 'update'])->name('coupon.update');
        // Delete a Cart
        Route::delete('delete/{coupon}', [CouponController::class, 'delete'])->name('coupon.delete');
        // get coupon by code
        Route::get('code', [CouponController::class, 'getCouponByCode'])->name('coupon.code');
    });

    // template routes
    Route::prefix('template')->namespace('Template')->group(function () {

        // Store a new sheet template
        Route::post('create', [SheetTemplateController::class, 'receiveSheet'])->name('template.receiveSheet');

        // Show a specific sheet template
        Route::get('/sheet-templates/{id}', [SheetTemplateController::class, 'show'])->name('template.show');

        // Update an existing sheet template
        Route::put('/sheet-templates/{id}', [SheetTemplateController::class, 'update'])->name('template.update');

        // Delete a sheet template
        Route::delete('/sheet-templates/{id}', [SheetTemplateController::class, 'destroy'])->name('template.destroy');
    });
});
