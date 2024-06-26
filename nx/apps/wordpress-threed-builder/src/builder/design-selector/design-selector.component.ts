import {
  Component,
  inject,
  Input,
  OnInit,
  ViewEncapsulation
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  HttpClientModule,
} from '@angular/common/http';
import { DynamicTexture, SceneHelper } from '@brocha-libs/builder-3d';
import { Designs } from '../types/design.type';
import { WordpressService } from '../../services/wordpress.service';
import { forkJoin, from, map, switchMap, tap, toArray, finalize } from 'rxjs';
import { Stage2D } from '@brocha-libs/builder-2d';
import { Layer } from '../types/layer.type';
import { LayerAPIService } from '../../services/layer.service';
import { LayerHelper } from '../layer.helper';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
import { DesignLayer } from '../types/three-d-builder-layer.type';


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
  private readonly wordpressService = inject(WordpressService);
  private readonly layerService = inject(LayerAPIService);
  private readonly layerHelper = inject(LayerHelper);
  public designs:Designs[] = [];
  public design!: Designs;

  ngOnInit() {
    this.wordpressService.getDesigns()
      .pipe(
        tap((designs: Designs[]) => this.designs = designs)
      )
      .subscribe()
  }

  applyDesign(design: Designs) {
    this.design = design;
    from(design.layers)
      .pipe(
        map((layer: Layer) =>
          this.layerService.downloadTemplate(layer.url).pipe(
            map((pathData) => ({layer: layer, pathData}))
          )
        ),
        toArray(),
        switchMap((layerApi) =>forkJoin(layerApi)),
        switchMap((layersWithPathData) => {
          const previousColors = [...this.layerHelper.designLayers.map(({ path }) => path.fill)];
          this.layerHelper.removeAllLayer();
          const layerPromise = layersWithPathData
            .map( (layerWithPath, index) => {
            const colour = previousColors[index] ? previousColors[index] : design.layers[index].color;
            return this.createDesignLayer(layerWithPath, colour);
          });
          return from(Promise.all(layerPromise));
        }),
        tap((path: DesignLayer[]) => {
          this.layerHelper.addDesignLayer(path);
        }),
        finalize(() => {
          this.stage.layer.draw();
          this.dynamicTexture.update(false);
        })
      ).subscribe();
  }

  async createDesignLayer(layerWithPath: { layer: Layer; pathData: string } , fill: string): Promise<DesignLayer> {
    const path = await  this.stage.createShape('path') as Path;
    await path.setAttrs({
      id: layerWithPath.layer.id,
      fill,
      data: layerWithPath.pathData,
      scaleX: 1,
      scaleY: 1,
    });
    await this.stage.addShape(this.stage.layer, path);
    return { layer: layerWithPath.layer, path: path, type: 'layer'};
  }
}
