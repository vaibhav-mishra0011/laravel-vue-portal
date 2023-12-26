
import './bootstrap';
import { createApp } from 'vue';
import vuetify from "./vuetify";



const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import PortalLayout from './components/PortalLayout.vue';

app.component('example-component', ExampleComponent);
app.component('portal-layout',PortalLayout);
app.use(vuetify);
app.mount('#app');
