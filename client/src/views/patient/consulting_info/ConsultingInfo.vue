<template>
    <div class="con-content">
        <div class="con-top">
            <div
                @dblclick="add_cons"
                class="background"
            >
                <div class="top-title">
                    <div style="margin-right:60px"> &nbsp;&nbsp; 2019-05-16 &nbsp;&nbsp; 14:00 &nbsp;&nbsp;</div>
                    <div style="margin-right:200px">接诊医生:12121212</div>
                    <div>录入:1212</div>
                </div>
                <div class="bottom-title">
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div class="font-left"> 主 诉:</div>
                            <div
                                class="font-right"
                                style="color:#000;margin-left:50px"
                            >asdsadsadsad</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div class="font-left"> 基本需要:</div>
                            <div class="font-right">asdsadsadsad</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div class="font-left">潜在需求:</div>
                            <div class="font-right">asdsadsadsad</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div class="font-left">医生方案:</div>
                            <div class="font-right">asdsadsadsad</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div class="font-left">沟通记录:</div>
                            <div class="font-right">asdsadsadsad</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div class="font-left">服务建议:</div>
                            <div class="font-right">asdsadsadsad</div>
                        </el-col>
                    </el-row>
                </div>
            </div>
        </div>
        <div dis-bottom>
            <div class="con-bottom">
                <el-button
                    class="con-button"
                    type="primary"
                    @click="add_cons"
                >新增</el-button>
            </div>
        </div>
        <add-consulting :show.sync="addcons_show"></add-consulting>
    </div>

</template>

<script>
import AddConsulting from "./AddConsulting";

export default {
    name: "ConsultingInfo",
    components: {
        AddConsulting
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            addcons_show: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getDisposalRecords();
            }
        }
    },
    computed: {},
    methods: {
        getDisposalRecords() {},

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        add_cons() {
            this.addcons_show = true;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.con-content {
    .con-top {
        // border: 1px solid red;
        position: absolute;
        right: 0;
        left: 0;
        top: 0;
        height: 100%;
        bottom: 0;
        .background {
            cursor: pointer;
            border: 1px solid #c4c4c4;
            margin: 10px 20px;
            height: 300px;
            border-left-width: 10px;
            &:hover {
                color: @color;
                border-color: @color;
            }
            .top-title {
                display: flex;
                color: #6d6d6d;
                font-size: 20px;
                font-weight: bold;
                margin: 10px 0;
            color: #000;

                // border: 1px solid red;
            }
            .bottom-title {
                margin-bottom: 100px;
                // border: 1px solid red;
                font-size: 16px;
                color: #8f8f8f;
                .bottom-title-col {
                    display: flex;
                    margin-bottom: -20px;
                    // border: 1px solid red;
                    .font-left {
                        font-weight: bold;
                        margin-right: 50px;
                        margin-bottom: 5px;
                    }
                    .font-right {
                        color: #000;
                    }
                }
               
            }
            
        }
    }
    .con-bottom {
        border: 1px solid #e4e4e4;
        background-color: #e3e3e3;
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 59px;
        .con-button {
            width: 130px;
            margin-left: 10px;
            margin-top: 10px;
        }
    }
}
</style>