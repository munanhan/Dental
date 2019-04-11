<template>
    <!-- 该菜单只支持两级，因为需求是要求两级 -->
    <div ref="navMenu">
        <ul class="menu">
            <!-- <li class="menu-item"  > -->

            <template v-for="(item, index) in menuData">
                <li
                    v-if="!item.url"
                    :key="item.name + index + item.url"
                    class="menu-item has-child"
                    @mouseenter="subShowHandler(item, true)"
                    @mouseleave="subShowHandler(item, false)"
                    :ref="'nav' + item.id"
                >
                    <div class="menu-content">
                        <i
                            class="menu-icon"
                            :class="item.icon"
                        ></i>
                        <div class="menu-text">{{item.name}}</div>

                        <transition name="fade">
                            <div
                                v-show="item.children.length && item.showChild"
                                :style="{
                                    left: item.childLeft,
                                    top: item.childTop,                                    
                                }"
                                class="sub-content"
                            >
                                <ul class="sub-menu">
                                    <router-link
                                        v-for="(citem, index) in item.children"
                                        :key="citem.name + index + citem.url"
                                        tag="li"
                                        :to="citem.url"
                                        class="sub-menu-item"
                                        exact-active-class="active theme-nav-active-font-color"
                                    >
                                        <div class="menu-content">
                                            <i
                                                class="menu-icon"
                                                :class="citem.icon"
                                            ></i>
                                            <div class="menu-text">{{citem.name}}</div>
                                        </div>
                                    </router-link>
                                </ul>
                            </div>
                        </transition>

                    </div>
                </li>

                <router-link
                    tag="li"
                    v-if="item.url"
                    :key="item.name + index + item.url"
                    :to="item.url"
                    class="menu-item"
                    exact-active-class="active theme-nav-active-font-color"
                >
                    <div class="menu-content">
                        <i
                            class="menu-icon"
                            :class="item.icon"
                        ></i>
                        <div class="menu-text">{{item.name}}</div>
                    </div>
                </router-link>
            </template>

            <!-- </li> -->

            <!-- <li class="menu-item active">
                <div class="menu-content">
                    <i class="menu-icon fa fa-user"></i>
                    <div class="menu-text">首页</div>
                </div>
            </li>
            <li class="menu-item">
                <div class="menu-content">
                    <i class="menu-icon fa fa-user"></i>
                    <div class="menu-text">66666</div>
                </div>
            </li>

            <li class="menu-item">
                <div class="menu-content">
                    <i class="menu-icon fa fa-user"></i>
                    <div class="menu-text">66666</div>
                </div>
            </li>

            <li class="menu-item">
                <div class="menu-content">
                    <i class="menu-icon fa fa-user"></i>
                    <div class="menu-text">66666</div>
                </div>
            </li>

            <li class="menu-item">
                <div class="menu-content">
                    <i class="menu-icon fa fa-user"></i>
                    <div class="menu-text">66666</div>
                </div>
            </li> -->
        </ul>

        <!-- <template v-for="(item, index) in menu">
            <template v-if="item.children && item.children.length">
                <el-submenu
                    :key="item.name + index + item.url"
                    :index="item.name + index + item.url"
                >
                    <template slot="title">
                        <span
                            class="menu-icon"
                            v-if="item.icon"
                        >
                            <i :class="item.icon"></i>
                        </span>
                        <span v-show="!collapse">
                            {{item.name}}
                        </span>
                    </template>

                    <menu-tree :menu="item.children"></menu-tree>
                </el-submenu>
            </template>

            <template v-if="!item.children">
                <el-menu-item
                    :key="item.name + index + item.url"
                    :index="item.url"
                >
                    <span
                        class="menu-icon"
                        v-if="item.icon"
                    >
                        <i :class="item.icon"></i>
                    </span>

                    <span v-show="!collapse">
                        {{item.name}}
                    </span>
                </el-menu-item>
            </template>
        </template> -->
    </div>
</template>

<script>
import { deepClone } from "@common/util";
export default {
    name: "MenuTree",
    props: {
        menu: {
            type: Array,
            default: () => []
        }
        // collapse: {
        //     type: Boolean,
        //     default: false
        // }
    },

    data() {
        return {
            menuData: []
        };
    },

    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeSubMenu();
        });
    },

    watch: {
        menu: {
            handler(newValue, oldValue) {
                let that = this,
                    cpData = deepClone(newValue);
                if (cpData.length) {
                    for (var i = 0; i < cpData.length; i++) {
                        var item = cpData[i];

                        if (item.children && item.children.length) {
                            item.showChild = false;
                            item.childTop = "0px";
                            item.childLeft = "0px";
                            item.zIndex = 3616;
                        }

                        // item.showChild = true;
                    }
                }

                that.menuData = cpData;
            },

            immediate: true
        }
    },

    methods: {
        subShowHandler(sub, flag) {
            let that = this;

            // debugger

            if (flag != sub.showChild) {
                sub.showChild = flag;
            }
        },

        resizeSubMenu() {
            let that = this,
                left = that.$refs.navMenu.offsetWidth;

            for (var i = 0; i < that.menuData.length; i++) {
                var item = that.menuData[i];

                if (item.children && item.children.length) {
                    item.childLeft = `${left}px`;

                    var rect = that.$refs[
                            "nav" + item.id
                        ][0].getBoundingClientRect(),
                        // whether the IE version is lower than 11
                        isIE = navigator.userAgent.indexOf("MSIE") != -1,
                        // fix ie document bounding top always 0 bug
                        rectTop =
                            isIE && element.tagName === "HTML"
                                ? -element.scrollTop
                                : rect.top;

                    item.childTop = `${rectTop}px`;
                }
            }
        }
    }
};
</script>
<style lang='less' scoped>
ul {
    padding: 0;
    margin: 0;
}

ul li {
    list-style: none;
    min-height: 80px;
}

.menu {
    text-align: center;

    .active {
        background-color: rgba(0, 0, 0, 0.1) !important;
    }

    .menu-item {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        color: #303133;

        &:hover {
            cursor: pointer;
            background-color: #c4c8d2;
        }

        .menu-content {
            .menu-icon {
                font-size: 24px;
                margin-bottom: 8px;
            }

            .menu-text {
                font-size: 16px;
            }

            .sub-content {
                position: fixed;
                z-index: 3600;
                padding-left: 8px;

                //二级菜单
                .sub-menu {
                    background-color: #eff1f6;
                    border: 1px solid #e3e3e3;
                    border-radius: 4px;
                    display: flex;
                    flex-wrap: wrap;
                    max-width: 270px;

                    .sub-menu-item {
                        width: 90px;
                        padding: 10px;
                        box-sizing: border-box;

                        &:hover {
                            cursor: pointer;
                            background-color: #c4c8d2;
                        }
                    }
                }
            }
        }
    }
}

.fade-enter-active,
.fade-leave-active {
    transition: all 0.2s;
    opacity: 1;
    transform: scale(1);
    transform-origin: top left;
}

.fade-enter, .fade-leave  /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    transform: scale(0);
}

// .menu-icon {
//     display: inline-block;
//     width: 28px;
//     margin-top: -2px;
//     margin-right: 14px;
//     // margin-left: 6px;
// }
</style>