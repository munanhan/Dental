<template>
    <div class="con-content">
        <div class="con-top">
            <div
                class="background"
                v-for="(item,index) in consultInfo"
                :key="index"
                @dblclick="edit_cons(item.id,index)"
            >

                <div class="top-title">
                    <div class="top-content">
                        <div class="top-text">{{item.created_at}}</div>
                        <div class="top-text">接诊医生：<span>{{item.doctor}}</span></div>
                        <div class="top-text">录入：<span>{{item.data_entry_person}}</span></div>
                    </div>
                    <div class="top-i-content">
                        <i
                            class="fa fa-pen top-i"
                            @click="edit_cons(item.id,index)"
                        ></i>

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
                            <div class="font-left">主 诉:</div>
                            <div>{{item.main_consult}}</div>
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
                            <div>{{item.base_demand}}</div>
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
                            <div>{{item.potential_demand}}</div>
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
                            <div>{{item.doctor_solution}}</div>

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
                            <div>{{item.record}}</div>

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
                            <div>{{item.service_proposal}}</div>
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
                    @click="add_cons('add')"
                >新增</el-button>
            </div>
        </div>
        <add-consulting
            :show.sync="addcons_show"
            :addConsult="patientInfo"
            :baseDemandList="baseDemandList"
            :potentialDemandList="potentialDemandList"
            :doctorList="doctorList"
            @add-item="addConsultResult"
        ></add-consulting>
        <edit-consulting
                :show.sync="editcons_show"
                :editConsult="patientInfo"
                :editConsultInfo="editConsultInfo"
                :editBaseDemandList="baseDemandList"
                :editPotentialDemandList="potentialDemandList"
                :editDoctorList="doctorList"
                @edit-item="editConsultResult"
        ></edit-consulting>
    </div>

</template>

<script>
import AddConsulting from "./AddConsulting";
import formatDate from "@/common/util.js";
import EditConsulting from "./EditConsulting";
export default {
    name: "ConsultingInfo",

    components: {
        AddConsulting,
        EditConsulting
    },

    props: {
        consultInfo: {},
        selectID: {}
    },

    data() {
        return {
            addcons_show: false,
            editcons_show: false,
            patientInfo: [],
            editConsultInfo:[],
            baseDemandList:[],
            potentialDemandList:[],
            doctorList:[],
            selectIndex:"",
        };
    },

    created() {},

    mounted() {},

    watch: {},

    computed: {},

    methods: {

        delDisposal(index, value) {
            this.consultInfo.splice(index, 1);
        },

        editConsultResult(data){
            let that=this;
            that.$set(that.consultInfo,that.selectIndex,data);
        },

        addConsultResult(data) {
            let that = this;
            that.consultInfo.push(data);
        },

        add_cons() {
            let that = this;

            that.$api.patient_consult.consultInfo({patient_id:that.selectID})
                .then(res=>{
                    if(res.code==200){
                        that.patientInfo=res.data.patientInfo;
                        that.baseDemandList=res.data.baseDemand;
                        that.potentialDemandList=res.data.potentialDemand;
                        that.doctorList=res.data.doctorInfo;
                        that.addcons_show=true;
                    }else {
                        console.log(res.msg);
                    }
                })
                .catch(res=>{
                    console.log(res);
                })
        },


        edit_cons(id,index) {
            let that=this;
            that.selectIndex=index;
            that.$api.patient_consult.consultInfo({id:id,patient_id:that.selectID})
                .then(res=>{
                    if(res.code==200){

                        res.data.consultInfo.base_demand = res.data.consultInfo.base_demand.map((item) =>{
                            return parseInt(item, 10);
                        });

                        res.data.consultInfo.potential_demand = res.data.consultInfo.potential_demand.map((item) =>{
                            return parseInt(item, 10) ;
                        });

                        that.editConsultInfo=res.data.consultInfo;

                        that.baseDemandList=res.data.baseDemand;
                        that.patientInfo=res.data.patientInfo;
                        that.potentialDemandList=res.data.potentialDemand;
                        that.doctorList=res.data.doctorInfo;

                        that.editcons_show=true;
                    }else {
                        console.log(res.msg);
                    }
                })
                .catch(res=>{
                    console.log(res);
                })

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
                        // margin-right: 50px;
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