<template>
    <div>
        <el-table
            border
            class="charge-top"
            height="802px"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
            highlight-current-row
            @current-change="handleCurrentChange"
            :data="returnInfo"
        >
            <div>
                <el-table-column
                    prop="status"
                    label="回访状态"
                    width="180"
                >
                </el-table-column>
                <el-table-column
                    prop="review_staff"
                    label="回访人"
                >
                </el-table-column>
                <el-table-column
                    prop="attend_doctor"
                    label="主治医生"
                    width="180"
                >
                </el-table-column>
                <el-table-column
                    prop="visit_time"
                    label="回访时间"
                    width="180"
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
                    width="180"
                >
                </el-table-column>
                <el-table-column
                    prop="created_at"
                    label="创建时间"
                    width="180"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="就诊日期"
                >
                </el-table-column>

            </div>
        </el-table>
        <div class="charge-bottom">
            <el-button
                class="button"
                @click="Add_Plan"
            >新增计划</el-button>
            <el-button
                class="button"
                type="primary"
                @click="Add_Revisit"
            >新增回访</el-button>
            <el-button
                class="button"
                @click="edit_returnvisit"
            >修改</el-button>
            <el-button
                class="button"
                @click="del"
            >删除</el-button>
        </div>
        <!-- <div style="flex:">asd</div> -->
        <add-plan
            :show.sync="addplan_show"
            :addPlan="patients"
        ></add-plan>
        <!-- @flush="flushData" -->
        <add-return-visit
            :show.sync="addrevisit_show"
            :addReturnVisit="patients"
            :addAttendDoctorList="doctors"
            :addVisitorList="visitors"
            :addContentList="visit_contents"
            :addResultList="visit_results"
        ></add-return-visit>
        <edit-return-visit 
        :show.sync="editrevis_show"
        :editInfo="selectItem"
        :editPatientInfo="patients"
        :editAttendDoctorList="doctors"
        :editVisitorList="visitors"
        :editContentList="visit_contents"
        :editResultList="visit_results"
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
        returnInfo: {},
        selectID: {}
    },
    data() {
        return {
            addplan_show: false,
            editrevis_show:false,
            addrevisit_show: false,
            patients: [],
            doctors: [],
            visitors: [],
            visit_results: [],
            visit_contents: [],
            selectItem: null
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getChargeInfo();
            }
        }
    },
    computed: {},
    methods: {
        handleCurrentChange(val) {
            let that = this;
            that.selectItem = val;
        },

        edit_returnvisit() {
            let that = this;
            that.getBaseInfo('edit');
            that.editrevis_show=true;
        },

        del() {},

        // flushData() {
        //     //刷新数据
        //     let that = this;
        //     that.getData(that.comboId);
        // },

        // getData(id) {
        //     //获取数据
        //     let that = this;

        //     that.table = res.data;
        //     // console.log(res.data);
        // },

        Add_Plan() {
            let that = this;
            that.getBaseInfo("plan");
        },
        Add_Revisit() {
            let that = this;
            that.getBaseInfo("visit");
        },

        getBaseInfo(flag) {
            let that = this;

            if (that.selectID) {
                that.$api.patient_visit
                    .visitInfo({ id: that.selectID })
                    .then(res => {
                        if (res.code == 200) {
                            that.patients = res.data.patient;
                            that.doctors = res.data.attend_doctor;
                            that.visitors = res.data.visitor;
                            that.visit_results = res.data.visit_result;
                            that.visit_contents = res.data.visit_content;

                            if (flag == "plan") {
                                that.addplan_show = true;
                            }if (visit) {
                                that.addrevisit_show = true;
                            } else {
                                that.editrevis_show = true;
                            }
                        }
                    })
                    .catch(res => {
                        console.log(res);
                    });
            }
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