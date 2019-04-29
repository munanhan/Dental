<template>
    <div class="external-processing">
        <div class="left-content">
            <el-menu
                default-active="processingDetails"
                @select="selectHandler"
            >
                <el-menu-item index="processingDetails">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">加工明细</span>
                </el-menu-item>
                <el-menu-item index="machiningType">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">加工类型</span>
                </el-menu-item>
            </el-menu>
        </div>
        <div class="right-content">

            <!-- 加工明细 -->
            <processing-details
                v-show="content.processingDetails"
                :update.sync="processingDetailsUpdate"
            ></processing-details>

            <!-- 加工类型 -->
            <machining-type
                v-show="content.machiningType"
                :update.sync="machiningTypeUpdate"
            ></machining-type>
        </div>
    </div>
</template>

<script>
import MachiningType from "./MachiningType";
import ProcessingDetails from "./ProcessingDetails";

export default {
    name: "ExternalProcessing",
    components: {
        MachiningType,
        ProcessingDetails
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
                processingDetails: true,
                machiningType: false
            },

            processingDetailsUpdate: false,
            machiningTypeUpdate: false
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
            that.content.machiningType = "machiningType" == index;
            that.machiningTypeUpdate = "machiningType" == index;

            that.content.processingDetails = "processingDetails" == index;
            that.processingDetailsUpdate = "processingDetails" == index;
        },

        afterGetData(res) {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
.external-processing {
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