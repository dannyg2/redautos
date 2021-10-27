import Home from "@/components/ExampleComponent.vue";
import Home2 from "@/components/Home.vue";

export default [
    { path: '', name: 'index', component: Home2 },
    { path: '/home', name: 'home', component: Home2 },
];