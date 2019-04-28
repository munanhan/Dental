<template>
    <div class="chargin-recon">
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
import ChargeDetail from "./ChargeDetail";
import ProjectConsumption from "./ProjectConsumption";

export default {
    name: "EmployeePerformance",
    components: {
        ChargeDetail,
        ProjectConsumption,
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
                chargeDetail: true,
                projectConsumption: false
            },

            chargeDetailUpdate: false,
            projectConsumptionUpdate: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                for (var key in that.content) {
                    if (that.content[key]) {
                        that[key + "Update"] = true;
                    }
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
            that.content.chargeDetail = "chargeDetail" == index;
            that.chargeDetailUpdate = "chargeDetail" == index;

            that.content.projectConsumption = "projectConsumption" == index;
            that.projectConsumptionUpdate = "projectConsumption" == index;
        },

        afterGetData(res) {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
.chargin-recon {
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