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
  PBRMaterial
} from '@brocha-libs/builder-3d';
import { HttpClientModule } from '@angular/common/http';
import { Stage2D } from '@brocha-libs/builder-2d';
import { environment } from '../environments/environment';
import { DesignSelectorComponent } from './design-selector/design-selector.component';
import { LayerColorPickerComponent } from './layer-color-picker/layer-color-picker.component';
import { LayerPatternsComponent } from './layer-patterns/layer-patterns.component';
import { Designs } from './types/design.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';
import { LayerHelper } from './layer.helper';
import { FileActionsComponent } from './file-actions/file-actions.component';
type MenuActions =  'designs' | 'layers' | 'patterns' | 'none';

@Component({
  selector: 'app-builder',
  standalone: true,
  imports: [
    CommonModule,
    HttpClientModule,
    DesignSelectorComponent,
    LayerColorPickerComponent,
    LayerPatternsComponent,
    FileActionsComponent
  ],
  templateUrl: './builder.component.html',
  styleUrl: './builder.component.scss',
  encapsulation: ViewEncapsulation.None,
  providers: [
    LayerHelper
  ]
})

export class BuilderComponent implements AfterViewInit{
  public sceneHelper: SceneHelper = new SceneHelper();
  public stage!: Stage2D;
  public dynamicTexture!: DynamicTexture;
  public currentAction!: MenuActions ;
  public menuActions: MenuActions[] = ['designs','layers', 'patterns' ];
  public design!: Designs;
  public readonly layerHelper = inject(LayerHelper);


  @ViewChild('threeDCanvas', { static: true }) threeDCanvas!: ElementRef;
  @ViewChild('konvaContainer', { static: true }) konvaContainer!: ElementRef;

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
    this.stage.isEditor = false;
    await this.threeDBuilder();
  }

  async threeDBuilder() {
    await this.sceneHelper.createScene(this.threeDCanvas.nativeElement);
    this.sceneHelper.addExternalEnvironment(`${environment.ASSET_URL}assets/environmentSpecular.env`);
    this.sceneHelper.loadCamera();
    await this.loadModel();
  }

  async loadModel() {
    await loadModel(this.sceneHelper.scene, 'model', '', `${environment.ASSET_URL}glb/`, 'flip-model-3.glb');
    (this.sceneHelper.scene.getMeshByName('bounding-box') as Mesh).isPickable = false;
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture = new Texture(`${environment.ASSET_URL}assets/Cotton_Heavy_Canvas_NRM.jpg`, this.sceneHelper.scene);
    (((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture as Texture).level = 2;
    (((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture as Texture).uScale = 5;
    (((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).bumpTexture as Texture).vScale = 5;
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).metallic = 0.2;
    ((this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).material as PBRMaterial).roughness = .2;
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
  }

}
