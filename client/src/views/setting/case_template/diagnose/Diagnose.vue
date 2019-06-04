<template>
    <div class="diagnose">
        <div class="table-container">

            <div class="block-item">
                <div
                    class="block"
                    :style="{
                        width: `${blockWidth}px`
                    }"
                >
                    <el-table
                        :data="diagnoseData"
                        border
                        :height="blockHeight"
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="diagnose_content"
                            label="诊断"
                            align="center"
                            show-overflow-tooltip
                        >
                        </el-table-column>
                        <el-table-column
                            label="操作"
                            align="center"
                            width="100px"
                        >
                            <template slot-scope="scope">
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
                                        @click.stop="showEditDialog('诊断', scope.row)"
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
                                        @click.stop="showDel('diagnoseData',scope.row, scope.$index)"
                                    ></el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
                <div
                    class="block"
                    :style="{
                        width: `${blockWidth}px`
                    }"
                >
                    <el-table
                        :data="propertiesData"
                        border
                        :height="blockHeight"
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="diagnose_content"
                            label="性质"
                            align="center"
                            show-overflow-tooltip
                        >
                        </el-table-column>
                        <el-table-column
                            label="操作"
                            align="center"
                            width="100px"
                        >
                            <template slot-scope="scope">
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
                                        @click.stop="showEditDialog('性质', scope.row)"
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
                                        @click.stop="showDel('propertiesData',  scope.row, scope.$index)"
                                    ></el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
        </div>

        <div
            class="bottom-btn"
            ref="bottom"
            :style="{'display':selectStatus}"
        >
            <el-button
                type="primary"
                class="btn"
                @click="addDiagnoseDialog = true"
            >新增</el-button>

        </div>

        <add-diagnose
            :show.sync="addDiagnoseDialog"
            @add-item="addDiagnoseItem"
            :menu_id="menu_id"
        ></add-diagnose>

        <edit-diagnose
            :show.sync="editDiagnoseDialog"
            :edit-item="currentEditItem"
            :type="editType"
            @edit-item="editItem"
        >
        </edit-diagnose>

    </div>
</template>

<script>
import AddDiagnose from "./AddDiagnose";
import EditDiagnose from "./EditDiagnose";

export default {
    name: "Diagnose",
    components: { AddDiagnose, EditDiagnose },
    props: {
        show: {
            required: true
        },

        height: {
            required: true
        },

        width: {
            required: true
        },
        selectStatus:{
            type:String
        },
        menu_id:{

        },
        data:{

        }
    },
    data() {
        return {

            diagnoseData: [],
            propertiesData: [],

            addDiagnoseDialog: false,
            editDiagnoseDialog: false,

            currentEditItem: {},
            editType: "",

            blockHeight: 100,
            blockWidth: 100
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            //监听事件,由layout那边的resize抛出的
            window.addEventListener("bodyChange", that.resizeContent);
        });
    },
    watch: {
        show(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.diagnoseData = [];
                that.propertiesData = [];

                for (var i = 0,len = that.data.length; i < len; i++) {
                    switch(that.data[i].type){
                        case 0:
                        that.diagnoseData.push(that.data[i]);
                        break;
                        case 1:
                        that.propertiesData.push(that.data[i]);
                        break;
                    }
                }

                that.resizeContent();

                that.$emit("update:show", false);
            }
        },

        width(newValue, oldValue) {
            let that = this;

            that.resizeContent();
        }
    },
    computed: {},
    methods: {
        //计算表格的高度
        resizeContent() {
            let that = this;
            that.blockHeight =
                that.height - that.$refs.bottom.clientHeight - 20;

            that.blockWidth = (that.width - 20) / 2;
        },

        addDiagnoseItem(value) {
            let that = this;
            switch(value.type){
                case 0:
                that.diagnoseData.push(value);
                break;
                case 1:
                that.propertiesData.push(value);
                break;

            }
        },

        //删除
        showDel(type, row, idx) {
            let that = this;
              that.$confirm('删除不可恢复，是否确定删除？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                that.del(row.id,type,idx);
              }).catch(() => {
                that.$message({
                  type: 'info',
                  message: '已取消删除'
                });          
              });
        },

        showEditDialog(type, row) {
            let that = this,
                params = {
                    //根据定义getbyid的field来获取数据
                    [that.getByIDField]: row[that.getByIDField]
                };

            that.editType = type;
            that.selectItem = row;
            that.getById(row);
            // that.editDiagnoseDialog = true;

            // that.$api[that.apiType]
            //     [that.getByIDMethod](params)
            //     .then(res => {
            //         if (res.code == 200) {
            //             that.currentEditItem = res.data;
            //             that.editDialog = true;
            //         } else {
            //             that.$message.error(res.msg || "获取数据失败，请重试.");
            //         }
            //     })
            //     .catch(res => {
            //         that.$message.error("获取数据失败，请重试.");
            //     });
        },
        getById(row){
            //根据id获取
            let that = this;
            let id = row.id
            that.$api.diagnose.getById({'id':id})
                .then(res => {
                    if (res.code == 200) {
                        that.currentEditItem = res.data;
                        that.editDiagnoseDialog = true;
                    } else {
                        that.$message.error(res.msg || "获取数据失败，请重试.");
                    }
                })
                .catch(res => {
                    that.$message.error("获取数据失败，请重试.");
                });
        },
        del(id,type,idx){
            let that = this;
            that.$api.diagnose.del({id})
                .then(res => {
                    if (res.code == 200) {
                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        //删除
                        that[type].splice(idx, 1);
                    } else {
                        that.$message.error(res.msg || "删除失败.");
                    }
                })
                .catch(res => {
                    that.$message.error("删除失败.");
                });
        },

        editItem(data) {
            let that = this;

            //设置数据, TODO
            that.selectItem.diagnose_content = data.diagnose_content;

            that.currentEditItem = null;
            that.editType = "";
        }
    }
};
</script>
<style lang="less" scoped>
.diagnose {
    height: 100%;
    box-sizing: border-box;
    position: relative;

    .table-container {
        display: flex;
        flex-direction: column;
        position: absolute;
        left: 10px;
        right: 10px;
        top: 0;
        bottom: 50px;

        .block-item {
            flex: 1;
            display: flex;
            box-sizing: border-box;
            flex-direction: row;

            &:nth-child(odd) {
                margin-bottom: 5px;
            }

            &:nth-child(even) {
                margin-top: 5px;
            }

            .block {
                flex: 1;
                // border: 1px solid #e3e3e3;

                &:nth-child(odd) {
                    margin-right: 5px;
                }

                &:nth-child(even) {
                    margin-left: 5px;
                }
            }
        }
    }

    .bottom-btn {
        position: absolute;
        height: 50px;
        width: 100%;
        bottom: 0;
        background-color: rgb(227, 227, 227);

        .btn {
            margin: 6px 10px;
        }
    }
}
</style>