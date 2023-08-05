<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ReclamationStatusController;
use App\Http\Controllers\PickupStatusController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\DeliveryInvoiceController;
use App\Http\Controllers\CustomerInvoiceController;
use App\Http\Controllers\BonDeliveryController;
use App\Http\Controllers\BonPickupController;
use App\Http\Controllers\BonReturnController;
use App\Http\Controllers\BonStockController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ReclamationsTypeController;
use App\Http\Controllers\OrderPhaseController;
use App\Http\Controllers\ExpensesTypeController;
use App\Http\Controllers\CitiesCodeController;

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\BonReturnsDeliveryController;








/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['jwt.auth', 'cors']], function () {


//packages   

Route::get('/messages', [MessageController::class, 'index']);
Route::post('/message/new', [MessageController::class, 'new_message']);


//packages   

Route::get('/conversations', [ConversationController::class, 'index']);
Route::post('/conversation/new', [ConversationController::class, 'new_conversation']);


//Expenses   

Route::get('/expenses', [ExpensesController::class, 'index']);
Route::get('/expense/{id}/get', [ExpensesController::class, 'get_expense']);
Route::post('/expense/new', [ExpensesController::class, 'new_expense']);
Route::put('/expense/{id}/update', [ExpensesController::class, 'update_expense']);
Route::put('/expense/{id}/delete', [ExpensesController::class, 'delete_expense']);

//Expenses   types 

Route::get('/expenses/types', [ExpensesTypeController::class, 'index']);


//packages   

    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/package/{id}/get', [PackageController::class, 'get_package']);
    Route::post('/package/new', [PackageController::class, 'new_package']);
    Route::put('/package/{id}/update', [PackageController::class, 'update_package']);
    Route::put('/package/{id}/delete', [PackageController::class, 'delete_package']);


//deliverymans   

    Route::get('/deliverymans', [DriverController::class, 'index']);
    Route::get('/deliveryman/{id}/get', [DriverController::class, 'get_deliveryman']);
    Route::post('/deliveryman/new', [DriverController::class, 'new_deliveryman']);
    Route::put('/deliveryman/{id}/update', [DriverController::class, 'update_deliveryman']);
    Route::post('/deliveryman/{id}/delete', [DriverController::class, 'delete_deliveryman']);


//customers   

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customer/{id}/get', [CustomerController::class, 'get_customer']);
    Route::post('/customer/new', [CustomerController::class, 'new_customer']);
    Route::put('/customer/{id}/update', [CustomerController::class, 'update_customer']);
    Route::post('/customer/{id}/delete', [CustomerController::class, 'delete_customer']);


//users   

    Route::get('/users', [UtilisateurController::class, 'index']);
    Route::get('/user/{id}/get', [UtilisateurController::class, 'get_user']);
    Route::post('/user/new', [UtilisateurController::class, 'new_user']);
    Route::put('/user/{id}/update', [UtilisateurController::class, 'update_user']);
    Route::post('/user/{id}/delete', [UtilisateurController::class, 'delete_user']);


    //Customer invoice   

    Route::get('/customer_invoices', [CustomerInvoiceController::class, 'index']);
    Route::put('/customer/invoice/{id}/close/update', [CustomerInvoiceController::class, 'update_customer_invoice_close']);
    Route::put('/customer/invoice/{id}/paid/update', [CustomerInvoiceController::class, 'update_customer_invoice_paid']);
    Route::post('/customer_invoice/{id}/delete', [CustomerInvoiceController::class, 'update_customer_invoice']);


    //Delivery Invoice   

    Route::get('/delivery_invoices', [DeliveryInvoiceController::class, 'index']);
    Route::put('/delivery/invoice/{id}/close/update', [DeliveryInvoiceController::class, 'update_delivery_invoice_close']);
    Route::put('/delivery/invoice/{id}/paid/update', [DeliveryInvoiceController::class, 'update_delivery_invoice_paid']);
    Route::post('/Delivery_invoice/{id}/delete', [DeliveryInvoiceController::class, 'delete_Delivery_invoice']);


//roles   

Route::get('/roles', [RoleController::class, 'index']);
Route::get('/role/{id}/get', [RoleController::class, 'get_role']);
Route::post('/role/new', [RoleController::class, 'new_role']);
Route::put('/role/{id}/update', [RoleController::class, 'update_role']);
Route::put('/role/{id}/delete', [RoleController::class, 'delete_role']);

//Permissions   

Route::get('/permissions', [RoleController::class, 'get_permissions']);

//get permissions status

Route::get('/role/order/statuses/permissions', [RoleController::class, 'get_permissions_orders_statuses']);


//cars   

Route::get('/cars', [CarController::class, 'index']);
Route::post('/car/new', [CarController::class, 'new_car']);
Route::post('/car/{id}/update', [CarController::class, 'update_car']);
Route::post('/car/{id}/delete', [CarController::class, 'update_car']);

//city   

Route::get('/cities', [CityController::class, 'index']);
Route::post('/city/new', [CityController::class, 'new_city']);
Route::put('/city/{id}/update', [CityController::class, 'update_city']);
Route::put('/city/{id}/delete', [CityController::class, 'delete_city']);

//city Codes

Route::get('/cities/codes', [CitiesCodeController::class, 'index']);
Route::post('/city/code/new', [CitiesCodeController::class, 'new_city_code']);
Route::put('/city/code/{id}/update', [CitiesCodeController::class, 'update_city_code']);
Route::put('/city/code/{id}/delete', [CitiesCodeController::class, 'delete_city_code']);


//orders   

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/order/{id}/get', [OrderController::class, 'get_order']);

Route::get('/orders/bons', [OrderController::class, 'orders_for_bons']);
Route::post('/order/new', [OrderController::class, 'new_order']);
Route::post('/order/{id}/update', [OrderController::class, 'update_order']);
Route::post('/order/{id}/delete', [OrderController::class, 'update_order']);


//order status   

Route::get('/order/status', [OrderStatusController::class, 'index']);
Route::get('/order/status/{id}/get', [OrderStatusController::class, 'get_order_status']);
Route::post('/order/status/new', [OrderStatusController::class, 'new_order_status']);
Route::put('/order/status/{id}/update', [OrderStatusController::class, 'update_order_status']);
Route::put('/order/status/{id}/delete', [OrderStatusController::class, 'delete_order_status']);

//order phases   

Route::get('/order/phases', [OrderPhaseController::class, 'index']);


//pickups status   

Route::get('/pickups_status', [PickupStatusController::class, 'index']);
Route::post('/pickups_status/new', [PickupStatusController::class, 'new_pickups_status']);
Route::post('/pickups_status/{id}/update', [PickupStatusController::class, 'update_pickups_status']);
Route::post('/pickups_status/{id}/delete', [PickupStatusController::class, 'update_pickups_status']);


//reclamations status   

Route::get('/reclamations_status', [ReclamationStatusController::class, 'index']);
Route::post('/reclamation_status/new', [ReclamationStatusController::class, 'new_reclamation_status']);
Route::post('/reclamation_status/{id}/update', [ReclamationStatusController::class, 'update_reclamation_status']);
Route::post('/reclamation_status/{id}/delete', [ReclamationStatusController::class, 'update_reclamation_status']);

//reclamations   

Route::get('/reclamations', [ReclamationController::class, 'index']);
Route::get('/reclamation/{id}/get', [ReclamationController::class, 'get_reclamation']);
Route::post('/reclamation/new', [ReclamationController::class, 'new_reclamation']);
Route::put('/reclamation/{id}/update', [ReclamationController::class, 'update_reclamation']);
Route::put('/reclamation/{id}/delete', [ReclamationController::class, 'delete_reclamation']);

//reclamations type 

Route::get('/reclamations/types', [ReclamationsTypeController::class, 'index']);


//pickups   

Route::get('/pickups', [PickupController::class, 'index']);
Route::post('/pickup/new', [PickupController::class, 'new_pickup']);
Route::post('/pickup/{id}/update', [PickupController::class, 'update_pickup']);
Route::post('/pickup/{id}/delete', [PickupController::class, 'update_pickup']);


//warehouses   

Route::get('/warehouses', [WarehouseController::class, 'index']);
Route::post('/warehouse/new', [WarehouseController::class, 'new_warehouse']);
Route::post('/warehouse/{id}/update', [WarehouseController::class, 'update_warehouse']);
Route::post('/warehouse/{id}/delete', [WarehouseController::class, 'update_warehouse']);

//  products 

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{i}/get', [ProductController::class, 'get_product']);
Route::post('/product/new', [ProductController::class, 'new_product']);
Route::put('/product/{id}/update', [ProductController::class, 'update_product']);
Route::put('/product/{id}/delete', [ProductController::class, 'delete_product']);

//  products categories

Route::get('/product/categories', [ProductCategoryController::class, 'index']);

//  products types

Route::get('/product/types', [ProductTypeController::class, 'index']);

//  bon delivery 

Route::get('/bons/delivery', [BonDeliveryController::class, 'index']);
Route::get('/bon/delivery/{id}/get', [BonDeliveryController::class, 'get_bon_delivery']);
Route::post('/bon/delivery/new', [BonDeliveryController::class, 'new_bon_delivery']);
Route::put('/bon/delivery/{id}/valid/update', [BonDeliveryController::class, 'update_bon_delivery_valid']);
Route::put('/bon/delivery/{id}/update', [BonDeliveryController::class, 'update_bon_delivery']);
Route::put('/bon/delivery/{id}/delete', [BonDeliveryController::class, 'delete_bon_delivery']);

//  bon pickup 

Route::get('/bons/pickups', [BonPickupController::class, 'index']);
Route::get('/bon/pickup/{id}/get', [BonPickupController::class, 'get_bon_pickup']);
Route::post('/bon/pickup/new', [BonPickupController::class, 'new_bon_pickup']);
Route::put('/bon/pickup/{id}/valid/update', [BonPickupController::class, 'update_bon_pickup_valid']);
Route::put('/bon/pickup/{id}/update', [BonPickupController::class, 'update_bon_pickup']);
Route::put('/bon/pickup/{id}/delete', [BonPickupController::class, 'delete_bon_pickup']);

//  bon stock 

Route::get('/bons/stocks', [BonStockController::class, 'index']);
Route::post('/bons/stock/new', [BonStockController::class, 'new_bon_stock']);
Route::put('/bon/stock/{id}/valid/update', [BonStockController::class, 'update_bon_stock_valid']);
Route::put('/bons/stock/{id}/update', [BonStockController::class, 'update_bon_stock']);
Route::put('/bons/stock/{id}/delete', [BonStockController::class, 'update_bon_stock']);

//  bon return Client

Route::get('/bons/customers/returns', [BonReturnController::class, 'index']);
Route::get('/bon/customer/return/{id}/get', [BonReturnController::class, 'get_bon_return']);
Route::post('/bon/customer/return/new', [BonReturnController::class, 'new_bon_return']);
Route::put('/bon/{id}/customer/return/valid/update', [BonReturnController::class, 'update_bon_return_valid']);
Route::put('/bon/{id}/customer/return/update', [BonReturnController::class, 'update_bon_return']);
Route::put('/bon/{id}/customer/return/delete', [BonReturnController::class, 'delete_bon_return']);


//  bon return Livreur

Route::get('/bons/delivery/returns', [BonReturnsDeliveryController::class, 'index']);
Route::get('/bon/{id}/delivery/return/get', [BonReturnsDeliveryController::class, 'get_bon_return']);
Route::post('/bon/delivery/return/new', [BonReturnsDeliveryController::class, 'new_bon_return']);
Route::put('/bon/{id}/delivery/return/valid/update', [BonReturnsDeliveryController::class, 'update_bon_return_valid']);
Route::put('/bon/{id}/delivery/return/update', [BonReturnsDeliveryController::class, 'update_bon_return']);
Route::put('/bon/{id}/delivery/return/delete', [BonReturnsDeliveryController::class, 'delete_bon_return']);









});



//user auth
    Route::post('/customer/register', [CustomerController::class, 'register']);
    
    Route::post('/login', [UtilisateurController::class, 'login']);
    



    // Routes accessible only to administrators
Route::group(['middleware' => 'role:administrator'], function () {
    // Your administrator routes here
});

// Routes accessible only to customers
Route::group(['middleware' => 'role:customer'], function () {
    // Your customer routes here
});

// Routes accessible only to delivery agents
Route::group(['middleware' => 'role:delivery_agent'], function () {
    // Your delivery agent routes here
});

