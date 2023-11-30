<?php

use App\Events\Activation;
use App\Events\PostEvent;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\back\AboutController;
use App\Http\Controllers\back\AdminController;
use App\Http\Controllers\back\AdminUserController;
use App\Http\Controllers\back\CatalogController;
use App\Http\Controllers\back\CategoryController;
use App\Http\Controllers\back\CatorderController;
use App\Http\Controllers\back\CommentController;
use App\Http\Controllers\back\ConfirmationController;
use App\Http\Controllers\back\CouponController;
use App\Http\Controllers\back\CtaController;
use App\Http\Controllers\back\EmailController;
use App\Http\Controllers\back\FootballController;
use App\Http\Controllers\back\PackController;
use App\Http\Controllers\back\PhotoController;
use App\Http\Controllers\back\PostController;
use App\Http\Controllers\back\PresentController;
use App\Http\Controllers\back\ProtranslateController;
use App\Http\Controllers\back\ServiceController;
use App\Http\Controllers\back\ThreadController;
use App\Http\Controllers\back\TicketController;
use App\Http\Controllers\front\ContactController;
use App\Http\Controllers\front\frontController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\PaymentController;
use App\Http\Controllers\front\ProductController;
use App\Http\Controllers\front\ProductPurchaseController;
use App\Http\Controllers\front\ResidController;
use App\Http\Controllers\front\TeammateController;
use App\Http\Controllers\front\TeamticketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Trez\RayganSms\Facades\RayganSms;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes(['verify'=>true]);

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        }
    );
    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

//Route::get('/',function (){
//    event(new Activation(User::find(1)));
//    return 'done';
//});
//back route

Route::prefix('api')->group(function (){
   Route::get('/cities/{province_id}',[App\Http\Controllers\UserController::class,'getAllCities']);
});


//Route::get('/', [App\Http\Controllers\front\HomeController::class, 'index'])->name('home');
//Route::get('/', [App\Http\Controllers\back\AdminController::class, 'homepage'])->name('home');
Route::get('/admin', [App\Http\Controllers\back\AdminController::class, 'homepage'])->name('home');
Route::get('/',[App\Http\Controllers\back\AdminController::class,'index'])->name('admin');

Route::prefix('admin')->middleware(['AdminCheck'])->group(function (){

    Route::get('/users', [App\Http\Controllers\back\AdminUserController::class, 'index'])->name('back.users');
    Route::get('/users/create', [App\Http\Controllers\back\AdminUserController::class, 'create'])->name('back.users.create');
    Route::post('/users/store', [App\Http\Controllers\back\AdminUserController::class, 'store'])->name('back.users.store');
    Route::get('/users/edit/{user}', [App\Http\Controllers\back\AdminUserController::class,'edit'])->name('back.users.edit');
    Route::put('/users/update/{user}', [App\Http\Controllers\back\AdminUserController::class,'update'])->name('back.users.update');
    Route::get('/users/delete/{user}', [App\Http\Controllers\back\AdminUserController::class,'destroy'])->name('back.users.delete');
    Route::get('/users/status/{user}', [App\Http\Controllers\back\AdminUserController::class,'updatestatus'])->name('back.users.status');
    Route::get('/users/profile/{user}', [App\Http\Controllers\back\AdminUserController::class,'profile'])->name('back.user.profile');
    Route::get('/users-search', [App\Http\Controllers\back\AdminUserController::class, 'userSearch'])->name('userSearch');
    Route::get('/users-code-search', [App\Http\Controllers\back\AdminUserController::class, 'userCodeSearch'])->name('userCode-Search');
    Route::get('/users-mobile-search', [App\Http\Controllers\back\AdminUserController::class, 'mobileSearch'])->name('users-mobileSearch');

    Route::get('/notifications', [App\Http\Controllers\back\AdminUserController::class,'show'])->name('back.user.notification');
});
Route::prefix('admin/emails')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\EmailController::class, 'index'])->name('back.emails');
    Route::get('/create', [App\Http\Controllers\back\EmailController::class, 'create'])->name('back.emails.create');
    Route::post('/store', [App\Http\Controllers\back\EmailController::class, 'store'])->name('back.emails.store');
    Route::get('/edit/{email}', [App\Http\Controllers\back\EmailController::class,'edit'])->name('back.emails.edit');
    Route::put('/update/{email}', [App\Http\Controllers\back\EmailController::class,'update'])->name('back.emails.update');
    Route::get('/delete/{email}', [App\Http\Controllers\back\EmailController::class,'destroy'])->name('back.emails.destroy');
    Route::get('/status/{email}', [App\Http\Controllers\back\EmailController::class,'updatestatus'])->name('back.emails.status');
});

Route::prefix('admin/emailmarketings')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\EmailmarketingController::class, 'index'])->name('back.emailmarketings');
    Route::get('/create', [App\Http\Controllers\back\EmailmarketingController::class, 'create'])->name('back.emailmarketings.create');
    Route::post('/store', [App\Http\Controllers\back\EmailmarketingController::class, 'store'])->name('back.emailmarketings.store');
    Route::get('/edit/{emailmarketing}', [App\Http\Controllers\back\EmailmarketingController::class,'edit'])->name('back.emailmarketings.edit');
    Route::put('/update/{emailmarketing}', [App\Http\Controllers\back\EmailmarketingController::class,'update'])->name('back.emailmarketings.update');
    Route::get('/delete/{emailmarketing}', [App\Http\Controllers\back\EmailmarketingController::class,'destroy'])->name('back.emailmarketings.destroy');
    Route::get('/status/{emailmarketing}', [App\Http\Controllers\back\EmailmarketingController::class,'updatestatus'])->name('back.emailmarketings.status');
    Route::POST('/sent/{emailmarketing}', [App\Http\Controllers\back\EmailmarketingController::class, 'sent'])->name('back.emailmarketings.sent');
});

Route::prefix('admin/posts')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PostController::class, 'index'])->name('back.posts');
    Route::get('/create', [App\Http\Controllers\back\PostController::class, 'create'])->name('back.posts.create');
    Route::post('/store', [App\Http\Controllers\back\PostController::class, 'store'])->name('back.posts.store');
    Route::get('/edit/{post}', [App\Http\Controllers\back\PostController::class,'edit'])->name('back.posts.edit');
    Route::put('/update/{post}', [App\Http\Controllers\back\PostController::class,'update'])->name('back.posts.update');
    Route::get('/delete/{post}', [App\Http\Controllers\back\PostController::class,'destroy'])->name('back.posts.destroy');
    Route::get('/status/{post}', [App\Http\Controllers\back\PostController::class,'updatestatus'])->name('back.posts.status');
});

Route::prefix('admin/categories')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CategoryController::class, 'index'])->name('back.categories');
    Route::get('/create', [App\Http\Controllers\back\CategoryController::class, 'create'])->name('back.categories.create');
    Route::post('/store', [App\Http\Controllers\back\CategoryController::class, 'store'])->name('back.categories.store');
    Route::get('/edit/{category}', [App\Http\Controllers\back\CategoryController::class,'edit'])->name('back.categories.edit');
    Route::put('/update/{category}', [App\Http\Controllers\back\CategoryController::class,'update'])->name('back.categories.update');
    Route::get('/delete/{category}', [App\Http\Controllers\back\CategoryController::class,'destroy'])->name('back.categories.destroy');
    Route::get('/status/{category}', [App\Http\Controllers\back\CategoryController::class,'updatestatus'])->name('back.categories.status');
});

Route::prefix('admin/catorders')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CatorderController::class, 'index'])->name('back.catorders');
    Route::get('/create', [App\Http\Controllers\back\CatorderController::class, 'create'])->name('back.catorders.create');
    Route::post('/store', [App\Http\Controllers\back\CatorderController::class, 'store'])->name('back.catorders.store');
    Route::get('/edit/{catorder}', [App\Http\Controllers\back\CatorderController::class,'edit'])->name('back.catorders.edit');
    Route::put('/update/{catorder}', [App\Http\Controllers\back\CatorderController::class,'update'])->name('back.catorders.update');
    Route::get('/delete/{catorder}', [App\Http\Controllers\back\CatorderController::class,'destroy'])->name('back.catorders.destroy');
    Route::get('/status/{catorder}', [App\Http\Controllers\back\CatorderController::class,'updatestatus'])->name('back.catorders.status');
    Route::get('/status/{catorder}', [App\Http\Controllers\back\CatorderController::class,'updatestatus'])->name('back.catorders.status');
});

Route::prefix('admin/catsliders')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CatsliderController::class, 'index'])->name('back.catsliders');
    Route::get('/create', [App\Http\Controllers\back\CatsliderController::class, 'create'])->name('back.catsliders.create');
    Route::post('/store', [App\Http\Controllers\back\CatsliderController::class, 'store'])->name('back.catsliders.store');
    Route::get('/edit/{catslider}', [App\Http\Controllers\back\CatsliderController::class,'edit'])->name('back.catsliders.edit');
    Route::put('/update/{catslider}', [App\Http\Controllers\back\CatsliderController::class,'update'])->name('back.catsliders.update');
    Route::get('/delete/{catslider}', [App\Http\Controllers\back\CatsliderController::class,'destroy'])->name('back.catsliders.destroy');
    Route::get('/status/{catslider}', [App\Http\Controllers\back\CatsliderController::class,'updatestatus'])->name('back.catsliders.status');
});

Route::prefix('admin/catalogcats')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CatalogcatController::class, 'index'])->name('back.catalogcats');
    Route::get('/create', [App\Http\Controllers\back\CatalogcatController::class, 'create'])->name('back.catalogcats.create');
    Route::post('/store', [App\Http\Controllers\back\CatalogcatController::class, 'store'])->name('back.catalogcats.store');
    Route::get('/edit/{catalogcat}', [App\Http\Controllers\back\CatalogcatController::class,'edit'])->name('back.catalogcats.edit');
    Route::put('/update/{catalogcat}', [App\Http\Controllers\back\CatalogcatController::class,'update'])->name('back.catalogcats.update');
    Route::get('/delete/{catalogcat}', [App\Http\Controllers\back\CatalogcatController::class,'destroy'])->name('back.catalogcats.destroy');
    Route::get('/status/{catalogcat}', [App\Http\Controllers\back\CatalogcatController::class,'updatestatus'])->name('back.catalogcats.status');
});

Route::prefix('admin/catalogs')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CatalogController::class, 'index'])->name('back.catalogs');
    Route::get('/create', [App\Http\Controllers\back\CatalogController::class, 'create'])->name('back.catalogs.create');
    Route::post('/store', [App\Http\Controllers\back\CatalogController::class, 'store'])->name('back.catalogs.store');
    Route::get('/edit/{catalog}', [App\Http\Controllers\back\CatalogController::class,'edit'])->name('back.catalogs.edit');
    Route::put('/update/{catalog}', [App\Http\Controllers\back\CatalogController::class,'update'])->name('back.catalogs.update');
    Route::get('/delete/{catalog}', [App\Http\Controllers\back\CatalogController::class,'destroy'])->name('back.catalogs.destroy');
    Route::get('/status/{catalog}', [App\Http\Controllers\back\CatalogController::class,'updatestatus'])->name('back.catalogs.status');
    Route::post('/catalog-sent/{catalog?}', [App\Http\Controllers\back\CatalogController::class, 'CatalogSent'])->name('CatalogSent');
});

Route::prefix('admin/catworks')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CatworkController::class, 'index'])->name('back.catworks');
    Route::get('/create', [App\Http\Controllers\back\CatworkController::class, 'create'])->name('back.catworks.create');
    Route::post('/store', [App\Http\Controllers\back\CatworkController::class, 'store'])->name('back.catworks.store');
    Route::get('/edit/{catwork}', [App\Http\Controllers\back\CatworkController::class,'edit'])->name('back.catworks.edit');
    Route::put('/update/{catwork}', [App\Http\Controllers\back\CatworkController::class,'update'])->name('back.catworks.update');
    Route::get('/delete/{catwork}', [App\Http\Controllers\back\CatworkController::class,'destroy'])->name('back.catworks.destroy');
    Route::get('/status/{catwork}', [App\Http\Controllers\back\CatworkController::class,'updatestatus'])->name('back.catworks.status');
});
Route::prefix('admin/productstore')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ProductStoreController::class, 'index'])->name('back.productstore');
    Route::get('/show/{product}', [App\Http\Controllers\back\ProductStoreController::class, 'show'])->name('back.productstore.show');
    Route::get('/edit/{product}', [App\Http\Controllers\back\ProductStoreController::class,'edit'])->name('back.productstore.edit');
    Route::put('/update/{product}', [App\Http\Controllers\back\ProductStoreController::class,'update'])->name('back.productstore.update');
    Route::get('/delete/{product}', [App\Http\Controllers\back\ProductStoreController::class,'destroy'])->name('back.productstore.destroy');
    Route::get('/status/{product}', [App\Http\Controllers\back\ProductStoreController::class,'updatestatus'])->name('back.productstore.status');
    Route::get('/productprint/{product}', [App\Http\Controllers\back\ProductStoreController::class,'productprint'])->name('back.productstoreprint');
    Route::get('/product-search', [App\Http\Controllers\back\ProductStoreController::class, 'productSearch'])->name('productstoreSearch');
    Route::get('/product-code-search', [App\Http\Controllers\back\ProductStoreController::class, 'productCodeSearch'])->name('productstoreCodeSearch');
    Route::get('/user-code-search', [\App\Http\Controllers\back\ProductStoreController::class, 'sotreuserCodeSearch'])->name('sotreuserCodeSearch');
});

Route::prefix('admin/products')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ProductController::class, 'index'])->name('back.products');
    Route::get('/create', [App\Http\Controllers\back\ProductController::class, 'create'])->name('back.products.create');
    Route::post('/store', [App\Http\Controllers\back\ProductController::class, 'store'])->name('back.products.store');
    Route::get('/show/{product}', [App\Http\Controllers\back\ProductController::class, 'show'])->name('back.products.show');
    Route::get('/edit/{product}', [App\Http\Controllers\back\ProductController::class,'edit'])->name('back.products.edit');
    Route::put('/update/{product}', [App\Http\Controllers\back\ProductController::class,'update'])->name('back.products.update');
    Route::get('/delete/{product}', [App\Http\Controllers\back\ProductController::class,'destroy'])->name('back.products.destroy');
    Route::get('/status/{product}', [App\Http\Controllers\back\ProductController::class,'updatestatus'])->name('back.products.status');
    Route::get('/productprint/{product}', [App\Http\Controllers\back\ProductController::class,'productprint'])->name('back.productprint');
    Route::get('/product-search', [App\Http\Controllers\back\ProductController::class, 'productSearch'])->name('productSearch');
    Route::get('/product-code-search', [App\Http\Controllers\back\ProductController::class, 'productCodeSearch'])->name('productCodeSearch');
    Route::delete('/delete/media', [App\Http\Controllers\back\ProductController::class,'deleteAll'])->name('back.products.delete.all');
    Route::get('/products-hold-edit', [\App\Http\Controllers\back\ProductController::class, 'holdEdit'])->name('back.holdEdit');
    Route::get('/product-hold-edit-search', [\App\Http\Controllers\back\ProductController::class, 'holdEditproductSearch'])->name('holdEditproductSearch');
    Route::get('/product-hold-edit-code-search', [App\Http\Controllers\back\ProductController::class, 'holdEditproductCodeSearch'])->name('holdEditproductCodeSearch');
    Route::get('/user-code-search', [\App\Http\Controllers\back\ProductController::class, 'userCodeSearch'])->name('userCodeSearch');
    Route::get('/holdedit/user-code-search', [\App\Http\Controllers\back\ProductController::class, 'holdedituserCodeSearch'])->name('holdedituserCodeSearch');

    Route::get('/product-cancel', [\App\Http\Controllers\back\ProductController::class, 'cancel'])->name('back.products.cancel');
    Route::get('/cancel-search', [\App\Http\Controllers\back\ProductController::class, 'cancelSearch'])->name('cancelSearch');
    Route::get('/cancel-code-search', [App\Http\Controllers\back\ProductController::class, 'cancelCodeSearch'])->name('cancelCodeSearch');
    Route::get('/cancel-user-code-search', [\App\Http\Controllers\back\ProductController::class, 'canceluserCodeSearch'])->name('canceluserCodeSearch');
});

Route::prefix('admin/productpurchases')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ProductPurchaseController::class, 'index'])->name('back.productpurchases');
    Route::get('/show/{transaction}', [App\Http\Controllers\back\ProductPurchaseController::class, 'show'])->name('back.productpurchases.show');
    Route::get('/product/purchase/print/{transaction}', [App\Http\Controllers\back\ProductPurchaseController::class,'productPurchasesPrint'])->name('back.productpurchasesprint');
});

Route::prefix('admin/presentpurchases')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PresentPurchaseController::class, 'index'])->name('back.presentpurchases');
    Route::get('/show/{presentaction}', [App\Http\Controllers\back\PresentPurchaseController::class, 'show'])->name('back.presentpurchases.show');
});

Route::prefix('admin/presents')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PresentController::class, 'index'])->name('back.presents');
    Route::get('/create/{protranslate}', [App\Http\Controllers\back\PresentController::class, 'create'])->name('back.presents.create');
    Route::post('/store', [App\Http\Controllers\back\PresentController::class, 'store'])->name('back.presents.store');
    Route::get('/show/{present}', [App\Http\Controllers\back\PresentController::class, 'show'])->name('back.presents.show');
    Route::get('/edit/{present}', [App\Http\Controllers\back\PresentController::class,'edit'])->name('back.presents.edit');
    Route::put('/update/{present}', [App\Http\Controllers\back\PresentController::class,'update'])->name('back.presents.update');
    Route::get('/delete/{present}', [App\Http\Controllers\back\PresentController::class,'destroy'])->name('back.presents.destroy');
    Route::get('/status/{present}', [App\Http\Controllers\back\PresentController::class,'updatestatus'])->name('back.presents.status');
    Route::get('/presentsprint/{present}', [App\Http\Controllers\back\PresentController::class,'presentsprint'])->name('back.presentsprint');
    Route::get('/present-code-search', [App\Http\Controllers\back\PresentController::class, 'presentCodeSearch'])->name('presentCodeSearch');
});
Route::prefix('admin/protranslates')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ProtranslateController::class, 'index'])->name('back.protranslates');
    Route::get('/create', [App\Http\Controllers\back\ProtranslateController::class, 'create'])->name('back.protranslates.create');
    Route::post('/store', [App\Http\Controllers\back\ProtranslateController::class, 'store'])->name('back.protranslates.store');
    Route::get('/show/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class, 'show'])->name('back.protranslates.show');
    Route::get('/edit/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class,'edit'])->name('back.protranslates.edit');
    Route::put('/update/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class,'update'])->name('back.protranslates.update');
    Route::get('/delete/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class,'destroy'])->name('back.protranslates.destroy');
    Route::get('/status/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class,'updatestatus'])->name('back.protranslates.status');
    Route::get('/productprint/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class,'productprint'])->name('back.protranslatesprint');
    Route::POST('/prosent/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class, 'prosent'])->name('back.protranslates.prosent');
    Route::POST('/product-sent-user/{protranslate}', [App\Http\Controllers\back\ProtranslateController::class, 'proSentUser'])->name('back.protranslates.proSentUser');
    Route::get('/code-search', [App\Http\Controllers\back\ProtranslateController::class, 'proCodeSearch'])->name('proCodeSearch');

});
Route::prefix('admin/coins')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CoinController::class, 'index'])->name('back.coins');
    Route::get('/create', [App\Http\Controllers\back\CoinController::class, 'create'])->name('back.coins.create');
    Route::post('/store', [App\Http\Controllers\back\CoinController::class, 'store'])->name('back.coins.store');
    Route::get('/edit/{coin}', [App\Http\Controllers\back\CoinController::class,'edit'])->name('back.coins.edit');
    Route::put('/update/{coin}', [App\Http\Controllers\back\CoinController::class,'update'])->name('back.coins.update');
    Route::get('/delete/{coin}', [App\Http\Controllers\back\CoinController::class,'destroy'])->name('back.coins.destroy');
});
Route::prefix('admin/menus')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\MenuController::class, 'index'])->name('back.menus');
    Route::get('/create', [App\Http\Controllers\back\MenuController::class, 'create'])->name('back.menus.create');
    Route::post('/store', [App\Http\Controllers\back\MenuController::class, 'store'])->name('back.menus.store');
    Route::get('/edit/{menu}', [App\Http\Controllers\back\MenuController::class,'edit'])->name('back.menus.edit');
    Route::put('/update/{menu}', [App\Http\Controllers\back\MenuController::class,'update'])->name('back.menus.update');
    Route::get('/delete/{menu}', [App\Http\Controllers\back\MenuController::class,'destroy'])->name('back.menus.destroy');
    Route::get('/status/{menu}', [App\Http\Controllers\back\MenuController::class,'updatestatus'])->name('back.menus.status');
});

Route::prefix('admin/photos')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PhotoController::class, 'index'])->name('back.photos');
    Route::get('/create', [App\Http\Controllers\back\PhotoController::class, 'create'])->name('back.photos.create');
    Route::post('/store', [App\Http\Controllers\back\PhotoController::class, 'store'])->name('back.photos.store');
    Route::get('/edit/{photo}', [App\Http\Controllers\back\PhotoController::class,'edit'])->name('back.photos.edit');
    Route::put('/update/{photo}', [App\Http\Controllers\back\PhotoController::class,'update'])->name('back.photos.update');
    Route::get('/delete/{photo}', [App\Http\Controllers\back\PhotoController::class,'destroy'])->name('back.photos.destroy');
    Route::get('/status/{photo}', [App\Http\Controllers\back\PhotoController::class,'updatestatus'])->name('back.photos.status');
    Route::post('/upload/', [App\Http\Controllers\back\PhotoController::class,'upload'])->name('back.photos.upload');
    Route::delete('/delete/media', [App\Http\Controllers\back\PhotoController::class,'deleteAll'])->name('back.photos.delete.all');

});

Route::prefix('admin/comments')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CommentController::class, 'index'])->name('back.comments');
    Route::get('/create', [App\Http\Controllers\back\CommentController::class, 'create'])->name('back.comments.create');
    Route::post('/store', [App\Http\Controllers\back\CommentController::class, 'store'])->name('back.comments.store');
    Route::get('/edit/{comment}', [App\Http\Controllers\back\CommentController::class,'edit'])->name('back.comments.edit');
    Route::put('/update/{comment}', [App\Http\Controllers\back\CommentController::class,'update'])->name('back.comments.update');
    Route::get('/delete/{comment}', [App\Http\Controllers\back\CommentController::class,'destroy'])->name('back.comments.destroy');
    Route::get('/status/{comment}', [App\Http\Controllers\back\CommentController::class,'updatestatus'])->name('back.comments.status');
});

Route::prefix('admin/contacts')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ContactController::class, 'index'])->name('back.contacts');
    Route::get('/create', [App\Http\Controllers\back\ContactController::class, 'create'])->name('back.contacts.create');
    Route::post('/store', [App\Http\Controllers\back\ContactController::class, 'store'])->name('back.contacts.store');
    Route::get('/edit/{contact}', [App\Http\Controllers\back\ContactController::class,'edit'])->name('back.contacts.edit');
    Route::put('/update/{contact}', [App\Http\Controllers\back\ContactController::class,'update'])->name('back.contacts.update');
    Route::get('/delete/{contact}', [App\Http\Controllers\back\ContactController::class,'destroy'])->name('back.contacts.destroy');
    Route::get('/status/{contact}', [App\Http\Controllers\back\ContactController::class,'updatestatus'])->name('back.contacts.status');
});

Route::prefix('admin/quickmobiles')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\QuickmobileController::class, 'index'])->name('back.quickmobiles');
    Route::get('/delete/{quickmobile}', [App\Http\Controllers\back\QuickmobileController::class,'destroy'])->name('back.quickmobiles.destroy');
});

Route::prefix('admin/catusers')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CatuserController::class, 'index'])->name('back.catusers');
    Route::get('/delete/{catuser}', [App\Http\Controllers\back\CatuserController::class,'destroy'])->name('back.catusers.destroy');
});

Route::prefix('admin/widgets')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\WidgetController::class, 'index'])->name('back.widgets');
    Route::get('/create', [App\Http\Controllers\back\WidgetController::class, 'create'])->name('back.widgets.create');
    Route::post('/store', [App\Http\Controllers\back\WidgetController::class, 'store'])->name('back.widgets.store');
    Route::get('/edit/{widget}', [App\Http\Controllers\back\WidgetController::class,'edit'])->name('back.widgets.edit');
    Route::put('/update/{widget}', [App\Http\Controllers\back\WidgetController::class,'update'])->name('back.widgets.update');
    Route::get('/delete/{widget}', [App\Http\Controllers\back\WidgetController::class,'destroy'])->name('back.widgets.destroy');
});

Route::prefix('admin/settings')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\SettingController::class, 'index'])->name('back.settings');
    Route::get('/create', [App\Http\Controllers\back\SettingController::class, 'create'])->name('back.settings.create');
    Route::post('/store', [App\Http\Controllers\back\SettingController::class, 'store'])->name('back.settings.store');
    Route::get('/edit/{setting}', [App\Http\Controllers\back\SettingController::class,'edit'])->name('back.settings.edit');
    Route::put('/update/{setting}', [App\Http\Controllers\back\SettingController::class,'update'])->name('back.settings.update');
    Route::get('/delete/{setting}', [App\Http\Controllers\back\SettingController::class,'destroy'])->name('back.settings.destroy');
    Route::get('/status/{setting}', [App\Http\Controllers\back\SettingController::class,'updatestatus'])->name('back.settings.status');
});

Route::prefix('admin/packs')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PackController::class, 'index'])->name('back.packs');
    Route::get('/create', [App\Http\Controllers\back\PackController::class, 'create'])->name('back.packs.create');
    Route::post('/store', [App\Http\Controllers\back\PackController::class, 'store'])->name('back.packs.store');
    Route::get('/edit/{pack}', [App\Http\Controllers\back\PackController::class,'edit'])->name('back.packs.edit');
    Route::put('/update/{pack}', [App\Http\Controllers\back\PackController::class,'update'])->name('back.packs.update');
    Route::get('/delete/{pack}', [App\Http\Controllers\back\PackController::class,'destroy'])->name('back.packs.destroy');
    Route::get('/status/{pack}', [App\Http\Controllers\back\PackController::class,'updatestatus'])->name('back.packs.status');
});

Route::prefix('admin/cancels')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CancelController::class, 'index'])->name('back.cancels');
    Route::get('/create', [App\Http\Controllers\back\CancelController::class, 'create'])->name('back.cancels.create');
    Route::post('/store', [App\Http\Controllers\back\CancelController::class, 'store'])->name('back.cancels.store');
    Route::get('/show/{cancel}', [App\Http\Controllers\back\CancelController::class, 'show'])->name('back.cancels.show');
    Route::get('/edit/{cancel}', [App\Http\Controllers\back\CancelController::class,'edit'])->name('back.cancels.edit');
    Route::put('/update/{cancel}', [App\Http\Controllers\back\CancelController::class,'update'])->name('back.cancels.update');
    Route::get('/delete/{cancel}', [App\Http\Controllers\back\CancelController::class,'destroy'])->name('back.cancels.destroy');
    Route::get('/status/{cancel}', [App\Http\Controllers\back\CancelController::class,'updatestatus'])->name('back.cancels.status');
});

Route::prefix('admin/portfolios')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PortfolioController::class, 'index'])->name('back.portfolios');
    Route::get('/create', [App\Http\Controllers\back\PortfolioController::class, 'create'])->name('back.portfolios.create');
    Route::post('/store', [App\Http\Controllers\back\PortfolioController::class, 'store'])->name('back.portfolios.store');
    Route::get('/edit/{portfolio}', [App\Http\Controllers\back\PortfolioController::class,'edit'])->name('back.portfolios.edit');
    Route::put('/update/{portfolio}', [App\Http\Controllers\back\PortfolioController::class,'update'])->name('back.portfolios.update');
    Route::get('/delete/{portfolio}', [App\Http\Controllers\back\PortfolioController::class,'destroy'])->name('back.portfolios.destroy');
    Route::get('/status/{portfolio}', [App\Http\Controllers\back\PortfolioController::class,'updatestatus'])->name('back.portfolios.status');
});

Route::prefix('admin/idcodes')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\IdcodeController::class, 'index'])->name('back.idcodes');
    Route::get('/create', [App\Http\Controllers\back\IdcodeController::class, 'create'])->name('back.idcodes.create');
    Route::post('/store', [App\Http\Controllers\back\IdcodeController::class, 'store'])->name('back.idcodes.store');
    Route::get('/show/{idcode}', [App\Http\Controllers\back\IdcodeController::class,'show'])->name('back.idcodes.show');
    Route::get('/edit/{idcode}', [App\Http\Controllers\back\IdcodeController::class,'edit'])->name('back.idcodes.edit');
    Route::put('/update/{idcode}', [App\Http\Controllers\back\IdcodeController::class,'update'])->name('back.idcodes.update');
    Route::get('/delete/{idcode}', [App\Http\Controllers\back\IdcodeController::class,'destroy'])->name('back.idcodes.destroy');
    Route::get('/status/{idcode}', [App\Http\Controllers\back\IdcodeController::class,'updatestatus'])->name('back.idcodes.status');
    Route::delete('/delete/idcodes', [App\Http\Controllers\back\IdcodeController::class,'deleteAll'])->name('back.idcodes.delete.all');
    Route::post('/sent/{idcode}', [App\Http\Controllers\back\IdcodeController::class, 'Sent'])->name('back.idcodes.Sent');
});
Route::prefix('admin/coupons')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CouponController::class, 'index'])->name('back.coupons');
    Route::get('/create', [App\Http\Controllers\back\CouponController::class, 'create'])->name('back.coupons.create');
    Route::post('/store', [App\Http\Controllers\back\CouponController::class, 'store'])->name('back.coupons.store');
    Route::get('/show/{coupon}', [App\Http\Controllers\back\CouponController::class,'show'])->name('back.coupons.show');
    Route::get('/edit/{coupon}', [App\Http\Controllers\back\CouponController::class,'edit'])->name('back.coupons.edit');
    Route::put('/update/{coupon}', [App\Http\Controllers\back\CouponController::class,'update'])->name('back.coupons.update');
    Route::get('/delete/{coupon}', [App\Http\Controllers\back\CouponController::class,'destroy'])->name('back.coupons.destroy');
    Route::get('/status/{coupon}', [App\Http\Controllers\back\CouponController::class,'updatestatus'])->name('back.coupons.status');
    Route::delete('/delete/coupons', [App\Http\Controllers\back\CouponController::class,'deleteAll'])->name('back.coupons.delete.all');
    Route::post('/sent/{coupon}', [App\Http\Controllers\back\CouponController::class, 'Sent'])->name('back.coupons.Sent');
});

Route::prefix('admin/couponpresents')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CouponpresentController::class, 'index'])->name('back.couponpresents');
    Route::get('/create', [App\Http\Controllers\back\CouponpresentController::class, 'create'])->name('back.couponpresents.create');
    Route::post('/store', [App\Http\Controllers\back\CouponpresentController::class, 'store'])->name('back.couponpresents.store');
    Route::get('/show/{couponpresent}', [App\Http\Controllers\back\CouponpresentController::class,'show'])->name('back.couponpresents.show');
    Route::get('/edit/{couponpresent}', [App\Http\Controllers\back\CouponpresentController::class,'edit'])->name('back.couponpresents.edit');
    Route::put('/update/{couponpresent}', [App\Http\Controllers\back\CouponpresentController::class,'update'])->name('back.couponpresents.update');
    Route::get('/delete/{couponpresent}', [App\Http\Controllers\back\CouponpresentController::class,'destroy'])->name('back.couponpresents.destroy');
    Route::get('/status/{couponpresent}', [App\Http\Controllers\back\CouponpresentController::class,'updatestatus'])->name('back.couponpresents.status');
    Route::delete('/delete/couponpresents', [App\Http\Controllers\back\CouponpresentController::class,'deleteAll'])->name('back.couponpresents.delete.all');
    Route::post('/sent/{couponpresent}', [App\Http\Controllers\back\CouponpresentController::class, 'Sent'])->name('back.couponpresents.Sent');
});

Route::prefix('admin/tickets')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\TicketController::class, 'index'])->name('back.tickets');
    Route::get('/create', [App\Http\Controllers\back\TicketController::class, 'create'])->name('back.tickets.create');
    Route::post('/store', [App\Http\Controllers\back\TicketController::class, 'store'])->name('back.tickets.store');
    Route::get('/show/{ticket}', [App\Http\Controllers\back\TicketController::class, 'show'])->name('back.tickets.show');
    Route::get('/edit/{ticket}', [App\Http\Controllers\back\TicketController::class,'edit'])->name('back.tickets.edit');
    Route::put('/update/{ticket}', [App\Http\Controllers\back\TicketController::class,'update'])->name('back.tickets.update');
    Route::get('/delete/{ticket}', [App\Http\Controllers\back\TicketController::class,'destroy'])->name('back.tickets.destroy');
    Route::get('/status/{ticket}', [App\Http\Controllers\back\TicketController::class,'updatestatus'])->name('back.tickets.status');
    Route::post('/reply/{ticket}', [App\Http\Controllers\back\TicketController::class, 'reply'])->name('back.tickets.reply');
});
Route::prefix('admin/ticketreplys')->middleware('AdminCheck')->group(function (){
    Route::get('/replydelete/{ticketreply}', [App\Http\Controllers\back\TicketreplyController::class,'destroy'])->name('back.ticketreplys.destroy');
});

Route::prefix('admin/teamtickets')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\TeamticketController::class, 'index'])->name('back.teamtickets');
    Route::get('/create', [App\Http\Controllers\back\TeamticketController::class, 'create'])->name('back.teamtickets.create');
    Route::post('/store', [App\Http\Controllers\back\TeamticketController::class, 'store'])->name('back.teamtickets.store');
    Route::get('/show/{teamticket}', [App\Http\Controllers\back\TeamticketController::class, 'show'])->name('back.teamtickets.show');
    Route::get('/edit/{teamticket}', [App\Http\Controllers\back\TeamticketController::class,'edit'])->name('back.teamtickets.edit');
    Route::put('/update/{teamticket}', [App\Http\Controllers\back\TeamticketController::class,'update'])->name('back.teamtickets.update');
    Route::get('/delete/{teamticket}', [App\Http\Controllers\back\TeamticketController::class,'destroy'])->name('back.teamtickets.destroy');
    Route::get('/status/{teamticket}', [App\Http\Controllers\back\TeamticketController::class,'updatestatus'])->name('back.teamtickets.status');
    Route::post('/reply/{teamticket}', [App\Http\Controllers\back\TeamticketController::class, 'reply'])->name('back.teammateticket.reply');
});

Route::prefix('admin/works')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\WorkController::class, 'index'])->name('back.works');
    Route::get('/create', [App\Http\Controllers\back\WorkController::class, 'create'])->name('back.works.create');
    Route::post('/store', [App\Http\Controllers\back\WorkController::class, 'store'])->name('back.works.store');
    Route::get('/edit/{work}', [App\Http\Controllers\back\WorkController::class,'edit'])->name('back.works.edit');
    Route::put('/update/{work}', [App\Http\Controllers\back\WorkController::class,'update'])->name('back.works.update');
    Route::get('/delete/{work}', [App\Http\Controllers\back\WorkController::class,'destroy'])->name('back.works.destroy');
});

Route::prefix('admin/teammates')->middleware('AdminCheck')->group(function (){
    Route::get('/', [\App\Http\Controllers\back\TeammateController::class, 'index'])->name('back.teammates');
    Route::get('/create', [App\Http\Controllers\back\TeammateController::class, 'create'])->name('back.teammates.create');
    Route::post('/store', [App\Http\Controllers\back\TeammateController::class, 'store'])->name('back.teammates.store');
    Route::get('/show/{teammate}', [App\Http\Controllers\back\TeammateController::class, 'show'])->name('back.teammates.show');
    Route::get('/edit/{teammate}', [App\Http\Controllers\back\TeammateController::class,'edit'])->name('back.teammates.edit');
    Route::put('/update/{teammate}', [App\Http\Controllers\back\TeammateController::class,'update'])->name('back.teammates.update');
    Route::get('/delete/{teammate}', [App\Http\Controllers\back\TeammateController::class,'destroy'])->name('back.teammates.destroy');
    Route::get('/status/{teammate}', [App\Http\Controllers\back\TeammateController::class,'updatestatus'])->name('back.teammates.status');
    Route::get('/teammateprint/{teammate}', [\App\Http\Controllers\back\TeammateController::class,'teammateprint'])->name('back.teammateprint');
    Route::get('/teamjobs', [App\Http\Controllers\back\TeammateController::class, 'TeamJob'])->name('back.teamjobs');
    Route::get('/teamjobs/{teammate}', [App\Http\Controllers\back\TeammateController::class, 'TeamJobshow'])->name('back.teamjobs.show');
    Route::get('/teamjobs-print/{teammate}', [\App\Http\Controllers\back\TeammateController::class,'teamJobsPrint'])->name('back.team.jobs.print');
});

Route::prefix('admin/groups')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\GroupController::class, 'index'])->name('back.groups');
    Route::get('/create', [App\Http\Controllers\back\GroupController::class, 'create'])->name('back.groups.create');
    Route::post('/store', [App\Http\Controllers\back\GroupController::class, 'store'])->name('back.groups.store');
    Route::get('/show/{group}', [App\Http\Controllers\back\GroupController::class, 'show'])->name('back.groups.show');
    Route::get('/edit/{group}', [App\Http\Controllers\back\GroupController::class,'edit'])->name('back.groups.edit');
    Route::put('/update/{group}', [App\Http\Controllers\back\GroupController::class,'update'])->name('back.groups.update');
    Route::get('/delete/{group}', [App\Http\Controllers\back\GroupController::class,'destroy'])->name('back.groups.destroy');
});

Route::prefix('admin/termpros')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\TermproController::class, 'index'])->name('back.termpros');
    Route::get('/create', [App\Http\Controllers\back\TermproController::class, 'create'])->name('back.termpros.create');
    Route::post('/store', [App\Http\Controllers\back\TermproController::class, 'store'])->name('back.termpros.store');
    Route::get('/edit/{termpro}', [App\Http\Controllers\back\TermproController::class,'edit'])->name('back.termpros.edit');
    Route::put('/update/{termpro}', [App\Http\Controllers\back\TermproController::class,'update'])->name('back.termpros.update');
    Route::get('/delete/{termpro}', [App\Http\Controllers\back\TermproController::class,'destroy'])->name('back.termpros.destroy');
    Route::get('/status/{termpro}', [App\Http\Controllers\back\TermproController::class,'updatestatus'])->name('back.termpros.status');
});

Route::prefix('admin/termteams')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\TermteamController::class, 'index'])->name('back.termteams');
    Route::get('/create', [App\Http\Controllers\back\TermteamController::class, 'create'])->name('back.termteams.create');
    Route::post('/store', [App\Http\Controllers\back\TermteamController::class, 'store'])->name('back.termteams.store');
    Route::get('/edit/{termteam}', [App\Http\Controllers\back\TermteamController::class,'edit'])->name('back.termteams.edit');
    Route::put('/update/{termteam}', [App\Http\Controllers\back\TermteamController::class,'update'])->name('back.termteams.update');
    Route::get('/delete/{termteam}', [App\Http\Controllers\back\TermteamController::class,'destroy'])->name('back.termteams.destroy');
    Route::get('/status/{termteam}', [App\Http\Controllers\back\TermteamController::class,'updatestatus'])->name('back.termteams.status');
});

Route::prefix('admin/messages')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\MessageController::class, 'index'])->name('back.messages');
    Route::get('/create', [App\Http\Controllers\back\MessageController::class, 'create'])->name('back.messages.create');
    Route::post('/store', [App\Http\Controllers\back\MessageController::class, 'store'])->name('back.messages.store');
    Route::get('/edit/{message}', [App\Http\Controllers\back\MessageController::class,'edit'])->name('back.messages.edit');
    Route::get('/show/{message}', [App\Http\Controllers\back\MessageController::class, 'show'])->name('back.messages.show');
    Route::put('/update/{message}', [App\Http\Controllers\back\MessageController::class,'update'])->name('back.messages.update');
    Route::get('/delete/{message}', [App\Http\Controllers\back\MessageController::class,'destroy'])->name('back.messages.destroy');
    Route::get('/status/{message}', [App\Http\Controllers\back\MessageController::class,'updatestatus'])->name('back.messages.status');
});

Route::prefix('admin/bannerusers')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\BanneruserController::class, 'index'])->name('back.bannerusers');
    Route::get('/create', [App\Http\Controllers\back\BanneruserController::class, 'create'])->name('back.bannerusers.create');
    Route::post('/store', [App\Http\Controllers\back\BanneruserController::class, 'store'])->name('back.bannerusers.store');
    Route::get('/edit/{banneruser}', [App\Http\Controllers\back\BanneruserController::class,'edit'])->name('back.bannerusers.edit');
    Route::put('/update/{banneruser}', [App\Http\Controllers\back\BanneruserController::class,'update'])->name('back.bannerusers.update');
    Route::get('/delete/{banneruser}', [App\Http\Controllers\back\BanneruserController::class,'destroy'])->name('back.bannerusers.destroy');
});

Route::prefix('admin/newsletters')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\NewsletterController::class, 'index'])->name('back.newsletters');
    Route::get('/delete/{newsletter}', [App\Http\Controllers\back\NewsletterController::class,'destroy'])->name('back.newsletters.destroy');
});

Route::prefix('admin/representations')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\RepresentationController::class, 'index'])->name('back.representations');
    Route::get('/show/{representation}', [App\Http\Controllers\back\RepresentationController::class,'show'])->name('back.representations.show');
    Route::get('/delete/{representation}', [App\Http\Controllers\back\RepresentationController::class,'destroy'])->name('back.representations.destroy');
    Route::get('/status/{representation}', [App\Http\Controllers\back\RepresentationController::class,'updatestatus'])->name('back.representations.status');
});

Route::prefix('admin/nextpayments')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\NextpaymentController::class, 'index'])->name('back.nextpayments');
    Route::get('/show/{nextpayment}', [App\Http\Controllers\back\NextpaymentController::class,'show'])->name('back.nextpayments.show');
    Route::get('/paymentsprint/{nextpayment}', [App\Http\Controllers\back\NextpaymentController::class,'nextpaymentsprint'])->name('back.nextpaymentsprint');
});
Route::prefix('admin/orders')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\OrderController::class, 'index'])->name('back.orders');
    Route::get('/show/{order}', [App\Http\Controllers\back\OrderController::class,'show'])->name('back.orders.show');
    Route::get('/ordersprint/{order}', [App\Http\Controllers\back\OrderController::class,'paymentsprint'])->name('back.ordersprint');
});

Route::prefix('admin/resources')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\AddsourceController::class, 'index'])->name('back.resources');
    Route::get('/show/{addsource}', [App\Http\Controllers\back\AddsourceController::class,'show'])->name('back.resources.show');
    Route::get('/resourcesprint/{addsource}', [App\Http\Controllers\back\AddsourceController::class,'resourcesprint'])->name('back.resourcesprint');
    Route::get('/edit/{addsource}', [App\Http\Controllers\back\AddsourceController::class,'edit'])->name('back.resources.edit');
    Route::put('/update/{addsource}', [App\Http\Controllers\back\AddsourceController::class,'update'])->name('back.resources.update');
    Route::get('/delete/{addsource}', [App\Http\Controllers\back\AddsourceController::class,'destroy'])->name('back.resources.destroy');
});

 Route::prefix('admin/galleries')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\GalleryController::class, 'index'])->name('back.galleries');
     Route::get('/create', [App\Http\Controllers\back\GalleryController::class, 'create'])->name('back.galleries.create');
     Route::post('/store', [App\Http\Controllers\back\GalleryController::class, 'store'])->name('back.galleries.store');
    Route::get('/edit/{gallery}', [App\Http\Controllers\back\GalleryController::class,'edit'])->name('back.galleries.edit');
    Route::put('/update/{gallery}', [App\Http\Controllers\back\GalleryController::class,'update'])->name('back.galleries.update');
    Route::get('/delete/{gallery}', [App\Http\Controllers\back\GalleryController::class,'destroy'])->name('back.galleries.destroy');
});

 Route::prefix('admin/videos')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\VideoController::class, 'index'])->name('back.videos');
     Route::get('/create', [App\Http\Controllers\back\VideoController::class, 'create'])->name('back.videos.create');
     Route::post('/store', [App\Http\Controllers\back\VideoController::class, 'store'])->name('back.videos.store');
    Route::get('/edit/{video}', [App\Http\Controllers\back\VideoController::class,'edit'])->name('back.videos.edit');
    Route::put('/update/{video}', [App\Http\Controllers\back\VideoController::class,'update'])->name('back.videos.update');
    Route::get('/delete/{video}', [App\Http\Controllers\back\VideoController::class,'destroy'])->name('back.videos.destroy');
});

////////////////////////////////////مدیریت صفحه اصلی/////////////////////////////////////////
Route::prefix('admin/sliders')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\SliderController::class, 'index'])->name('back.sliders');
    Route::get('/create', [App\Http\Controllers\back\SliderController::class, 'create'])->name('back.sliders.create');
    Route::post('/store', [App\Http\Controllers\back\SliderController::class, 'store'])->name('back.sliders.store');
    Route::get('/show/{slider}', [App\Http\Controllers\back\SliderController::class,'edit'])->name('back.sliders.edit');
    Route::put('/update/{slider}', [App\Http\Controllers\back\SliderController::class,'update'])->name('back.sliders.update');
    Route::get('/delete/{slider}', [App\Http\Controllers\back\SliderController::class,'destroy'])->name('back.sliders.destroy');
});
Route::prefix('admin/slideshows')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\SlideshowController::class, 'index'])->name('back.slideshows');
    Route::get('/create', [App\Http\Controllers\back\SlideshowController::class, 'create'])->name('back.slideshows.create');
    Route::post('/store', [App\Http\Controllers\back\SlideshowController::class, 'store'])->name('back.slideshows.store');
    Route::get('/edit/{slideshow}', [App\Http\Controllers\back\SlideshowController::class,'edit'])->name('back.slideshows.edit');
    Route::put('/update/{slideshow}', [App\Http\Controllers\back\SlideshowController::class,'update'])->name('back.slideshows.update');
    Route::get('/delete/{slideshow}', [App\Http\Controllers\back\SlideshowController::class,'destroy'])->name('back.slideshows.destroy');
});

Route::prefix('admin/resids')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ResidController::class, 'index'])->name('back.resids');
    Route::get('/show/{resid}', [App\Http\Controllers\back\ResidController::class, 'show'])->name('back.resids.show');
    Route::get('/delete/{resid}', [App\Http\Controllers\back\ResidController::class,'destroy'])->name('back.resids.destroy');
});

Route::prefix('admin/presentresids')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\PresentresidController::class, 'index'])->name('back.presentresids');
    Route::get('/show/{presentresid}', [App\Http\Controllers\back\PresentresidController::class, 'show'])->name('back.presentresids.show');
    Route::get('/delete/{presentresid}', [App\Http\Controllers\back\PresentresidController::class,'destroy'])->name('back.presentresids.destroy');
});
Route::prefix('admin/abouts')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\AboutController::class, 'index'])->name('back.abouts');
    Route::get('/create', [App\Http\Controllers\back\AboutController::class, 'create'])->name('back.abouts.create');
    Route::post('/store', [App\Http\Controllers\back\AboutController::class, 'store'])->name('back.abouts.store');
    Route::get('/edit/{about}', [App\Http\Controllers\back\AboutController::class,'edit'])->name('back.abouts.edit');
    Route::put('/update/{about}', [App\Http\Controllers\back\AboutController::class,'update'])->name('back.abouts.update');
    Route::get('/delete/{about}', [App\Http\Controllers\back\AboutController::class,'destroy'])->name('back.abouts.destroy');
});

Route::prefix('admin/aboutlists')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\AboutlistController::class, 'index'])->name('back.aboutlists');
    Route::get('/create', [App\Http\Controllers\back\AboutlistController::class, 'create'])->name('back.aboutlists.create');
    Route::post('/store', [App\Http\Controllers\back\AboutlistController::class, 'store'])->name('back.aboutlists.store');
    Route::get('/edit/{aboutlist}', [App\Http\Controllers\back\AboutlistController::class,'edit'])->name('back.aboutlists.edit');
    Route::put('/update/{aboutlist}', [App\Http\Controllers\back\AboutlistController::class,'update'])->name('back.aboutlists.update');
    Route::get('/delete/{aboutlist}', [App\Http\Controllers\back\AboutlistController::class,'destroy'])->name('back.aboutlists.destroy');
});

Route::prefix('admin/aunderwidgets')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\AunderwidgetController::class, 'index'])->name('back.aunderwidgets');
    Route::get('/create', [App\Http\Controllers\back\AunderwidgetController::class, 'create'])->name('back.aunderwidgets.create');
    Route::post('/store', [App\Http\Controllers\back\AunderwidgetController::class, 'store'])->name('back.aunderwidgets.store');
    Route::get('/edit/{aunderwidget}', [App\Http\Controllers\back\AunderwidgetController::class,'edit'])->name('back.aunderwidgets.edit');
    Route::put('/update/{aunderwidget}', [App\Http\Controllers\back\AunderwidgetController::class,'update'])->name('back.aunderwidgets.update');
    Route::get('/delete/{aunderwidget}', [App\Http\Controllers\back\AunderwidgetController::class,'destroy'])->name('back.aunderwidgets.destroy');
});

Route::prefix('admin/services')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ServiceController::class, 'index'])->name('back.services');
    Route::get('/create', [App\Http\Controllers\back\ServiceController::class, 'create'])->name('back.services.create');
    Route::post('/store', [App\Http\Controllers\back\ServiceController::class, 'store'])->name('back.services.store');
    Route::get('/edit/{service}', [App\Http\Controllers\back\ServiceController::class,'edit'])->name('back.services.edit');
    Route::put('/update/{service}', [App\Http\Controllers\back\ServiceController::class,'update'])->name('back.services.update');
    Route::get('/delete/{service}', [App\Http\Controllers\back\ServiceController::class,'destroy'])->name('back.services.destroy');
});

Route::prefix('admin/clients')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ClientController::class, 'index'])->name('back.clients');
    Route::get('/create', [App\Http\Controllers\back\ClientController::class, 'create'])->name('back.clients.create');
    Route::post('/store', [App\Http\Controllers\back\ClientController::class, 'store'])->name('back.clients.store');
    Route::get('/edit/{client}', [App\Http\Controllers\back\ClientController::class,'edit'])->name('back.clients.edit');
    Route::put('/update/{client}', [App\Http\Controllers\back\ClientController::class,'update'])->name('back.clients.update');
    Route::get('/delete/{client}', [App\Http\Controllers\back\ClientController::class,'destroy'])->name('back.clients.destroy');
});

Route::prefix('admin/ctas')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CtaController::class, 'index'])->name('back.ctas');
    Route::get('/create', [App\Http\Controllers\back\CtaController::class, 'create'])->name('back.ctas.create');
    Route::post('/store', [App\Http\Controllers\back\CtaController::class, 'store'])->name('back.ctas.store');
    Route::get('/edit/{cta}', [App\Http\Controllers\back\CtaController::class,'edit'])->name('back.ctas.edit');
    Route::put('/update/{cta}', [App\Http\Controllers\back\CtaController::class,'update'])->name('back.ctas.update');
    Route::get('/delete/{cta}', [App\Http\Controllers\back\CtaController::class,'destroy'])->name('back.ctas.destroy');
});

Route::prefix('admin/ads')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\AdController::class, 'index'])->name('back.ads');
    Route::get('/create', [App\Http\Controllers\back\AdController::class, 'create'])->name('back.ads.create');
    Route::post('/store', [App\Http\Controllers\back\AdController::class, 'store'])->name('back.ads.store');
    Route::get('/edit/{ad}', [App\Http\Controllers\back\AdController::class,'edit'])->name('back.ads.edit');
    Route::put('/update/{ad}', [App\Http\Controllers\back\AdController::class,'update'])->name('back.ads.update');
    Route::get('/delete/{ad}', [App\Http\Controllers\back\AdController::class,'destroy'])->name('back.ads.destroy');
});
Route::prefix('admin/adsforms')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\AdsformController::class, 'index'])->name('back.adsforms');
    Route::get('/show/{adsform}', [App\Http\Controllers\back\AdsformController::class,'show'])->name('back.adsforms.show');
    Route::put('/update/{adsform}', [App\Http\Controllers\back\AdsformController::class,'update'])->name('back.adsforms.update');
    Route::get('/delete/{adsform}', [App\Http\Controllers\back\AdsformController::class,'destroy'])->name('back.adsforms.destroy');
});

Route::prefix('admin/guides')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\GuideController::class, 'index'])->name('back.guides');
    Route::get('/create', [App\Http\Controllers\back\GuideController::class, 'create'])->name('back.guides.create');
    Route::post('/store', [App\Http\Controllers\back\GuideController::class, 'store'])->name('back.guides.store');
    Route::get('/edit/{guide}', [App\Http\Controllers\back\GuideController::class,'edit'])->name('back.guides.edit');
    Route::put('/update/{guide}', [App\Http\Controllers\back\GuideController::class,'update'])->name('back.guides.update');
    Route::get('/delete/{guide}', [App\Http\Controllers\back\GuideController::class,'destroy'])->name('back.guides.destroy');
});

Route::prefix('admin/customers')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CustomerController::class, 'index'])->name('back.customers');
    Route::get('/create', [App\Http\Controllers\back\CustomerController::class, 'create'])->name('back.customers.create');
    Route::post('/store', [App\Http\Controllers\back\CustomerController::class, 'store'])->name('back.customers.store');
    Route::get('/edit/{customer}', [App\Http\Controllers\back\CustomerController::class,'edit'])->name('back.customers.edit');
    Route::put('/update/{customer}', [App\Http\Controllers\back\CustomerController::class,'update'])->name('back.customers.update');
    Route::get('/delete/{customer}', [App\Http\Controllers\back\CustomerController::class,'destroy'])->name('back.customers.destroy');
});

Route::prefix('admin/footballs')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\FootballController::class, 'index'])->name('back.footballs');
    Route::get('/create', [App\Http\Controllers\back\FootballController::class, 'create'])->name('back.footballs.create');
    Route::post('/store', [App\Http\Controllers\back\FootballController::class, 'store'])->name('back.footballs.store');
    Route::get('/edit/{football}', [App\Http\Controllers\back\FootballController::class,'edit'])->name('back.footballs.edit');
    Route::put('/update/{football}', [App\Http\Controllers\back\FootballController::class,'update'])->name('back.footballs.update');
    Route::get('/delete/{football}', [App\Http\Controllers\back\FootballController::class,'destroy'])->name('back.footballs.destroy');
    Route::get('/status/{football}', [App\Http\Controllers\back\FootballController::class,'updatestatus'])->name('back.footballs.status');
    Route::get('/result/{football}', [App\Http\Controllers\back\FootballController::class,'result'])->name('back.footballs.result');
});
Route::prefix('admin/footballpres')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\FootballpreController::class, 'index'])->name('back.footballpres');
    Route::get('/create', [App\Http\Controllers\back\FootballpreController::class, 'create'])->name('back.footballpres.create');
    Route::post('/store', [App\Http\Controllers\back\FootballpreController::class, 'store'])->name('back.footballpres.store');
    Route::get('/edit/{footballpre}', [App\Http\Controllers\back\FootballpreController::class,'edit'])->name('back.footballpres.edit');
    Route::put('/update/{footballpre}', [App\Http\Controllers\back\FootballpreController::class,'update'])->name('back.footballpres.update');
    Route::get('/delete/{footballpre}', [App\Http\Controllers\back\FootballpreController::class,'destroy'])->name('back.footballpres.destroy');
    Route::get('/status/{footballpre}', [App\Http\Controllers\back\FootballpreController::class,'updatestatus'])->name('back.footballpres.status');
});
Route::prefix('admin/currencies')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\CurrencyController::class, 'index'])->name('back.currencies');
    Route::get('/create', [App\Http\Controllers\back\CurrencyController::class, 'create'])->name('back.currencies.create');
    Route::post('/store', [App\Http\Controllers\back\CurrencyController::class, 'store'])->name('back.currencies.store');
    Route::get('/edit/{currency}', [App\Http\Controllers\back\CurrencyController::class,'edit'])->name('back.currencies.edit');
    Route::put('/update/{currency}', [App\Http\Controllers\back\CurrencyController::class,'update'])->name('back.currencies.update');
    Route::get('/delete/{currency}', [App\Http\Controllers\back\CurrencyController::class,'destroy'])->name('back.currencies.destroy');
    Route::get('/status/{currency}', [App\Http\Controllers\back\CurrencyController::class,'updatestatus'])->name('back.currencies.status');
});
Route::prefix('admin/faqs')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\FaqController::class, 'index'])->name('back.faqs');
    Route::get('/create', [App\Http\Controllers\back\FaqController::class, 'create'])->name('back.faqs.create');
    Route::post('/store', [App\Http\Controllers\back\FaqController::class, 'store'])->name('back.faqs.store');
    Route::get('/edit/{faq}', [App\Http\Controllers\back\FaqController::class,'edit'])->name('back.faqs.edit');
    Route::put('/update/{faq}', [App\Http\Controllers\back\FaqController::class,'update'])->name('back.faqs.update');
    Route::get('/delete/{faq}', [App\Http\Controllers\back\FaqController::class,'destroy'])->name('back.faqs.destroy');
    Route::get('/status/{faq}', [App\Http\Controllers\back\FaqController::class,'updatestatus'])->name('back.faqs.status');
});
Route::prefix('admin/confirmations')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ConfirmationController::class, 'index'])->name('back.confirmations');
    Route::get('/show/{confirmation}', [App\Http\Controllers\back\ConfirmationController::class, 'show'])->name('back.confirmations.show');
    Route::get('/delete/{confirmation}', [App\Http\Controllers\back\ConfirmationController::class,'destroy'])->name('back.confirmations.destroy');
    Route::get('/confirmationsprint/{confirmation}', [App\Http\Controllers\back\ConfirmationController::class,'confirmPrint'])->name('back.confirmationsprint');
    Route::get('/confirmations/pdf/{confirmation}', [App\Http\Controllers\back\ConfirmationController::class,'confirmPdf'])->name('back.confirmations.pdf');
});

Route::prefix('admin/questions')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\QuestionController::class, 'index'])->name('back.questions');
    Route::get('/show/{question}', [App\Http\Controllers\back\QuestionController::class, 'show'])->name('back.questions.show');
    Route::get('/delete/{question}', [App\Http\Controllers\back\QuestionController::class,'destroy'])->name('back.questions.destroy');
});

Route::prefix('admin/currency')->middleware('AdminCheck')->group(function (){
    Route::post('/store', [App\Http\Controllers\back\CurrencyController::class, 'store'])->name('back.currency.store');
});
Route::prefix('admin/bannerhomes')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\BannerhomeController::class, 'index'])->name('back.bannerhomes');
    Route::get('/create', [App\Http\Controllers\back\BannerhomeController::class, 'create'])->name('back.bannerhomes.create');
    Route::post('/store', [App\Http\Controllers\back\BannerhomeController::class, 'store'])->name('back.bannerhomes.store');
    Route::get('/edit/{bannerhome}', [App\Http\Controllers\back\BannerhomeController::class,'edit'])->name('back.bannerhomes.edit');
    Route::put('/update/{bannerhome}', [App\Http\Controllers\back\BannerhomeController::class,'update'])->name('back.bannerhomes.update');
    Route::get('/delete/{bannerhome}', [App\Http\Controllers\back\BannerhomeController::class,'destroy'])->name('back.bannerhomes.destroy');
    Route::get('/status/{bannerhome}', [App\Http\Controllers\back\BannerhomeController::class,'updatestatus'])->name('back.bannerhomes.status');
});

Route::prefix('admin/producttrackings')->middleware('AdminCheck')->group(function (){
    Route::get('/', [App\Http\Controllers\back\ProducttrackingController::class, 'index'])->name('back.producttrackings');
    Route::get('/create', [App\Http\Controllers\back\ProducttrackingController::class, 'create'])->name('back.producttrackings.create');
    Route::post('/store', [App\Http\Controllers\back\ProducttrackingController::class, 'store'])->name('back.producttrackings.store');
    Route::get('/show/{producttracking}', [App\Http\Controllers\back\ProducttrackingController::class, 'show'])->name('back.producttrackings.show');
    Route::get('/edit/{producttracking}', [App\Http\Controllers\back\ProducttrackingController::class,'edit'])->name('back.producttrackings.edit');
    Route::put('/update/{producttracking}', [App\Http\Controllers\back\ProducttrackingController::class,'update'])->name('back.producttrackings.update');
    Route::get('/delete/{producttracking}', [App\Http\Controllers\back\ProducttrackingController::class,'destroy'])->name('back.producttrackings.destroy');
    Route::get('/status/{producttracking}', [App\Http\Controllers\back\ProducttrackingController::class,'updatestatus'])->name('back.producttrackings.status');
});
///////////////////////////end///////////////////////////////

//////////////////////////front-end routes////////////////////////////////


//////////////////////////////////////////////روت های ناحیه کاربری////////////////////////////////////////////////////
Route::group(['middleware' => ['auth','MobileCheck']],function(){
    Route::get('dashboard', [App\Http\Controllers\UserController::class,'dashboard'])->name('profile');
    Route::get('/profile/{user}', [App\Http\Controllers\UserController::class,'edit'])->name('profileedite');
    Route::put('/update/{user}', [App\Http\Controllers\UserController::class,'update'])->name('profileupdate');
    Route::put('/account/{user}', [App\Http\Controllers\UserController::class,'account'])->name('profileAccount');
    Route::get('dashboard/update', [App\Http\Controllers\UserController::class,'profile'])->name('profilecheck')->middleware('MobileCheck');
    Route::get('/notification', [App\Http\Controllers\UserController::class,'notification'])->name('notification');
    Route::get('/delete/{id}', [App\Http\Controllers\UserController::class,'destroy'])->name('profile.photo.destroy');

    Route::get('/dashboard/product', [App\Http\Controllers\front\ProductController::class, 'index'])->name('product')->middleware('MobileCheck');
    Route::post('/dashboard/product/store', [App\Http\Controllers\front\ProductController::class, 'store'])->name('product.store')->middleware(['MobileCheck','ProfileCheck']);
    Route::get('/dashboard/product/show/{product}', [App\Http\Controllers\front\ProductController::class, 'productshow'])->name('productshow')->middleware('MobileCheck');
    Route::get('/dashboard/product/oldproduct', [App\Http\Controllers\front\ProductController::class, 'oldproduct'])->name('oldproduct')->middleware('MobileCheck');
    Route::get('/dashboard/product/oldproduct/search', [App\Http\Controllers\front\ProductController::class,'productSearch'])->name('dash-productSearch');

    Route::get('/dashboard/product-tracking/{product}', [App\Http\Controllers\front\ProductController::class, 'productTracking'])->name('productTracking')->middleware('MobileCheck');

    Route::get('/dashboard/product/edit/{product}', [App\Http\Controllers\front\ProductController::class, 'edit'])->name('product.edit');
    Route::put('/dashboard/product/update/{product}', [App\Http\Controllers\front\ProductController::class, 'update'])->name('product.update');
    Route::post('/dashboard/product/re-request/{product}', [App\Http\Controllers\front\ProductController::class, 'Rerequest'])->name('product.re-request');
    Route::get('/dashboard/product/delete/{product}', [App\Http\Controllers\front\ProductController::class,'destroy'])->name('product.destroy');
    Route::post('/dashboard/product/cancel/{product}', [App\Http\Controllers\front\ProductController::class,'cancel'])->name('product.cancel');
    /*روت های پرداخت منبع یابی*/
    Route::get('/dashboard/order/product', [App\Http\Controllers\front\OrderController::class, 'index'])->name('product.orderPage');
    Route::get('/dashboard/order/product/result', [App\Http\Controllers\front\OrderController::class, 'result'])->name('product.paymentResult');

//    Route::get('/callback', [App\Http\Controllers\front\PaymentController::class, 'paymentVerify'])->name('callback');
//    Route::post('/dashboard/payment/product/', [App\Http\Controllers\front\PaymentController::class, 'payment'])->name('product.payment');
//    Route::get('/dashboard/payment/product/result', [App\Http\Controllers\front\PaymentController::class, 'result'])->name('paymentResult');
//    Route::post('/dashboard/payment/product/verify/{order}', [App\Http\Controllers\front\PaymentController::class, 'Verify'])->name('verify');
//
//    Route::get('dashboard/paymentlist', [App\Http\Controllers\front\PaymentController::class,'paymentList'])->name('paymentList');
    /* پایان روت های پرداخت منبع یابی*/

    /* روت های پرداخت منبع یابی نکست پی */
    Route::get('/callback', [App\Http\Controllers\front\NextpaymentController::class, 'nextpaymentVerify'])->name('callback');
    Route::post('/dashboard/pay/product/', [App\Http\Controllers\front\NextpaymentController::class, 'payment'])->name('product.pay');
    Route::get('/dashboard/pay/product/result', [App\Http\Controllers\front\NextpaymentController::class, 'result'])->name('paymentResult');
    Route::post('/dashboard/pay/product/verify/{ordernextpay}', [App\Http\Controllers\front\NextpaymentController::class, 'Verify'])->name('verify');

    Route::get('dashboard/paymentlist', [App\Http\Controllers\front\NextpaymentController::class,'paymentList'])->name('paymentList');
    Route::get('dashboard/paymentlist/show/{nextpayment}', [App\Http\Controllers\front\NextpaymentController::class,'paymentShow'])->name('paymentShow');
    /*  پایان روت های پرداخت منبع یابی نکست پی */

    /*روت پرداخت نهایی*/
//    Route::get('/callback', [App\Http\Controllers\front\PaymentpresentController::class, 'paymentVerify'])->name('callback');
//    Route::post('/dashboard/payment/product/', [App\Http\Controllers\front\PaymentpresentController::class, 'payment'])->name('present.payment');
//    Route::get('/dashboard/payment/product/result', [App\Http\Controllers\front\PaymentpresentController::class, 'result'])->name('paymentResult');
//    Route::post('/dashboard/payment/product/verify/{order}', [App\Http\Controllers\front\PaymentpresentController::class, 'Verify'])->name('verify');
    /*پایان روت پرداخت نهایی*/

    Route::get('/dashboard/transactions', [App\Http\Controllers\front\ProductPurchaseController::class, 'index'])->name('transactions');
    Route::get('/dashboard/product/purchase', [App\Http\Controllers\front\ProductPurchaseController::class, 'productPurchase'])->name('product.purchase');
    Route::get('/dashboard/product/purchase/show/{transaction}', [App\Http\Controllers\front\ProductPurchaseController::class, 'show'])->name('productPurchase.show');

//    Route::get('/dashboard/product/MobileCheck', [App\Http\Controllers\front\ProductController::class, 'MobileCheck'])->name('MobileCheck');
//    Route::get('/dashboard/product/MobileCheckSent', [App\Http\Controllers\front\ProductController::class, 'MobileCheckSent'])->name('MobilecheckSent');
//    Route::PUT('/dashboard/product/MobileCheck/store', [App\Http\Controllers\front\ProductController::class, 'MobileCheckStore'])->name('MobileCheckStore');
//    Route::post('/dashboard/product/MobileCheck/resent', [App\Http\Controllers\front\ProductController::class, 'MobileCheckResent'])->name('MobileCheckResent');
//    Route::post('/dashboard/product/MobileCheck-out', [App\Http\Controllers\front\ProductController::class, 'MobileCheckOut'])->name('MobileCheckOut');

    Route::get('/dashboard/product/InvoiceAccount', [App\Http\Controllers\front\ProductController::class, 'InvoiceAccount'])->name('InvoiceAccount');
    Route::get('/dashboard/product/InvoicePresentAccount', [App\Http\Controllers\front\ProductController::class, 'InvoicePresentAccount'])->name('InvoicePresentAccount');
    Route::get('/dashboard/product/InvoiceAccount/{transaction}', [App\Http\Controllers\front\ProductController::class, 'InvoiceAccountShow'])->name('InvoiceAccountShow');
    Route::get('/dashboard/product/InvoicePresentAccount/{presentaction}', [App\Http\Controllers\front\ProductController::class, 'InvoicePresentAccountShow'])->name('InvoicePresentAccountShow');

    Route::get('/dashboard/product/present/', [App\Http\Controllers\front\PresentController::class, 'index'])->name('present');
    Route::get('/dashboard/product/present/show/{present}', [App\Http\Controllers\front\PresentController::class, 'show'])->name('present.show');
    Route::get('/dashboard/product/present/{present}', [App\Http\Controllers\front\PresentController::class, 'status'])->name('present.status');
    Route::get('/dashboard/product/present/select/{present}', [App\Http\Controllers\front\PresentController::class, 'select'])->name('present.select');
    Route::post('/dashboard/product/present/coupon/{present}', [App\Http\Controllers\front\PresentController::class, 'addCouponPresent'])->name('addCouponPresent');
    Route::post('/dashboard/product/present/quickSelect/{present}', [App\Http\Controllers\front\PresentController::class, 'quickSelect'])->name('present.quickSelect');
    Route::get('/dashboard/product/present/quickSelect-back/{present}', [App\Http\Controllers\front\PresentController::class, 'presentQuickSelectBack'])->name('present-quickSelect-back');
    Route::get('/dashboard/product/present/order/print/{present}', [App\Http\Controllers\front\PresentController::class,'orderPresentPrint'])->name('present.orderPresentPrint');
    Route::post('/dashboard/product/present/storeUser/{present}', [App\Http\Controllers\front\PresentController::class,'storeUser'])->name('present.storeUser');

    Route::get('/dashboard/present/purchase', [App\Http\Controllers\front\PresentPurchaseController::class, 'presentPurchase'])->name('presentpurchase');
    Route::get('/dashboard/present/purchase/show/{presentaction}', [App\Http\Controllers\front\PresentPurchaseController::class, 'show'])->name('presentPurchase.show');

    Route::get('dashboard/ticket/create', [App\Http\Controllers\front\TicketController::class, 'create'])->name('ticket.create');
    Route::post('dashboard/ticket/store', [App\Http\Controllers\front\TicketController::class, 'store'])->name('ticket.store');
    Route::get('dashboard/ticket/show/{ticket}', [App\Http\Controllers\front\TicketController::class, 'show'])->name('ticket.show');
    Route::post('dashboard/ticket/reply/{ticket}', [App\Http\Controllers\front\TicketController::class, 'reply'])->name('ticket.reply');
    Route::get('dashboard/ticket/all', [App\Http\Controllers\front\TicketController::class, 'ticketshow'])->name('ticketshow');

    Route::get('/dashboard/coin/{couponpresent?}', [App\Http\Controllers\front\CoinController::class,'index'])->name('yabaneCoin');
    Route::get('/dashboard/coin/change/{coin}', [App\Http\Controllers\front\CoinController::class,'change'])->name('changeCoin');

    Route::post('dashboard', [App\Http\Controllers\UserController::class, 'rateToCoupon'])->name('rateToCoupon')->middleware(['ProfileCheck']);

    Route::get('add-to-cart/{id}', [App\Http\Controllers\front\CartController::class, 'addToCart'])->name('cartadd');

    Route::post('/coupon/{product}', [App\Http\Controllers\front\CouponController::class, 'addCoupon'])->name('couponadd');
    /*امضای الکترونیکی کاربر*/
    Route::get('dashboard/confirmation', [App\Http\Controllers\front\ConfirmationController::class, 'index'])->name('confirmation.index');
    Route::get('/dashboard/confirmation/show/{confirmation}', [App\Http\Controllers\front\ConfirmationController::class, 'show'])->name('confirmation.show');
    Route::get('/dashboard/confirmation/show/confirm/{confirmation}', [App\Http\Controllers\front\ConfirmationController::class, 'update'])->name('confirmation.update');
    Route::get('/dashboard/confirmation/print/{confirmation}', [App\Http\Controllers\front\ConfirmationController::class, 'confirmPrint'])->name('confirmation.print');
    /************************/

    Route::post('/dashboard/football-pre/store', [App\Http\Controllers\front\FootballpreController::class, 'store'])->name('footballpre.store');

    /*رهگیری مرسولات*/
    Route::get('dashboard/pro-tracking', [App\Http\Controllers\front\ProducttrackingController::class, 'index'])->name('producttrackings.index');
    Route::get('/dashboard/pro-tracking/show/{producttracking}', [App\Http\Controllers\front\ProducttrackingController::class, 'show'])->name('producttrackings.show');
    /************************/
});
///////////////////////////////////////////////////روت های مربوط به همکاری با ما و پنل همکاران/////////////////////////////
Route::group(['middleware' => ['auth','MobileCheck']],function(){
    Route::get('dashboard/works/create', [App\Http\Controllers\front\TeammateController::class, 'create'])->name('works.create');
    Route::post('/dashboard/teammate/store', [App\Http\Controllers\front\TeammateController::class,'store'])->name('teammate.store');
    Route::get('dashboard/teammates/', [App\Http\Controllers\front\TeammateController::class, 'index'])->name('teammate');
    Route::get('dashboard/teammates-final/', [App\Http\Controllers\front\TeammateController::class, 'teammate'])->name('teammate-final');
    Route::put('/dashboard/teammate-final/store/{teammate}', [App\Http\Controllers\front\TeammateController::class,'teammateFinal'])->name('teammate-final.store');// روت تکمیل فرم استخدام

    Route::get('dashboard/workproduct/', [App\Http\Controllers\front\TeammateController::class, 'workProduct'])->name('workProduct');
    Route::get('dashboard/workproduct-all/', [App\Http\Controllers\front\TeammateController::class, 'workProductAll'])->name('workProductAll');
    Route::get('dashboard/workproduct-code-search', [App\Http\Controllers\front\TeammateController::class, 'workProductCodeSearch'])->name('workProductCodeSearch');
    Route::get('dashboard/checking-product/{product}', [App\Http\Controllers\front\TeammateController::class, 'checkingPro'])->name('checkingPro');
    Route::get('dashboard/confirm-product/{product}', [App\Http\Controllers\front\TeammateController::class, 'confirmPro'])->name('confirmPro');

    Route::put('/dashboard/checking-product/store/{product}', [App\Http\Controllers\front\MessageController::class,'store'])->name('addDesProduct');
    Route::get('/dashboard/product-message/', [App\Http\Controllers\front\MessageController::class,'productMessage'])->name('productMessage');
    Route::get('/dashboard/product-message-search/', [App\Http\Controllers\front\MessageController::class,'searchproductMessage'])->name('searchproductMessage');

    Route::post('/dashboard/checking-product/translate/store', [App\Http\Controllers\front\ProtranslateController::class,'store'])->name('translate.store');
    Route::get('/dashboard/checking-product/translate/all', [App\Http\Controllers\front\ProtranslateController::class,'proTranslate'])->name('protranslate');
    Route::get('/dashboard/checking-product/translate/edit/{protranslate}', [App\Http\Controllers\front\ProtranslateController::class,'edit'])->name('protranslate.edit');
    Route::put('/dashboard/checking-product/translate/update/{protranslate}', [App\Http\Controllers\front\ProtranslateController::class,'update'])->name('protranslate.update');
    Route::get('dashboard/checking-product/translate/code-search', [App\Http\Controllers\front\ProtranslateController::class, 'workProtranslateCodeSearch'])->name('workProtranslateCodeSearch');

    Route::get('dashboard/teammate-ticket/create', [App\Http\Controllers\front\TeamticketController::class, 'create'])->name('teammate-ticket.create');
    Route::post('dashboard/teammate-ticket/store', [App\Http\Controllers\front\TeamticketController::class, 'store'])->name('teammate-ticket.store');
    Route::post('dashboard/teammate-ticket/reply/{teamticket}', [App\Http\Controllers\front\TeamticketController::class, 'reply'])->name('teammate-ticket.reply');
    Route::get('dashboard/teammateticket/show/{teamticket}', [App\Http\Controllers\front\TeamticketController::class, 'show'])->name('teammate-ticket.show');
    Route::get('dashboard/teammate-ticket/all', [App\Http\Controllers\front\TeamticketController::class, 'teammateTicketshow'])->name('teammate-ticketshow.all');

    Route::get('/teammate/notification', [App\Http\Controllers\front\TeammateController::class,'notification'])->name('teammate-notification');
});


////////////////////////////////////////////روت های فرانت سایت/////////////////////////////////////////////////////////
    Route::get('/posts', [App\Http\Controllers\front\PostController::class, 'index'])->name('front.posts');
    Route::get('/posts/{post}', [App\Http\Controllers\front\PostController::class, 'show'])->name('postdetail');
    Route::get('/posts-category/{slug}', [App\Http\Controllers\front\PostController::class, 'postshow'])->name('postcat');
    Route::get('/search', [App\Http\Controllers\front\postController::class, 'searchTitle'])->name('search');
    Route::get('/main-search-index', [App\Http\Controllers\AdminController::class, 'index'])->name('MainSearch');
    Route::post('/main-search', [App\Http\Controllers\AdminController::class, 'searchmain'])->name('searchmain');

    Route::get('/gallery-search/{gallery}', [App\Http\Controllers\front\GalleryController::class, 'gallerySearch'])->name('gallerySearch');

    Route::post('/comment/{post}', [App\Http\Controllers\front\CommentController::class,'store'])->name('comment.store');
    Route::post('/comments', [App\Http\Controllers\front\CommentController::class,'replyStore'])->name('comment.reply');

    Route::get('/contacts', [App\Http\Controllers\front\ContactController::class, 'index'])->name('contacts');
    Route::post('/contacts/store', [App\Http\Controllers\front\ContactController::class,'store'])->name('contacts.store');

    Route::post('/store', [App\Http\Controllers\front\NewsletterController::class,'store'])->name('newsletter.store');

    Route::get('/works', [App\Http\Controllers\front\WorkController::class, 'index'])->name('front.works');

    Route::get('/adsforms', [App\Http\Controllers\front\AdsformController::class, 'index'])->name('ads');
    Route::post('/adsforms/store', [App\Http\Controllers\front\AdsformController::class, 'store'])->name('ads.store');

    Route::get('/representation', [App\Http\Controllers\front\RepresentationController::class, 'index'])->name('representations');
    Route::post('/representation/store', [App\Http\Controllers\front\RepresentationController::class, 'store'])->name('representations.store');

    Route::get('/guide', [App\Http\Controllers\front\HomeController::class, 'guide'])->name('guide');

    Route::get('/portfolio/{portfolio}', [App\Http\Controllers\front\PortfolioController::class, 'index'])->name('portfolio-detail');
    Route::get('/portfolio-all/', [App\Http\Controllers\front\PortfolioController::class, 'portfolioAll'])->name('portfolio-all');

    Route::get('/catalogs', [App\Http\Controllers\front\CatalogController::class, 'index'])->name('catalogs');
    Route::get('/catalogs-detail/{catalog}', [App\Http\Controllers\front\CatalogController::class, 'show'])->name('catalogs-detail');
    Route::get('/catalogs-buy/{catalog}', [App\Http\Controllers\front\CatalogController::class, 'buyCatalog'])->name('buyCatalog');
    Route::post('/catalogs-buy/store', [App\Http\Controllers\front\CatuserController::class, 'store'])->name('Catagdownload.store');

    Route::post('/photos/', [App\Http\Controllers\front\PhotoController::class,'upload'])->name('photos.upload');

    Route::get('/services/{service}', [App\Http\Controllers\front\ServiceController::class, 'show'])->name('servicedetail');
    Route::get('/widgetdetail/{aunderwidget}', [App\Http\Controllers\front\AunderwidgetController::class, 'show'])->name('widgetdetail');

    Route::get('/wallet', [App\Http\Controllers\UserController::class, 'wallet'])->name('front.wallet');
    Route::post('/wallet-purchase/', [App\Http\Controllers\front\WalletPurchaseController::class, 'purchase'])->name('wallet.purchase');
    Route::get('/wallet-purchase/result/{user}', [App\Http\Controllers\front\WalletPurchaseController::class, 'result'])->name('wallet.purchase.result');

    Route::get('/production', [App\Http\Controllers\front\ProductionController::class, 'index'])->name('producion');
    Route::get('/product-category', [App\Http\Controllers\front\ProductionController::class, 'cat'])->name('product-category');

    Route::post('/quickmobile/store', [App\Http\Controllers\front\QuickmobileController::class, 'store'])->name('quick.mobile.store');

    Route::get('/check/mobile-user', [App\Http\Controllers\UserController::class, 'checkMobileUser'])->name('checkMobileUser');/*for register*/
    Route::post('/MobileCheck-out', [App\Http\Controllers\UserController::class, 'MobileCheckOutUser'])->name('MobileCheckOutUser');/*for register*/
    Route::post('/MobileCheck/resent', [App\Http\Controllers\UserController::class, 'MobileCheckResentUser'])->name('MobileCheckResentUser');/*for register*/

    Route::get('/login-phone', [App\Http\Controllers\Auth\LoginController::class, 'loginPhone'])->name('loginPhone');/*for login*/
    Route::post('/login-mobile', [App\Http\Controllers\Auth\LoginController::class, 'doLoginPhone'])->name('doLoginPhone');/*for login*/
    Route::get('/login-check/mobile-user', [App\Http\Controllers\UserController::class, 'LogincheckMobileUser'])->name('LogincheckMobileUser');/*for login*/
    Route::post('/login-MobileCheck-out', [App\Http\Controllers\UserController::class, 'LoginMobileCheckOutUser'])->name('LoginMobileCheckOutUser');/*for login*/
    Route::post('/login-MobileCheck/resent', [App\Http\Controllers\UserController::class, 'LoginMobileCheckResentUser'])->name('LoginMobileCheckResentUser');/*for login*/

    Route::get('/faq', [App\Http\Controllers\front\FaqController::class, 'index'])->name('front.faq');
    Route::post('/faq/store', [App\Http\Controllers\front\QuestionController::class, 'store'])->name('front.faq.question');

    Route::get('/resources', [App\Http\Controllers\front\AddsourceController::class, 'index'])->name('front.resources');
    Route::post('/resources/store', [App\Http\Controllers\front\AddsourceController::class, 'store'])->name('front.resources.store');

    Route::get('/abouts', [App\Http\Controllers\front\AboutController::class, 'index'])->name('front.abouts');
    Route::get('/videos', [App\Http\Controllers\front\VideoController::class, 'index'])->name('front.videos');
//    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('front.home');
////////////////////////////////////////////////روت های پرداخت/////////////////////////////////////////////////////////
Route::get('/pardakht/{product}', [App\Http\Controllers\front\ProductController::class, 'pardakht'])->name('pardakht');
Route::post('/pardakht/store', [App\Http\Controllers\front\ResidController::class, 'store'])->name('pardakht.store');

Route::get('/present-pardakht/{present}', [App\Http\Controllers\front\PresentController::class, 'pardakht'])->name('pardakht-present');
Route::post('/present-pardakht/store', [App\Http\Controllers\front\PresentresidController::class, 'store'])->name('present-pardakht.store')->middleware('ProfileCheck');

Route::get('/purchase/{product}', [App\Http\Controllers\front\ProductPurchaseController::class, 'purchase'])->name('purchase');
Route::get('/purchase/result/{product}', [App\Http\Controllers\front\ProductPurchaseController::class, 'result'])->name('purchase.result');
Route::get('/purchase/product/result/{product}', [App\Http\Controllers\front\ProductPurchaseController::class, 'productPurchase'])->name('productPurchase.result');
Route::get('/purchase/unresult/{product}', [App\Http\Controllers\front\ProductPurchaseController::class, 'unresult'])->name('purchase.unresult');

Route::get('/purchase/present/{present}', [App\Http\Controllers\front\PresentPurchaseController::class, 'purchase'])->name('present.purchase');
Route::get('/purchase/present/result/{present}', [App\Http\Controllers\front\PresentPurchaseController::class, 'result'])->name('present.purchase.result');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/test/notification',[App\Http\Controllers\front\NotificationController::class,'index'])->name('notification.index');
Route::post('/test/notification',[App\Http\Controllers\front\NotificationController::class,'notification'])->name('notification.post');
