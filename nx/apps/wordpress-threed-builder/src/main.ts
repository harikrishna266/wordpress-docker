import { bootstrapApplication, createApplication } from '@angular/platform-browser';
import { AppComponent } from './app/app.component';
import { createCustomElement } from '@angular/elements';
 import { appConfig } from './app/app.config';


(async () => {
  const app = await createApplication(
    appConfig,
   );

  const toogleElement = createCustomElement(AppComponent, {
    injector: app.injector,
  });

  customElements.define('app-root', toogleElement);

})();
