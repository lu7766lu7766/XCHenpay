<template>
    <div class="date-btn">
        <button type="button" class="btn btn-info-lighter" data-toggle="button" @click="yesterday">昨日</button>
        <button type="button" class="btn btn-info-lighter" data-toggle="button" @click="today">今日</button>
        <button type="button" class="btn btn-info-lighter" data-toggle="button" @click="lastWeek">上周</button>
        <button type="button" class="btn btn-info-lighter" data-toggle="button" @click="thisWeek">本周</button>
        <button type="button" class="btn btn-purple-lighter" data-toggle="button" @click="lastMonth">上月</button>
        <button type="button" class="btn btn-purple-lighter" data-toggle="button" @click="thisMonth">本月</button>
    </div>
</template>

<script>
    export default {
        prop: ['startTime', 'endTime'],
        methods: {
            updateTime(data) {
                this.$emit('update:startTime', data.start)
                this.$emit('update:endTime', data.end)
            },
            yesterday() {
                this.updateTime({
                    start: moment().subtract(1, 'days').startOf('day'),
                    end: moment().subtract(1, 'days').endOf('day')
                })
            },
            today() {
                this.updateTime({
                    start: moment().startOf('day'),
                    end: moment().endOf('day')
                })
            },
            lastWeek() {
                this.updateTime({
                    start: moment().subtract(1, 'weeks').startOf('isoWeek'),
                    end: moment().subtract(1, 'weeks').endOf('isoWeek')
                })
            },
            thisWeek() {
                this.updateTime({
                    start: moment().startOf('isoWeek'),
                    end: moment().endOf('isoWeek')
                })
            },
            lastMonth() {
                this.updateTime({
                    start: moment().subtract(1, 'months').startOf('month'),
                    end: moment().subtract(1, 'months').endOf('month')
                })
            },
            thisMonth() {
                this.updateTime({
                    start: moment().startOf('month'),
                    end: moment().endOf('month')
                })
            }
        }
    }
</script>
