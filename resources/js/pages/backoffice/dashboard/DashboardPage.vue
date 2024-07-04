<script>
export default {
    name: "DashboardPage",
}
</script>

<script setup>
import DataProvider from '@/providers/DataProvider.js'
import useDataProvider from "@/composables/useDataProvider.js";
import useAxios from "@/composables/useAxios.js";
import { AppSpinner } from "@/components/ui";
import { HorizontalDivider } from "@/components/ui/dividers"
import { StatsTemplate } from "@/components/templates";
import { DashboardStats } from "@/components/backoffice/dashboard";
import { UserInfo } from "@/components/backoffice";


defineProps({
    jsonUrl: {
        type: String,
        required: true,
    },
})

const { dataProviderKey } = useDataProvider();
const { makeRequest } = useAxios();
const requestTest = async () => {
    const { data } = await makeRequest({
        method: 'post',
        url: '/backoffice/test',
        data: {
            name: 'test',
        }
    });
}
requestTest()

</script>

<template>
    <DataProvider
        :provider-key="dataProviderKey"
        :url="jsonUrl"
    >
        <template v-slot="{loading, error, data}">
            <AppSpinner v-if="loading"/>

            <template v-if="!loading && !error">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <UserInfo :user="data?.user"/>
                    </div>
                </div>

                <horizontal-divider/>

                <StatsTemplate>
                    <DashboardStats :stats="data?.stats"/>
                </StatsTemplate>
            </template>

        </template>
    </DataProvider>
</template>
