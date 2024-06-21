import { Layer } from './layer.type';

export type Designs = {
  id: string;
  name: string;
  layers: Layer[],
  model_id: string;
  user: string;
};
