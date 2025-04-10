import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

const notyf = new Notyf({
    duration: 2000,
    position: { x: 'right', y: 'top' },
    ripple: true
});

export default {
    install(Vue) {
        Vue.prototype.$notyf = notyf;
    }
};
