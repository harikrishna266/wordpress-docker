import {  Component, model, ViewEncapsulation } from '@angular/core';
import { ThreeDBuilderComponent } from './three-d-builder/three-d-builder.component';
import { SelectModelComponent } from './select-model/select-model.component';
import { MatDialog, MatDialogModule } from '@angular/material/dialog';
import { Model } from './types/model.type';
import { Designs } from './types/design.type';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-builder',
  standalone: true,
  imports: [
    ThreeDBuilderComponent,
    SelectModelComponent,
    MatDialogModule,
    CommonModule
  ],
  templateUrl: './builder.component.html',
  styleUrl: './builder.component.scss',
  encapsulation: ViewEncapsulation.None,
})

export class BuilderComponent {
  public  model!: Model;
  constructor(private  readonly dial: MatDialog) {
  }

  openModel() {
    this.dial.open(SelectModelComponent, {width: '80%', height: '80%'})
      .afterClosed()
      .subscribe((e: {selectedDesign: Designs
        selectedModel: Model}) => {
        this.model = e.selectedModel;
      });
  }

}
