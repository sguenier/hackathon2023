/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

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
  },
}
