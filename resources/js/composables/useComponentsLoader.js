import { defineAsyncComponent} from "vue";

export default function useComponentsLoader() {
    const statsLoader = component =>{
        return defineAsyncComponent({
            loader: () => import('@/components/ui/stats')
                .then(module => module[component])
        });
    }

    const loadComponents= (items, loader) => {
        return items.map((item) => {
            return {
                name: item.component,
                component: loader(item.component),
            }
        })
    }
    const removeDuplicates = (components) => {
        return components.filter((component, index, self) =>
            index === self.findIndex((t)=> (
                t.name === component.name
            ))
        );
    }

    const components = (items, loader) => {
        const loadedComponents = loadComponents(items, loader);
        return removeDuplicates(loadedComponents);
    }

    const findComponentByName = (name, components) => {
        return components.find(component => component.name === name).component;
    }

    return {
        statsLoader,
        components,
        findComponentByName,
    }
}
