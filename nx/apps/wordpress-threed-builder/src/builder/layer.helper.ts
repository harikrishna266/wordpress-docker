import { Injectable } from '@angular/core';
import { DesignLayer, LayerTypes, PatternLayer } from './types/three-d-builder-layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';

@Injectable({
  providedIn: 'root'
})
export class LayerHelper {

  designLayers: LayerTypes[] = []

  addPattern(path: Path, pattern: Path,  selectedLayer: DesignLayer ) {
    const patternLayer: PatternLayer = {
      layer: selectedLayer.layer,  path, type: 'pattern', pattern,
    };
    const index = this.designLayers.findIndex((layer) => layer.layer.id === selectedLayer.layer.id);
    this.designLayers = [...this.designLayers.slice(0, index), patternLayer, ...this.designLayers.slice(index)];
  }

  getPatternForLayer(patternId: string) {
    const pattern =  this.designLayers
      .find((layer): layer is PatternLayer  => layer.type === 'pattern' && layer.path.id === patternId);
    return pattern ? pattern : false;
  }
}
