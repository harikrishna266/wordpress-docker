import { Component, Injector, Renderer2 } from '@angular/core';
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
})
export class AppComponent {
  constructor(
    public renderer: Renderer2,
    injector: Injector,
  ) {
    const PopupElement = createCustomElement(BuilderComponent, {injector});
    customElements.define('builder-element', PopupElement);
  }}
