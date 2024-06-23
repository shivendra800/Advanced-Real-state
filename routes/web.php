<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::namespace('App\Http\Controllers')->group(function () {

    Route::controller(\UserController::class)->group(function () {
        Route::get('/', 'Index');
    });

    Route::controller(\Frontend\IndexController::class)->group(function () {
        Route::get('/property/details/{id}/{slug}', 'PropertyDetails');
         // Send Message from Property Details Page 
        Route::post('/property/message', 'PropertyMessage')->name('property.message');
          // Agent Details Page in Frontend 
        Route::get('/agent/details/{id}', 'AgentDetails')->name('agent.details');
   
    });
    // User WishlistAll Route 
    Route::controller(\Frontend\WishlistController::class)->group(function () {
        Route::post('/add-to-wishList/{property_id}',  'AddToWishList');
    });
    Route::post('/add-to-compare/{property_id}', [App\Http\Controllers\Frontend\CompareController::class, 'AddToCompare']);
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::namespace('App\Http\Controllers')->group(function () {


        Route::controller(\UserController::class)->group(function () {
            Route::get('/user-logout', 'UserLogout');
        });
        // User WishlistAll Route 
        Route::controller(\Frontend\WishlistController::class)->group(function () {
            Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
            Route::get('/get-wishlist-property', 'GetWishlistProperty');
            Route::get('/wishlist-remove/{id}', 'WishlistRemove');
        });
        //   User Compare All Route 
        Route::controller(\Frontend\CompareController::class)->group(function () {

            Route::get('/user/compare', 'UserCompare')->name('user.compare');
            Route::get('/get-compare-property', 'GetCompareProperty');
            Route::get('/compare-remove/{id}', 'CompareRemove');
        });
    });
});

require __DIR__ . '/auth.php';

Route::get('admin/login', [App\Http\Controllers\AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);

Route::middleware(['auth', 'roles:admin'])->group(function () {

    Route::namespace('App\Http\Controllers')->group(function () {

        Route::controller(\AdminController::class)->group(function () {
            Route::get('admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
            Route::get('admin/logout', 'AdminLogout')->name('admin.logout');
        });
        // Agent All Route from admin 
        Route::controller(AdminController::class)->group(function () {

            Route::get('/all/agent', 'AllAgent')->name('all.agent');
            Route::get('/add/agent', 'AddAgent')->name('add.agent');
            Route::post('/store/agent', 'StoreAgent')->name('store.agent');
            Route::get('/edit/agent/{id}', 'EditAgent')->name('edit.agent');
            Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
            Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent');
            Route::get('/changeStatus', 'changeStatus');
        });

         // Admin User All Route 
        Route::controller(AdminController::class)->group(function(){

            Route::get('/all/admin', 'AllAdmin')->name('all.admin');
            Route::get('/add/admin', 'AddAdmin')->name('add.admin');
            Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
            Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
            Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
            Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');

        });



    });

    Route::namespace('App\Http\Controllers\Backend')->group(function () {

        // Property Type All Route 
        Route::controller(\PropertyTypeController::class)->group(function () {
            Route::get('all-Proptype', 'AllPropType')->middleware('permission:all.type');
            Route::get('/add-type', 'AddType')->middleware('permission:add.type');
            Route::post('/store-type', 'StoreType');
            Route::get('/edit-type/{id}', 'EditType');
            Route::post('/update-type', 'UpdateType');
            Route::get('/delete-type/{id}', 'DeleteType');
        });

        // Amenities Type All Route 
        Route::controller(PropertyTypeController::class)->group(function () {
            Route::get('/all-amenitie', 'AllAmenitie');
            Route::get('/add-amenitie', 'AddAmenitie');
            Route::post('/store-amenitie', 'StoreAmenitie');
            Route::get('/edit-amenitie/{id}', 'EditAmenitie');
            Route::post('/update-amenitie', 'UpdateAmenitie');
            Route::get('/delete-amenitie/{id}', 'DeleteAmenitie');
        });

        // Property All Route 
        Route::controller(PropertyController::class)->group(function () {

            Route::get('/all/property', 'AllProperty')->name('all.property');
            Route::get('/add/property', 'AddProperty')->name('add.property');
            Route::post('/store/property', 'StoreProperty')->name('store.property');
            Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property');
            Route::post('/update/property', 'UpdateProperty')->name('update.property');
            Route::post('/update/property/thambnail', 'UpdatePropertyThambnail')->name('update.property.thambnail');
            Route::post('/update/property/multiimage', 'UpdatePropertyMultiimage')->name('update.property.multiimage');
            Route::get('/property/multiimg/delete/{id}', 'PropertyMultiImageDelete')->name('property.multiimg.delete');
            Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');
            Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.property.facilities');
            Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');
            Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');
            Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');
            Route::post('/active/property', 'ActiveProperty')->name('active.property');
            Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
            Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');
            Route::get('/admin/property/message/', 'AdminPropertyMessage')->name('admin.property.message');
            
        });

        // Permission All Route 
        Route::controller(RoleController::class)->group(function () {

            Route::get('/all/permission', 'AllPermission')->name('all.permission');
            Route::get('/add/permission', 'AddPermission')->name('add.permission');
            Route::post('/store/permission', 'StorePermission')->name('store.permission');
            Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
            Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
            Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');


            Route::get('/import/permission', 'ImportPermission')->name('import.permission');
            Route::get('/export', 'Export')->name('export');
            Route::post('/import', 'Import')->name('import');
        });


        // Roles All Route 
        Route::controller(RoleController::class)->group(function () {

            Route::get('/all/roles', 'AllRoles')->name('all.roles');
            Route::get('/add/roles', 'AddRoles')->name('add.roles');
            Route::post('/store/roles', 'StoreRoles')->name('store.roles');
            Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
            Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
            Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');


            Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
            Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');

            Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');

            Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');

            Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');

            Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
        });


                 // SMTP Setting  All Route 
Route::controller(SettingController::class)->group(function(){

    Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
    Route::post('/update/smpt/setting', 'UpdateSmtpSetting')->name('update.smpt.setting');  

});

// Site Setting  All Route 
Route::controller(SettingController::class)->group(function(){

    Route::get('/site/setting', 'SiteSetting')->name('site.setting');
    Route::post('/update/site/setting', 'UpdateSiteSetting')->name('update.site.setting');  

});
    });
});

//    Admin Route End Here

//    Agent Route Start
Route::get('agent/login', [App\Http\Controllers\AgentController::class, 'AgentLogin'])->name('agent.login')->middleware(RedirectIfAuthenticated::class);
Route::post('/agent/register', [App\Http\Controllers\AgentController::class, 'AgentRegister'])->name('agent.register');
Route::middleware(['auth', 'roles:agent'])->group(function () {

    Route::namespace('App\Http\Controllers')->group(function () {

        Route::controller(\AgentController::class)->group(function () {
            Route::get('agent/dashboard', 'AgentDashboard')->name('agent.dashboard');
            Route::get('/agent/logout',   'AgentLogout')->name('agent.logout');
            Route::get('/agent/profile',   'AgentProfile')->name('agent.profile');
            Route::post('/agent/profile/store',   'AgentProfileStore')->name('agent.profile.store');
            Route::get('/agent/change/password',   'AgentChangePassword')->name('agent.change.password');
            Route::post('/agent/update/password',   'AgentUpdatePassword')->name('agent.update.password');
        });
    });

    Route::namespace('App\Http\Controllers\Agent')->group(function () {

        // Agent All Property  
        Route::controller(AgentPropertyController::class)->group(function () {

            Route::get('/agent/all/property', 'AgentAllProperty')->name('agent.all.property');
            Route::get('/agent/add/property', 'AgentAddProperty')->name('agent.add.property');

            Route::post('/agent/store/property', 'AgentStoreProperty')->name('agent.store.property');

            Route::get('/agent/edit/property/{id}', 'AgentEditProperty')->name('agent.edit.property');

            Route::post('/agent/update/property', 'AgentUpdateProperty')->name('agent.update.property');

            Route::post('/agent/update/property/thambnail', 'AgentUpdatePropertyThambnail')->name('agent.update.property.thambnail');

            Route::post('/agent/update/property/multiimage', 'AgentUpdatePropertyMultiimage')->name('agent.update.property.multiimage');

            Route::get('/agent/property/multiimg/delete/{id}', 'AgentPropertyMultiimgDelete')->name('agent.property.multiimg.delete');

            Route::post('/agent/store/new/multiimage', 'AgentStoreNewMultiimage')->name('agent.store.new.multiimage');

            Route::post('/agent/update/property/facilities', 'AgentUpdatePropertyFacilities')->name('agent.update.property.facilities');

            Route::get('/agent/details/property/{id}', 'AgentDetailsProperty')->name('agent.details.property');

            Route::get('/agent/delete/property/{id}', 'AgentDeleteProperty')->name('agent.delete.property');

            Route::get('/agent/property/message/', 'AgentPropertyMessage')->name('agent.property.message');

            Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');

            // Schedule Request Route 
            Route::get('/agent/schedule/request/', 'AgentScheduleRequest')->name('agent.schedule.request');

            Route::get('/agent/details/schedule/{id}', 'AgentDetailsSchedule')->name('agent.details.schedule');

            Route::post('/agent/update/schedule/', 'AgentUpdateSchedule')->name('agent.update.schedule');
        });

        // Agent Buy Package Route from admin 
        Route::controller(AgentPropertyController::class)->group(function () {

            Route::get('/buy/package', 'BuyPackage')->name('buy.package');
            Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
            Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');

            Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
            Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');


            Route::get('/package/history', 'PackageHistory')->name('package.history');
            Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');

   //User Property  Message  Request Route 
            Route::get('/agent/property/message/', 'AgentPropertyMessage')->name('agent.property.message');

            Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');  
      
         // Schedule Request Route 
          Route::get('/agent/schedule/request/', 'AgentScheduleRequest')->name('agent.schedule.request'); 
      
           Route::get('/agent/details/schedule/{id}', 'AgentDetailsSchedule')->name('agent.details.schedule'); 
      
         Route::post('/agent/update/schedule/', 'AgentUpdateSchedule')->name('agent.update.schedule'); 

        });
    });
});
