<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-if="canShowCompany" v-model="company_id" :options="companies"/>
            <!-- fee start -->

            <!-- order start -->
            <order v-if="company_id !== -1"/>
            <!-- order end -->
        </div>
    </div>
</template>

<script>
    import ReqMixins from 'mixins/request'
    export default {
        api: "orderSearch",
        mixins: [ReqMixins],
        components: {
            CompanySelector: require('@/CompanySelector'),
            Order: require('./Order'),
        },
        data: () => ({
            canEditOrder: false,
            canShowCompany: false,
            company_id: -1,
            companies: [],
        }),
        async mounted() {
            this.proccessAjax('dataInit', {}, res => {
                this.companies = _.concat([{id: '', company_name: '全部'}], _.map(res.companies))
                this.canEditOrder = res.can_edit_order
                this.canShowCompany = res.can_show_company
                if (!this.canShowCompany) {
                    this.company_id = res.user.id
                }
            })
        }
    }
</script>
