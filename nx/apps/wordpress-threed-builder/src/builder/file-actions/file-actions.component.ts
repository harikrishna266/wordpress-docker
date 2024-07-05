import { CommonModule } from '@angular/common';
import { Component, Input, inject } from '@angular/core';
import { WordpressService } from '../../services/wordpress.service';

@Component({
  selector: 'app-file-actions',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './file-actions.component.html',
  styleUrl: './file-actions.component.css',
})
export class FileActionsComponent {

  private wordpressService = inject(WordpressService);
  @Input() designData: any;

  saveDesign() {
    this.wordpressService
      .saveDesings({ name: 'abc', serialized_data: 'abc_serialize' })
      .subscribe();
  }
}
