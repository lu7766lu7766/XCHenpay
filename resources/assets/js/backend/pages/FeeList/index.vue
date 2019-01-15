<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    通道列表
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>API代码</th>
                                <th>通道名称</th>
                                <th>手续费</th>
                                <th class="width-status">状态</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas"
                                :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.i6pay_id }}</td>
                                <td>{{ data.name }}</td>
                                <td>
                                    <span>{{ getFee(data) | numFormat('0,0.00') }}%</span>
                                </td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green" v-if="getStatus(data)"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td class="width-control">
                                    <a @click="showDetail(data)">
                                        <i class="mdi mdi-information-outline text-blue"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :last-page="lastPage" @pageChange="pageChange"/>
                    <!-- <nav aria-label="Page navigation" class="page-bar"> end -->
                </div>
            </div>
            <!-- card end -->
        </div>
        <detail/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'

    export default {
        api: "feeList",
        mixins: [ListMixins],
        components: {
            Detail: require('./modal/Detail')
        },
        methods: {
            getTotal(res) {
            },
            onGetList(res) {
                this.datas = _.orderBy(res.data, x => +x.i6pay_id, 'asc')
            },
            getFee(data) {
                return data.payment_fee[0]
                    ? data.payment_fee[0].fee
                    : data.fee
            },
            getStatus(data) {
                return data.payment_fee[0]
                    ? +data.payment_fee[0].status
                    : data.activate
            },
            showDetail(data) {
                this.$root.$emit('feeListDetail.show', data)
            }
        },
        mounted() {
            this.search()
        }
    }
</script>
