<template>
    <div>
 
        <el-container>
            <el-header>
                <MyHeader></MyHeader>
            </el-header>
            <el-container>
              <el-aside width="200px">
                <MyLeft></MyLeft>
              </el-aside>
              <el-main>
                <MyRight></MyRight>
              </el-main>
            </el-container>
          </el-container>
    </div>
</template>

<script>
    import MyHeader from '../public/header.vue'
    import MyLeft from '../public/left.vue'
    import MyRight from '../public/right.vue'
    export default {
        name: '',
        components: {
            MyLeft,
            MyRight,
            MyHeader,
        },
        data() {
            return {
            }
        },

        methods: {}
    }
</script>

<style>

</style>