<template>
    <div>
        <el-dialog
            title="考勤设置"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog attend-dialog"
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
                        prop="attend_type"
                        label="考勤类型"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="attend_color"
                        label="颜色"
                        align="center"
                        show-overflow-tooltip
                    >
                        <!-- prop="attend_color" -->
                        <template slot-scope="scope">
                            <el-color-picker v-model="scope.row.attend_color" @change="(value) => changeColor(scope.row, value)"></el-color-picker>
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="删除"
                        align="center"
                        show-overflow-tooltip
                    >
                        <template slot-scope="scope">

                            <el-tooltip
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
                                    @click.stop="del(scope.row, scope.$index)"
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
                        @click="addAttendSettingDialog = true"
                        :disabled="commitLoading"
                    >新增</el-button>
                </div>

                <el-button
                    type="primary"
                    @click="commit"
                    :loading="commitLoading"
                >确 定</el-button>
            </div>
        </el-dialog>

        <add-attend-setting :show.sync="addAttendSettingDialog"></add-attend-setting>
    </div>
</template>

<script>
import DialogForm from "../base/DialogForm";
import AddAttendSetting from './AddAttendSetting';

export default {
    name: "AttendSetting",
    mixins: [DialogForm],

    components: {AddAttendSetting},
    props: {},
    data() {
        return {
            commitLoading: false,
            tableHeight: 340,

            tableData: [
                { attend_type: "全勤", attend_color: "red" },
                { attend_type: "迟到", attend_color: "blue" }
            ],

            addAttendSettingDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {},
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

        del(row, index) {
            let that = this;
            that.tableData.splice(index, 1);
        },

        commit() {
            let that = this;

            that.$emit("update-pay-type", "");

            that.closeDialog();
        },

        addItem(item) {
            let that = this;

            console.log(item);
        },

        changeColor(row, color){
            let that = this;

            console.log(row, color)
        }
    }
};
</script>
<style lang="less" scoped>
.attend-dialog {
    /deep/ .el-color-picker {
        width: 100%;

        .el-color-picker__trigger {
            width: 100%;
        }
    }
}
</style>