import { Component, ViewEncapsulation } from '@angular/core';
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
export class AppComponent  {
}
