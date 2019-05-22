<template>
    <el-dialog
        title="关联分诊所"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-store"
        :close-on-click-modal="false"
        v-dialog-drag
        width="600px"
    >
        <el-form
            :model="form"
            :rules="formRules"
            label-width="100px"
        >
            <el-form-item
                label="管家号"
                prop="no"
            >
                <el-input
                    v-model.trim="form.no"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="验证码"
                prop="identifying_code"
            >

                <div class="id-code">
                    <el-input
                        v-model.trim="form.identifying_code"
                        autocomplete="off"
                        placeholder="请输入验证码"
                        class="id-code-text"
                    ></el-input>

                    <el-button
                        type="primary"
                        @click="getIdentCode"
                        :disabled="watting"
                        class="id-send-btn"
                    >{{idCodeText}}</el-button>
                </div>

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
import DialogForm from "../../base/DialogForm";
export default {
    name: "AddStoreDialog",
    mixins: [DialogForm],

    components: {},
    props: {},
    data() {
        return {
            idCodeText: "获取验证码",
            watting: false,

            form: {
                no: "",
                identifying_code: ""
            },
            formRules: {
                no: [
                    {
                        required: true,
                        message: "请输入管家号",
                        trigger: "blur"
                    }
                ],
                identifying_code: [
                    {
                        required: true,
                        message: "请输入验证码",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        getIdentCode() {
            let that = this,
                count = 60,
                timer = null;

            that.watting = true;

            timer = setInterval(() =>{
                if(count == 0){
                    that.watting = false;
                    that.idCodeText = '获取验证码';

                    clearInterval(timer);
                }else{
                    that.idCodeText = count--;    
                }
            }, 1e3);
        },

        addCommit() {},

    }
};
</script>
<style lang="less" scoped>
.add-store {
    .id-code {
        display: flex;

        .id-send-btn{
            width: 120px;
        }

        .id-code-text {
            flex: 1;
            margin-right: 10px;
            width: 120px;
        }
    }
}
</style>