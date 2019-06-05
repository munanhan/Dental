export default {
    userInfo(state) {
        let user = state.user;
        return user || {};
    },

    //获取菜单
    menu(state) {
        let menu = state.menu;
        return menu || [];
    },

    // //功能权限
    // btn_act(state) {
    //     let act = state.btn_act;
    //     return act || {};
    // },

    //子菜单
    subMenu(state){
        let subMenu = state.subMenu;
        return subMenu || {};
    },

    chooseDatesub5(state) {
        let sub = state.chooseDate || '';
        return sub.substr(5).replace('-','.');
    }
}