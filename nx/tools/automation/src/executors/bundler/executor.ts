import { WordpressBundlerExecutorSchema } from './schema';
import * as chokidar from 'chokidar';
import { exec } from 'child_process';
import * as fs from 'fs-extra';
import * as path from 'path';
import * as console from 'console';

const copyFrom = path.join(__dirname, '../../../../../dist/apps/wordpress-threed-builder/browser');
const copyToBase = path.join(__dirname, '../../../../../dist/apps/fictivecode/public/3d-builder');

export default async function runExecutor(
  options: WordpressBundlerExecutorSchema
): Promise<{ success: boolean }> {
  const watcher = chokidar.watch(options.paths, {
    ignored: options.ignored,
    persistent: true,
  });

  const buildProject = () => {

    return new Promise<{ success: boolean }>((resolve, reject) => {
      exec('nx build wordpress-threed-builder --configuration=wordpress --output-hashing=none', (error, stdout, stderr) => {
        if (error) {
          console.error(stderr);
          resolve({ success: false });
        } else {
          console.log(`Build output: ${stdout}`);
        }
      });
    });
  };



  watcher
    .on('change', async path => {
      console.log(`File ${path} has been changed`);
      await buildProject();
      console.log(`build complete!`);
    })
  console.log('Watching for file changes...');

  return new Promise<{ success: boolean }>(resolve => {
    watcher.on('error', error => {
      console.error('Watcher error:', error);
      resolve({ success: false });
    });
  });
}
