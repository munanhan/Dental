<template>
    <div>
      <el-row>
        <el-col :span="21">
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
        </el-col>
      </el-row>

      <el-row>
        <el-col :span="24">
          <div class="">
            <el-table
              :data="tableData"
              style="width: 100%">
              <el-table-column
                prop="id"
                label="员工编号"
                >
              </el-table-column>
              <el-table-column
                prop="name"
                label="员工姓名"
              >
              </el-table-column>
              <el-table-column
                prop="phone"
                label="手机号码">
              </el-table-column>
              <el-table-column
                prop="password"
                label="密码">
                <template slot-scope="scope">
                  <div v-if="scope.row.password==''">
                    <el-button type="text" @click="showPasswordDialog(scope.row.id)">设置密码</el-button>
                  </div>
                  <div v-else>
                    <el-button type="text" @click="showPasswordDialog(scope.row.id)">******</el-button>
                  </div>
                </template>
              </el-table-column>
              <el-table-column 
                prop="role"
                label="职位">
                <!-- <template slot-scope="scope">
                  <el-select
                      clearable
                      filterable
                      placeholder=""
                      size="small"
                      v-model="scope.row.role"
                      class="width100"
                  >
                      <el-option
                          v-for="item in role_list"
                          :key="item"
                          :label="item"
                          :value="item"
                      ></el-option>
                  </el-select>
                </template> -->
              </el-table-column>
              <el-table-column
                prop="is_job"
                label="在职情况">
                <!-- <template slot-scope="scope">
                <el-select
                      clearable
                      filterable
                      placeholder=""
                      size="small"
                      v-model="scope.row.is_job"
                      class="width100"
                  >
                      <el-option
                          v-for="item in status"
                          :key="item"
                          :label="item"
                          :value="item"
                      ></el-option>
                  </el-select>
                </template> -->
              </el-table-column>
              <el-table-column
                prop="operation"
                label="操作">

                    <template slot-scope="scope">
                      <el-tooltip
                            effect="dark"
                            content="修改"
                            placement="bottom"
                        >
                            <el-button
                                type="primary"
                                size="mini"
                                icon="el-icon-edit"
                                circle
                                @click.stop="showEditDialog(scope.row)"
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

    <!--修改密码-->
    <set-password 
        :show.sync="passwordDialog"
        :id="id"
    >
    </set-password>
    <!--添加员工-->
    <add-dialog 
        :show.sync="addDialog"
    >
    </add-dialog>
    <!--修改员工-->
    <edit-dialog 
        :show.sync="editDialog"
        :editItem="editItem"
    >
    </edit-dialog>
    </div>
</template>


<script>
import SetPassword from "./SetPassword";
import AddDialog from "./AddDialog";
import EditDialog from "./EditDialog";
export default {
    name: 'Index',
    components: {
       SetPassword,
       AddDialog,
       EditDialog
    },
      props: {
        refresh: {
          type: Boolean,
          required: true
        }
      },
      data() {

        return {
          passwordDialog:false,
          addDialog:false,
          editDialog:false,
          staff:'',
          id:'',
          editItem:{},
           tableData: [
           {
                id: 1,
                name: '刘伟',
                phone: '13888888888',
                password:'liuwei666',
                role:'主任',
                is_job:'在职',
                operation:''
                },
           {
                id: 2,
                name: '张三',
                phone: '13800090990',
                password:'liuwei666',
                role:'医生',
                is_job:'在职',
                operation:''
          },
          {
                id: 3,
                name: '李四',
                phone: '13813458888',
                password:'liuwei666',
                role:'护士',
                is_job:'在职',
                operation:''
                },
          {
                id: 4,
                name: '王五',
                phone: '13899599599',
                password:'',
                role:'前台',
                is_job:'在职',
                operation:''
          }

          ],
          

          role_list:[
            '主任',
            '医生',
            '前台',
            '护士',
            '收银员',
            '技师',
            '咨询师'
          ],
          status:[
            '在职',
            '离职'
          ]
          // tableData:[]
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
        del(id){
           alert(id);
        },
        showEditDialog(editItem){
          let that = this;
          that.editItem = editItem;
          that.editDialog = true;
        },
        search(){
          let that = this;
          alert(that.staff);
        },
        showPasswordDialog(id){
          let that = this;
          that.id = id;
          that.passwordDialog = true;

        },
        // submitForm(formName) {
        //   this.$refs[formName].validate((valid) => {
        //     if (valid) {
        //       alert('submit!');
        //     } else {
        //       console.log('error submit!!');
        //       return false;
        //     }
        //   });
        // },
        // handleClose(){
        //    let that = this;
        //    that.$refs["ruleForm"].resetFields();
        //    that.setPassword = false;
        // },
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
    text-align: center;;
}
/*.title{
  text-align: center;
  margin-bottom: 10px;
}*/
</style>