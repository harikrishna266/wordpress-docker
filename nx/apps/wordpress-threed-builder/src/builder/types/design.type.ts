export type Designs = {
  ID: string;
  name: string;
  design_layer_1: string;
  design_layer_2: string;
  design_layer_3?: string;
  design_layer_4?: string;
  model_id: string;
  user: string;
};


export type LayerNames = 'layer_1' | 'layer_2' | 'layer_3' | 'layer_4';
