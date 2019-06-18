<template>
    <div>
        <el-dialog
            title="回访计划设置"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog past-medicalhistory"
            :close-on-click-modal="false"
            top="3vh"
            :append-to-body="true"
            width="1000px"
            v-dialog-drag
        >
            <div style="width:970px;height:100%;display:flex">
                <div style="flex:1;text-align:left;width:100px;height:500px">
                    <div style="margin-bottom:5px;display:flex;height:30px;font-size:16px;color:#000">
                        <div style="margin-top:5px;margin-right:10px">计划组合</div>
                        <el-button style="margin-top:-5px;">增加</el-button>
                    </div>
                    <div style="border:1px solid #e3e3e3;height:470px">

                    </div>
                </div>
                <div
                    style="flex:1;text-align:right;"
                    class="content"
                >
                    <el-table
                        border
                        class="width100 mb-10"
                        :data="anamnesis_menu.data"
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        :height="tableHeight"
                    >
                        <el-table-column type="index"></el-table-column>
                        <el-table-column
                            v-for="(item,index) in anamnesis_menu.columns"
                            :key="index"
                            :prop="item.field"
                            :label="item.title"
                        >
                            <template slot-scope="scope">
                                <span v-if="scope.row.isSet">
                                    <el-input
                                        size="mini"
                                        placeholder="请输入内容"
                                        v-model="anamnesis_menu.sel[item.field]"
                                    >
                                    </el-input>
                                </span>
                                <span v-else>{{scope.row[item.field]}}</span>
                            </template>
                        </el-table-column>

                        <el-table-column
                            label="操作"
                            align="center"
                            show-overflow-tooltip
                        >
                            <template slot-scope="scope">
                                <el-button
                                    v-if="scope.row.isSet"
                                    size="mini"
                                    @click="store(scope.row,scope.$index)"
                                >保存
                                </el-button>

                                <el-button
                                    v-else
                                    size="mini"
                                    @click="edit(scope.row,scope.$index)"
                                >修改
                                </el-button>

                                <el-button
                                    v-if="!scope.row.isSet"
                                    size="mini"
                                    type="danger"
                                    @click="del(scope.row,scope.$index)"
                                >删除
                                </el-button>

                                <el-button
                                    v-else
                                    size="mini"
                                    type="danger"
                                    @click="cancel(scope.row,scope.$index)"
                                >取消
                                </el-button>

                            </template>
                        </el-table-column>

                    </el-table>

                </div>
            </div>
            <div
                slot="footer"
                class="dialog-footer "
            >
                <el-button
                    type="primary"
                    @click="addAnamnesisItem"
                    :disabled="commitLoading"
                >
                    新增
                </el-button>

                <el-button @click="closeDialog">关闭
                </el-button>

            </div>
        </el-dialog>
    </div>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";

export default {
    name: "ReturnVisitSetup",
    mixins: [DialogForm],

    components: {},
    props: {},

    data() {
        return {
            addmed_show: false,
            tableHeight: "340px",
            tableData: [],
            anamnesis_menu: {
                sel: null,
                columns: [
                    {
                        field: "name",
                        title: "既往史"
                    }
                ],
                data: []
            }
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.getAnamnesisList();
            }
        }
    },
    computed: {},
    methods: {
        getAnamnesisList() {
            let that = this;
            that.$api.anamnesis
                .get()
                .then(res => {
                    that.anamnesis_menu.data.map(i => {
                        i.id = res.data.id;
                        i.isSet = false;
                        return i;
                    });
                    that.anamnesis_menu.data = res.data;
                })
                .catch(res => {
                    console.log(res);
                });
        },

        //添加账号
        addAnamnesisItem() {
            let that = this;
            for (let i of that.anamnesis_menu.data) {
                if (i.isSet) return that.$message.warning("请先保存当前编辑项");
            }
            let j = { name: "", isSet: true };
            that.anamnesis_menu.data.push(j);
            that.anamnesis_menu.sel = JSON.parse(JSON.stringify(j));
        },

        del(row, index) {
            let that = this;

            console.log(row.id);
            let id = row.id;

            that.$confirm("此操作将永久删除该记录, 是否继续?", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning"
            })
                .then(() => {
                    that.$api.anamnesis.del({ id }).then(res => {
                        if (res.code == 200) {
                            that.anamnesis_menu.data.splice(index, 1);
                            that.$message({
                                type: "success",
                                message: "删除成功!"
                            });
                        }
                    });
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: "已取消删除"
                    });
                });
        },

        store(row, index) {
            let that = this;
            let data = JSON.parse(JSON.stringify(that.anamnesis_menu.sel));

            if (data.name == "" || data.discount == "") {
                that.$message.warning("请填写完成信息");
                return false;
            }

            delete data.isSet;

            that.$api.anamnesis
                .store(data)
                .then(res => {
                    if (res.code == 200) {
                        for (let k in res.data) row[k] = res.data[k];
                        row.isSet = false;
                        that.$message({
                            type: "success",
                            message: "保存成功!"
                        });
                    } else {
                        that.$message({
                            type: "warning",
                            message: res.msg
                        });
                    }
                })
                .catch(res => {
                    console.log(res.data);
                });
        },

        edit(row, index) {
            let that = this;
            for (let i of that.anamnesis_menu.data) {
                if (i.isSet) {
                    that.$message.warning("请先保存当前编辑项");
                    return false;
                }
            }
            that.anamnesis_menu.sel = JSON.parse(JSON.stringify(row));
            that.$set(row, "isSet", true);
        },

        cancel(row, index) {
            let that = this;
            if (!that.anamnesis_menu.sel.id)
                that.anamnesis_menu.data.splice(index, 1);
            row.isSet = false;
        }
    }
};
</script>
<style lang="less" scoped>
.past-medicalhistory {
    /deep/ .el-dialog__header {
        text-align: center;
    }
}
</style>