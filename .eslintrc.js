module.exports = {
  parserOptions: {
    sourceType: 'module'
  },
  env: {
    browser: true,
    es6: true,
  },
  globals: {
    ASSET_VERSION: true,
    DEBUG: true,
    SERVER_URL: true,
  },
  extends: [
      'airbnb-base',
  ],
  settings: {
    'import/core-modules': ['Routing'],
  },

  rules: {
    'lines-between-class-members': 0,
    'operator-linebreak': 0,
    'no-plusplus': 0,
    'import/prefer-default-export': 0,
    'no-mixed-operators': 0,
    'no-underscore-dangle': 0,
    'prefer-template': 0,
    'func-names': 0,
    'class-methods-use-this': 0,
    'import/no-mutable-exports': 0,
    "arrow-body-style": ["error", "as-needed"],
    "strict": 0,
    "arrow-parens": 0,
    "no-bitwise": ["error", { "allow": ["~"] }],
    'no-throw-literal': 0,
    "semi-style": 0,
    "function-paren-newline": 0,
    "no-new": 0,
    'object-curly-newline': 0,
    "no-restricted-syntax": [
      'error',
      'LabeledStatement',
      'WithStatement',
    ],
    "no-continue": 0,
    "no-console": 0,
  },
};
