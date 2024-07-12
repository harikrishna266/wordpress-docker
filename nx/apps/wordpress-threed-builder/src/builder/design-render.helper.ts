import { Designs } from './types/design.type';
import { finalize, forkJoin, from, map, switchMap, tap, toArray } from 'rxjs';
import { Layer } from './types/layer.type';
import { DesignLayer } from './types/three-d-builder-layer.type';
import { LayerHelper } from './layer.helper';
import { inject } from '@angular/core';
import { LayerAPIService } from '../services/layer.service';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
import { Stage2D } from '@brocha-libs/builder-2d';
import { DynamicTexture, SceneHelper } from '@brocha-libs/builder-3d';


export class DesignRenderHelper {
  design!: Designs;
  designAPI: any;
  public stage!: Stage2D;
  public dynamicTexture!: DynamicTexture;
  public sceneHelper!: SceneHelper
  private readonly layerService = inject(LayerAPIService);
  private readonly layerHelper = inject(LayerHelper);

  constructor() {
  }


  applyDesign(design: Designs) {
    this.design = design;
    if (this.designAPI) {
      this.designAPI.unsubscribe();
      this.layerHelper.removeAllLayer();
    }
    this.designAPI = from(design.layers)
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
            .map( async (layerWithPath, index) => {
              const colour = previousColors[index] ? previousColors[index] : design.layers[index].color;
              return await this.createDesignLayer(layerWithPath, colour);
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
