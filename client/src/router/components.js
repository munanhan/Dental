//主的组件
const components = {
    //患者
    "/patient/Index": resolve =>
        require.ensure([], () => resolve(require("@views/patient/Index"))),

    //预约
    "/appointment/Index": resolve =>
        require.ensure([], () => resolve(require("@views/appointment/Index"))),

    //沟通
    "/communication/Index": resolve =>
        require.ensure([], () => resolve(require("@views/communication/Index"))),

    //统计
    "/statistics/Index": resolve =>
        require.ensure([], () => resolve(require("@views/statistics/Index"))),

    //商城
    "/shop/Index": resolve =>
        require.ensure([], () => resolve(require("@views/shop/Index"))),

    //客服
    "/custom_service/Index": resolve =>
        require.ensure([], () =>
            resolve(require("@views/custom_service/Index"))
        ),

    //库房
    "/warehouse/Index": resolve =>
        require.ensure([], () => resolve(require("@views/warehouse/Index"))),

    //回访
    "/return_visit/Index": resolve =>
        require.ensure([], () => resolve(require("@views/return_visit/Index"))),

    //短信
    "/message/Index": resolve =>
        require.ensure([], () => resolve(require("@views/message/Index"))),

    //问诊
    "/inquiry/Index": resolve =>
        require.ensure([], () => resolve(require("@views/inquiry/Index"))),

    //微官网
    "/micro_website/Index": resolve =>
        require.ensure([], () => resolve(require("@views/micro_website/Index"))),

    //支出
    "/expenditure/Index": resolve =>
        require.ensure([], () => resolve(require("@views/expenditure/Index"))),

    //消毒
    "/disinfect/Index": resolve =>
        require.ensure([], () => resolve(require("@views/disinfect/Index"))),

    //考勤
    "/attendance/Index": resolve =>
        require.ensure([], () => resolve(require("@views/attendance/Index"))),

    //回收
    "/recovery/Index": resolve =>
        require.ensure([], () => resolve(require("@views/recovery/Index"))),

    //营销
    "/marketing/Index": resolve =>
        require.ensure([], () => resolve(require("@views/marketing/Index"))),

    //管理
    "/setting/Index": resolve =>
        require.ensure([], () => resolve(require("@views/setting/Index")))
};

export default components;
