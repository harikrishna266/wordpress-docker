import { CommonModule } from '@angular/common';
import {
  ChangeDetectionStrategy,
  Component,
  Input,
  inject,
} from '@angular/core';
import { WordpressService } from '../../services/wordpress.service';
import { tap } from 'rxjs';

type UserActions = 'save' | 'cancel';

@Component({
  selector: 'app-file-actions',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './file-actions.component.html',
  styleUrl: './file-actions.component.css',
  // changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FileActionsComponent {
  constructor() {}

  private wordpressService = inject(WordpressService);
  @Input() designData: any;

  saveDesign() {
    this.wordpressService
      .saveDesings({ name: 'abc', serialized_data: 'abc_serialize' })
      .subscribe();
  }
}
