import { WordpressBundlerExecutorSchema } from './schema';
import * as chokidar from 'chokidar';
import { exec } from 'child_process';
import * as fs from 'fs-extra';
import * as path from 'path';
import * as console from 'console';

export default async function runExecutor(
  options: WordpressBundlerExecutorSchema
): Promise<{ success: boolean }> {
  const watcher = chokidar.watch(options.paths, {
    ignored: options.ignored,
    persistent: true,
  });

  const buildProject = () => {
    return new Promise<{ success: boolean }>((resolve, reject) => {
      exec('nx build wordpress-threed-builder --output-hashing=none', (error, stdout, stderr) => {
        if (error) {
          console.error(`Build error: ${stderr}`);
          resolve({ success: false });
        } else {
          console.log(`Build output: ${stdout}`);
          combineModules()
            .then(() => resolve({ success: true }))
            .catch(err => {
              console.error(`Error combining modules: ${err}`);
              resolve({ success: false });
            });
        }
      });
    });
  };

  const combineModules = async () => {
    const distDir = path.join(__dirname, '../../../../../dist/apps/wordpress-threed-builder/browser');
    const wordpressPath = path.join(__dirname, '../../../../../apps/fictivecode/src/public/wordpress-scripts');

    const files = await fs.readdir(distDir);

    for (const file of files) {
      const outputFile = path.join(wordpressPath, file);
      const filePath = path.join(distDir, file);
      const content = await fs.readFile(filePath, 'utf-8');
      await fs.writeFile(outputFile, content, 'utf-8');
    }

  };

  watcher
    .on('change', async path => {
      console.log(`File ${path} has been changed`);
      await buildProject();
    })


  console.log('Watching for file changes...');

  return new Promise<{ success: boolean }>(resolve => {
    watcher.on('error', error => {
      console.error('Watcher error:', error);
      resolve({ success: false });
    });
  });
}
