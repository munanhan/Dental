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
                                v-show="item.showChild && item.children.length"
                                :style="{
                                    left: item.childLeft,
                                    top: item.childTop,                                    
                                }"
                                class="sub-content"
                            >
                                <ul class="sub-menu theme-nav">
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
        </ul>
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

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeSubMenu);
        } else {
            window.attachEvent("bodyChange", that.resizeSubMenu);
        }
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
                            //一开始就展示子菜单，然后将左偏移到-100%，不显示，为了计算高度
                            item.height = 0;
                            item.showChild = true;
                            item.childTop = "0px";
                            item.childLeft = "-100%";
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

            if (flag != sub.showChild) {
                sub.showChild = flag;
            }
        },

        resizeSubMenu() {
            let that = this,
                left = that.$refs.navMenu.offsetWidth,
                bodyHeight = document.body.clientHeight;

            for (var i = 0; i < that.menuData.length; i++) {
                var item = that.menuData[i];

                if (item.children && item.children.length) {
                    var ele = that.$refs["nav" + item.id][0],
                        rect = ele.getBoundingClientRect(),
                        // whether the IE version is lower than 11
                        isIE = navigator.userAgent.indexOf("MSIE") != -1,
                        // fix ie document bounding top always 0 bug
                        rectTop =
                            isIE && element.tagName === "HTML"
                                ? -element.scrollTop
                                : rect.top;

                    //用于计算是否超出屏幕
                    var height =
                            item.height ||
                            ele.querySelector(".sub-content").offsetHeight,
                        lessHeight = bodyHeight - rectTop;

                    item.height = height;

                    if (lessHeight < height) {
                        //总可视高度减去容器的高度就知道要弹出的高度
                        rectTop = bodyHeight - height;
                    }

                    //----------------------

                    item.childLeft = `${left}px`;
                    item.childTop = `${rectTop}px`;
                    item.showChild = false;
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
        color: white;
        background-color: rgba(0, 0, 0, 0.24) !important;
    }

    .menu-item {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        cursor: pointer;

        &:hover {
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.2);
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
                    // background-color: #eff1f6;
                    border: 1px solid #e3e3e3;
                    border-radius: 8px;
                    display: flex;
                    flex-wrap: wrap;
                    max-width: 270px;
                    overflow: hidden;

                    .sub-menu-item {
                        width: 90px;
                        padding: 10px;
                        box-sizing: border-box;

                        &:hover {
                            cursor: pointer;
                            background-color: rgba(0, 0, 0, 0.2);
                        }
                    }
                }
            }
        }
    }
}

.fade-enter-active,
.fade-leave-active {
    opacity: 1;
    transform: scale(1, 1);
    transition: all 0.3s cubic-bezier(0.55, 0, 0.1, 1);
    transform-origin: top left;
}
.fade-enter,
.fade-leave-active {
    opacity: 0;
    transform: scale(0.45, 0.45);
}

// .fade-enter-active,
// .fade-leave-active {
//     transition: all 0.2s;
//     opacity: 1;
//     transform: scale(1);
//     transform-origin: top left;
// }

// .fade-enter, .fade-leave-to  /* .fade-leave-active below version 2.1.8 */ {
//     opacity: 0;
//     transform: scale(0);
// }
</style>