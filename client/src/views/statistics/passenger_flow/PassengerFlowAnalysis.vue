<template>
    <div
        class="passenger-flow"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div class="search-item">
                <el-radio-group v-model="search.dateTypes">
                    <el-radio-button :label="0">天</el-radio-button>
                    <el-radio-button :label="1">月</el-radio-button>
                </el-radio-group>
            </div>

            <div class="search-item">
                <el-date-picker
                    v-model="search.dateRange"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                    :clearable="false"
                    v-show="search.dateTypes == 0"
                >
                </el-date-picker>

                <el-date-picker
                    v-model="search.dateRange"
                    type="monthrange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                    :clearable="false"
                    v-show="search.dateTypes == 1"
                >
                </el-date-picker>
            </div>

            <div class="search-item">
                <el-button
                    type="primary"
                    @click="getData"
                >查询</el-button>
            </div>
        </div>

        <div
            class="count-number"
            ref="count"
        >
            <el-row class="head">
                <el-col class="head-detail">
                    <div class="head-item customer">
                        <div class="head-button">顾客总数</div>
                        <div class="bottom-text">0</div>
                    </div>
                </el-col>
                <el-col class="head-detail">
                    <div class="head-item customer-new">
                        <div class="head-button">新顾客</div>
                        <div class="bottom-text">0/0</div>

                    </div>
                </el-col>
                <el-col class="head-detail">
                    <div class="head-item patient">
                        <div class="head-button">新患者/老患者</div>
                        <div class="bottom-text">0</div>
                    </div>
                </el-col>
                <el-col class="head-detail">
                    <div class="head-item transfer">
                        <div class="head-button">转换率</div>
                        <div class="bottom-text">0.00%</div>
                    </div>
                </el-col>
            </el-row>
        </div>

        <div class="detail-content">
            <div
                class="detail-row"
                :style="{
                    height: detailHeight
                }"
            >
                <div class="detail-left">
                    <div class="head">
                        <span class="point"></span>
                        来店时间段分析
                    </div>

                    <div class="detail">暂无数据</div>
                </div>
                <div class="detail-right">
                    <div class="head">
                        <span class="point"></span>
                        年龄分布 0 人
                    </div>

                    <div class="detail">暂无数据</div>
                </div>
            </div>

            <div
                class="detail-row"
                :style="{
                    height: detailHeight
                }"
            >
                <div class="detail-left">
                    <div class="head">
                        <span class="point"></span>
                        初诊人次 - 初诊流失人次 - 初诊流失率 -
                    </div>
                    <div class="detail">暂无数据</div>
                </div>
                <div class="detail-right">
                    <div class="head">
                        <span class="point"></span>
                        性别分布（单位：人） 0人
                    </div>
                    <div class="detail">暂无数据</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Base from "../Base";
export default {
    name: "PassengerFlowAnalysis",
    components: {},

    mixins: [Base],

    props: {},

    data() {
        return {
            search: {
                dateRange: [new Date(), new Date()],
                dateTypes: 0
            },

            detailHeight: "300px"
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeContent();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeContent);
        } else {
            window.attachEvent("bodyChange", that.resizeContent);
        }
    },
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.resizeContent();

                //更新原来的refresh, 防止下次点击时不通知更新
                that.$emit("update:refresh", false);
            }
        }
    },
    computed: {},
    methods: {
        afterGetData(res) {
            let that = this;
        },

        resizeContent() {
            let that = this,
                detailHeight =
                    (that.$refs.content.clientHeight -
                        that.$refs.search.clientHeight -
                        that.$refs.count.clientHeight) /
                    2;
            
            detailHeight = parseInt(detailHeight);

            that.detailHeight = `${detailHeight}px`;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.passenger-flow {
    height: 100%;
    box-sizing: border-box;

    .action-bar {
        padding: 10px 10px 0 10px;
        border: 1px solid #e3e3e3;
    }

    .count-number {
        border: 1px solid #e3e3e3;
        border-top: none;

        .head {
            height: 80px;
            line-height: 30px;
            display: flex;
            padding: 10px;

            .head-detail {
                font-size: 18px;
                margin-right: 10px;
                box-sizing: border-box;

                &:last-of-type {
                    margin-right: 0;
                }

                .customer {
                    color: #f48389;
                    background-color: #fef3f4;
                }

                .customer-new {
                    color: #f2cd73;
                    background-color: #fdf9ef;
                }

                .patient {
                    color: #9dcc64;
                    background-color: #f6faf1;
                }

                .transfer {
                    color: #95a2eb;
                    background-color: #eff3fd;
                }

                .head-item {
                    .bottom-text {
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
    }

    .detail-content {
        .detail-row {
            display: flex;
            border-bottom: 1px solid #e3e3e3;
            box-sizing: border-box;

            .head {
                color: #6d6b6b;
                height: 28px;
                .point {
                    display: inline-block;
                    background-color: #92a8de;
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                }
            }

            .detail {
                height: 100%;
                color: #6d6b6b;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .detail-left,
            .detail-right {
                padding: 10px;
                display: flex;
                flex-direction: column;                
            }

            .detail-left {
                flex: 1;
                border-right: 1px solid #e3e3e3;
            }

            .detail-right {
                width: 300px;
            }
        }
    }
}
</style>