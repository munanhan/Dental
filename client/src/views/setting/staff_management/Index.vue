<template>
    <div
        class="content"
        ref="Content"
    >
        <el-row>
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
                <el-col :span="2">
                    <div class="staff_name">
                        <span class="mr10">员工姓名</span>
                    </div>
                </el-col>
                <el-col :span="4">
                    <span class="mr10">
                        <el-input
                            v-model="search.name"
                            placeholder="请输入姓名"
                        ></el-input>
                    </span>
                </el-col>
                <el-col :span="2">
                    <span class="">
                        <el-button
                            type="primary"
                            @click="searchName"
                        >查询</el-button>
                    </span>
                </el-col>
                <el-col :span="2">
                    <span>
                        <el-button
                            type="primary"
                            @click="addDialog = true"
                        >新增员工</el-button>
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
                        :height="clientHeight"
                    >
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
                            label="手机号码"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="password"
                            label="密码"
                        >
                            <template slot-scope="scope">
                                <div v-if="scope.row.password==''">
                                    <el-button
                                        type="text"
                                        @click="showPasswordDialog(scope.row.id)"
                                    >设置密码</el-button>
                                </div>
                                <div v-else>
                                    <el-button
                                        type="text"
                                        @click="showPasswordDialog(scope.row.id)"
                                    >******</el-button>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="role"
                            label="职位"
                        >
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
                            prop="entry"
                            label="在职情况"
                        >
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
                            label="操作"
                        >

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
                                        @click.stop="showDel(scope.row.id)"
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
            @flush="flush"
        >
        </add-dialog>
        <!--修改员工-->
        <edit-dialog
            :show.sync="editDialog"
            :editItem="editItem"
            @flush="flush"
        >
        </edit-dialog>

        <!-- 删除提示框 -->
        <el-dialog
            title="提示"
            :visible.sync="is_del"
            width="300px"
            center
        >
            <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div>
            <span
                slot="footer"
                class="dialog-footer"
            >
                <el-button @click="is_del = false">取 消</el-button>
                <el-button
                    type="primary"
                    @click="del"
                >确 定</el-button>
            </span>
        </el-dialog>

    </div>
</template>


<script>
import SetPassword from "./SetPassword";
import AddDialog from "./AddDialog";
import EditDialog from "./EditDialog";
export default {
    name: "StaffManagement",
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
            clientHeight: 700,
            passwordDialog: false,
            addDialog: false,
            editDialog: false,
            search: { name: "" },
            id: "",
            del_id: 0,
            is_del: false,
            editItem: {},
            tableData: [
                //  {
                //       id: 1,
                //       name: '刘伟',
                //       phone: '13888888888',
                //       password:'liuwei666',
                //       role:'主任',
                //       is_job:'在职',
                //       operation:''
                //       },
                //  {
                //       id: 2,
                //       name: '张三',
                //       phone: '13800090990',
                //       password:'liuwei666',
                //       role:'医生',
                //       is_job:'在职',
                //       operation:''
                // },
                // {
                //       id: 3,
                //       name: '李四',
                //       phone: '13813458888',
                //       password:'liuwei666',
                //       role:'护士',
                //       is_job:'在职',
                //       operation:''
                //       },
                // {
                //       id: 4,
                //       name: '王五',
                //       phone: '13899599599',
                //       password:'',
                //       role:'前台',
                //       is_job:'在职',
                //       operation:''
                // }
            ],

            role_list: [
                "主任",
                "医生",
                "前台",
                "护士",
                "收银员",
                "技师",
                "咨询师"
            ],
            status: ["在职", "离职"]
            // tableData:[]
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeTable();

            //更新原来的refresh, 防止下次点击时不通知更新
            that.$emit("update:refresh", false);

            that.getData();
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
                let tableHeight = that.$refs.Content.clientHeight - 70;
                that.tableHeight = tableHeight;
            }
        },
        showDel(id) {
            let that = this;
            that.del_id = id;
            that.is_del = true;
        },
        del() {
            let that = this;
            let id = that.del_id;

            that.$api.staff
                .del({ id })
                .then(res => {
                    if (res.code == 200) {
                        for (
                            var i = 0, length = that.tableData.length - 1;
                            i < length;
                            i++
                        ) {
                            if (that.tableData[i].id == id) {
                                that.tableData.splice(i, 1);
                                that.total = that.total - 1;
                            }
                        }

                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        that.is_del = false;
                    } else {
                        that.$message.error(res.msg || "操作异常请重试.");
                    }
                })
                .catch(res => {
                    console.log(res);
                });
        },
        showEditDialog(editItem) {
            let that = this;
            // that.editItem = editItem;
            // that.editDialog = true;
            that.getById(editItem.id);
        },
        searchName() {
            let that = this;
            that.getData();
        },
        showPasswordDialog(id) {
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
        getData() {
            let that = this;
            that.$api.staff
                .user_list(that.search)
                .then(res => {
                    that.tableData = res.data;
                })
                .catch(res => {
                    console.log(res);
                });
        },
        getById(id) {
            let that = this;
            that.$api.staff
                .getById({ id: id })
                .then(res => {
                    that.editItem = res.data;
                    that.editDialog = true;
                })
                .catch(res => {
                    console.log(res);
                });
        },
        flush() {
            let that = this;
            that.getData();
        },

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.staff_name {
    padding: 10px;
}
.btn_class {
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
.content {
    background: white;
    height: 100%;
}

/*.title{
  text-align: center;
  margin-bottom: 10px;
}*/
</style>