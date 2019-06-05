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
                                    <a @click="$root.$emit('feeListDetail.show', data)">
                                        <i class="mdi mdi-information-outline text-blue"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <!-- card end -->
        </div>
        <detail/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import FeeMixins from '../FeeMixins'

    export default {
        api: "feeList",
        mixins: [ListMixins, FeeMixins],
        components: {
            Detail: require('./modal/Detail')
        },
        methods: {
            getList() {
                this.callApi(async () => {
                    await this.$api.channel.list.getList(this.getReqBody, {
                        s: res => this.datas = _.orderBy(res.data, x => +x.i6pay_id, 'asc')
                    })
                })
            },
            getTotal() {
            }
        },
        mounted() {
            this.search()
        }
    }
</script>
