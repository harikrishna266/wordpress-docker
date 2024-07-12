import {
  Component,
  inject,
  Input,
  OnInit,
  ViewEncapsulation
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  HttpClientModule
} from '@angular/common/http';
import { DynamicTexture, SceneHelper } from '@brocha-libs/builder-3d';
import { Designs } from '../types/design.type';
import { WordpressService } from '../../services/wordpress.service';
import { forkJoin, from, map, switchMap, tap, toArray, finalize, Observable } from 'rxjs';
import { Stage2D } from '@brocha-libs/builder-2d';
import { Layer } from '../types/layer.type';
import { LayerAPIService } from '../../services/layer.service';
import { LayerHelper } from '../layer.helper';
import { DesignLayer } from '../types/three-d-builder-layer.type';
import { DesignRenderHelper } from '../design-render.helper';


@Component({
  selector: 'app-design-selector',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  styleUrl: './design-selector.component.scss',
  templateUrl: './design-selector.component.html',
  encapsulation: ViewEncapsulation.None,
})
export class DesignSelectorComponent implements OnInit{
  @Input() sceneHelper!: SceneHelper;
  @Input() dynamicTexture!: DynamicTexture;
  @Input() stage!: Stage2D;
  @Input() modelId!: string;
  private readonly wordpressService = inject(WordpressService);
  private readonly layerService = inject(LayerAPIService);
  private readonly layerHelper = inject(LayerHelper);
  public readonly designRenderHelper = inject(DesignRenderHelper);

  public designs:Designs[] = [];
  public design!: Designs;

  ngOnInit() {
    this.wordpressService.getDesignsForModel(this.modelId)
      .pipe(
        tap((designs: Designs[]) => this.designs = designs)
      )
      .subscribe()
  }

  applyDesign(design: Designs) {
    this.designRenderHelper.applyDesign(design)
  }


}
