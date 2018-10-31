<template>
    <div class="panel-body">
        <table class="table table-hover text-center table-bordered table-box">
            <thead>
            <tr>
                <th class="width-40">#</th>
                <th>API代号</th>
                <th>通道名称</th>
                <th>手续费</th>
                <th class="status">状态</th>
                <th class="control">操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(data, index) in datas" :key="index">
                <td>{{ startIndex + index }}</td>
                <td>{{ data.i6pay_id }}</td>
                <td>{{ data.name }}</td>
                <td>{{ data.fee }}</td>
                <td>
                    <i class="icon ion-checkmark-round text-green" v-if="data.status == '开启'"></i>
                    <i class="icon ion-close-round text-red" v-else></i>
                </td>
                <td class="control">
                    <a @click="showInfo(data.id)">
                        <i class="livicon" data-name="info" data-size="18" data-c="#428BCA" data-hc="#428BCA"
                           data-loop="true" data-toggle="modal" data-target="#hand-info" id="livicon-17"
                           style="width: 18px; height: 18px;">
                            <svg height="18" version="1.1" width="18" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 style="overflow: hidden; position: relative; left: -0.75px;"
                                 id="canvas-for-livicon-17">
                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2
                                </desc>
                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                <path fill="#428bca" stroke="none"
                                      d="M16,3C8.82,3,3,8.82,3,16S8.82,29,16,29C23.179000000000002,29,29,23.18,29,16S23.179,3,16,3ZM15.899,7.7C17.06,7.7,18,8.639,18,9.8C18,10.958,17.06,11.9,15.899000000000001,11.9S13.799000000000001,10.959,13.799000000000001,9.8C13.8,8.639,14.739,7.7,15.899,7.7ZM18.698,24.5H16.198C15.198,24.5,14.198,23.5,14.198,22.5V15.7C14.198,15.2,12.598,14.7,12.598,14.2C12.598,13.799999999999999,13.198,13.5,13.697000000000001,13.5H16.198C17.198,13.5,18.198,14.2,18.198,15.2V22.5C18.198,23,19.8,23.4,19.8,23.9C19.8,24.301,19.2,24.5,18.698,24.5Z"
                                      stroke-width="0" transform="matrix(0.5625,0,0,0.5625,0,0)"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            </svg>
                        </i>
                    </a>
                    <a @click="showEdit(data.id)">
                        <i class="livicon" data-name="edit" data-size="18" data-c="#f56954" data-hc="#f56954"
                           data-loop="true" data-toggle="modal" data-target="#hand-edit" id="livicon-18"
                           style="width: 18px; height: 18px;">
                            <svg height="18" version="1.1" width="18" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 style="overflow: hidden; position: relative; left: -0.25px;"
                                 id="canvas-for-livicon-18">
                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2
                                </desc>
                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                <path fill="#f56954" stroke="none"
                                      d="M24,20V24H8V8H20L24,4H7C5.343,4,4,5.343,4,7V25C4,26.656,5.343,28,7,28H25C26.656,28,28,26.656,28,25V16L24,20Z"
                                      stroke-width="0" transform="matrix(0.5625,0,0,0.5625,0,0)"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <path fill="#f56954" stroke="none"
                                      d="M27.105,5.369L29.651,7.914999999999999C30.114,8.380999999999998,30.118,9.143999999999998,29.651,9.610999999999999L27.671,11.591L23.429,7.347999999999999L25.409,5.3679999999999986C25.877,4.9,26.637,4.9,27.105,5.369ZM12.817,20.788C12.817,20.788,12.817,17.959,15.646,15.131L22.722,8.055L26.964000000000002,12.298L19.888,19.373C17.060000000000002,22.201,14.232000000000003,22.202,14.232000000000003,22.202S12.524000000000003,23.322000000000003,12.111000000000002,22.908C11.668,22.468,12.817,20.788,12.817,20.788ZM17.202,18.1L23.57,11.733L22.72,10.884L16.351999999999997,17.252000000000002L17.202,18.1Z"
                                      transform="matrix(0.5625,0,0,0.5625,0,0)" stroke-width="0"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            </svg>
                        </i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    import ReportMixins from 'mixins/report'

    export default {
        mixins: [ReportMixins],
        data: () => ({}),
        methods: {
            async fetch() {
                var $companySelector = document.querySelector('#company_selection')
                let myCompany = $companySelector ? $companySelector.value : company
                var res = await this.post('/admin/logQuery/feeData', {
                    // at laravel view logQuery
                    company: myCompany
                })
                if (res.ok) {
                    this.datas = res.body.data
                    this.paginate.total = res.body.recordsTotal
                }
            },
            showInfo(id) {
                this.modalProccess($('#show_FeeInfo'), '/admin/logQuery/showFeeInfo/' + id)
            },
            showEdit(id) {
                this.modalProccess($('#edit_FeeInfo'), '/admin/logQuery/editFeeInfo/' + id)
            },
            async modalProccess($modal, url) {
                $modal.modal('show')
                $modal.find('.modal-content').html('')
                var res = await this.$http.get(url)
                $modal.find('.modal-content').html(res.body)
            }
        },
        mounted() {
            this.$root.$on('getFeeData', this.fetch)
        },
        destroyed() {
            this.$root.$off('getFeeData')
        }
    }
</script>
