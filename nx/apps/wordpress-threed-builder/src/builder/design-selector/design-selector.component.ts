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
import { forkJoin, from, map, switchMap, tap, toArray } from 'rxjs';
import { Stage2D } from '@brocha-libs/builder-2d';
import { Layer } from '../types/layer.type';
import { LayerAPIService } from '../../services/layer.service';
import { LayerHelper } from '../layer.helper';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';


@Component({
  selector: 'app-design-selector',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  styleUrl: './design-selector.component.scss',
  templateUrl: './design-selector.component.html',
  encapsulation: ViewEncapsulation.None,
  providers: []
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
            map((path) => ({layer: layer, path}))
          )
        ),
        toArray(),
        switchMap((layerApi) =>forkJoin(layerApi)),
        tap((layersWithPath) => {
          const previousColors = [...this.layerHelper.designLayers.map(({ path }) => path.fill)]
          this.layerHelper.designLayers = [];
          layersWithPath.forEach(async (layerWithPath, index) => {
            let colour = design.layers[index].color;
            if(previousColors[index]) {
              colour = previousColors[index];
            }
            const layerInstance = await this.createLayer(layerWithPath, colour);
            this.layerHelper.designLayers.push({ path: layerInstance, type: 'layer', layer: layerWithPath.layer });
          });
          this.stage.layer.draw();
          this.dynamicTexture.update(false);
        })
      ).subscribe();
  }

  async createLayer(layerWithPath: {layer: Layer, path: string}, fill: string) {
    const layerObj =   this.stage.createShape('path') as Path;
    layerObj.setAttrs({
      id: layerWithPath.layer.id,
      fill,
      data: layerWithPath.path,
      scaleX: 1,
      scaleY: 1,
    });
    await this.stage.addShape(this.stage.layer, layerObj);
    return layerObj;
  }
}
