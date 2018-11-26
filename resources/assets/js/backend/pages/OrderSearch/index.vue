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
            isAdmin: false,
            company_id: '',
            companies: [],
        }),
        async mounted() {
            let loader = this.$loading.show({
                container: this.$el,
            })
            var res = await this.$callApi('orderSearch:dataInit')
            this.companies = _.map(res.companies)
            this.isAdmin = res.isAdmin
            if (!this.isAdmin) {
                this.company_id = res.user.id
            }
            loader.hide()
        }
    }
</script>
