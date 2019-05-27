<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');


    /**
     * 测试路由
     */
    $router->get('jun/test', 'Idc\MachineRoomController@test');
    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');
    $router->get('vtest', 'Others\ContactsController@vtest');
    $router->get('ctset', 'Others\ContactsController@test');
    $router->get('test', 'Others\StaffController@test');
    $router->get('contacts/maillist', 'Others\ContactsController@test');
    $router->get('ip/test', 'Idc\IpsController@test');
    $router->get('account/test', 'Hr\AccountController@test');
    $router->post('test/search', 'Search\DbSearchController@doSearch');//测试数据库搜索路由
    $router->get('tranUnder','Business\UnderController@tranUnder');//下架状态的同步

    // 显示通讯录
    $router->get('staff/staff_list', 'Hr\EmployeeInformationController@showEmployee');//内部员工通讯录

    /**
     * 联系人
     */
    Route::group([
        'prefix' => 'contacts',
    ], function (Router $router) {
        $router->get('list', 'Others\ContactsController@index');//展示系统联系人信息（主要用于前端首页客户联系业务员使用）
        $router->post('insert', 'Others\ContactsController@insert');//写入联系人信息
        $router->get('alert', 'Others\ContactsController@edit');//获取需修改联系人信息
        $router->post('alerting', 'Others\ContactsController@doEdit');//修改联系人信息
        $router->post('remove', 'Others\ContactsController@deleted');//删除联系人信息
    });

    /**
     * IP
     */
    Route::group([
        'prefix' => 'ips',
    ], function (Router $router) {
        $router->get('index', 'Idc\IpsController@index');//展示IP信息
        $router->post('insert', 'Idc\IpsController@insert');//写入IP信息
        $router->get('alert', 'Idc\IpsController@edit');//获取需编辑的IP信息
        $router->post('alerting', 'Idc\IpsController@doEdit');//编辑IP信息
        $router->post('remove', 'Idc\IpsController@deleted');//删除IP信息
        $router->get('machineroom', 'Idc\IpsController@machineroom');//获取机房信息
        $router->get('showIdcIps', 'DefenseIp\StoreController@showIdcIps');//获取ip资源库未使用ip
    });

    //测试路由
    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');

    /**
     * 前端显示
     */
    Route::group([
        'prefix' => 'show',
    ], function (Router $router) {
        $router->get('/search', 'Show\GlobalSearchController@index');
        $router->get('/user_list', 'Show\UserController@index');//用户列表
        $router->get('/user_link_list', 'Show\LinkUserController@index');
        $router->get('/hr/employeeManagement', 'Show\EmployeeManagementController@index');
        $router->get('/system_info', 'Show\SystemInformationController@index');
        $router->get('/hr/departmentview', 'Show\DepartmentController@index');
        $router->get('/hr/position', 'Show\PositionController@index');
        $router->get('/hr/usermanagement', 'Show\UserManagementController@index');
        Route::group([
            'middleware' => 'CheckStaff',
        ], function (Router $router) {
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

            $router->get('/crm/clientele', 'Show\ClienteleController@index');
            $router->get('/business', 'Show\BusinessController@index');
            $router->get('/checkbusiness', 'Show\CheckBusinessController@index');
            $router->get('/business/order', 'Show\OrderController@index');
            $router->get('/business/clienteleInfo', 'Show\OrderController@clienteleInfo');
            $router->get('/finance', 'Show\FinanceController@index');
            $router->get('/statisticalPerformance', 'Show\StatisticalPerformanceController@index');
            $router->get('/whitelist', 'Show\WhitelistController@index');
            $router->get('/work_order', 'Show\WorkOrderTypeController@index');


            $router->get('/checkrecharge', 'Show\RechargeController@index');
            $router->get('/reviewRecharge', 'Show\ReviewRechargeController@index');
            $router->get('/pwdDepartment', 'Show\WorkOrderTypeController@getPwdDepart');
            $router->get('/work_order_type', 'Show\WorkOrderTypeController@index');
            $router->get('/defenseip', 'Show\DefenseipController@index');
            $router->get('/defensePackage', 'Show\DefensePackageController@index');
            $router->get('/defenseBusines', 'Show\DefenseBusinessController@index');
            $router->get('/defenseipReview', 'Show\DefenseipReviewController@index');
            $router->get('/dismissalReview', 'Show\DismissalReviewController@index');
            $router->get('/disposal', 'Show\DisposalController@index');
            $router->get('/disposalHistory', 'Show\DisposalHistoryController@index');
            $router->get('/machineProcessing', 'Show\MachineProcessingController@index');
            $router->get('/newTypeManagement', 'Show\NewTypeManagementController@index');
            $router->get('/defenseBusinesReview', 'Show\DefenseBusinessReviewController@index');
            $router->get('/customerStatistics', 'Show\CustomerStatisticsController@index');
            $router->get('/businessStatistics', 'Show\BusinessStatisticsController@index');
            $router->get('/overlay', 'Show\OverlayController@index');
            $router->get('/overlayBusiness', 'Show\OverlayBusinessController@index');

        });

    });

    /**
     * HR
     */
    Route::group([
        'prefix' => 'hr',
    ], function (Router $router) {
        /**
         * 账户
         */
        $router->get('show_account', 'Hr\AccountController@showAccount');//展示后台账户
        $router->get('show_self', 'Hr\AccountController@personalAccount');//展示个人账户
        $router->post('edit_self', 'Hr\AccountController@editAccount');//编辑个人账户
        $router->post('reset_pass', 'Hr\AccountController@resetAccountPass');//重置个人账户密码
        $router->post('confirm_pass', 'Hr\AccountController@confirmPass');//确认密码
        $router->post('old_pass', 'Hr\AccountController@oldPass');//获取旧密码
        $router->post('edit_pass', 'Hr\AccountController@editPassword');//修改密码
        $router->post('insert_account', 'Hr\AccountController@insertAccount');//新建后台管理账户
        /**
         * 员工信息
         */
        $router->get('show_employee', 'Hr\EmployeeInformationController@showEmployee');//展示员工信息
        $router->post('insert_employee', 'Hr\EmployeeInformationController@insertEmployee');//写入员工信息
        $router->post('edit_employee', 'Hr\EmployeeInformationController@editEmployee');//编辑员工信息
        $router->post('delete_employee', 'Hr\EmployeeInformationController@deleteEmployee');//删除员工信息（开发预留）
        $router->get('employee_personal', 'Hr\EmployeeInformationController@employeePersonal');//修改个人信息
        $router->get('department', 'Hr\EmployeeInformationController@department');//获取部门数据
        $router->post('jobs', 'Hr\EmployeeInformationController@jobs');//获取职位数据
        /**
         * 部门
         */
        $router->get('show_depart', 'Hr\DepartmentController@showDepart');//展示部门数据
        $router->post('insert_depart', 'Hr\DepartmentController@insertDepart');//写入部门数据
        $router->post('edit_depart', 'Hr\DepartmentController@editDepart');//修改部门数据
        $router->post('delete_depart', 'Hr\DepartmentController@deleteDepart');//删除部门数据（开发预留）
        /**
         * 职位
         */
        $router->get('show_jobs', 'Hr\JobsController@showJobs');//展示职位数据
        $router->post('insert_jobs', 'Hr\JobsController@insertJobs');//写入职位数据
        $router->post('edit_jobs', 'Hr\JobsController@editJobs');//修改职位数据
        $router->post('delete_jobs', 'Hr\JobsController@deleteJobs');//删除职位数据（开发预留）
        $router->get('depart', 'Hr\JobsController@depart');//获取部门数据

    });


    /**
     * 机房管理
     */
    Route::group([
        'prefix' => 'machine_room',
    ], function (Router $router) {
        $router->get('showByAjax', 'Idc\MachineRoomController@showByAjax');//获取机房列表
        $router->get('show_select_list_by_ajax', 'Idc\MachineRoomController@showSelectListByAjax');//单独获取机房名字及id
        $router->post('storeByAjax', 'Idc\MachineRoomController@storeByAjax');//添加机房
        $router->post('destroyByAjax', 'Idc\MachineRoomController@destroyByAjax');//删除机房
        $router->post('updateByAjax', 'Idc\MachineRoomController@updateByAjax');//编辑机房
    });

    /**
     * 机柜管理
     */
    Route::group([
        'prefix' => 'cabinet',
    ], function (Router $router) {
        $router->get('showByAjax', 'Idc\CabinetController@showByAjax');//获取机柜列表
        $router->post('storeByAjax', 'Idc\CabinetController@storeByAjax');//添加机柜
        $router->post('destroyByAjax', 'Idc\CabinetController@destroyByAjax');//删除机柜
        $router->post('updateByAjax', 'Idc\CabinetController@updateByAjax');//编辑机柜

    });

    /**
     * 消息管理
     */
    Route::group([
        'prefix' => 'news',
    ], function (Router $router) {
        $router->get('news_list', 'News\NewsController@index');//消息列表
        $router->post('insert', 'News\NewsController@insert');//发布消息
        $router->post('edit', 'News\NewsController@edit');//编辑消息
        $router->post('deleted', 'News\NewsController@deleted'); //删除消息
        $router->get('get_news_type', 'News\NewsController@get_news_type');//获取消息类型列表
        $router->get('test', 'News\NewsController@form');//上传图片接口
    });

    /**
     * 新闻类型接口
     */
    Route::group([
        'prefix' => 'news_type',
    ], function (Router $router) {
        $router->get('show', 'News\NewsTypeController@showNewsType');//获取消息类型
        $router->post('insert', 'News\NewsTypeController@insertNewsType');//添加消息类型
        $router->post('edit', 'News\NewsTypeController@editNewsType');//编辑消息类型
        $router->post('delete', 'News\NewsTypeController@deleteNewsType');//删除消息类型
    });

    /**
     * cpu资源库管理
     */
    Route::group([
        'prefix' => 'cpu',
    ], function (Router $router) {
        $router->get('cpu_list', 'Idc\CpuController@index');//获取cpu列表
        $router->post('insert', 'Idc\CpuController@insert');//添加cpu
        $router->post('deleted', 'Idc\CpuController@deleted');//删除cpu
        $router->post('edit', 'Idc\CpuController@edit');//编辑cpu
    });

    /**
     * harddisk资源库管理
     */
    Route::group([
        'prefix' => 'harddisk',
    ], function (Router $router) {
        $router->get('harddisk_list', 'Idc\HarddiskController@index');//获取硬盘列表
        $router->post('insert', 'Idc\HarddiskController@insert');//添加硬盘
        $router->post('edit', 'Idc\HarddiskController@edit');//编辑
        $router->post('deleted', 'Idc\HarddiskController@deleted');//删除
    });

    /**
     * 内存资源库管理
     */
    Route::group([
        'prefix' => 'memory',
    ], function (Router $router) {
        $router->get('memory_list', 'Idc\MemoryController@index');//内存列表
        $router->post('insert', 'Idc\MemoryController@insert');//添加内存
        $router->post('edit', 'Idc\MemoryController@edit');//编辑内存
        $router->post('deleted', 'Idc\MemoryController@deleted');//删除内存信息
    });

    /**
     * 机器资源库
     */
    Route::group([
        'prefix' => 'machine',
    ], function (Router $router) {
        $router->get('showmachine', 'Idc\MachineController@showMachine');//展示机器信息
        $router->post('insertmachine', 'Idc\MachineController@insertMachine');//写入机器信息
        $router->post('editmachine', 'Idc\MachineController@editMachine');//修改机器信息
        $router->post('deletemachine', 'Idc\MachineController@deleteMachine');//删除机器信息（开发预留）
        $router->get('machineroom', 'Idc\MachineController@machineroom');//获取机房数据
        $router->get('cabinets', 'Idc\MachineController@cabinets');//获取机柜数据
        $router->get('ips', 'Idc\MachineController@ips');//获取IP数据
        $router->get('excel_template', 'Idc\MachineController@excelTemplate');//下载机器的批量模板
        $router->post('handle_excel', 'Idc\MachineController@handleExcel');//上传机器的批量添加数据
        // $router->get('tran_status','Idc\MachineController@tranStatus');//转换机器状态，非必要请勿打开使用
    });

    /**
     * 机器统计模块
     */
    Route::group([
        'prefix' => 'statistics',
    ], function (Router $router) {
        $router->get('statisticsList', 'Statistics\StatisticsController@index');//机器统计
    });

    /**
     * 业绩统计
     */
    Route::group([
        'prefix' => 'pfmStatistics',
    ], function (Router $router) {
        $router->get('pfmBig', 'Statistics\PfmStatisticsController@index');//财务用业绩统计
        $router->get('pfmSmall', 'Statistics\PfmStatisticsController@pfmSmall');//业务员用业绩统计
        $router->get('test', 'Statistics\PfmStatisticsController@test');//计算时间区间内消费额度
    });

    /**
     * 充值情况统计
     */
    Route::group([
        'prefix' => 'rechargeStatistics',
    ], function (Router $router) {
        $router->get('list', 'Statistics\RechargeStatisticsController@index');//充值统计
        $router->get('getFlow', 'Statistics\RechargeStatisticsController@getFlow');//充值统计
    });


    /**
     * 工单问答
     */
    Route::group([
        'prefix' => 'work_answer',
    ], function (Router $router) {
        $router->get('show', 'Work\WorkAnswerController@showWorkAnswer');//获取工单问答的信息
        $router->post('insert', 'Work\WorkAnswerController@insertWorkAnswer');//写入工单问答新内容
    });

    /**
     * 工单接口
     */
    Route::group([
        'prefix' => 'workorder',
    ], function (Router $router) {
        $router->get('show', 'Work\WorkOrderController@showWorkOrder');//展示工单
        $router->get('department', 'Work\WorkOrderController@department');//工单转发部门时使用
        $router->post('insert', 'Work\WorkOrderController@insertWorkOrder');//提交工单
        $router->post('edit', 'Work\WorkOrderController@editWorkOrder');//修改工单状态和转发部门
        $router->post('delete', 'Work\WorkOrderController@deleteWorkOrder');//删除工单（开发预留）
        $router->get('work_types', 'Work\WorkOrderController@workTypes');//获取工单类型
    });

    /**
     * 工单类型
     */
    Route::group([
        'prefix' => 'worktype',
    ], function (Router $router) {
        $router->get('show', 'Work\WorkTypeController@showWorkType');//获取工单类型
        $router->post('insert', 'Work\WorkTypeController@insertWorkType');//写入工单类型数据
        $router->post('edit', 'Work\WorkTypeController@editWorkType');//修改工单类型
        $router->post('delete', 'Work\WorkTypeController@deleteWorkType');//删除工单类型（开发预留）
    });

    /**
     * 白名单管理
     */
    Route::group([
        'prefix' => 'whitelist',
    ], function (Router $router) {
        $router->get('checkIP', 'Work\WhiteListController@checkIP');//检测IP使用状态并获取该IP使用客户信息接口
        $router->get('show', 'Work\WhiteListController@showWhiteList');//根据审核状态显示白名单申请单接口
        $router->post('insert', 'Work\WhiteListController@insertWhiteList');//生成白名单申请单
        $router->post('check', 'Work\WhiteListController@checkWhiteList');//白名单申请单 审核接口
        $router->post('delete', 'Work\WhiteListController@deleteWhiteList');//白名单申请单 删除接口
        $router->get('skipBeian', 'Work\WhiteListController@skipBeian');//跳转到工信部备案
    });


    /**
     * 业务模块
     * 业务相关接口(业务员下订单/手动生成业务编号及业务数据并且提供财务人员/管理人员/业务员查看数据等)
     */
    Route::group([
        'prefix' => 'business',
    ], function (Router $router) {
        // 业务

        $router->get('machineroom', 'Business\BusinessController@machineroom');//新购业务时获取机房
        $router->get('selectmachine', 'Business\BusinessController@selectMachine');//新购业务时选择机器
        $router->get('selectcabinet', 'Business\BusinessController@selectCabinet');//新购业务时选择机柜
        $router->post('insert', 'Business\BusinessController@insertBusiness');//产生业务
        $router->get('security', 'Business\BusinessController@securityBusiness');//信安查看业务
        $router->post('check', 'Business\BusinessController@checkBusiness');//信安审核业务
        $router->post('enable', 'Business\BusinessController@enableBusiness');//启用业务（开发预留）
        $router->get('showbusiness', 'Business\BusinessController@showBusiness');//展示业务数据
        $router->post('deletebusiness', 'Business\BusinessController@deleteBusiness');//删除业务数据（开发预留）

        // 订单
        $router->get('finance', 'Business\OrdersController@financeOrders');//财务查看订单
        $router->post('clerk', 'Business\OrdersController@clerkOrders');//业务员查看订单
        $router->post('resource', 'Business\OrdersController@resource');//获取资源

        $router->post('renewresource', 'Business\OrdersController@renewResource');//续费
        $router->get('all_renew', 'Business\OrdersController@allRenew');//获取业务下续费的资源
        $router->get('show_renew_order', 'Business\OrdersController@showRenewOrder');//展示续费的订单
        $router->get('renew_pay', 'Business\OrdersController@renewPay');//支付续费的订单
        //$router->get('tran_orders','Business\OrdersController@tranOrders');

        $router->post('insertresource', 'Business\OrdersController@insertResource');//新购资源
        // $router->post('renewresource', 'Business\OrdersController@renewResource');//续费资源

        $router->post('deleteorders', 'Business\OrdersController@deleteOrders');//删除订单（开发预留）
        //客户信息
        $router->get('admin_customer', 'Business\CustomerController@adminCustomer');//获取客户信息
        $router->post('pull_black', 'Business\CustomerController@pullBlackCustomer');//修改客户账户状态
        $router->post('reset_password', 'Business\CustomerController@resetPassword');//后台替客户重置密码

        $router->post('recharge', 'Business\RechargeController@rechargeByAdmin');//后台业务员替客户充值
        $router->get('showAuditRechargeBig', 'Business\RechargeController@showAuditRechargeBig');//财务用业务员手动充值记录
        $router->get('showAuditRechargeSmall', 'Business\RechargeController@showAuditRechargeSmall');//业务员用业务员手动充值记录
        $router->post('auditRecharge', 'Business\RechargeController@auditRecharge');//财务用审核手动充值
        $router->get('showRecharge', 'Business\RechargeController@getRecharge');//查看自己用户的充值流水信息
        $router->get('showAllRecharge', 'Business\RechargeController@getAllRecharge');//财务用查看所有客户充值流水信息接口
        //$router->get('editAuditRecharge', 'Business\RechargeController@editAuditRecharge');//财务用更改充值审核单接口


        /**
         * 转移业务员相关
         */
        $router->get('depart', 'Business\CustomerController@depart');//获取部门
        $router->post('select_clerk', 'Business\CustomerController@selectClerk');//选择业务员
        $router->post('edit_clerk', 'Business\CustomerController@editClerk');//修改业务员
        $router->post('insert_clerk', 'Business\CustomerController@insertClerk');//绑定业务员

        $router->post('payOrderByAdmin', 'Business\OrdersController@payOrderByAdmin');//业务员替客户支付

        /**
         * 信安录入业务时进行相关信息的获取
         */
        $router->get('select_sales','Business\BusinessController@selectSalesman');//选择业务员
        $router->post('select_users','Business\BusinessController@selectUsers');//选择客户
        $router->post('security_insert','Business\BusinessController@securityInsertBusiness');//录入业务
        $router->post('security_order','Business\OrdersController@securityInsertOrders');//录入资源

        /**
         * IDC业务数据统计相关
         */
        $router->get('new_business','Business\BusinessController@newBusiness');//新增业务统计
        $router->get('under_business','Business\BusinessController@underBusiness');//下架业务统计
        $router->get('new_registration','Business\BusinessController@newRegistration');//新注册统计
        $router->get('changemarket','Business\BusinessController@changeMarket');//业务统计

        $router->post('register', 'Business\CustomerController@registerClerk');//后台替客户注册账号

        /**
         * 更换资源相关
         */
        $router->post('getresource','Business\OrdersController@getResource');//获取可更换的资源
        $router->post('change','Business\OrdersController@changeResource');//提交更换信息
        $router->post('checkchange','Business\OrdersController@checkChange');//审核更换记录
        $router->get('getchange','Business\OrdersController@getChange');//获取更换记录
        // $router->get('getorders','Business\OrdersController@getOrders');//获取相关的可更换的订单
    });


    /**
     * 消息系统
     */
    Route::group([
        'prefix' => 'message',
    ], function (Router $router) {

        /**
         * 续费提醒
         */
        Route::group([
            'prefix' => 'deadline',
        ], function (Router $router) {
            $router->post('sendUser', 'Message\DeadlineController@sendUser');//单独用户
            $router->post('sendAllUser', 'Message\DeadlineController@sendAllUser');//手动发送所有用户
        });

    });


    /**
     * 查找过期资源
     */
    Route::group([
        'prefix' => 'overdue',
    ], function (Router $router) {
        $router->get('showOverdueCabinet', 'Overdue\OverdueController@showOverdueCabinet');//查找5天内到期的机柜
        $router->get('showOverdueMachine', 'Overdue\OverdueController@showOverdueMachine');//查找5天内到期的机器
        $router->get('showOverdueRes', 'Overdue\OverdueController@showOverdueRes');//查找5天内到期资源
        $router->get('showUnpaidMachine', 'Overdue\OverdueController@showUnpaidMachine'); //查找未支付使用中的机器
        $router->get('showXiaJiaMachine', 'Overdue\OverdueController@showXiaJiaMachine');//查找最近下架的机器
        $router->get('showUnpaidCabinet', 'Overdue\OverdueController@showUnpaidCabinet');//查找未支付使用中的机柜
        $router->get('showXiaJiaRes', 'Overdue\OverdueController@showXiaJiaRes');//查找下架资源
        $router->get('showOverdueResDet', 'Overdue\OverdueController@showOverdueResDet');//按类型查找接近过期资源
        $router->get('showTrialDefenseIp', 'Overdue\OverdueController@showTrialDefenseIp');//查找试用中高防IP业务
        $router->get('showUnpaidIdcOrder', 'Overdue\OverdueController@showUnpaidIdcOrder');//查找未付款的idc业务订单

        //以下是因权限问题,分出来给管理层看的
        $router->get('showOverdueCabinetX', 'Overdue\OverdueController@showOverdueCabinetX');//查找5天内到期的机柜
        $router->get('showOverdueMachineX', 'Overdue\OverdueController@showOverdueMachineX');//查找5天内到期的机器
        $router->get('showOverdueResX', 'Overdue\OverdueController@showOverdueResX');//查找5天内到期资源
        $router->get('showUnpaidMachineX', 'Overdue\OverdueController@showUnpaidMachineX'); //查找未支付使用中的机器
        $router->get('showXiaJiaMachineX', 'Overdue\OverdueController@showXiaJiaMachineX');//查找最近下架的机器
        $router->get('showUnpaidCabinetX', 'Overdue\OverdueController@showUnpaidCabinetX');//查找未支付使用中的机柜
        $router->get('showXiaJiaResX', 'Overdue\OverdueController@showXiaJiaResX');//查找下架资源
        $router->get('showOverdueResDetX', 'Overdue\OverdueController@showOverdueResDetX');//按类型查找接近过期资源
        $router->get('showTrialDefenseIpX', 'Overdue\OverdueController@showTrialDefenseIpX');//查找试用中高防IP业务
        $router->get('showUnpaidIdcOrderX', 'Overdue\OverdueController@showUnpaidIdcOrderX');//查找未付款的idc业务订单
    });

    /**
     * 高防IP
     */
    Route::group([
        'prefix' => 'defenseip',
    ], function (Router $router) {

        /**
         * 资源
         */
        Route::group([
            'prefix' => 'store',
        ], function (Router $router) {
            $router->post('insert', 'DefenseIp\StoreController@insert');//高防IP添加
            // $router->post('insertVer2', 'DefenseIp\StoreController@insertVer2');//高防IP添加
            $router->get('del', 'DefenseIp\StoreController@del');//删除
            $router->post('edit', 'DefenseIp\StoreController@edit'); //编辑
            $router->get('show', 'DefenseIp\StoreController@show');//获取资源信息
            $router->get('form', 'DefenseIp\StoreController@form');//获取资源信息
        });

        /**
         * 套餐
         */
        Route::group([
            'prefix' => 'package',
        ], function (Router $router) {
            $router->post('insert', 'DefenseIp\PackageController@insert');//添加套餐
            $router->get('del', 'DefenseIp\PackageController@del');//删除套餐
            $router->post('edit', 'DefenseIp\PackageController@edit');//编辑套餐
            $router->get('show', 'DefenseIp\PackageController@show'); //获取套餐信息
            $router->get('showById', 'DefenseIp\PackageController@showById'); //获取套餐信息
        });


        /**
         *  高防IP业务管理
         */
        Route::group([
            'prefix' => 'remove',
        ], function (Router $router) {
            $router->get('selectExpireList', 'DefenseIp\RemoveController@selectExpireList');  //查询过期业务
            $router->get('showBusinessByPackage', 'DefenseIp\RemoveController@showBusinessByPackage');  //查询某套餐所有业务
            $router->get('showBusinessByCustomer', 'DefenseIp\RemoveController@showBusinessByCustomer');  //查询某用户所有业务
            $router->get('showBusinessBySite', 'DefenseIp\RemoveController@showBusinessBySite');  //查询某机房所有业务
            $router->get('getStatistics', 'DefenseIp\RemoveController@getStatistics');//查询高防的流量图

            $router->get('subExamine', 'DefenseIp\RemoveController@subExamine');//提交审核
            $router->get('goExamine', 'DefenseIp\RemoveController@goExamine');//进行审核
            $router->get('showExamine', 'DefenseIp\RemoveController@showExamine');//查看正在审核的下架申请

            $router->post('setTarget', 'DefenseIp\SetController@setTarget');//配置目标IP


        });

        /**
         *  高防ip后台购买
         */
        Route::group([
            'prefix' => 'order',
        ], function (Router $router) {
            $router->get('buyNowByAdmin', 'DefenseIp\BusinessController@buyNowByAdmin');  //后台替客户购买高防ip,提交试用申请
            $router->get('renewByAdmin', 'DefenseIp\BusinessController@renewByAdmin');  //后台替客户续费高防ip
            $router->get('upExamineDefenseIp', 'DefenseIp\BusinessController@upExamineDefenseIp');  //审核后台的高防试用申请
            $router->get('showUpExamineDefenseIp', 'DefenseIp\BusinessController@showUpExamineDefenseIp');  //获取待审核的高防试用申请

        });


    });

    /**
     * 申请下架
     */
    Route::group([
        'prefix' => 'under',
    ], function (Router $route) {
        $route->post('apply_under', 'Business\UnderController@applyUnder');//申请下架
        $route->get('under_history', 'Business\UnderController@underHistory');//下架历史记录
        $route->post('do_under', 'Business\UnderController@doUnder');//操作下架
        $route->get('show_apply_under', 'Business\UnderController@showApplyUnder');//展示申请记录
        $route->get('depart', 'Business\UnderController@department');//转发机房
        $route->get('random_code', 'Business\UnderController@randomCode');//转发机房
    });

    /**
     * excel
     */
    Route::group([
        'prefix' => 'excel',
    ], function (Router $route) {
        Route::get('export', 'Excel\ExcelController@export');    //Excel导出
        Route::get('import', 'Excel\ExcelController@import');    //Excel导入
    });

    /**
     * 数据转移
     *因关联问题,注意顺序
     */
    Route::group([
        'prefix' => 'dataTransfer',
    ], function (Router $router) {
        $router->get('transMachineroom', 'DataTransfer\DataTransferController@transMachineroom');//转移机房数据
        $router->get('transAdminUser', 'DataTransfer\DataTransferController@transAdminUser');//转移后台人员数据
        $router->get('transIp', 'DataTransfer\DataTransferController@transIp');//转移IP资源数据
        $router->get('transCabinet', 'DataTransfer\DataTransferController@transCabinet');//转移IP资源数据
        $router->get('transMachine', 'DataTransfer\DataTransferController@transMachine');//转移IP资源数据
        $router->get('transCustomer', 'DataTransfer\DataTransferController@transCustomer');//转移IP资源数据
        $router->get('transNews', 'DataTransfer\DataTransferController@transNews');//转移文章
    });

    /**
     *  测试
     */
    Route::group([
        'prefix' => 'test',
    ], function (Router $router) {
        $router->get('test', 'DefenseIp\BusinessController@test');  //查询过期业务


    });


    /**
     *微信端
     */
    Route::group([
        'prefix' => 'wechat',
        'middleware' => 'web',
    ], function (Router $router) {
        $router->get('test', 'Wechat\WechatController@test');  //微信端测试接口
        $router->get('test2', 'Wechat\WechatController@test2');  //微信端测试接口

    });


    /**
     * 上传文件管理
     */
    Route::group([
        'prefix' => 'upload',
    ], function (Router $router) {
        $router->post('putImages', 'News\UploadController@putImages');//上传图片接口
        $router->get('showImages', 'News\UploadController@showImages');//展示上传图片接口
        $router->get('del', 'News\UploadController@del');//展示上传图片接口
    });

    /**
     * 客户用户管理
     */
    Route::group([
        'prefix' => 'users',
    ], function (Router $router) {

        $router->post('getUserInfo', 'TzUsers\InfoController@getUserInfo');//修改用户QQ、手机、备注等信息
        $router->post('updateUserInfo', 'TzUsers\InfoController@updateUserInfo');//更新客户信息

    });

    /**
     * 友情链接管理
     */
    Route::group([
        'prefix' => 'links',
    ], function (Router $router) {
        $router->get('show', 'News\LinksController@show');//获取友情链接
        $router->post('insert', 'News\LinksController@insert');//添加友情链接
        $router->post('edit', 'News\LinksController@edit');//编辑友情链接
        $router->post('del', 'News\LinksController@del');//删除友情链接
    });

    /**
     * 促销活动管理
     */
    Route::group([
        'prefix' => 'promotion',
    ], function (Router $router) {
        $router->get('show', 'News\PromotionController@show');//获取友情链接
        $router->post('insert', 'News\PromotionController@insert');//添加友情链接
        $router->post('edit', 'News\PromotionController@edit');//编辑友情链接
        $router->post('del', 'News\PromotionController@del');//删除友情链接
    });

    /**
     * 叠加包
     */
    Route::group([
        'prefix' => 'overlay',
    ], function (Router $router) {
        $router->get('show', 'DefenseIp\OverlayController@show');//展示叠加包资源
        $router->post('insert', 'DefenseIp\OverlayController@insert');//添加叠加包资源
        $router->post('edit', 'DefenseIp\OverlayController@edit');//编辑叠加包资源
        $router->post('del', 'DefenseIp\OverlayController@del');//删除叠加包资源

        $router->post('buyNowByAdmin', 'DefenseIp\OverlayController@buyNowByAdmin');//购买叠加包接口
        $router->get('showBelong', 'DefenseIp\OverlayController@showBelong');//展示某客户所属叠加包接口
        $router->post('useOverlayToDIP', 'DefenseIp\OverlayController@useOverlayToDIP');//将叠加包使用到高防ip接口
        $router->post('useOverlayToIDC', 'DefenseIp\OverlayController@useOverlayToIDC');//将叠加包使用到IDC业务接口
    });


});


