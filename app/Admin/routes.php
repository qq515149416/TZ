<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
   


    //Jun   个人测试用
    $router->get('jun/test', 'Idc\MachineRoomController@test');
    // 测试使用
    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');
    $router->get('ctset', 'Others\ContactsController@test');
    $router->get('test', 'Others\StaffController@test');
    $router->get('contacts/maillist', 'Others\ContactsController@test');
    $router->get('ip/test', 'Idc\IpsController@test');
    $router->get('account/test','Hr\AccountController@test');

    // 显示通讯录
    $router->get('staff/staff_list', 'Others\StaffController@index');

    // 联系人表
    Route::group([
        'prefix' => 'contacts',
    ],function(Router $router){
        $router->get('list', 'Others\ContactsController@index');
        $router->post('insert', 'Others\ContactsController@insert');
        $router->get('alert', 'Others\ContactsController@edit');
        $router->post('alerting', 'Others\ContactsController@doEdit');
        $router->post('remove', 'Others\ContactsController@deleted');
    });

//ip
    Route::group([
        'prefix' => 'ips',
    ],function(Router $router){
        $router->get('index', 'Idc\IpsController@index');
        $router->post('insert', 'Idc\IpsController@insert');
        $router->get('alert', 'Idc\IpsController@edit');
        $router->post('alerting', 'Idc\IpsController@doEdit');
        $router->post('remove', 'Idc\IpsController@deleted');
        $router->get('machineroom', 'Idc\IpsController@machineroom');
    });


    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');
    // 前端显示
    $router->get('/user_list', 'Show\UserController@index');
    $router->get('/user_link_list', 'Show\LinkUserController@index');
    $router->get('/machine_room/show', 'Show\TestController@index');
    $router->get('/machine_room/socket', 'Show\TestController@socket');
    $router->get('/resource/ip', 'Show\IpController@index');
    $router->get('/resource/machine_room', 'Show\MachineRoomController@index');
    $router->get('/resource/cpu', 'Show\CpuController@index');
    $router->get('/resource/harddisk', 'Show\HarddiskController@index');
    $router->get('/resource/memory', 'Show\MemoryController@index');
    $router->get('/resource/cabinet', 'Show\CabinetController@index');
    $router->get('/article', 'Show\NewController@index');
    $router->get('/resource/machinelibrary', 'Show\MachineLibraryController@index');
    $router->get('/hr/employeeManagement', 'Show\EmployeeManagementController@index');
    $router->get('/crm/clientele', 'Show\ClienteleController@index');
    $router->get('/business', 'Show\BusinessController@index');
    $router->get('/checkbusiness', 'Show\CheckBusinessController@index');
    $router->get('/business/order', 'Show\OrderController@index');
    $router->get('/finance', 'Show\FinanceController@index');
    $router->get('/statisticalPerformance', 'Show\StatisticalPerformanceController@index');
    $router->get('/whitelist', 'Show\WhitelistController@index');
    $router->get('/work_order_type', 'Show\WorkOrderTypeController@index');
    $router->get('/work_order', 'Show\WorkOrderTypeController@index');
    $router->get('/system_info', 'Show\SystemInformationController@index');
    $router->get('/hr/departmentview', 'Show\DepartmentController@index');
    $router->get('/hr/position', 'Show\PositionController@index');

//人事
    Route::group([
        'prefix' => 'hr',
    ],function(Router $router){
        /**
         * 账户
         */
        $router->get('show_account', 'Hr\AccountController@showAccount');
        $router->get('show_self', 'Hr\AccountController@personalAccount');
        $router->post('edit_self', 'Hr\AccountController@editAccount');
        $router->post('reset_pass', 'Hr\AccountController@resetAccountPass');
        $router->post('confirm_pass', 'Hr\AccountController@confirmPass');
        $router->post('old_pass', 'Hr\AccountController@oldPass');
        $router->post('edit_pass', 'Hr\AccountController@editPassword');
        $router->post('insert_account', 'Hr\AccountController@insertAccount');
        /**
         * 员工信息
         */
        $router->get('show_employee', 'Hr\EmployeeInformationController@showEmployee');
        $router->post('insert_employee', 'Hr\EmployeeInformationController@insertEmployee');
        $router->post('edit_employee', 'Hr\EmployeeInformationController@editEmployee');
        $router->post('delete_employee', 'Hr\EmployeeInformationController@deleteEmployee');
        $router->get('employee_personal', 'Hr\EmployeeInformationController@employeePersonal');
        $router->get('department', 'Hr\EmployeeInformationController@department');
        $router->post('jobs', 'Hr\EmployeeInformationController@jobs');
        /**
         * 部门
         */
        $router->get('show_depart','Hr\DepartmentController@showDepart');
        $router->post('insert_depart','Hr\DepartmentController@insertDepart');
        $router->post('edit_depart','Hr\DepartmentController@editDepart');
        $router->post('delete_depart','Hr\DepartmentController@deleteDepart');
        /**
         * 职位
         */
        $router->get('show_jobs','Hr\JobsController@showJobs');
        $router->post('insert_jobs','Hr\JobsController@insertJobs');
        $router->post('edit_jobs','Hr\JobsController@editJobs');
        $router->post('delete_jobs','Hr\JobsController@deleteJobs');
        $router->get('depart','Hr\JobsController@depart');
        
    });


    //机房管理
    Route::group([
        'prefix' => 'machine_room',
    ], function (Router $router) {
        $router->get('showByAjax', 'Idc\MachineRoomController@showByAjax');
        $router->get('show_select_list_by_ajax', 'Idc\MachineRoomController@showSelectListByAjax');
        $router->post('storeByAjax', 'Idc\MachineRoomController@storeByAjax');
        $router->post('destroyByAjax', 'Idc\MachineRoomController@destroyByAjax');
        $router->post('updateByAjax', 'Idc\MachineRoomController@updateByAjax');
    });

    //机柜管理   分组增删改查
    Route::group([
        'prefix' => 'cabinet',
    ], function (Router $router) {
        $router->get('showByAjax', 'Idc\CabinetController@showByAjax');
        $router->post('storeByAjax', 'Idc\CabinetController@storeByAjax');
        $router->post('destroyByAjax', 'Idc\CabinetController@destroyByAjax');
        $router->post('updateByAjax', 'Idc\CabinetController@updateByAjax');

    });

    //消息管理
    Route::group([
        'prefix' => 'news',
    ],function (Router $router) {
        $router->get('news_list', 'News\NewsController@index');
        $router->post('insert', 'News\NewsController@insert');
        $router->post('edit', 'News\NewsController@edit');
        $router->post('deleted', 'News\NewsController@deleted');
        $router->get('get_news_type', 'News\NewsController@get_news_type');
    });

    //cpu资源库管理
    Route::group([
        'prefix' => 'cpu',
    ],function (Router $router) {
        $router->get('cpu_list', 'Idc\CpuController@index');
        $router->post('insert', 'Idc\CpuController@insert');
        $router->post('deleted', 'Idc\CpuController@deleted');
        $router->post('edit', 'Idc\CpuController@edit');
    });

    //harddisk资源库管理
    Route::group([
        'prefix' => 'harddisk',
    ],function (Router $router) {
        $router->get('harddisk_list', 'Idc\HarddiskController@index');
        $router->post('insert', 'Idc\HarddiskController@insert');
        $router->post('edit', 'Idc\HarddiskController@edit');
        $router->post('deleted', 'Idc\HarddiskController@deleted');
    });

//内存资源库管理
    Route::group([
        'prefix' => 'memory',
    ],function (Router $router) {
        $router->get('memory_list', 'Idc\MemoryController@index');
        $router->post('insert', 'Idc\MemoryController@insert');
        $router->post('edit', 'Idc\MemoryController@edit');
        $router->post('deleted', 'Idc\MemoryController@deleted');
    });


    // 机器资源库
    Route::group([
        'prefix' => 'machine',
    ], function(Router $router){
        $router->get('showmachine', 'Idc\MachineController@showMachine');
        $router->post('insertmachine', 'Idc\MachineController@insertMachine');
        $router->post('editmachine', 'Idc\MachineController@editMachine');
        $router->post('deletemachine', 'Idc\MachineController@deleteMachine');
        $router->get('machineroom', 'Idc\MachineController@machineroom');
        $router->get('cabinets', 'Idc\MachineController@cabinets');
        $router->get('ips', 'Idc\MachineController@ips');
        $router->get('excel_template','Idc\MachineController@excelTemplate');
        $router->post('handle_excel','Idc\MachineController@handleExcel');
    });



    //统计模块
    Route::group([
        'prefix' => 'statistics',
    ],function (Router $router) {
        $router->post('statisticsList', 'Statistics\StatisticsController@index');
    });

    //业绩统计
    Route::group([
        'prefix' => 'pfmStatistics',
    ],function (Router $router) {
        $router->get('pfmStatisticsList', 'Statistics\PfmStatisticsController@index');
    });

     //充值情况统计
    Route::group([
        'prefix' => 'rechargeStatistics',
    ],function (Router $router) {
        $router->get('list', 'Statistics\RechargeStatisticsController@index');
    });


    //工单问答
    Route::group([
        'prefix' => 'work_answer',
    ],function(Router $router){
        $router->get('show','Work\WorkAnswerController@showWorkAnswer');
        $router->post('insert','Work\WorkAnswerController@insertWorkAnswer');
    });

    //工单接口
    Route::group([
        'prefix' => 'workorder',
    ],function(Router $router){
        $router->get('show','Work\WorkOrderController@showWorkOrder');
        $router->get('department','Work\WorkOrderController@department');
        $router->post('insert','Work\WorkOrderController@insertWorkOrder');
        $router->post('edit','Work\WorkOrderController@editWorkOrder');
        $router->post('delete','Work\WorkOrderController@deleteWorkOrder');
        $router->get('work_types','Work\WorkOrderController@workTypes');
    });

    //工单类型接口
    Route::group([
        'prefix' => 'worktype',
    ],function(Router $router){
        $router->get('show','Work\WorkTypeController@showWorkType');
        $router->post('insert','Work\WorkTypeController@insertWorkType');
        $router->post('edit','Work\WorkTypeController@editWorkType');
        $router->post('delete','Work\WorkTypeController@deleteWorkType');
    });

    // 白名单接口
    Route::group([
        'prefix' => 'whitelist',
    ],function(Router $router){
        $router->get('checkIP','Work\WhiteListController@checkIP');
        $router->get('show','Work\WhiteListController@showWhiteList');
        $router->post('insert','Work\WhiteListController@insertWhiteList');
        $router->post('check','Work\WhiteListController@checkWhiteList');
        $router->post('delete','Work\WhiteListController@deleteWhiteList');
    });

    // 业务相关接口(业务员下订单/手动生成业务编号及业务数据并且提供财务人员/管理人员/业务员查看数据等)
    Route::group([
        'prefix' => 'business',
    ],function(Router $router){
        // 业务
        $router->get('machineroom','Business\BusinessController@machineroom');
        $router->get('selectmachine','Business\BusinessController@selectMachine');
        $router->get('selectcabinet','Business\BusinessController@selectCabinet');
        $router->post('insert','Business\BusinessController@insertBusiness');
        $router->get('security','Business\BusinessController@securityBusiness');
        $router->post('check','Business\BusinessController@checkBusiness');
        $router->post('enable','Business\BusinessController@enableBusiness');
        $router->get('showbusiness','Business\BusinessController@showBusiness');
        $router->get('deletebusiness','Business\BusinessController@deleteBusiness');
        // 订单
        $router->post('finance','Business\OrdersController@financeOrders');
        $router->post('clerk','Business\OrdersController@clerkOrders');
        $router->post('resource','Business\OrdersController@resource');
        $router->post('insertresource','Business\OrdersController@insertResource');
        $router->post('renewresource','Business\OrdersController@renewResource');
        $router->get('deleteorders','Business\OrdersController@deleteOrders');
        //客户信息
        $router->get('admin_customer','Business\CustomerController@adminCustomer');
        $router->post('pull_black','Business\CustomerController@pullBlackCustomer');
        $router->post('reset_password','Business\CustomerController@resetPassword');

        $router->post('recharge','Business\CustomerController@rechargeByAdmin');
    });



    //发送信息
    Route::group([
        'prefix' => 'message',
    ], function (Router $router) {

        //
        Route::group([
            'prefix' => 'deadline',
        ], function (Router $router) {
            $router->post('sendUser','Message\DeadlineController@sendUser');        //单独用户
            $router->post('sendAllUser','Message\DeadlineController@sendAllUser');  //手动发送所有用户
        });

    });




     Route::group([
        'prefix' => 'overdue',
    ],function(Router $router){
        $router->get('showOverdueCabinet','Overdue\OverdueController@showOverdueCabinet');
        $router->get('showOverdueMachine','Overdue\OverdueController@showOverdueMachine');
        $router->get('showOverdueRes','Overdue\OverdueController@showOverdueRes');     
        $router->get('showUnpaidMachine','Overdue\OverdueController@showUnpaidMachine');
        $router->get('showXiaJiaMachine','Overdue\OverdueController@showXiaJiaMachine');
        $router->get('showUnpaidCabinet','Overdue\OverdueController@showUnpaidCabinet');
        $router->get('showXiaJiaRes','Overdue\OverdueController@showXiaJiaRes');
        $router->get('showOverdueResDet','Overdue\OverdueController@showOverdueResDet');
        
    }); 

});

