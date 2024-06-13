import { Layer } from './layer.type';

export type Designs = {
  id: string;
  name: string;
  layers: Layer[],
  model_id: string;
  user: string;
};


export type LayerNames = 'layer_1' | 'layer_2' | 'layer_3' | 'layer_4';
