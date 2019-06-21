<template>
    <div
        class="expenditure-details"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div class="search-item">
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
                <span class="mr-10 ml-10">经手人</span>
                <el-select
                    v-model="search.doctor"
                    placeholder="请选择经手人"
                    multiple
                    clearable
                    collapse-tags
                >
                    <el-option
                        v-for="item in person_handling"
                        :key="item.id"
                        :label="item.name"
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
                class="width100 mb-10 details-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                :height="tableHeight"
                show-summary
            >
                <el-table-column
                    label="发生日期"
                    width="120"
                    align="center"
                    prop="date"
                >
                </el-table-column>
                <el-table-column
                    prop="handler"
                    label="经手人"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="charge_person"
                    label="负责人"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="expenditure_type"
                    label="支出类别"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="expenditure_content"
                    label="支出明细"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="expenditure_money"
                    label="支出金额"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="expenditure_method"
                    label="付款方式"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="remark"
                    label="备注"
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
import { setCookie,getCookie,downloadFile } from "../../../common/util";
export default {
    name: "ReconCalendar",
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

            person_handling: [],

            search: {
                dateRange: [new Date(), new Date()],
                doctor:[]
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
                that.getSelect();
                that.getData();
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
            let parms = {};
            parms.dtfm = typeof that.search.dateRange[0] == 'object'?
                                that.search.dateRange[0].toLocaleDateString():
                                that.search.dateRange[0];
            parms.dtto = typeof that.search.dateRange[1] == 'object'?
                                that.search.dateRange[1].toLocaleDateString():
                                that.search.dateRange[1];
            parms.handler = that.search.doctor;

            that.$api.expenditure_statistics.get(parms)
                .then(res => {
                  if(res.code == 200){
                        that.tableData = res.data;
                   }
                   else{
                       that.$message.error(
                            res.msg || "get error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });
        },
        getSelect(){
            let that = this;
            that.$api.expenditure_statistics.getSelect()
                .then(res => {
                  if(res.code == 200){
                        that.person_handling = res.data;
                   }
                   else{
                       that.$message.error(
                            res.msg || "get error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });
        },

        exportExcel() {
            let that = this;
            let dtfm = typeof that.search.dateRange[0] == 'object'?
                                that.search.dateRange[0].toLocaleDateString():
                                that.search.dateRange[0];
            let dtto = typeof that.search.dateRange[1] == 'object'?
                                that.search.dateRange[1].toLocaleDateString():
                                that.search.dateRange[1];
            let handler = '';

            if (that.search.doctor.length > 0) {
                for (var i = 0,len = that.search.doctor.length; i < len; i++) {
                    handler+= '&handler[]='+that.search.doctor[i];
                }
            }
            let url = (window.HOSTNAME || '')+'/api/expenditure_statistics/export?dtfm='+dtfm+'&dtto='+dtto+handler;
            let token = getCookie("token");
            console.log(url);
            downloadFile(url,{'Authorization':token},'支出清单');
        }
    }
};
</script>
<style lang="less" scoped>
.expenditure-details {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;
}
</style>