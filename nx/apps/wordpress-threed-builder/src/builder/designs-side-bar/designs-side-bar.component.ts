import { Component, EventEmitter, Input, Output, ViewEncapsulation } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { tap } from 'rxjs';
import { SceneHelper } from '@brocha-libs/builder-3d';
type Designs = {
  ID: string;
  name: string;
  design_layer_1: string;
  design_layer_2: string;
  design_layer_3?: string;
  design_layer_4?: string;
  model_id: string;
  user: string;
};

@Component({
  selector: 'app-designs-side-bar',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  styleUrl: './designs-side-bar.component.scss',
  templateUrl: './designs-side-bar.component.html',
  encapsulation: ViewEncapsulation.None
})
export class DesignsSideBarComponent {
  @Input() sceneHelper!: SceneHelper;
  @Output() designSelected: EventEmitter<Designs> = new EventEmitter();
  designs:Designs[] = []

  constructor(private http: HttpClient) {
    http.get<Designs[]>('/wp-admin/admin-ajax.php?action=get_all_designs')
      .pipe(
        tap((res) => this.designs = res)
      )
      .subscribe()
  }

  applyDesign(design: Designs) {
    this.designSelected.next(design);
  }
}
