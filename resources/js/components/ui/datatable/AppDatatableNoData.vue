<script>
export default {
    name: "AppDataTableNoData",
}
</script>

<script setup>
import { AppEmptyState } from '@/components/ui/states'
</script>

<template>
    <AppEmptyState
        title="No hay datos que mostar"
        message="No se encontraron dastos para mostrar en este listado"
    />
</template>
