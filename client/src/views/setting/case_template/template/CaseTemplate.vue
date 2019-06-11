<template>
    <div class="case-template">
        <table
            class="case-table"
            cellspacing="0"
        >
            <tbody>
                <tr>
                    <td class="case-title">主诉</td>
                    <td>
                        <el-input
                            v-model.trim="form.main_complain"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">现病史</td>
                    <td>
                        <el-input
                            v-model.trim="form.now_history"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">既往史</td>
                    <td>
                        <el-input
                            v-model.trim="form.previous_history"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">检查</td>
                    <td>
                        <el-input
                            type="textarea"
                            v-model.trim="form.inspect"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">辅助检查</td>
                    <td>
                        <el-input
                            v-model.trim="form.auxiliary"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">诊断</td>
                    <td>
                        <el-input
                            type="textarea"
                            v-model.trim="form.diagnosis"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">治疗方案</td>
                    <td>
                        <el-input
                            v-model.trim="form.treatment_plan"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">治疗</td>
                    <td>
                        <el-input
                            type="textarea"
                            v-model.trim="form.treatment"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
                <tr>
                    <td class="case-title">医嘱</td>
                    <td>
                        <el-input
                            v-model.trim="form.doctor_advice"
                            autocomplete="off"
                            :disabled="isDisabled"
                        ></el-input>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="bottom-container" :style="{'display':selectStatus}">

            <div v-if="isDisabled">
                <el-button
                    type="primary"
                    @click="isDisabled = false"
                    class="btn"
                >编辑</el-button>

            </div>

            <div v-else>

                <el-button
                    type="primary"
                    @click="saveChange"
                    class="btn save"
                >保存</el-button>

                <el-button @click="cancel">取消</el-button>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "CaseTemplate",
    components: {},
    props: {
		data:{
			type: Object,
			required: true
		},
        selectStatus:{
            type:String
        },
        menu_id:{

        }
	},
    data() {
        return {
            form: {
                
            },

            isDisabled: true,

        };
    },
    created() {},
    mounted() {},
    watch: {
		data(newValue, oldValue){
            if (newValue) {
                let that = this;
                that.isDisabled = true;
                that.form = that.data;
            }
		}

	},
    computed: {},
    methods: {
		getData(){
			let that = this;

			console.log('*****************')
		},

        saveChange() {
            let that = this;
            that.form.menu_id = that.menu_id;
            // console.log(that.form);
            that.form.id == undefined?that.addData():that.updateData();


        },
        addData(){
            let that = this;
            that.$api.case_template.add(that.form)
            .then(res => {
                if (res.code == 200) {
                        that.$message({
                            message: "修改成功.",
                            type: "success",
                            duration: 800
                        });
                        that.isDisabled = true;
                }
                else{
                       that.$message.error( res.msg || "数据获取失败." );
                }
                
            })
            .catch(res => {

            });
        },
        updateData(){
            let that = this;
            that.$api.case_template.update(that.form)
            .then(res => {
                if (res.code == 200) {
                        that.$message({
                            message: "修改成功.",
                            type: "success",
                            duration: 800
                        });
                        that.isDisabled = true;
                }
                else{
                       that.$message.error( res.msg || "数据获取失败." );
                }
                
            })
            .catch(res => {

            });
        },

        cancel() {
            let that = this;

            //如果取消的话，建议重新拿数据，不拿的话，先deep copy一份数据

            that.isDisabled = true;
        }
    }
};
</script>
<style lang="less" scoped>
.case-template {
    position: relative;

    .case-table {
        border: 1px solid #e3e3e3;
        margin: 0 10px;
        width: 100%;
        box-sizing: border-box;

        .case-title {
            width: 140px;
            text-align: center;
            background-color: #f9f9f9;
        }

        td {
            border: 1px solid #e3e3e3;
            /deep/ .el-input__inner,
            /deep/ .el-textarea__inner {
                border-radius: 0;
                border: none;
                resize: none;
            }
        }
    }

    .bottom-container {
        position: absolute;
        height: 50px;
        background-color: rgb(227, 227, 227);
        left: 0;
        right: 0;
        bottom: 2px;

        .btn {
            margin: 6px 10px;

            &.save {
                margin-right: 0;
            }
        }
    }
}
</style>