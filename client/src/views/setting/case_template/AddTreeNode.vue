<template>
    <el-dialog
        title="新增节点"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-tree-node"
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
                label="节点名称"
                prop="outline_name"
            >
                <el-input
                    v-model.trim="form.outline_name"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="类型"
                prop="type"
            >
                <el-radio-group v-model="form.type">
                    <el-radio :label="0">目录</el-radio>
                    <el-radio :label="1">案例</el-radio>
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
import AddDialogForm from "../../base/AddDialogForm";

export default {
    name: "AddTreeNode",
    mixins: [AddDialogForm],

    components: {},
    props: {
        selectNode:{

        }
    },
    data() {
        return {
            commitLoading: false,

            form: {
                outline_name: "",
                type: 0
            },
            formRules: {
                outline_name: [
                    {
                        required: true,
                        message: "请输入节点名称",
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
        addCommit(){
            let that = this;
            let data = {};
            data.type = that.form.type;
            if (that.selectNode == null) {
                //没有选中默认为顶级
                // data.p_id = 0;
                // data.outline_name = that.form.outline_name;
            }
            else if (that.selectNode.type == 0) {
                //这是目录，取id作为p_id
                that.form.p_id = that.selectNode.id;
                // data.p_id = that.selectNode.id;
                // data.outline_name = that.form.outline_name;
            }
            else if (that.selectNode.type == 1) {
                //这是案例，取p_id作为p_id
                // data.p_id = that.selectNode.p_id;
                // data.outline_name = that.form.outline_name;
                that.form.p_id = that.selectNode.p_id;
            }
            that.$api.case_template_menu.add(that.form)
                .then(res => {
                    if (res.code == 200) {
                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        that.$emit('add-item', res.data);
                        that.closeDialog();
                    }

                })
                .catch(res => {
                     that.$message.error(
                          res.msg || "操作异常请重试."
                      );
                });
            // console.log(that.form);

        }

    }
};
</script>
<style lang="less" scoped>
.add-tree-node{
    /deep/ .el-dialog__body{
        padding-bottom: 0;
    }
}

</style>