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
    this.designLayers = [...this.designLayers.slice(0, index + 1), patternLayer, ...this.designLayers.slice(index + 1)];
    this.designLayers.map((layer: LayerTypes, index: number) => layer.path.zIndex = index);
  }

  addDesignLayer(designLayer: DesignLayer[]) {
    this.designLayers = [...this.designLayers, ...designLayer];
    this.designLayers.map((layer: LayerTypes, index: number) => layer.path.zIndex = index);
  }

  removeAllLayer() {
    this.designLayers.map((layer: LayerTypes) => {
      layer.path.shape.destroy();
      if(layer.type === 'pattern') {
        layer.pattern.shape.destroy();
      }
    })
    this.designLayers = [];
  }


  getPatternForLayer(patternId: string) {
    const pattern =  this.designLayers
      .find((layer): layer is PatternLayer  => layer.type === 'pattern' && layer.path.id === patternId);
    return pattern ? pattern : false;
  }
}
