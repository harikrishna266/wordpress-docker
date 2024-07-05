import { AfterViewInit, Component, ViewEncapsulation } from '@angular/core';
import { ThreeDBuilderComponent } from './three-d-builder/three-d-builder.component';

@Component({
  selector: 'app-builder',
  standalone: true,
  imports: [
    ThreeDBuilderComponent
  ],
  templateUrl: './builder.component.html',
  styleUrl: './builder.component.scss',
  encapsulation: ViewEncapsulation.None,
  providers: [

  ]
})

export class BuilderComponent implements AfterViewInit{


  ngAfterViewInit() {

  }

}
