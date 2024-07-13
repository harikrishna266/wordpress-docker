import { Component, ViewEncapsulation } from '@angular/core';
import { BuilderComponent } from '../builder/builder.component';
import { CommonModule } from '@angular/common';

@Component({
  standalone: true,
  imports: [
    BuilderComponent,
    CommonModule,
 ],
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss',
  encapsulation: ViewEncapsulation.ShadowDom
})
export class AppComponent  {
}
