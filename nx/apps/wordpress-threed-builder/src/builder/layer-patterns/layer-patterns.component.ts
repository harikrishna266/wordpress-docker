import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Layer } from '../types/layer.type';
import { WordpressService } from '../../services/wordpress.service';
import { Pattern } from '../types/pattern.type';
import { LayerHelper } from '../layer.helper';

@Component({
  selector: 'app-layer-patterns',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layer-patterns.component.html',
  styleUrl: './layer-patterns.component.css',
})
export class LayerPatternsComponent implements OnInit {

  public readonly layerHelper = inject(LayerHelper);
  private readonly wordpressService = inject(WordpressService);
  patterns: Pattern[] = [];

  selectedlayer!: Layer;
  // selectedLayer!: Layer;
  // @Input() sceneHelper!: SceneHelper;
  // @Input() stage!: Stage2D;
  // @Output() patternPicked: EventEmitter<{layer: Layer, pattern: string}> = new EventEmitter();
  // @Output() colourPicked: EventEmitter<{layer: Layer, color: string}> = new EventEmitter();
  //
  //
  // private readonly LayerService = inject(LayerAPIService);
  //
  // goodColors: string[] = colors;
  //
  // private _layers!: Array<LayerWithSelection>;
  // @Input()
  // public get layers(): Array<LayerWithSelection> {
  //   return this._layers;
  // }
  // public set layers(layers: Layer[]) {
  //   this._layers = layers.filter((layer: Layer) => layer.allowPattern).map((layer) => ({...layer, selected: false}));
  // }
  //
  // public patterns: Pattern[] = [];
  //
  // selectLayer(layer: LayerWithSelection) {
  //   this.layers.map((layer) =>  layer.selected = false);
  //   layer.selected = true;
  //   this.selectedLayer = layer;
  //   this.createPattern()
  // }
  //
  ngOnInit() {
    // this.wordpressService.getAllPatterns()
    //   .pipe(
    //     tap((patterns: Pattern[]) => this.patterns = patterns)
    //   )
    //   .subscribe()
  }
  //
  // get isLayerSelected() {
  //   return this.layers.some((layer) => layer.selected);
  // }
  //
  // colourSelected(color: string) {
  //   const selectedLayer = this.layers.find((layer) => layer.selected) as LayerWithSelection;
  //   const { selected, ...layer } = selectedLayer;
  //   this.colourPicked.next({layer, color})
  // }
  //
  // async selectPattern(pattern: Pattern) {
  //   const selectedLayer = this.layers.find((layer) =>  layer.selected = true);
  //   if(selectedLayer) {
  //     const { selected, ...layer } = selectedLayer;
  //     this.LayerService.downloadTemplate(pattern.url)
  //       .pipe(
  //         tap((pattern) => this.patternPicked.next({ layer, pattern }) )
  //       )
  //       .subscribe()
  //   }
  // }
  //
  // async createPattern() {
  //   const selectedLayer = this.layers.find((layer) => layer.selected) as LayerWithSelection;
  //    // const selectedLayer = this.designLayers.find(({path}) => pattern.layer.id === path.id);
  //   // const path = selectedLayer?.path;
  //   // if(path && selectedLayer) {
  //   //   const patternPath = this.stage.createShape('path') as Path;
  //   //   await patternPath.setAttrs({
  //   //     id: 'patternPath',
  //   //     scaleX: 1,
  //   //     scaleY: 1,
  //   //     data: pattern.pattern
  //   //   });
  //   //   const basePath = this.stage.createShape('path') as Path;
  //   //   await basePath.setAttrs({
  //   //     id: 'basePath',
  //   //     x: 0,
  //   //     y: 0,
  //   //     data: selectedLayer.path.data,
  //   //     fill: '',
  //   //     fillPatternScaleX: .51,
  //   //     fillPatternScaleY: .51,
  //   //     fillPatternRepeat: 'repeat',
  //   //     scaleX: 1,
  //   //     scaleY: 1
  //   //   });
  //   //   await this.stage.addShape(this.stage.layer, basePath);
  //   //   this.designLayers.push({path: basePath, pattern: patternPath, type: 'pattern',});
  //   //   this.stage.layer.draw();
  //   //   this.dynamicTexture.update(false);
  //   // }
  // }
}
