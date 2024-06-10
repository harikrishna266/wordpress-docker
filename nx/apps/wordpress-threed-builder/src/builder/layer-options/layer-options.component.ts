import { Component, EventEmitter, Input, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SceneHelper } from '@brocha-libs/builder-3d';
import { LayerNames } from '../types/design.type';

@Component({
  selector: 'app-layer-options',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layer-options.component.html',
  styleUrl: './layer-options.component.css',
})
export class LayerOptionsComponent {
  selectedLayer: LayerNames = 'layer_1';
  @Input() sceneHelper!: SceneHelper;
  @Output() colourPicked: EventEmitter<{layer: LayerNames, color: string}> = new EventEmitter();
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

  selectLayer(layer: LayerNames) {
    this.selectedLayer = layer;
  }

  colourSelected(color: string) {
    this.colourPicked.next({layer: this.selectedLayer, color: color})
  }
}
