<template>
    <el-dialog
        title="加工单管理"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        v-dialog-drag
        width="1000px"
    >
        <el-form
            ref="form"
            :model="form"
            label-width="82px"
            :rules="rules"
        >
            <div class="">
                <el-form-item label="牙位">
                    <el-row :gutter="20">
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                    </el-row>
                </el-form-item>
                <el-form-item label="加工类型">
                    <el-row :gutter="20">
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                    </el-row>
                </el-form-item>
                <el-form-item label="色号">
                    <el-row :gutter="20">
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                        <el-col
                            :span="5"
                            style="margin-right:25px"
                        >
                            <el-input></el-input>
                        </el-col>
                    </el-row>
                </el-form-item>
                <div style="display:flex">
                    <el-form-item
                        label="加工单位"
                        prop="social_security"
                    >
                        <el-select
                            style="width:140px;margin-left:10px"
                            v-model="value"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>

                    </el-form-item>
                    <!-- <i
            class="fa fa-cog"
            style="margin-top:10px;
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px
                  "
          ></i> -->
                    <el-form-item
                        label="取 件 人"
                        prop="social_security"
                    >
                        <el-select
                            style="width:140px;margin-right:10px"
                            v-model="value"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>

                    </el-form-item>
                    <!-- <i
            class="fa fa-cog"
            style="margin-top:10px;
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px;
                   margin-right:20px
                  "
          ></i> -->
                    <el-form-item
                        label="取件人电话"
                        prop="social_security"
                    >
                        <el-input style="width:140px;margin-right:25px"></el-input>

                    </el-form-item>
                    <el-form-item
                        label="加工天数"
                        prop="social_security"
                    >
                        <el-input style="width:140px"></el-input>

                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="医生"
                        prop="social_security"
                    >
                        <el-select
                            style="width:140px;margin-left:10px"
                            v-model="form.doctor"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in form.doctorContent"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>

                    </el-form-item>
                    <el-form-item
                        label="送件日期"
                        prop="social_security"
                    >
                        <el-input style="width:140px;margin-right:10px"></el-input>

                    </el-form-item>
                    <el-form-item
                        label="回件日期"
                        prop="social_security"
                    >
                        <el-input style="width:140px;margin-right:25px"></el-input>

                    </el-form-item>
                    <el-form-item
                        label="加工单号"
                        prop="social_security"
                    >
                        <el-input style="width:140px"></el-input>

                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="状态"
                        prop="social_security"
                    >
                        <el-select
                            style="width:140px;margin-left:10px"
                            v-model="value"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>

                    </el-form-item>
                    <el-form-item
                        label="加工厂价"
                        prop="social_security"
                    >
                        <el-input style="width:140px;margin-right:10px"></el-input>

                    </el-form-item>
                    <el-form-item
                        label="对患者价"
                        prop="social_security"
                    >
                        <el-input style="width:140px;margin-right:25px"></el-input>

                    </el-form-item>
                    <el-form-item
                        label="加工颗数"
                        prop="social_security"
                    >
                        <el-input style="width:140px"></el-input>

                    </el-form-item>

                </div>
                <el-form-item label="色号">
                    <el-row :gutter="23">
                        <el-col :span="23">
                            <el-input style="width:100%"></el-input>
                        </el-col>
                    </el-row>
                </el-form-item>
            </div>
        </el-form>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">退出</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
                @click="changePassword"
            >确 定</el-button>
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
    name: "ChangePassword",

    mixins: [DialogForm],

    data() {
        return {
            form: {
                //医生
                doctorContent: [
                    {
                        value: "选项1",
                        label: "黄金糕"
                    }
                ],
                doctor: "",

                rules: {}
            }
        };
    },

    methods: {}
};
</script>
<style lang="less" scoped>
.el-input {
    width: 200px;
}
</style>