import { ApplicationConfig } from '@angular/core';
import { provideHttpClient, withInterceptors } from '@angular/common/http';
import { WordpressDevAPIInterceptor } from '../interceptor/wordpress-demo.interceptor';
import { WordpressService } from '../services/wordpress.service';
import { LayerAPIService } from '../services/layer.service';
import { provideAnimations } from '@angular/platform-browser/animations';

export const appConfig: ApplicationConfig = {

  providers: [
    WordpressService,
    LayerAPIService,
    provideHttpClient(withInterceptors([WordpressDevAPIInterceptor])),
    provideAnimations()
  ],
};
