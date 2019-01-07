<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-model="company_id" :options="companies"/>
            <!-- fee start -->

            <!-- order start -->
            <component :is="company_id ? 'order' : ''" v-if="company_id !== ''"/>
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
            company_id: '',
            companies: [],
        }),
        async mounted() {
            this.proccessAjax('dataInit', {}, res => {
                this.companies = _.map(res.companies)
                this.canEditOrder = res.can_edit_order
                this.canShowCompany = res.can_show_company
                if (!this.canShowCompany) {
                    this.company_id = res.user.id
                }
            })
        }
    }
</script>
