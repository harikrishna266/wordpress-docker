import { HttpInterceptorFn, HttpResponse } from '@angular/common/http';
import { HttpRequest, HttpHandlerFn } from '@angular/common/http';
import { environment } from '../environments/environment';
import { of } from 'rxjs';
import { sampleData } from './mock-data';

export const WordpressDevAPIInterceptor: HttpInterceptorFn = (req: HttpRequest<any>, next: HttpHandlerFn) => {
  // @ts-ignore
  if (environment.name === 'development' && sampleData[req.url]) {
    const url:  any = req.url;
    const mockResponse = new HttpResponse({
      status: 200,
      // @ts-ignore
      body: sampleData[req.url as any]
    });
    return of(mockResponse);
  }
  return next(req);
}





