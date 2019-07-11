<template>
    <div>
        <el-table
            border
            class="charge-top"
            height="802px"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
            highlight-current-row

            :data="visitInfo"
        >

                <el-table-column
                    prop="status"
                    label="回访状态"
                    width="90"
                >
                </el-table-column>
                <el-table-column
                    prop="review_staff"
                    label="回访人"
                    width="90"
                >
                </el-table-column>
                <el-table-column
                    prop="attend_doctor"
                    label="主治医生"
                    width="90"
                >
                </el-table-column>
                <el-table-column
                    prop="visit_time"
                    label="回访时间"
                    width="170"
                >
                </el-table-column>
                <el-table-column
                    prop="review_content"
                    label="回访内容"

                >
                </el-table-column>
                <el-table-column
                    prop="review_result"
                    label="回访结果"
                    width="200"
                >
                </el-table-column>
                <el-table-column
                    prop="created_at"
                    label="创建时间"
                    width="170"
                >
                </el-table-column>
                <el-table-column
                    fixed="right"
                    label="操作"
                    width="100">
                    <template slot-scope="scope">
                        <el-button @click="editVisit(scope.$index,scope.row)" type="text" size="small">修改</el-button>
                        <el-button @click="delVisit(scope.$index,scope.row)" type="text" size="small">删除</el-button>
                    </template>
                </el-table-column>

        </el-table>
        <div class="charge-bottom">
            <el-button
                class="button"
                @click="addPlan"
            >新增计划</el-button>
            <el-button
                class="button"
                type="primary"
                @click="addVisit"
            >新增回访</el-button>

        </div>

        <add-plan
            :show.sync="add_plan_show"
            :addPlanPatients="patients"
        ></add-plan>

        <add-return-visit
            :show.sync="add_visit_show"
            :addReturnVisit="patients"
            :addAttendDoctorList="doctors"
            :addVisitorList="visitors"
            :addContentList="visit_contents"
            :addResultList="visit_results"
            @add-item="addSuccess"
        ></add-return-visit>
        <edit-return-visit
            :show.sync="edit_visit_show"
            :editInfo="editInfo"
            :editPatientInfo="patients"
            :editAttendDoctorList="doctors"
            :editVisitorList="visitors"
            :editContentList="visit_contents"
            :editResultList="visit_results"
            @edit-item="updateSuccess"
        ></edit-return-visit>
    </div>
</template>

<script>
import AddPlan from "./AddPlan";
import AddReturnVisit from "./AddReturnVisit";
import EditReturnVisit from "./EditReturnVisit";

export default {
    name: "ReturnVisitInfo",
    components: {
        AddPlan,
        AddReturnVisit,
        EditReturnVisit
    },
    props: {
        visitInfo: {},
        selectPatientID: {}
    },
    data() {
        return {
            add_plan_show: false,
            edit_visit_show: false,
            add_visit_show: false,
            patients: [],
            doctors: [],
            visitors: [],
            visit_results: [],
            visit_contents: [],
            editInfo:[],
            selectIndex:"",
        };
    },
    created() {},
    mounted() {},
    watch: {

    },
    computed: {},
    methods: {

        addSuccess(data){
            let that = this;
            that.visitInfo.push(data);
        },

        updateSuccess(data){
            let that=this;

            that.$set(that.visitInfo,that.selectIndex,data);
        },

        editVisit(index,row) {

            let that = this;

            that.selectIndex=index;

            that.getBaseInfo("edit_visit",row.id);

        },

        delVisit(index,row) {

            let that=this;

            that.$api.patient_visit.del({id:row.id})
                .then(res=>{

                    if(res.code==200){

                        that.visitInfo.splice(index, 1);

                        that.$message.success(res.msg);

                    }else {

                        that.$message.error(res.msg);
                    }
                })
                .catch(res=>{
                    console.log(res);
                })
        },

        addPlan() {
            let that = this;
            that.getBaseInfo("add_plan",null);
        },

        addVisit() {
            let that = this;
            that.getBaseInfo("add_visit",null);
        },

        getBaseInfo(flag,id) {
            let that = this;
            that.$api.patient_visit
                .visitInfo({ patient_id: that.selectPatientID ,id:id })
                .then(res => {
                    if (res.code == 200) {
                        that.patients = res.data.patient;
                        that.doctors = res.data.attend_doctor;
                        that.visitors = res.data.visitor;
                        that.visit_results = res.data.visit_result;
                        that.visit_contents = res.data.visit_content;

                        if (flag == "add_plan") {
                            that.add_plan_show = true;
                        }

                        if (flag == "add_visit") {
                            that.add_visit_show = true;
                        }
                        if(flag=="edit_visit") {
                            that.editInfo=res.data.visit_info;
                            that.edit_visit_show = true;
                        }
                    }
                })
                .catch(res => {
                    console.log(res);
                });
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.charge-top {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    position: relative;
}
.charge-bottom {
    height: 60px;
    position: absolute;
    left: 0;
    bottom: 0;
    background-color: #e3e3e3;
    width: 100%;
}

// /deep/ .el-table__body-wrapper {
//   height: 755px;
// }

.button {
    width: 130px;
    margin-top: 10px;
    margin-left: 10px;
}
</style>