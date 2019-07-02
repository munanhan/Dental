<template>
    <div class="con-content">
        <div class="con-top">
            <div
                @dblclick="add_cons"
                class="background"
                v-for="(item,index) in consultInfo"
                :key="index"
            >
                <!-- <div class="top-title">
                    <div style="margin-right:60px"> &nbsp;&nbsp; 2019-05-16 &nbsp;&nbsp; 14:00 &nbsp;&nbsp;</div>
                    <div style="margin-right:200px">接诊医生:12121212</div>
                    <div>录入:1212</div>
                </div> -->
                <div class="top-title">
                    <div class="top-content">
                        <div class="top-text">{{item.created_at}}</div>
                        <div class="top-text">接诊医生：<span>{{item.doctor}}</span></div>
                        <div class="top-text">录入：<span>{{item.data_entry_person}}</span></div>
                    </div>
                    <div class="top-i-content">

                        <i class="fa fa-pen top-i"></i>
                        <i
                            @click="delDisposal"
                            class="fa fa-trash-alt top-i"
                        ></i>
                    </div>
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
                            <div class="font-left"> 主 诉:{{item.main_consult}}</div>
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
                            <div class="font-left"> 基本需要:{{item.base_demand}}</div>
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
                            <div class="font-left">潜在需求:{{item.potential_demand}}</div>
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
                            <div class="font-left">医生方案:{{item.doctor_solution}}</div>

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
                            <div class="font-left">沟通记录:{{item.record}}</div>
                            <!-- <div
                                style="flex:1"
                                class="font-right"
                            ></div> -->
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
                            <div class="font-left">服务建议:{{item.service_proposal}}</div>
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
        <add-consulting
            :show.sync="addcons_show"
            :addConsult="patientInfo"
            @add-item="addConsultResult"
        ></add-consulting>
    </div>

</template>

<script>
import AddConsulting from "./AddConsulting";
import formatDate from "@/common/util.js";
export default {
    name: "ConsultingInfo",
    components: {
        AddConsulting
    },
    props: {
        consultInfo: {
            type:Array,
            default: () => []
        },
        selectID:"",
    },
    data() {
        return {
            addcons_show: false,
            consultingList: [],
            patientInfo:[],
        };
    },
    created() {
    },
    mounted() {},
    watch: {


    },
    computed: {},
    methods: {
        delDisposal(index, value) {
            this.consultingList.splice(index, 1);
        },

        addConsultResult(data) {
            let that = this;
            that.consultingList.push(data);
        },

        add_cons() {
            let that = this;

            if (that.selectID) {
                that.$api.patient_consult.patientInfo({id: that.selectID})
                    .then(res=>{
                        that.patientInfo=res.data;
                        that.addcons_show = true;
                    })
                    .catch(res=>{
                        console.log(res);
                    })

            } else {
                that.$message.warning("请选择一个患者");
            }
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
        overflow: auto;
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
            height: 200px;
            border-left-width: 10px;
            &:hover {
                color: @color;
                border-color: @color;
            }
            .top-title {
                justify-content: space-around;
                display: flex;
                color: #6d6d6d;
                font-size: 20px;
                font-weight: bold;
                margin: 10px 0;
                color: #000;

                // border: 1px solid red;
                .top-content {
                    flex: 1 auto;
                    text-align: left;
                    margin-right: 20px;
                    .top-text {
                        margin-left: 3px;
                        margin-right: 20px;
                        display: inline-block;
                    }
                }
                .top-i-content {
                    // border:1px solid red;
                    margin-right: 10px;
                    .top-i {
                        margin-right: 5px;
                        cursor: pointer;
                        color: #696969;
                        &:hover {
                            color: #000;
                        }
                    }
                }
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
                        width: 80px;
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