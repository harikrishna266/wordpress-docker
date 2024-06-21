import { Injectable } from '@angular/core';
import { LayerTypes } from './types/three-d-builder-layer.type';

@Injectable({
  providedIn: 'root'
})
export class LayerHelper {

  designLayers: LayerTypes[] = []

}
