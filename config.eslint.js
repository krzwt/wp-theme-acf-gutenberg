// config.eslint.js
import js from '@eslint/js';

/** @type {import("eslint").FlatConfig[]} */
export default [
  js.configs.recommended, // ESLint's recommended base rules

  {
    files: ["**/*.js"],
    languageOptions: {
      ecmaVersion: "latest",
      sourceType: "module",
      globals: {
        $: 'readonly',        // jQuery
        jQuery: 'readonly',    // Optional
        window: "readonly",
        document: "readonly",
      },
    },

    rules: {
      "no-console": "error",
      "no-debugger": "error",
      semi: ["error", "always"],
      quotes: ["error", "single"],
      indent: ["error", 4],
      eqeqeq: ["error", "always"], // Enforce strict equality ===
      curly: ["error", "all"], // Enforce curly braces for all control statements
      "no-unused-vars": ["warn", { args: "none", ignoreRestSiblings: true }], // Warn on unused vars
      "no-var": "error", // Enforce let/const over var
      "prefer-const": ["error", { destructuring: "all" }], // Use const where possible
      "arrow-spacing": ["error", { before: true, after: true }], // Clean arrow function spacing
      "comma-dangle": ["error", "always-multiline"], // Trailing comma in multiline objects/arrays
      "object-curly-spacing": ["error", "always"], // Spacing inside curly braces
      "array-bracket-spacing": ["error", "never"], // No spacing inside array brackets
      "space-before-function-paren": ["error", "never"], // No space before function parentheses
      "keyword-spacing": ["error", { before: true, after: true }], // Consistent keyword spacing
    },
  },
];
