import {
  AfterViewInit,
  Component,
  EventEmitter,
  inject,
  Input,
  OnInit,
  Output,
  ViewEncapsulation
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  HttpClientModule,
} from '@angular/common/http';
import { SceneHelper } from '@brocha-libs/builder-3d';
import { Designs } from '../types/design.type';
import { WordpressService } from '../../services/wordpress.service';
import { tap } from 'rxjs';

@Component({
  selector: 'app-design-selector',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  styleUrl: './design-selector.component.scss',
  templateUrl: './design-selector.component.html',
  encapsulation: ViewEncapsulation.None,
  providers: []
})
export class DesignSelectorComponent implements OnInit{
  @Input() sceneHelper!: SceneHelper;
  @Output() designSelected: EventEmitter<Designs> = new EventEmitter();
  private readonly wordpressService = inject(WordpressService)
  public designs:Designs[] = [];
  ngOnInit() {
    this.wordpressService.getDesigns()
      .pipe(
        tap((designs: Designs[]) => this.designs = designs)
      )
      .subscribe()
  }

  applyDesign(design: Designs) {
    this.designSelected.next(design);
  }
}
