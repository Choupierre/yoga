"use strict";
var _a;
exports.__esModule = true;
require("../css/app.postcss");
var vue_1 = require("vue");
var inertia_vue3_1 = require("@inertiajs/inertia-vue3");
var progress_1 = require("@inertiajs/progress");
var inertia_helpers_1 = require("laravel-vite-plugin/inertia-helpers");
var vue_m_1 = require("../../vendor/tightenco/ziggy/dist/vue.m");
var appName = ((_a = window.document.getElementsByTagName('title')[0]) === null || _a === void 0 ? void 0 : _a.innerText) || 'Laravel';
var pinia = createPinia();
(0, inertia_vue3_1.createInertiaApp)({
    title: function (title) { return "".concat(title, " - ").concat(appName); },
    resolve: function (name) { return (0, inertia_helpers_1.resolvePageComponent)("./Pages/".concat(name, ".vue"), import.meta.glob('./Pages/**/*.vue')); },
    setup: function (_a) {
        var el = _a.el, app = _a.app, props = _a.props, plugin = _a.plugin;
        return (0, vue_1.createApp)({ render: function () { return (0, vue_1.h)(app, props); } })
            .use(plugin)
            .use(pinia)
            .use(vue_m_1.ZiggyVue, Ziggy)
            .mount(el);
    }
});
progress_1.InertiaProgress.init({ color: '#4B5563' });
