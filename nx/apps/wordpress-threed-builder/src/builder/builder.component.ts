import {
  AfterViewInit,
  Component,
  ElementRef,
  ViewChild, ViewEncapsulation
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  createDynamicTexture,
  loadModel,
  SceneHelper,
  ArcRotateCamera,
  DynamicTexture,
  Mesh,
  PBRMaterial,
  Texture
} from '@brocha-libs/builder-3d';
import { HttpClient, HttpClientModule, HttpHeaders } from '@angular/common/http';
import { WordpressService } from '../services/wordpress.service';
import { BoundaryService, ShapeInstance, Stage2D } from '@brocha-libs/builder-2d';
import { environment } from '../environments/environment';
import { DesignsSideBarComponent } from './designs-side-bar/designs-side-bar.component';
import { LayerOptionsComponent } from './layer-options/layer-options.component';
import { LayerPatternsComponent } from './layer-patterns/layer-patterns.component';
import { Designs, LayerNames } from './types/design.type';
import { filter, forkJoin, from, map, switchMap, toArray} from 'rxjs';

@Component({
  selector: 'app-builder',
  standalone: true,
  imports: [CommonModule, HttpClientModule, DesignsSideBarComponent, LayerOptionsComponent, LayerPatternsComponent],
  templateUrl: './builder.component.html',
  styleUrl: './builder.component.scss',
  providers: [WordpressService],
  encapsulation: ViewEncapsulation.None
})
export class BuilderComponent implements AfterViewInit{
  stage!: Stage2D;
  readonly sceneHelper: SceneHelper = new SceneHelper();
  boundaryService!: BoundaryService;
  dynamicTexture!: DynamicTexture;
  currentAction: 'designs' | 'layers' | 'patterns' | undefined  = undefined ;
  selectedLayerName = 'layer_1';
  layer_1!: ShapeInstance;
  layer_2!: ShapeInstance;
  layer_3!: ShapeInstance;
  layer_4!: ShapeInstance;
  selectedLayer = this.layer_1;
  selectedDesign!: Designs;

  @ViewChild('threedCanvas', { static: true }) threedCanvas!: ElementRef;
  @ViewChild('konvaContainer', { static: true }) konvaContainer!: ElementRef;

  constructor(private http: HttpClient) {}

  selectLayer(layer: LayerNames): void {
    const layerMapping = {
      layer_1: this.layer_1,
      layer_2: this.layer_2,
      layer_3: this.layer_3,
      layer_4: this.layer_4
    };
    this.selectedLayerName = layer;
    this.selectedLayer = layerMapping[layer] as ShapeInstance;
  }

  setCurrentAction(action: 'designs' | 'layers' | 'patterns' | undefined) {
    if(this.currentAction === action) {
      this.currentAction = undefined;
      return;
    }
    this.currentAction = action;
  }


  async ngAfterViewInit() {
    this.stage = new Stage2D();
    this.stage.initializeStage(this.konvaContainer.nativeElement, 2048, 2048);
    this.stage.isEditor = true;
    this.boundaryService = new BoundaryService(this.stage);
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
    (this.sceneHelper.scene.activeCamera as ArcRotateCamera).setTarget((this.sceneHelper.scene.getMeshByName('bounding-box') as Mesh));
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture = new Texture(`${environment.ASSET_URL}assets/Cotton_Heavy_Canvas_NRM.jpg`, this.sceneHelper.scene);
    (((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture as Texture).level = 2;
    (((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture as Texture).uScale = 5;
    (((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture as Texture).vScale = 5;
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).metallic = 0.2;
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).roughness = .7;
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).indexOfRefraction = 1.9;
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
    this.changeColor();
  }

  async setColor(color: string) {
    await this.selectedLayer.setAttrs({
      fill: color
    });
    this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }

  async changeColor() {
    const headers = new HttpHeaders({
      'Accept': 'text/plain'
    });
    from([this.selectedDesign?.design_layer_1, this.selectedDesign?.design_layer_2, this.selectedDesign?.design_layer_3, this.selectedDesign?.design_layer_4])
      .pipe(
        filter((url): url is string => !!url),
        map((url: string) => this.http.get(url, { headers, responseType: 'text' })),
        toArray(),
        switchMap((e) =>forkJoin(e)),
      ).subscribe(async ([layer_1, layer_2, layer_3, layer_4]) => {
        this.layer_1 = await this.createLayer(layer_1, 'red');
        this.layer_2 = await this.createLayer(layer_2, 'yellow');
        this.layer_3 = await this.createLayer(layer_3, 'green');
        this.layer_4 = await this.createLayer(layer_4, 'brown');
        this.dynamicTexture.update(false);
    });
  }

  applyColor(color: {layer: LayerNames, color: string}) {
    this.selectLayer(color.layer);
    this.setColor(color.color);
  }

  async createLayer(path: string, fill: string) {
    const layer =   this.stage.createShape('path');
    layer.setAttrs({
      x: 0,
      y: 0,
      fill,
      data: path,
      fillPatternScaleX: 1,
      fillPatternScaleY: 1,
      fillPatternRepeat: 'repeat',
      scaleX: 1,
      scaleY: 1
    });
    await this.stage.addShape(this.stage.layer, layer);
    return layer;
  }

  applyDesign(design: Designs) {
    this.selectedDesign = design;
    this.changeColor();
  }
}
