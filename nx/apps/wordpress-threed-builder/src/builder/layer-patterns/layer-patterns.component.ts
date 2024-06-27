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
    this.selectedPattern = this.layerHelper.getPatternForLayer(this.designLayer.layer.id);
  }

  ngOnInit() {
    this.wordpressService.getAllPatterns()
      .pipe(
        tap((patterns: Pattern[]) => this.patterns = patterns)
      )
      .subscribe()
  }

  async setNewPattern(pattern: Pattern) {
    this.layerService.downloadTemplate(pattern.url)
      .pipe(
        tap(async (patternData) => {
          const patternLayer = this.layerHelper.getPatternForLayer(this.designLayer.layer.id);
           if(!patternLayer) {
            await this.layerHelper.createPattern(patternData, pattern, this.designLayer, this.stage);
          } else {
            await this.layerHelper.updatePattern(pattern, patternLayer, patternData, this.stage)
          }
           this.dynamicTexture.update(false);
          this.selectedPattern = this.layerHelper.getPatternForLayer(this.designLayer.layer.id);
        })
      ).subscribe()
  }



}
