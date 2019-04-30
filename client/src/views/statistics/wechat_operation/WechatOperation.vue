<template>
    <div class="wechat-operation">
        <el-row class="head">
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">昨日新增关注</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0/0</div>
                    <div class="head-button">昨日取消关注</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">总关注人数</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">新增微信预约</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">新增微信咨询</div>
                </div>
            </el-col>
        </el-row>

        <el-row class="trend">
            <div class="trend-title">
                <span class="chart-tip">&nbsp;</span>
                趋势图
            </div>
            <div class="tend-content">
                213213213123123
            </div>
        </el-row>
    </div>
</template>

<script>
import Base from "../Base";
export default {
    name: "WechatOperation",
    components: {},

    mixins: [Base],

    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {};
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        afterGetData(res) {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.wechat-operation {
    position: relative;
    height: 100%;
    box-sizing: border-box;
    background-color: #efefef;
    padding: 10px;

    .gray-border {
        border: 1px solid #e3e3e3;
    }

    .bg-white {
        background-color: white;
        box-shadow: 2px 2px 10px #888888;
        .gray-border;
    }

    .head {
        padding: 10px;
        height: 80px;
        line-height: 30px;
        display: flex;
        margin-bottom: 10px;
        
        .bg-white;

        .head-detail {
            font-size: 18px;
            border-right: 1px solid #e3e3e3;
            cursor: pointer;

            &:last-of-type {
                border-right: 0;
            }

            &:hover {
                .head-item {
                    .top,
                    .head-button {
                        color: @hover-color;
                    }
                }
            }

            .head-item {
                .top {
                    text-align: center;
                    font-size: 30px;
                }

                .head-button {
                    text-align: center;
                    transition: 0.2s all;
                }
            }
        }
    }

    .trend {
        .bg-white;

        .trend-title {
            color: @color;
            padding: 10px;
            .gray-border;

            .chart-tip {
                background-color: @color;
                margin-right: 5px;
            }
        }

        .tend-content{
            padding: 10px;
        }
    }
}
</style>