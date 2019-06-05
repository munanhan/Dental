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
                                    <el-table-column prop="name">
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
                                <el-tabs type="border-card" v-model="selectPrivilege">
                                    <el-tab-pane label="PC端" name="0">
                                        <el-tree
                                          :data="permissionList"
                                          show-checkbox
                                          node-key="id"
                                          :props="treeField"
                                          ref="permissionPcTree"
                                          check-strictly
                                          :default-checked-keys="role_privilege"
                                          @check-change="checkedNodes"

                                          >
                                        
                                          <span slot-scope="{ node,data }">
                                              <span>
                                                  <div v-if="data.p_type != 3">
                                                    <i class="fa fa-folder-open" style="color:#F4A460;"></i> 
                                                    <span>{{ node.label }}</span>
                                                  </div>
                                                  <div v-else>
                                                    <i class="fa fa-file-alt" style="color:#4F94CD"></i> {{ node.label }}
                                                  </div>
                                              </span>              
                                          </span>
                                        </el-tree>
                                    </el-tab-pane>
                                    <el-tab-pane label="移动端" name="1">
                                          <el-tree
                                            :data="permissionPhoneList"
                                            show-checkbox
                                            node-key="id"
                                            :props="treeField"
                                            ref="permissionPhoneTree"
                                            check-strictly
                                            :default-checked-keys="role_privilege"

                                            >
                                            <span slot-scope="{ node,data }">
                                              <span>
                                                  <div v-if="data.p_type != 3">
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
            selectPrivilege:0,
            addRole:false,
            //添加角色
            editItem: {},
            //高度设定
            treeHight: 700,
            menuHeight: 667,

            selectRow:{},
            //被选中的当前行
            tab: "pc",
            openPermission:false,
            treeField:{
                children:'children',
                label:'p_name'
            },
            menuData: [],
            permissionPhoneList: [],
            permissionList: [],
            role_privilege: [],//当前选中的角色权限
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.getMenu();
            // that.getData();
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
                that.getMenu();
                that.getData();
                that.resizeTable();

                //更新原来的refresh, 防止下次点击时不通知更新
                that.$emit("update:refresh", false);

                // that.getData();
            }
        },
        selectPrivilege(newValue,oldValue){
            let that = this;
            if (newValue && Object.keys(that.selectRow).length != 0) {
                that.selectPrivilege = newValue;
                that.getData();
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
        //选中子节点
        selectChild(node, checkAll) {
            let that = this;
            let type = that.selectPrivilege == 0?'permissionPcTree':'permissionPhoneTree';
            let treeInstance = that.$refs[type];
            let keys = [];
            let checkNode = node => {
                    for (var i = 0; i < node.length; i++) {
                        var item = node[i];
                        keys.push(item.id);

                        treeInstance.setChecked(item, checkAll);

                        if (item.children && item.children.length) {
                            checkNode(item.children);
                        }
                    }
                };

            checkNode([node]);
        },
        checkedNodes(nodes,currentNodes){
            //获取节点
            let that = this;
            that.selectChild(nodes,currentNodes);
        },
        selectTab(tab, event) {
          //选择该角色
            console.log(tab, event);
        },
        getMenuTableData(row) {
            let that = this;
            that.selectRow = row;
            that.getData();
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
          let that = this,
            role_id = that.selectRow.id,
            type = that.selectPrivilege;

            that.role_privilege = [];

        that.$api.privilege.getByType({'type':type,'role_id':role_id})
            .then(res => {

                console.log(res.data);

                if (type == 0) {
                    that.permissionList = res.data.privilege;
                    that.role_privilege = res.data.role_privilege;
                }
                if (type == 1) {
                    that.permissionPhoneList = res.data.privilege;
                    that.role_privilege = res.data.role_privilege;
                }


               // console.log(res.data);
            })
            .catch(res => {

            });

        },
        getMenu(){
            //获取菜单
          let that = this;
          let type = that.selectPrivilege;
            that.$api.role.get()
            .then(res => {
                that.menuData = res.data;
               // console.log(res.data);
            })
            .catch(res => {

            });
        }
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
        /*width: 500px;*/
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