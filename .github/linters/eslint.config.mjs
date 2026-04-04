import pluginVue from "eslint-plugin-vue";
import eslintConfigPrettier from "eslint-config-prettier";

export default [
    ...pluginVue.configs["flat/recommended"],
    eslintConfigPrettier,
    {
        rules: {
            "no-unused-vars": "off",
            "vue/multi-word-component-names": "off",
        },
    },
];
