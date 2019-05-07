<template>
    <div class="home">
        <el-row class="head">
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">今日总诊人数</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0/0</div>
                    <div class="head-button">今日初/复诊人数</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">今日回访</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">今日预约</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">今日新增关注</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">今日应收金额</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">今日实收金额</div>
                </div>
            </el-col>
        </el-row>

        <div class="home-content">
            <div class="table-list">
                <div class="select-list">
                    <div
                        class="select-item"
                        @click="changTable('today_work')"
                    >
                        <div class="select-text"><i class="fa fa-user-astronaut"></i> 今日工作</div>
                    </div>
                    <div
                        class="select-item"
                        @click="changTable('today_visit')"
                    >
                        <div class="select-text"><i class="fa fa-phone-volume"></i> 今日待回访</div>
                    </div>
                    <div
                        class="select-item"
                        @click="changTable('today_receive')"
                    >
                        <div class="select-text"><i class="fa fa-check-square"></i> 今日到件</div>
                    </div>
                    <div
                        class="select-item"
                        @click="changTable('today_balance')"
                    >
                        <div class="select-text"><i class="fa fa-calendar-check"></i> 今日结算</div>
                    </div>
                    <div
                        class="select-item"
                        @click="changTable('today_birthday')"
                    >
                        <div class="select-text"><i class="fa fa-birthday-cake"></i> 今日生日</div>
                    </div>
                </div>

                <div class="table-container">
                    <div
                        v-show="state.today_work"
                        class="table-item"
                    >
                        <el-table
                            :data="tableData"
                            border
                            class="width100"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                prop="date"
                                label="操作"
                                width="80"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="患者姓名"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="状态"
                                width="80"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="病历情况"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="病历号"
                                width="90"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="就诊时间"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="预约时间"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="预约事项"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="医生"
                                width="80"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="电话"
                                width="80"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="就诊状态"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="应收"
                                width="120"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="实收"
                                align="center"
                            >
                            </el-table-column>
                        </el-table>
                    </div>

                    <div
                        v-show="state.today_visit"
                        class="table-item"
                    >
                        <el-table
                            :data="tableData"
                            border
                            class="width100"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                prop="date"
                                label="操作"
                                width="100"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="患者姓名"
                                width="200"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="电话"
                                width="100"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="回访日期"
                                width="220"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="回访人"
                                width="90"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="主治医生"
                                width="200"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="回访内容"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="回访结果"
                                width="200"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="回访状态"
                                width="200"
                                align="center"
                            >
                            </el-table-column>
                        </el-table>
                    </div>

                    <div
                        v-show="state.today_receivec"
                        class="table-item"
                    >
                        <el-table
                            :data="tableData"
                            border
                            class="width100"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                prop="date"
                                label="操作"
                                width="100"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="状态"
                                width="100"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="患者姓名"
                                width="130"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="电话"
                                width="130"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="病历号"
                                width="130"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="加工单位"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="加工单号"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="取件人"
                                width="130"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="送件日期"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="回件日期"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="加工颗数"
                                width="150"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="医生"
                                align="center"
                            >
                            </el-table-column>
                        </el-table>
                    </div>

                    <div
                        v-show="state.today_balance"
                        class="table-item"
                    >
                        <el-table
                            :data="tableData"
                            border
                            class="width100"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                prop="date"
                                label="收费时间"
                                width="240"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="患者姓名"
                                width="240"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="病历号"
                                width="210"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="医生"
                                width="210"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="收银员"
                                width="210"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="本次实收"
                                width="200"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="社保卡"
                                align="center"
                            >
                            </el-table-column>
                        </el-table>
                    </div>

                    <div
                        v-show="state.today_birthday"
                        class="table-item"
                    >
                        <el-button
                            type="primary"
							class="today-birthday-btn"
                        >群发消息</el-button>

                        <el-table
                            border
                            class="width100"
                            :data="tableData"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                type="selection"
                                width="80"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                label="操作"
                                width="120"
                                align="center"
                            >
                                <template slot-scope="scope">{{ scope.row.date }}</template>
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="患者姓名"
                                width="120"
                                align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="电话"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="病历号"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="出生年月"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="年龄"
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
                            <el-table-column
                                prop="address"
                                label="最后发送时间"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                        </el-table>
                    </div>
                </div>
            </div>

        </div>

        <!-- <button @click="test">test</button> -->
    </div>
</template>

<script>
export default {
    name: "Home",

    data() {
        return {
            tableData: [],

            state: {
                today_work: true,
                today_waiting_visit: false,
                today_receivec: false,
                today_balance: false,
                today_birthday: false
            }
        };
    },

    created() {},

    methods: {
        changTable(type) {
            let that = this;

            that.state["today_work"] = "today_work" == type;
            that.state["today_visit"] = "today_visit" == type;
            that.state["today_receivec"] = "today_receive" == type;
            that.state["today_balance"] = "today_balance" == type;
            that.state["today_birthday"] = "today_birthday" == type;
        },

        getData() {
            let that = this;
        },

        // test(){
        //     let that = this;

        //     that.$api.user.getUserInfo();
        // }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.gray-border {
    border: 1px solid #e3e3e3;
}

.bg-white {
    background-color: white;
    box-shadow: 2px 2px 10px #888888;
    .gray-border;
}

.head {
    padding: 10px;
    margin: 10px;
    height: 80px;
    line-height: 30px;
    display: flex;
    .bg-white;

    .head-detail {
        font-size: 18px;
        border-right: 1px solid #e3e3e3;
        cursor: pointer;

        &:last-of-type {
            border-right: 0;
        }

        &:hover {
            .head-item {
                .top,
                .head-button {
					color: @hover-color;
                }
            }
        }

        .head-item {
            .top {
                text-align: center;
                font-size: 30px;
            }

            .head-button {
                text-align: center;
                transition: 0.2s all;
            }
        }
    }
}

.home-content {
    padding: 10px;

    .table-list {
        .bg-white;

        .select-list {
            margin-bottom: 10px;

            .select-item {
                padding: 10px;
                display: inline-block;
                width: 20%;
                box-sizing: border-box;
                text-align: center;
                line-height: 50px;
                cursor: pointer;

                &:hover {
                    .select-text {
                        background-color: @backgroud-color;
                    }
                }

                .select-text {
					.gray-border;
					transition: 0.3s all;
                }
            }
        }

        .table-item {
			padding: 0 10px;
			
			.today-birthday-btn{
				float: right;
				margin-bottom: 10px;
			}
        }
    }
}

</style>