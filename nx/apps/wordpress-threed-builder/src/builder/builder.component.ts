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
  PBRMaterial, Mesh, Texture
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
import {
  Color3,
  CreateDecal, Matrix, MeshBuilder,
  PBRMetallicRoughnessMaterial, PickingInfo,
  PointerEventTypes,
  StandardMaterial,
  Vector3
} from '@babylonjs/core';
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
    this.stage.isEditor = true;
    await this.threeDBuilder();
  }

  async threeDBuilder() {
    await this.sceneHelper.createScene(this.threeDCanvas.nativeElement);
    this.sceneHelper.scene.useRightHandedSystem = false;
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
    this.createDecal();
  }


  createDecalMesh(position: Vector3, normal: Vector3, ) {
    const decalMaterial = new PBRMaterial('decal', this.sceneHelper.scene);
    decalMaterial.albedoColor = Color3.Red();
    decalMaterial.zOffset = -30;
    const decalMesh = CreateDecal('decal',
        this.sceneHelper.scene.getMeshByName('Cloth') as Mesh,
        {
          position,
          size: new Vector3(.1, .1, .1),
          normal
        });
      decalMesh.material = decalMaterial;
    ((this.sceneHelper.scene.getMeshByName('decal') as Mesh).material as PBRMaterial).metallic = 0.2;
    ((this.sceneHelper.scene.getMeshByName('decal') as Mesh).material as PBRMaterial).roughness = .2;
  }

  createDecal() {
    // (this.sceneHelper.scene.getMeshByName('Cloth') as Mesh).flipFaces(true);
    //
    // this.sceneHelper.scene.onPointerObservable.add((evtData, evtState) => {
    //   const pickResult = this.sceneHelper.scene.pick(this.sceneHelper.scene.pointerX, this.sceneHelper.scene.pointerY, (mesh) => mesh.name !== 'bounding-box');
    //   switch (evtData.type) {
    //     case PointerEventTypes.POINTERUP:
    //       console.log(pickResult);
    //       if (pickResult && pickResult.hit) {
    //         const normal = pickResult.getNormal();
    //         const position = pickResult.pickedPoint;
    //         if (normal && position) {
    //            this.createDecalMesh(position, normal);
    //         }
    //       }
    //       break;
    //   }
    // });
    this.sceneHelper.scene.onPointerDown = () => {
       const ray = this.sceneHelper.scene.createPickingRay(
        this.sceneHelper.scene.pointerX,
        this.sceneHelper.scene.pointerY,
        Matrix.Identity(),
        this.sceneHelper.scene.activeCamera
      );

      const raycastHit = this.sceneHelper.scene.pickWithRay(ray)  ;
      console.log(raycastHit);

      if (raycastHit && raycastHit.hit && raycastHit.pickedMesh && raycastHit.pickedMesh.name === "Cloth") {
        const decal = MeshBuilder.CreateDecal("decal", raycastHit.pickedMesh, {
          position: raycastHit.pickedPoint as Vector3,
          normal: raycastHit.getNormal(true) as Vector3,
          size: new Vector3(.1, .1, .1),
        });
        const material = new PBRMaterial('decal', this.sceneHelper.scene);
        material.albedoTexture = this.dynamicTexture;
        material.metallic = 0.2;
        material.roughness = 0.2;
        decal.material = material;
      }

        // decal.material =
        //   this.splatters[Math.floor(Math.random() * this.splatters.length)];
        //
        // decal.setParent(raycastHit.pickedMesh);
        //
        // raycastHit.pickedMesh.physicsImpostor.applyImpulse(
        //   ray.direction.scale(5),
        //   raycastHit.pickedPoint
        // );

    }
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

  async addRect() {
    const rectangle = this.stage.createShape('rect');
    await rectangle.setAttrs({
      width: 300,
      height: 300,
      x: 372,
      y: 600,
      fill: 'yellow'
    });
    rectangle.shape.zIndex(5);
    await this.stage.addShape( this.stage.layer, rectangle);
    await this.stage.layer.draw();
    this.dynamicTexture.update(false);

  }

}
