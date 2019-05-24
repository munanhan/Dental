<template>
    <div class="content" ref="Content">
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
                  <el-input v-model="search.name" placeholder="姓名"></el-input>
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
                    v-model="dateRange"
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
              :height="tableHeight"
              style="width: 100%">
              <el-table-column
                prop="case_id"
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
                prop="receipts"
                label="消费总额">
              </el-table-column>
              <el-table-column
                prop="member_level"
                label="会员级别">
              </el-table-column>
              <el-table-column
                prop="phone"
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
      @flush="updateData"
    >
    </set-member-dialog>
 
       <!--分页-->
      <el-row>
          <div class="block">
            <el-pagination
              @size-change="sizeChange"
              @current-change="currentChange"
              :current-page="search.current_page"
              :page-sizes="[10, 15, 20, 25]"
              :page-size="search.page_size"
              layout="total, sizes, prev, pager, next, jumper"
              class="pager"
              background
              :total="total">
            </el-pagination>
          </div>
      </el-row>
    </div>
</template>

<script>
import SetMemberDialog from "./SetMemberDialog";
export default {
    name: 'MemberUpgrade',
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
            total:0,
            editItem:{},
            up_dialog:false,
            tableHeight:700,
            dateRange :[],
            search:{
              current_page:1,
              page_size:15,
              name:'',
              phone:'',
              dtfm:'',
              dtto:'',
              start_money:undefined,
              end_money:undefined
            },
            tableData:[],
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
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.resizeTable();

                //更新原来的refresh, 防止下次点击时不通知更新
                that.$emit("update:refresh", false);

                that.getData();
            }
        }
    },
      computed: {},
      methods: {
        resizeTable() {
            let that = this;
            // console.log(that.$refs.ContentData.clientHeight);
                if (that.$refs.Content.clientHeight != 0) {
                  let tableHeight = that.$refs.Content.clientHeight - 140;
                  that.tableHeight = tableHeight;
                }
            
        },
        currentChange(val){
          //改变当前页
          let that = this;
          that.search.current_page = val;
          //***后端分页***/
          that.getData();
          //*************/
          //***前端分页***/
          // let start = (val-1)*that.page_size;
          // let end = start+that.page_size;
          // if (end >= that.tableData.length) {
          //    end = that.tableData.length;
          // }
          // that.currentData = that.tableData.slice(start,end);
          /****************/
        },
        sizeChange(val){
          //当前页数量
          let that = this;
          /*******后端分页*********/
          that.search.page_size = val;
          that.getData();
          // that.search.current_page = 1;
          // that.tableData = that.tableData.slice(0,that.page_size);
          // that.total = that.tableData.length;
          /***********************/
          /****前端分页*****/
          // that.page_size = val;
          // that.current_page = 1;
          // that.currentData = that.tableData.slice(0,that.page_size);
          // that.total = that.tableData.length;
          /****************/
        },
        showUpDialog(editItem){
            let that = this;
            that.getById(editItem);
            // that.editItem = editItem;
            // that.up_dialog = true;
        },
        getDataDone() {
          setTimeout(() => {
            that.$emit("update:refresh", false);
          }, 6e3);
        },
        /*******获取数据********/
        getData(){
            //获取数据
            let that = this;
            console.log(that.dateRange);
            if (that.dateRange != null ) {
                that.search.dtfm = that.dateRange[0];
                that.search.dtto = that.dateRange[1];
            }
            else{
                that.search.dtfm = undefined;
                that.search.dtto = undefined;
            }

            that.$api.member.get(that.search)
            .then(res => {
               that.tableData = res.data.row;
               that.total = res.data.total;
            })
            .catch(res => {

            });
        },
        getById(parms){
            let that = this;
            let id = parms.id;
            that.$api.member.getById({'id':id})
            .then(res => {
                if (res.code == 200) {
                    that.editItem = res.data;
                    that.up_dialog = true;
                    // that.editMemberDialog = true;
                }else{
                    that.$message.error(
                          res.msg || "操作异常请重试."
                      );
                }
            })
            .catch(res => {

            });
        },
        updateData(data){
            //更新数据
            let that = this;
            for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {
                // console.log(id);
                if (that.tableData[i].id == data.id) {
                     that.$set(that.tableData,i,data);
                     break;
                }
            }
        },
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
    height: 100%;
}
.input_size{
    width:100%;
}
.block{
  padding: 25px;
}
</style>