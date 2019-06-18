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
                  <div style="display:flex;font-size:20px">
                    <div>asa</div>
                    <div>sas</div>
                  </div>
                </div>
                <div class="visit-bottom">
                    <el-form-item
                        style="padding-top:10px"
                        label="活动名称"
                    >
                        <el-date-picker
                            v-model="form.value1"
                            type="date"
                            placeholder="选择日期"
                        >
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item label="回访人员">
                        <el-select
                            style="width:220px"
                            v-model="form.value"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in form.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="主治医生">
                        <el-select
                            style="width:220px"
                            v-model="form.value"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in form.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <div style="margin-left:12px">
                        回访状态
                        <el-radio
                            style="margin-left:10px"
                            v-model="form.radio"
                            label="1"
                        >已回访</el-radio>
                        <el-radio
                            v-model="form.radio"
                            label="2"
                        >做计划</el-radio>
                        <el-radio
                            v-model="form.radio"
                            label="3"
                        >待跟进</el-radio>
                    </div>

                    <el-form-item
                        style="margin-top:20px"
                        label="回访内容"
                    >
                        <input style="">
                        <!-- <el-input style="height:20px;width:470px"></el-input> -->
                    </el-form-item>
                    <el-form-item
                        style="margin-top:20px"
                        label="回访结果"
                    >
                        <input style="height:50px;width:470px">
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
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddReturnVisit",

    mixins: [DialogForm],

    data() {
        return {
            form: {
                value1: "",
                radio: "1"
            }
        };
    },

    methods: {
        commit() {
            let that = this;

            that.$emit("update", {});
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
    }
    .visit-bottom {
        background-color: #fafafa;
        // border: 1px solid red;
        padding-bottom: 30px;
        input {
            height: 50px;
            width: 470px;
            margin-top: 13px;
        }
    }
}
</style>