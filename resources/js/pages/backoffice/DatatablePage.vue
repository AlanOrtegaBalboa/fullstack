<script>
export default {
    name: "DatatablePage",
}
</script>

<script setup>
import {ref} from "vue";
import DataProvider from '@/providers/DataProvider.js';
import useDataProvider from "@/composables/useDataProvider.js";
import useDatatable from "@/composables/useDatatable.js";
import { TableListTemplate } from "@/components/templates";
import { AppDatatableSkeleton } from "@/components/ui/skeletons";
import { AppSpinner } from "@/components/ui";
import { AppErrorState } from "@/components/ui/states";
import { AppTable } from "@/components/common";

defineProps({
    jsonUrl: {
        type: String,
        required: true,
    }
});
const { dataProviderKey, updateDataProvider } = useDataProvider();

const columns = ref([]);

const initConfig = data => {
    columns.value = data?.table_columns || [];
};
const {
    filters, updateSorter, filterData, paginate,
} = useDatatable(columns);

</script>

<template>
    <DataProvider
        :provider-key="dataProviderKey"
        :url="jsonUrl"
        :filters="filters"
        @refreshed="initConfig"
    >
        <template v-slot="{loading, data, error}">
            <template v-if="! error">
                <AppSpinner v-if="loading"/>

                <AppDatatableSkeleton
                    v-if="loading && data?.skeleton"
                    :columns="columns"
                    :rows="10"
                />

                <TableListTemplate v-if="!loading">
                    <template v-slot:topActionButtons>

                    </template>
                    <template v-slot:filters>

                    </template>
                    <template v-slot:table>
                        <AppTable
                            :columns="columns"
                            :table-data="data?.table_data"
                            @sort="updateSorter($event, () => updateDataProvider());"
                            @paginate="paginate($event, () => updateDataProvider());"
                            @actionDispatched="updateDataProvider"
                        />
                    </template>

                    <template v-slot:modals>

                    </template>
                </TableListTemplate>
            </template>

            <AppErrorState
                v-else
                :error="error"
                @refresh="updateDataProvider"
            />
        </template>
    </DataProvider>
</template>


