<template>
        <el-dialog
        title="修改节点"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog edit-tree-node"
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
            <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
        </div>
    </el-dialog>
</template>

<script>
import EditDialogForm from "../../base/EditDialogForm";
export default {
    name: 'EditTreeNode',
    mixins: [EditDialogForm],

    components:{},
    props:{},

    data(){
      return {
          apiType: "",
          formRules:{
                 outline_name: [
                                    {
                                      required: true,
                                      message:'请输入目录名称.',
                                      trigger: "blur"
                                    }
                                ],

            },
      }
    },
    created(){},
    mounted(){},
    watch:{},
    computed:{},
    methods:{
    },
}
</script>
<style lang="less" scoped>
.edit-tree-node{
    /deep/ .el-dialog__body{
        padding-bottom: 0;
    }
}
</style>