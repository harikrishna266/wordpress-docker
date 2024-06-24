import { Pipe, PipeTransform } from '@angular/core';
import { DesignLayer, LayerTypes } from '../types/three-d-builder-layer.type';

@Pipe({
  name: 'filterByDesignLayer'
})
export class DesignLayerFilterPipe implements PipeTransform {
  transform(items: LayerTypes[], ): DesignLayer[] {
    return items.filter((item: LayerTypes): item is DesignLayer => item.type === 'layer');
  }
}
