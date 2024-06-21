import { Component, EventEmitter, Input, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SceneHelper } from '@brocha-libs/builder-3d';
import { Layer } from '../types/layer.type';
import { colors } from '../colors';
type LayerWithSelection = Layer & { selected: boolean};
@Component({
  selector: 'app-layer-color-picker',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layer-color-picker.component.html',
  styleUrl: './layer-color-picker.component.css',
})

export class LayerColorPickerComponent {
  selectedLayer!: Layer;
  @Input() sceneHelper!: SceneHelper;
  @Output() colourPicked: EventEmitter<{layer: Layer, color: string}> = new EventEmitter();

  private _layers!: Array<LayerWithSelection>;
  @Input()
  public get layers(): Array<LayerWithSelection> {
    return this._layers;
  }
  public set layers(layers: Layer[]) {
    this._layers = layers.map((layer) => ({...layer, selected: false}));
  }

  goodColors: string[] = colors;

  selectLayer(layer: LayerWithSelection) {
    this.layers.map((layer) =>  layer.selected = false);
    layer.selected = true;
    this.selectedLayer = layer;
  }

  get isLayerSelected() {
    return this.layers.some((layer) => layer.selected);
  }

  colourSelected(color: string) {
    const selectedLayer = this.layers.find((layer) => layer.selected) as LayerWithSelection;
    const { selected, ...layer } = selectedLayer;
    this.colourPicked.next({layer, color})
  }
}
