<template>
   <div class="expenditure">
        <div class="left-content">
            <div class="calendar-action">

                <span class="left-action">

                    <span class="ml-20 mr-10">发生日期</span>
                    <i
                        class="fa fa-arrow-circle-left mr-10 pre-mth"
                        @click.prevent.stop="switchDate('pre')"
                    ></i>
                    <!-- <span
                    v-if="curYear != selectYear || curMonth != selectMonth"
                    class="current mr-10"
                    @click.stop="switchDate"
                >今</span> -->
                    <span
                        v-if="!isCurrentDate"
                        class="current mr-10"
                        @click.prevent.stop="switchDate('current')"
                    >今</span>

                    <span
                        v-if="isCurrentDate"
                        class="mr-10"
                    >
                        &nbsp;&nbsp;
                    </span>

                    <!-- <span v-else>&nbsp;&nbsp;&nbsp;</span> -->
                    <i
                        class="fa fa-arrow-circle-right mr-10 next-mth"
                        @click.prevent.stop="switchDate('next')"
                    ></i>

                </span>

                <span class="ml-10 date-type">
                    <el-radio-group
                        v-model="dateType"
                        size="medium"
                        @change="dateTypeChange"
                    >
                        <el-radio :label="0">天</el-radio>
                        <el-radio :label="1">周</el-radio>
                        <el-radio :label="2">月</el-radio>
                    </el-radio-group>
                </span>

            </div>

            <div class="search">
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">从</span>
                        <el-date-picker
                            v-model="search.dtFm"
                            type="date"
                            format="yyyy-MM-dd"
                            value-format="yyyy-MM-dd"
                            :clearable="false"
                            class="search-input"
                            @change="changeData('fm')"
                        >
                        </el-date-picker>
                    </label>
                </div>
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">到</span>
                        <el-date-picker
                            v-model="search.dtTo"
                            type="date"
                            format="yyyy-MM-dd"
                            value-format="yyyy-MM-dd"
                            :clearable="false"
                            class="search-input"
                            @change="changeData('to')"
                        >
                        </el-date-picker>
                    </label>
                </div>
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">支出类型</span>
                        <el-select
                            v-model="search.payType"
                            collapse-tags
                            class="search-input"
                        >
                            <el-option
                                v-for="item in payType"
                                :key="item.id"
                                :label="item.label"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </label>
                </div>
                <div class="btn-container">
                    <div class="btn-item mr-10">
                        <el-button
                            type="primary"
                            class="btns"
                            @click="getData"
                        >查询</el-button>
                    </div>
                    <div class="btn-item ml-10">
                        <el-button
                            class="btns"
                            @click="exportExcel"
                        >导出Excel</el-button>
                    </div>

                </div>
            </div>
        </div>
        <div
            class="right-content"
            ref="content"
        >
            <div
                class="right-head"
                ref="head"
            >
                <span>
                    {{dateFmText}}
                </span>
                <span class="ml-10 mr-10">
                    -
                </span>
                <span class="mr-10">
                    {{dateToText}}
                </span>
                <span class="mr-10">
                    (共{{dateCount}}天)
                </span>

                <span class="ml-10">
                    <el-button
                        type="primary"
                        class="btns"
                        @click="addPayDialog = true"
                    >新增支出</el-button>
                </span>
            </div>

            <div class="pay-table">
                <el-table
                    border
                    class="width100 mb-10"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                    show-summary
                >
                    <el-table-column
                        prop="address"
                        label="删除"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="编辑"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="发生日期"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="经手人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="负责人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="支出类别"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="支出明细"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="支出金额"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="付款方式"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="备注"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                </el-table>
            </div>
        </div>

        <pay-dialog :show.sync="addPayDialog"></pay-dialog>
    </div>
</template>

<script>
export default {
    name: 'Disinfect',
    components:{},
    props:{},
    data(){
      return {
      }
    },
    created(){},
    mounted(){},
    watch:{},
    computed:{},
    methods:{},
}
</script>
<style lang="less" scoped>

</style>