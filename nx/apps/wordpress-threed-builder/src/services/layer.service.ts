import { inject, Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class LayerService {
  private http: HttpClient = inject(HttpClient);

  downloadTemplate(template: string) {
    const headers = new HttpHeaders({
      'Accept': 'text/plain'
    });
    return this.http.get(template, { headers, responseType: 'text' });
  }

}
