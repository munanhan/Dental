<template>
    <div class="treat">
        <div class="table-container">

            <div class="block-item">
                <div
                    class="block"
                    :style="{
                        width: `${blockWidth}px`
                    }"
                >
                    <el-table
                        :data="preparationData"
                        :height="blockHeight"
                        border
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="备牙"
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
                                        @click.stop="showEditDialog('备牙', scope.row)"
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
                                        @click.stop="del('preparationData',scope.row, scope.$index)"
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
                        :data="investData"
                        :height="blockHeight"
                        border
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="充值"
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
                                        @click.stop="showEditDialog('充值', scope.row)"
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
                                        @click.stop="del('investData',  scope.row, scope.$index)"
                                    ></el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>

            <div class="block-item">
                <div
                    class="block"
                    :style="{
                        width: `${blockWidth}px`
                    }"
                >
                    <el-table
                        :data="medicinalData"
                        :height="blockHeight"
                        border
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="药物"
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
                                        @click.stop="showEditDialog('药物', scope.row)"
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
                                        @click.stop="del('medicinalData', scope.row, scope.$index)"
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
                        :data="otherData"
                        :height="blockHeight"
                        border
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="其他"
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
                                        @click.stop="showEditDialog('其他', scope.row)"
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
                                        @click.stop="del('otherData', scope.row, scope.$index)"
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
                @click="AddTreatDialog = true"
            >新增</el-button>
        </div>

        <add-treat
            :show.sync="AddTreatDialog"
            @add-item="addTreat"
        ></add-treat>

        <edit-treat
            :show.sync="editTreatDialog"
            :edit-item="currentEditItem"
            :type="editType"
            @edit-item="editItem"
        >
        </edit-treat>
    </div>
</template>

<script>
import AddTreat from "./AddTreat";
import EditTreat from "./EditTreat";

export default {
    name: "Treat",
    components: { AddTreat, EditTreat },
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
        }
    },
    data() {
        return {
            preparationData: [],
            investData: [],
            medicinalData: [],
            otherData: [],

            AddTreatDialog: false,
            editTreatDialog: false,

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
                that.resizeContent();

                that.$emit("update:show", false);
            }
        },

        height(newValue, oldValue) {
            let that = this;

            that.resizeContent();
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
                (that.height - that.$refs.bottom.clientHeight - 20) / 2;

            that.blockWidth = (that.width - 20) / 2;
        },

        addTreat() {
            let that = this;
        },

        //删除
        del(type, row, idx) {
            let that = this;

            //删除
            that[type].splice(idx, 1);
        },

        showEditDialog(type, row) {
            let that = this,
                params = {
                    //根据定义getbyid的field来获取数据
                    [that.getByIDField]: row[that.getByIDField]
                };

            that.editType = type;
            that.selectItem = row;

            that.editTreatDialog = true;

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

        editItem(data) {
            let that = this;

            //设置数据, TODO
            that.selectItem.text = data.aaa;

            that.currentEditItem = null;
            that.editType = "";
        }
    }
};
</script>
<style lang="less" scoped>
.treat {
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