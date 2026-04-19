const esbuild = require('esbuild');
const path = require('path');
const fs = require('fs');

const isWatch = process.argv.includes('--watch');

const cssInjectPlugin = {
    name: 'css-inject',
    setup(build) {
        build.onLoad({ filter: /\.css$/ }, async (args) => {
            const css = await fs.promises.readFile(args.path, 'utf8');
            const escaped = css.replace(/\\/g, '\\\\').replace(/`/g, '\\`').replace(/\$/g, '\\$');
            return {
                contents: `
                    (function() {
                        if (typeof document !== 'undefined' && !document.querySelector('style[data-univer-sheet]')) {
                            var s = document.createElement('style');
                            s.setAttribute('data-univer-sheet', '');
                            s.textContent = \`${escaped}\`;
                            document.head.appendChild(s);
                        }
                    })();
                `,
                loader: 'js',
            };
        });
    },
};

const config = {
    entryPoints: [
        path.resolve(__dirname, '../resources/js/univer-sheet.js'),
    ],
    outfile: path.resolve(__dirname, '../resources/js/dist/univer-sheet.js'),
    bundle: true,
    minify: !isWatch,
    sourcemap: isWatch,
    format: 'iife',
    target: ['es2020'],
    plugins: [cssInjectPlugin],
    define: {
        'process.env.NODE_ENV': '"production"',
    },
};

if (isWatch) {
    esbuild.context(config).then((ctx) => {
        ctx.watch();
        console.log('Watching...');
    });
} else {
    esbuild.build(config).then(() => {
        console.log('Build complete.');
    });
}
