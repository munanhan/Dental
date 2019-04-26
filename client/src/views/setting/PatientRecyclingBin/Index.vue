<template>
    <div class="content" ref="Content">
      <el-row :gutter="10">
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
              :data="currentData"
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
                prop="patient_source"
                label="患者来源">
              </el-table-column>
              <el-table-column
                prop="content"
                label="患者备注">
              </el-table-column>
              <el-table-column
                prop="group"
                label="分组">
                <template slot-scope="scope">
                  <div v-if="scope.row.group == 0">
                    最近患者
                  </div>
                  <div v-if="scope.row.group == 1">
                    黑名单
                  </div>
                  <div v-if="scope.row.group == 2">
                    治疗完成
                  </div>
                </template>
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
                                icon="el-icon-edit"
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
                                @click.stop="del(scope.row.id)"
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
              :current-page="current_page"
              :page-sizes="[5, 10, 15, 20]"
              :page-size="page_size"
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

export default {
    name: 'Index',
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
            current_page:1,
            page_size:5,
            total:'',
            search:{
              staff:'',
              phone:'',
            },
            currentData:[{}],
            tableData:[
            {
              id:1,
              name:'琳',
              age:18,
              sex:'女',
              phone:'138888888',
              patient_source:'网站',
              content:'蛀牙',
              group:2

            },
            {
              id:2,
              name:'为',
              age:22,
              sex:'女',
              phone:'138888898',
              patient_source:'朋友介绍',
              content:'换牙',
              group:1

            },
            {
              id:3,
              name:'张三',
              age:18,
              sex:'男',
              phone:'138888888',
              patient_source:'网站',
              content:'蛀牙',
              group:2

            },
            {
              id:4,
              name:'李四',
              age:18,
              sex:'女',
              phone:'138888888',
              patient_source:'网站',
              content:'拔牙',
              group:2

            },
            {
              id:5,
              name:'严',
              age:18,
              sex:'男',
              phone:'138888888',
              patient_source:'网站',
              content:'牙疼',
              group:0

            },
            {
              id:6,
              name:'赵六',
              age:18,
              sex:'男',
              phone:'138888888',
              patient_source:'网站',
              content:'牙疼',
              group:0

            }
          ]
        };
      },
      created() {
        let that = this;
        that.current_page = 1;
        that.currentData = that.tableData.slice(0,that.page_size);
        that.total = that.tableData.length;
      },
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

                setTimeout(() => {
                    that.$emit("update:update", false);
                });
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
          let start = (val-1)*that.page_size;
          let end = start+that.page_size;
          if (end >= that.tableData.length) {
             end = that.tableData.length;
          }
          that.currentData = that.tableData.slice(start,end);
        },
        sizeChange(val){
          //当前页数量
          let that = this;
          that.page_size = val;
          that.current_page = 1;
          that.currentData = that.tableData.slice(0,that.page_size);
          that.total = that.tableData.length;
        },
        selectThis(val){
          //选中
          let that = this;
          that.select_group = [];
          for (var i = 0; i < val.length; i++) {
              that.select_group.push(val[i].id);
           }
        },
        del(id){
          alert(id);
        },
        delAll(){
          let that = this;
          console.log(that.select_group);
        },
        update(id){
          alert(id);
        },
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
            //     that.search.dtfm = that.search.dateRange[0];
            //     that.search.dtto = that.search.dateRange[1];
                console.log(that.search); 
            // that.pager.current = 1;

            // if (that.$check_pm("report_candidate_info_statistics")) {
            //     //权限
            //     that.getCandidateInfoStatistics(params);
            // } else {
            //     that.$message.error("无此权限.");
            // }
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