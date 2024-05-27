import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class WordpressService {
  constructor(private http: HttpClient) { }

  getAllDesigns() {
    return this.http.get('admin-ajax.php?action=get_all_designs');
  }

}
