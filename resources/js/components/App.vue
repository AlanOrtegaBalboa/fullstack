<script>
import {defineAsyncComponent} from "vue";

const AppToastProvider = defineAsyncComponent(() => import('@/providers/AppToastProvider.vue'));
const BackofficeLayout = defineAsyncComponent(() => import('@/layouts/BackofficeLayout.vue'));
const DashboardPage = defineAsyncComponent( () => import('@/pages/backoffice/dashboard/DashboardPage.vue'))
export default {
    name: 'App',
    components: {
        AppToastProvider,
        BackofficeLayout,
        DashboardPage,
    },
    setup() {
        return {

        }
    }
}
</script>

