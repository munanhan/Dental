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
                class="width100 mb-10 sheet-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                :height="tableHeight"
                show-summary
                :summary-method="getSummaries"
            >
                <el-table-column
                    label="单据时间"
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
                    prop="status"
                    label="单据状态"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="id"
                    label="单据编号"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="charging_type"
                    label="类型"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="receivable"
                    label="应收"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="receipts"
                    label="实收"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="chshier"
                    label="收银员"
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

            doctors: [],

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
            parms.doctor_id = that.search.doctor;

            parms.current_page = that.pager.current;

            parms.page_size = that.pager.size;

            that.$api.flow_sheet.get(parms)
                .then(res => {
                  if(res.code == 200){
                        that.tableData = res.data.row;
                        that.pager.total = res.data.total;
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

          getSummaries(param) {
            const { columns, data } = param;
            const sums = [];
            columns.forEach((column, index) => {
              if (index === 0) {
                sums[index] = '合计';
                return;
              }
              const values = data.map(item => Number(item[column.property]));
              
              if (column.property == 'receivable' || column.property == 'receipts') {
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

        getSelect(){
            let that = this;
            that.$api.flow_sheet.getSelect()
                .then(res => {
                  if(res.code == 200){
                        that.doctors = res.data;
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
            let doctor = '';

            if (that.search.doctor.length > 0) {
                for (var i = 0,len = that.search.doctor.length; i < len; i++) {
                    doctor+= '&doctor_id[]='+that.search.doctor[i];
                }
            }
            let url = (window.HOSTNAME || '')+'/api/flow_sheet/export?dtfm='+dtfm+'&dtto='+dtto+doctor;
            let token = getCookie("token");
            // console.log(url);
            downloadFile(url,{'Authorization':token},'流水单');
        }
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