import { Component, EventEmitter, Input, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SceneHelper } from '@brocha-libs/builder-3d';
import { Layer } from '../types/layer.type';
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

  currentTab: 'color' | 'pattern' = 'pattern';
  goodColors: string[] = [
    '#FFFFFF',
    '#FF5733',
    '#33FF57',
    '#3357FF',
    '#FF33A6',
    '#FFBD33',
    '#33FFF0',
    '#FF33E0',
    '#FFD700',
    '#4CAF50',
    '#2196F3',
    '#FF5722',
    '#9C27B0',
    '#E91E63',
    '#3F51B5',
    '#00BCD4',
    '#8BC34A',
    '#FFC107',
    '#FF9800',
    '#607D8B',
    '#795548'
  ];

  selectLayer(layer: LayerWithSelection) {
    this.layers.map((layer) =>  layer.selected = false);
    layer.selected = true;
    this.selectedLayer = layer;
  }

  colourSelected(color: string) {
    const selectedLayer = this.layers.find((layer) => layer.selected) as LayerWithSelection;
    const { selected, ...layer } = selectedLayer;
    this.colourPicked.next({layer, color})
  }
}
