import { Injectable } from '@angular/core';
import { DesignLayer, LayerTypes, PatternLayer } from './types/three-d-builder-layer.type';

@Injectable({
  providedIn: 'root'
})
export class LayerHelper {

  designLayers: LayerTypes[] = []

  addPattern(patternLayer: PatternLayer ) {
    const index = this.designLayers
      .findIndex((layer) => layer.layer.id === patternLayer.layer.id && layer.type === 'layer');
    this.designLayers = [...this.designLayers.slice(0, index + 1), patternLayer, ...this.designLayers.slice(index + 1)];
    this.setZIndex();
  }

  setZIndex() {
    this.designLayers.map((layer, index) => {
      layer.path.shape.zIndex(index);
    });
  }

  addDesignLayer(designLayer: DesignLayer[]) {
    this.designLayers = [...this.designLayers, ...designLayer];
    this.setZIndex();
  }

  removeAllLayer() {
    this.designLayers.map((layer: LayerTypes) => {
      layer.path.shape.destroy();
      if(layer.type === 'pattern') {
        layer.basePath.shape.destroy();
        layer.path.shape.destroy();
        layer.patternImage.shape.destroy();
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
