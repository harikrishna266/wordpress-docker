import { Injectable } from '@angular/core';
import { DesignLayer, LayerTypes, PatternLayer } from './types/three-d-builder-layer.type';
import { Pattern } from './types/pattern.type';
import { Layer } from './types/layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
import { Stage2D } from '@brocha-libs/builder-2d';

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
      layer.path.zIndex = index;
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


  getPatternForLayer(layerId: string) {
    const pattern =  this.designLayers
      .find((layer): layer is PatternLayer  => layer.type === 'pattern' && layer.path.id === layerId);
    return pattern ? pattern : false;
  }

  async createPattern(patternData: string, pattern: Pattern, designLayer: DesignLayer, stage: Stage2D) {
    const patternPath = stage.createShape('path') as Path;
    patternPath.setAttrs({
      id: pattern.id,
      scaleX: 1,
      scaleY: 1,
      data: patternData,
    });

    const image = await patternPath.shape.toImage({
      x: 0,
      y: 0,
      mimeType: 'image/png',
      width: pattern.width,
      height: pattern.height,
      quality: 1,
      pixelRatio: 1
    }) as any;

    const path =   stage.createShape('path') as Path;
    path.setAttrs({
      id: designLayer.layer.id,
      fill: '',
      data: designLayer.path.data,
      scaleX: 1,
      scaleY: 1,
      fillPatternImage: image,
    });
    await stage.addShape(stage.layer, path);
    const patternLayer: PatternLayer = {layer: designLayer.layer, path, basePath: designLayer.path, patternImage: patternPath, type: 'pattern', };
    this.addPattern(patternLayer);
    stage.layer.draw();
  }


  async updatePattern(pattern: Pattern, patternLayer: PatternLayer, patternSection: string, stage: Stage2D) {
    patternLayer.patternImage.setAttrs({...patternLayer.patternImage.serialize(), data: patternSection});
    const image = await patternLayer.patternImage.shape.toImage({
      x: 0,
      y: 0,
      mimeType: 'image/png',
      width: pattern.width,
      height: pattern.height,
      quality: 1,
      pixelRatio: 1
    }) as any;
    await patternLayer.path.shape.fillPatternImage(image);
    stage.layer.draw();
  }
}
