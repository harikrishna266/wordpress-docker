import { Component, EventEmitter, inject, Input, OnInit, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SceneHelper } from '@brocha-libs/builder-3d';
import { Layer } from '../types/layer.type';
import { colors } from '../colors';
import { tap } from 'rxjs';
import { Designs } from '../types/design.type';
import { WordpressService } from '../../services/wordpress.service';
import { Pattern } from '../types/pattern.type';
import { LayerService } from '../../services/layer.service';
type LayerWithSelection = Layer & { selected: boolean};


@Component({
  selector: 'app-layer-patterns',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layer-patterns.component.html',
  styleUrl: './layer-patterns.component.css',
})
export class LayerPatternsComponent implements OnInit {
  selectedLayer!: Layer;
  @Input() sceneHelper!: SceneHelper;
  @Output() patternPicked: EventEmitter<{layer: Layer, pattern: string}> = new EventEmitter();
  @Output() colourPicked: EventEmitter<{layer: Layer, color: string}> = new EventEmitter();

  private readonly wordpressService = inject(WordpressService)
  private readonly LayerService = inject(LayerService);

  goodColors: string[] = colors;

  private _layers!: Array<LayerWithSelection>;
  @Input()
  public get layers(): Array<LayerWithSelection> {
    return this._layers;
  }
  public set layers(layers: Layer[]) {
    this._layers = layers.filter((layer: Layer) => layer.allowPattern).map((layer) => ({...layer, selected: false}));
  }

  public patterns: Pattern[] = [];

  selectLayer(layer: LayerWithSelection) {
    this.layers.map((layer) =>  layer.selected = false);
    layer.selected = true;
    this.selectedLayer = layer;
  }

  ngOnInit() {
    this.wordpressService.getAllPatterns()
      .pipe(
        tap((patterns: Pattern[]) => this.patterns = patterns)
      )
      .subscribe()
  }

  get isLayerSelected() {
    return this.layers.some((layer) => layer.selected);
  }

  colourSelected(color: string) {
    const selectedLayer = this.layers.find((layer) => layer.selected) as LayerWithSelection;
    const { selected, ...layer } = selectedLayer;
    this.colourPicked.next({layer, color})
  }

  async selectPattern(pattern: Pattern) {
    const selectedLayer = this.layers.find((layer) =>  layer.selected = true);
    if(selectedLayer) {
      const { selected, ...layer } = selectedLayer;
      this.LayerService.downloadTemplate(pattern.url)
        .pipe(
          tap((pattern) => this.patternPicked.next({ layer, pattern }) )
        )
        .subscribe()
    }
  }
}
