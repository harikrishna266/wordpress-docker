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
import { Designs, LayerNames } from './types/design.type';
import { forkJoin, from, map, switchMap, tap, toArray } from 'rxjs';
import { LayerService } from '../services/layer.service';
import { Layer } from './types/layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
type MenuActions =  'designs' | 'layers' | 'patterns' | 'none';
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
  public layers: Path[] = [];

  private readonly LayerService = inject(LayerService);

  @ViewChild('threeDCanvas', { static: true }) threedCanvas!: ElementRef;
  @ViewChild('konvaContainer', { static: true }) konvaContainer!: ElementRef;


  selectLayer(layer: LayerNames): void {}

  setCurrentAction(action: MenuActions) {
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
    await this.sceneHelper.createScene(this.threedCanvas.nativeElement);
    this.sceneHelper.addDefaultEnvironment();
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

  async setColor(color: string) {
    // await this.selectedLayer.setAttrs({
    //   fill: color
    // });
    // this.stage.layer.draw();
    // this.dynamicTexture.update(false);
  }


  applyColor(color: any) {
    this.selectLayer(color.layer);
    this.setColor(color.color);
  }

  async createLayer(path: string, fill: string) {
    const layer =   this.stage.createShape('path') as Path;
    layer.setAttrs({
      fill,
      data: path,
      scaleX: 1,
      scaleY: 1,
    });
    await this.stage.addShape(this.stage.layer, layer);
    return layer;
  }

  applyDesign(design: Designs) {
    if(this.design?.id === design.id) {
      return;
    }
    this.design = design;
    from(design.layers)
      .pipe(
        map((layer: Layer) => this.LayerService.downloadTemplate(layer.url)),
        toArray(),
        switchMap((layerApi) =>forkJoin(layerApi)),
        tap((layers) => {
          this.layers = [];
          layers.forEach(async (layer, index) => {
            const layerInstance = await this.createLayer(layer, design.layers[index].color);
            this.layers.push(layerInstance);
          });
          this.stage.layer.draw();
          this.dynamicTexture.update(false);
        })
      ).subscribe();
  }
}

const materialConfig  = {
  metallic: 0.2,
  roughness: .7,
  indexOfRefraction: 1.9,
  bumpTexture: {
    url: `${environment.ASSET_URL}assets/Cotton_Heavy_Canvas_NRM.jpg`,
    level: 2,
    uScale: 5,
    vScale: 5,
  }
}
