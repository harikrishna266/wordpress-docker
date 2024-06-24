import { Component, inject, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PatternLayer } from '../../types/three-d-builder-layer.type';
import { colors } from '../../colors';
import { Stage2D } from '@brocha-libs/builder-2d';
import { DynamicTexture } from '@brocha-libs/builder-3d';
import { tap } from 'rxjs';
import { Pattern } from '../../types/pattern.type';
import { WordpressService } from '../../../services/wordpress.service';

@Component({
  selector: 'app-layer-pattern-setting',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layer-pattern-setting.component.html',
  styleUrl: './layer-pattern-setting.component.css',
})
export class LayerPatternSettingComponent {
  tabSelected: 'color'| 'pattern' | 'pattern-color' = 'color';
  @Input() patternDetails!: PatternLayer;
  @Input() stage!: Stage2D;
  @Input() dynamicTexture!: DynamicTexture;
  protected readonly colours = colors;
  private readonly wordpressService = inject(WordpressService);

  patterns: Pattern[] = [];

  async setColor(color: string) {
    switch (this.tabSelected) {
      case 'color':
        await this.updatePatternColor(color);
        break;
      case 'pattern':
        await this.updateColor(color);
        break;
    }
  }

  ngOnInit() {
    this.wordpressService.getAllPatterns()
      .pipe(
        tap((patterns: Pattern[]) => this.patterns = patterns)
      )
      .subscribe()
  }

  async updateColor(color: string) {
    await this.patternDetails.path.setAttrs({...this.patternDetails.path.serialize(), fill: color});
    await this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }

  async updatePatternColor(color: string) {
    this.patternDetails.pattern.setAttrs({fill: color})
    const image = await this.patternDetails.pattern.shape.toImage({
      x: 0,
      y: 0,
      mimeType: 'image/png',
      width: 805,
      height: 805,
      quality: 1,
      pixelRatio: 1
    }) as any;
    await this.patternDetails.path.shape.fillPatternImage(image);
    await this.stage.layer.draw();
    this.dynamicTexture.update(false);
   }
}