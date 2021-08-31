import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        dark: false,
        themes: {
            light: {
                primary: '#139025',
                background: '#c2f8b4', // Not automatically applied
                cream: '#ffffee',
            },
        },
    },
});
