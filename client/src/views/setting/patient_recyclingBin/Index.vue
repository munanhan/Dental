<template>
    <div class="content" ref="Content">
      <el-row :gutter="10">
      <div class="search">
        <el-col :span="3">
              <span class="mr10">
                  <el-input v-model="search.patient_name" placeholder="姓名"></el-input>
              </span>
        </el-col>
        <el-col :span="3">
              <span class="mr10">
                  <el-input v-model="search.patient_phone" placeholder="电话"></el-input>
              </span>
        </el-col>
        <el-col :span="2">
              <span class="">
                  <el-button type="primary" @click="getData">查询</el-button>
              </span>
        </el-col>
        <el-col :span="2">
              <span class="">
                  <el-button type="primary" @click="delAll">批量删除</el-button>
              </span>
        </el-col>

      </div>
      </el-row>

      <el-row>
        <el-col :span="24">
          <div>
            <el-table
              :data="tableData"
              style="width: 100%"
              @selection-change="selectThis"
              ref="multipleTable"
              :height="tableHeight"
              >
              <el-table-column
                type="selection"
                width="55"
              >
              </el-table-column>
              <el-table-column
                prop="patient_name"
                label="患者姓名"
              >
              </el-table-column>
              <el-table-column
                prop="patient_age"
                label="年龄">
              </el-table-column>
              <el-table-column
                prop="patient_sex"
                label="性别">
              </el-table-column>
              <el-table-column
                prop="patient_phone"
                label="电话">
              </el-table-column>
              <el-table-column
                prop="patient_source"
                label="患者来源">
              </el-table-column>
              <el-table-column
                prop="patient_content"
                label="患者备注">
              </el-table-column>
              <el-table-column
                prop="group"
                label="分组">
                <!-- <template slot-scope="scope">
                  <div v-if="scope.row.group == 0">
                    最近患者
                  </div>
                  <div v-if="scope.row.group == 1">
                    黑名单
                  </div>
                  <div v-if="scope.row.group == 2">
                    治疗完成
                  </div>
                </template> -->
              </el-table-column>
              <el-table-column
                prop="operation"
                label="操作">

                    <template slot-scope="scope">
                      <el-tooltip
                            effect="dark"
                            content="还原"
                            placement="bottom"
                        >
                            <el-button
                                type="primary"
                                size="mini"
                                icon="el-icon-upload2"
                                circle
                                @click.stop="update(scope.row.id)"
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
                                @click.stop="showDel(scope.row.id)"
                            ></el-button>
                        </el-tooltip>
                    </template>

              </el-table-column>
            </el-table>
          </div>
        </el-col>
      </el-row>
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
    <!-- 删除提示框 -->
    <el-dialog title="提示" :visible.sync="is_del" width="300px" center>
       <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div> 
       <span slot="footer" class="dialog-footer">
          <el-button @click="is_del = false">取 消</el-button>
          <el-button type="primary" @click="del" >确 定</el-button>
      </span>
    </el-dialog>
    </div>
</template>

<script>

export default {
    name: 'PatientRecyclingBin',
    components: {
      
    },
      props: {
        refresh: {
          type: Boolean,
          required: true
        }
      },
      data() {
        return {
            tableHeight:700,
            select_group:[],
            // current_page:1,
            // page_size:5,
            is_del:false,
            del_id:0,
            total:0,
            search:{
              name:'',
              phone:'',
              current_page:1,
              page_size:10
            },
            // currentData:[{}],
            tableData:[
            // {
            //   id:1,
            //   name:'琳',
            //   age:18,
            //   sex:'女',
            //   phone:'138888888',
            //   patient_source:'网站',
            //   content:'蛀牙',
            //   group:2

            // },
            // {
            //   id:2,
            //   name:'为',
            //   age:22,
            //   sex:'女',
            //   phone:'138888898',
            //   patient_source:'朋友介绍',
            //   content:'换牙',
            //   group:1

            // },
            // {
            //   id:3,
            //   name:'张三',
            //   age:18,
            //   sex:'男',
            //   phone:'138888888',
            //   patient_source:'网站',
            //   content:'蛀牙',
            //   group:2

            // },
            // {
            //   id:4,
            //   name:'李四',
            //   age:18,
            //   sex:'女',
            //   phone:'138888888',
            //   patient_source:'网站',
            //   content:'拔牙',
            //   group:2

            // },
            // {
            //   id:5,
            //   name:'严',
            //   age:18,
            //   sex:'男',
            //   phone:'138888888',
            //   patient_source:'网站',
            //   content:'牙疼',
            //   group:0

            // },
            // {
            //   id:6,
            //   name:'赵六',
            //   age:18,
            //   sex:'男',
            //   phone:'138888888',
            //   patient_source:'网站',
            //   content:'牙疼',
            //   group:0

            // }
          ]
        };
      },
      created() {
        let that = this;
        // that.current_page = 1;
        // that.currentData = that.tableData.slice(0,that.page_size);
        // that.total = that.tableData.length;
      },
      mounted() {
        let that = this;

        that.$nextTick(() => {
            that.getData();
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
        selectThis(val){
          //选中
          let that = this;
          that.select_group = [];
          for (var i = 0; i < val.length; i++) {
              that.select_group.push(val[i].id);
           }
        },
        showDel(id){
          let that = this;
          that.del_id = id;
          that.is_del = true;
        },
        del(){
          let that = this;
          let id = that.del_id;
          that.$api.patient_recycling_bin.del({id})
          .then(res => {
            if (res.code == 200) {
              for (var i = 0, length = that.tableData.length - 1; i < length; i++) {
                 if (that.tableData[i].id == id) {

                     that.tableData.splice(i,1);
                     that.total = that.total-1;
                 }
              }
              that.$message({
                  message: res.msg,
                  type: "success",
                  duration: 800
              });
              that.is_del = false;
            }
            else{
              that.$message.error(
                            res.msg || "操作异常请重试."
                        );
            }
              

              
          })
          .catch(res => {
            console.log(res);
          });

        },
        delAll(){
          let that = this;
          let length = that.tableData.length - 1,
              quickKey = {};

          for(var i = 0; i <= length; i ++){
            quickKey[that.select_group[i]] = true;

          }

          that.$api.patient_recycling_bin.delAll({'id':that.select_group})
          .then(res => {
              let newData = [];
              for(var i = 0; i < that.tableData.length; i++){
                var item = that.tableData[i];

                if(!quickKey[item.id]){
                  newData.push(item);
                }
                else{
                  that.total = that.total-1;
                }
              }

              that.tableData = newData;


              // for (var i = length; i > 0; i--) {
              //    if (that.select_group.includes(that.tableData[i].id)) {
                     
              //    }
              // }

          })
          .catch(res => {
            console.log(res);
          });

          // console.log(that.select_group);
        },
        update(id){
          let that = this;

          that.$api.patient_recycling_bin.reduction({id})
          .then(res => {
              for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {
                 if (that.tableData[i].id == id) {

                     that.tableData.splice(i,1);
                 }
              }
          })
          .catch(res => {
            // console.log(res);
          });
        },
        getData() {
            let that = this;
            //     that.search.dtfm = that.search.dateRange[0];
            //     that.search.dtto = that.search.dateRange[1];
                // console.log(that.search); 
            // that.pager.current = 1;

            that.$api.patient_recycling_bin.get(that.search)
            .then(res => {
               that.tableData = res.data.row;
               that.total = res.data.total;
            })
            .catch(res => {

            });

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
//导入全局的颜色
@import "~@css/var";
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
.pager{
   float: right;
   margin: 30px;
}
</style>