<template>
    <el-dialog
        title="新增治疗"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-treat"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <el-form
            :model="form"
            :rules="formRules"
            label-width="100px"
            ref="form"
        >

            <el-form-item
                label="治疗名称"
                prop="treat_name"
            >
                <el-input
                    v-model.trim="form.treat_name"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="类型"
                prop="type"
            >
                <el-radio-group v-model="form.type">
                    <el-radio :label="0">备牙</el-radio>
                    <el-radio :label="1">充值</el-radio>
                    <el-radio :label="2">药物</el-radio>
                    <el-radio :label="3">其他</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button
                @click="closeDialog"
                :disabled="commitLoading"
            >取 消</el-button>
            <el-button
                type="primary"
                @click="addCommit"
                :loading="commitLoading"
            >确 定</el-button>
            <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
        </div>

    </el-dialog>
</template>

<script>
import AddDialogForm from "../../../base/AddDialogForm";

export default {
    name: "AddTreat",
    mixins: [AddDialogForm],

    components: {},
    props: {
        menu_id:{

        }
    },
    data() {
        return {
            apiType: "treat",
            form: {
                treat_name: "",
                menu_id:0,
                type: 0
            },
            formRules: {
                treat_name: [
                    {
                        required: true,
                        message: "请输入治疗名称",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue,oldValue){
            let that = this;
            if (newValue) {

                that.form.menu_id = that.menu_id;

            }
        }
    },
    computed: {},
    methods: {}
};
</script>
<style lang="less" scoped>
.add-treat {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }
}
</style>