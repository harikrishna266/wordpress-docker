import {
  AfterViewInit,
  Component,
  ElementRef, inject,
  ViewChild, ViewEncapsulation
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  createDynamicTexture,
  loadModel,
  SceneHelper,
  DynamicTexture,
  PBRMaterial,
} from '@brocha-libs/builder-3d';
import { HttpClientModule } from '@angular/common/http';
import { Stage2D } from '@brocha-libs/builder-2d';
import { environment } from '../environments/environment';
import { DesignSelectorComponent } from './design-selector/design-selector.component';
import { LayerColorPickerComponent } from './layer-color-picker/layer-color-picker.component';
import { LayerPatternsComponent } from './layer-patterns/layer-patterns.component';
import { Designs } from './types/design.type';
import { forkJoin, from, map, switchMap, tap, toArray } from 'rxjs';
import { LayerService } from '../services/layer.service';
import { Layer } from './types/layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
type MenuActions =  'designs' | 'layers' | 'patterns' | 'none';
type ModelLayer = { path: Path, type: 'layer'} | {path: Path, pattern: Path, type: 'pattern'} ;
@Component({
  selector: 'app-builder',
  standalone: true,
  imports: [
    CommonModule,
    HttpClientModule,
    DesignSelectorComponent,
    LayerColorPickerComponent,
    LayerPatternsComponent
  ],
  templateUrl: './builder.component.html',
  styleUrl: './builder.component.scss',
  encapsulation: ViewEncapsulation.None,
})

export class BuilderComponent implements AfterViewInit{
  private readonly sceneHelper: SceneHelper = new SceneHelper();
  private stage!: Stage2D;
  private dynamicTexture!: DynamicTexture;
  public currentAction!: MenuActions ;
  public design!: Designs;
  public modelLayers: ModelLayer[] = [];
  private readonly LayerService = inject(LayerService);

  @ViewChild('threeDCanvas', { static: true }) threeDCanvas!: ElementRef;
  @ViewChild('konvaContainer', { static: true }) konvaContainer!: ElementRef;

  setCurrentAction(action: any) {
    if(this.currentAction === action) {
      this.currentAction = 'none';
      return;
    }
    this.currentAction = action;
  }


  async ngAfterViewInit() {
    this.stage = new Stage2D();
    this.stage.initializeStage(this.konvaContainer.nativeElement, 2048, 2048);
    this.stage.isEditor = true;
    await this.threeDBuilder();
  }

  async threeDBuilder() {
    await this.sceneHelper.createScene(this.threeDCanvas.nativeElement);
    this.sceneHelper.addExternalEnvironment(`${environment.ASSET_URL}assets/environmentSpecular.env`);
    this.sceneHelper.loadCamera();
    await this.loadModel();
  }

  async loadModel() {
    await loadModel(this.sceneHelper.scene, 'model', '', `${environment.ASSET_URL}glb/`, 'model-3.glb');
    await this.renderDynamicTexture();
  }

  async renderDynamicTexture() {
    this.dynamicTexture = await createDynamicTexture('main-texture',
      this.stage.layer.getCanvas()._canvas,
      this.sceneHelper.scene
    );
    this.sceneHelper.scene.meshes.forEach((mesh) => {
      if (mesh.material) {
        const material = mesh.material as PBRMaterial;
        material.albedoTexture = this.dynamicTexture;
      }
    });
  }

  async setColor(selectedLayer: Path, color: string) {
    await selectedLayer.setAttrs({
      fill: color
    });
    this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }


  applyColor({layer, color}: {layer: Layer, color: string}) {
    const selectedLayer = this.modelLayers.find(({path}) => layer.id === path.id);
    if(selectedLayer) {
      this.setColor(selectedLayer.path, color);
    }
  }

  async createLayer(layer: {id: string, path: string}, fill: string) {
    const layerObj =   this.stage.createShape('path') as Path;
    layerObj.setAttrs({
      id: layer.id,
      fill,
      data: layer.path,
      scaleX: 1,
      scaleY: 1,
    });
    await this.stage.addShape(this.stage.layer, layerObj);
    return layerObj;
  }

  async applyPattern(pattern: {layer: Layer, pattern: string}) {
    const selectedLayer = this.modelLayers.find(({path}) => pattern.layer.id === path.id);
    const path = selectedLayer?.path;
    if(path && selectedLayer) {
      const patternShape = this.stage.createShape('path');
      await patternShape.setAttrs({
        fill: 'red',
        scaleX: 1,
        scaleY: 1,
        data: pattern.pattern
      });
      const image = await patternShape.shape.toImage({
        x: 0,
        y: 0,
        mimeType: 'image/png',
        width: 805,
        height: 805,
        quality: 1,
        pixelRatio: 1
      }) as any;
      const basePath = this.stage.createShape('path') as Path;
      await basePath.setAttrs({
        x: 0,
        y: 0,
        data: selectedLayer.path.data,
        fill: '',
        fillPatternImage: image,
        fillPatternScaleX: .51,
        fillPatternScaleY: .51,
        fillPatternRepeat: 'repeat',
        scaleX: 1,
        scaleY: 1
      });
      await this.stage.addShape(this.stage.layer, basePath);
      this.stage.layer.draw();
      this.dynamicTexture.update(false);
    }
  }

  applyDesign(design: Designs) {
    if(this.design?.id === design.id) {
      return;
    }
    this.design = design;
    from(design.layers)
      .pipe(
        map((layer: Layer) =>
          this.LayerService.downloadTemplate(layer.url).pipe(
            map((path) => ({id: layer.id, path}))
          )
        ),
        toArray(),
        switchMap((layerApi) =>forkJoin(layerApi)),
        tap((layers) => {
          const previousColors = [...this.modelLayers.map(({ path }) => path.fill)]
          this.modelLayers = [];
          layers.forEach(async (layer, index) => {
            let colour = design.layers[index].color;
            if(previousColors[index]) {
              colour = previousColors[index];
            }
            const layerInstance = await this.createLayer(layer, colour);
            this.modelLayers.push({ path: layerInstance, type: 'layer' });
          });
          this.stage.layer.draw();
          this.dynamicTexture.update(false);
        })
      ).subscribe();
  }
}
