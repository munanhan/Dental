<template>
    <div
        class="flow-sheet"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div class="search-item">
                <span class="mr-10">就诊日期</span>
                <el-date-picker
                    v-model="search.dateRange"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                    :picker-options="pickerOptions"
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                    :clearable="false"
                >
                </el-date-picker>
            </div>

            <div class="search-item">
                <span class="mr-10 ml-10">医生</span>
                <el-select
                    v-model="search.doctor"
                    placeholder="请选择医生"
					multiple
					clearable
					collapse-tags
                >
                    <el-option
                        v-for="item in doctors"
                        :key="item.id"
                        :label="item.label"
                        :value="item.id"
                    >
                    </el-option>
                </el-select>
            </div>

            <div class="search-item">
                <el-button
                    type="primary"
                    @click="getData"
                >查询</el-button>
            </div>

            <div class="action-bar-right">
                <el-button
                    type="primary"
                    @click="exportExcel"
                >导出Excel</el-button>
            </div>
        </div>

        <el-row>
            <el-table
                border
                class="width100 mb-10 sheet-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                :height="tableHeight"
                show-summary
            >
                <el-table-column
                    label="单据时间"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="病历号"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="患者姓名"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="单据状态"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="单据编号"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="类型"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="应收"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="实收"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="收银员"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="医生"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
            </el-table>
        </el-row>

        <el-row
            class="pager"
            type="flex"
            justify="end"
        >
            <el-pagination
                @current-change="changePage"
                @size-change="pageSizeChange"
                background
                layout="total, sizes, prev, pager, next, jumper"
                :page-sizes="[10, 20, 50, 100, 200]"
                :page-size="pager.size"
                :total="pager.total"
                :current-page="pager.current"
            ></el-pagination>
        </el-row>

    </div>
</template>

<script>
export default {
    name: "FlowSheet",
    components: {},
    props: {
        update: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            tableHeight: 300,

            tableData: [],

            doctors: [{ id: 0, label: "小李" }, { id: 1, label: "小张" }],

            search: {
                dateRange: [new Date(), new Date()],
                doctor: []
            },

            pager: {
                total: 0,
                current: 1,
                size: 50
            },

            pickerOptions: {
                shortcuts: [
                    {
                        text: "今天",
                        onClick(picker) {
                            picker.$emit("pick", [new Date(), new Date()]);
                        }
                    },
                    {
                        text: "昨天",
                        onClick(picker) {
                            let yesterday = getYesterday();

                            picker.$emit("pick", [yesterday, yesterday]);
                        }
                    },
                    {
                        text: "本周",
                        onClick(picker) {
                            let curWeek = getCurWeek();

                            picker.$emit("pick", [curWeek.start, curWeek.end]);
                        }
                    },
                    {
                        text: "本月",
                        onClick(picker) {
                            let curMonth = getCurMonth();

                            picker.$emit("pick", [
                                curMonth.start,
                                curMonth.end
                            ]);
                        }
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeTable();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeTable);
        } else {
            window.attachEvent("bodyChange", that.resizeTable);
        }
    },
    watch: {
        update(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.resizeTable();

                that.$emit("update:update", false);
            }
        }
    },
    computed: {},
    methods: {
        changePage(index) {
            let that = this;

            if (that.pager) {
                that.pager.current = index;
                that.getData();
            }
        },

        pageSizeChange(val) {
            let that = this;

            if (that.pager) {
                that.pager.size = val;
                that.getData();
            }
        },

        resizeTable() {
            let that = this,
                tableHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.search.clientHeight -
                    70;

            that.tableHeight = tableHeight;
        },

        getData() {
            let that = this;
        },

        exportExcel() {}
    }
};
</script>
<style lang="less" scoped>
.flow-sheet {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;
}
</style>