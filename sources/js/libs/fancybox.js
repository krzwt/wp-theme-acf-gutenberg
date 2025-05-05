// fancyboxInit.js
import { Fancybox } from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

export const initFancybox = () => {
    Fancybox.bind('[data-fancybox]', {
        loop: true,
        Toolbar: {
            display: ['close'],
        },
    });
};
