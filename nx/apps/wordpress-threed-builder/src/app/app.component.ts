import { AfterViewInit, Component, Injector, Input, Renderer2, ViewEncapsulation } from '@angular/core';
import { createCustomElement } from '@angular/elements';
import { BuilderComponent } from '../builder/builder.component';

@Component({
  standalone: true,
  imports: [
    BuilderComponent
  ],
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss',
  encapsulation: ViewEncapsulation.ShadowDom
})
export class AppComponent implements AfterViewInit{

  @Input() model = '1';

  constructor(
    public renderer: Renderer2,
  ) { }


  ngAfterViewInit() {
    this.loadExternalStyles();
  }

  loadExternalStyles() {
    fetch('https://fictivecodes.com/wordpress-scripts/styles.css')
      .then(function(response) {
        return response.text();
      })
      .then((cssContent: any) => {
        const styleElement = this.renderer.createElement('style');
        this.renderer.appendChild(styleElement, this.renderer.createText(cssContent));
        this.renderer.appendChild(this.renderer.selectRootElement('app-root').shadowRoot, styleElement);
      })
  }
}





