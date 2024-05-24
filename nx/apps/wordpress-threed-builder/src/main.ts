import { createApplication } from '@angular/platform-browser';
import { AppComponent } from './app/app.component';
import { createCustomElement } from '@angular/elements';


(async () => {
  const app = await createApplication({
    providers: [],
  });

  const toogleElement = createCustomElement(AppComponent, {
    injector: app.injector,
  });

  customElements.define('app-root', toogleElement);

})();
