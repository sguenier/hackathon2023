/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution');

module.exports = {
  root: true,
  'extends': [
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    '@vue/eslint-config-prettier/skip-formatting',
  ],
  parserOptions: { ecmaVersion: 'latest' },
  rules: {
    'vue/multi-word-component-names': 'off',
    'comma-dangle': [ 'error', 'always-multiline' ],
    'no-console': 'warn',
    'vue/block-tag-newline': [
      'error',
      {
        singleline: 'never',
        multiline: 'always',
        maxEmptyLines: 1,
      },
    ],
    'vue/html-indent': [
      'error',
      2,
      {
        attribute: 1,
        baseIndent: 1,
        closeBracket: 0,
        alignAttributesVertically: true,
        ignores: [],
      },
    ],
    'vue/max-attributes-per-line': [
      'error',
      {
        "singleline": {
          "max": 1,
        },      
      },
    ],
    "vue/first-attribute-linebreak": [
      "error",
      {
        "singleline": "ignore",
        "multiline": "below",
      },
    ],
    "vue/html-closing-bracket-newline": [
      "error",
      {
        "singleline": "never",
        "multiline": "always",
      },
    ],
    "vue/html-self-closing": [
      "error",
      {
        "html": {
          "void": "never",
          "normal": "always",
          "component": "always",
        },
        "svg": "always",
        "math": "always",
      },
    ],
    'vue/component-name-in-template-casing': [
      'error',
      'kebab-case',
      { registeredComponentsOnly: false },
    ],
    'vue/custom-event-name-casing': [ 'error', 'kebab-case' ],
    'vue/require-name-property': 'error',
    'vue/component-tags-order': [
      'error',
      {
        order: [
          'template',
          'script',
          'style',
        ], 
      },
    ],
    'indent': [
      'error',
      2,
      { 'SwitchCase': 1 },
    ],
    'object-curly-spacing': [ 'error', 'always' ],
    'array-bracket-newline': [
      'error',
      {
        'multiline': true,
        'minItems': 3, 
      },
    ],
    'array-bracket-spacing': [ 'error', 'always' ],
    'array-element-newline': [
      'error',
      {
        'multiline': true,
        'minItems': 3, 
      },
    ],
    'arrow-body-style': [ 'error', 'as-needed' ],
    'semi': [ 'error', 'always' ],
    'vue/require-explicit-emits': 'error',
    "vue/order-in-components": [
      "error",
      {
        "order": [
          "el",
          "name",
          "key",
          "parent",
          "functional",
          [ "delimiters", "comments" ],
          [
            "components",
            "directives",
            "filters",
          ],
          "extends",
          "mixins",
          [ "provide", "inject" ],
          "ROUTER_GUARDS",
          "layout",
          "middleware",
          "validate",
          "scrollToTop",
          "transition",
          "loading",
          "inheritAttrs",
          "model",
          "emits",
          [ "props", "propsData" ],
          "setup",
          "asyncData",
          "data",
          "fetch",
          "head",
          "computed",
          "watch",
          "watchQuery",
          "LIFECYCLE_HOOKS",
          "methods",
          [ "template", "render" ],
          "renderError",
        ],
      },
    ],
  },
};
