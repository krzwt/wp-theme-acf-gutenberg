// config.stylelint.js
export default {
    extends: ['stylelint-config-standard-scss', 'stylelint-config-clean-order/error'],
    plugins: ['stylelint-scss'],
    rules: {
        'selector-class-pattern': '^[a-z0-9\\-]+$', // kebab-case only
        'at-rule-no-unknown': null,
        'scss/at-rule-no-unknown': true,
        'max-nesting-depth': [4, { ignore: ['pseudo-classes'] }],
      
        // ✅ Disable conflicting spacing rules properly
        'scss/at-else-empty-line-before': 'never',
        'scss/at-if-closing-brace-newline-after': null,
        'scss/at-if-closing-brace-space-after': null,
        'scss/at-else-closing-brace-newline-after': null,
        'scss/at-else-closing-brace-space-after': null,
      
        // ✅ Adjust spacing around @rules
        'at-rule-empty-line-before': ['always', {
          except: ['blockless-after-same-name-blockless', 'first-nested'],
          ignore: ['after-comment', 'inside-block']
        }]
    },      
    overrides: [
      {
        files: ['**/*.scss'],
        customSyntax: 'postcss-scss',
      },
    ],
};