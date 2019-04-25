<template>
    <div class="content">
      <el-row :gutter="10">
        <!-- <el-col :span="21">
          <el-input placeholder="请输入姓名" v-model="staff" class="">
            <template slot="prepend">员工姓名</template>
              <el-button slot="append" icon="el-icon-search" @click="search"></el-button>
            </el-input>
        </el-col>
        <el-col :span="3" class="btn_class">
          <el-button
                  type="primary"
                  @click="addDialog = true"
                  >
                  添加员工
          </el-button>
        </el-col> -->
      <div class="search">
        <el-col :span="3">
              <span class="mr10">
                  <el-input v-model="search.staff" placeholder="姓名"></el-input>
              </span>
        </el-col>
        <el-col :span="3">
              <span class="mr10">
                  <el-input v-model="search.phone" placeholder="电话"></el-input>
              </span>
        </el-col>
        <el-col :span="6">
              <span class="mr10">
                  <el-date-picker
                    v-model="search.dateRange"
                    type="daterange"
                    class="input_size"
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期">
                  </el-date-picker>
              </span>
        </el-col>
        <el-col :span="3">
              <span class="mr10">
                  <el-input-number v-model="search.start_money" placeholder="最小金额" :precision="2" :step="0.1" :min="0" controls-position="right" class="input_size"></el-input-number>
              </span>
        </el-col>
        <el-col :span="3">
              <span class="mr10">
                  <el-input-number v-model="search.end_money" placeholder="最大金额" :precision="2" :step="0.1" :min="0" controls-position="right" class="input_size"></el-input-number>
              </span>
        </el-col>
        <el-col :span="2">
              <span class="">
                  <el-button type="primary" @click="getData">查询</el-button>
              </span>
        </el-col>

      </div>
      </el-row>

      <el-row>
        <el-col :span="24">
          <div>
            <el-table
              :data="tableData"
              style="width: 100%">
              <el-table-column
                prop="case_no"
                label="病历号"
                >
              </el-table-column>
              <el-table-column
                prop="name"
                label="患者姓名"
              >
              </el-table-column>
              <el-table-column
                prop="age"
                label="年龄">
              </el-table-column>
              <el-table-column
                prop="sex"
                label="性别">
              </el-table-column>
              <el-table-column
                prop="phone"
                label="电话">
              </el-table-column>
              <el-table-column
                prop="sale_total"
                label="消费总额">
              </el-table-column>
              <el-table-column
                prop="mem_level"
                label="会员级别">
              </el-table-column>
              <el-table-column
                prop="mem_card"
                label="会员卡号">
              </el-table-column>
              <el-table-column
                prop="up_mem"
                label="升级会员">

                    <template slot-scope="scope">
                      <el-tooltip
                            effect="dark"
                            content="升级会员"
                            placement="bottom"
                        >
                            <el-button
                                type="primary"
                                size="mini"
                                icon="el-icon-edit"
                                circle
                                @click.stop="showUpDialog(scope.row)"
                            ></el-button>
                        </el-tooltip>
                    </template>
              </el-table-column>
            </el-table>
          </div>
        </el-col>
      </el-row>

   
    <!-- 弹出会员升级 -->
    <set-member-dialog 
      :show.sync="up_dialog"
      :editItem="editItem"
    >
    </set-member-dialog>
 
    </div>
</template>

<script>
import SetMemberDialog from "./SetMemberDialog";
export default {
    name: 'Index',
    components: {
      SetMemberDialog
    },
      props: {
        refresh: {
          type: Boolean,
          required: true
        }
      },
      data() {
        return {
            editItem:{},
            up_dialog:false,
            search:{
              dateRange :[],
              staff:'',
              phone:'',
              dtfm:'',
              dtto:'',
              start_money:'',
              end_money:''
            },
            tableData:[{
              case_no:'001',
              name:'琳',
              age:18,
              sex:'女',
              phone:'138888888',
              sale_total:123.06,
              mem_level:'黄金会员',
              mem_card:'huanjin001',
              mem_up:''

          }]
        };
      },
      created() {},
      mounted() {},
      watch: {
        refresh(newValue, oldValue) {
          let that = this;

          if (newValue) {
            that.getPatientInfo();
          }
        }
      },
      computed: {},
      methods: {
        getPatientInfo() {
          let that = this;

          that.$api.aaaa.aaaa
            .then(res => {
              that.getDataDone();
            })
            .catch(res => {
              that.getDataDone();
            });
        },
        getData() {
            let that = this;
                that.search.dtfm = that.search.dateRange[0];
                that.search.dtto = that.search.dateRange[1];
                console.log(that.search);
            // that.pager.current = 1;

            // if (that.$check_pm("report_candidate_info_statistics")) {
            //     //权限
            //     that.getCandidateInfoStatistics(params);
            // } else {
            //     that.$message.error("无此权限.");
            // }
        },
        showUpDialog(editItem){
            let that = this;
            that.editItem = editItem;
            that.up_dialog = true;
        },

        getDataDone() {
          setTimeout(() => {
            that.$emit("update:refresh", false);
          }, 6e3);
        }
      }
}
</script>
<style lang="less" scoped>
.staff_name{
  padding: 10px;
}
.btn_class{
    background: white;
    text-align: center;
}
.search {
    padding: 10px;
    border-bottom: 1px solid #e3e3e3;
    height: 40px;
    width: 100%;
    background: white;
}
.content{
    background: white;
    height: 800px;
}
.input_size{
    width:100%;
}
</style>