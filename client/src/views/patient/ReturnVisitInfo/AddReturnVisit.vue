<template>
    <el-dialog
        title="新增回访"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="600px"
        top="2vh"
    >
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
        >
            <div class="visit-content">
                <div class="visit-top">
                    <div style="display:flex;font-size:16px;">
                        <div class="number">{{addReturnVisit.patient_name}} </div>
                        <div class="top-font"> {{addReturnVisit.patient_sex}} </div>
                        <div class="top-font"> {{addReturnVisit.case_id}} </div>
                        <div class="top-font"> {{addReturnVisit.patient_age}}岁 </div>
                        <div class="top-font"> {{addReturnVisit.patient_phone}}</div>
                    </div>
                </div>
                <div class="visit-bottom">
                    <el-form-item
                        style="padding-top:10px"
                        label="回访时间"
                    >
                        <el-date-picker
                            v-model="form.visit_time"
                            type="date"
                            value-format="yyyy-MM-dd"
                            placeholder="选择日期"
                        >
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item label="回访人员">
                        <el-select
                            style="width:220px"
                            v-model="form.review_staff"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in addVisitorList"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="主治医生">
                        <el-select
                            style="width:220px"
                            v-model="form.attend_doctor"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in addAttendDoctorList"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <div style="margin-left:12px">
                        回访状态
                        <el-radio-group v-model="form.status">
                            <el-radio :label="0">已回访</el-radio>
                            <el-radio :label="1">做计划</el-radio>
                            <el-radio :label="2">待跟进</el-radio>
                        </el-radio-group>
                    </div>
                    <div>
                        <div class="returncontent">
                            <div
                                @click="isblock = !isblock"
                                class="returncontent2"
                                style="display:flex"
                            >
                                <i class="el el-icon-chat-dot-square return-i"></i>
                                <div class="return-div">回访内容语
                                    <div
                                        class="return-select"
                                        :class="{'block':isblock}"
                                    >
                                        <el-table
                                            style="cursor: pointer;"
                                            :data="addContentList"
                                            stripe
                                            border
                                            :show-header="false"
                                            highlight-current-row
                                        >
                                            <el-table-column prop="name">
                                                <template slot-scope="scope">
                                                    <span
                                                        @click="selectType(scope.row.name)"
                                                        style="display:inline-block;width:100%"
                                                    >
                                                        {{ scope.row.name }}
                                                    </span>
                                                </template>
                                            </el-table-column>
                                        </el-table>
                                    </div>
                                </div>

                            </div>
                            <i
                                @click="return_content"
                                class="el-icon-setting return-i2"
                            ></i>
                        </div>

                        <el-form-item label="回访内容">
                            <textarea
                                v-model="form.review_content"
                                style="margin-top:10px;resize:none;height:50px;width:470px"
                            ></textarea>
                            <!-- <el-input style="height:20px;width:470px"></el-input> -->
                        </el-form-item>
                    </div>

                    <div class="review-results">
                        <div
                            @click="resultsblock = !resultsblock"
                            class="review-results2"
                            style="display:flex"
                        >
                            <i class="el el-icon-chat-dot-square results-i"></i>
                            <div class="results-div">结果常用语
                                <div
                                    class="return-select"
                                    :class="{'block':resultsblock}"
                                >
                                    <el-table
                                        style="cursor: pointer;"
                                        :data="addResultList"
                                        stripe
                                        border
                                        :show-header="false"
                                        highlight-current-row
                                    >
                                        <el-table-column prop="name">
                                            <template slot-scope="scope">
                                                <span
                                                    @click="resultselectType(scope.row.name)"
                                                    style="display:inline-block;width:100%"
                                                >
                                                    {{ scope.row.name }}
                                                </span>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                </div>
                            </div>
                        </div>
                        <i class="el-icon-setting results-i2"></i>
                    </div>
                    <el-form-item label="回访结果">
                        <textarea
                            v-model="form.review_result"
                            style="margin-top:10px;resize:none;height:50px;width:470px"
                        ></textarea>
                    </el-form-item>
                </div>
            </div>

        </el-form>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button
                type="primary"
                @click.stop.prevent="commit"
            >确 定</el-button>
        </div>

        <return-content :show.sync="retcontent_show"></return-content>

    </el-dialog>
</template>

<script>
import DialogForm from "../../base/DialogForm";
import ReturnContent from "./ReturnContent";
import { trim ,formatDate} from "@common/util";

export default {
    name: "AddReturnVisit",
    mixins: [DialogForm],

    components: {
        ReturnContent
    },
    props: {
        addReturnVisit: {},
        addAttendDoctorList: {},
        addVisitorList: {},
        addContentList: {},
        addResultList: {}
    },

    created() {},

    data() {
        return {
            retcontent_show: false,
            isblock: false,
            resultsblock: false,

            form: {
                visit_time: "",
                review_staff: "",
                attend_doctor: "",
                status: 0,
                review_content: "",
                review_result: ""
            }
        };
    },

    watch: {

        // 'form.visit_time':{
        //     handler(newValue,oldValue){
        //         if(newValue){
        //             let that=this;
        //             new Date(newValue).getTime() >new Date().getTime()
        //                 ? (that.form.status=1)
        //                 : (that.form.status=0)
        //         }
        //     }
        // },

        isblock(newValue, oldValue) {
            let that = this;

            if (newValue) {
                //绑定事件

                setTimeout(() => {
                    document.addEventListener("click", that.checkHideSearch);
                });

            }
        },

        resultsblock(newValue, oldValue) {
            let that = this;

            if (newValue) {
                //绑定事件
                setTimeout(() => {
                    document.addEventListener("click", that.resultHideSearch);
                });
            }
        }
    },

    methods: {

        //回访内容语
        selectType(catepory) {
            let that = this,
                text = trim(that.form.review_content);

            that.form.review_content = text
                ? text + "," + catepory
                : text + catepory;

        },

        checkHideSearch() {
            let that = this;

            that.isblock = false;

            document.removeEventListener("click", that.checkHideSearch);
        },

        //结束常用语
        resultselectType(catepory) {
            let that = this,
                text = trim(that.form.review_result);

            that.form.review_result = text
                ? text + "," + catepory
                : text + catepory;
        },

        resultHideSearch() {
            let that = this;

            that.resultsblock = false;

            document.removeEventListener("click", that.resultHideSearch);
        },

        commit() {
            let that = this;

            that.form.patient_id=that.addReturnVisit.id;

            that.$api.patient_visit.store(that.form)
                .then(res=>{
                    if(res.code==200){
                        that.$emit("add-item",JSON.parse(JSON.stringify(res.data)));

                        that.$message.success(res.msg);

                        that.closeDialog();
                    }else {
                        that.$message.error(res.msg);
                    }
                })
                .catch(res=>{
                    console.log(res);
                });
            that.$emit("update", {});
        },

        return_content() {
            this.retcontent_show = true;
        },


        afterClose() {
            let that = this;
            for (let key in that.form) {
                that.form[key] = "";
            }
        }

    }
};
</script>
<style lang="less" scoped>
.visit-content {
    .visit-top {
        height: 50px;
        width: 100%;
        margin-bottom: 10px;
        background-color: #fafafa;
        border: 1px solid #e2e2e2;
        .number {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            margin-left: 20px;
        }
        .top-font {
            margin-top: 12px;
            margin-left: 10px;
        }
    }
    .visit-bottom {
        background-color: #fafafa;
        border: 1px solid #e2e2e2;
        // border: 1px solid red;
        padding-bottom: 30px;
        input {
            height: 50px;
            width: 470px;
            margin-top: 13px;
        }
        .returncontent {
            margin-left: 80px;
            height: 18px;
            margin-top: 10px;
            margin-bottom: -5px;
            display: flex;
            // border: 1px solid red;
            width: 400px;
            .returncontent2 {
                .return-i {
                    font-size: 18px;
                }
                .return-div {
                    font-size: 14px;
                    margin-left: 5px;
                    .return-select {
                        display: none;
                        margin-left: -20px;
                        margin-top: 10px;
                        height: 100px;
                        position: absolute;
                        z-index: 99;
                        width: 300px;
                    }
                    .block {
                        display: block;
                    }
                }
                &:hover {
                    color: #7092ff;
                    cursor: pointer;
                    .return-div {
                        text-decoration: underline;
                    }
                }
            }
            .return-i2 {
                margin-left: 10px;
                font-size: 16px;
                &:hover {
                    cursor: pointer;
                    color: #7092ff;
                }
            }
        }

        .review-results {
            margin-left: 80px;
            height: 18px;
            margin-top: 10px;
            margin-bottom: -5px;
            display: flex;
            // border: 1px solid red;
            width: 400px;
            .review-results2 {
                .results-i {
                    font-size: 18px;
                }
                .results-div {
                    font-size: 14px;
                    margin-left: 5px;
                    .return-select {
                        display: none;
                        margin-left: -20px;
                        margin-top: 10px;
                        height: 100px;
                        position: absolute;
                        z-index: 99;
                        width: 300px;
                    }
                    .block {
                        display: block;
                    }
                }
                &:hover {
                    color: #7092ff;
                    cursor: pointer;
                    .results-div {
                        text-decoration: underline;
                    }
                }
            }
            .results-i2 {
                margin-left: 10px;
                font-size: 16px;
                &:hover {
                    cursor: pointer;
                    color: #7092ff;
                }
            }
        }
    }
}
</style>