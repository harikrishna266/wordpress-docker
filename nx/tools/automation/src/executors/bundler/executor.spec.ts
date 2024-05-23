import { WordpressBundlerExecutorSchema } from './schema';
import executor from './executor';

const options: WordpressBundlerExecutorSchema = {};

describe('WordpressBundler Executor', () => {
  it('can run', async () => {
    const output = await executor(options);
    expect(output.success).toBe(true);
  });
});
