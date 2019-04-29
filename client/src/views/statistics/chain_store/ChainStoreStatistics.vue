<template>
    <div class="chain-store">
        <div class="left-content">
            <el-menu
                default-active="chargeDetail"
                @select="selectHandler"
            >
                <el-menu-item index="chargeDetail">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">收费明细</span>
                </el-menu-item>
                <el-menu-item index="projectConsumption">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">项目消费</span>
                </el-menu-item>
            </el-menu>
        </div>
        <div class="right-content">

            <!-- 收费明细 -->
            <charge-detail
                v-show="content.chargeDetail"
                :update.sync="chargeDetailUpdate"
            ></charge-detail>

            <!-- 项目消费 -->
            <project-consumption
                v-show="content.projectConsumption"
                :update.sync="projectConsumptionUpdate"
            ></project-consumption>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChainStoreStatistics",
    components: {},

    props: {},
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
    }

    .right-content {
        flex: 1 auto;
        overflow: auto;
    }
}
</style>