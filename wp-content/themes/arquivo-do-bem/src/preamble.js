// // src/preamble.js
// import RefreshRuntime from 'http://localhost:5173/@react-refresh'
// RefreshRuntime.injectIntoGlobalHook(window)
// window.$RefreshReg$ = () => {}
// window.$RefreshSig$ = () => (type) => type
// window.__vite_plugin_react_preamble_installed__ = true

// wp-content/themes/arquivo-do-bem/src/preamble.js
import RefreshRuntime from '/@react-refresh'

RefreshRuntime.injectIntoGlobalHook(window)
window.$RefreshReg$ = () => {}
window.$RefreshSig$ = () => (type) => type
window.__vite_plugin_react_preamble_installed__ = true

