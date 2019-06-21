<template>
    <el-dialog
        title="修改支出类型"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <el-form
            :model="form"
            :rules="formRules"
            label-width="60px"
            ref="form"
        >
            <el-form-item
                label="类型"
                prop="expenditure_type"
            >
                <el-input
                    v-model.trim="form.expenditure_type"
                    autocomplete="off"
                ></el-input>
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
                @click="editCommit"
                :loading="commitLoading"
            >确 定</el-button>
        </div>
    </el-dialog>
</template>

<script>
import EditDialogForm from "../base/EditDialogForm";
export default {
    name: "EditExpenditureCategory",
    mixins: [EditDialogForm],
    components: {},
    props: {

    },
    data() {
        return {
            commitLoading: false,

            form: {
                expenditure_type: ""
            },
            formRules: {
                expenditure_type: [
                    {
                        required: true,
                        message: "请输入类型",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {},
    watch: {

    },
    computed: {},
    methods: {
        editCommit() {
            let that = this;
            that.$api.expenditure_type.update(that.form)
                .then(res => {
                  if(res.code == 200){

                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });

                        that.$emit("edit-item", res.data);

                        that.closeDialog();

                   }
                   else{
                       that.$message.error(
                            res.msg || "edit error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });
        }
    }
};
</script>
<style lang="less" scoped>
</style>