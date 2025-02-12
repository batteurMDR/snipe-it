<?php

use Illuminate\Http\Request;

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


Route::group(['prefix' => 'v1','namespace' => 'Api', 'middleware' => 'auth:api'], function () {


    Route::get('/', function() {

        return response()->json(
            [
                'status' => 'error',
                'message' => '404 endpoint not found. This is the base URL for the API and does not return anything itself. Please check the API reference at https://snipe-it.readme.io/reference to find a valid API endpoint.',
                'payload' => null,
            ], 404);
    });




    Route::group(['prefix' => 'account'], function () {

        Route::get('requestable/hardware',
            [
                'as' => 'api.assets.requestable',
                'uses' => 'AssetsController@requestable'
            ]
        );

        Route::get('requests',
            [
                'as' => 'api.assets.requested',
                'uses' => 'ProfileController@requestedAssets'
            ]
        );

    });

    /*--- Accessories API ---*/    
    Route::group(['prefix' => 'accessories'], function () {

        Route::get('{accessory}/checkedout',
            [
                'as' => 'api.accessories.checkedout',
                'uses' => 'AccessoriesController@checkedout'
            ]
        );

        Route::get('selectlist',
            [
                'as' => 'api.accessories.selectlist',
                'uses'=> 'AccessoriesController@selectlist'
            ]
        );
    });

    // Accessories group
    Route::resource('accessories', 'AccessoriesController',
        ['names' =>
            [
                'index' => 'api.accessories.index',
                'show' => 'api.accessories.show',
                'update' => 'api.accessories.update',
                'store' => 'api.accessories.store',
                'destroy' => 'api.accessories.destroy'
            ],
            'except' => ['create', 'edit'],
            'parameters' => ['accessory' => 'accessory_id']
        ]
    );

    // Accessories resource

    Route::group(['prefix' => 'accessories'], function () {

        Route::get('{accessory}/checkedout',
            [
                'as' => 'api.accessories.checkedout',
                'uses' => 'AccessoriesController@checkedout'
            ]
        );

        Route::post('{accessory}/checkout',
            [
                'as' => 'api.accessories.checkout',
                'uses' => 'AccessoriesController@checkout'
            ]
        );

        Route::post('{accessory}/checkin',
            [
                'as' => 'api.accessories.checkin',
                'uses' => 'AccessoriesController@checkin'
            ]
        );

    }); // Accessories group


    /*--- Categories API ---*/

    Route::group(['prefix' => 'categories'], function () {

        Route::get('{item_type}/selectlist',
            [
                'as' => 'api.categories.selectlist',
                'uses' => 'CategoriesController@selectlist'
            ]
        );

    });

    // Categories group
    Route::resource('categories', 'CategoriesController',
        [
            'names' =>
                [
                    'index' => 'api.categories.index',
                    'show' => 'api.categories.show',
                    'store' => 'api.categories.store',
                    'update' => 'api.categories.update',
                    'destroy' => 'api.categories.destroy'
                ],
            'except' => ['edit', 'create'],
            'parameters' => ['category' => 'category_id']
        ]
    ); // Categories resource


    /*--- Companies API ---*/

    Route::get( 'companies/selectlist',  [
        'as' => 'companies.selectlist',
        'uses' => 'CompaniesController@selectlist'
    ]);


    // Companies resource
    Route::resource('companies', 'CompaniesController',
        [
            'names' =>
                [
                    'index' => 'api.companies.index',
                    'show' => 'api.companies.show',
                    'store' => 'api.companies.store',
                    'update' => 'api.companies.update',
                    'destroy' => 'api.companies.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['company' => 'company_id']
        ]
    ); // Companies resource


    /*--- Departments API ---*/

    Route::group(['prefix' => 'departments'], function () {


        Route::get('selectlist',
            [
                'as' => 'api.departments.selectlist',
                'uses' => 'DepartmentsController@selectlist'
            ]
        );
    }); // Departments group



    Route::resource('departments', 'DepartmentsController',
        [
            'names' =>
                [
                    'index' => 'api.departments.index',
                    'show' => 'api.departments.show',
                    'store' => 'api.departments.store',
                    'update' => 'api.departments.update',
                    'destroy' => 'api.departments.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['department' => 'department_id']
        ]
    ); // Departments resource


    /*--- Components API ---*/

    Route::group(['prefix' => 'components'], function () {

        Route::get('{component}/assets',
            [
                'as' =>'api.components.assets',
                'uses' => 'ComponentsController@getAssets',
            ]
        );

        Route::post('{component}/checkout',
            [
                'as' =>'api.components.checkout',
                'uses' => 'ComponentsController@checkout',
            ]
        );

        Route::post('{component}/checkin',
        [
            'as' =>'api.components.checkin',
            'uses' => 'ComponentsController@checkin',
        ]
    );

    }); // Components group
    

    Route::resource('components', 'ComponentsController',
        [
            'names' =>
                [
                    'index' => 'api.components.index',
                    'show' => 'api.components.show',
                    'store' => 'api.components.store',
                    'update' => 'api.components.update',
                    'destroy' => 'api.components.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['component' => 'component_id']
        ]
    ); // Components resource

   


    /*--- Consumables API ---*/
    Route::get('consumables/selectlist',
        [
            'as' => 'api.consumables.selectlist',
            'uses'=> 'ConsumablesController@selectlist'
        ]
    );

    Route::resource('consumables', 'ConsumablesController',
        [
            'names' =>
                [
                    'index' => 'api.consumables.index',
                    'show' => 'api.consumables.show',
                    'store' => 'api.consumables.store',
                    'update' => 'api.consumables.update',
                    'destroy' => 'api.consumables.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['consumable' => 'consumable_id']
        ]
    ); // Consumables resource

    Route::group(['prefix' => 'consumables'], function () {
        Route::get('view/{id}/users',
            [
                'as' => 'api.consumables.showUsers',
                'uses' => 'ConsumablesController@getDataView'
            ]
        );

        Route::post('{consumable}/checkout',
            [
                'as' => 'api.consumables.checkout',
                'uses' => 'ConsumablesController@checkout'
            ]
        );
    });

    /*--- Depreciations API ---*/

    Route::resource('depreciations', 'DepreciationsController',
        [
            'names' =>
                [
                    'index' => 'api.depreciations.index',
                    'show' => 'api.depreciations.show',
                    'store' => 'api.depreciations.store',
                    'update' => 'api.depreciations.update',
                    'destroy' => 'api.depreciations.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['depreciation' => 'depreciation_id']
        ]
    ); // Depreciations resource


    /*--- Fields API ---*/

    Route::resource('fields', 'CustomFieldsController', [
        'names' => [
            'index' => 'api.customfields.index',
            'show' => 'api.customfields.show',
            'store' => 'api.customfields.store',
            'update' => 'api.customfields.update',
            'destroy' => 'api.customfields.destroy'
        ],
        'except' => [ 'create', 'edit' ],
        'parameters' => [ 'field' => 'field_id' ]
    ]);

    Route::group(['prefix' => 'fields'], function () {
        Route::post('fieldsets/{id}/order',
            [
                'as' => 'api.customfields.order',
                'uses' => 'CustomFieldsController@postReorder'
            ]
        );
        Route::post('{field}/associate',
            [
                'as' => 'api.customfields.associate',
                'uses' => 'CustomFieldsController@associate'
            ]
        );
        Route::post('{field}/disassociate',
            [
                'as' => 'api.customfields.disassociate',
                'uses' => 'CustomFieldsController@disassociate'
            ]
        );
    }); // Fields group


    /*--- Fieldsets API ---*/

    Route::group(['prefix' => 'fieldsets'], function () {
        Route::get('{fieldset}/fields',
            [
                'as' => 'api.fieldsets.fields',
                'uses' => 'CustomFieldsetsController@fields'
            ]
        );
        Route::get('/{fieldset}/fields/{model}',
            [
                'as' => 'api.fieldsets.fields-with-default-value',
                'uses' => 'CustomFieldsetsController@fieldsWithDefaultValues'
            ]
        );
    });

    Route::resource('fieldsets', 'CustomFieldsetsController',
        [
            'names' =>
                [
                    'index' => 'api.fieldsets.index',
                    'show' => 'api.fieldsets.show',
                    'store' => 'api.fieldsets.store',
                    'update' => 'api.fieldsets.update',
                    'destroy' => 'api.fieldsets.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['fieldset' => 'fieldset_id']
        ]
    ); // Custom fieldset resource


    /*--- Groups API ---*/

    Route::resource('groups', 'GroupsController',
        [
            'names' =>
                [
                    'index' => 'api.groups.index',
                    'show' => 'api.groups.show',
                    'store' => 'api.groups.store',
                    'update' => 'api.groups.update',
                    'destroy' => 'api.groups.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['group' => 'group_id']
        ]
    ); // Groups resource


    /*--- Hardware API ---*/

    Route::group(['prefix' => 'hardware'], function () {
    
        Route::get('{asset_id}/licenses',  [
            'as' => 'api.assets.licenselist',
            'uses' => 'AssetsController@licenses'
        ]);
    
        Route::get('{asset_id}/files',  [
            'as' => 'api.assets.filelist',
            'uses' => 'AssetsController@files'
        ]);
    
        Route::get('{asset_id}/file/{file_id}',  [
            'as' => 'api.assets.filedownload',
            'uses' => 'AssetsController@download'
        ]);
        
        Route::get( 'bytag/{tag}',  [
            'as' => 'assets.show.bytag',
            'uses' => 'AssetsController@showByTag'
        ]);

        Route::get('bytag/{any}',
            [
                'as' => 'api.assets.show.bytag',
                'uses' => 'AssetsController@showByTag'
            ]
        )->where('any', '.*');


        Route::get('byserial/{any}',
            [
                'as' => 'api.assets.show.byserial',
                'uses' => 'AssetsController@showBySerial'
            ]
         )->where('any', '.*');
        

        Route::get( 'selectlist',  [
            'as' => 'assets.selectlist',
            'uses' => 'AssetsController@selectlist'
        ]);

        Route::get('audit/{audit}', [
            'as' => 'api.asset.to-audit',
            'uses' => 'AssetsController@index'
        ]);


        Route::post('audit', [
            'as' => 'api.asset.audit',
            'uses' => 'AssetsController@audit'
        ]);

        Route::post('{asset_id}/checkout',
            [
                'as' => 'api.assets.checkout',
                'uses' => 'AssetsController@checkout'
            ]
        );

        Route::post('{asset_id}/checkin',
            [
                'as' => 'api.assets.checkin',
                'uses' => 'AssetsController@checkin'
            ]
        );

        Route::post('{asset_id}/restore',
            [
                'as' => 'api.assets.restore',
                'uses' => 'AssetsController@restore'
            ]
        );

        Route::post('{asset_id}/destroy',
            [
                'as' => 'api.assets.destroy',
                'uses' => 'AssetsController@destroy'
            ]
        );

    });

    /*--- Asset Maintenances API ---*/
    Route::resource('maintenances', 'AssetMaintenancesController',
        [
            'names' =>
                [
                    'index' => 'api.maintenances.index',
                    'show' => 'api.maintenances.show',
                    'store' => 'api.maintenances.store',
                    'update' => 'api.maintenances.update',
                    'destroy' => 'api.maintenances.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['maintenance' => 'maintenance_id']
        ]
    ); // Consumables resource


    Route::resource('hardware', 'AssetsController',
        [
            'names' =>
                [
                    'index' => 'api.assets.index',
                    'show' => 'api.assets.show',
                    'store' => 'api.assets.store',
                    'update' => 'api.assets.update',
                    'destroy' => 'api.assets.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['asset' => 'asset_id']
        ]
    ); // Hardware resource


    /*--- Imports API ---*/

    Route::resource('imports', 'ImportController',
        [
            'names' =>
                [
                    'index' => 'api.imports.index',
                    'show' => 'api.imports.show',
                    'store' => 'api.imports.store',
                    'update' => 'api.imports.update',
                    'destroy' => 'api.imports.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['import' => 'import_id']
        ]
    ); // Imports resource

    Route::group(['prefix' => 'imports'], function () {

        Route::post('process/{import}',
            [
                'as' => 'api.imports.importFile',
                'uses'=> 'ImportController@process'
            ]
        );
    }); // Imports group




    /*--- Licenses API ---*/

    Route::group(['prefix' => 'licenses'], function () {
        Route::get('selectlist',
            [
                'as' => 'api.licenses.selectlist',
                'uses'=> 'LicensesController@selectlist'
            ]
        );

    }); // Licenses group

    Route::resource('licenses', 'LicensesController',
        [
            'names' =>
                [
                    'index' => 'api.licenses.index',
                    'show' => 'api.licenses.show',
                    'store' => 'api.licenses.store',
                    'update' => 'api.licenses.update',
                    'destroy' => 'api.licenses.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['license' => 'license_id']
        ]
    ); // Licenses resource

    Route::resource('licenses.seats', 'LicenseSeatsController',
        [
            'names' =>
                [
                    'index' => 'api.licenses.seats.index',
                    'show' => 'api.licenses.seats.show',
                    'update' => 'api.licenses.seats.update'
                ],
            'except' => ['create', 'edit', 'destroy', 'store'],
            'parameters' => ['licenseseat' => 'licenseseat_id']
        ]
    ); // Licenseseats resource

    /*--- Locations API ---*/

    Route::group(['prefix' => 'locations'], function () {

        Route::get('{location}/users',
            [
                'as'=>'api.locations.viewusers',
                'uses'=>'LocationsController@getDataViewUsers'
            ]
        );

        Route::get('{location}/assets',
            [
                'as'=>'api.locations.viewassets',
                'uses'=>'LocationsController@getDataViewAssets'
            ]
        );

        // Do we actually still need this, now that we have an API?
        Route::get('{location}/check',
            [
                'as' => 'api.locations.check',
                'uses' => 'LocationsController@show'
            ]
        );

        Route::get( 'selectlist',  [
            'as' => 'locations.selectlist',
            'uses' => 'LocationsController@selectlist'
        ]);
    }); // Locations group



    Route::resource('locations', 'LocationsController',
        [
            'names' =>
                [
                    'index' => 'api.locations.index',
                    'show' => 'api.locations.show',
                    'store' => 'api.locations.store',
                    'update' => 'api.locations.update',
                    'destroy' => 'api.locations.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['location' => 'location_id']
        ]
    ); // Locations resource




    /*--- Manufacturers API ---*/

    Route::group(['prefix' => 'manufacturers'], function () {

        Route::get( 'selectlist',  [
            'as' => 'manufacturers.selectlist',
            'uses' => 'ManufacturersController@selectlist'
        ]);
    }); // Locations group


    Route::resource('manufacturers', 'ManufacturersController',
        [
            'names' =>
                [
                    'index' => 'api.manufacturers.index',
                    'show' => 'api.manufacturers.show',
                    'store' => 'api.manufacturers.store',
                    'update' => 'api.manufacturers.update',
                    'destroy' => 'api.manufacturers.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['manufacturer' => 'manufacturer_id']
        ]
    ); // Manufacturers resource


    /*--- Models API ---*/

    Route::group(['prefix' => 'models'], function () {

        Route::get('assets',
            [
                'as' => 'api.models.assets',
                'uses'=> 'AssetModelsController@assets'
            ]
        );
        Route::get('selectlist',
            [
                'as' => 'api.models.selectlist',
                'uses'=> 'AssetModelsController@selectlist'
            ]
        );
    }); // Models group


    Route::resource('models', 'AssetModelsController',
        [
            'names' =>
                [
                    'index' => 'api.models.index',
                    'show' => 'api.models.show',
                    'store' => 'api.models.store',
                    'update' => 'api.models.update',
                    'destroy' => 'api.models.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['model' => 'model_id']
        ]
    ); // Models resource




    /*--- Settings API ---*/
    Route::get('settings/ldaptest', [
        'as' => 'api.settings.ldaptest',
        'uses' => 'SettingsController@ldapAdSettingsTest'
    ]);

    Route::post('settings/purge_barcodes', [
        'as' => 'api.settings.purgebarcodes',
        'uses' => 'SettingsController@purgeBarcodes'
    ]);

    Route::get('settings/login-attempts', [
        'middleware' => ['auth', 'authorize:superuser'],
        'as' => 'api.settings.login_attempts',
        'uses' => 'SettingsController@showLoginAttempts'
    ]);


    Route::post('settings/ldaptestlogin', [
        'as' => 'api.settings.ldaptestlogin',
        'uses' => 'SettingsController@ldaptestlogin'
    ]);

    Route::post('settings/slacktest', [
        'as' => 'api.settings.slacktest',
        'uses' => 'SettingsController@slacktest'
    ]);

    Route::post(
        'settings/mailtest',
        [
            'as'  => 'api.settings.mailtest',
            'uses' => 'SettingsController@ajaxTestEmail'
    ]);


    Route::resource('settings', 'SettingsController',
        [
            'names' =>
                [
                    'index' => 'api.settings.index',
                    'store' => 'api.settings.store',
                    'show' => 'api.settings.show',
                    'update' => 'api.settings.update'
                ],
            'except' => ['create', 'edit', 'destroy'],
            'parameters' => ['setting' => 'setting_id']
        ]
    ); // Settings resource




    /*--- Status Labels API ---*/


    Route::group(['prefix' => 'statuslabels'], function () {

        // Pie chart for dashboard
        Route::get('assets',
            [
                'as' => 'api.statuslabels.assets.bytype',
                'uses' => 'StatuslabelsController@getAssetCountByStatuslabel'
            ]
        );

        Route::get('{statuslabel}/assetlist',
            [
                'as' => 'api.statuslabels.assets',
                'uses' => 'StatuslabelsController@assets'
            ]
        );

        Route::get('{statuslabel}/deployable',
            [
                'as' => 'api.statuslabels.deployable',
                'uses' => 'StatuslabelsController@checkIfDeployable'
            ]
        );


    });

    Route::resource('statuslabels', 'StatuslabelsController',
        [
            'names' =>
                [
                    'index' => 'api.statuslabels.index',
                    'store' => 'api.statuslabels.store',
                    'show' => 'api.statuslabels.show',
                    'update' => 'api.statuslabels.update',
                    'destroy' => 'api.statuslabels.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['statuslabel' => 'statuslabel_id']
        ]
    );

    // Status labels group


    /*--- Suppliers API ---*/
    Route::group(['prefix' => 'suppliers'], function () {

        Route::get('list',
            [
                'as'=>'api.suppliers.list',
                'uses'=>'SuppliersController@getDatatable'
            ]
        );

        Route::get('selectlist',
            [
                'as' => 'api.suppliers.selectlist',
                'uses' => 'SuppliersController@selectlist'
            ]
        );
    }); // Suppliers group


    Route::resource('suppliers', 'SuppliersController',
        [
            'names' =>
                [
                    'index' => 'api.suppliers.index',
                    'show' => 'api.suppliers.show',
                    'store' => 'api.suppliers.store',
                    'update' => 'api.suppliers.update',
                    'destroy' => 'api.suppliers.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['supplier' => 'supplier_id']
        ]
    ); // Suppliers resource




    /*--- Users API ---*/


    Route::group([ 'prefix' => 'users' ], function () {

        Route::post('two_factor_reset',
            [
                'as' => 'api.users.two_factor_reset',
                'uses' => 'UsersController@postTwoFactorReset'
            ]
        );

        Route::get('me',
            [
                'as' => 'api.users.me',
                'uses' => 'UsersController@getCurrentUserInfo'
            ]
        );

        Route::get('list/{status?}',
            [
                'as' => 'api.users.list',
                'uses' => 'UsersController@getDatatable'
            ]
        );

        Route::get('selectlist',
            [
                'as' => 'api.users.selectlist',
                'uses' => 'UsersController@selectList'
            ]
        );

        Route::get('{user}/assets',
            [
                'as' => 'api.users.assetlist',
                'uses' => 'UsersController@assets'
            ]
        );


        Route::get('{user}/accessories',
            [
                'as' => 'api.users.accessorieslist',
                'uses' => 'UsersController@accessories'
            ]
        );


        Route::get('{user}/licenses',
            [
                'as' => 'api.users.licenselist',
                'uses' => 'UsersController@licenses'
            ]
        );

        Route::post('{user}/upload',
            [
                'as' => 'api.users.uploads',
                'uses' => 'UsersController@postUpload'
            ]
        );
    }); // Users group

    Route::resource('users', 'UsersController',
        [
            'names' =>
                [
                    'index' => 'api.users.index',
                    'show' => 'api.users.show',
                    'store' => 'api.users.store',
                    'update' => 'api.users.update',
                    'destroy' => 'api.users.destroy'
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['user' => 'user_id']
        ]
    ); // Users resource


    Route::get(
        'reports/activity',
        [ 'as' => 'api.activity.index', 'uses' => 'ReportsController@index' ]
    );

    Route::get(
        'reports/depreciation',
        [ 
            'as' => 'api.depreciation-report.index', 
            'uses' => 'AssetsController@index' 
        ]
    );

    /*--- Kits API ---*/

    Route::resource('kits', 'PredefinedKitsController',
        [
            'names' =>
                [
                    'index' => 'api.kits.index',
                    'show' => 'api.kits.show',
                    'store' => 'api.kits.store',
                    'update' => 'api.kits.update',
                    'destroy' => 'api.kits.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['kit' => 'kit_id']
        ]
    );


    Route::group([ 'prefix' => 'kits/{kit_id}' ], function () {

        // kit licenses
        Route::get('licenses', 
            [
                'as' => 'api.kits.licenses.index',
                'uses' => 'PredefinedKitsController@indexLicenses',
            ]
        );
        
        Route::post('licenses', 
            [
                'as' => 'api.kits.licenses.store',
                'uses' => 'PredefinedKitsController@storeLicense',
            ]
        );
        
        Route::put('licenses/{license_id}', 
            [
                'as' => 'api.kits.licenses.update',
                'uses' => 'PredefinedKitsController@updateLicense',
            ]
        );

        Route::delete('licenses/{license_id}', 
            [
                'as' => 'api.kits.licenses.destroy',
                'uses' => 'PredefinedKitsController@detachLicense',
            ]
        );
        
        // kit models
        Route::get('models', 
            [
                'as' => 'api.kits.models.index',
                'uses' => 'PredefinedKitsController@indexModels',
            ]
        );
        
        Route::post('models', 
            [
                'as' => 'api.kits.models.store',
                'uses' => 'PredefinedKitsController@storeModel',
            ]
        );
        
        Route::put('models/{model_id}', 
            [
                'as' => 'api.kits.models.update',
                'uses' => 'PredefinedKitsController@updateModel',
            ]
        );

        Route::delete('models/{model_id}', 
            [
                'as' => 'api.kits.models.destroy',
                'uses' => 'PredefinedKitsController@detachModel',
            ]
        );

        // kit accessories
        Route::get('accessories', 
            [
                'as' => 'api.kits.accessories.index',
                'uses' => 'PredefinedKitsController@indexAccessories',
            ]
        );
        
        Route::post('accessories', 
            [
                'as' => 'api.kits.accessories.store',
                'uses' => 'PredefinedKitsController@storeAccessory',
            ]
        );
        
        Route::put('accessories/{accessory_id}', 
            [
                'as' => 'api.kits.accessories.update',
                'uses' => 'PredefinedKitsController@updateAccessory',
            ]
        );

        Route::delete('accessories/{accessory_id}', 
            [
                'as' => 'api.kits.accessories.destroy',
                'uses' => 'PredefinedKitsController@detachAccessory',
            ]
        );

        // kit consumables
        Route::get('consumables', 
            [
                'as' => 'api.kits.consumables.index',
                'uses' => 'PredefinedKitsController@indexConsumables',
            ]
        );
        
        Route::post('consumables', 
            [
                'as' => 'api.kits.consumables.store',
                'uses' => 'PredefinedKitsController@storeConsumable',
            ]
        );
        
        Route::put('consumables/{consumable_id}', 
            [
                'as' => 'api.kits.consumables.update',
                'uses' => 'PredefinedKitsController@updateConsumable',
            ]
        );

        Route::delete('consumables/{consumable_id}', 
            [
                'as' => 'api.kits.consumables.destroy',
                'uses' => 'PredefinedKitsController@detachConsumable',
            ]
        );

    }); // kits group

    Route::fallback(function(){
        return response()->json(
            [
                'status' => 'error',
                'message' => '404 endpoint not found. Please check the API reference at https://snipe-it.readme.io/reference to find a valid API endpoint.',
                'payload' => null,
            ], 404);
    });

});


