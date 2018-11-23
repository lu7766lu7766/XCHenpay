<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30" v-if="isAdmin">
                <div class="card-header">
                    商户筛选
                </div>
                <div class="card-body">
                    <select class="form-control" v-model="company_id">
                        <option value="">請選擇商戶</option>
                        <option v-for="company in companies" :value="company.id">{{ company.company_name }}</option>
                    </select>
                </div>
            </div>
            <!-- fee start -->
            <component :is="isDataInit ? 'fee' : ''" v-if="company_id !== ''"/>
            <!-- fee end -->

            <!-- order start -->
            <component :is="isDataInit ? 'order' : ''" v-if="company_id !== ''"/>
            <!-- order end -->
        </div>
    </div>
</template>

<script>
    export default {
        api: "orderSearch",
        components: {
            Fee: require('./Fee'),
            Order: require('./Order'),
        },
        data: () => ({
            isDataInit: false,
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
            this.isDataInit = true
            loader.hide()
        }
    }
</script>
