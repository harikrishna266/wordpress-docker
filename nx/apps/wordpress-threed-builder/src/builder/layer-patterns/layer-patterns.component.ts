import { Component, inject, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WordpressService } from '../../services/wordpress.service';
import { LayerHelper } from '../layer.helper';
import { DesignLayer, LayerTypes, PatternLayer } from '../types/three-d-builder-layer.type';
import { tap } from 'rxjs';
import { Pattern } from '../types/pattern.type';
import { LayerPatternSettingComponent } from './layer-pattern-setting/layer-pattern-setting.component';
import { Stage2D } from '@brocha-libs/builder-2d';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
import { DynamicTexture } from '@brocha-libs/builder-3d';
import { LayerAPIService } from '../../services/layer.service';
import { DesignLayerFilterPipe } from '../pipes/design-layer-filter.pipe';
import { PipesModule } from '../pipes/pipes.module';

@Component({
  selector: 'app-layer-patterns',
  standalone: true,
  imports: [CommonModule, LayerPatternSettingComponent, PipesModule],
  providers: [
    DesignLayerFilterPipe
  ],
  templateUrl: './layer-patterns.component.html',
  styleUrl: './layer-patterns.component.css',
})
export class LayerPatternsComponent implements OnInit {
  public readonly layerHelper = inject(LayerHelper);
  private readonly wordpressService = inject(WordpressService);
  private readonly layerService = inject(LayerAPIService);
  patterns: Pattern[] = [];
  designLayer!: DesignLayer;
  selectedPattern: false | PatternLayer = false;
  @Input() stage!: Stage2D;
  @Input() dynamicTexture!: DynamicTexture;
  selectLayer(layer: LayerTypes) {
    if(layer.type === 'layer') {
      this.designLayer = layer;
    }
    this.selectedPattern = this.layerHelper.getPatternForLayer(layer.layer.id);
  }

  ngOnInit() {
    this.wordpressService.getAllPatterns()
      .pipe(
        tap((patterns: Pattern[]) => this.patterns = patterns)
      )
      .subscribe()
  }

  async createPattern(pattern: Pattern) {
    this.layerService.downloadTemplate(pattern.url)
      .pipe(
        tap(async (patternSection) => {
          const pattern = this.stage.createShape('path') as Path;
          pattern.setAttrs({
            id: pattern.id,
            scaleX: 1,
            scaleY: 1,
            data: patternSection,
          });
          const image = await pattern.shape.toImage({
            x: 0,
            y: 0,
            mimeType: 'image/png',
            width: 805,
            height: 805,
            quality: 1,
            pixelRatio: 1
          }) as any;
          const path =   this.stage.createShape('path') as Path;
          path.setAttrs({
            id: this.designLayer.layer.id,
            fill: '',
            data: this.designLayer.path.data,
            scaleX: 1,
            scaleY: 1,
            fillPatternImage: image,
          });
          await this.stage.addShape(this.stage.layer, path);
          const patternLayer: PatternLayer = {layer: this.designLayer.layer, path, basePath: this.designLayer.path, patternImage: pattern, type: 'pattern', };
          this.layerHelper.addPattern(patternLayer);
          this.stage.layer.draw();
          this.dynamicTexture.update(false);
        })
      ).subscribe()
  }
}
