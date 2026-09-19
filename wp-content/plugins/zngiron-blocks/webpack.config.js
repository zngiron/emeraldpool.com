/**
 * wp-scripts, plus one extra entry.
 *
 * When a project has block.json files, wp-scripts uses them as its entry points
 * and ignores src/index.js. The Frame stylesheet is shared by five blocks and so
 * belongs to none of them, which is the one thing that needs adding back.
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const [ scripts, ...rest ] = defaultConfig;

module.exports = [
  {
    ...scripts,
    entry: async () => ( {
      ...( typeof scripts.entry === 'function' ? await scripts.entry() : scripts.entry ),
      'style-index': './src/index.js',
    } ),
  },
  ...rest,
];
