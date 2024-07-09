import { Designs } from '../builder/types/design.type';
import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Pattern } from '../builder/types/pattern.type';
import { Observable } from 'rxjs';
import { Model } from '../builder/types/model.type';

@Injectable({
  providedIn: 'root'
})
export class WordpressService {

  $wordpressURL = '/wp-admin/admin-ajax.php';

  private readonly http: HttpClient = inject(HttpClient);
  getDesigns() {
      return this.http.get<Designs[]>(`${this.$wordpressURL}?action=get_all_designs`)
  }

  getDesignsForModel(id: Model["id"]) {
    return this.http.get<Designs[]>(`${this.$wordpressURL}?action=get_all_designs&modelId=${id}`)
  }

  getAllPatterns() {
    return this.http.get<Pattern[]>(`${this.$wordpressURL}?action=get_all_patterns`)
  }

  saveDesings(designData:any): Observable<any[]> {
    return this.http.post<any[]>(`${this.$wordpressURL}?action=save_user_design`, designData);
  }

  getModel() {
    return this.http.get<Model[]>(`${this.$wordpressURL}?action=get_models`)
  }
}
