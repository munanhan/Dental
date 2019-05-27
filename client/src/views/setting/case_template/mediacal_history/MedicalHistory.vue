<template>
    <div class="medical-history">
        <div class="table-container">

            <div class="block-item">
                <div class="block">
                    <el-table
                        :data="partData"
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="部位"
                            align="center"
                            show-overflow-tooltip
                        >
                        </el-table-column>
                        <el-table-column
                            label="删除"
                            align="center"
                            width="100px"
                        >
                            <template slot-scope="scope">

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
                                        @click.stop="del('partData',scope.row, scope.$index)"
                                    ></el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
                <div class="block">
                    <el-table
                        :data="propertiesData"
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="性质"
                            align="center"
                            show-overflow-tooltip
                        >
                        </el-table-column>
                        <el-table-column
                            label="删除"
                            align="center"
                            width="100px"
                        >
                            <template slot-scope="scope">

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
                                        @click.stop="del('propertiesData',  scope.row, scope.$index)"
                                    ></el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>

            <div class="block-item">
                <div class="block">
                    <el-table
                        :data="timeData"
                        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    >
                        <el-table-column
                            prop="attend_type"
                            label="时间"
                            align="center"
                            show-overflow-tooltip
                        >
                        </el-table-column>
                        <el-table-column
                            label="删除"
                            align="center"
                            width="100px"
                        >
                            <template slot-scope="scope">

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
                                        @click.stop="del('timeData', scope.row, scope.$index)"
                                    ></el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>

                <div class="block">
                    <el-table
                        :data="otherData"
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
                            label="删除"
                            align="center"
                            width="100px"
                        >
                            <template slot-scope="scope">

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

        <div class="bottom-btn">
            <el-button
                type="primary"
                class="btn"
                @click="addMedicalDialog = true"
            >新增</el-button>

        </div>

        <add-medical
            :show.sync="addMedicalDialog"
            @add-item="addMedicalItem"
        ></add-medical>

    </div>
</template>

<script>
import AddMedical from "./AddMedical";

export default {
    name: "MedicalHistory",
    components: { AddMedical },
    props: {},
    data() {
        return {
            partData: [],
            propertiesData: [],
            timeData: [],
            otherData: [],

            addMedicalDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        addMedicalItem() {
            let that = this;
        },

        //删除
        del(type, row, idx) {
            let that = this;

            //删除
            that[type].splice(idx, 1);
        }
    }
};
</script>
<style lang="less" scoped>
.medical-history {
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
                border: 1px solid #e3e3e3;

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