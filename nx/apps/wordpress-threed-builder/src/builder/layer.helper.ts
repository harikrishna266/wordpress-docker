import { Injectable } from '@angular/core';
import { DesignLayer, LayerTypes, PatternLayer } from './types/three-d-builder-layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
import { Layer } from './types/layer.type';

@Injectable({
  providedIn: 'root'
})
export class LayerHelper {

  designLayers: LayerTypes[] = []

  addPattern(path: Path, pattern: Path, layer: Layer,  selectedLayer: DesignLayer, ) {
    const patternLayer: PatternLayer = {
      layer, path, type: 'pattern', pattern, enabled: true
    };
    const index = this.designLayers.findIndex((layer) => layer.layer.id === selectedLayer.layer.id);
    this.designLayers = [...this.designLayers.slice(0, index), patternLayer, ...this.designLayers.slice(index)];
  }

  getPatternForLayer(selectedLayer: LayerTypes) {
    return this.designLayers.find((layer) => layer.type === 'pattern' && layer.path.id === selectedLayer.layer.id);
  }
}
