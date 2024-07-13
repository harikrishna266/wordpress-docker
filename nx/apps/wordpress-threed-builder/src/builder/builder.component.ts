import { ChangeDetectorRef, Component, model, ViewEncapsulation } from '@angular/core';
import { ThreeDBuilderComponent } from './three-d-builder/three-d-builder.component';
import { SelectModelComponent } from './select-model/select-model.component';
import {   MatDialogModule } from '@angular/material/dialog';

import { CommonModule } from '@angular/common';
import { DesignRenderHelper } from './design-render.helper';
import { MatButtonModule } from '@angular/material/button';
import {MatSidenavModule} from '@angular/material/sidenav';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatIconModule } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';
import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Model } from './types/model.type';
import { Designs } from './types/design.type';
import {  MatTabsModule } from '@angular/material/tabs';
import { MatTableModule } from '@angular/material/table';
import { FlexLayoutModule } from '@angular/flex-layout';
import { DesignSelectorComponent } from './design-selector/design-selector.component';
import { LayerColorPickerComponent } from './layer-color-picker/layer-color-picker.component';
type MenuActions =  'designs' | 'layers' | 'patterns' | 'elements' | 'none';

@Component({
  selector: 'app-builder',
  standalone: true,
  imports: [
    ThreeDBuilderComponent,
    SelectModelComponent,
    MatDialogModule,
    CommonModule,
    MatButtonModule,
    MatSidenavModule,
    MatCheckboxModule,
    ReactiveFormsModule, FormsModule,
    MatTableModule, MatTabsModule,
    FlexLayoutModule,
    DesignSelectorComponent,
    MatToolbarModule, MatButtonModule, MatIconModule, MatSidenavModule, MatListModule, MatSlideToggleModule, LayerColorPickerComponent
  ],
  templateUrl: './builder.component.html',
  styleUrl: './builder.component.scss',
  encapsulation: ViewEncapsulation.None,
  providers: [
    DesignRenderHelper
  ]
})

export class BuilderComponent {
  selectedMenu: MenuActions = 'layers';
  public model: Model = {
    name: 'jersey',
    id: 'jersey',
    url: 'http://localhost:3200/tshirt.glb',
    image: ''
  };

  public  design: Designs =   {
    "id": "1",
    "name": "Design 1",
    "model_id": "1",
    "user": "1",
    imageUrl:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/DESIGN-1.png',

    layers: [
      {
        id: '1',
        name: 'layer_1',
        url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-1.txt',
        color: '#353535',
        allowPattern: true,

      },
      {
        id: '2',
        name: 'layer_2',
        url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-2.txt',
        color: '#ff0000',
        allowPattern: false,
      },
      {
        id: '3',
        name:'layer3',
        url:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-3.txt',
        color:'#ffffff',
        allowPattern: false,
      },
      {
        id: '4',
        name:'layer4',
        url:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-4.txt',
        color:'#353535',
        allowPattern: false,
      },
      {
        id:'5',
        name:'Stitches',
        url:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/stitches.txt',
        color:' yellow',
        allowPattern: false,
      }
    ],
  };
}
