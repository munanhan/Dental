<template>
    <div>
        <el-dialog
            title="付款方式选择"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog pay-dialog"
            :close-on-click-modal="false"
            v-dialog-drag
        >
            <div class="content">
                <!-- <div class="letf-content"> -->
                <el-table
                    border
                    class="width100 mb-10"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                >
                    <el-table-column
                        prop="expenditure_method"
                        label="支出类型"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        label="删除"
                        align="center"
                        show-overflow-tooltip
                    >
                        <template slot-scope="scope">

                            <!-- <el-tooltip
                                effect="dark"
                                content="上移"
                                placement="bottom"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-arrow-up"
                                    circle
                                    @click.stop="move(-1, scope.$index)"
                                ></el-button>
                            </el-tooltip>

                            <el-tooltip
                                effect="dark"
                                content="下移"
                                placement="bottom"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-arrow-down"
                                    circle
                                    @click.stop="move(1, scope.$index)"
                                ></el-button>
                            </el-tooltip> -->
                            <el-tooltip
                                effect="dark"
                                content="修改"
                                placement="bottom"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-edit"
                                    circle
                                    @click.stop="showEdit(scope.row)"
                                ></el-button>
                            </el-tooltip>
                            <el-tooltip
                                effect="dark"
                                content="删除"
                                placement="bottom"
                            >
                                <el-button
                                    type="danger"
                                    size="mini"
                                    icon="el-icon-delete"
                                    circle
                                    @click.stop="showDel(scope.row, scope.$index)"
                                ></el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div
                slot="footer"
                class="dialog-footer"
            >
                <div class="pull-left">
                    <el-button
                        type="primary"
                        @click="addPayTypeDialog = true"
                        :disabled="commitLoading"
                    >新增</el-button>
                </div>

                <!-- <div>
                    <el-button
                        @click="closeDialog"
                        :disabled="commitLoading"
                    >取 消</el-button>
                </div> -->
                <el-button
                    type="primary"
                    @click="commit"
                    :loading="commitLoading"
                >确 定</el-button>
                <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
            </div>
        </el-dialog>

        <add-pay-type
            :show.sync="addPayTypeDialog"
            @add-item="addItem"
        ></add-pay-type>

        <edit-pay-type
            :show.sync="editExpendDialog"
            :editItem="editItem"
            @edit-item="flush"
        ></edit-pay-type>
    </div>
</template>

<script>
import DialogForm from "../base/DialogForm";
import AddPayType from "./AddPayType";
import EditPayType from "./EditPayType";


export default {
    name: "PayType",
    mixins: [DialogForm],

    components: { AddPayType,EditPayType },
    props: {},
    data() {
        return {
            commitLoading: false,
            tableHeight: 340,
            tableData: [],

            addPayTypeDialog: false,
            editExpendDialog:false,

            editItem:{},
            selectRow:{},
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue,oldValue){
            if (newValue) {
            let that = this;
            that.$api.expenditure_method.get()
                .then(res => {
                  if(res.code == 200){
                        that.tableData = res.data;

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
    },
    computed: {},
    methods: {
        //交换位置
        move(act, index) {
            let that = this,
                moveIdx = index + act;

            if (moveIdx != -1 && moveIdx != that.tableData.length) {
                that.tableData[index] = that.tableData.splice(
                    moveIdx,
                    1,
                    that.tableData[index]
                )[0];
            }
        },

        showDel(row,index){
            let that = this;
              that.$confirm('删除不可恢复，是否确定删除？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                that.del(row.id,index);
              }).catch(() => {
                that.$message({
                  type: 'info',
                  message: '已取消删除'
                });          
              });
        },

        del(id, index) {
            let that = this;
            that.$api.expenditure_method.del({id})
                .then(res => {
                    if (res.code == 200) {
                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        //删除
                        that.tableData.splice(index, 1);
                    } else {
                        that.$message.error(res.msg || "删除失败.");
                    }
                })
                .catch(res => {
                    that.$message.error("删除失败.");
                });
        },

        showEdit(row){
            let that = this;
            let id = row.id;
            that.selectRow = row;
            that.$api.expenditure_method.getById({id:id})
                .then(res => {
                    if (res.code == 200) {
                        // that.$message({
                        //     message: res.msg,
                        //     type: "success",
                        //     duration: 800
                        // });

                            that.editItem = res.data;
                            that.editExpendDialog = true;

                    } else {
                        that.$message.error(res.msg || "获取失败.");
                    }
                })
                .catch(res => {
                    that.$message.error("获取失败.");
                });

        },

        commit() {
            let that = this;

            // that.$emit('update-category', '');

            that.closethisDialog();

        },

        flush(data){
            let that = this;
            that.selectRow.expenditure_method = data.expenditure_method;

        },

        addItem(item) {
            let that = this;
            that.tableData.push(item);
            // console.log(item);
        },
        closethisDialog(){
            let that = this;
            that.$emit('update-pay-type', that.tableData);
            setTimeout(() => {
                //允许用户自定义关闭窗口后的动作
                that.closeDialog();
            }, 200);
        }
    }
};
</script>
<style lang="less" scoped>
</style>