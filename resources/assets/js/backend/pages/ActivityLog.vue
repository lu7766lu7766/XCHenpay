<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="search-box">
                        <date-time-picker placeholder="開始日期" v-model="searchData.start"/>
                        <date-time-picker placeholder="結束日期" v-model="searchData.end"/>

                        <picker-button :startTime.sync="searchData.start" :endTime.sync="searchData.end"/>

                        <div class="search-input">
                            <input type="text" class="form-control" placeholder="关键字" v-model="searchData.keyword">
                        </div>

                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻
                            </button>
                        </div>
                    </div>

                    <!-- search-box end -->
                    <div class="row view-box m-t-15">
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>

                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>商户名</th>
                                <th>描述</th>
                                <th class="width-date">创建时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="data.id">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.log_name }}</td>
                                <td class="text-left">{{ data.description }}</td>
                                <td>{{ data.created_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :lastPage="lastPage" @pageChange="pageChange"/>
                    <!-- <nav aria-label="Page navigation" class="page-bar"> end -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ListMixins from "mixins/list"

    export default {
        api: "activityLog",
        mixins: [ListMixins],
        data: () => ({
            searchData: {
                start: moment().startOf('day'),
                end: moment().endOf('day'),
                keyword: ''
            }
        }),
        methods: {
            onGetList(res) {
                this.datas = res.data
            },
            onGetTotal(res) {
                this.paginate.total = res.data
            }
        }
    }
</script>

<style scoped>

</style>
