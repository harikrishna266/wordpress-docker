import { Component, inject, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DesignLayer, PatternLayer } from '../../types/three-d-builder-layer.type';
import { colors } from '../../colors';
import { Stage2D } from '@brocha-libs/builder-2d';
import { DynamicTexture } from '@brocha-libs/builder-3d';
import { tap } from 'rxjs';
import { Pattern } from '../../types/pattern.type';
import { WordpressService } from '../../../services/wordpress.service';
import { LayerAPIService } from '../../../services/layer.service';
import { LayerHelper } from '../../layer.helper';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-layer-pattern-setting',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './layer-pattern-setting.component.html',
  styleUrl: './layer-pattern-setting.component.css',
})
export class LayerPatternSettingComponent {
  tabSelected: 'color'| 'pattern' | 'pattern-color' | 'settings' = 'color';
  @Input() patternDetails!: PatternLayer;
  @Input() stage!: Stage2D;
  @Input() dynamicTexture!: DynamicTexture;
  @Input() designLayer!: DesignLayer;
  protected readonly colours = colors;
  private readonly wordpressService = inject(WordpressService);
  private readonly layerService = inject(LayerAPIService);
  public readonly layerHelper = inject(LayerHelper);


  patterns: Pattern[] = [];

  async setColor(color: string) {
    switch (this.tabSelected) {
      case 'color':
        await this.updateColor(color);
        break;
      case 'pattern-color':
        await this.updatePatternColor(color);
        break;
    }
  }

  async updateLayer() {
    await this.patternDetails.patternImage.setAttrs({...this.patternDetails.patternImage.serialize()})
     const image = await this.patternDetails.patternImage.shape.toImage({
      x: 0,
      y: 0,
      mimeType: 'image/png',
      width: 805,
      height: 805,
      quality: 1,
      pixelRatio: this.patternDetails.patternImage.pixelRation
    }) as any;
    await this.patternDetails.path.shape.fillPatternImage(image);
    await this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }

  ngOnInit() {
    this.wordpressService.getAllPatterns()
      .pipe(
        tap((patterns: Pattern[]) => this.patterns = patterns)
      )
      .subscribe()
  }

  async updateColor(color: string) {
    await this.patternDetails.basePath.setAttrs({ fill: color});
    await this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }

  async updatePatternColor(color: string) {
    this.patternDetails.patternImage.setAttrs({...this.patternDetails.patternImage.serialize(), fill: color})
    const image = await this.patternDetails.patternImage.shape.toImage({
      x: 0,
      y: 0,
      mimeType: 'image/png',
      width: 805,
      height: 805,
      quality: 1,
      pixelRatio: this.patternDetails.patternImage.pixelRation
    }) as any;
    await this.patternDetails.path.shape.fillPatternImage(image);
    await this.stage.layer.draw();
    this.dynamicTexture.update(false);
   }

  async setNewPattern(pattern: Pattern) {
    this.layerService.downloadTemplate(pattern.url)
      .pipe(
        tap(async (patternData) => {
          const patternLayer = this.layerHelper.getPatternForLayer(this.designLayer.layer.id);
          if(patternLayer) {
            await this.layerHelper.updatePattern(pattern, patternLayer, patternData, this.stage)
          }
          this.dynamicTexture.update(false);
        })
      ).subscribe()
  }
}
