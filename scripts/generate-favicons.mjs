#!/usr/bin/env node
// Generate favicon.svg (SVGO-optimized), apple-touch-icon.png, icon-192.png,
// icon-512.png, favicon.ico from public/images/aletheia-logo.svg.
// Re-run manually via: node scripts/generate-favicons.mjs

import { readFileSync, writeFileSync } from 'node:fs';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';
import pngToIco from 'png-to-ico';
import { optimize } from 'svgo';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = resolve(__dirname, '..');
const src = resolve(root, 'public/images/aletheia-logo.svg');
const pub = resolve(root, 'public');

const svgSource = readFileSync(src, 'utf8');

const { data: optimizedSvg } = optimize(svgSource, {
    multipass: true,
    plugins: [
        'preset-default',
        'removeDimensions',
        'removeXMLNS',
        { name: 'addAttributesToSVGElement', params: { attributes: [{ xmlns: 'http://www.w3.org/2000/svg' }] } },
    ],
});

writeFileSync(resolve(pub, 'favicon.svg'), optimizedSvg);

const png = (size) => sharp(Buffer.from(optimizedSvg), { density: 512 }).resize(size, size, { fit: 'contain', background: { r: 255, g: 255, b: 255, alpha: 0 } }).png();

await png(180).toFile(resolve(pub, 'apple-touch-icon.png'));
await png(192).toFile(resolve(pub, 'icon-192.png'));
await png(512).toFile(resolve(pub, 'icon-512.png'));

const icoSources = await Promise.all([16, 32, 48].map((s) => png(s).toBuffer()));
const icoBuffer = await pngToIco(icoSources);
writeFileSync(resolve(pub, 'favicon.ico'), icoBuffer);

console.log('Favicons written:');
console.log('  public/favicon.svg         (', optimizedSvg.length, 'bytes)');
console.log('  public/favicon.ico         (16/32/48)');
console.log('  public/apple-touch-icon.png (180x180)');
console.log('  public/icon-192.png         (192x192)');
console.log('  public/icon-512.png         (512x512)');
