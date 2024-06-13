import { ApplicationConfig } from '@angular/core';
import { provideHttpClient, withInterceptors } from '@angular/common/http';
import { WordpressDevAPIInterceptor } from '../interceptor/wordpress-demo.interceptor';
import { WordpressService } from '../services/wordpress.service';

export const appConfig: ApplicationConfig = {
  providers: [
    WordpressService,
    provideHttpClient(withInterceptors([WordpressDevAPIInterceptor])),
  ],
};
