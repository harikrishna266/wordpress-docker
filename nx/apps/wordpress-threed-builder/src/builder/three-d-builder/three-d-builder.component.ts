import {
  AfterViewInit,
  Component,
  ElementRef, inject, Input,
  ViewChild
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  createDynamicTexture,
  loadModel,
  SceneHelper,
  DynamicTexture,
  PBRMaterial, Mesh, Texture
} from '@brocha-libs/builder-3d';
import { Stage2D } from '@brocha-libs/builder-2d';
import { DesignSelectorComponent } from '../design-selector/design-selector.component';
import { LayerColorPickerComponent } from '../layer-color-picker/layer-color-picker.component';
import { LayerPatternsComponent } from '../layer-patterns/layer-patterns.component';
import { Designs } from '../types/design.type';
import { LayerHelper } from '../layer.helper';
import { environment } from '../../environments/environment';
import { Model } from '../types/model.type';
import { DesignRenderHelper } from '../design-render.helper';
type MenuActions =  'designs' | 'layers' | 'patterns' | 'none';
import { Inspector } from '@babylonjs/inspector';

@Component({
  selector: 'app-three-d-builder',
  standalone: true,
  imports: [CommonModule, DesignSelectorComponent, LayerColorPickerComponent, LayerPatternsComponent],
  templateUrl: './three-d-builder.component.html',
  styleUrl: './three-d-builder.component.css',
})
export class ThreeDBuilderComponent implements AfterViewInit {
  public sceneHelper: SceneHelper = new SceneHelper();
  public stage!: Stage2D;
  public dynamicTexture!: DynamicTexture;
  public currentAction!: MenuActions ;
  public menuActions: MenuActions[] = ['designs','layers', 'patterns' ];
  public readonly layerHelper = inject(LayerHelper);
  public readonly designRenderHelper = inject(DesignRenderHelper);

  @Input() design!: Designs;

  _model!:Model;
  @Input()
  set model(model: Model) {
    this._model = model;
    setTimeout(() => {
      this.loadModel();
      this.designRenderHelper.applyDesign(this.design);
    }, 500)

  }
  get model() {
    return this._model;
  }

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
    this.designRenderHelper.stage = this.stage;
    this.stage.initializeStage(this.konvaContainer.nativeElement, 2048, 2048);
    this.stage.isEditor = false;
    await this.threeDBuilder();
  }

  async threeDBuilder() {
    await this.sceneHelper.createScene(this.threeDCanvas.nativeElement);
    this.designRenderHelper.sceneHelper = this.sceneHelper;
    this.sceneHelper.addExternalEnvironment(`${environment.ASSET_URL}assets/environmentSpecular.env`);
    this.sceneHelper.loadCamera();

  }

  async loadModel() {
    const model = new URL(this.model.url).pathname.split('/')[1];
    await loadModel(this.sceneHelper.scene, 'model', '', `${environment.ASSET_URL}glb/`, model);
    (this.sceneHelper.scene.getMeshByName('bounding-box') as Mesh).isPickable = true;
    await this.renderDynamicTexture();
  }



  async renderDynamicTexture() {
    this.dynamicTexture = await createDynamicTexture('main-texture',
      this.stage.layer.getCanvas()._canvas,
      this.sceneHelper.scene
    );
    this.designRenderHelper.dynamicTexture = this.dynamicTexture;
    this.sceneHelper.scene.meshes.forEach((mesh) => {
      if (mesh.material) {
        const material = mesh.material as PBRMaterial;
        material.albedoTexture = this.dynamicTexture;
      }
    });
    // ['Cloth.003_primitive1'].map((e) => {
    //   (this.sceneHelper.scene.getMeshByName(e) as Mesh).visibility = 1;
    //   (this.sceneHelper.scene.getMeshByName(e) as Mesh).material = material;
    //   ((this.sceneHelper.scene.getMeshByName(e) as Mesh).material as PBRMaterial).albedoTexture = this.dynamicTexture;
    // })
  }

  async addRect() {
    // const rectangle = this.stage.createShape('rect');
    // await rectangle.setAttrs({
    //   width: 550,
    //   height: 900,
    //   x: 1255,
    //   y: 380,
    //   fill: 'green',
    //   strokeWidth: 8,
    //   stroke: 'yellow'
    // });
    // rectangle.shape.zIndex(5);
    // await this.stage.addShape( this.stage.layer, rectangle);
    const text = this.stage.createShape('text') ;
    text.setAttrs({
      text: 'BROCHA',
      fontStyle: ['bold'],
      fontSize: 140,
      fill: 'white',
      x: 1255,
      y: 380,
    })
    await this.stage.addShape(this.stage.layer, text);

    const sports = this.stage.createShape('text') ;
    sports.setAttrs({
      text: 'Sports',
      fontStyle: ['bold', 'italic'],
      fontSize: 90,
      fill: 'white',
      x: 1370,
      y: 500,
    })
    await this.stage.addShape(this.stage.layer, sports);



    const textf = this.stage.createShape('text') ;
    textf.setAttrs({
      text: 'BROCHA',
      fontStyle: ['bold'],
      fontSize: 140,
      fill: 'white',
      x: 255,
      y: 380,
    })
    await this.stage.addShape(this.stage.layer, textf);

    const sportsf = this.stage.createShape('text') ;
    sportsf.setAttrs({
      text: 'Sports',
      fontStyle: ['bold', 'italic'],
      fontSize: 90,
      fill: 'white',
      x: 370,
      y: 500,
    })
    await this.stage.addShape(this.stage.layer, sportsf);

    await this.stage.layer.draw();
    this.dynamicTexture.update(false);
  }
}
