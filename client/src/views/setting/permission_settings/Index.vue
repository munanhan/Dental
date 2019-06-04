<template>
    <div
        class="content"
        ref="menuContent"
    >
        <el-container>
            <el-aside
                class="left"
                :style="{'width':200+'px'}"
            >
                <div class="menu_title">
                    <el-row>
                        <el-col :span="10">
                            <div class="title">
                                职位列表
                            </div>

                        </el-col>
                        <el-col :span="13">
                            <div class="setting">
                                <i
                                    class="fa fa-cog"
                                    style="margin-top:10px;
                                     font-size:20px;
                                     cursor:pointer;
                                     margin-left:10px"
                                     @click="addRole = true"
                                    
                                ></i>
                            </div>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="24">
                            <div class="menu_content">
                                <el-table
                                    :data="menuData"
                                    stripe
                                    border
                                    :show-header="false"
                                    highlight-current-row
                                    :height="menuHeight"
                                    @row-click="getMenuTableData"
                                >
                                    <el-table-column prop="role">
                                    </el-table-column>
                                </el-table>

                            </div>
                        </el-col>
                    </el-row>

                </div>
            </el-aside>

            <el-main class="right">
                <el-col :span="24">
                    <el-row>
                        <div class="right">
                            <div class="data_content" :style="{'height':treeHight+'px'}">
                                <el-tabs type="border-card">
                                    <el-tab-pane label="PC端">
                                        <el-tree
                                          :data="permissionList"
                                          show-checkbox
                                          node-key="id"
                                          :props="treeField"
                                          ref="permissionPcTree"
                                          >
                                        
                                          <span slot-scope="{ node }">
                                              <span>
                                                  <div v-if="node.level == 1">
                                                    <i class="fa fa-folder-open" style="color:#F4A460;"></i> {{ node.label }}
                                                  </div>
                                                  <div v-else>
                                                    <i class="fa fa-file-alt" style="color:#4F94CD"></i> {{ node.label }}
                                                  </div>
                                              </span>              
                                          </span>
                                        </el-tree>
                                    </el-tab-pane>
                                    <el-tab-pane label="移动端">
                                          <el-tree
                                            :data="permissionPhoneList"
                                            show-checkbox
                                            node-key="id"
                                            :props="treeField"
                                            ref="permissionPhoneTree"

                                            >
                                            <span slot-scope="{ node }">
                                              <span>
                                                  <div v-if="node.level == 1">
                                                    <i class="fa fa-folder-open" style="color:#F4A460;"></i> {{ node.label }}
                                                  </div>
                                                  <div v-else>
                                                    <i class="fa fa-file-alt" style="color:#4F94CD"></i> {{ node.label }}
                                                  </div>
                                              </span>              
                                          </span>
                                          </el-tree>
                                    </el-tab-pane>
                                </el-tabs>
                            </div>
                        </div>
                    </el-row>
                    <el-row>
                        <div class="btn_content">
                            <el-col :span="20">
                                <el-checkbox :checked="openPermission" @change="openAllPermission">展开权限树</el-checkbox>
                            </el-col>
                            <el-col :span="1">
                                <el-button
                                type="primary"
                                @click.stop="savePermission"
                                >
                                  保存
                                </el-button>
                            </el-col>
                        </div>
                    </el-row>
                </el-col>
            </el-main>
        </el-container>

        <!-- 添加角色 -->
        <add-role
            :show.sync="addRole"
        >
        </add-role>

    </div>
</template>

<script>
import AddRole from './AddRoleDialog';
export default {
    name: "PermissionSettings",
    components: {
      AddRole
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            addRole:false,
            //添加角色
            editItem: {},
            //高度设定
            treeHight: 700,
            menuHeight: 667,
            tab: "pc",
            openPermission:false,
            treeField:{
                children:'children',
                label:'p_name'
            },
            menuData: [
                {
                    id: 1,
                    role: "主任"
                },
                {
                    id: 2,
                    role: "咨询师"
                },
                {
                    id: 3,
                    role: "前台"
                },
                {
                    id: 4,
                    role: "护士"
                },
                {
                    id: 5,
                    role: "收银员"
                },
                {
                    id: 6,
                    role: "技师"
                },
                {
                    id: 7,
                    role: "医生"
                }
            ],
            permissionPhoneList: [
                {
                    id:1,
                    p_name:'手机首页',
                    p_id:0,
                    level:1
                },
                {
                    id:2,
                    p_name:'手机患者',
                    p_id:0,
                    level:1,
                    children:[
                    {
                        id:3,
                        p_name:'手机添加患者',
                        p_id:2,
                        level:2
                    },
                    {
                        id:4,
                        p_name:'手机查看患者信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:5,
                        p_name:'手机查看处置记录',
                        p_id:2,
                        level:2
                    },
                    {
                        id:6,
                        p_name:'手机查看收费信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:7,
                        p_name:'手机查看影像信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:8,
                        p_name:'手机查看病例信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:9,
                        p_name:'手机查看外加工信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:10,
                        p_name:'手机查看回访信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:11,
                        p_name:'手机查看质询信息',
                        p_id:2,
                        level:2
                    }
                    ]
                },
                    {
                        id:12,
                        p_name:'手机预约',
                        p_id:0,
                        level:1
                    },
                    {
                        id:13,
                        p_name:'手机沟通',
                        p_id:0,
                        level:1
                    },
                    {
                        id:14,
                        p_name:'手机统计',
                        p_id:0,
                        level:1
                    },
                    {
                        id:15,
                        p_name:'手机营销',
                        p_id:0,
                        level:1

                    },
                    {
                      id:19,
                      p_name:'手机管理',
                      p_id:0,
                      level:1,
                      children:[
                        {
                          id:16,
                          p_name:'手机客服',
                          p_id:19,
                          level:2
                        },
                        {
                          id:17,
                          p_name:'手机库房',
                          p_id:19,
                          level:2
                        },
                        {
                          id:18,
                          p_name:'手机回访',
                          p_id:19,
                          level:2
                        },
                        {
                          id:20,
                          p_name:'手机诊所信息',
                          p_id:19,
                          level:2
                        },
                        {
                          id:21,
                          p_name:'手机权限设置',
                          p_id:19,
                          level:2
                        },
                        {
                          id:22,
                          p_name:'手机员工管理',
                          p_id:19,
                          level:2
                        },
                        {
                          id:23,
                          p_name:'手机处置与收费',
                          p_id:19,
                          level:2
                        },
                        {
                          id:24,
                          p_name:'手机处置组合',
                          p_id:19,
                          level:2
                        },
                        {
                          id:25,
                          p_name:'手机病历模板',
                          p_id:19,
                          level:2
                        },
                        {
                          id:26,
                          p_name:'手机会员升级',
                          p_id:19,
                          level:2
                        },
                        {
                          id:27,
                          p_name:'手机患者回收站',
                          p_id:19,
                          level:2
                        },
                        {
                          id:28,
                          p_name:'手机操作记录',
                          p_id:19,
                          level:2
                        },
                      ],

                    }
            ],
            permissionList: [
                {
                    id:1,
                    p_name:'首页',
                    p_id:0,
                    level:1
                },
                {
                    id:2,
                    p_name:'患者',
                    p_id:0,
                    level:1,
                    children:[
                    {
                        id:3,
                        p_name:'添加患者',
                        p_id:2,
                        level:2
                    },
                    {
                        id:4,
                        p_name:'查看患者信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:5,
                        p_name:'查看处置记录',
                        p_id:2,
                        level:2
                    },
                    {
                        id:6,
                        p_name:'查看收费信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:7,
                        p_name:'查看影像信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:8,
                        p_name:'查看病例信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:9,
                        p_name:'查看外加工信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:10,
                        p_name:'查看回访信息',
                        p_id:2,
                        level:2
                    },
                    {
                        id:11,
                        p_name:'查看质询信息',
                        p_id:2,
                        level:2
                    }
                    ]
                },
                    {
                        id:12,
                        p_name:'预约',
                        p_id:0,
                        level:1
                    },
                    {
                        id:13,
                        p_name:'沟通',
                        p_id:0,
                        level:1
                    },
                    {
                        id:14,
                        p_name:'统计',
                        p_id:0,
                        level:1
                    },
                    {
                        id:15,
                        p_name:'营销',
                        p_id:0,
                        level:1

                    },
                    {
                      id:19,
                      p_name:'管理',
                      p_id:0,
                      level:1,
                      children:[
                        {
                          id:16,
                          p_name:'客服',
                          p_id:19,
                          level:2
                        },
                        {
                          id:17,
                          p_name:'库房',
                          p_id:19,
                          level:2
                        },
                        {
                          id:18,
                          p_name:'回访',
                          p_id:19,
                          level:2
                        },
                        {
                          id:20,
                          p_name:'诊所信息',
                          p_id:19,
                          level:2
                        },
                        {
                          id:21,
                          p_name:'权限设置',
                          p_id:19,
                          level:2
                        },
                        {
                          id:22,
                          p_name:'员工管理',
                          p_id:19,
                          level:2
                        },
                        {
                          id:23,
                          p_name:'处置与收费',
                          p_id:19,
                          level:2
                        },
                        {
                          id:24,
                          p_name:'处置组合',
                          p_id:19,
                          level:2
                        },
                        {
                          id:25,
                          p_name:'病历模板',
                          p_id:19,
                          level:2
                        },
                        {
                          id:26,
                          p_name:'会员升级',
                          p_id:19,
                          level:2
                        },
                        {
                          id:27,
                          p_name:'患者回收站',
                          p_id:19,
                          level:2
                        },
                        {
                          id:28,
                          p_name:'操作记录',
                          p_id:19,
                          level:2
                        },
                      ],

                    }
            ],
        };
    },
    created() {},
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
                that.getData();
                that.resizeTable();

                //更新原来的refresh, 防止下次点击时不通知更新
                that.$emit("update:refresh", false);

                // that.getData();
            }
        }
    },

    computed: {},
    methods: {
        savePermission(){
          //保存权限
          let permissionPc = this.$refs.permissionPcTree.getCheckedNodes();
          let permissionPhone = this.$refs.permissionPhoneTree.getCheckedNodes();
          //console.log(permissionPc);
          //console.log(permissionPhone);
        },
        openAllPermission(){
          //展开所有的权限
           let that = this;
           //console.log(that.openPermission);
           that.openPermission = that.openPermission == true?false:true;
           for(var i=0;i<this.$refs.permissionPcTree.store._getAllNodes().length;i++){
            //展开与缩放
              this.$refs.permissionPcTree.store._getAllNodes()[i].expanded = that.openPermission;
           }
           for(var i=0;i<this.$refs.permissionPhoneTree.store._getAllNodes().length;i++){
            //展开与缩放
              this.$refs.permissionPhoneTree.store._getAllNodes()[i].expanded = that.openPermission;
           }
        },
        selectTab(tab, event) {
          //选择该角色
            console.log(tab, event);
        },
        getMenuTableData(row) {
            alert(row.id);
        },
        resizeTable() {
            let that = this;
            // if (that.$refs.menuContent.clientHeight != 0) {
            let treeHight = that.$refs.menuContent.clientHeight - 70;
            that.treeHight = treeHight;
            that.menuHeight = treeHight - 33;
            // }

            // that.$refs.search.clientHeight -
            // 70;
            // console.log(treeHight);
        },
        edit(editItem) {
            //修改
            let that = this;
            that.editItem = editItem;
        },
        del(id) {
            //删除
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

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        getData(){
          //获取列表数据
          let that = this;
            that.$api.privilege.get()
            .then(res => {
               console.log(res.data);
            })
            .catch(res => {

            });

        },
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
/deep/
    .el-table--striped
    .el-table__body
    tr.el-table__row--striped.current-row
    td,
/deep/ .el-table__body tr.current-row > td {
    background-color: @linght-background-color;
}
/deep/ .el-tree-node:focus > .el-tree-node__content {
    background-color: @linght-background-color !important;
}

/deep/ .el-tree-node__content:hover {
    background-color: @linght-background-color !important;
}


.content{
    background: white;
    height: 100%;
    .data_content {
    /*border: 1px solid #dbdbdb;*/
    margin-bottom: 10px;
    /*height: 700px;*/
    /*padding: 10px 0 0 10px;*/

    /deep/ .el-tabs__header .el-tabs__nav-scroll {
      padding-left: 0 ;
    }

    /deep/ .el-tabs__content{
      overflow: auto;
    }
  }
}

.left {
    border: 1px solid #dbdbdb;
    height: 100%;
    width: 180px;
    /*height: 800px;*/

    .title {
        padding-top: 10px;
        padding-bottom: 5px;
        padding-left: 16px;
        font-size: 14px;
        font-weight: bold;
        color: @color;
        /*text-align: center;*/
        border-bottom: 2px solid @color;
    }

    .setting {
        float: right;
        /*padding-right: 10px;*/
    }

    .menu_content {
        /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
            background-color: @linght-background-color;
            cursor: pointer;
        }
        /deep/ .el-table__body td {
            padding: 3px 0;
        }
    }
}
.right {
    /*border: 1px solid #dbdbdb;*/
    padding: 0 0 0 5px;
    /*height: 800px;*/
    height: 100%;
    /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
        background-color: @linght-background-color;
    }
}
.btn_content {
    padding: 0 0 10px 10px;
    /*border-bottom: 1px solid #e3e3e3;*/
    height: 40px;
    /*width: 100%;*/
}
</style>