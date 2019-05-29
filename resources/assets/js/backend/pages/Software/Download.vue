<template>
    <section>
        <header>
            <div class="container text-center">
                软件下载
            </div>
        </header>
        <div class="download">
            <div class="container">
                <div class="card" v-for="(category, index) in datas" :key="index">
                    <div class="card-header">{{ category.name }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-box">
                                <tbody>
                                <tr v-for="(data, index2) in category.software" :key="index2">
                                    <td class="img"><img src="/img/logo-sm.png" alt=""></td>
                                    <td class="name">
                                        <b>{{ data.title }}</b>
                                        <span>{{ data.description }}</span>
                                    </td>
                                    <td class="control">
                                        <span class="qr-btn">
                                            <i class="mdi mdi-barcode-scan"
                                               :class="!data.qrcode_link ? 'no-link' : ''"></i>
                                            <div class="qr-box" v-if="data.qrcode_link">
                                                <qrcode :value="data.qrcode_link"
                                                        :options="{
                                                        width: 100,
                                                        margin: 0
                                                    }"/>
                                            </div>
                                        </span>
                                        <a :href="data.download_link" class="download-btn">
                                            <i class="ion-android-download"
                                               :class="!data.download_link ? 'no-link' : ''"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        mixins: [ReqMixins],
        components: {
            qrcode: require('@chenfengyuan/vue-qrcode').default
        },
        data: () => ({
            datas: []
        }),
        created() {
            this.callApi(async () => {
                const res = await this.$api.software.download.getData()
                this.datas = res.data
            })
        }
    }
</script>
