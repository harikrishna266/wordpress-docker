import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SceneHelper } from '@brocha-libs/builder-3d';

@Component({
  selector: 'app-layer-patterns',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layer-patterns.component.html',
  styleUrl: './layer-patterns.component.css',
})
export class LayerPatternsComponent {
  @Input() sceneHelper!: SceneHelper;
}
