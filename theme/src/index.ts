import 'styles/index.scss';

/**
 * Initializes the website.
 */
const init = (): void => {
    console.log('initialized...');
};

if (document.readyState !== 'loading') {
    init();
} else {
    document.addEventListener('DOMContentLoaded', (): void => {
        init();
    });
}