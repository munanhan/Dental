<template>
    <el-dialog
        title="新增计划组合"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        :append-to-body="true"
        v-dialog-drag
        width="500px"
    >
        <!-- :model="changePwd" -->
        <el-form
            ref="form"
            :model="form"
            label-width="100px"
            :rules="rules"
        >
            <el-form-item
                label="组合名称"
                prop="name"
            >
                <el-input
                    style="width:350px"
                    v-model="form.name"
                    type="text"
                    autocomplete="off"
                ></el-input>
            </el-form-item>
        </el-form>
            <!-- class="dialog-footer" -->
        <div
            slot="footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button type="primary" @click="submit('form')">确 定</el-button>
            <!-- :loading="commitLoading" -->
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddProjectPortfolio",

    mixins: [DialogForm],

    data() {
        return {
            form: {
                name: ""
            },
            rules: {
                name:{
                    required: true,
                    message: "请输入组合名称",
                    trigger: "blur"
                },
            }
        };
    },

    methods: {
        submit(form){
            let that=this;
            that.$refs[form].validate(validate=>{
                if(validate){
                    that.$api.visit_combo.store(that.form)
                        .then(res=>{
                            if(res.code==200){
                                that.$emit('add-item',JSON.parse(JSON.stringify(res.data)));
                                that.closeDialog();
                                that.$message.success(res.msg);
                            }
                        })
                        .catch(console.log(res))
                }
            })
        }
    }
};
</script>
<style lang="less" scoped>
</style>