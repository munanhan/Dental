<template>
    <div
        class="arrears-patient"
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
                <el-input
                    v-model="search.dim"
                    placeholder="病历号、姓名、电话"
                ></el-input>
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
                class="width100 mb-10 patient-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                :height="tableHeight"
                show-summary
                :summary-method="getSummaries"
            >
                <el-table-column
                    label="就诊日期"
                    width="120"
                    align="center"
                    prop="charge_date"
                >
                </el-table-column>
                <el-table-column
                    prop="case_id"
                    label="病历号"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="patient_name"
                    label="患者姓名"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="arrearage"
                    label="欠费金额"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="doctor"
                    label="医生"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="patient_phone"
                    label="电话1"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="patient_age"
                    label="年龄"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="patient_address"
                    label="地址"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="comment"
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
    name: "ArrearsPatient",
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

            search: {
                dateRange: [new Date(), new Date()],
                dim: ""
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
            parms.dim = that.search.dim;
            // console.log(that.search.dateRange);
            // console.log(that.search.dim);

            that.$api.arrearage_statistics.get(parms)
            .then(res => {
                if (res.code == 200) {
                    that.tableData = res.data;
                }

            })
            .catch(res => {

            });
        },
          getSummaries(param) {
            const { columns, data } = param;
            const sums = [];
            columns.forEach((column, index) => {
              if (index === 0) {
                sums[index] = '合计';
                return;
              }
              const values = data.map(item => Number(item[column.property]));
              
              if (column.property == 'arrearage') {
                  if (!values.every(value => isNaN(value))) {
                    sums[index] = values.reduce((prev, curr) => {
                      const value = Number(curr);
                      if (!isNaN(value)) {
                        return prev + curr;
                      } else {
                        return prev;
                      }
                    }, 0);
                    sums[index] += ' 元';
                  } else {
                    sums[index] = '';
                  }
              }

            });

            return sums;
          },

        exportExcel() {
            let that = this;
            let dtfm = typeof that.search.dateRange[0] == 'object'?
                                that.search.dateRange[0].toLocaleDateString():
                                that.search.dateRange[0];
            let dtto = typeof that.search.dateRange[1] == 'object'?
                                that.search.dateRange[1].toLocaleDateString():
                                that.search.dateRange[1];
            let dim = that.search.dim;

            let url = (window.HOSTNAME || '')+'/api/arrearage_statistics/export?dtfm='+dtfm+'&dtto='+dtto+'&dim='+dim;
            let token = getCookie("token");
            console.log(url);
            downloadFile(url,{'Authorization':token},'欠费患者');
        }
    }
};
</script>
<style lang="less" scoped>
.arrears-patient {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;
}
</style>