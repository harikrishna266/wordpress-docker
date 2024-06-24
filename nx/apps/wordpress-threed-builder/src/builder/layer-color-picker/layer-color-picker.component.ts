import { Component, inject, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LayerHelper } from '../layer.helper';
import { LayerTypes } from '../types/three-d-builder-layer.type';
import { colors } from '../colors';
import { DynamicTexture } from '@brocha-libs/builder-3d';
import { Stage2D } from '@brocha-libs/builder-2d';
import { PipesModule } from '../pipes/pipes.module';
@Component({
  selector: 'app-layer-color-picker',
  standalone: true,
  imports: [CommonModule, PipesModule],
  templateUrl: './layer-color-picker.component.html',
  styleUrl: './layer-color-picker.component.css',
})

export class LayerColorPickerComponent {
  @Input() dynamicTexture!: DynamicTexture;
  @Input() stage!: Stage2D;
  public readonly layerHelper = inject(LayerHelper);
  public selectedLayer!: LayerTypes;
  public colours = colors;
  selectLayer(layer: LayerTypes) {
    this.selectedLayer = layer;
  }

  setColor(color: string) {
    this.selectedLayer.path.setAttrs({fill: color});
    this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }
}
