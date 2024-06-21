import { Designs } from '../builder/types/design.type';
import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Pattern } from '../builder/types/pattern.type';

@Injectable({
  providedIn: 'root'
})
export class WordpressService {

  private readonly http: HttpClient = inject(HttpClient);
  getDesigns() {
      return this.http.get<Designs[]>('/wp-admin/admin-ajax.php?action=get_all_designs')
  }

  getAllPatterns() {
    return this.http.get<Pattern[]>('/wp-admin/admin-ajax.php?action=get_all_patterns')
  }
}
