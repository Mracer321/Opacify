import * as si from 'simple-icons';
import { readFileSync, writeFileSync, existsSync } from 'fs';
import { join } from 'path';

const deviconRoot = 'node_modules/devicon/icons';

const deviconMap = {
    laravel: 'laravel/laravel-original',
    react: 'react/react-original',
    nodedotjs: 'nodejs/nodejs-original',
    flutter: 'flutter/flutter-original',
    vuedotjs: 'vuejs/vuejs-original',
    angular: 'angular/angular-original',
    python: 'python/python-original',
    php: 'php/php-original',
    mysql: 'mysql/mysql-original',
    postgresql: 'postgresql/postgresql-original',
    mongodb: 'mongodb/mongodb-original',
    docker: 'docker/docker-original',
    amazonaws: 'amazonwebservices/amazonwebservices-plain-wordmark',
    typescript: 'typescript/typescript-original',
    java: 'java/java-original',
    redis: 'redis/redis-original',
    javascript: 'javascript/javascript-original',
    html5: 'html5/html5-original',
    css: 'css3/css3-original',
    tailwindcss: 'tailwindcss/tailwindcss-original',
    bootstrap: 'bootstrap/bootstrap-original',
    springboot: 'spring/spring-original',
    android: 'android/android-original',
    apple: 'apple/apple-original',
    firebase: 'firebase/firebase-original',
    jenkins: 'jenkins/jenkins-original',
    github: 'github/github-original',
    tensorflow: 'tensorflow/tensorflow-original',
    openapiinitiative: 'openapi/openapi-original',
    githubactions: 'githubactions/githubactions-original',
    digitalocean: 'digitalocean/digitalocean-original',
};

const simpleIconsMap = {
    nextdotjs: 'siNextdotjs',
    n8n: 'siN8n',
    googleanalytics: 'siGoogleanalytics',
    powerbi: 'siPowerbi', // may be missing — fallback below
};

const aliases = {
    ReactJS: 'react',
    'React Native': 'react',
    React: 'react',
    'Next.js': 'nextdotjs',
    Nextjs: 'nextdotjs',
    'Node.js': 'nodedotjs',
    Nodejs: 'nodedotjs',
    'Vue.js': 'vuedotjs',
    Vue: 'vuedotjs',
    AWS: 'amazonaws',
    'Spring Boot': 'springboot',
    CSS3: 'css',
    TailwindCSS: 'tailwindcss',
    'AI/ML': 'tensorflow',
    'REST APIs': 'openapiinitiative',
    'CI/CD': 'githubactions',
    'VPS & Cloud Deployment': 'digitalocean',
    'cloud-deployment': 'digitalocean',
    Automation: 'n8n',
    'Data Analytics': 'googleanalytics',
    'Power BI': 'powerbi',
    iOS: 'apple',
    Redis: 'redis',
    HTML5: 'html5',
    JavaScript: 'javascript',
    TypeScript: 'typescript',
    PHP: 'php',
    Python: 'python',
    Java: 'java',
    MySQL: 'mysql',
    PostgreSQL: 'postgresql',
    MongoDB: 'mongodb',
    Docker: 'docker',
    Flutter: 'flutter',
    Angular: 'angular',
    Laravel: 'laravel',
    Bootstrap: 'bootstrap',
    Android: 'android',
    Firebase: 'firebase',
    Jenkins: 'jenkins',
    GitHub: 'github',
};

function uniquifySvgIds(svg, prefix) {
    return svg
        .replace(/\bid="([^"]+)"/g, (_, id) => `id="${prefix}-${id}"`)
        .replace(/url\(#([^)]+)\)/g, (_, id) => `url(#${prefix}-${id})`);
}

function readDevicon(relativePath, slug) {
    const path = join(deviconRoot, relativePath + '.svg');
    if (!existsSync(path)) {
        throw new Error('Devicon SVG not found: ' + path);
    }
    const raw = readFileSync(path, 'utf8');
    const viewBoxMatch = raw.match(/viewBox="([^"]+)"/i);
    const viewBox = viewBoxMatch ? viewBoxMatch[1] : '0 0 128 128';
    let inner = raw
        .replace(/<\?xml[^>]*>\s*/i, '')
        .replace(/<svg[^>]*>/i, '')
        .replace(/<\/svg>\s*$/i, '')
        .trim();
    inner = uniquifySvgIds(inner, slug);
    return { viewBox, svg: inner, source: 'devicon' };
}

function readSimpleIcon(exportName) {
    const icon = si[exportName];
    if (!icon) {
        throw new Error('Simple icon not found: ' + exportName);
    }
    return {
        viewBox: icon.viewBox || '0 0 24 24',
        svg: `<path fill="#${icon.hex}" d="${icon.path}"/>`,
        source: 'simple-icons',
    };
}

// Power BI — use embedded Simple Icons path (from simple-icons dataset when available)
const powerBiFallback = {
    viewBox: '0 0 24 24',
    svg: '<path fill="#F2C811" d="M5.371 2.026A1.07 1.07 0 0 0 4.582 2.823L.104 20.777a1.07 1.07 0 0 0 1.047 1.29h3.891a1.07 1.07 0 0 0 1.051-.877l.882-4.414h3.408l.882 4.414a1.07 1.07 0 0 0 1.051.877h3.891a1.07 1.07 0 0 0 1.047-1.29L19.418 2.823a1.07 1.07 0 0 0-.905-.783L12 2.094l-4.629.932zm1.127 5.654h2.916l1.167 5.842H5.331l1.167-5.842z"/>',
    source: 'simple-icons',
};

const logos = {};

for (const [slug, relative] of Object.entries(deviconMap)) {
    try {
        logos[slug] = readDevicon(relative, slug);
    } catch (e) {
        console.error(e.message);
    }
}

for (const [slug, exportName] of Object.entries(simpleIconsMap)) {
    try {
        logos[slug] = readSimpleIcon(exportName);
    } catch {
        if (slug === 'powerbi') {
            logos[slug] = powerBiFallback;
        } else {
            console.error('Missing simple icon:', slug);
        }
    }
}

function phpExport(value, depth = 0) {
    const pad = '    '.repeat(depth);
    if (Array.isArray(value)) {
        if (Object.keys(value).length === 0) {
            return '[]';
        }
        const isList = value.every((_, i) => String(i) in value);
        if (isList) {
            return (
                '[\n' +
                value.map((v) => pad + '    ' + phpExport(v, depth + 1)).join(',\n') +
                '\n' +
                pad +
                ']'
            );
        }
    }
    if (value && typeof value === 'object') {
        const entries = Object.entries(value).map(([k, v]) => {
            const key = `'${String(k).replace(/'/g, "\\'")}'`;
            return `${pad}    ${key} => ${phpExport(v, depth + 1)}`;
        });
        return `[\n${entries.join(',\n')}\n${pad}]`;
    }
    if (typeof value === 'string') {
        return `'${value.replace(/\\/g, '\\\\').replace(/'/g, "\\'")}'`;
    }
    return String(value);
}

const php = `<?php

/**
 * Official technology brand logos (Devicon + Simple Icons).
 * Regenerate: node scripts/generate-tech-logos.mjs
 */
return [
    'logos' => ${phpExport(logos, 0)},

    'aliases' => ${phpExport(aliases, 0)},
];
`;

writeFileSync('resources/data/tech-logos.php', php);
console.log('Generated', Object.keys(logos).length, 'technology logos');
