import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WordpressService } from '../../services/wordpress.service';
import { MatStepperModule } from '@angular/material/stepper';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { Model } from '../types/model.type';
import { Designs } from '../types/design.type';
import { MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-select-model',
  standalone: true,
  imports: [CommonModule, MatStepperModule, ReactiveFormsModule, MatInputModule, MatButtonModule],
  templateUrl: './select-model.component.html',
  styleUrl: './select-model.component.css',
})
export class SelectModelComponent {
  private readonly wordpressService = inject(WordpressService);
  readonly dialogRef = inject(MatDialogRef<SelectModelComponent, {selectedDesign: Designs
    selectedModel: Model}> );

  public models: Model[] = [];
  public designs: Designs[] = [];
  public selectedModel!: Model;
  public selectedDesign!: Designs;
  constructor(private _formBuilder: FormBuilder) {
    this.wordpressService
      .getModel()
      .subscribe((models) => {
      this.models = models;
    })
  }

  selectModel(model: Model) {
    this.selectedModel = model;
    this.wordpressService.getDesignsForModel(model.id).subscribe((designs) => {
      this.designs = designs;
    })
  }

  selectDesign(design: Designs) {
    this.selectedDesign = design;
  }

  apply() {
    this.dialogRef.close({selectedDesign: this.selectedDesign, selectedModel: this.selectedModel});
  }
}
