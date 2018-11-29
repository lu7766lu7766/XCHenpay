<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-model="company_id" :options="companies"/>
            <!-- fee start -->
            <component :is="company_id ? 'fee' : ''" v-if="company_id !== ''"/>
            <!-- fee end -->

            <!-- order start -->
            <component :is="company_id ? 'order' : ''" v-if="company_id !== ''"/>
            <!-- order end -->
        </div>
    </div>
</template>

<script>
    export default {
        api: "orderSearch",
        components: {
            CompanySelector: require('@/CompanySelector'),
            Fee: require('./Fee'),
            Order: require('./Order'),
        },
        data: () => ({
            canEditOrder: false,
            canEditFee: false,
            canShowCompany: false,
            company_id: '',
            companies: [],
        }),
        async mounted() {
            let loader = this.$loading.show({
                container: this.$el,
            })
            var res = await this.$callApi('orderSearch:dataInit')
            this.companies = _.map(res.companies)
            this.canEditFee = res.can_edit_fee
            this.canEditOrder = res.can_edit_order
            this.canShowCompany = res.can_show_company
            if (!this.canShowCompany) {
                this.company_id = res.user.id
            }
            loader.hide()
        }
    }
</script>
