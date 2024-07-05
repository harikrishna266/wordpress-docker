import { Designs } from '../builder/types/design.type';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Pattern } from '../builder/types/pattern.type';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class WordpressService {

  $wordpressURL: string = '/wp-admin/admin-ajax.php'; 

  private readonly http: HttpClient = inject(HttpClient);
  getDesigns() {
      return this.http.get<Designs[]>(`${this.$wordpressURL}?action=get_all_designs`)
  }

  getAllPatterns() {
    return this.http.get<Pattern[]>(`${this.$wordpressURL}?action=get_all_patterns`)
  }

  saveDesings(designData:any): Observable<any[]>{
    return this.http.post<any[]>(`${this.$wordpressURL}?action=save_user_design`, designData);
  }
}
