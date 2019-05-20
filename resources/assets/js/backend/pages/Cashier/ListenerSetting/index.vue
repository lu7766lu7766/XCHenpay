<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    监听设置
                </div>
                <div class="card-body">
                    <div class="search-box">
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.status">
                                <option value="">状态</option>
                                <option v-for="(name, val) in options.status" :key="val" :value="val">{{ name }}
                                </option>
                            </select>
                        </div>
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.bank_id">
                                <option value="">银行</option>
                                <option v-for="(bank, index) in options.banks" :key="index" :value="bank.id">
                                    {{ bank.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻
                            </button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-btn-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-add btn-half"
                                    @click="$root.$emit('listenerSettingAdd.show')">新增
                            </button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>银行名称</th>
                                <th>简讯格式</th>
                                <th class="width-status">状态</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td class="width-name">{{ _(data).getVal('bank.0.name', '-') }}</td>
                                <td class="text-left">{{ data.contents }}</td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green"
                                       v-if="data.status == 'Y'"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td>
                                    <a @click="$root.$emit('listenerSettingInfo.show', data)">
                                        <i class="mdi mdi-information-outline text-blue"></i></a>
                                    <a @click="$root.$emit('listenerSettingEdit.show', data)">
                                        <i class="mdi mdi-pencil-box-outline"></i></a>
                                </td>
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
        <info/>
        <add/>
        <edit/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'

    export default {
        mixins: [ListMixins],
        components: {
            Info: require('./modal/Info'),
            Add: require('./modal/Add'),
            Edit: require('./modal/Edit'),
        },
        data: () => ({
            options: {
                status: {
                    'Y': '开启',
                    'N': '关闭'
                },
                banks: []
            },
            searchData: {
                status: '',
                bank_id: ''
            },
            config: {}
        }),
        methods: {
            dataInit() {
                this.$api.listenerSetting.getOptions({}, {
                    s: res => this.options.banks = res.data
                })
            },
            getTotal() {
                this.$api.listenerSetting.getListTotal(this.getReqBody, {
                    s: res => this.paginate.total = res.data
                })
            },
            getList() {
                this.callApi(async () => {
                    await this.$api.listenerSetting.getList(this.getReqBody, {
                        s: res => this.datas = res.data
                    })
                })
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
