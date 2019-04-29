<template>
    <div class="chain-store">
        <div class="left-content">
            <el-menu
                default-active="operationSituation"
                @select="selectHandler"
            >
                <el-menu-item index="operationSituation">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">运营情况</span>
                </el-menu-item>
                <el-menu-item index="trendAnalysis">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">趋势分析</span>
                </el-menu-item>
            </el-menu>
        </div>
        <div class="right-content">

            <!-- 运营情况 -->
            <operation-situation
                v-if="content.operationSituation"
                :update.sync="operationSituationUpdate"
            ></operation-situation>

            <!-- 趋势分析 -->
            <trend-analysis
                v-if="content.trendAnalysis"
                :update.sync="trendAnalysisUpdate"
            ></trend-analysis>
        </div>
    </div>
</template>

<script>
import OperationSituation from "./OperationSituation";
import TrendAnalysis from "./TrendAnalysis";

export default {
    name: "ChainStoreStatistics",
    components: {
        OperationSituation,
        TrendAnalysis
    },

    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            content: {
                //这里改成了flase用于处理tab点进去没有刷新图表
                operationSituation: false,
                trendAnalysis: false
            },

            operationSituationUpdate: false,
            trendAnalysisUpdate: false
        };
    },
    created() {},
    mounted() {
    },
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                let hasSet = false;

                for (var key in that.content) {
                    if (that.content[key]) {
                        that[key + "Update"] = true;
                        hasSet = true;
                    }
                }

                //用于处理图表没有显示, 上面的模块显示情况改成了v-if,不然图片点击进去没有渲染
                if(!hasSet){
                    that.content.operationSituation = true;
                    that.operationSituationUpdate = true;
                }

                //更新原来的refresh, 防止下次点击时不通知更新
                that.$emit("update:refresh", false);
            }
        }
    },
    computed: {},
    methods: {
        selectHandler(index) {
            let that = this;
            that.content.operationSituation = "operationSituation" == index;
            that.operationSituationUpdate = "operationSituation" == index;

            that.content.trendAnalysis = "trendAnalysis" == index;
            that.trendAnalysisUpdate = "trendAnalysis" == index;
        }
    }
};
</script>
<style lang="less" scoped>
.chain-store {
    display: flex;
    position: relative;
    height: 100%;
    box-sizing: border-box;

    .left-content {
        width: 150px;

        border-right: 1px solid #e3e3e3;

        .menu-icon {
            margin-right: 10px;
        }

        /deep/ .el-menu {
            border-right: 0;
        }
    }

    .right-content {
        flex: 1;
        overflow: auto;
    }
}
</style>